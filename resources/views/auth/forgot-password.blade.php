<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Sandi - Velozza</title>
    <!-- Gunakan link CSS yang sama dengan login -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-container"> 
    <!-- Header yang sama dengan login -->
    <div class="login-header">
        <h1>VELOZZA</h1>
        <p>Sistem Pemesanan Tiket Kereta Cepat</p>
    </div>

    <!-- Body form dengan struktur class yang sama -->
    <div class="login-body">
        <h2>Lupa Sandi</h2>
        <p class="subtitle">Masukkan alamat email Anda untuk menerima link reset.</p>
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="admin@velozza.com">
            </div>

            <button type="submit" class="btn-submit">Kirim Link Reset Password</button>
        </form>

        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('login') }}" style="color: #dc2626; font-weight: bold; text-decoration: none;">Kembali ke Login</a>
        </div>
    </div>
</div>

</body>
</html>