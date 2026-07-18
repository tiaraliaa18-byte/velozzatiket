<x-app-layout title="Kelola Jadwal - Velozza">

    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <div class="w-64 h-screen sticky top-0 text-white p-6 shadow-lg flex flex-col" style="background: linear-gradient(180deg, #7a0d1e 0%, #a11225 35%, #d3541c 100%);">
            <h1 class="text-2xl font-bold tracking-wider mb-8">VELOZZA</h1>
            <nav class="space-y-3 flex-1">
                <a href="{{ url('/admin/jadwal') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg bg-white text-[#a11225] font-semibold shadow-sm">
                    <span class="text-lg">📅</span> Kelola Jadwal
                </a>
                <a href="{{ url('/admin/pembayaran') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-white/90 hover:bg-white/10 transition">
                    <span class="text-lg">🎟️</span> Pembayaran
                </a>
                <a href="{{ url('/admin/riwayat') }}"
                   class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-white/90 hover:bg-white/10 transition">
                    <span class="text-lg">🕘</span> Riwayat
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
                <h2 class="text-3xl font-bold text-gray-800">Manajemen Jadwal Kereta Api</h2>
                <button onclick="bukaModalTambah()"
                        class="flex items-center gap-2 bg-[#a11225] hover:bg-[#7a0d1e] text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
                    + Tambah Jadwal Baru
                </button>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                    <button type="button"
                                            onclick="bukaModalEdit({
                                                id: '{{ $j->id_jadwal }}',
                                                nama_kereta: '{{ $j->nama_kereta }}',
                                                kelas: '{{ $j->kelas }}',
                                                asal: '{{ $j->asal }}',
                                                tujuan: '{{ $j->tujuan }}',
                                                waktu_keberangkatan: '{{ \Carbon\Carbon::parse($j->waktu_keberangkatan)->format('H:i') }}',
                                                durasi: '{{ $j->durasi }}',
                                                harga_tiket: '{{ $j->harga_tiket }}'
                                            })"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-3 py-1.5 rounded-md transition">
                                        Edit
                                    </button>
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

    {{-- MODAL TAMBAH / EDIT JADWAL --}}
    <div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 id="modal-title" class="text-xl font-bold text-gray-800">Tambah Jadwal Baru</h3>
                <button type="button" onclick="tutupModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>

            <form id="form-jadwal" method="POST" action="{{ route('admin.jadwal.store') }}">
                @csrf
                <div id="method-field"></div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kereta</label>
                        <select id="select-nama-kereta" onchange="toggleNamaBaru()"
                                class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition">
                            <option value="">-- Pilih Kereta --</option>
                            @foreach($jadwal->pluck('nama_kereta')->unique() as $namaKereta)
                                <option value="{{ $namaKereta }}">{{ $namaKereta }}</option>
                            @endforeach
                            <option value="__baru__">+ Tambah Nama Baru</option>
                        </select>

                        <input type="text" id="input-nama-baru"
                            class="hidden mt-2 w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition"
                            placeholder="Ketik nama kereta baru">

                        <input type="hidden" name="nama_kereta" id="input-nama-kereta">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" id="input-kelas" required
                                class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition">
                            <option value="ekonomi">Ekonomi</option>
                            <option value="bisnis">Bisnis</option>
                            <option value="eksekutif">Eksekutif</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asal</label>
                            <select name="asal" id="input-asal" required
                                    class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition">
                                <option value="Bandung">Bandung</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                            <select name="tujuan" id="input-tujuan" required
                                    class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition">
                                <option value="Jakarta">Jakarta</option>
                                <option value="Jogja">Jogja</option>
                                <option value="Malang">Malang</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Berangkat</label>
                            <input type="time" name="waktu_keberangkatan_time" id="input-waktu" required
                                   class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" name="durasi" id="input-durasi" required min="1"
                                   class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition"
                                   placeholder="Cth: 45">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (Rp)</label>
                        <input type="number" name="harga_tiket" id="input-harga" required min="0"
                               class="w-full p-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#a11225]/40 focus:border-[#a11225] transition"
                               placeholder="Cth: 150000">
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="tutupModal()"
                            class="flex-1 py-2.5 rounded-xl border border-gray-300 text-gray-600 font-semibold hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-[#a11225] text-white font-semibold hover:bg-[#7a0d1e] transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal-tambah');
        const form = document.getElementById('form-jadwal');
        const modalTitle = document.getElementById('modal-title');
        const methodField = document.getElementById('method-field');
        const selectNamaKereta = document.getElementById('select-nama-kereta');
        const inputNamaBaru = document.getElementById('input-nama-baru');
        const hiddenNamaKereta = document.getElementById('input-nama-kereta');

        function toggleNamaBaru() {
            if (selectNamaKereta.value === '__baru__') {
                inputNamaBaru.classList.remove('hidden');
                inputNamaBaru.value = '';
                hiddenNamaKereta.value = '';
                inputNamaBaru.focus();
            } else {
                inputNamaBaru.classList.add('hidden');
                hiddenNamaKereta.value = selectNamaKereta.value;
            }
        }

        inputNamaBaru.addEventListener('input', function () {
            hiddenNamaKereta.value = inputNamaBaru.value;
        });

        function bukaModalTambah() {
            modalTitle.textContent = 'Tambah Jadwal Baru';
            form.action = "{{ route('admin.jadwal.store') }}";
            methodField.innerHTML = '';
            form.reset();
            selectNamaKereta.value = '';
            inputNamaBaru.classList.add('hidden');
            hiddenNamaKereta.value = '';
            modal.classList.remove('hidden');
        }
        function bukaModalEdit(data) {
            modalTitle.textContent = 'Edit Jadwal';
            form.action = "{{ url('/admin/jadwal') }}/" + data.id;
            methodField.innerHTML = '@method('PUT')';

            // Cek apakah nama kereta ini ada di dropdown
            const adaDiDropdown = Array.from(selectNamaKereta.options).some(opt => opt.value === data.nama_kereta);
            if (adaDiDropdown) {
                selectNamaKereta.value = data.nama_kereta;
                inputNamaBaru.classList.add('hidden');
            } else {
                selectNamaKereta.value = '__baru__';
                inputNamaBaru.classList.remove('hidden');
                inputNamaBaru.value = data.nama_kereta;
            }
            hiddenNamaKereta.value = data.nama_kereta;

            document.getElementById('input-kelas').value = data.kelas;
            document.getElementById('input-asal').value = data.asal;
            document.getElementById('input-tujuan').value = data.tujuan;
            document.getElementById('input-waktu').value = data.waktu_keberangkatan;
            document.getElementById('input-durasi').value = data.durasi;
            document.getElementById('input-harga').value = data.harga_tiket;

            modal.classList.remove('hidden');
        }

        function tutupModal() {
            modal.classList.add('hidden');
        }

        // Sebelum submit, gabungkan input time jadi format datetime-local ('YYYY-MM-DDTHH:MM')
        // supaya cocok dengan str_replace('T', ' ', ...) di controller
        form.addEventListener('submit', function () {
            const waktu = document.getElementById('input-waktu').value; // "HH:MM"
            const today = new Date().toISOString().split('T')[0];       // "YYYY-MM-DD"

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'waktu_keberangkatan';
            hiddenInput.value = today + 'T' + waktu;
            form.appendChild(hiddenInput);
        });
    </script>

</x-app-layout>