<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'identity_number' => 'required|numeric|digits_between:9,18|unique:users,identity_number',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'identity_number.required' => 'NIM/NIP wajib diisi.',
            'identity_number.numeric' => 'NIM/NIP harus berupa angka.',
            'identity_number.digits_between' => 'NIM/NIP harus berukuran 9 hingga 18 digit.',
            'identity_number.unique' => 'NIM/NIP sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Menyimpan data user baru ke database secara permanen
        User::create([
            'name' => $request->name,
            'identity_number' => $request->identity_number,
            'email' => $request->email,
            'role' => 'mahasiswa', 
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}