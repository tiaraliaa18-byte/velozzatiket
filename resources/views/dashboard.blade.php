<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Velozza</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardpenumpang.css') }}">
</head>

<body>
 
<!-- TOPBAR -->
<div class="topbar" id="topbar">
  <a href="#" class="logo">
    VELOZZA
  </a>
  <div class="topbar-steps">
    <div class="tstep active" id="s2">
        <div class="tstep-num">1</div>Pilih Kereta
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s3">
        <div class="tstep-num">2</div>Pilih Kursi
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s4">
        <div class="tstep-num">3</div>Penumpang
    </div>
    <div class="tstep-sep">›</div>
    
    <div class="tstep" id="s5">
        <div class="tstep-num">4</div>Konfirmasi
    </div>
</div>
</div>
 
<!-- HERO SEARCH -->
<div class="hero" id="hero-section">
  <div style="max-width:1200px;margin:0 auto">
    <div class="hero-title">Pesan Tiket Kereta</div>
    <div class="hero-sub">Temukan jadwal terbaik untuk perjalanan Anda</div>
    <div class="search-card">
      <div class="search-row">
        <div class="sf" style="min-width:220px">
          <label>Ke</label>
          <select>
            <option>Bandung</option>
          </select>
        </div>
        <button class="swap-btn" onclick="swapSt()" title="Tukar stasiun">→<i class="ti ti-arrows-exchange"></i></button>
        <div class="sf" style="min-width:220px">
          <label>Ke</label>
          <select>
            <option>Jakarta</option>
            <option>Yogyakarta</option>
            <option>Malang</option>
          </select>
        </div>
        <div class="sf">
          <label>Tanggal</label>
          <input type="date" value="2026-06-15" style="width:160px">
        </div>
        <div class="sf" style="min-width:auto;flex:0">
          <label>Penumpang</label>
          <div class="pax-counter">
            <button type="button" class="pax-btn" id="pax-kurang">−</button>
            <span class="pax-val" id="pax-val">1</span>
            <button type="button" class="pax-btn" id="pax-tambah">+</button>
          </div>
        </div>
        <div class="sf" style="min-width:130px">
          <label>Kelas</label>
          <select>
            <option>Semua Kelas</option>
            <option>Eksekutif</option>
            <option>Bisnis</option>
            <option>Ekonomi</option>
          </select>
        </div>
        <button class="btn-search" onclick="goPage('page-results',2)">
          <i class="ti ti-search"></i>Cari Tiket
        </button>
      </div>
    </div>
  </div>
</div>
 
<div class="main">
 
<!-- PAGE 2: RESULTS -->
  <div class="layout-2col">
    <div>
      <div class="filter-tabs">
        <div class="ftab active">Semua (8)</div>
        <div class="ftab">Eksekutif</div>
        <div class="ftab">Bisnis</div>
        <div class="ftab">Ekonomi</div>
        <div class="ftab" style="margin-left:auto">
          <i class="ti ti-arrows-sort" style="font-size:12px;vertical-align:-1px"></i> Harga Terendah
        </div>
      </div>
 
      <!-- Train cards -->
      @foreach($daftarJadwal as $jadwal)
  @php
      // Mengambil jam & menit dari database
      $jamMenit = \Carbon\Carbon::parse($jadwal->waktu_keberangkatan)->format('H:i:s');
      
      // Menggabungkan tanggal hari ini dengan jam dari database
      $waktuDinamis = \Carbon\Carbon::today()->setTimeFromTimeString($jamMenit);
      
      // Mengambil durasi dari database, jika kosong otomatis default ke 5 jam
      $durasiKereta = $jadwal->durasi ?? 5; 
  @endphp

  <div class="train-card" onclick="selTrain(this, '{{ $jadwal->nama_kereta }}', '{{ $jadwal->kelas }}', '{{ $waktuDinamis->format('H:i') }}', '-', '{{ $jadwal->harga_tiket }}', '{{ $durasiKereta }}j 00m', 'langsung')">
    <div class="tc-main">
      <div class="tc-name-block">
        <div class="tc-name">{{ $jadwal->nama_kereta }}</div>
        <span class="tc-class-pill 
          @if($jadwal->kelas == 'Eksekutif') pill-exec 
          @elseif($jadwal->kelas == 'Bisnis') pill-biz 
          @else pill-eco @endif">
          {{ $jadwal->kelas }}
        </span>
      </div>
      <div>
        <div class="tc-time">{{ $waktuDinamis->format('H:i') }}</div>
        <div class="tc-sta">{{ $jadwal->asal }}</div>
      </div>
      <div class="tc-mid">
        <div class="tc-dur">{{ $durasiKereta }}j 00m</div>
        <div class="tc-line"></div>
        <div class="tc-stops">Langsung</div>
      </div>
      <div>
        <div class="tc-time">{{ $waktuDinamis->copy()->addHours($durasiKereta)->format('H:i') }}</div>
        <div class="tc-sta">{{ $jadwal->tujuan }}</div>
      </div>
      <div class="tc-price">
        <div class="tc-price-amt">Rp {{ number_format($jadwal->harga_tiket, 0, ',', '.') }}</div>
        <div class="tc-price-per">/orang</div>
      </div>
    </div>
    
    <!-- Bagian tc-footer (fasilitas & rute) sudah dihapus dari sini -->
  </div>
@endforeach

<div style="clear: both; margin-top: 24px;">
  <button class="btn-primary" id="btn-pilih-kereta" disabled onclick="goPage('page-seat',3)">
    Pilih Kursi <i class="ti ti-arrow-right"></i>
  </button>
</div>
 
<!-- PAGE 3: SEAT -->
<div class="page" id="page-seat">
  <div class="layout-sidebar">
    <div>
      <div class="card">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-armchair"></i>Pilih Kursi</div>
          <div class="notice notice-info" style="margin-bottom:16px">
            <i class="ti ti-users"></i>Pilih 2 kursi untuk penumpang Anda
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
            <div style="font-size:13px;font-weight:600;color:var(--text-mid)" id="seat-train-lbl">Argo Bromo Anggrek · Eksekutif</div>
            <div class="gerbong-tabs">
              <div class="gtab active" onclick="switchGerbong(this,4)">Gerbong 4</div>
              <div class="gtab" onclick="switchGerbong(this,5)">5</div>
              <div class="gtab" onclick="switchGerbong(this,6)">6</div>
              <div class="gtab" onclick="switchGerbong(this,7)">7</div>
            </div>
          </div>
          <div class="seat-section">
            <div style="display:flex;gap:5px;align-items:center;margin-bottom:4px">
              <div style="width:24px"></div>
              <div class="seat-col-header" style="width:34px">A</div>
              <div class="seat-col-header" style="width:34px">B</div>
              <div style="width:20px"></div>
              <div class="seat-col-header" style="width:34px">C</div>
              <div class="seat-col-header" style="width:34px">D</div>
            </div>
            <div class="seat-map" id="seat-map"></div>
            <div class="seat-legend">
              <div class="leg-item"><div class="leg-box leg-avail"></div>Tersedia</div>
              <div class="leg-item"><div class="leg-box leg-sel"></div>Dipilih</div>
              <div class="leg-item"><div class="leg-box leg-taken"></div>Terisi</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-receipt" style="margin-right:6px"></i>Ringkasan Pemesanan</div>
        </div>
        <div class="summary-body">
          <div class="sum-row"><span class="sum-label">Kereta</span><span class="sum-val" id="s-train">Argo Bromo</span></div>
          <div class="sum-row"><span class="sum-label">Kursi</span><span class="sum-val" id="s-seats">—</span></div>
          <div class="sum-row"><span class="sum-label">Harga/orang</span><span class="sum-val" id="s-price">Rp 580.000</span></div>
          <div class="sum-row"><span class="sum-label">Penumpang</span><span class="sum-val">2 orang</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt" id="s-total">Rp 1.160.000</span></div>
          <button class="btn-primary" id="btn-lanjut-kursi" disabled onclick="goPage('page-passenger',4)" style="margin-top:14px">
            Data Penumpang <i class="ti ti-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE 4: PASSENGER -->
<div class="page" id="page-passenger">
  <div class="layout-sidebar">
    <div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-users"></i>Data Penumpang</div>
          <div class="pax-section-header">
            <div class="pax-avatar">P1</div>
            <div>
              <div class="pax-section-label">Penumpang 1</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p1-seat">4A</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field"><label>Nama Lengkap (sesuai KTP)</label><input type="text" placeholder="Cth: Budi Santoso"></div>
            <div class="form-field"><label>Nomor KTP / Paspor</label><input type="text" placeholder="16 digit NIK"></div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="pax-section-header">
            <div class="pax-avatar">P2</div>
            <div>
              <div class="pax-section-label">Penumpang 2</div>
              <div style="font-size:12px;color:var(--text-mute)">Dewasa</div>
            </div>
            <div class="pax-seat-tag"><i class="ti ti-armchair" style="font-size:11px"></i> Kursi <span id="p2-seat">4B</span></div>
          </div>
          <div class="form-grid">
            <div class="form-field"><label>Nama Lengkap (sesuai KTP)</label><input type="text" placeholder="Cth: Siti Rahayu"></div>
            <div class="form-field"><label>Nomor KTP / Paspor</label><input type="text" placeholder="16 digit NIK"></div>
          </div>
          <div class="form-grid-3">
            <div class="form-field"><label>Jenis Kelamin</label><select><option>Laki-laki</option><option>Perempuan</option></select></div>
            <div class="form-field"><label>Tanggal Lahir</label><input type="date"></div>
            <div class="form-field"><label>Nomor HP</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-mail"></i>Kontak Pemesan</div>
          <div class="form-grid">
            <div class="form-field"><label>Alamat Email</label><input type="email" placeholder="email@contoh.com"></div>
            <div class="form-field"><label>Nomor HP Pemesan</label><input type="text" placeholder="+62 812 xxxx xxxx"></div>
          </div>
          <div class="notice notice-info">
            <i class="ti ti-send"></i>E-tiket akan dikirim ke email dan nomor HP ini
          </div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-seat',3)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" onclick="goPage('page-confirm',5)">Lanjut ke Konfirmasi <i class="ti ti-arrow-right"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-receipt" style="margin-right:6px"></i>Ringkasan</div>
        </div>
        <div class="summary-body">
          <div class="sum-row"><span class="sum-label">Rute</span><span class="sum-val">GMR → YK</span></div>
          <div class="sum-row"><span class="sum-label">Tanggal</span><span class="sum-val">15 Jun 2026</span></div>
          <div class="sum-row"><span class="sum-label">Kereta</span><span class="sum-val" id="s2-train">Argo Bromo</span></div>
          <div class="sum-row"><span class="sum-label">Kursi</span><span class="sum-val" id="s2-seats">4A, 4B</span></div>
          <div class="sum-row"><span class="sum-label">2 × Rp 580.000</span><span class="sum-val">Rp 1.160.000</span></div>
          <div class="sum-row"><span class="sum-label">Biaya layanan</span><span class="sum-val">Rp 20.000</span></div>
          <div class="sum-total"><span>Total</span><span class="sum-total-amt">Rp 1.180.000</span></div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE 5: CONFIRMATION -->
<div class="page" id="page-confirm">
  <div class="layout-sidebar">
    <div>
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-ticket"></i>Detail Tiket</div>
          <div class="ticket">
            <div class="ticket-top">
              <div>
                <div class="ticket-train-name" id="tck-train">Argo Bromo Anggrek</div>
                <div class="ticket-class">Eksekutif · 15 Juni 2026</div>
              </div>
              <i class="ti ti-train ticket-icon"></i>
            </div>
            <div class="ticket-body">
              <div class="ticket-route">
                <div class="ticket-city">GMR</div>
                <div class="ticket-line">
                  <div class="ticket-dur" style="text-align:center;font-size:11px;color:var(--text-mute);margin-bottom:3px" id="tck-dur">5j 05m</div>
                  <div class="ticket-line-inner"></div>
                </div>
                <div class="ticket-city">YK</div>
              </div>
              <div class="ticket-meta">
                <div class="tm-item"><small>Berangkat</small><span id="tck-dep">07:00</span></div>
                <div class="tm-item"><small>Tiba</small><span id="tck-arr">12:05</span></div>
                <div class="tm-item"><small>Kursi</small><span id="tck-seats">4A, 4B</span></div>
                <div class="tm-item"><small>Penumpang</small><span>2 orang</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <div class="card" style="margin-bottom:16px">
        <div class="card-body">
          <div class="card-title"><i class="ti ti-credit-card"></i>Metode Pembayaran</div>
          <div class="payment-option selected" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-building-bank"></i></div>
            <div>
              <div class="pay-title">Transfer Bank</div>
              <div class="pay-sub">BCA · Mandiri · BRI · BNI · BSI</div>
            </div>
            <div class="pay-radio"></div>
          </div>
          <div class="payment-option" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-device-mobile"></i></div>
            <div>
              <div class="pay-title">Dompet Digital</div>
              <div class="pay-sub">GoPay · OVO · Dana · ShopeePay</div>
            </div>
            <div class="pay-radio"></div>
          </div>
          <div class="payment-option" onclick="selPay(this)">
            <div class="pay-icon"><i class="ti ti-qrcode"></i></div>
            <div>
              <div class="pay-title">QRIS</div>
              <div class="pay-sub">Scan QR dari semua aplikasi e-wallet</div>
            </div>
            <div class="pay-radio"></div>
          </div>
        </div>
      </div>
 
      <div class="card">
        <div class="card-body">
          <div class="sum-row" style="font-size:13px"><span class="sum-label">Subtotal (2 tiket)</span><span class="sum-val">Rp 1.160.000</span></div>
          <div class="sum-row" style="font-size:13px"><span class="sum-label">Biaya layanan</span><span class="sum-val">Rp 20.000</span></div>
          <div class="sum-total" style="padding-top:14px"><span>Total Pembayaran</span><span class="sum-total-amt">Rp 1.180.000</span></div>
          <div style="display:flex;gap:12px;margin-top:16px">
            <button class="btn-outline" onclick="goPage('page-passenger',4)"><i class="ti ti-arrow-left"></i>Kembali</button>
            <button class="btn-primary" onclick="showSuccess()">
              <i class="ti ti-lock"></i>Bayar — Rp 1.180.000
            </button>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="summary-card">
        <div class="summary-header">
          <div class="summary-header-title"><i class="ti ti-clock" style="margin-right:6px"></i>Batas Waktu Pembayaran</div>
        </div>
        <div class="summary-body">
          <div class="countdown-box">
            <div class="countdown-num" id="cdnum">01:29:47</div>
            <div class="countdown-label">sebelum pesanan dibatalkan</div>
            <div class="countdown-bar"><div class="countdown-progress" id="cdprog"></div></div>
          </div>
          <div class="notice notice-warn" style="margin-top:4px">
            <i class="ti ti-alert-triangle"></i>Segera selesaikan pembayaran
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
<!-- PAGE SUCCESS -->
<div class="page" id="page-success">
  <div class="success-wrap">
    <div class="success-icon"><i class="ti ti-circle-check"></i></div>
    <div class="success-title">Pemesanan Berhasil!</div>
    <div class="success-sub">Tiket Anda sudah dikonfirmasi. Kode pemesanan:</div>
    <div class="booking-code">KAI-2026-08412</div>
    <div class="notice notice-ok" style="margin-bottom:24px;text-align:left">
      <i class="ti ti-mail-check"></i>E-tiket telah dikirim ke email dan WhatsApp Anda. Tunjukkan e-tiket saat boarding di stasiun.
    </div>
    <div class="success-actions">
      <button class="btn-outline"><i class="ti ti-download"></i>Unduh E-Tiket</button>
      <button class="btn-primary" style="width:auto;padding:0 24px" onclick="goPage('page-results',2)">
        <i class="ti ti-search"></i>Pesan Lagi
      </button>
    </div>
  </div>
</div>
 
</div><!-- .main -->
 
<script>
var pax=2, selPrice=580000, selSeats=[], selTrainName='Argo Bromo Anggrek';
var taken=['1C','2A','2D','3B','3C','4C','5A','5D','6B','7A','7C'];
var cdSecs=5387, cdTotal=5387;

document.addEventListener("DOMContentLoaded", function() {
    var btnKurang = document.getElementById('pax-kurang');
    var btnTambah = document.getElementById('pax-tambah');
    var txtPax = document.getElementById('pax-val');

    if (btnKurang && btnTambah && txtPax) {
        
        // Aksi ketika tombol MINUS diklik
        btnKurang.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Mencegah intervensi library luar
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax > 1) {
                var newPax = currentPax - 1;
                txtPax.textContent = newPax;
                pax = newPax; // Sinkronisasi ke variabel global pax aplikasi Velozza
            }
        });

        // Aksi ketika tombol PLUS diklik
        btnTambah.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Mencegah intervensi library luar
            
            var currentPax = parseInt(txtPax.textContent) || 1;
            if (currentPax < 6) {
                var newPax = currentPax + 1;
                txtPax.textContent = newPax;
                pax = newPax; // Sinkronisasi ke variabel global pax aplikasi Velozza
            }
        });
    }
});
 
function goPage(id, step){
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  document.querySelectorAll('.tstep').forEach((s,i)=>{
    s.classList.remove('active','done');
    if(i+1<step) s.classList.add('done');
    else if(i+1===step) s.classList.add('active');
  });
  window.scrollTo(0,0);
}
 
function swapSt(){
  var f=document.getElementById('from-inp'), t=document.getElementById('to-inp');
  var tmp=f.value; f.value=t.value; t.value=tmp;
}
 
function selTrain(el,name,cls,dep,arr,price,dur,stops){
  document.querySelectorAll('.train-card').forEach(c=>c.classList.remove('selected'));
  el.classList.add('selected');
  selTrainName=name; selPrice=parseInt(price);
  document.getElementById('btn-pilih-kereta').disabled=false;
  document.getElementById('seat-train-lbl').textContent=name+' · '+cls;
  document.getElementById('s-train').textContent=name.split(' ').slice(0,2).join(' ');
  document.getElementById('s2-train').textContent=name.split(' ').slice(0,2).join(' ');
  document.getElementById('s-price').textContent='Rp '+parseInt(price).toLocaleString('id-ID');
  document.getElementById('s-total').textContent='Rp '+(parseInt(price)*2).toLocaleString('id-ID');
  document.getElementById('tck-train').textContent=name;
  document.getElementById('tck-dep').textContent=dep;
  document.getElementById('tck-arr').textContent=arr;
  document.getElementById('tck-dur').textContent=dur;
  selSeats=[];
  buildSeats();
}
 
var routeData = {
  'Argo Bromo Anggrek': [
    {name:'Jakarta Gambir',time:'07:00 · Berangkat',type:'start'},
    {name:'Cirebon',time:'09:05 · Transit 3 menit',type:'mid'},
    {name:'Purwokerto',time:'10:45 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'12:05 · Tiba',type:'end'}
  ],
  'Taksaka Pagi': [
    {name:'Jakarta Gambir',time:'08:30 · Berangkat',type:'start'},
    {name:'Yogyakarta',time:'14:00 · Tiba',type:'end'}
  ],
  'Senja Utama YK': [
    {name:'Jakarta Gambir',time:'10:15 · Berangkat',type:'start'},
    {name:'Cirebon',time:'12:20 · Transit 5 menit',type:'mid'},
    {name:'Yogyakarta',time:'16:20 · Tiba',type:'end'}
  ],
  'Lodaya Pagi': [
    {name:'Jakarta Gambir',time:'06:00 · Berangkat',type:'start'},
    {name:'Bandung',time:'08:30 · Transit 5 menit',type:'mid'},
    {name:'Tasikmalaya',time:'10:10 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'14:30 · Tiba',type:'end'}
  ],
  'Gajayana': [
    {name:'Jakarta Gambir',time:'14:00 · Berangkat',type:'start'},
    {name:'Cirebon',time:'16:05 · Transit 3 menit',type:'mid'},
    {name:'Yogyakarta',time:'19:45 · Tiba',type:'end'}
  ]
};
 
function buildSeats(){
  var map=document.getElementById('seat-map');
  map.innerHTML='';
  for(var n=1;n<=8;n++){
    var row=document.createElement('div');
    row.className='seat-row';
    var lbl=document.createElement('div');
    lbl.className='seat-row-lbl';
    lbl.textContent=n;
    row.appendChild(lbl);
    ['A','B'].forEach(function(c){
      var id=n+c;
      var s=document.createElement('div');
      s.className='seat';
      if(taken.indexOf(id)>=0){s.classList.add('taken');s.innerHTML='<i class="ti ti-x" style="font-size:10px"></i>';}
      else if(selSeats.indexOf(id)>=0){s.classList.add('selected');s.textContent=id;}
      else{s.textContent=id;}
      s.onclick=(function(sid,el){return function(){toggleSeat(sid,el);};})(id,s);
      row.appendChild(s);
    });
    var aisle=document.createElement('div');
    aisle.className='seat-aisle';
    row.appendChild(aisle);
    ['C','D'].forEach(function(c){
      var id=n+c;
      var s=document.createElement('div');
      s.className='seat';
      if(taken.indexOf(id)>=0){s.classList.add('taken');s.innerHTML='<i class="ti ti-x" style="font-size:10px"></i>';}
      else if(selSeats.indexOf(id)>=0){s.classList.add('selected');s.textContent=id;}
      else{s.textContent=id;}
      s.onclick=(function(sid,el){return function(){toggleSeat(sid,el);};})(id,s);
      row.appendChild(s);
    });
    map.appendChild(row);
  }
  updateSeatUI();
}
 
function toggleSeat(id,el){
  if(el.classList.contains('taken')) return;
  var idx=selSeats.indexOf(id);
  if(idx>=0){selSeats.splice(idx,1);}
  else{
    if(selSeats.length>=2) selSeats.shift();
    selSeats.push(id);
  }
  buildSeats();
}
 
function updateSeatUI(){
  var txt=selSeats.length>0?selSeats.join(', '):'—';
  document.getElementById('s-seats').textContent=txt;
  document.getElementById('s2-seats').textContent=txt;
  document.getElementById('tck-seats').textContent=txt;
  if(selSeats[0]) document.getElementById('p1-seat').textContent=selSeats[0];
  if(selSeats[1]) document.getElementById('p2-seat').textContent=selSeats[1];
  var btn=document.getElementById('btn-lanjut-kursi');
  btn.disabled=selSeats.length!==2;
}
 
function switchGerbong(el,n){
  document.querySelectorAll('.gtab').forEach(g=>g.classList.remove('active'));
  el.classList.add('active');
  buildSeats();
}
 
function selPay(el){
  document.querySelectorAll('.payment-option').forEach(p=>p.classList.remove('selected'));
  el.classList.add('selected');
}
 
function showSuccess(){
  goPage('page-success',5);
  document.querySelectorAll('.tstep').forEach(s=>{s.classList.remove('active');s.classList.add('done');});
}
 
setInterval(function(){
  if(cdSecs<=0) return;
  cdSecs--;
  var h=Math.floor(cdSecs/3600), m=Math.floor((cdSecs%3600)/60), s=cdSecs%60;
  var el=document.getElementById('cdnum');
  if(el) el.textContent=(h?String(h).padStart(2,'0')+':':'')+String(m).padStart(2,'0')+':'+String(s).padStart(2,'0');
  var prog=document.getElementById('cdprog');
  if(prog) prog.style.width=Math.round(cdSecs/cdTotal*100)+'%';
},1000);
 
buildSeats();
</script>
</body>
</html>