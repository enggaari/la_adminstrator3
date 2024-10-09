<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        $data['title'] = 'Login';
        return view('pages.auth.index', $data);
    }

    public function register()
    {
        $data['title'] = 'Login';
        return view('pages.auth.register', $data);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        $nama_lengkap = $request->input('nama_lengkap');
        $email        = $request->input('email');
        $password     = $request->input('password');

        $user = User::create([
            'name'      => $nama_lengkap,
            'email'     => $email,
            'password'  => Hash::make($password)
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register Berhasil!'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register Gagal!'
            ], 400);
        }
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infoLogin)) {

            // if (Auth::user()->role == 'developer') {
            //     return redirect('/admin/developer');
            // } else if (Auth::user()->role == 'member') {
            //     return redirect('/admin/member');
            // }
            if (Auth::user()->role == 'developer') {
                return redirect('dashboardDev');
            } else if (Auth::user()->role == 'administrator') {
                return redirect('dashboardAdmin');
            } else if (Auth::user()->role == 'member') {
                return redirect('dashboardMember');
            } else {
                return redirect('/dashboardIndi');
            }
        } else {
            return redirect('')->withErrors('pastikan username atau password benar')->withInput();
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('');
    }

    function block()
    {
        $data['title'] = 'Login';
        return view('pages.auth.block', $data);
    }
}
