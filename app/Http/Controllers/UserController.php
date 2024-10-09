<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('pages.user.index', $data);
    }
}
