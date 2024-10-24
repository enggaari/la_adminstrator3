<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\SubMenu;
use App\Models\UserAccessMenu;
use App\Models\UserAccessSubmenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//return type redirectResponse
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class DeveloperController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['menuSidebar'] = Menu::whereHas('userAccessMenus', function ($query) {
            $query->where('roleId', Auth::user()->role);
        })->get();

        return view('pages.dev.index', $data);
    }

    public function role()
    {
        $data['title'] = 'Role Access';
        $data['menuSidebar'] = Menu::whereHas('userAccessMenus', function ($query) {
            $query->where('roleId', Auth::user()->role);
        })->get();

        // data
        $data['role'] = Role::all();
        return view('pages.dev.role', $data);
    }

    public function useraccessmenu(string $id): View
    {
        $data['title'] = 'Role Access';
        $data['menuSidebar'] = Menu::whereHas('userAccessMenus', function ($query) {
            $query->where('roleId', Auth::user()->role);
        })->get();

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
                );
                return response()->json(['success' => true, 'message' => 'Akses ditambahkan']);
            } else {
                // Jika checkbox tidak dicentang, hapus data dari tabel user_access_menu
                UserAccessMenu::where('roleId', $roleId)->where('menuId', $menuId)->delete();
                UserAccessSubmenu::where('roleId', $roleId)->where('menuId', $menuId)->delete();
                return response()->json(['success' => true, 'message' => 'Akses terhapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function useraccesssubmenu(string $roleId, $menuId): View
    {
        $data['title'] = 'Role Access';
        $data['menuSidebar'] = Menu::whereHas('userAccessMenus', function ($query) {
            $query->where('roleId', Auth::user()->role);
        })->get();


        // Mendekripsi ID
        try {
            $data['role'] = Crypt::decryptString($roleId);
            $data['menuSelected'] = Menu::find(Crypt::decryptString($menuId));
            $data['menuId'] = Crypt::decryptString($menuId);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'ID tidak valid!']);
        }

        // data
        $data['submenu'] = SubMenu::join('menus', 'menus.id', '=', 'sub_menus.idMenu')
            ->where('sub_menus.idMenu', $data['menuId'])
            ->select('sub_menus.id as submenuId', 'sub_menus.*', 'menus.*')
            ->get();
        // ->toArray();

        $data['accessSubmenus'] = UserAccessSubmenu::where('roleId',  $data['role'])->where('menuId', $data['menuId'])->pluck('submenuId')->toArray();
        // echo json_encode($data['accessSubmenus']);
        // die();

        return view('pages.dev.userAccessSubmenu', $data);
    }

    function updateaccesssubmenu(Request $request)
    {
        try {
            $submenuId = Crypt::decryptString($request->submenuId);
            $menuId = $request->menuId;
            $roleId = $request->roleId;
            $isChecked = filter_var($request->isChecked, FILTER_VALIDATE_BOOLEAN);

            if ($isChecked) {
                // Jika checkbox dicentang, tambahkan data ke tabel user_access_menu
                UserAccessSubmenu::updateOrCreate(
                    ['roleId' => $roleId, 'menuId' => $menuId, 'submenuId' => $submenuId],
                );
                return response()->json(['success' => true, 'message' => 'Akses ditambahkan']);
            } else {
                // Jika checkbox tidak dicentang, hapus data dari tabel user_access_menu
                UserAccessSubmenu::where('roleId', $roleId)->where('menuId', $menuId)->where('submenuId', $submenuId)->delete();
                return response()->json(['success' => true, 'message' => 'Akses terhapus']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
