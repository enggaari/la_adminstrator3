<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index()
    {
        // echo 'home';
        // echo '<h1>name : ' . Auth::user()->name . '</h1>';
        // echo '<a href="/logout" class="btn btn-primary">Logout</a>';
        $data['title'] = 'Dashboard';
        $data['menuSidebar'] = Menu::whereHas('userAccessMenus', function ($query) {
            $query->where('roleId', Auth::user()->role);
        })->get();
        // echo 'admin';
        return view('pages.admin.index', $data);
    }

    function developer()
    {
        echo 'developer';
        echo '<h1>name : ' . Auth::user()->name . '</h1>';
        echo '<a href="/logout" class="btn btn-primary">Logout</a>';
    }

    function member()
    {
        echo 'member';
        echo '<h1>name : ' . Auth::user()->name . '</h1>';
        echo '<a href="/logout" class="btn btn-primary">Logout</a>';
    }
}
