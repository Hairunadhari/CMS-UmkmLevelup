<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

class SuperLoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('pages-umkm.auth-login');   
    }


public function submitLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    try {
        if ($this->guard()->attempt($credentials)) {
            $request->session()->regenerate();

            // Simpan URL sebelumnya jika ada
            $previousUrl = Session::get('previousUrl');
            // dd($previousUrl);

            // Lakukan pengecekan role pengguna
            if ($this->guard()->user()->id_role == 2 || $this->guard()->user()->id_role == 3 || $this->guard()->user()->id_role == 4) {
                // Simpan data pengguna ke dalam session
                $request->session()->put('name', $this->guard()->user()->name);
                $request->session()->put('id_user', $this->guard()->user()->id);
                $request->session()->put('id_role', $this->guard()->user()->id_role);

                // Redirect sesuai role pengguna
                if ($this->guard()->user()->id_role == 2) {
                    if (!$previousUrl) {
                        return redirect()->route('/dashboard');
                    }else {
                        return redirect($previousUrl);
                    }
                } elseif ($this->guard()->user()->id_role == 4 || $this->guard()->user()->id_role == 3) {
                    if (!$previousUrl) {
                        return redirect()->route('/kuesioner-unverif');
                    } else {
                        return redirect($previousUrl);
                    }
                    
                } else {
                    return redirect()->route('list-materi');
                }
            } else {
                // Jika role tidak valid, redirect ke halaman login
                return redirect('login');
            }
        }
    } catch (\Throwable $th) {
        // dd($th);
        $request->session()->flash('alert', [
            'type' => 'error',
            'message' => 'Silahkan periksa kembali email dan password Anda.',
        ]);
    }
    
    // Jika login gagal, redirect ke halaman login
    return redirect('login');
}

    
    public function logout(Request $request)
    {
         // Simpan URL saat ini sebelum logout
         
         Session::flush();
         Session::put('previousUrl', url()->previous());
        // $this->guard()->logout();
        return redirect('login');

    }
}
