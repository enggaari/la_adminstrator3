<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
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
}
