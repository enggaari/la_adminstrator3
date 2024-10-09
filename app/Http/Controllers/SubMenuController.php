<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SubMenuController extends Controller
{
    function index()
    {
        $data['title'] = 'Sub Menu';

        // data
        $subMenu = DB::table('sub_menus')
            ->join('menus', 'sub_menus.idMenu', '=', 'menus.id') // Join tabel menus
            ->select(
                'sub_menus.id',
                'sub_menus.subMenu',
                'menus.menu as menuName', // Ambil nama menu
                'sub_menus.url',
                'sub_menus.icon',
                'sub_menus.status',
                'sub_menus.info',
                'sub_menus.alias'
            )
            ->get();

        $data['subMenu'] = SubMenu::with('menu')->get();
        // dd($data['subMenu']);

        $data['menus'] = Menu::all();
        return view('pages.dev.subMenu', $data);
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
            'subMenu' => 'required|string|max:500',
            'url' => 'required|string',
            'icon' => 'required|string',
            'info' => 'nullable|string|max:500',
            'alias' => 'string|max:500',
            'status' => 'boolean',
        ]);


        // dd($request);
        // return response()->json($request);

        // Simpan ke database
        $SubMenu = SubMenu::create([
            'idMenu' => $request->idMenu,
            'subMenu' => $request->subMenu,
            'url' => $request->url,
            'icon' => $request->icon,
            'status' => $request->status,
            'info' => $request->info,
            'alias' => $request->alias,
        ]);

        //redirect to index
        return redirect('/subMenu')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $submenu = SubMenu::find($decryptedId);

        // dd($submenu);
        return response()->json([
            'success' => true,
            'data' => $submenu
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'idMenuEdit' => 'required|exists:menus,id', // Memastikan menu yang dipilih ada
            'subMenuEdit' => 'required|string|max:255',
            'urlEdit' => 'nullable|string|max:255',
            'iconEdit' => 'nullable|string|max:100',
            'infoEdit' => 'nullable|string|max:500',
            'aliasEdit' => 'nullable|string|max:500',
            'statusEdit' => 'boolean', // Validasi checkbox status
        ]);

        // return response()->json($request);
        // die();
        // Cari submenu berdasarkan ID
        $submenu = SubMenu::find($id);

        // Jika submenu tidak ditemukan
        if (!$submenu) {
            return response()->json([
                'success' => false,
                'message' => 'Submenu not found.'
            ], 404);
        }

        // Update data submenu
        $submenu->idMenu = $request->idMenuEdit;
        $submenu->subMenu = $request->subMenuEdit;
        $submenu->url = $request->urlEdit;
        $submenu->icon = $request->iconEdit;
        $submenu->info = $request->infoEdit;
        $submenu->alias = $request->aliasEdit;
        $submenu->status = $request->statusEdit; // Set checkbox status
        $submenu->save();

        // Ambil data menu yang berelasi (join)
        $menu = Menu::find($submenu->idMenu);

        // Dapatkan nomor iterasi (untuk urutan)
        $iteration = SubMenu::where('id', '<=', $submenu->id)->count();

        // Bangun HTML baris table yang baru sesuai dengan format Anda
        $updatedRow = '
            <td class="align-middle product white-space-nowrap py-0">' . $iteration . '</td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $submenu->subMenu . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $menu->menu . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:200px;">
                <h6 class="fw-semi-bold mb-0">' . $submenu->url . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:100px;">
                <h6 class="fw-semi-bold mb-0">' . $submenu->icon . '</h6>
            </td>
            <td class="align-middle product white-space-nowrap" style="min-width:100px;">
                <h6 class="fw-semi-bold mb-0">' . ($submenu->status ? 'Aktif' : 'Tidak Aktif') . '</h6>
            </td>
            <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                <h6 class="mb-0 text-900">' . $submenu->info . '</h6>
            </td>
            <td class="align-middle customer white-space-nowrap" style="min-width:200px;">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0 text-900">' . $submenu->alias . '</h6>
                </div>
            </td>
            <td class="align-middle white-space-nowrap text-end pe-0">
                <button data-id="' . Crypt::encryptString($submenu->id) . '" class="btn btn-sm btn-phoenix-primary me-1 fs--2 edit-data-btn">
                    <span class="fas fa-edit"></span>
                </button>
                <form id="delete-data-form-' . $submenu->id . '" action="/deleteMenu/' . Crypt::encryptString($submenu->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="btn btn-sm btn-phoenix-danger fs--2" onclick="confirmDelete(' . $submenu->id . ')">
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
            'editId' => $submenu->id
        ]);
    }

    public function destroy($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            // Mencari menu berdasarkan ID dan menghapusnya
            $submenu = SubMenu::findOrFail($decryptedId);
            $submenu->delete();

            return redirect('/subMenu')->with(['success' => 'Data Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return redirect('/subMenu')->with(['error' => 'Data Gagal Dihapus, Error: ' . $e->getMessage()]);
        }
    }
}
