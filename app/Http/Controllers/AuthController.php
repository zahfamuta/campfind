<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    // Proses Simpan Data Akun Baru ke Database (Sudah dengan phone_number)
    public function register(Request $request) {
        $request->validate([
            'identity_number' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required', 
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'identity_number' => $request->identity_number,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number, 
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Proses Verifikasi Login (Fungsi yang tadi sempat hilang)
    public function login(Request $request) {
        $credentials = $request->validate([
            'identity_number' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'loginError' => 'NIM/NIP atau password salah.',
        ]);
    }
}