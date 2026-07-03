<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Utama otomatis lempar ke login
Route::get('/', function () {
    return redirect('/login');
});

// Jalur Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Jalur Daftar Akun (Register)
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Halaman Dashboard Utama (Hanya bisa dibuka jika sudah login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Jalur Keluar
Route::get('/logout', function () {
    \Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});