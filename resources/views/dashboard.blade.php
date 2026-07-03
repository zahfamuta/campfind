<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f3f4f6; margin: 0; padding: 0; }
        .navbar { background: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .navbar h1 { margin: 0; font-size: 20px; color: #111827; }
        .user-info { font-size: 14px; color: #4b5563; }
        .container { padding: 2rem; max-width: 1000px; margin: 0 auto; }
        .welcome-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .welcome-card h2 { margin-top: 0; color: #111827; }
        .btn-green { background: #16a34a; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; }
        .btn-green:hover { background: #15803d; }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>CAMPFIND</h1>
        <div class="user-info">
            Halo, {{ Auth::user()->name }} ({{ Auth::user()->identity_number }}) | 
            <a href="{{ url('/login') }}" style="color: red; text-decoration: none; font-weight: bold;">Keluar / Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>Selamat Datang di Halaman Dashboard Utama</h2>
            <p style="color: #6b7280;">Aplikasi Pengelolaan Barang Hilang & Temuan Kampus (Fase 1)</p>
        </div>

        <h3>Menu Navigasi Fase 1:</h3>
        <button class="btn-green">➕ Lapor Barang Temuan Baru</button>
    </div>

</body>
</html> 