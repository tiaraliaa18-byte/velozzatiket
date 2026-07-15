<x-app-layout title="Riwayat Pembayaran - Velozza">
    @php
        // Siapkan data ringkas per booking untuk modal detail
        $riwayatData = [];
        foreach ($riwayat as $index => $pesanan) {
            $riwayatData[$index] = [
                'kode_booking' => $pesanan->kode_booking ?? '-',
                'kereta'       => $pesanan->jadwal->nama_kereta ?? '-',
                'rute'         => ($pesanan->jadwal->asal ?? '-') . ' ➔ ' . ($pesanan->jadwal->tujuan ?? '-'),
                'email'        => $pesanan->email_pemesan ?? '-',
                'hp'           => $pesanan->hp_pemesan ?? '-',
                'total_harga'  => 'Rp ' . number_format($pesanan->total_harga ?? 0, 0, ',', '.'),
                'penumpang'    => $pesanan->tiket->map(function ($t) {
                    $p = $t->penumpang;
                    return [
                        'nama'          => $p->nama_lengkap ?? '-',
                        'nik'           => $p->nik_ktp ?? '-',
                        'jenis_kelamin' => $p->jenis_kelamin ?? '-',
                        'tgl_lahir'     => $p->tgl_lahir
                            ? \Carbon\Carbon::parse($p->tgl_lahir)->translatedFormat('d M Y')
                            : '-',
                        'no_kursi'      => $t->no_kursi ?? '-',
                    ];
                })->values(),
            ];
        }
    @endphp

    <div class="flex min-h-screen">
        <x-sidebar />

        <!-- MAIN CONTENT -->
        <div class="flex-1 p-10 overflow-y-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Riwayat Pembayaran</h2>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-red-50 text-[#a11225] font-bold text-sm uppercase tracking-wider">
                            <th class="p-4 border-b-2 border-red-200">Kode Booking</th>
                            <th class="p-4 border-b-2 border-red-200">Nama Penumpang</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">No. Kursi</th>
                            <th class="p-4 border-b-2 border-red-200">Tgl &amp; Waktu Berangkat</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">Bukti Transfer</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">Status Akhir</th>
                            <th class="p-4 border-b-2 border-red-200 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        @forelse($riwayat as $index => $pesanan)
                            @php
                                $jumlahPenumpang = $pesanan->tiket->count() ?: 1;
                                $bukti = $pesanan->pembayaran?->bukti_pembayaran;
                                $status = $pesanan->status_pembayaran;

                                $tglBerangkat = $pesanan->jadwal && $pesanan->jadwal->waktu_keberangkatan
                                    ? \Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->translatedFormat('d M Y')
                                        . ' · ' . \Carbon\Carbon::parse($pesanan->jadwal->waktu_keberangkatan)->format('H:i')
                                    : (\Carbon\Carbon::parse($pesanan->tanggal_keberangkatan)->translatedFormat('d M Y') ?? '-');
                            @endphp

                            @if($pesanan->tiket->isEmpty())
                                <tr class="hover:bg-red-50/40 transition">
                                    <td class="p-4 font-mono font-semibold text-[#a11225]">{{ $pesanan->kode_booking ?? '-' }}</td>
                                    <td class="p-4 text-gray-400 italic">-</td>
                                    <td class="p-4 text-center text-gray-400 italic">-</td>
                                    <td class="p-4">{{ $tglBerangkat }}</td>
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
                                        @if($status === 'lunas')
                                            <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Lunas</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <button type="button" onclick="showDetail({{ $index }})"
                                            class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded-md text-xs font-semibold transition">
                                            🔍 Detail
                                        </button>
                                    </td>
                                </tr>
                            @else
                                @foreach($pesanan->tiket as $i => $t)
                                    @php
                                        $penumpang = $t->penumpang;
                                    @endphp
                                    <tr class="hover:bg-red-50/40 transition">
                                        @if($i === 0)
                                            <td class="p-4 font-mono font-semibold text-[#a11225] align-top" rowspan="{{ $jumlahPenumpang }}">{{ $pesanan->kode_booking ?? '-' }}</td>
                                        @endif

                                        <td class="p-4 font-medium text-gray-900">{{ $penumpang->nama_lengkap ?? '-' }}</td>
                                        <td class="p-4 text-center font-mono font-bold text-gray-700 bg-gray-50/50">{{ $t->no_kursi ?? '-' }}</td>

                                        @if($i === 0)
                                            <td class="p-4 align-top" rowspan="{{ $jumlahPenumpang }}">{{ $tglBerangkat }}</td>
                                            <td class="p-4 text-center align-top" rowspan="{{ $jumlahPenumpang }}">
                                                @if($bukti)
                                                    <a href="{{ asset('storage/' . $bukti) }}" target="_blank" class="bg-red-100 text-[#a11225] hover:bg-red-200 px-3 py-1 rounded-md text-xs font-semibold transition inline-block">
                                                        👁️ Lihat Struk
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">Belum diupload</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center align-top" rowspan="{{ $jumlahPenumpang }}">
                                                @if($status === 'lunas')
                                                    <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Lunas</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-bold uppercase">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center align-top" rowspan="{{ $jumlahPenumpang }}">
                                                <button type="button" onclick="showDetail({{ $index }})"
                                                    class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded-md text-xs font-semibold transition">
                                                    🔍 Detail
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-gray-400 italic">Belum ada riwayat transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[85vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Detail Pemesanan</h3>
                <button type="button" onclick="closeDetail()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>
            <div id="detailContent" class="p-6 text-sm text-gray-700 space-y-4"></div>
        </div>
    </div>

    <script>
        const riwayatData = @json($riwayatData);

        function showDetail(index) {
            const data = riwayatData[index];
            if (!data) return;

            const penumpangRows = data.penumpang.map(p => `
                <tr class="border-b border-gray-100">
                    <td class="py-2 pr-3 font-medium text-gray-900">${p.nama}</td>
                    <td class="py-2 pr-3 font-mono text-xs">${p.nik}</td>
                    <td class="py-2 pr-3 text-center capitalize">${p.jenis_kelamin}</td>
                    <td class="py-2 pr-3 text-center">${p.tgl_lahir}</td>
                    <td class="py-2 text-center font-mono font-bold">${p.no_kursi}</td>
                </tr>
            `).join('');

            document.getElementById('detailContent').innerHTML = `
                <div class="grid grid-cols-2 gap-4 bg-red-50/50 rounded-lg p-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Detail Perjalanan</p>
                        <p class="font-semibold text-gray-800">${data.kereta}</p>
                        <p class="text-xs text-gray-500">${data.rute}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Total Harga</p>
                        <p class="font-semibold text-gray-800">${data.total_harga}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">Email Pemesan</p>
                        <p>${data.email}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">No. HP Pemesan</p>
                        <p>${data.hp}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Data Penumpang</p>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-200">
                                <th class="py-2 pr-3">Nama</th>
                                <th class="py-2 pr-3">NIK</th>
                                <th class="py-2 pr-3 text-center">Jenis Kelamin</th>
                                <th class="py-2 pr-3 text-center">Tgl Lahir</th>
                                <th class="py-2 text-center">No. Kursi</th>
                            </tr>
                        </thead>
                        <tbody>${penumpangRows}</tbody>
                    </table>
                </div>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetail() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>

</x-app-layout>