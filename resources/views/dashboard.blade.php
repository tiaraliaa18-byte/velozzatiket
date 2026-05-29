<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Velozza</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardpenumpang.css') }}">
</head>
<body>

    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <h1>VELOZZA</h1>
            <span class="brand-tag">PELANGGAN</span>
        </div>

        <div class="dashboard-body">
            <div class="success-badge">
                login sukses
            </div>
            
            <h2>Selamat Datang di Aplikasi Velloza</h2>
            <p>Anda login menggunakan email: <strong>{{ Auth::user()?->email }}</strong></p>
            <p>Hak Akses Aplikasi: <span class="role-text">{{ strtoupper($user->role) }}</span></p>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    KELUAR DARI APLIKASI
                </button>
            </form>
        </div>
        


        
    </div>

</body>
</html>