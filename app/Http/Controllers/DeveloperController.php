<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

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
        $data['title'] = 'User Access Menu';

        // Mendekripsi ID
        // try {
        //     $decryptedId = Crypt::decryptString($id);
        // } catch (\Exception $e) {
        //     return redirect()->back()->with(['error' => 'ID tidak valid!']);
        // }

        // data
        $data['role'] = Role::all();

        $data['menu'] = Menu::all();
        return view('pages.dev.menu', $data);
    }
}
