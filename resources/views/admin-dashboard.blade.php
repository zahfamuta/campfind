<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Staff Panel</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; margin: 0; padding: 2rem; }
        .header { background: #1e293b; color: white; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        .logout-btn { background: #ef4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .card-stats { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; flex: 1; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #3b82f6; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        thead { background: #334155; color: white; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .btn-confirm { background: #ea580c; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .status-badge { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 13px; font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <div>
        <h2>🏢 Panel Pengelolaan Staff Prodi - CampFind</h2>
        <p style="margin: 0; opacity: 0.8;">Selamat datang, {{ Auth::user()->name }} (Staff/Dosen)</p>
    </div>
    <form action="{{ url('/logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">🔴 Keluar Aplikasi</button>
    </form>
</div>

<div class="card-stats">
    <div class="card" style="border-left-color: #10b981;">
        <h3>📦 {{ $barangTemuan->count() }}</h3>
        <p style="margin:0; color:#64748b;">Total Barang Temuan (Found)</p>
    </div>
    <div class="card" style="border-left-color: #ef4444;">
        <h3>🔍 {{ $barangKehilangan->count() }}</h3>
        <p style="margin:0; color:#64748b;">Total Laporan Kehilangan (Lost)</p>
    </div>
</div>

<h3 style="color: #1e293b;">🟢 Verifikasi Penyerahan Barang Temuan (Found)</h3>
<table>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Lokasi Ditemukan</th>
            <th>Pelapor</th>
            <th>Status</th>
            <th>Tindakan Verifikasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($barangTemuan as $item)
            <tr>
                <td style="font-weight: bold;">{{ $item->title }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->user->name ?? 'Anonim' }}</td>
                <td>
                    @if($item->status == 'active')
                        <span class="status-badge" style="background: #fef3c7; color: #d97706;">🔄 Di Amankan di Prodi</span>
                    @else
                        <span class="status-badge" style="background: #d1d5db; color: #4b5563;">✅ Sudah Diambil</span>
                    @endif
                </td>
                <td>
                    @if($item->status == 'active')
                        <form action="{{ url('/admin/konfirmasi/'.$item->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-confirm">✅ Tandai Sudah Diambil Pemilik</button>
                        </form>
                    @else
                        <span style="color: #64748b; font-size: 14px;">Tidak ada tindakan</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #64748b; padding: 2rem;">Belum ada data titipan barang temuan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<h3 style="color: #1e293b; margin-top: 2.5rem;">🔴 Daftar Laporan Kehilangan Barang (Lost)</h3>
<table>
    <thead style="background: #475569;">
        <tr>
            <th>Nama Barang</th>
            <th>Lokasi Hilang</th>
            <th>Pelapor</th>
            <th>Status di Sistem</th>
        </tr>
    </thead>
    <tbody>
        @forelse($barangKehilangan as $lost)
            <tr>
                <td style="font-weight: bold;">{{ $lost->title }}</td>
                <td>{{ $lost->location }}</td>
                <td>{{ $lost->user->name ?? 'Anonim' }}</td>
                <td>
                    <span class="status-badge" style="background: #fee2e2; color: #ef4444;">🔍 Belum Ditemukan</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; color: #64748b; padding: 2rem;">Tidak ada laporan aktif mengenai kehilangan barang.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>