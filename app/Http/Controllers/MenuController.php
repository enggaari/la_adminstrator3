<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MenuController extends Controller
{
    function index()
    {
        $data['title'] = 'Menu';

        // data
        $data['menu'] = Menu::all();
        return view('pages.dev.menu', $data);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu' => 'required|string|max:255|unique:menus,menu',
            'info' => 'nullable|string|max:500',
            'alias' => 'string|max:500',
        ]);

        // Simpan menu ke database
        $menu = Menu::create([
            'menu' => $request->menu,
            'info' => $request->info,
            'alias' => $request->alias,
        ]);

        //redirect to index
        return redirect('/menu')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $role = Menu::find($decryptedId);
        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'menuEdit' => 'required|string|max:255',
            'infoEdit' => 'nullable|string|max:500',
            'aliasEdit' => 'string|max:500',
        ]);

        // Cari role berdasarkan ID
        $menu = Menu::find($id);

        // Jika role tidak ditemukan
        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ], 404);
            // return redirect('/role')->with(['error' => 'Periksa input']);
        }

        // Update data role
        $menu->menu = $request->menuEdit;
        $menu->info = $request->infoEdit;
        $menu->alias = $request->aliasEdit;
        $menu->save();

        // Dapatkan nomor iterasi jika perluEdit
        $iteration = Menu::where('id', '<=', $menu->id)->count();

        // Bangun HTML baris table yang baru
        $updatedRow = '
                    <td class="align-middle product white-space-nowrap py-0">' . $iteration . '</td>
                    <td class="align-middle product white-space-nowrap" style="min-width:360px;">
                        <h6 class="fw-semi-bold mb-0">' . $request->menuEdit . '</h6>
                    </td>
                    <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 text-900">' . $request->infoEdit . '</h6>
                        </div>
                    </td>
                    <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0 text-900">' . $request->aliasEdit . '</h6>
                        </div>
                    </td>
                    <td class="align-middle white-space-nowrap text-end pe-0">
                        <button data-id="' . Crypt::encryptString($menu->id)  . '" class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-data-btn">
                            <span class="fas fa-edit"></span>
                        </button>
                        <form id="delete-data-form-' . $menu->id . '" action="/deleteMenu/' . Crypt::encryptString($menu->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-sm btn-phoenix-danger fs--2" onclick="confirmDelete(' . $menu->id . ')">
                                <span class="fas fa-trash"></span>
                            </button>
                        </form>
                    </td>
                ';

        // Kembalikan data yang baru
        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully!',
            'updatedRow' => $updatedRow,
            'data' => [
                'id' => $menu->id,
                'menuEdit' => $menu->menuEdit,
                'infoEdit' => $menu->infoEdit,
                'aliasEdit' => $menu->aliasEdit,
                'iteration' => $iteration // Urutan dalam table
            ],
            'editId' => $menu->id
        ]);
    }

    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            // Mencari menu berdasarkan ID dan menghapusnya
            $menu = Menu::findOrFail($decryptedId);
            $menu->delete();

            return redirect('/menu')->with(['success' => 'Data Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return redirect('/menu')->with(['error' => 'Data Gagal Dihapus, Error: ' . $e->getMessage()]);
        }
    }
}
