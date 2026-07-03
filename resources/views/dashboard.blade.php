<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CampFind - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">CAMPFIND</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Halo, <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->identity_number }})
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Keluar / Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow p-5 bg-white rounded">
                    <h2>Selamat Datang di Halaman Dashboard Utama</h2>
                    <p class="text-muted">Aplikasi Pengelolaan Barang Hilang & Temuan Kampus (Fase 5).</p>
                    <hr>
                    <div class="mt-4">
                        <h5>Menu Navigasi Fase 5:</h5>
                        <a href="{{ route('items.create') }}" class="btn btn-success mt-2">➕ Lapor Barang Temuan Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>