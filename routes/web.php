<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 1. Halaman Utama otomatis dilempar ke login
Route::get('/', function () {
    return redirect('/login');
});

// 2. Jalur Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 3. Jalur Daftar Akun (Register)
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// 4. Dashboard Utama: Menampilkan daftar laporan Lost & Found serta Fitur Cari & Filter (Sesuai Flowchart)
Route::get('/dashboard', function (Request $request) {
    $query = Item::query();

    // Logika Filter Cari Barang berdasarkan nama atau lokasi
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('location', 'like', '%' . $request->search . '%');
        });
    }

    // Logika Filter Kategori Barang
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // Ambil data terbaru
    $items = $query->latest()->get(); 
    
    return view('dashboard', compact('items'));
})->middleware('auth');

// 5. Membuka Halaman Form Lapor Temuan
Route::get('/lapor-temuan', function () {
    return view('lapor');
})->middleware('auth');

// Memproses Simpan Data Form ke Database (Disesuaikan dengan category_id)
Route::post('/lapor-temuan', function (Request $request) {
    $request->validate([
        'item_name' => 'required',
        'category' => 'required', // Ini dari form HTML
        'location' => 'required',
        'photo' => 'nullable|image|max:2048'
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('items_photos', 'public');
    }

    // Mengonversi teks kategori dari HTML menjadi angka ID sesuai database kelompokmu
    $categoryId = 1; // Default jika 'Elektronik'
    if ($request->category == 'Dokumen/Dompet') {
        $categoryId = 2;
    } elseif ($request->category == 'Pakaian/Aksesoris') {
        $categoryId = 3;
    } elseif ($request->category == 'Lainnya') {
        $categoryId = 4;
    }

    Item::create([
        'name' => $request->item_name, // Mengisi kolom 'name' di database dengan input 'item_name' dari form
        'category_id' => $categoryId,
        'location' => $request->location,
        'type' => 'found',
        'photo' => $photoPath,
        'status' => 'Tunggu Konfirmasi Pemilik',
        'user_id' => Auth::id()
    ]);

    return redirect('/dashboard')->with('success', 'Laporan berhasil disimpan!');
})->middleware('auth');

// 7. Jalur Keluar (Logout)
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});