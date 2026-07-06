<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

function pastikanKategoriTersedia() {
    $kategoriMaster = [
        ['id' => 1, 'category_name' => 'Elektronik'],
        ['id' => 2, 'category_name' => 'Dokumen / Dompet'],
        ['id' => 3, 'category_name' => 'Pakaian / Aksesoris'],
        ['id' => 4, 'category_name' => 'Lainnya'],
    ];

    foreach ($kategoriMaster as $kat) {
        Illuminate\Support\Facades\DB::table('categories')->updateOrInsert(
            ['id' => $kat['id']],
            ['category_name' => $kat['category_name'], 'created_at' => now(), 'updated_at' => now()]
        );
    }
}

// 4. Dashboard Utama: Menampilkan daftar laporan dengan Fitur Cari & Filter
Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    // Jalankan pengaman otomatis mengisi kategori
    pastikanKategoriTersedia();

    // Mengambil query dasar untuk fitur pencarian
    $queryTemuan = Item::where('type', 'found');
    $queryKehilangan = Item::where('type', 'lost');

    // Jika user mengetik sesuatu di kotak pencarian
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $queryTemuan->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%');
        });
        $queryKehilangan->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%');
        });
    }

    // Jika user memilih kategori tertentu
    if ($request->has('category') && $request->category != '') {
        $category = $request->category;
        $queryTemuan->where('category_id', $category);
        $queryKehilangan->where('category_id', $category);
    }

    // Eksekusi ambil data terakhir
    $barangTemuan = $queryTemuan->latest()->get();
    $barangKehilangan = $queryKehilangan->latest()->get();

    return view('dashboard', compact('barangTemuan', 'barangKehilangan'));
})->middleware('auth');
// 5. Membuka Halaman Form Lapor Temuan
Route::get('/lapor-temuan', function () {
    // Jalankan pengaman otomatis mengisi kategori
    pastikanKategoriTersedia();
    return view('lapor');
})->middleware('auth');

// 6. Memproses Simpan Data Form ke Kolom Asli Database Kelompok
Route::post('/lapor-temuan', function (Request $request) {
    $request->validate([
        'item_name' => 'required',
        'category' => 'required',
        'location' => 'required',
        'photo' => 'nullable|image|max:2048'
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('items_photos', 'public');
    }

    // Mengonversi pilihan kategori menjadi ID angka
    $categoryId = 1; 
    if ($request->category == 'Dokumen/Dompet') {
        $categoryId = 2;
    } elseif ($request->category == 'Pakaian/Aksesoris') {
        $categoryId = 3;
    } elseif ($request->category == 'Lainnya') {
        $categoryId = 4;
    }

    // Menyimpan data sesuai dengan properti kolom asli kelompokmu
    Item::create([
        'title' => $request->item_name,
        'category_id' => $categoryId,
        'location' => $request->location,
        'description' => 'Dilaporkan melalui form penemuan.',
        'type' => 'found',
        'date_time' => now(),
        'image' => $photoPath,
        'status' => 'active', 
        'user_id' => Auth::id()
    ]);

    return redirect('/dashboard')->with('success', 'Laporan berhasil disimpan!');
})->middleware('auth');

// 7. Jalur Keluar (Logout)
Route::any('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// Menampilkan Halaman Form Lapor Kehilangan
Route::get('/lapor-kehilangan', function () {
    pastikanKategoriTersedia();
    return view('lapor-kehilangan');
})->middleware('auth');

// Memproses Simpan Laporan Kehilangan ke Database
Route::post('/lapor-kehilangan', function (Illuminate\Http\Request $request) {
    $request->validate([
        'item_name' => 'required',
        'category' => 'required',
        'location' => 'required',
        'photo' => 'nullable|image|max:2048'
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('items_photos', 'public');
    }

    // Menentukan category_id berdasarkan pilihan form
    $categoryId = 1; 
    if ($request->category == 'Dokumen/Dompet') { $categoryId = 2; }
    elseif ($request->category == 'Pakaian/Aksesoris') { $categoryId = 3; }
    elseif ($request->category == 'Lainnya') { $categoryId = 4; }

    // Simpan ke tabel items dengan type 'lost'
    App\Models\Item::create([
        'title' => $request->item_name,
        'category_id' => $categoryId,
        'location' => $request->location,
        'description' => 'Dilaporkan melalui form kehilangan barang oleh mahasiswa.',
        'type' => 'lost', // Otomatis tersimpan sebagai barang hilang
        'date_time' => now(),
        'image' => $photoPath,
        'status' => 'active', 
        'user_id' => Auth::id()
    ]);

    return redirect('/dashboard')->with('success', 'Laporan kehilangan berhasil dipublikasikan!');
})->middleware('auth');

// 10. Halaman Khusus Dashboard Admin/Staff
Route::get('/admin/dashboard', function () {
    // Proteksi Keamanan: Jika bukan staff, tendang balik ke dashboard mahasiswa
    if (Auth::user()->role !== 'admin') {
        return redirect('/dashboard');
    }
    // ... sisa kode di bawahnya tetap sama

    $barangTemuan = Item::where('type', 'found')->latest()->get();
    $barangKehilangan = Item::where('type', 'lost')->latest()->get();

    return view('admin-dashboard', compact('barangTemuan', 'barangKehilangan'));
})->middleware('auth');

// Halaman Khusus Dashboard Admin/Staff
Route::get('/admin/dashboard', function () {
    if (Auth::user()->identity_number != '23456789') {
        return redirect('/dashboard');
    }

    // Mengambil data dari database
    $barangTemuan = \App\Models\Item::where('type', 'found')->latest()->get();
    $barangKehilangan = \App\Models\Item::where('type', 'lost')->latest()->get(); // Pastikan baris ini ada

    // Kirim kedua variabel ke view admin-dashboard
    return view('admin-dashboard', compact('barangTemuan', 'barangKehilangan'));
})->middleware('auth');

// Proses Konfirmasi Barang Khusus Jalur Admin
Route::patch('/admin/konfirmasi/{id}', function ($id) {
    if (Auth::user()->identity_number != '23456789') {
        return redirect('/dashboard');
    }

    $item = \App\Models\Item::findOrFail($id);
    $item->update(['status' => 'completed']);

    return redirect('/admin/dashboard')->with('success', 'Barang berhasil diverifikasi!');
})->middleware('auth');

// Rute untuk mengubah status barang menjadi 'active' (Di Amankan di Prodi) ketika mahasiswa klik tombol Titip Prodi
Route::patch('/barang/titip/{id}', function ($id) {
    $item = \App\Models\Item::findOrFail($id);
    
    // Ubah status menjadi active (Di Amankan di Prodi)
    $item->update(['status' => 'active']);

    return redirect('/dashboard')->with('success', 'Barang berhasil dititipkan ke Prodi!');
})->middleware('auth');