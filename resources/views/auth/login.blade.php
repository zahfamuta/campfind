<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Login</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; margin: 0; }
        .login-card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .login-card h2 { margin-bottom: 1.5rem; color: #1e3a8a; letter-spacing: 1px; font-size: 28px; }
        .input-group { margin-bottom: 1.25rem; text-align: left; }
        .input-group label { font-size: 13px; font-weight: 600; color: #4b5563; }
        .input-group input { width: 100%; padding: 0.75rem; margin-top: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; font-size: 14px; transition: 0.2s; }
        .input-group input:focus { border-color: #2563eb; outline: none; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .btn { width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: bold; margin-top: 0.5rem; transition: 0.2s; }
        .btn:hover { background: #1d4ed8; }
        .error-text { color: #dc2626; font-size: 13px; margin-bottom: 1rem; text-align: left; background: #fee2e2; padding: 0.5rem; border-radius: 4px; }
        .register-link { margin-top: 1.5rem; font-size: 13px; color: #6b7280; }
        .register-link a { color: #2563eb; text-decoration: none; font-weight: 600; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>CAMPFIND</h2>
        
        @if ($errors->has('loginError'))
            <div class="error-text">
                {{ $errors->first('loginError') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>NIM / NIP</label>
                <input type="text" name="identity_number" placeholder="Masukkan NIM/NIP" required value="{{ old('identity_number') }}">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar</a>
        </div>
    </div>
</body>
</html>