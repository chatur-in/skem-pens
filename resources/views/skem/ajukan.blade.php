@php
    /* Prodi dikelompokkan per departemen, D3 ditampilkan lebih dulu */
    $grup = collect($studyPrograms)
        ->sortBy(fn ($p) => [$p->degree === 'D3' ? 0 : 1, $p->name])
        ->groupBy(fn ($p) => $p->department?->name ?? 'Program Lainnya')
        ->sortKeys();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Ajukan SKEM PENS – Sistem Pengajuan Satuan Kredit Ekstrakurikuler</title>
@include('partials.favicon')
<meta name="description" content="Ajukan klaim poin SKEM PENS: isi data kegiatan, unggah formulir verifikasi dan bukti, lalu pantau status pengajuan.">
@vite(['resources/css/skem/ajukan.css'])
</head>
<body>
<script>document.documentElement.classList.add('js')</script>

<!-- Sprite ikon + logo (inline, tidak perlu file terpisah) -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<symbol id="i-back" viewBox="0 0 24 24"><path d="M19 12H5M11 18l-6-6 6-6"/></symbol>
<symbol id="i-next" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
<symbol id="i-up" viewBox="0 0 24 24"><path d="M12 16V4M7 9l5-5 5 5M4 20h16"/></symbol>
<symbol id="i-doc" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><path d="M9 11l3 3 8-8"/><path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9"/></symbol>
<symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></symbol>
<symbol id="i-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></symbol>
<symbol id="i-send" viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></symbol>
<symbol id="i-akt" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></symbol>
</defs></svg>

<nav class="nav" aria-label="Navigasi utama"><div class="w nv">
  <a class="brand" href="{{ url('/') }}" aria-label="Kembali ke beranda SKEM PENS"><i><img src="{{ asset('images/logo-pens.svg') }}" alt="" width="36" height="36"></i><span class="bt"><b>SKEM <span>PENS</span></b><small>Satuan Kredit Ekstrakurikuler Mahasiswa</small></span></a>
  <a class="btn g" href="{{ url('/') }}"><svg class="ico"><use href="#i-back"/></svg> Beranda</a>
</div></nav>

<header class="hero"><div class="meteors" aria-hidden="true"></div><div class="w">
  <div class="crumbs rv"><a href="{{ url('/') }}">Beranda</a><svg class="ico"><use href="#i-next"/></svg><span>Pengajuan SKEM</span></div>
  <h1 class="rv">Ajukan <em>Klaim SKEM</em></h1>
  <p class="sub rv">Lengkapi data kegiatan, unggah formulir dan bukti pendukung resmi.<br>Klaim poin SKEM dapat diajukan maksimal 1 tahun setelah kegiatan.</p>
  <div class="chips rv">
    <span class="chip"><svg class="ico"><use href="#i-check"/></svg>4 langkah singkat</span>
    <span class="chip"><svg class="ico"><use href="#i-lock"/></svg>Data tersimpan otomatis</span>
    <span class="chip"><svg class="ico"><use href="#i-up"/></svg>Maks. 1 tahun setelah kegiatan</span>
  </div>
</div></header>

<div class="w" style="position:relative;z-index:2;margin-top:-56px;padding-bottom:60px">
  <div class="card rv">
    <ol class="steps" id="steps">
      <li class="act" data-s="1"><span>Identitas</span></li>
      <li data-s="2"><span>Kegiatan &amp; Poin</span></li>
      <li data-s="3"><span>Lampiran</span></li>
      <li data-s="4"><span>Pernyataan &amp; Kirim</span></li>
    </ol>

    <!-- PANE 1 : IDENTITAS -->
    <section class="pane on" id="pane1" aria-label="Langkah 1: Identitas mahasiswa">
      <h3 class="pt">Identitas Mahasiswa</h3>
      <p class="pm">Pastikan data sesuai dengan data akademik KTM.</p>
      <div class="idbanner" id="idBanner" hidden><svg class="ico"><use href="#i-check"/></svg><span>Data identitas diisi otomatis dari pengajuan sebelumnya.</span><button type="button" id="idClear">Kosongkan</button></div>
      <div class="subh">Data diri</div>
      <div class="grid2">
        <div class="fld"><label for="nama">Nama lengkap *</label><input id="nama" placeholder="Sesuai KTM" autocomplete="name"><p class="err">Nama wajib diisi.</p></div>
        <div class="fld"><label for="nrp">NRP * <small>(10 digit)</small></label><input id="nrp" maxlength="10" inputmode="numeric" pattern="[0-9]*" placeholder="31256xxxxx"><p class="hint" id="nrpHint"><span></span><b id="nrpCount">0/10</b></p><p class="err">NRP harus 10 digit angka.</p></div>
      </div>
      <div class="subh">Program studi &amp; departemen</div>
      <div class="grid2">
        <div class="fld">
          <label for="prodi">Program studi *</label>
          <select id="prodi" name="study_program_id">
            <option value="">— Pilih Program Studi —</option>
            @foreach($grup as $dept => $items)
              <optgroup label="{{ $dept }}">
                @foreach($items as $prodi)
                  <option value="{{ $prodi->id }}" data-dept="{{ $dept }}">{{ $prodi->name }}</option>
                @endforeach
              </optgroup>
            @endforeach
          </select>
          <p class="err">Program studi wajib dipilih.</p>
        </div>
        <div class="fld">
          <label for="dept">Departemen</label>
          <input id="dept" name="department_name" readonly tabindex="-1" placeholder="Terisi otomatis dari program studi">
          <p class="hint">Mengikuti program studi yang dipilih.</p>
        </div>
      </div>
      <div class="pnav"><span></span><button class="btn y" data-go="2" type="button">Lanjut: Kegiatan <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 2 : KEGIATAN & POIN -->
    <section class="pane" id="pane2" aria-label="Langkah 2: Informasi kegiatan dan estimasi poin">
      <h3 class="pt">Informasi Kegiatan</h3>
      <p class="pm">Pilih komponen dan jenis kegiatan. Estimasi poin mengacu pada pedoman SKEM PENS resmi.</p>
      <div class="subh">Komponen SKEM *</div>
      <div class="komp-hint on" id="kompHint"><svg class="ico"><use href="#i-akt"/></svg>Pilih salah satu komponen untuk membuka jenis kegiatan.</div>
      <div class="komp" id="komp">
        <button type="button" class="kopt" data-k="1"><b>Kredit 1</b><small>Interpersonal &amp; Manajerial — ditentukan kampus (PKKMB, OPP, LKMM)</small></button>
        <button type="button" class="kopt" data-k="2"><b>Kredit 2</b><small>Pengembangan Spiritual — ditentukan kampus (mentoring keagamaan)</small></button>
        <button type="button" class="kopt" data-k="3"><b>Kredit 3</b><small>Minat, Bakat, Organisasi &amp; Kompetisi — pilihan bebas mahasiswa</small></button>
      </div>
      <div class="subh">Detail kegiatan</div>
      <div class="fld"><label for="jenis">Jenis kegiatan *</label><select id="jenis" disabled><option value="">Pilih komponen terlebih dahulu</option></select><p class="err">Jenis kegiatan wajib dipilih.</p></div>
      <div class="subh">Penilaian</div>
      <div class="grid2">
        <div class="fld"><label for="peran">Peran / perolehan *</label><select id="peran" disabled><option value="">Pilih jenis kegiatan terlebih dahulu</option></select><p class="err">Peran wajib dipilih.</p></div>
        <div class="fld"><label for="poin">Estimasi poin SKEM</label><div class="poinv"><input id="poin" readonly value="—"><span>poin</span></div><p class="hint">Ditentukan otomatis dari pedoman resmi PENS. Nilai final oleh verifikator.</p></div>
      </div>
      <div class="pnav"><button class="btn o" data-go="1" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button><button class="btn y" data-go="3" type="button">Lanjut: Lampiran <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 3 : LAMPIRAN -->
    <section class="pane" id="pane3" aria-label="Langkah 3: Lampiran bukti">
      <h3 class="pt">Lampiran Bukti</h3>
      
      <div class="upl-info-card">
        <svg class="ico"><use href="#i-doc"/></svg>
        <span>Pastikan dokumen terbaca dengan jelas. Maksimal ukuran file <strong>5 MB</strong> per dokumen.</span>
      </div>

      <div class="fld lamp" id="fldForm">
        <div class="lamp-head"><div class="tt"><span class="no">1</span>Formulir kegiatan SKEM (PDF)</div><div style="display:flex;gap:8px;align-items:center"><span class="cnt" id="cntForm">0/1 file</span><span class="req" id="reqForm">Wajib</span></div></div>
        <div class="upl-box">
          <div class="upl-icon"><svg class="ico"><use href="#i-doc"/></svg></div>
          <div class="upl-title">Klik atau tarik file PDF formulir ke sini</div>
          <div class="upl-sub">Format PDF · Maksimal 5 MB</div>
          <input type="file" id="fFormulir" accept="application/pdf,.pdf">
        </div>
        <ul class="files" id="listFormulir"></ul>
        <p class="err" id="errFormulir" style="display:none">Formulir PDF wajib dilampirkan.</p>
      </div>

      <div class="lamp-sep"></div>

      <div class="fld lamp" id="fldBukti">
        <div class="lamp-head"><div class="tt"><span class="no">2</span>Bukti kegiatan <span style="font-weight:500;color:var(--mute)">(sertifikat / piagam / dokumentasi)</span></div><div style="display:flex;gap:8px;align-items:center"><span class="cnt" id="cntBukti">0/6 file</span><span class="req" id="reqBukti">Wajib</span></div></div>
        <div class="upl-box">
          <div class="upl-icon"><svg class="ico"><use href="#i-up"/></svg></div>
          <div class="upl-title">Klik atau tarik bukti kegiatan ke sini</div>
          <div class="upl-sub">Format JPG, PNG, atau PDF · Maks. 6 file (masing-masing 5 MB)</div>
          <input type="file" id="fBukti" accept="image/*,.jpg,.jpeg,.png,.webp,.pdf" multiple>
        </div>
        <ul class="files" id="listBukti"></ul>
        <p class="err" id="errBukti" style="display:none">Minimal 1 bukti kegiatan wajib dilampirkan.</p>
      </div>

      <div class="pnav"><button class="btn o" data-go="2" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button><button class="btn y" data-go="4" type="button">Lanjut: Pernyataan <svg class="ico"><use href="#i-next"/></svg></button></div>
    </section>

    <!-- PANE 4 : PERNYATAAN & KIRIM -->
    <section class="pane" id="pane4" aria-label="Langkah 4: Pernyataan dan kirim">
      <h3 class="pt">Ringkasan &amp; Pernyataan</h3>
      <p class="pm">Periksa kembali ringkasan pengajuan Anda sebelum menyetujui dan mengirimkan data.</p>
      
      <div id="ringkas"></div>

      <div class="fld stmt-wrap" style="margin-top:22px">
        <label class="stmt" id="chkStmt">
          <input type="checkbox" id="setuju">
          <span class="stmt-txt"><b>Pernyataan keabsahan data</b>Saya menyatakan bahwa seluruh data dan berkas dokumen yang dilampirkan adalah benar, sah, serta dapat dipertanggungjawabkan. Apabila di kemudian hari ditemukan ketidaksesuaian data, saya bersedia menerima sanksi akademik sesuai ketentuan kampus PENS yang berlaku.</span>
        </label>
        <p class="err" id="errSetuju" style="display:none;margin-top:8px">Anda wajib menyetujui pernyataan keabsahan data sebelum mengirim pengajuan.</p>
      </div>

      <div class="pnav">
        <button class="btn o" data-go="3" type="button"><svg class="ico"><use href="#i-back"/></svg> Kembali</button>
        <button class="btn-submit" id="kirim" type="button">
          <span class="btn-txt">Kirim Pengajuan SKEM</span>
          <svg class="ico ico-send"><use href="#i-send"/></svg>
          <span class="spin-ico"></span>
        </button>
      </div>
    </section>
  </div>
</div>

<div class="ov" id="ovOk" role="dialog" aria-modal="true"><div class="ovbox">
  <div class="ckr"><svg class="ico"><use href="#i-check"/></svg></div>
  <h3>Pengajuan berhasil dikirim!</h3>
  <p>Pengajuan Anda akan diproses dan diverifikasi oleh verifikator serta validator SKEM PENS.</p>
  <p id="regNo" hidden style="margin-top:10px;font-weight:800;color:var(--b)"></p>
  <div style="display:flex;gap:10px;margin-top:20px"><button class="btn o" id="ovLagi" style="flex:1;justify-content:center">Ajukan Lagi</button><button class="btn y" id="ovClose" style="flex:1;justify-content:center">Pantau Status</button></div>
</div></div>

<footer><div class="w fwrap"><span><b>SKEM PENS</b> — Politeknik Elektronika Negeri Surabaya</span><p>Alat bantu mahasiswa. Selalu rujuk pedoman SKEM resmi kampus untuk ketentuan terbaru.</p></div></footer>
<div id="toast" role="status"></div>

<script>
window.SKEM_CFG = {
    storeUrl: @json(route('skem.store')),
    trackUrl: @json(route('skem.track')),
    csrf: @json(csrf_token()),
};
</script>
<script>
@verbatim
/* Katalog poin resmi — Pedoman SKEM PENS.
   Format: SKEM_POIN[komponen].items[jenis] = [[peran, poin], ...]
   Hanya untuk tampilan/estimasi; nilai final tetap dihitung & divalidasi di server. */
window.SKEM_POIN = {
  1: { label:'Kredit 1 — Interpersonal & Manajerial', items:{
    'PKKMB (Pengenalan Kehidupan Kampus Mahasiswa Baru)': [['Peserta', 0.35]],
    'OPP (Orientasi Program Pendidikan)': [['Peserta', 0.20]],
    'LKMM Pra-TD (Pra-Tahap Dasar)': [['Peserta', 0.30]],
    'LKMM TD (Tahap Dasar)': [['Peserta', 0.40]]
  }},
  2: { label:'Kredit 2 — Pengembangan Spiritual', items:{
    'Mentoring Keagamaan (1 Semester)': [['Peserta / Mentee', 0.50]]
  }},
  3: { label:'Kredit 3 — Minat, Bakat, Organisasi & Kompetisi', items:{
    // A. Organisasi dan Kepemimpinan
    'Pengurus Organisasi (Internasional)': [['Ketua (1 Periode)', 1.50], ['Wakil Ketua (1 Periode)', 1.30], ['Pengurus Inti Lain (1 Periode)', 1.00], ['Anggota Pengurus (1 Periode)', 0.60]],
    'Pengurus Organisasi (Nasional)': [['Ketua (1 Periode)', 1.20], ['Wakil Ketua (1 Periode)', 1.00], ['Pengurus Inti Lain (1 Periode)', 0.80], ['Anggota Pengurus (1 Periode)', 0.50]],
    'Pengurus Organisasi (Kampus)': [['Ketua (1 Periode)', 1.00], ['Wakil Ketua (1 Periode)', 0.80], ['Pengurus Inti Lain (1 Periode)', 0.60], ['Anggota Pengurus (1 Periode)', 0.40]],
    'Pengurus Organisasi (Hima / Prodi)': [['Ketua (1 Periode)', 0.90], ['Wakil Ketua (1 Periode)', 0.70], ['Pengurus Inti Lain (1 Periode)', 0.50], ['Anggota Pengurus (1 Periode)', 0.30]],
    'Pengurus UKM / Tim Kompetisi': [['Ketua (1 Periode)', 0.90], ['Wakil Ketua (1 Periode)', 0.70], ['Pengurus Inti Lain (1 Periode)', 0.50], ['Anggota Pengurus (1 Periode)', 0.30]],
    'Pengurus BSO (Program Studi)': [['Ketua (1 Periode)', 0.70], ['Wakil Ketua (1 Periode)', 0.50], ['Pengurus Inti Lain (1 Periode)', 0.30], ['Anggota Pengurus (1 Periode)', 0.20]],
    'Panitia Kegiatan (Internasional)': [['Ketua (1 Kegiatan)', 1.20], ['Wakil Ketua (1 Kegiatan)', 1.10], ['Panitia Inti Lain (1 Kegiatan)', 0.60], ['Anggota Panitia (1 Kegiatan)', 0.40]],
    'Panitia Kegiatan (Nasional)': [['Ketua (1 Kegiatan)', 1.00], ['Wakil Ketua (1 Kegiatan)', 0.90], ['Panitia Inti Lain (1 Kegiatan)', 0.50], ['Anggota Panitia (1 Kegiatan)', 0.30]],
    'Panitia Kegiatan (Kampus)': [['Ketua (1 Kegiatan)', 0.70], ['Wakil Ketua (1 Kegiatan)', 0.50], ['Panitia Inti Lain (1 Kegiatan)', 0.30], ['Anggota Panitia (1 Kegiatan)', 0.10]],
    'Panitia Kegiatan (Prodi)': [['Ketua (1 Kegiatan)', 0.30], ['Wakil Ketua (1 Kegiatan)', 0.20], ['Panitia Inti Lain (1 Kegiatan)', 0.10], ['Anggota Panitia (1 Kegiatan)', 0.05]],
    'Pelatihan LKMM Lanjut / Menengah': [['Peserta LKMM Lanjut', 0.70], ['Peserta LKMM Menengah', 0.60]],

    // B. Penalaran, Kreativitas & Kewirausahaan
    'Lomba Karya Ilmiah / Inovasi (Internasional)': [['Juara I', 1.50], ['Juara II', 1.40], ['Juara III', 1.30], ['Penghargaan Lain', 1.00], ['Peserta', 0.60]],
    'Lomba Karya Ilmiah / Inovasi (Nasional)': [['Juara I', 1.20], ['Juara II', 1.10], ['Juara III', 1.00], ['Penghargaan Lain', 0.60], ['Peserta', 0.40]],
    'Lomba Karya Ilmiah / Inovasi (Regional)': [['Juara I', 0.80], ['Juara II', 0.70], ['Juara III', 0.60], ['Penghargaan Lain', 0.50], ['Peserta', 0.20]],
    'Lomba Karya Ilmiah / Inovasi (Kampus)': [['Juara I', 0.60], ['Juara II', 0.50], ['Juara III', 0.40], ['Penghargaan Lain', 0.30], ['Peserta', 0.10]],
    'Pendanaan Proposal (Penelitian / PKM)': [['Ketua (Internasional)', 0.90], ['Anggota (Internasional)', 0.30], ['Ketua (Nasional)', 0.70], ['Anggota (Nasional)', 0.20], ['Ketua (Regional)', 0.50], ['Anggota (Regional)', 0.15], ['Ketua (Kampus)', 0.40], ['Anggota (Kampus)', 0.10]],
    'Forum Ilmiah / Seminar (Internasional)': [['Pembicara', 1.50], ['Moderator', 0.60], ['Peserta Luring', 0.25], ['Peserta Daring', 0.20]],
    'Forum Ilmiah / Seminar (Nasional)': [['Pembicara', 1.30], ['Moderator', 0.50], ['Peserta Luring', 0.20], ['Peserta Daring', 0.15]],
    'Forum Ilmiah / Seminar (Regional)': [['Pembicara', 1.10], ['Moderator', 0.40], ['Peserta Luring', 0.15], ['Peserta Daring', 0.10]],
    'Forum Ilmiah / Seminar (Kampus)': [['Pembicara', 0.90], ['Moderator', 0.30], ['Peserta Luring', 0.10], ['Peserta Daring', 0.05]],
    'Workshop / Pelatihan (Internasional)': [['Pembicara', 1.10], ['Moderator', 0.50], ['Peserta Luring', 0.25], ['Peserta Daring', 0.20]],
    'Workshop / Pelatihan (Nasional)': [['Pembicara', 0.90], ['Moderator', 0.40], ['Peserta Luring', 0.20], ['Peserta Daring', 0.15]],
    'Workshop / Pelatihan (Regional)': [['Pembicara', 0.70], ['Moderator', 0.30], ['Peserta Luring', 0.15], ['Peserta Daring', 0.10]],
    'Workshop / Pelatihan (Kampus)': [['Pembicara', 0.50], ['Moderator', 0.20], ['Peserta Luring', 0.10], ['Peserta Daring', 0.05]],
    'Hak Cipta (IPTEK)': [['Ketua', 0.20], ['Anggota', 0.10]],
    'Paten / Desain Industri': [['Ketua', 1.00], ['Anggota', 0.30]],
    'Publikasi Jurnal Ilmiah': [['Ketua (Internasional Bereputasi)', 1.20], ['Anggota (Internasional Bereputasi)', 0.80], ['Ketua (Nasional S1-S2)', 0.80], ['Anggota (Nasional S1-S2)', 0.40], ['Ketua (Nasional S3-S4)', 0.60], ['Anggota (Nasional S3-S4)', 0.30], ['Ketua (Nasional S5-S6)', 0.40], ['Anggota (Nasional S5-S6)', 0.20], ['Ketua (Tidak Terakreditasi)', 0.30], ['Anggota (Tidak Terakreditasi)', 0.10]],
    'Konferensi Ilmiah': [['Ketua (Internasional Bereputasi)', 0.80], ['Anggota (Internasional Bereputasi)', 0.40], ['Ketua (Internasional)', 0.60], ['Anggota (Internasional)', 0.30], ['Ketua (Nasional)', 0.40], ['Anggota (Nasional)', 0.10]],
    'Mahasiswa Berprestasi (Mawapres)': [['Juara I (Nasional)', 1.20], ['Juara II (Nasional)', 1.10], ['Juara III (Nasional)', 1.00], ['Penghargaan Lain (Nasional)', 0.60], ['Juara I (Regional)', 0.80], ['Juara II (Regional)', 0.70], ['Juara III (Regional)', 0.60], ['Penghargaan Lain (Regional)', 0.50], ['Juara I (Kampus)', 0.60], ['Juara II (Kampus)', 0.50], ['Juara III (Kampus)', 0.40], ['Penghargaan Lain (Kampus)', 0.30]],
    'Wirausaha Mandiri': [['Ketua PT', 1.20], ['Anggota PT', 0.50], ['Ketua CV', 0.90], ['Anggota CV', 0.30], ['Ketua UD', 0.70], ['Anggota UD', 0.10], ['Ketua Usaha Mandiri', 0.50], ['Anggota Usaha Mandiri', 0.05]],

    // C. Minat dan Bakat
    'Prestasi Minat & Bakat (Olahraga, Seni, Kerohanian)': [['Juara I (Internasional)', 1.50], ['Juara II (Internasional)', 1.40], ['Juara III (Internasional)', 1.30], ['Penghargaan Lain (Internasional)', 1.00], ['Peserta (Internasional)', 0.60], ['Juara I (Nasional)', 1.20], ['Juara II (Nasional)', 1.10], ['Juara III (Nasional)', 1.00], ['Penghargaan Lain (Nasional)', 0.60], ['Peserta (Nasional)', 0.40], ['Juara I (Regional)', 0.80], ['Juara II (Regional)', 0.70], ['Juara III (Regional)', 0.60], ['Penghargaan Lain (Regional)', 0.50], ['Peserta (Regional)', 0.20], ['Juara I (Kampus)', 0.60], ['Juara II (Kampus)', 0.50], ['Juara III (Kampus)', 0.40], ['Penghargaan Lain (Kampus)', 0.30], ['Peserta (Kampus)', 0.10]],
    'Pelatih / Pembimbing Minat Bakat': [['Nasional', 0.80], ['Regional', 0.60], ['Kampus', 0.30], ['Sekolah', 0.20]],
    'Karya Seni (Konser, Pameran, Puisi, Foto, Teater)': [['Nasional', 1.10], ['Regional', 0.90], ['Kampus', 0.70]],

    // D. Kegiatan Lainnya
    'Upacara Bendera': [['Peserta / Petugas', 0.10]],
    'Tim PPK PENS (1 Semester)': [['Anggota Tim', 0.35]],
    'Pemadu LKMM': [['Pemadu', 0.40]],
    'Asisten Peneliti / Laboratorium (1 Semester)': [['Asisten', 0.35]],
    'Mentor Keagamaan (1 Periode Mentoring)': [['Mentor', 0.50]]
  }}
};

/* Wizard pengajuan SKEM — dipindahkan dari skem-ajukan.html, dihubungkan ke Laravel. */
const $ = id => document.getElementById(id);
const toastEl = $('toast'); let tm;
const toast = m => { toastEl.textContent = m; toastEl.classList.add('on'); clearTimeout(tm); tm = setTimeout(() => toastEl.classList.remove('on'), 2400); };

/* ================= DATA POIN RESMI (Pedoman SKEM PENS) ================= */
const POIN = window.SKEM_POIN;
const FIDS = ['nama','nrp','prodi'];
const CFG = window.SKEM_CFG || {};
const esc = s => String(s ?? '').replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));

let komponen = 0, filesFormulir = [], filesBukti = [];

function prodiValue(){ return $('prodi').value; }
function prodiText(){ const o=$('prodi').selectedOptions[0]; return (o && o.value) ? o.textContent.trim() : ''; }
function deptValue(){ return $('dept').value.trim(); }
/* Departemen diisi otomatis dari program studi yang dipilih */
function syncDept(){ const o=$('prodi').selectedOptions[0]; $('dept').value = (o && o.dataset.dept) ? o.dataset.dept : ''; }

/* ================= DROPDOWN KUSTOM ================= */
const CS_ICON='<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
let csOpen=null;

function csReveal(c,el){
  const lr=c.list.getBoundingClientRect(), er=el.getBoundingClientRect();
  if(er.top<lr.top) c.list.scrollTop-=(lr.top-er.top);
  else if(er.bottom>lr.bottom) c.list.scrollTop+=(er.bottom-lr.bottom);
}

function csVisible(c){ return c.items.filter(x=>!x.opts && x.el.style.display!=='none'); }

function csFilter(c){
  const q=c.search.value.trim().toLowerCase();
  let any=false;
  c.items.forEach(x=>{
    if(x.opts){ const hit=x.opts.some(o=>!q||o.text.includes(q)); x.el.style.display=hit?'':'none'; }
  });
  c.items.forEach(x=>{
    if(!x.opts){ const show=!q||x.text.includes(q); x.el.style.display=show?'':'none'; if(show) any=true; }
  });
  c.empty.style.display=any?'none':'block';
  c.active=-1;
  csVisible(c).forEach(x=>x.el.classList.remove('act'));
}

function csRefresh(sel){
  const c=sel._cs; if(!c) return;
  c.box.innerHTML=''; c.items=[];
  const addOpt=(o,grp)=>{
    const d=document.createElement('div');
    d.className='cs-opt'+(o.value===''?' ph':'')+(o.value==='__lain'?' lain':'');
    d.textContent=o.textContent; d.dataset.i=o.index; d.setAttribute('role','option');
    c.box.appendChild(d);
    const it={el:d,i:o.index,text:o.textContent.toLowerCase(),grp};
    c.items.push(it); if(grp) grp.opts.push(it);
  };
  for(const ch of sel.children){
    if(ch.tagName==='OPTGROUP'){
      const h=document.createElement('div'); h.className='cs-grp'; h.textContent=ch.label;
      c.box.appendChild(h);
      const grp={el:h,opts:[]}; c.items.push(grp);
      for(const o of ch.children) addOpt(o,grp);
    } else if(ch.tagName==='OPTION') addOpt(ch,null);
  }
  c.box.appendChild(c.empty);
  const cur=sel.selectedIndex, o=sel.options[cur];
  c.items.forEach(x=>{ if(!x.opts && x.i===cur) x.el.classList.add('sel'); });
  c.val.textContent=o?o.textContent:'';
  c.val.classList.toggle('ph', !sel.value);
  c.btn.disabled=sel.disabled;
  c.wrap.classList.toggle('dis', sel.disabled);
  c.search.parentNode.style.display = sel.options.length>8 ? '' : 'none';
  csFilter(c);
}

function csChoose(sel,i){
  const c=sel._cs;
  sel.selectedIndex=i;
  sel.dispatchEvent(new Event('change',{bubbles:true}));
  csClose(sel); c.btn.focus({preventScroll:true});
}

function csPlace(sel){
  const c=sel._cs, r=c.btn.getBoundingClientRect(), L=c.list;
  const below=window.innerHeight-r.bottom-16, above=r.top-84;
  const want=Math.min(300, L.scrollHeight+14);
  const up = below<want && above>below;
  L.style.left=r.left+'px'; L.style.width=r.width+'px';
  if(up){ L.style.top='auto'; L.style.bottom=(window.innerHeight-r.top+4)+'px'; L.style.maxHeight=Math.max(140,Math.min(300,above))+'px'; }
  else { L.style.bottom='auto'; L.style.top=(r.bottom+4)+'px'; L.style.maxHeight=Math.max(140,Math.min(300,below))+'px'; }
  c.wrap.classList.toggle('up', up);
}

function csClose(sel){
  const c=sel._cs; if(!c) return;
  c.wrap.classList.remove('open'); c.btn.setAttribute('aria-expanded','false');
  c.list.classList.remove('on');
  c.wrap.appendChild(c.list); c.list.removeAttribute('style');
  c.search.value=''; csFilter(c);
  if(csOpen===sel) csOpen=null;
}

function csOpenList(sel){
  if(sel.disabled) return;
  if(csOpen && csOpen!==sel) csClose(csOpen);
  const c=sel._cs;
  // Daftar dipindah ke <body> dan diposisikan tetap di bawah/atas tombol,
  // sehingga tidak tertutup oleh bagian form di sekitarnya
  document.body.appendChild(c.list);
  c.list.classList.add('on');
  c.list.style.position='fixed'; c.list.style.zIndex='1000';
  c.wrap.classList.add('open'); c.btn.setAttribute('aria-expanded','true'); csOpen=sel;
  c.list.scrollTop=0;
  csPlace(sel);
  const vis=csVisible(c);
  const idx=vis.findIndex(x=>x.i===sel.selectedIndex);
  csSetActive(c, idx);
  if(c.search.parentNode.style.display!=='none') c.search.focus({preventScroll:true});
  const selEl=c.items.find(x=>!x.opts && x.i===sel.selectedIndex);
  if(selEl) csReveal(c, selEl.el);
}

window.addEventListener('resize', ()=>{ if(csOpen) csPlace(csOpen); });
window.addEventListener('scroll', e=>{
  if(csOpen && !csOpen._cs.list.contains(e.target)) csPlace(csOpen);
}, true);

function csSetActive(c,n){
  const vis=csVisible(c);
  vis.forEach(x=>x.el.classList.remove('act'));
  if(!vis.length){ c.active=-1; return; }
  c.active=Math.max(0,Math.min(vis.length-1,n));
  vis[c.active].el.classList.add('act');
  csReveal(c, vis[c.active].el);
}

function csKey(sel,e){
  const c=sel._cs;
  const isOpen=c.wrap.classList.contains('open');
  if(e.key==='ArrowDown'||e.key==='ArrowUp'){
    e.preventDefault();
    if(!isOpen){ csOpenList(sel); return; }
    csSetActive(c, c.active + (e.key==='ArrowDown'?1:-1));
  } else if(e.key==='Enter'){
    if(isOpen){
      e.preventDefault();
      const vis=csVisible(c);
      if(c.active>=0 && vis[c.active]) csChoose(sel, vis[c.active].i);
      else csClose(sel);
    }
  } else if(e.key==='Escape'){
    if(isOpen){ e.preventDefault(); csClose(sel); c.btn.focus({preventScroll:true}); }
  } else if(e.key==='Home'||e.key==='End'){
    if(isOpen && e.target===c.btn){ e.preventDefault(); csSetActive(c, e.key==='Home'?0:csVisible(c).length-1); }
  }
}

function csInit(sel){
  if(sel._cs) return;
  const wrap=document.createElement('div'); wrap.className='cs';
  sel.parentNode.insertBefore(wrap, sel); wrap.appendChild(sel);
  sel.classList.add('cs-native'); sel.tabIndex=-1; sel.setAttribute('aria-hidden','true');

  const btn=document.createElement('button');
  btn.type='button'; btn.className='cs-btn'; btn.id=sel.id+'-cs';
  btn.setAttribute('aria-haspopup','listbox'); btn.setAttribute('aria-expanded','false');
  const val=document.createElement('span'); val.className='cs-val';
  btn.append(val); btn.insertAdjacentHTML('beforeend', CS_ICON);

  const list=document.createElement('div'); list.className='cs-list'; list.setAttribute('role','listbox');
  const sbox=document.createElement('div'); sbox.className='cs-sbox';
  const search=document.createElement('input'); search.type='search'; search.placeholder='Cari pilihan…'; search.autocomplete='off';
  sbox.appendChild(search);
  const box=document.createElement('div');
  const empty=document.createElement('div'); empty.className='cs-empty'; empty.textContent='Tidak ada pilihan yang cocok';
  list.append(sbox, box);
  wrap.append(btn, list);

  const lbl=document.querySelector('label[for="'+sel.id+'"]'); if(lbl) lbl.htmlFor=btn.id;

  sel._cs={wrap,btn,val,list,search,box,empty,items:[],active:-1};
  const c=sel._cs;
  wrap._close=()=>csClose(sel);

  // Sinkronkan tampilan setiap kali nilai/opsi berubah (termasuk perubahan lewat script)
  const vDesc=Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype,'value');
  const iDesc=Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype,'selectedIndex');
  Object.defineProperty(sel,'value',{configurable:true,get(){return vDesc.get.call(this)},set(v){vDesc.set.call(this,v);csRefresh(this)}});
  Object.defineProperty(sel,'selectedIndex',{configurable:true,get(){return iDesc.get.call(this)},set(v){iDesc.set.call(this,v);csRefresh(this)}});
  new MutationObserver(()=>csRefresh(sel)).observe(sel,{childList:true,subtree:true,characterData:true,attributes:true,attributeFilter:['disabled']});

  btn.addEventListener('click',()=>{ c.wrap.classList.contains('open') ? csClose(sel) : csOpenList(sel); });
  btn.addEventListener('keydown',e=>csKey(sel,e));
  search.addEventListener('input',()=>csFilter(c));
  search.addEventListener('keydown',e=>csKey(sel,e));
  box.addEventListener('click',e=>{
    const d=e.target.closest('.cs-opt'); if(d) csChoose(sel, +d.dataset.i);
  });
  csRefresh(sel);
}

document.querySelectorAll('select').forEach(csInit);
document.addEventListener('mousedown',e=>{
  if(csOpen && !csOpen._cs.wrap.contains(e.target) && !csOpen._cs.list.contains(e.target)) csClose(csOpen);
});

/* ================= RESTORE FORM ================= */
try{
  const s = JSON.parse(localStorage.getItem('skemAjuanForm')||'{}');
  FIDS.forEach(i=>{ if(s[i]!==undefined && !(i==='prodi' && s[i]==='')) $(i).value=s[i]; });
  syncDept();
  if(s.komponen){
    setKomponen(+s.komponen);
    if(s.jenis){ $('jenis').value=s.jenis; fillPeran(s.jenis, s.peran); }
  }
}catch(e){}

function saveForm(){
  try{
    const o={};
    FIDS.forEach(i=>o[i]=$(i).value);
    o.komponen=komponen;
    o.jenis=$('jenis').value;
    o.peran=$('peran').value;
    localStorage.setItem('skemAjuanForm', JSON.stringify(o));
  }catch(e){}
}
FIDS.forEach(i => $(i).addEventListener('input', saveForm));

/* ===== FORM 1 IDENTITAS: banner data tersimpan & penghitung NRP ===== */
function updNrp(){ const n=$('nrp').value.length; $('nrpCount').textContent=n+'/10'; $('nrpCount').style.color=n===10?'var(--ok)':''; }
$('nrp').addEventListener('input', updNrp);
if(($('nama').value||$('nrp').value)) $('idBanner').hidden=false;
$('idClear').addEventListener('click', () => {
  $('nama').value=''; $('nrp').value='';
  $('prodi').value=''; syncDept();
  updNrp(); saveForm(); $('idBanner').hidden=true; $('nama').focus();
});
updNrp();

/* ================= STEPPER ================= */
let cur = 1;
function go(n){
  if(n > cur && !validate(cur)) return;
  const back = n < cur;
  cur = n;
  document.querySelectorAll('.pane').forEach(p => p.classList.remove('on','back'));
  $('pane'+n).classList.add('on');
  $('pane'+n).classList.toggle('back', back);
  document.querySelectorAll('#steps li').forEach(li => {
    const s = +li.dataset.s;
    li.classList.toggle('act', s === n);
    li.classList.toggle('done', s < n);
  });
  if(n === 4) renderRingkas();
  window.scrollTo({ top: document.querySelector('.card').offsetTop - 80, behavior:'smooth' });
}
document.querySelectorAll('[data-go]').forEach(b => b.addEventListener('click', () => go(+b.dataset.go)));

function markBad(id, bad){ $(id).closest('.fld')?.classList.toggle('bad', bad); if(!$(id).closest('.fld')) $(id).classList.toggle('bad', bad); return bad; }
function validate(n){
  let ok = true;
  if(n === 1){
    ok = !markBad('nama', !$('nama').value.trim()) && ok;
    ok = !markBad('nrp', !/^\d{10}$/.test($('nrp').value.trim())) && ok;
    ok = !markBad('prodi', !prodiValue()) && ok;
    if(!ok) toast('Lengkapi dulu data identitas dengan benar.');
  }
  if(n === 2){
    ok = !markBad('jenis', !komponen || !$('jenis').value) && ok;
    ok = !markBad('peran', !$('peran').value) && ok;
    if(!ok) toast('Pilih jenis kegiatan dan peran terlebih dahulu.');
  }
  if(n === 3){
    const eF = $('errFormulir'), eB = $('errBukti');
    eF.style.display = filesFormulir.length ? 'none' : 'block';
    eB.style.display = filesBukti.length ? 'none' : 'block';
    ok = filesFormulir.length > 0 && filesBukti.length > 0;
    if(!ok) toast('Lampiran wajib: formulir PDF + minimal 1 bukti kegiatan.');
  }
  return ok;
}
['nama','nrp'].forEach(i => $(i).addEventListener('input', () => { const f = $(i).closest('.fld'); if(f) f.classList.remove('bad'); }));
$('prodi').addEventListener('change', () => { syncDept(); saveForm(); $('prodi').closest('.fld')?.classList.remove('bad'); });

/* ================= KOMPONEN & POIN ================= */
function setKomponen(k){
  komponen = k;
  document.querySelectorAll('.kopt').forEach(b => b.classList.toggle('sel', +b.dataset.k === k));
  const sel = $('jenis'); sel.innerHTML = '';
  const items = POIN[k] ? POIN[k].items : {};
  const keys = Object.keys(items);
  if(!keys.length){ sel.innerHTML = '<option value="">Pilih komponen terlebih dahulu</option>'; sel.disabled = true; }
  else{
    sel.disabled = false;
    sel.innerHTML = '<option value="">— Pilih jenis kegiatan —</option>' + keys.map(j => `<option>${esc(j)}</option>`).join('');
  }
  $('peran').innerHTML = '<option value="">Pilih jenis kegiatan terlebih dahulu</option>'; $('peran').disabled = true;
  $('poin').value = '—';
  const kh=document.getElementById('kompHint'); if(kh) kh.classList.toggle('on', !k);
}
function fillPeran(jenis, keep){
  const items = POIN[komponen]?.items || {};
  const sel = $('peran'); sel.innerHTML = '';
  const arr = items[jenis] || [];
  if(!arr.length){ sel.disabled = true; sel.innerHTML = '<option value="">Pilih jenis kegiatan terlebih dahulu</option>'; $('poin').value='—'; return; }
  sel.disabled = false;
  sel.innerHTML = '<option value="">— Pilih peran / perolehan —</option>' + arr.map((p,i)=>`<option value="${i}">${esc(p[0])}</option>`).join('');
  if(keep !== undefined){ sel.value = keep; updPoin(); }
}
function updPoin(){
  const items = POIN[komponen]?.items || {};
  const arr = items[$('jenis').value] || [];
  const p = arr[+ $('peran').value];
  $('poin').value = p ? p[1].toFixed(2).replace('.', ',') : '—';
}
document.querySelectorAll('.kopt').forEach(b => b.addEventListener('click', () => { setKomponen(+b.dataset.k); saveForm(); }));
$('jenis').addEventListener('change', () => { fillPeran($('jenis').value); saveForm(); });
$('peran').addEventListener('change', () => { updPoin(); saveForm(); });

/* ================= UPLOADS ================= */
const MAXB = 5 * 1024 * 1024;
function updLampiran(){
  const f=filesFormulir.length, b=filesBukti.length;
  $('cntForm').textContent=f+'/1 file';
  $('cntBukti').textContent=b+'/6 file';
  $('cntBukti').classList.toggle('full', b>=6);
  $('reqForm').textContent=f?'Terlampir':'Wajib'; $('reqForm').classList.toggle('ok', !!f);
  $('reqBukti').textContent=b?'Terlampir':'Wajib'; $('reqBukti').classList.toggle('ok', !!b);
  $('fFormulir').closest('.upl-box').classList.toggle('full', f>=1);
  $('fBukti').closest('.upl-box').classList.toggle('full', b>=6);
}
function renderList(input, arr, listEl){
  listEl.innerHTML = '';
  updLampiran();
  arr.forEach((f, i) => {
    const li = document.createElement('li');
    const isImg = f.type.startsWith('image/');
    li.innerHTML = (isImg ? `<img src="${f.data}" alt="">` : '<span class="pdfi">PDF</span>')
      + `<span class="n">${esc(f.name)}</span><span class="s">${(f.size/1024).toFixed(0)} KB</span><button type="button" aria-label="Hapus ${esc(f.name)}">×</button>`;
    li.querySelector('button').onclick = () => { arr.splice(i,1); renderList(input, arr, listEl); };
    listEl.appendChild(li);
  });
}
function pickFiles(input, arr, listEl, maxFiles, onlyPdf){
  input.addEventListener('change', () => {
    const fs = [...input.files]; input.value = '';
    let added = 0;
    for(const f of fs){
      if(onlyPdf && !(f.type === 'application/pdf' || f.name.toLowerCase().endsWith('.pdf'))){ toast('"'+f.name+'" bukan PDF. Formulir wajib PDF.'); continue; }
      if(!onlyPdf && !(/image\//.test(f.type) || f.type === 'application/pdf' || /\.(jpe?g|png|webp|pdf)$/i.test(f.name))){ toast('"'+f.name+'" tidak didukung.'); continue; }
      if(f.size > MAXB){ toast('"'+f.name+'" melebihi 5 MB.'); continue; }
      if(arr.length >= maxFiles){ toast('Maksimal '+maxFiles+' file.'); break; }
      const r = new FileReader();
      r.onload = () => { arr.push({ name:f.name, type:f.type, size:f.size, data:r.result, file:f }); renderList(input, arr, listEl); };
      r.readAsDataURL(f); added++;
    }
    if(added) toast(added + ' file ditambahkan.');
  });
}
updLampiran();
pickFiles($('fFormulir'), filesFormulir, $('listFormulir'), 1, true);
pickFiles($('fBukti'), filesBukti, $('listBukti'), 6, false);

/* Drag & Drop Effect */
document.querySelectorAll('.upl-box').forEach(box => {
  ['dragenter','dragover'].forEach(e => box.addEventListener(e, ev => { ev.preventDefault(); box.classList.add('dragover'); }));
  ['dragleave','drop'].forEach(e => box.addEventListener(e, ev => { ev.preventDefault(); box.classList.remove('dragover'); }));
});

/* ================= RINGKASAN ================= */
function renderRingkas(){
  const j = $('jenis').value, per = $('peran');
  const peranTxt = per.selectedOptions[0]?.textContent || '—';
  const poin = $('poin').value || '0';
  const formulir = filesFormulir.length ? esc(filesFormulir[0].name) : 'Belum diunggah';

  $('ringkas').innerHTML = `
    <div class="summary-grid">
      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-doc"/></svg> Identitas Mahasiswa</div>
        </div>
        <div class="rk-main">${esc($('nama').value)}</div>
        <div class="rk-grid">
          <div class="rk-item"><b>NRP</b><span>${esc($('nrp').value)}</span></div>
          <div class="rk-item"><b>Program studi</b><span>${esc(prodiText())}</span></div>
          <div class="rk-item"><b>Departemen</b><span>${esc(deptValue())}</span></div>
        </div>
      </div>

      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-akt"/></svg> Kegiatan SKEM</div>
          <span class="rk-badge">+${esc(poin)} Poin</span>
        </div>
        <div class="rk-main">${esc(j)}</div>
        <div class="rk-grid rk-grid2">
          <div class="rk-item"><b>Komponen</b><span>Komponen ${komponen}</span></div>
          <div class="rk-item"><b>Peran / Perolehan</b><span>${esc(peranTxt)}</span></div>
        </div>
      </div>

      <div class="summary-card">
        <div class="rk-head">
          <div class="sc-title"><svg class="ico"><use href="#i-up"/></svg> Berkas Lampiran</div>
        </div>
        <div class="rk-grid rk-grid2">
          <div class="rk-item"><b>Formulir Kegiatan</b><span>${formulir}</span></div>
          <div class="rk-item"><b>Bukti Pendukung</b><span>${filesBukti.length} file terlampir</span></div>
        </div>
      </div>
    </div>
  `;
  const labels=['Ubah identitas','Ubah kegiatan','Ubah lampiran'];
  $('ringkas').querySelectorAll('.summary-card').forEach((card,i)=>{
    if(i>2) return;
    const b=document.createElement('button'); b.type='button'; b.className='sc-edit'; b.dataset.go=i+1;
    b.innerHTML='<svg class="ico" viewBox="0 0 24 24"><use href="#i-back"/></svg>'+labels[i];
    b.querySelector('svg').style.transform='rotate(180deg)';
    card.appendChild(b);
  });
}

/* Tombol "Ubah data" di setiap kartu ringkasan */
$('ringkas').addEventListener('click', e => {
  const b = e.target.closest('[data-go]'); if(b) go(+b.dataset.go);
});

/* ================= RESET & KIRIM ================= */
function resetForm(){
  /* Data identitas (nama, NRP, prodi, departemen) sengaja TIDAK dihapus
     agar pengajuan berikutnya tidak perlu diisi ulang. */
  $('setuju').checked = false;
  setKomponen(0); filesFormulir = []; filesBukti = [];
  renderList($('fFormulir'), filesFormulir, $('listFormulir')); renderList($('fBukti'), filesBukti, $('listBukti'));
  saveForm(); /* simpan ulang: identitas tetap, data kegiatan ikut direset */
  go(1);
}

/* ===== Susun data sesuai field yang diterima controller ===== */
function selectedPeran(){
  const arr = (POIN[komponen] && POIN[komponen].items[$('jenis').value]) || [];
  return arr[+$('peran').value] || null;
}
function buildFormData(){
  const p = selectedPeran();
  const fd = new FormData();
  fd.append('name', $('nama').value.trim());
  fd.append('nrp', $('nrp').value.trim());
  fd.append('study_program_id', $('prodi').value);
  fd.append('component', komponen);
  fd.append('activity_name', $('jenis').value);
  fd.append('role', p ? p[0] : '');
  fd.append('points', p ? p[1].toFixed(2) : '');
  fd.append('formulir', filesFormulir[0].file);
  filesBukti.forEach(f => fd.append('bukti[]', f.file));
  return fd;
}
function firstError(res){
  if(res && res.errors){ const k = Object.keys(res.errors)[0]; if(k) return res.errors[k][0]; }
  return (res && res.message) || 'Periksa kembali data Anda.';
}

let lastNrp = '';
$('kirim').addEventListener('click', async () => {
  if(!validate(1)) { go(1); return; }
  if(!validate(2)) { go(2); return; }
  if(!validate(3)) { go(3); return; }
  if(!$('setuju').checked){ $('errSetuju').style.display = 'block'; $('chkStmt').scrollIntoView({behavior:'smooth', block:'center'}); return; }
  $('errSetuju').style.display = 'none';

  const btn = $('kirim');
  btn.disabled = true;
  btn.classList.add('loading');
  btn.querySelector('.btn-txt').textContent = 'Mengirim Pengajuan…';
  try{
    const resp = await fetch(CFG.storeUrl, {
      method: 'POST',
      body: buildFormData(),
      headers: { 'X-CSRF-TOKEN': CFG.csrf, 'Accept': 'application/json' }
    });
    let res = null;
    try{ res = await resp.json(); }catch(e){}
    if(resp.ok && res && res.success){
      lastNrp = $('nrp').value.trim();
      const reg = res.data && res.data.registration_number;
      $('regNo').textContent = reg ? 'Nomor registrasi: ' + reg : '';
      $('regNo').hidden = !reg;
      $('ovOk').classList.add('on');
      resetForm();
    } else {
      toast('Gagal: ' + firstError(res));
    }
  }catch(err){
    toast('Koneksi terputus atau berkas gagal diunggah. Coba lagi.');
  }finally{
    btn.disabled = false;
    btn.classList.remove('loading');
    btn.querySelector('.btn-txt').textContent = 'Kirim Pengajuan SKEM';
  }
});

$('ovClose').onclick = () => { window.location.href = CFG.trackUrl + '?nrp=' + encodeURIComponent(lastNrp); };
$('ovLagi').onclick = () => { $('ovOk').classList.remove('on'); window.scrollTo({top:0, behavior:'smooth'}); };
$('setuju').addEventListener('change', () => { $('errSetuju').style.display = 'none'; });

/* ================= REVEAL ANIMATION ================= */
if('IntersectionObserver' in window){
  const io = new IntersectionObserver(es => es.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } }), {threshold:.06});
  document.querySelectorAll('.rv').forEach(el => io.observe(el));
} else document.querySelectorAll('.rv').forEach(el => el.classList.add('in'));

setKomponen(komponen);
/* meteor */
(function(){
  var box=document.querySelector('.meteors');
  if(!box||(window.matchMedia&&matchMedia('(prefers-reduced-motion:reduce)').matches))return;
  var n=window.innerWidth<600?7:14;
  for(var k=0;k<n;k++){
    var m=document.createElement('i');
    m.style.left=(Math.random()*125-5)+'%';
    m.style.height=(45+Math.random()*70)+'px';
    m.style.setProperty('--o',(.25+Math.random()*.4).toFixed(2));
    m.style.animationDuration=(2.6+Math.random()*3)+'s';
    m.style.animationDelay=(-Math.random()*6)+'s';
    box.appendChild(m);
  }
})();
@endverbatim
</script>
</body>
</html>