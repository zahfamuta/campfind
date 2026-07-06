<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Lapor Kehilangan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; margin: 0; padding: 2rem; }
        .form-box { background: white; padding: 2rem; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h2 { color: #dc2626; margin-top: 0; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; font-size: 14px; }
        input[type="text"], select { width: 100%; padding: 0.6rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        .btn-submit { background: #dc2626; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-submit:hover { background: #b91c1c; }
        .btn-back { display: block; text-align: center; margin-top: 1rem; color: #6b7280; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<div class="form-box">
    <h2>🔍 Form Lapor Barang Kehilangan</h2>
    <p style="color: #6b7280; font-size: 14px;">Isi formulir ini jika Anda merasa kehilangan barang di lingkungan kampus.</p>
    
    <form action="{{ url('/lapor-kehilangan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Barang yang Hilang</label>
            <input type="text" name="item_name" placeholder="Contoh: Tumbler Corkcicle Hitam, Jaket Himpunan" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="category" required>
                <option value="Elektronik">Elektronik</option>
                <option value="Dokumen/Dompet">Dokumen / Dompet</option>
                <option value="Pakaian/Aksesoris">Pakaian / Aksesoris</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label>Perkiraan Lokasi Hilang</label>
            <input type="text" name="location" placeholder="Contoh: Kelas F3.2, Kantin Kampus 1" required>
        </div>

        <div class="form-group">
            <label>Foto Barang (Jika ada)</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Kirim Laporan Kehilangan</button>
    </form>

    <a href="{{ url('/dashboard') }}" class="btn-back">⬅ Kembali ke Dashboard</a>
</div>

</body>
</html>