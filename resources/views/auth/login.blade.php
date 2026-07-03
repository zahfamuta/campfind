<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampFind - Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6; }
        .login-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        .input-group { margin-bottom: 1rem; text-align: left; }
        .input-group input { width: 100%; padding: 0.5rem; margin-top: 0.25rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 0.5rem; background: #1d4ed8; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>CAMPFIND</h2>
        <div class="input-group">
            <label>NIM / NIP</label>
            <input type="text" placeholder="Masukkan NIM/NIP">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" placeholder="••••••••">
        </div>
        <button class="btn">Masuk</button>
    </div>
</body>
</html>