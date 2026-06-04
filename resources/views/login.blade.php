<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Velozza</title>
      <link rel="stylesheet" href="{{ asset('css/login.css') }}">                                                                                                                                                                                                        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-container">
        
        <div class="login-header">
            <h1>VELOZZA</h1>
            <p>Sistem Pemesanan Tiket Kereta Cepat</p>
        </div>

        <div class="login-body">
            <h2>Selamat Datang</h2>
            <p class="subtitle">Silakan masuk menggunakan akun Anda yang terdaftar.</p>

            @if ($errors->any())
                <div style="color: red; background-color: #fef2f2; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: left;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="contoh: admin@velozza.com">
                </div>

                <div class="form-group">
                    <div class="label-flex">
                        <label for="password">Kata Sandi</label>
                        <a href="#" class="forgot-link">Lupa Sandi?</a>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-submit">
                    MASUK KE APLIKASI
                </button>
            </form>
        </div>

        <div class="login-footer">
            Belum punya akun penumpang? <a href="#" class="register-link">Daftar Sekarang</a>
        </div>
    </div>

</body>
</html>