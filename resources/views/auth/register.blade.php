<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Daftar Akun</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; margin: 0; }
        .register-card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .register-card h2 { margin-bottom: 1.5rem; color: #1e3a8a; font-size: 26px; }
        .input-group { margin-bottom: 1rem; text-align: left; }
        .input-group label { font-size: 13px; font-weight: 600; color: #4b5563; }
        .input-group input, .input-group select { width: 100%; padding: 0.75rem; margin-top: 0.4rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        .btn { width: 100%; padding: 0.75rem; background: #16a34a; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: bold; margin-top: 0.5rem; }
        .btn:hover { background: #15803d; }
        .login-link { margin-top: 1.5rem; font-size: 13px; color: #6b7280; }
        .login-link a { color: #2563eb; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <body>
    <div class="register-card">
        <h2>DAFTAR AKUN</h2>
        <form action="{{ url('/register') }}" method="POST">
            @csrf 
            <div class="input-group">
                <label>NIM / NIP</label>
                <input type="text" name="identity_number" placeholder="Masukkan NIM atau NIP" required>
            </div>
            <div class="input-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Nama Lengkap Anda" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="nama@kampus.ac.id" required>
            </div>
            <div class="input-group">
    <label>Nomor Telepon</label>
    <input type="text" name="phone_number" placeholder="Contoh: 081234567890" required>
</div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="input-group">
                <label>Status</label>
                <select name="role">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen / Staff</option>
                </select>
            </div>
            <button type="submit" class="btn">Daftar Sekarang</button>
        </form>
        <div class="login-link">
            Sudah punya akun? <a href="{{ url('/login') }}">Login disini</a>
        </div>
    </div>
</body>
</html>