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
        <div class="w-64 bg-blue-900 text-white p-6 shadow-lg">
            <h1 class="text-2xl font-bold tracking-wider mb-8">VELOZZA</h1>
            <nav class="space-y-4">
                <a href="{{ url('/admin/jadwal') }}" class="block py-2.5 px-4 rounded hover:bg-blue-800 transition">📅 Kelola Jadwal</a>
                <a href="{{ url('/admin/pembayaran') }}" class="block py-2.5 px-4 rounded bg-blue-800 font-semibold">🎟️ Data Tiket</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded hover:bg-blue-800 transition text-red-300 cursor-pointer">
                        🚪 Logout
                    </button>
                </form>
            </nav>
        </div>

        <div class="flex-1 p-10 overflow-y-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Manajemen Status Pembayaran</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 font-semibold text-sm uppercase tracking-wider">
                            <th class="p-4 border-b">Kode Booking</th>
                            <th class="p-4 border-b">Nama Penumpang</th>
                            <th class="p-4 border-b">Detail Perjalanan</th>
                            <th class="p-4 border-b text-center">No. Kursi</th>
                            <th class="p-4 border-b text-center">Bukti Transfer</th>
                            <th class="p-4 border-b">Status Saat Ini</th>
                            <th class="p-4 border-b text-center">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        @forelse($tiket as $t)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-mono font-semibold text-blue-700">VLZ-{{ $t->id_pembayaran }}</td>

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
                                        <a href="{{ asset('uploads/' . $t->bukti_pembayaran) }}" target="_blank" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-md text-xs font-semibold transition inline-block">
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
                                        <select name="status_pembayaran" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 bg-white text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                            <option value="menunggu" {{ $t->status_pembayaran == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="valid" {{ $t->status_pembayaran == 'valid' ? 'selected' : '' }}>Valid</option>
                                            <option value="ditolak" {{ $t->status_pembayaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 italic">Belum ada data transaksi tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>