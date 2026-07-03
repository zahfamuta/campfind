<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; padding: 0; margin: 0; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 320px; text-align: center; }
        .input-group { margin-bottom: 1rem; text-align: left; }
        .input-group label { font-size: 14px; font-weight: bold; color: #374151; }
        .input-group input { width: 100%; padding: 0.6rem; margin-top: 0.25rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.6rem; background: #1d4ed8; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 0.5rem; }
        .btn:hover { background: #1e40af; }
        .error-text { color: red; font-size: 13px; margin-bottom: 1rem; text-align: left; }
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
    </div>
</body>
</html>