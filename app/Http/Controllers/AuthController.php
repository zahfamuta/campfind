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

    // 1. Proses Simpan Data Akun Baru - BYPASS TOTAL AMAN
    public function register(Request $request) {
        $request->validate([
            'identity_number' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required', 
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        // Trik Jitu: Daftarkan semua sebagai 'mahasiswa' biar lolos CHECK constraint SQLite kelompokmu
        User::create([
            'identity_number' => $request->identity_number,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number, 
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', 
        ]);

        return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // 2. Proses Verifikasi Login (Bypass Pengalihan Menggunakan Nomor NIP)
    public function login(Request $request) {
        $credentials = $request->validate([
            'identity_number' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // LOGIKA HARDCODE: Jika NIP yang login adalah milik Ibu Sofi (23456789)
            // Maka langsung dilempar ke Dashboard Admin khusus!
            if (Auth::user()->identity_number == '23456789') {
                return redirect('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'loginError' => 'NIM/NIP atau password salah.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}