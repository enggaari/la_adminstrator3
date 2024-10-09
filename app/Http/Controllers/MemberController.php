<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('pages.member.index', $data);
    }
}
