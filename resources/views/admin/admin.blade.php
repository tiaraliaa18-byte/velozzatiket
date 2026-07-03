<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Kelola Jadwal Velozza</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* 🎨 GLOBAL & VARIABEL WARNA VELOZZA */
        :root {
            --bg-utama: #f8fafc;        /* Soft gray premium untuk background luar */
            --warna-sidebar-start: #991b1b;
            --warna-sidebar-mid-1: #b91c1c;
            --warna-sidebar-mid-2: #dc2626;
            --warna-sidebar-end: #ea580c;
            --text-judul: #1e293b;
            --text-muted: #64748b;
            --merah-velozza: #e11d48;
            --merah-hover: #be123c;
            --oranye-velozza: #ea580c;
            --oranye-hover: #c2410c;
            --warna-border-tabel: #cbd5e1; /* Warna garis abu-abu rapi untuk grid */
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-utama);
            color: #334155;
            height: 100vh;
            overflow: hidden;
        }

        /* 📦 LAYOUT STRUKTUR UTAMA */
        .dashboard-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* 🚪 SIDEBAR VELOZZA */
        .sidebar {
            width: 260px;
            background: linear-gradient(to bottom, 
                var(--warna-sidebar-start) 0%, 
                var(--warna-sidebar-mid-1) 45%, 
                var(--warna-sidebar-mid-2) 70%, 
                var(--warna-sidebar-end) 100%);
            padding: 30px 24px;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            color: #ffffff;
            flex-shrink: 0;
        }

        .sidebar-brand {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.05em;
            margin-bottom: 40px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .menu-link {
            display: block;
            padding: 12px 16px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .menu-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .menu-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(4px);
        }

        .logout-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            color: #fca5a5;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background-color: rgba(153, 27, 27, 0.4);
            color: #ffffff;
        }

        /* 💻 KONTEN UTAMA DOCK */
        .main-content {
            flex-grow: 1;
            padding: 40px;
            overflow-y: auto;
        }

        /* 🔔 ALERT BANNER NOTIFIKASI */
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .alert-success {
            background-color: #f0fdf4;
            border-left: 4px solid #22c55e;
            color: #166534;
        }
        .alert-danger {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }
        .alert-list {
            list-style-position: inside;
            margin-top: 4px;
        }

        /* 🔝 TOP BAR (JUDUL & TOMBOL TAMBAH) */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .top-bar h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-judul);
        }

        .btn-tambah {
            background-color: var(--merah-velozza);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
            transition: all 0.2s ease;
        }

        .btn-tambah:hover {
            background-color: var(--merah-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(225, 29, 72, 0.35);
        }

        /* 📊 CARD & TABEL MANAJEMEN JADWAL DENGAN GRID GARIS */
        .table-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid var(--warna-border-tabel);
        }

        .main-table {
            width: 100%;
            border-collapse: collapse; /* Menyatukan border agar garis tidak double */
            text-align: left;
        }

        /* Header Tabel Custom Bernuansa Soft Premium Pink */
        .main-table thead tr {
            background-color: #ffeeee;
        }

        /* Garis Vertikal Pembatas Kolom di Header */
        .main-table th {
            padding: 16px 24px;
            color: #991b1b;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 2px solid #fca5a5;
            border-right: 1px solid var(--warna-border-tabel);
        }

        /* Hilangkan garis vertikal paling kanan di header */
        .main-table th:last-child {
            border-right: none;
        }

        /* Garis Pembatas Kolom & Baris Vertikal-Horizontal di Body */
        .main-table td {
            padding: 18px 24px;
            font-size: 14px;
            color: #475569;
            vertical-align: middle;
            border-bottom: 1px solid var(--warna-border-tabel);
            border-right: 1px solid var(--warna-border-tabel);
        }

        /* Hilangkan garis vertikal paling kanan di isi body */
        .main-table td:last-child {
            border-right: none;
        }

        /* Efek Hover Baris */
        .main-table tbody tr {
            transition: background-color 0.2s ease;
        }
        .main-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Detail Komponen Tabel */
        .kereta-nama {
            font-weight: 700;
            color: #1e293b;
        }
        .kereta-kelas {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 400;
            text-transform: capitalize;
            margin-top: 2px;
        }

        .rute-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge-asal {
            background-color: #fff7ed;
            color: #c2410c;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-tujuan {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .rute-panah {
            color: #94a3b8;
        }

        .durasi-text {
            font-weight: 600;
            color: #334155;
        }

        .harga-text {
            font-weight: 700;
            color: #16a34a;
        }

        .aksi-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-edit {
            background-color: #eab308;
            color: #ffffff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(234, 179, 8, 0.2);
            transition: all 0.2s ease;
        }
        .btn-edit:hover {
            background-color: #ca8a04;
            transform: translateY(-1px);
        }

        .btn-hapus {
            background-color: #ef4444;
            color: #ffffff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
            transition: all 0.2s ease;
        }
        .btn-hapus:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        /* 🪟 POPUP MODAL CRUD JADWAL */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background-color: #ffffff;
            width: 100%;
            max-width: 450px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

        .modal-header {
            background: linear-gradient(to right, var(--oranye-velozza), #be123c);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
        }
        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
        }
        .btn-close-modal {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            opacity: 0.8;
        }
        .btn-close-modal:hover {
            opacity: 1;
        }

        /* FORM DALAM MODAL */
        .modal-form {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            color: #334155;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--oranye-velozza);
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.15);
        }
        
        /* Input Spesial Ber-Rupiah */
        .input-rupiah-wrapper {
            display: flex;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }
        .rupiah-addon {
            background-color: #e2e8f0;
            color: #64748b;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 600;
            user-select: none;
            border-right: 1px solid #cbd5e1;
        }
        .input-rupiah-wrapper .form-control {
            border: none;
            border-radius: 0;
        }

        /* Menghilangkan panah input type number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            margin-top: 8px;
        }
        .btn-batal {
            background-color: #e2e8f0;
            color: #475569;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-batal:hover {
            background-color: #cbd5e1;
        }
        .btn-simpan {
            background-color: var(--oranye-velozza);
            color: #ffffff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(234, 88, 12, 0.2);
            transition: background-color 0.2s;
        }
        .btn-simpan:hover {
            background-color: var(--oranye-hover);
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <div class="sidebar">
            <div class="sidebar-brand">VELOZZA</div>
            <nav class="sidebar-menu" style="flex-grow: 1;">
                <a href="{{ url('/admin/jadwal') }}" class="menu-link active">📅 Kelola Jadwal</a>
                <a href="{{ url('/admin/pembayaran') }}" class="menu-link">🎟️ Data Tiket</a>
            </nav>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">🚪 Logout</button>
                </form>
            </div>
        </div>

        <div class="main-content">
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="alert-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="top-bar">
                <h2>Manajemen Jadwal Kereta Api</h2>
                <button id="openModalBtn" class="btn-tambah">➕ Tambah Jadwal Baru</button>
            </div>

            <div class="table-card">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>Nama Kereta</th>
                            <th>Rute Perjalanan</th>
                            <th>Waktu Berangkat</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $j)
                            <tr>
                                <td>
                                    <span class="kereta-nama">{{ $j->nama_kereta }}</span>
                                    <span class="kereta-kelas">Kelas: {{ $j->kelas ?? '-' }}</span>
                                </td>
                                <td>
                                    <div class="rute-container">
                                        <span class="badge-asal">{{ $j->asal }}</span>
                                        <span class="rute-panah">➔</span>
                                        <span class="badge-tujuan">{{ $j->tujuan }}</span>
                                    </div>
                                </td>
                                <td>{{ date('H:i', strtotime($j->waktu_keberangkatan)) }}</td>
                                <td class="durasi-text">{{ $j->durasi ?? '-' }} Menit</td>
                                <td class="harga-text">Rp {{ number_format($j->harga_tiket, 0, ',', '.') }}</td>
                                <td>
                                    <div class="aksi-group">
                                        <button type="button"
                                                class="btn-edit openEditModalBtn"
                                                data-id="{{ $j->id_jadwal }}"
                                                data-nama="{{ $j->nama_kereta }}"
                                                data-kelas="{{ $j->kelas }}"
                                                data-asal="{{ $j->asal }}"
                                                data-tujuan="{{ $j->tujuan }}"
                                                data-waktu="{{ date('H:i', strtotime($j->waktu_keberangkatan)) }}"
                                                data-durasi="{{ $j->durasi }}"
                                                data-harga="{{ $j->harga_tiket }}">
                                            Edit
                                        </button>

                                        <form action="{{ url('/admin/jadwal/'.$j->id_jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-hapus">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 50px 24px; text-align: center; color: #94a3b8; font-style: italic; font-size: 14px; border-right: none;">
                                    Belum ada jadwal kereta yang diinput oleh Admin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="crudModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Jadwal Kereta Baru</h3>
                <button id="closeModalBtn" class="btn-close-modal">&times;</button>
            </div>
            
            <form id="modalForm" action="{{ url('/admin/jadwal') }}" method="POST" class="modal-form">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="form-group">
                    <label>Nama Kereta:</label>
                    <select id="nama_kereta" name="nama_kereta" required class="form-control" style="font-weight: 500;">
                        <option value="" disabled selected> Pilih Nama Kereta </option>
                        <option value="Anggrek">Anggrek</option>
                        <option value="Argo">Argo</option>
                        <option value="Utama">Utama</option>
                        <option value="Pasundan">Pasundan</option>
                        <option value="Merapi">Merapi</option>
                        <option value="Kertajaya">Kertajaya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kelas Kereta:</label>
                    <select id="kelas" name="kelas" required class="form-control" style="font-weight: 500;">
                        <option value="" disabled selected> Pilih Kelas Kereta </option>
                        <option value="eksekutif">Eksekutif</option>
                        <option value="bisnis">Bisnis</option>
                        <option value="ekonomi">Ekonomi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stasiun Asal:</label>
                    <select id="stasiun_asal" name="asal" required class="form-control">
                        <option value="" disabled selected> Pilih Kota Asal </option>
                        <option value="Bandung">Bandung (BD)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stasiun Tujuan:</label>
                    <select id="stasiun_tujuan" name="tujuan" required class="form-control">
                        <option value="" disabled selected> Pilih Kota Tujuan </option>
                        <option value="Jakarta">Jakarta (GMR)</option>
                        <option value="Jogja">Jogja (YK)</option>
                        <option value="Malang">Malang (ML)</option>
                        <option value="Bandung">Bandung (BD)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Waktu Berangkat:</label>
                    <input type="time" id="waktu_keberangkatan" name="waktu_keberangkatan" required class="form-control">
                </div>

                <div class="form-group">
                    <label>Durasi Perjalanan (Menit):</label>
                    <input type="number" id="durasi" name="durasi" required class="form-control" style="font-weight: 500;">
                </div>

                <div class="form-group">
                    <label>Harga Tiket:</label>
                    <div class="input-rupiah-wrapper">
                        <span class="rupiah-addon">Rp</span>
                        <input type="number" id="harga_tiket" name="harga_tiket" required class="form-control" style="font-weight: 600;">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="cancelModalBtn" class="btn-batal">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan ke Database</button>
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
        
        const namaKeretaSelect = document.getElementById('nama_kereta');
        const kelasSelect = document.getElementById('kelas');
        const stasiunTujuanSelect = document.getElementById('stasiun_tujuan');
        const hargaTiketInput = document.getElementById('harga_tiket');
        const durasiInput = document.getElementById('durasi');

        let isEditMode = false;

        // ==========================================
        // TABEL REFERENSI HARGA & DURASI
        // Struktur: tabelHarga[namaKereta][kelas][tujuan] = { harga, durasi }
        // Kelas pakai huruf kecil karena value dropdown "kelas" juga huruf kecil
        // Silakan sesuaikan angka-angka di bawah dengan harga real kamu
        // ==========================================
        // Durasi (menit) per kereta+tujuan — biasanya sama untuk semua kelas
        // karena rangkaian & rute sama, cuma harga yang beda per kelas.
        // Silakan sesuaikan kalau jadwal real kamu beda.
        const durasiRute = {
            'Anggrek':   { Jakarta: 195, Jogja: 435, Malang: 690, Bandung: 40 },
            'Argo':      { Jakarta: 175, Jogja: 405, Malang: 660, Bandung: 35 },
            'Utama':     { Jakarta: 185, Jogja: 420, Malang: 675, Bandung: 40 },
            'Pasundan':  { Jakarta: 205, Jogja: 450, Malang: 705, Bandung: 45 },
            'Merapi':    { Jakarta: 200, Jogja: 440, Malang: 695, Bandung: 42 },
            'Kertajaya': { Jakarta: 210, Jogja: 460, Malang: 720, Bandung: 50 }
        };

        // Helper: gabungin harga (angka) + durasi (dari durasiRute) jadi { harga, durasi }
        function buatBaris(namaKereta, harga) {
            const durasi = durasiRute[namaKereta];
            const hasil = {};
            for (const tujuan in harga) {
                hasil[tujuan] = { harga: harga[tujuan], durasi: durasi[tujuan] };
            }
            return hasil;
        }

        const tabelHarga = {
            'Anggrek': {
                'ekonomi':   buatBaris('Anggrek', { Jakarta: 150000, Jogja: 165000, Malang: 400000, Bandung: 80000 }),
                'bisnis':    buatBaris('Anggrek', { Jakarta: 220000, Jogja: 240000, Malang: 470000, Bandung: 100000 }),
                'eksekutif': buatBaris('Anggrek', { Jakarta: 300000, Jogja: 320000, Malang: 550000, Bandung: 120000 })
            },
            'Argo': {
                'ekonomi':   buatBaris('Argo', { Jakarta: 160000, Jogja: 175000, Malang: 420000, Bandung: 85000 }),
                'bisnis':    buatBaris('Argo', { Jakarta: 250000, Jogja: 270000, Malang: 480000, Bandung: 105000 }),
                'eksekutif': buatBaris('Argo', { Jakarta: 350000, Jogja: 370000, Malang: 580000, Bandung: 130000 })
            },
            'Utama': {
                'ekonomi':   buatBaris('Utama', { Jakarta: 155000, Jogja: 170000, Malang: 410000, Bandung: 82000 }),
                'bisnis':    buatBaris('Utama', { Jakarta: 240000, Jogja: 260000, Malang: 460000, Bandung: 98000 }),
                'eksekutif': buatBaris('Utama', { Jakarta: 340000, Jogja: 360000, Malang: 560000, Bandung: 125000 })
            },
            'Pasundan': {
                'ekonomi':   buatBaris('Pasundan', { Jakarta: 140000, Jogja: 150000, Malang: 380000, Bandung: 70000 }),
                'bisnis':    buatBaris('Pasundan', { Jakarta: 210000, Jogja: 225000, Malang: 440000, Bandung: 90000 }),
                'eksekutif': buatBaris('Pasundan', { Jakarta: 290000, Jogja: 310000, Malang: 520000, Bandung: 110000 })
            },
            'Merapi': {
                'ekonomi':   buatBaris('Merapi', { Jakarta: 145000, Jogja: 155000, Malang: 390000, Bandung: 75000 }),
                'bisnis':    buatBaris('Merapi', { Jakarta: 215000, Jogja: 230000, Malang: 450000, Bandung: 95000 }),
                'eksekutif': buatBaris('Merapi', { Jakarta: 295000, Jogja: 315000, Malang: 530000, Bandung: 115000 })
            },
            'Kertajaya': {
                'ekonomi':   buatBaris('Kertajaya', { Jakarta: 135000, Jogja: 145000, Malang: 370000, Bandung: 65000 }),
                'bisnis':    buatBaris('Kertajaya', { Jakarta: 205000, Jogja: 220000, Malang: 430000, Bandung: 88000 }),
                'eksekutif': buatBaris('Kertajaya', { Jakarta: 280000, Jogja: 300000, Malang: 510000, Bandung: 108000 })
            }
        };

        // Auto-fill Harga dan Durasi berdasarkan Nama Kereta + Kelas + Tujuan
        // (Hanya saat Mode Tambah, bukan saat Edit)
        function updateHargaOtomatis() {
            if (isEditMode) return;

            const namaKereta = namaKeretaSelect.value;
            const kelas = kelasSelect.value;
            const tujuan = stasiunTujuanSelect.value;

            const data = tabelHarga[namaKereta]?.[kelas]?.[tujuan];

            if (data) {
                hargaTiketInput.value = data.harga;
                durasiInput.value = data.durasi;
            } else {
                hargaTiketInput.value = '';
                durasiInput.value = '';
            }
        }

        namaKeretaSelect.addEventListener('change', updateHargaOtomatis);
        kelasSelect.addEventListener('change', updateHargaOtomatis);
        stasiunTujuanSelect.addEventListener('change', updateHargaOtomatis);

        openBtn.addEventListener('click', () => {
            isEditMode = false;
            modalTitle.innerText = "➕ Tambah Jadwal Kereta Baru";
            modalForm.action = "{{ url('/admin/jadwal') }}";
            formMethod.value = "POST";
            modalForm.reset();
            modal.classList.add('show');
        });

        document.querySelectorAll('.openEditModalBtn').forEach(button => {
            button.addEventListener('click', function() {
                isEditMode = true;
                modalTitle.innerText = "✏️ Edit Jadwal Kereta Api";
                const idJadwal = this.getAttribute('data-id');
                modalForm.action = "{{ url('/admin/jadwal') }}/" + idJadwal;
                formMethod.value = "PUT";

                document.getElementById('nama_kereta').value = this.getAttribute('data-nama');
                document.getElementById('kelas').value = this.getAttribute('data-kelas');
                document.getElementById('stasiun_asal').value = this.getAttribute('data-asal');
                document.getElementById('stasiun_tujuan').value = this.getAttribute('data-tujuan');
                document.getElementById('waktu_keberangkatan').value = this.getAttribute('data-waktu');
                document.getElementById('durasi').value = this.getAttribute('data-durasi');
                document.getElementById('harga_tiket').value = this.getAttribute('data-harga');

                modal.classList.add('show');
            });
        });

        const closeModal = () => {
            modal.classList.remove('show');
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