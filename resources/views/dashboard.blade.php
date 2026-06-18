<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penumpang - Velozza</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">
 
<div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="#" class="text-2xl font-black tracking-wider text-blue-600 font-mono">
            VELOZZA
        </a>
        
        <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
            <div class="flex items-center gap-1 text-blue-600 font-bold">
                <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px]">1</span> Pilih Kereta
            </div>
            <span class="text-gray-400">›</span>
            <div class="flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px]">2</span> Pilih Kursi
            </div>
            <span class="text-gray-400">›</span>
            <div class="flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px]">3</span> Penumpang
            </div>
            <span class="text-gray-400">›</span>
            <div class="flex items-center gap-1">
                <span class="w-5 h-5 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px]">4</span> Konfirmasi
            </div>
        </div>

        <div class="flex items-center gap-4">
            <h2 class="text-sm font-bold text-gray-800">👋 Selamat Datang, {{ $user->name ?? 'Penumpang' }}!</h2>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1.5 px-3 rounded-lg transition shadow-sm cursor-pointer">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
</div>
 
<div class="bg-gradient-to-r cursor-default from-blue-700 to-indigo-800 text-white py-12 px-4 shadow-inner">
  <div class="max-w-6xl mx-auto text-center md:text-left">
    <div class="text-3xl font-extrabold mb-2">Pesan Tiket Kereta</div>
    <div class="text-blue-100 text-sm mb-6">Temukan jadwal terbaik untuk perjalanan Anda</div>
  </div>
</div>
 
<div class="max-w-7xl mx-auto px-4 py-8">

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif
 
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">🎟️ Jadwal yang Tersedia</h3>
            
            <div class="space-y-4">
                @foreach($daftarJadwal as $jadwal)
                    @php
                        $jamMenit = \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->format('H:i:s');
                        $waktuDinamis = \Carbon\Carbon::today()->setTimeFromTimeString($jamMenit);
                        $durasiKereta = $jadwal->durasi ?? 5; 
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition cursor-pointer flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="text-lg font-bold text-gray-900">{{ $jadwal->nama_kereta }}</div>
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded uppercase tracking-wider 
                                    @if($jadwal->kelas == 'Eksekutif') bg-purple-100 text-purple-700 
                                    @elseif($jadwal->kelas == 'Bisnis') bg-blue-100 text-blue-700 
                                    @else bg-green-100 text-green-700 @endif">
                                    {{ $jadwal->kelas }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $waktuDinamis->format('H:i') }}</span>
                                    <span class="text-xs text-gray-400">{{ $jadwal->asal }}</span>
                                </div>
                                <div class="text-center text-xs text-gray-400 px-2 border-x border-gray-200">
                                    <span>{{ $durasiKereta }}j 00m</span>
                                    <div class="w-16 h-[2px] bg-gray-300 my-0.5 mx-auto"></div>
                                    <span class="text-[10px]">Langsung</span>
                                </div>
                                <div>
                                    <span class="font-bold text-gray-800 block">{{ $waktuDinamis->copy()->addHours($durasiKereta)->format('H:i') }}</span>
                                    <span class="text-xs text-gray-400">{{ $jadwal->tujuan }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right w-full md:w-auto border-t md:border-t-0 pt-3 md:pt-0 flex md:flex-col justify-between items-center md:items-end">
                            <div>
                                <span class="text-xs text-gray-400 block md:inline">/orang</span>
                                <span class="text-xl font-black text-orange-600">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</span>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg mt-2 transition shadow-sm">
                                Pilih Kereta
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">💳 Detail & Pembayaran</h3>

            <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl text-center shadow-sm">
                <span class="text-xs font-bold text-yellow-800 block mb-1">⏱️ SISA WAKTU PEMBAYARAN</span>
                <span id="cdnum" class="text-2xl font-black text-gray-800 font-mono">01:29:47</span>
                <p class="text-[11px] text-gray-500 mt-1">Segera transfer agar pesanan Anda tidak dibatalkan otomatis.</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 space-y-4">
                <div>
                    <h3 class="text-md font-bold text-gray-800 mb-1">Konfirmasi Transfer Manual</h3>
                    <p class="text-xs text-gray-500">Silakan transfer ke rekening <strong>Bank BCA: 123-456-7890 a/n PT Velozza</strong>.</p>
                </div>

                <form action="{{ url('/pembayaran/kirim') }}" method="POST" enctype="multipart/form-data" class="space-y-4 m-0">
                    @csrf
                    <input type="hidden" name="id_pemesanan" value="99">

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Bank Asal Anda</label>
                        <input type="text" name="bank_asal" placeholder="Contoh: Mandiri, BRI, BCA" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Pemilik Rekening</label>
                        <input type="text" name="nama_rekening" placeholder="Sesuai nama di ATM" required 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Upload Bukti (.jpg / .png)</label>
                        <input type="file" name="bukti_pembayaran" required 
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[10px] text-gray-400 mt-1">*Maksimal ukuran file gambar 2MB</p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg text-sm transition shadow-sm cursor-pointer">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
// Logic hitung mundur sederhana bawaan Tiara
var cdSecs = 5387;
setInterval(function(){
    if(cdSecs <= 0) return;
    cdSecs--;
    var h = Math.floor(cdSecs/3600), m = Math.floor((cdSecs%3600)/60), s = cdSecs%60;
    var el = document.getElementById('cdnum');
    if(el) el.textContent = (h ? String(h).padStart(2,'0')+':' : '') + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
}, 1000);
</script>
</body>
</html>