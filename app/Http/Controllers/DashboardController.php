<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class DashboardController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
       // Lakukan pengecekan apakah pengguna sudah login
       $this->middleware(function ($request, $next) {
        if (session('id_user') == null) {
            // Jika pengguna tidak login, alihkan ke halaman login
            return redirect('/');
        }

        return $next($request);
    });
    }
    public function index()
    {
        // dd(session('id_user'));
        // dd(Auth::check());

        // if (session('id_role') == null) {
        //     return redirect('/');
        // }
        return view('dashboard');
    }
}
