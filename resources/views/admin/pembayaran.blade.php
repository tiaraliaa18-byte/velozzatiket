<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Manajemen Status Pembayaran</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <!-- SIDEBAR -->
        <div class="w-64 text-white p-6 shadow-lg flex flex-col" style="background: linear-gradient(180deg, #7a0d1e 0%, #a11225 35%, #d3541c 100%);">
            <h1 class="text-2xl font-bold tracking-wider mb-8">VELOZZA</h1>
            <nav class="space-y-3 flex-1">
                <a href="{{ url('/admin/jadwal') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-white/90 hover:bg-white/10 transition">
                    <span class="text-lg">📅</span> Kelola Jadwal
                </a>
                <a href="{{ url('/admin/pembayaran') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg bg-white text-[#a11225] font-semibold shadow-sm">
                    <span class="text-lg">🎟️</span> Data Tiket
                </a>
            </nav>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 text-left py-2.5 px-4 rounded-lg hover:bg-white/10 transition text-white/80 cursor-pointer">
                    <span class="text-lg">🚪</span> Logout
                </button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 p-10 overflow-y-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Manajemen Status Pembayaran</h2>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-red-50 text-[#a11225] font-bold text-sm uppercase tracking-wider">
                            <th class="p-4 border-b-2 border-red-200">Kode Booking</th>
                            <th class="p-4 border-b-2 border-red-200">Nama Penumpang</th>
                            <th class="p-4 border-b-2 border-red-200">Detail Perjalanan</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">No. Kursi</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">Bukti Transfer</th>
                            <th class="p-4 border-b-2 border-red-200">Status Saat Ini</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        @forelse($tiket as $t)
                            <tr class="hover:bg-red-50/40 transition">
                                <td class="p-4 font-mono font-semibold text-[#a11225]">VLZ-{{ $t->id_pembayaran }}</td>

                                <td class="p-4 font-medium text-gray-900">
                                    {{ $t->pemesanan->penumpang->nama_penumpang ?? '-' }}
                                </td>

                                <td class="p-4">
                                    <span class="font-semibold text-gray-800">{{ $t->pemesanan->jadwal->nama_kereta ?? '-' }}</span> <br>
                                    <span class="text-xs text-gray-400">{{ $t->pemesanan->jadwal->stasiun_asal ?? '-' }} ➔ {{ $t->pemesanan->jadwal->stasiun_tujuan ?? '-' }}</span>
                                </td>

                                <td class="p-4 text-center font-mono font-bold text-gray-700 bg-gray-50/50">
                                    {{ $t->pemesanan->no_kursi ?? '-' }}
                                </td>

                                <td class="p-4 text-center">
                                    @if($t->bukti_pembayaran)
                                        <a href="{{ asset('uploads/' . $t->bukti_pembayaran) }}" target="_blank" class="bg-red-100 text-[#a11225] hover:bg-red-200 px-3 py-1 rounded-md text-xs font-semibold transition inline-block">
                                            👁️ Lihat Struk
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Belum diupload</span>
                                    @endif
                                </td>

                                <td class="p-4">
                                    @if($t->status_pembayaran === 'valid')
                                        <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Valid</span>
                                    @elseif($t->status_pembayaran === 'ditolak')
                                        <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Ditolak</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Menunggu</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    <form action="{{ url('/admin/pembayaran/'.$t->id_pembayaran) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_pembayaran" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 bg-white text-xs focus:outline-none focus:ring-2 focus:ring-[#a11225] cursor-pointer">
                                            <option value="menunggu" {{ $t->status_pembayaran == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="valid" {{ $t->status_pembayaran == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="ditolak" {{ $t->status_pembayaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-400 italic">Belum ada data transaksi tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>