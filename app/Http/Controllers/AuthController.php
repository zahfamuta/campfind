<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }
}