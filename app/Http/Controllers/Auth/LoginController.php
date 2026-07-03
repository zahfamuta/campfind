<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'identity_number' => $request->identity_number,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'puslia') {
                return redirect()->intended('/puslia/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'identity_number' => 'NIM/NIP atau password salah.',
        ])->onlyInput('identity_number');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}