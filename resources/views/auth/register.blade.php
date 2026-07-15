<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Velozza</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-10 font-sans">

    <div class="w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-red-600 text-white text-center py-8 px-6">
                <h1 class="text-3xl font-extrabold tracking-wide">VELOZZA</h1>
                <p class="text-yellow-300 font-semibold text-sm mt-1">Sistem Pemesanan Tiket Kereta Cepat</p>
            </div>
            <div class="h-1 bg-orange-400"></div>

            {{-- BODY --}}
            <div class="px-8 py-8">
                <h2 class="text-xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm mt-1 mb-6">
                    Daftar untuk mulai memesan tiket kereta secara online.
                </p>

                {{-- Notifikasi error validasi --}}
                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Cth: Budi Santoso"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="email@contoh.com"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Kata Sandi</label>
                        <input type="password" name="password" required minlength="8"
                               placeholder="Minimal 8 karakter"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required minlength="8"
                               placeholder="Ulangi kata sandi"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold tracking-wide py-3 rounded-xl transition">
                        DAFTAR SEKARANG
                    </button>
                </form>
            </div>

            {{-- FOOTER --}}
            <div class="bg-gray-50 text-center py-4 border-t border-gray-100">
                <span class="text-gray-500 text-sm">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-red-600 font-semibold text-sm hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>

</body>
</html>