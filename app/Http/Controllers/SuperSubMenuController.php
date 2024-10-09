<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\SuperSubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SuperSubMenuController extends Controller
{
    function index()
    {
        $data['title'] = 'Super Sub Menu';

        // data
        $data['superSubMenu'] = (new SuperSubMenu())->superSubMenu();

        // dd($data['superSubMenu']);
        $data['menus'] = Menu::all();
        $data['subMenu'] = SubMenu::all();

        return view('pages.dev.superSubMenu', $data);
    }

    public function store(Request $request)
    {
        // Ubah nilai checkbox menjadi true/false
        $request->merge([
            'status' => $request->has('status') ? true : false,
        ]);

        // Validasi input
        $request->validate([
            'idMenu' => 'required|string',
            'idSubMenu' => 'required|string',
            'superSubMenu' => 'required|string',
            'url' => 'required|string',
            'info' => 'nullable|string|max:500',
            'alias' => 'string|max:500',
            'status' => 'boolean',
        ]);


        // dd($request);
        // return response()->json($request);

        // Simpan ke database
        $SuperSubMenu = SuperSubMenu::create([
            'idMenu' => $request->idMenu,
            'idSubMenu' => $request->idSubMenu,
            'super_sub_menus' => $request->superSubMenu,
            'url' => $request->url,
            'status' => $request->status,
            'info' => $request->info,
            'alias' => $request->alias,
        ]);

        //redirect to index
        return redirect('/superSubMenu')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);

        $supersubmenu = SuperSubMenu::find($decryptedId);
        return response()->json([
            'success' => true,
            'data' => $supersubmenu
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'idMenuEdit' => 'required|string',
            'idSubMenuEdit' => 'required|string',
            'superSubMenuEdit' => 'required|string',
            'urlEdit' => 'required|string',
            'infoEdit' => 'nullable|string|max:500',
            'aliasEdit' => 'string|max:500',
            'statusEdit' => 'boolean',
        ]);

        // Cari role berdasarkan ID
        $superSubMenu = SuperSubMenu::with(['menu', 'subMenu']) // Pastikan relasi di model
            ->find($id);

        // return response()->json($superSubMenu);
        // die();

        // Jika role tidak ditemukan
        if (!$superSubMenu) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.'
            ], 404);
            // return redirect('/role')->with(['error' => 'Periksa input']);
        }

        // Update data role
        $superSubMenu->idMenu =  $request->idMenuEdit;
        $superSubMenu->idSubMenu =  $request->idSubMenuEdit;
        $superSubMenu->super_sub_menus =  $request->superSubMenuEdit;
        $superSubMenu->url =  $request->urlEdit;
        $superSubMenu->info =  $request->infoEdit;
        $superSubMenu->alias =  $request->aliasEdit;
        $superSubMenu->status =  $request->statusEdit;
        $superSubMenu->save();

        // Mendapatkan data dari relasi yang baru diperbarui
        $menu = $superSubMenu->menu->menu;
        $subMenu = $superSubMenu->subMenu->subMenu;

        // return response()->json($superSubMenu);
        // die();

        // Dapatkan nomor iterasi jika perluEdit
        $iteration = SuperSubMenu::where('id', '<=', $superSubMenu->id)->count();

        // Bangun HTML baris table yang baru
        $updatedRow = '
            <td class="align-middle product white-space-nowrap py-0">' . $iteration . '</td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $superSubMenu->super_sub_menus . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $menu . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $subMenu . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $superSubMenu->url . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:100px;">
                <h6 class="fw-semi-bold mb-0">' . ($superSubMenu->status ? 'Aktif' : 'Tidak Aktif') . '</h6>
            </td>
            <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                <h6 class="mb-0 text-900">' . $superSubMenu->info . '</h6>
            </td>
            <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0 text-900">' . $superSubMenu->alias . '</h6>
                </div>
            </td>
            <td class="align-middle white-space-nowrap text-end pe-0">
                <button data-id="' . Crypt::encryptString($superSubMenu->id) . '" class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-data-btn">
                    <span class="fas fa-edit"></span>
                </button>
                <form id="delete-data-form-' . $superSubMenu->id . '" action="/deleteSuperSubMenu/' . Crypt::encryptString($superSubMenu->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2" onclick="confirmDelete(' . $superSubMenu->id . ')">
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
            'editId' => $superSubMenu->id
        ]);
    }

    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            // Mencari menu berdasarkan ID dan menghapusnya
            $submenu = SuperSubMenu::findOrFail($decryptedId);
            $submenu->delete();

            return redirect('/superSubMenu')->with(['success' => 'Data Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return redirect('/superSubMenu')->with(['error' => 'Data Gagal Dihapus, Error: ' . $e->getMessage()]);
        }
    }
}
