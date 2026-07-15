<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Velozza</title>
    <!-- Gunakan CSS yang sama dengan login -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <h1>VELOZZA</h1>
        <p>Sistem Pemesanan Tiket Kereta Cepat</p>
    </div>

    <div class="login-body">
        <h2>Reset Password</h2>
        <p class="subtitle">Masukkan password baru Anda di bawah ini.</p>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn-submit">Reset Password</button>
        </form>
    </div>
</div>

</body>
</html>