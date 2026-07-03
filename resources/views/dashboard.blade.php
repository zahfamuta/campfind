<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; margin: 0; padding: 0; }
        .navbar { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .navbar h1 { margin: 0; font-size: 20px; color: #1e3a8a; }
        .user-info { font-size: 14px; color: #4b5563; }
        .container { padding: 2rem; max-width: 1100px; margin: 0 auto; }
        .welcome-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .welcome-card h2 { margin-top: 0; color: #111827; }
        
        /* Tombol Navigasi */
        .btn-green { background: #16a34a; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; text-decoration: none; display: inline-block; margin-bottom: 1.5rem; }
        .btn-green:hover { background: #15803d; }
        
        /* Style Filter & Pencarian Sesuai Flowchart */
        .search-filter-box { background: white; padding: 1.25rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .search-filter-box input, .search-filter-box select { padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .search-filter-box input { flex: 1; min-width: 200px; }
        .btn-search { background: #1e3a8a; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-search:hover { background: #1d4ed8; }

        /* Style Tabel Daftar Barang */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #1e3a8a; color: white; }
        .badge { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-success { background: #dcfce7; color: #15803d; }

        /* Tombol Metode Pengembalian Sesuai Flowchart */
        .btn-action { padding: 0.4rem 0.8rem; border-radius: 4px; border: none; font-size: 12px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 0.3rem; }
        .btn-wa { background: #25d366; color: white; }
        .btn-wa:hover { background: #20ba5a; }
        .btn-prodi { background: #3b82f6; color: white; }
        .btn-prodi:hover { background: #2563eb; }
        .btn-done { background: #6b7280; color: white; cursor: not-allowed; }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>CAMPFIND</h1>
        <div class="user-info">
            Halo, <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->identity_number }}) | 
            <a href="{{ url('/logout') }}" style="color: red; text-decoration: none; font-weight: bold;">Logout</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; font-weight: bold; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-card">
            <h2>Selamat Datang di Halaman Dashboard Utama</h2>
            <p style="color: #6b7280; margin: 0;">Aplikasi Pengelolaan Barang Hilang & Temuan Kampus (CampFind)</p>
        </div>

        <a href="{{ url('/lapor-temuan') }}" class="btn-green">➕ Lapor Barang Temuan Baru</a>

        <h3>Daftar Laporan Lost & Found</h3>

        <form action="{{ url('/dashboard') }}" method="GET" class="search-filter-box">
            <input type="text" name="search" placeholder="Cari nama barang atau lokasi..." value="{{ request('search') }}">
            
            <select name="category">
                <option value="">-- Semua Kategori --</option>
                <option value="Elektronik" {{ request('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                <option value="Dokumen/Dompet" {{ request('category') == 'Dokumen/Dompet' ? 'selected' : '' }}>Dokumen / Dompet</option>
                <option value="Pakaian/Aksesarois" {{ request('category') == 'Pakaian/Aksesoris' ? 'selected' : '' }}>Pakaian / Aksesoris</option>
                <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>

            <button type="submit" class="btn-search">🔍 Filter & Cari</button>
            @if(request('search') || request('category'))
                <a href="{{ url('/dashboard') }}" style="padding-top: 0.6rem; color: #6b7280; text-decoration: none; font-size: 14px;">Reset</a>
            @endif
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Pelapor</th>
                    <th>Metode Pengembalian (Klik Klaim)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->location }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'Selesai' ? 'badge-success' : 'badge-warning' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            @if($item->status != 'Selesai')
                                <a href="https://wa.me/{{ $item->user->phone_number }}?text=Halo%20{{ urlencode($item->user->name) }},%20saya%20ingin%20mengonfirmasi%20terkait%20laporan%20barang%20{{ urlencode($item->item_name) }}%20di%20CampFind." 
                                   target="_blank" class="btn-action btn-wa">
                                    💬 Via WhatsApp
                                </a>

                                <a href="https://wa.me/{{ $item->user->phone_number }}?text=Halo%20{{ urlencode($item->user->name) }},%20saya%20pilih%20metode%20Titip%20Prodi%20untuk%20barang%20{{ urlencode($item->item_name) }}.%20Mohon%20berikan%20kode%20klaimnya." 
                                   target="_blank" class="btn-action btn-prodi">
                                    🏢 Titip Prodi
                                </a>
                            @else
                                <span class="btn-action btn-done">Barang Sudah Diambil</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #9ca3af;">Barang yang dicari tidak ditemukan atau belum ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>