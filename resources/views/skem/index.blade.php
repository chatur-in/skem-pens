<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>SKEM PENS – Satuan Kredit Ekstrakurikuler Mahasiswa</title>
@include('partials.favicon')
<meta name="description" content="Informasi SKEM PENS: pengertian, syarat kelulusan, komponen, tahapan pengajuan, dan layanan pembuatan formulir, pengajuan, serta pemantauan SKEM.">
<script>document.documentElement.classList.add('js')</script>
@vite(['resources/css/skem/index.css'])</head><body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
<symbol id="i-doc" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></symbol>
<symbol id="i-up" viewBox="0 0 24 24"><path d="M12 16V4M7 9l5-5 5 5M4 20h16"/></symbol>
<symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></symbol>
<symbol id="i-chart" viewBox="0 0 24 24"><path d="M5 20V11M12 20V4M19 20v-6"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><path d="M9 11l3 3 8-8"/><path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h9"/></symbol>
<symbol id="i-gen" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M12 11.5v6M9 14.5h6"/></symbol>
<symbol id="i-send" viewBox="0 0 24 24"><path d="M21 3L10.5 13.5"/><path d="M21 3l-6.5 18-4-7.5L3 9.5z"/></symbol>
<symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.2 2"/></symbol>
<symbol id="i-shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
<symbol id="i-arr" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
</defs></svg>
<a class="skip" href="#menu">Lewati ke menu</a>
<nav class="nav" aria-label="Navigasi utama"><div class="w nv">
  <a class="brand" href="{{ route('skem.index') }}" aria-label="SKEM PENS, ke atas halaman"><i><img src="{{ asset('images/logo-pens.svg') }}" alt="" width="36" height="36"></i><span class="bt"><b>SKEM PENS</b><small>Satuan Kredit Ekstrakurikuler Mahasiswa</small></span></a>
  <a class="btn g sm2" href="{{ route('admin.dashboard') }}" target="_blank" rel="noopener"><svg class="ico"><use href="#i-lock"/></svg> Login Admin</a>
</div></nav>
<header class="hero"><div class="meteors" aria-hidden="true"></div><div class="w">
  <div class="hg">
    <div>
      <span class="tag">Politeknik Elektronika Negeri Surabaya</span>
      <h1>Kelola <em>SKEM</em> kamu dengan mudah.</h1>
      <p class="sub">Satuan Kredit Ekstrakurikuler Mahasiswa, pengakuan resmi atas aktivitas non-akademikmu. Semua prosesnya ada di satu tempat.</p>
      <div class="cta-row"><a class="btn y" href="#menu">Mulai sekarang <svg class="ico"><use href="#i-arr"/></svg></a><a class="btn g" href="#tentang">Pelajari SKEM</a></div>
      <ul class="hf"><li><svg class="ico"><use href="#i-doc"/></svg>Pelajari ketentuan</li><li><svg class="ico"><use href="#i-gen"/></svg>Buat formulir</li><li><svg class="ico"><use href="#i-send"/></svg>Ajukan klaim</li><li><svg class="ico"><use href="#i-clock"/></svg>Pantau status</li></ul>
    </div>
    <div class="goal" aria-label="Target kelulusan SKEM 3,0 kredit">
      <div class="gh">Target kelulusan</div>
      <div class="gn">3,0<small>kredit SKEM</small></div>
      <p class="gs">Syarat wajib kelulusan mahasiswa D3 dan Sarjana Terapan (STr).</p>
      <div class="lg2">
        <div class="rw"><span class="bn">1</span><div><b>Interpersonal &amp; Manajerial</b><small>Ditentukan kampus</small></div></div>
        <div class="rw"><span class="bn">2</span><div><b>Pengembangan Spiritual</b><small>Ditentukan kampus</small></div></div>
        <div class="rw"><span class="bn">3</span><div><b>Minat, Bakat &amp; Organisasi</b><small>Pilihan bebas</small></div></div>
      </div>
    </div>
  </div>
</div></header>
<div class="w menu" id="menu"><div class="grid">
  <a class="mc rv" href="https://pjj.pens.ac.id/wp-content/uploads/2026/07/Pedoman-Pelaksanaan-SKEM-Reguler.pdf" target="_blank" rel="noopener"><div class="mt"><div class="ic"><svg class="ico"><use href="#i-doc"/></svg></div><span class="no">01</span></div><b>Pedoman SKEM PENS</b><span class="d">Ketentuan lengkap dan daftar bobot kegiatan SKEM. Berupa PDF, dibuka di tab baru.</span><em>Buka pedoman <span class="go"><svg class="ico"><use href="#i-arr"/></svg></span></em></a>
  <a class="mc rv" href="{{ route('skem.generator') }}" target="_blank" rel="noopener"><div class="mt"><div class="ic"><svg class="ico"><use href="#i-gen"/></svg></div><span class="no">02</span></div><b>Generator Formulir</b><span class="d">Buat formulir kegiatan SKEM dan unduh sebagai PDF siap cetak.</span><em>Buka generator <span class="go"><svg class="ico"><use href="#i-arr"/></svg></span></em></a>
  <a class="mc rv" href="{{ route('skem.create') }}" target="_blank" rel="noopener"><div class="mt"><div class="ic"><svg class="ico"><use href="#i-send"/></svg></div><span class="no">03</span></div><b>Ajukan SKEM</b><span class="d">Kirim pengajuan klaim poin SKEM beserta bukti kegiatanmu.</span><em>Ajukan sekarang <span class="go"><svg class="ico"><use href="#i-arr"/></svg></span></em></a>
  <a class="mc rv" href="{{ route('skem.track') }}" target="_blank" rel="noopener"><div class="mt"><div class="ic"><svg class="ico"><use href="#i-clock"/></svg></div><span class="no">04</span></div><b>Pantau Status</b><span class="d">Lihat apakah pengajuanmu sudah disetujui, ditolak, atau masih diproses.</span><em>Cek status <span class="go"><svg class="ico"><use href="#i-arr"/></svg></span></em></a>
</div></div>
<main>
<div class="w">
<section id="tentang" class="rv">
  <div class="ab">
    <div><div class="eb">Tentang</div><h2>Apa itu SKEM?</h2>
      <p class="lead"><b>SKEM (Satuan Kredit Ekstrakurikuler Mahasiswa)</b> adalah instrumen penilaian di PENS (Politeknik Elektronika Negeri Surabaya) untuk mengakui aktivitas non-akademik mahasiswa.</p>
      <span class="kl">Aktivitas yang diakui mendukung pengembangan</span>
      <ul class="tg"><li>Karakter</li><li>Soft skills</li><li>Kepemimpinan</li><li>Kompetensi profesional</li></ul>
    </div>
    <div class="stats">
      <div class="stat"><b>3,0</b><span>kredit minimum untuk lulus</span></div>
      <div class="stat"><b>3</b><span>komponen SKEM wajib</span></div>
      <div class="stat"><b>1<small>tahun</small></b><span>batas pengajuan ke belakang</span></div>
    </div>
  </div>
</section>
<section id="syarat" class="rv"><div class="eb">Ketentuan</div><h2>Syarat Kelulusan</h2><p class="lead">SKEM merupakan salah satu syarat wajib kelulusan bagi mahasiswa D3 dan Sarjana Terapan (STr).</p>
  <div class="two">
    <div class="card"><ul class="ck">
      <li>Mahasiswa wajib mengumpulkan nilai akumulatif SKEM minimal 3,0 (atau 3 poin) sebagai salah satu syarat wajib kelulusan.</li>
      <li class="x">Jika nilai SKEM belum memenuhi batas minimum saat akan lulus, mahasiswa tidak dapat lulus dan harus mengikuti kegiatan tambahan.</li>
      <li>Pengakuan SKEM hanya untuk kegiatan yang dilaksanakan selama masa studi aktif, dan setiap kegiatan hanya dapat diajukan satu kali.</li>
    </ul></div>
    <div class="big"><strong>3,0</strong><span>kredit akumulatif minimum<br>untuk dapat lulus</span></div>
  </div>
</section>
<section id="komponen" class="rv"><div class="eb">Struktur</div><h2>Tiga Komponen SKEM</h2><p class="lead">Ketiga komponen wajib dipenuhi. Komponen 1 dan 2 sudah ditentukan kampus, sedangkan Komponen 3 bebas kamu pilih sesuai minat.</p>
  <div class="komp">
    <div class="kr"><span class="kn">1</span>
      <div class="ki"><h3>Interpersonal &amp; Manajerial <span class="kt">Ditentukan kampus</span></h3><p>Melatih kepemimpinan, komunikasi, dan keterampilan manajerial.</p></div>
      <div class="kg"><span class="kl">Kegiatan wajib</span><ul class="tg"><li>PKKMB</li><li>OPP</li><li>LKMM Pra-TD</li><li>LKMM TD</li></ul></div></div>
    <div class="kr"><span class="kn">2</span>
      <div class="ki"><h3>Pengembangan Spiritual <span class="kt">Ditentukan kampus</span></h3><p>Memperkuat nilai spiritual dan etika melalui kegiatan keagamaan.</p></div>
      <div class="kg"><span class="kl">Kegiatan wajib</span><ul class="tg"><li>Mentoring Keagamaan (1 semester)</li></ul></div></div>
    <div class="kr free"><span class="kn">3</span>
      <div class="ki"><h3>Minat, Bakat, Organisasi &amp; Kompetisi <span class="kt">Pilihan bebas</span></h3><p>Pilih kegiatan sesuai minat untuk mengembangkan potensi diri. Setiap kegiatan dibuktikan dengan sertifikat, piagam, atau surat keterangan resmi.</p></div>
      <div class="kg"><span class="kl">Contoh kegiatan</span><ul class="tg"><li>Organisasi</li><li>Kepanitiaan</li><li>Lomba &amp; prestasi</li><li>Forum ilmiah</li><li>Kewirausahaan</li><li>Minat &amp; bakat</li></ul></div></div>
  </div>
</section>
<section id="alur" class="rv"><div class="eb">Alur</div><h2>Tahapan Pengajuan SKEM</h2><p class="lead">Dari kegiatan sampai poin tercatat, ikuti empat tahapan berikut.</p>
  <div class="steps">
    <div class="st"><h3>Pelaksanaan Kegiatan</h3><p>Pastikan kegiatan diikuti selama kamu berstatus mahasiswa aktif PENS.</p></div>
    <div class="st"><h3>Dokumentasi Bukti</h3><p>Simpan sertifikat, piagam, surat keputusan (SK), atau bukti resmi lainnya dalam bentuk digital (PDF).</p></div>
    <div class="st"><h3>Penginputan Data</h3><p>Isi formulir dan minta tanda tangan verifikator, lalu masuk ke Sistem Pengajuan SKEM, isi detail kegiatan, dan unggah bukti beserta formulir PDF.</p></div>
    <div class="st"><h3>Verifikasi &amp; Validasi</h3><p>Data diperiksa verifikator dan validator. Jika disetujui, nilai kredit tercatat dan dapat dipantau di sistem monitoring.</p></div>
  </div>
</section>
<section id="tips" class="rv"><div class="eb">Tips</div><h2>Tips Sukses Memenuhi Target SKEM</h2><p class="lead">Beberapa kebiasaan kecil yang membuat target 3,0 terasa ringan.</p>
  <div class="tips">
    <div class="card"><span class="ti"><svg class="ico"><use href="#i-clock"/></svg></span><b>Cicil sejak Tingkat 1</b><p>Selesaikan komponen wajib (Komponen 1 &amp; 2) di tahun pertama agar tidak menumpuk di akhir perkuliahan.</p></div>
    <div class="card"><span class="ti"><svg class="ico"><use href="#i-chart"/></svg></span><b>Aktif di Organisasi/Kepanitiaan</b><p>Menjadi pengurus atau panitia acara kampus menyumbang poin cukup besar untuk Komponen 3.</p></div>
    <div class="card"><span class="ti"><svg class="ico"><use href="#i-shield"/></svg></span><b>Periksa Keabsahan Sertifikat</b><p>Pastikan sertifikat mencantumkan nama penyelenggara yang jelas dan tanda tangan resmi agar tidak ditolak saat verifikasi.</p></div>
  </div>
  <div class="card warn"><b>Kesalahan pengisian yang sering terjadi</b><ul class="ck">
    <li class="x">Salah memilih kategori, misalnya kompetisi robot didaftarkan sebagai Organisasi.</li>
    <li class="x">Nama kegiatan disingkat. Tulis nama lengkapnya.</li>
    <li class="x">Dokumen tidak lengkap, termasuk formulir verifikasi yang belum ditandatangani.</li>
    <li class="x">Nama di sertifikat berbeda dengan data akademik. Lampirkan surat keterangan dari penyelenggara bila ada perbedaan.</li>
  </ul></div>
</section>
<section id="dokumen" class="rv"><div class="eb">Rujukan</div><h2>Dokumen &amp; Tautan Resmi</h2><p class="lead">Rujukan utama untuk ketentuan, bobot kegiatan, dan layanan SKEM.</p>
  <div class="docs">
    <a class="dc main" href="https://pjj.pens.ac.id/wp-content/uploads/2026/07/Pedoman-Pelaksanaan-SKEM-Reguler.pdf" target="_blank" rel="noopener"><i><svg class="ico"><use href="#i-doc"/></svg></i><div><b>Pedoman Pelaksanaan SKEM PENS (Reguler)</b><small>Ketentuan lengkap dan daftar bobot kegiatan (PDF)</small></div></a>
    <a class="dc" href="{{ route('skem.create') }}" target="_blank" rel="noopener"><i><svg class="ico"><use href="#i-up"/></svg></i><div><b>Sistem Pengajuan SKEM</b><small>Formulir klaim poin online</small></div></a>
    <a class="dc" href="{{ route('skem.track') }}" target="_blank" rel="noopener"><i><svg class="ico"><use href="#i-chart"/></svg></i><div><b>Sistem Monitoring SKEM</b><small>Pantau status pengajuan NRP</small></div></a>
    <a class="dc" href="{{ route('skem.create') }}" target="_blank" rel="noopener"><i><svg class="ico"><use href="#i-check"/></svg></i><div><b>Form Verifikasi SKEM</b><small>Lengkapi lampiran &amp; bukti</small></div></a>
  </div>
</section>
<section id="faq" class="rv"><div class="eb">FAQ</div><h2>Pertanyaan umum</h2><p class="lead">Jawaban singkat untuk hal yang paling sering ditanyakan.</p>
  <details><summary>Berapa minimal poin SKEM untuk lulus?</summary><p>Minimal 3,0 satuan kredit SKEM untuk mahasiswa D3 dan Sarjana Terapan (STr), sebagai salah satu syarat wajib kelulusan.</p></details>
  <details><summary>Bagaimana jika poin SKEM belum cukup saat akan lulus?</summary><p>Mahasiswa tidak dapat dinyatakan lulus meskipun kewajiban akademik lain sudah selesai, dan harus mengikuti kegiatan SKEM tambahan.</p></details>
  <details><summary>Sampai kapan kegiatan bisa diajukan?</summary><p>Kegiatan dapat diajukan maksimal 1 tahun sejak kegiatan dilaksanakan. Pengajuan yang melewati batas ini tidak diproses.</p></details>
  <details><summary>Apa yang terjadi jika bukti kegiatan dipalsukan?</summary><p>Mahasiswa dikenai sanksi sesuai peraturan disiplin yang berlaku di PENS, termasuk pembatalan pengajuan SKEM.</p></details>
  <details><summary>Bagaimana jika ada kondisi khusus sehingga tidak bisa mengikuti kegiatan?</summary><p>Mahasiswa dapat mengajukan dispensasi atau penyesuaian kepada Bagian Kemahasiswaan melalui dosen wali.</p></details>
  <details><summary>Bagaimana membuat formulir kegiatan SKEM?</summary><p>Gunakan menu Generator Formulir di halaman ini untuk mengisi formulir dan mengunduhnya sebagai PDF, lalu minta tanda tangan verifikator sebelum diunggah ke sistem pengajuan.</p></details>
</section>
<div class="cta rv"><h2>Siap mengurus SKEM-mu?</h2><p>Mulai dari membuat formulir, lalu ajukan dan pantau prosesnya.</p><a class="btn y" href="#menu">Pilih menu <svg class="ico"><use href="#i-arr"/></svg></a></div>
</div>
</main>
<footer><div class="w"><div class="fl"><span class="brand"><i><img src="{{ asset('images/logo-pens.svg') }}" alt="" width="36" height="36"></i><span class="bt"><b>SKEM PENS</b><small>Satuan Kredit Ekstrakurikuler Mahasiswa</small></span></span><nav aria-label="Pintasan"><a href="#tentang">Tentang</a><a href="#syarat">Syarat</a><a href="#komponen">Komponen</a><a href="#alur">Alur</a><a href="#dokumen">Dokumen</a><a href="#faq">FAQ</a></nav></div><p>Alat bantu mahasiswa Politeknik Elektronika Negeri Surabaya. Selalu rujuk pedoman SKEM resmi dari kampus untuk ketentuan terbaru.</p></div></footer>
<script>
(function(){
  var box=document.querySelector('.meteors');
  if(!box||(window.matchMedia&&matchMedia('(prefers-reduced-motion:reduce)').matches))return;
  var n=window.innerWidth<600?10:20;
  for(var i=0;i<n;i++){
    var m=document.createElement('i');
    m.style.left=(Math.random()*120-5)+'%';
    m.style.height=(50+Math.random()*80)+'px';
    m.style.setProperty('--o',(.25+Math.random()*.4).toFixed(2));
    m.style.animationDuration=(3.5+Math.random()*4)+'s';
    m.style.animationDelay=(-Math.random()*8)+'s';
    box.appendChild(m);
  }
})();
</script>
<script>
if ('IntersectionObserver' in window) {
  const io = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } }), { threshold: .08 });
  document.querySelectorAll('.rv').forEach(el => io.observe(el));
} else document.querySelectorAll('.rv').forEach(el => el.classList.add('in'));
</script>
</body>
</html>