<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Kelola Jadwal Velozza</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        <div class="w-64 bg-blue-900 text-white p-6 shadow-lg">
            <h1 class="text-2xl font-bold tracking-wider mb-8">VELOZZA</h1>
            <nav class="space-y-4">
                <a href="{{ url('/admin/jadwal') }}" class="block py-2.5 px-4 rounded bg-blue-800 font-semibold">📅 Kelola Jadwal</a>
                <a href="{{ url('/admin/pembayaran') }}" class="block py-2.5 px-4 rounded hover:bg-blue-800 transition">🎟️ Data Tiket</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded hover:bg-blue-800 transition text-red-300 cursor-pointer">
                        🚪 Logout
                    </button>
                </form>
            </nav>
        </div>

        <div class="flex-1 p-10 overflow-y-auto">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Manajemen Jadwal Kereta Api</h2>
                <button id="openModalBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium shadow transition cursor-pointer">
                    ➕ Tambah Jadwal Baru
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 font-semibold text-sm uppercase tracking-wider">
                            <th class="p-4 border-b">Rute Perjalanan</th>
                            <th class="p-4 border-b">Waktu Berangkat</th>
                            <th class="p-4 border-b">Harga</th>
                            <th class="p-4 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                        @forelse($jadwal as $j)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            {{ $j->asal }}
                                        </span>
                                        <span class="text-gray-400">➔</span>
                                        <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            {{ $j->tujuan }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">{{ $j->waktu_keberangkatan }}</td>
                                <td class="p-4 font-medium text-green-600">Rp {{ number_format($j->harga_tiket, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                                class="openEditModalBtn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-xs font-medium transition cursor-pointer shadow"
                                                data-id="{{ $j->id_jadwal }}"
                                                data-asal="{{ $j->asal }}"
                                                data-tujuan="{{ $j->tujuan }}"
                                                data-waktu="{{ date('Y-m-d\TH:i', strtotime($j->waktu_keberangkatan)) }}"
                                                data-harga="{{ $j->harga_tiket }}">
                                            Edit
                                        </button>

                                        <form action="{{ url('/admin/jadwal/'.$j->id_jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-medium transition cursor-pointer shadow">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic">
                                    Belum ada jadwal kereta yang diinput oleh Admin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="crudModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all scale-95 duration-300">
            <div class="bg-blue-900 text-white p-4 flex justify-between items-center">
                <h3 class="text-lg font-bold" id="modalTitle">Tambah Jadwal Kereta Baru</h3>
                <button id="closeModalBtn" class="text-white hover:text-gray-200 text-xl font-bold cursor-pointer">&times;</button>
            </div>
            
            <form id="modalForm" action="{{ url('/admin/jadwal') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Stasiun Asal:</label>
                    <select id="stasiun_asal" name="asal" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected> Pilih Kota Asal </option>
                        <option value="Bandung">Bandung (BD)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Stasiun Tujuan:</label>
                    <select id="stasiun_tujuan" name="tujuan" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected> Pilih Kota Tujuan </option>
                        <option value="Jakarta">Jakarta (GMR)</option>
                        <option value="Jogja">Jogja (YK)</option>
                        <option value="Malang">Malang (ML)</option>
                        <option value="Bandung">Bandung (BD)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Waktu Berangkat:</label>
                    <input type="datetime-local" id="waktu_keberangkatan" name="waktu_keberangkatan" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1">Harga Tiket:</label>
                    <div class="flex rounded-lg shadow-sm bg-gray-50">
                        <span class="px-3 py-2 rounded-l-lg border border-r-0 border-gray-300 bg-gray-200 text-gray-500 text-sm flex items-center select-none">
                            Rp
                        </span>
                        <input type="number" id="harga_tiket" name="harga_tiket" placeholder="Masukkan nominal harga" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-r-lg bg-white text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2 border-t border-gray-100">
                    <button type="button" id="cancelModalBtn" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm shadow transition cursor-pointer">
                        Simpan ke Database
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('crudModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');
        
        const modalTitle = document.getElementById('modalTitle');
        const modalForm = document.getElementById('modalForm');
        const formMethod = document.getElementById('formMethod');
        
        const stasiunTujuanSelect = document.getElementById('stasiun_tujuan');
        const hargaTiketInput = document.getElementById('harga_tiket');

        let isEditMode = false;

        stasiunTujuanSelect.addEventListener('change', function() {
            if (isEditMode) return;

            const kotaTujuan = this.value;
            let hargaOtomatis = 0;

            if (kotaTujuan === 'Jakarta') {
                hargaOtomatis = 150000;
            } else if (kotaTujuan === 'Jogja') {
                hargaOtomatis = 175000;
            } else if (kotaTujuan === 'Malang') {
                hargaOtomatis = 450000;
            } else if (kotaTujuan === 'Bandung') {
                hargaOtomatis = 90000;
            }

            hargaTiketInput.value = hargaOtomatis;
        });

        openBtn.addEventListener('click', () => {
            isEditMode = false;
            modalTitle.innerText = "➕ Tambah Jadwal Kereta Baru";
            modalForm.action = "{{ url('/admin/jadwal') }}";
            formMethod.value = "POST";
            modalForm.reset();
            modal.classList.remove('hidden');
        });

        document.querySelectorAll('.openEditModalBtn').forEach(button => {
            button.addEventListener('click', function() {
                isEditMode = true;
                modalTitle.innerText = "✏️ Edit Jadwal Kereta Api";
                const idJadwal = this.getAttribute('data-id');
                modalForm.action = "{{ url('/admin/jadwal') }}/" + idJadwal;
                formMethod.value = "PUT";

                document.getElementById('stasiun_asal').value = this.getAttribute('data-asal');
                document.getElementById('stasiun_tujuan').value = this.getAttribute('data-tujuan');
                document.getElementById('waktu_keberangkatan').value = this.getAttribute('data-waktu');
                document.getElementById('harga_tiket').value = this.getAttribute('data-harga');

                modal.classList.remove('hidden');
            });
        });

        const closeModal = () => {
            modal.classList.add('hidden');
        };

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>

</body>
</html>