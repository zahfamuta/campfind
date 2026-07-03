<?php

use Illuminate\Support\Facades\Route;

// Halaman Utama/Welcome
Route::get('/', function () {
    return view('welcome');
});

// Alamat Login CampFind
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
// Proses kirim data login
Route::post('/login', [AuthController::class, 'login']);

// Halaman dashboard setelah sukses masuk
Route::get('/dashboard', function () {
    return view('dashboard'); // Memanggil file dashboard.blade.php milik kelompokmu
})->middleware('auth');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
