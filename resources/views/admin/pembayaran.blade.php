<x-app-layout title="Manajemen Status Pembayaran - Velozza">
    <div class="flex min-h-screen">
        <x-sidebar />

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
                            <th class="p-4 border-b-2 border-red-200 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        {{-- $pemesanan dikirim dari PembayaranController@index,
                             sudah difilter status_pembayaran = 'proses' --}}
                        @forelse($pemesanan as $pesanan)
                            @php
                                $namaPenumpang = $pesanan->tiket->pluck('penumpang.nama_lengkap')->filter()->implode(', ') ?: '-';
                                $daftarKursi = $pesanan->tiket->pluck('no_kursi')->implode(', ') ?: '-';
                                $bukti = $pesanan->pembayaran?->bukti_pembayaran;
                            @endphp
                            <tr class="hover:bg-red-50/40 transition">
                                <td class="p-4 font-mono font-semibold text-[#a11225]">{{ $pesanan->kode_booking ?? '-' }}</td>
                                <td class="p-4 font-medium text-gray-900">{{ $namaPenumpang }}</td>
                                <td class="p-4">
                                    <span class="font-semibold text-gray-800">{{ $pesanan->jadwal->nama_kereta ?? '-' }}</span> <br>
                                    <span class="text-xs text-gray-400">{{ $pesanan->jadwal->asal ?? '-' }} ➔ {{ $pesanan->jadwal->tujuan ?? '-' }}</span>
                                </td>
                                <td class="p-4 text-center font-mono font-bold text-gray-700 bg-gray-50/50">{{ $daftarKursi }}</td>
                                <td class="p-4 text-center">
                                    @if($bukti)
                                        <a href="{{ asset('storage/' . $bukti) }}" target="_blank" class="bg-red-100 text-[#a11225] hover:bg-red-200 px-3 py-1 rounded-md text-xs font-semibold transition inline-block">
                                            👁️ Lihat Struk
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Belum diupload</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.pembayaran.update', $pesanan->pembayaran->id_pembayaran ?? 0) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_pembayaran" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1 bg-white text-xs focus:outline-none focus:ring-2 focus:ring-[#a11225] cursor-pointer">
                                            <option value="menunggu_konfirmasi" {{ $pesanan->status_pembayaran == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="lunas" {{ $pesanan->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="ditolak" {{ $pesanan->status_pembayaran == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 italic">Belum ada data transaksi tiket yang perlu diproses.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>