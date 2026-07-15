<x-app-layout title="Kelola Jadwal - Velozza">
    <div class="flex min-h-screen">
        <x-sidebar />

        <!-- MAIN CONTENT -->
        <div class="flex-1 p-10 overflow-y-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Manajemen Jadwal Kereta Api</h2>
                <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                        class="flex items-center gap-2 bg-[#a11225] hover:bg-[#7a0d1e] text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
                    + Tambah Jadwal Baru
                </button>
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
                            <th class="p-4 border-b-2 border-red-200">Nama Kereta</th>
                            <th class="p-4 border-b-2 border-red-200">Rute Perjalanan</th>
                            <th class="p-4 border-b-2 border-red-200">Waktu Berangkat</th>
                            <th class="p-4 border-b-2 border-red-200">Durasi</th>
                            <th class="p-4 border-b-2 border-red-200">Harga</th>
                            <th class="p-4 border-b-2 border-red-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        @forelse($jadwal as $j)
                            <tr class="hover:bg-red-50/40 transition">
                                <td class="p-4">
                                    <span class="font-semibold text-gray-900">{{ $j->nama_kereta }}</span><br>
                                    <span class="text-xs text-gray-400">Kelas: {{ ucfirst($j->kelas) }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="bg-orange-50 text-orange-700 px-2 py-1 rounded-md text-xs font-semibold">{{ $j->asal }}</span>
                                    →
                                    <span class="bg-red-50 text-red-700 px-2 py-1 rounded-md text-xs font-semibold">{{ $j->tujuan }}</span>
                                </td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($j->waktu_keberangkatan)->format('H:i') }}</td>
                                <td class="p-4">{{ $j->durasi }} Menit</td>
                                <td class="p-4 font-semibold text-gray-800">Rp {{ number_format($j->harga_tiket, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">Edit</button>
                                    <form action="{{ url('/admin/jadwal/' . $j->id_jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 italic">Belum ada jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>