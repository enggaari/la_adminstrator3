<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        // $data = Auth()->user()->role;

        // dd($data);

        // ambil data role dari user dan ammbil data role dari route
        if (Auth()->user()->role == $role) {
            // return response()->json($role);
            return $next($request);
            // return redirect('users');
        }

        // jika role tidak sesuai maka lempar ke admin
        return redirect('block');
    }
}
