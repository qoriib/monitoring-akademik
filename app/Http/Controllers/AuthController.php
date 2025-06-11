<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    /**
     * Logout dan redirect ke login.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
