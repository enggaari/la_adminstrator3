<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\UserAccessMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//return type redirectResponse
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class DeveloperController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('pages.dev.index', $data);
    }

    public function role()
    {
        $data['title'] = 'Role Access';

        // data
        $data['role'] = Role::all();
        return view('pages.dev.role', $data);
    }

    public function useraccessmenu(string $id): View
    {
        $data['title'] = 'Role Access';

        // Mendekripsi ID
        try {
            $decryptedId = Crypt::decryptString($id);
            $data['role'] = Role::find($decryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'ID tidak valid!']);
        }


        // data
        $data['menu'] = Menu::all();
        $roleId = $data['role']['role'];
        $data['accessMenus'] = UserAccessMenu::where('roleId', $roleId)->pluck('menuId')->toArray();

        return view('pages.dev.userAccessMenu', $data);
    }

    function updateaccessmenu(Request $request)
    {
        try {
            $menuId = Crypt::decryptString($request->menuId); // Decrypt menu ID
            $roleId = $request->roleId; // Decrypt role ID
            $isChecked = filter_var($request->isChecked, FILTER_VALIDATE_BOOLEAN);

            if ($isChecked) {
                // Jika checkbox dicentang, tambahkan data ke tabel user_access_menu
                UserAccessMenu::updateOrCreate(
                    ['roleId' => $roleId, 'menuId' => $menuId],
                    ['roleId' => $roleId, 'menuId' => $menuId]
                );
                return response()->json(['success' => true, 'message' => 'Akses ditambahkan']);
            } else {
                // Jika checkbox tidak dicentang, hapus data dari tabel user_access_menu
                UserAccessMenu::where('roleId', $roleId)->where('menuId', $menuId)->delete();
                return response()->json(['success' => true, 'message' => 'Akses terhapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
