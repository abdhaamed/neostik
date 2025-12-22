<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // pilihan login
    public function choice()
    {
        return view('auth.login-choice');
    }

    // form admin
    public function adminForm()
    {
        return view('auth.admin-login');
    }

    // form driver
    public function driverForm()
    {
        return view('auth.driver-login');
    }

    // proses login ADMIN
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'email' => 'Akses admin ditolak.',
        ]);
    }

    // proses login DRIVER
    public function driverLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'driver') {
                $request->session()->regenerate();
                return redirect()->route('driver.dashboard');
            }

            Auth::logout();
        }

        return back()->withErrors([
            'email' => 'Akses driver ditolak.',
        ]);
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
