<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Lapor Barang Temuan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; margin: 0; padding: 2rem; }
        .form-card { background: white; max-width: 500px; margin: 0 auto; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px rgba(0,0,0,0.05); }
        h2 { color: #1e3a8a; margin-top: 0; margin-bottom: 1.5rem; }
        .input-group { margin-bottom: 1.25rem; }
        .input-group label { display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 0.5rem; }
        .input-group input, .input-group select { width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 0.75rem; background: #16a34a; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background: #15803d; }
        .btn-back { display: inline-block; margin-top: 1rem; color: #2563eb; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

    <div class="form-card">
        <h2>Isi Form Temuan (Finder)</h2>
        <form action="{{ url('/lapor-temuan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <label>Nama Barang</label>
                <input type="text" name="item_name" placeholder="Contoh: Kunci Motor, Tumbler" required>
            </div>

            <div class="input-group">
                <label>Kategori</label>
                <select name="category" required>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Dokumen/Dompet">Dokumen / Dompet</option>
                    <option value="Pakaian/Aksesoris">Pakaian / Aksesoris</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="input-group">
                <label>Lokasi Ditemukan</label>
                <input type="text" name="location" placeholder="Contoh: Gedung Kuliah Terpadu Lantai 2" required>
            </div>

            <div class="input-group">
                <label>Foto Barang</label>
                <input type="file" name="photo" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">Simpan ke Database</button>
        </form>
        <a href="{{ url('/dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
    </div>

</body>
</html>