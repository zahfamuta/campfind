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
        
        .btn-green { background: #16a34a; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; text-decoration: none; display: inline-block; margin-bottom: 1.5rem; }
        .btn-green:hover { background: #15803d; }
        
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #1e3a8a; color: white; }
        .badge { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
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

        <div style="margin-bottom: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ url('/lapor-temuan') }}" class="btn-green" style="margin-bottom: 0;">➕ Lapor Barang Temuan Baru</a>
            <a href="{{ url('/lapor-kehilangan') }}" class="btn-green" style="background: #dc2626; margin-bottom: 0;">🔍 Lapor Barang Kehilangan</a>
        </div>

        <h3 style="color: #16a34a; margin-top: 2rem;">🟢 Daftar Barang Temuan (Found)</h3>
        <div style="overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 3rem;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #1e40af; color: white;">
                    <tr>
                        <th style="padding: 1rem;">Nama Barang</th>
                        <th style="padding: 1rem;">Lokasi Ditemukan</th>
                        <th style="padding: 1rem;">Status</th>
                        <th style="padding: 1rem;">Penemu (Pelapor)</th>
                        <th style="padding: 1rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangTemuan as $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem; font-weight: bold;">{{ $item->title }}</td>
                            <td style="padding: 1rem;">{{ $item->location }}</td>
                            <td style="padding: 1rem;">
                                @if($item->status == 'active')
                                    <span style="background: #fef3c7; color: #d97706; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 14px; font-weight: bold;">Di Amankan di Prodi</span>
                                @elseif($item->status == 'completed')
                                    <span style="background: #cbd5e1; color: #4b5563; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 14px; font-weight: bold;">Sudah Diambil</span>
                                @else
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 14px; font-weight: bold;">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td style="padding: 1rem;">{{ $item->user->name ?? 'Anonim' }}</td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <a href="https://wa.me/{{ $item->user->phone_number ?? '' }}" target="_blank" class="btn-green" style="padding: 0.4rem 0.8rem; font-size: 14px; background: #22c55e; margin: 0; border-radius: 4px;">An 💬 Via WhatsApp</a>
                                    
                                    @if($item->status == 'active')
                                        <button type="button" style="background: #94a3b8; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: not-allowed; font-size: 14px;" disabled>
                                            🏢 Sudah di Prodi
                                        </button>
                                    @elseif($item->status == 'completed')
                                        <button type="button" style="background: #cbd5e1; color: #64748b; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: not-allowed; font-size: 14px;" disabled>
                                            ✅ Selesai
                                        </button>
                                    @else
                                        <form action="{{ url('/barang/titip/'.$item->id) }}" method="POST" style="display: inline; margin: 0;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">
                                                🏢 Titip Prodi
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">Belum ada laporan barang temuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h3 style="color: #dc2626;">🔴 Daftar Laporan Kehilangan Barang (Lost)</h3>
        <div style="overflow-x: auto; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 2rem;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #991b1b; color: white;">
                    <tr>
                        <th style="padding: 1rem;">Nama Barang</th>
                        <th style="padding: 1rem;">Perkiraan Lokasi Hilang</th>
                        <th style="padding: 1rem;">Status</th>
                        <th style="padding: 1rem;">Pemilik (Pelapor)</th>
                        <th style="padding: 1rem;">Hubungi Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangKehilangan as $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem; font-weight: bold;">{{ $item->title }}</td>
                            <td style="padding: 1rem;">{{ $item->location }}</td>
                            <td style="padding: 1rem;"><span style="background: #fee2e2; color: #ef4444; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 14px; font-weight: bold;">{{ $item->status }}</span></td>
                            <td style="padding: 1rem;">{{ $item->user->name ?? 'Anonim' }}</td>
                            <td style="padding: 1rem;">
                                <a href="https://wa.me/{{ $item->user->phone_number ?? '' }}?text=Halo%20{{ urlencode($item->user->name ?? '') }},%20saya%20menemukan%20barang%20yang%20cocok%20dengan%20laporan%20kehilangan%20{{ urlencode($item->title) }}%20Anda." 
                                   target="_blank" class="btn-green" style="padding: 0.4rem 0.8rem; font-size: 14px; background: #22c55e; margin: 0; border-radius: 4px;">
                                    💬 Hubungi Pemilik
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">Belum ada laporan kehilangan barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>