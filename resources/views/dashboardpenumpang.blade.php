<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penumpang - Velozza</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-4xl mx-auto mt-10 p-6">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">👋 Selamat Datang, {{ $user->name }}!</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 px-4 rounded-lg transition shadow-sm">
                    🚪 Kelolar Akun / Logout
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm font-semibold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 space-y-4">
                <h3 class="text-lg font-semibold text-gray-700">🎟️ Tiket & Pemesanan Saya</h3>
                
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-bl-lg text-xs font-bold uppercase tracking-wider">
                        Menunggu Pembayaran
                    </div>
                    
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs font-bold text-blue-600 block mb-1">ID PEMESANAN: #VLZ-99</span>
                            <h4 class="text-lg font-bold text-gray-900">Velozza Express (Eksekutif)</h4>
                            <p class="text-sm text-gray-500">Bandung (BDG) ➔ Jakarta (GMR)</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-200 pt-4 mt-4 flex justify-between items-center text-sm">
                        <div>
                            <p class="text-xs text-gray-400">Total Tagihan</p>
                            <p class="text-base font-bold text-gray-800">Rp 150.000</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Nomor Kursi</p>
                            <p class="text-sm font-semibold text-gray-700">A-12</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 h-fit">
                <h3 class="text-lg font-bold text-gray-800 mb-2">💳 Konfirmasi Transfer</h3>
                <p class="text-xs text-gray-500 mb-4">Silakan transfer manual ke rekening **Bank BCA: 123-456-7890 a/n PT Velozza**.</p>

                <form action="{{ url('/pembayaran/kirim') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <input type="hidden" name="id_pemesanan" value="99">

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Bank Asal Anda</label>
                        <input type="text" name="bank_asal" placeholder="Contoh: Mandiri, BRI, BCA" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pemilik Rekening</label>
                        <input type="text" name="nama_rekening" placeholder="Sesuai nama di ATM/Buku" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Upload Bukti (.jpg / .png)</label>
                        <input type="file" name="bukti_pembayaran" required 
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[10px] text-gray-400 mt-1">*Maksimal ukuran file gambar 2MB</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg text-sm transition shadow-sm">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>