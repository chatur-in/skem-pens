<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Status Pengajuan SKEM Saya</title>
@include('partials.favicon')
@vite(['resources/css/skem/pantau-mahasiswa.css'])
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
</defs></svg>

@php
    // Pemetaan status -> label, kelas badge, warna aksen
    $ST = [
        'diajukan'   => ['Diajukan',        's-blue',   '#174679'],
        'verifikasi' => ['Verifikasi',      's-amber',  '#e0a100'],
        'validasi'   => ['Validasi',        's-violet', '#5b3aa0'],
        'acc'        => ['Disetujui (ACC)', 's-green',  '#12703a'],
        'tolak'      => ['Ditolak',         's-red',    '#b3261e'],
    ];
    $STEPS = ['diajukan' => 'Diajukan', 'verifikasi' => 'Verifikasi', 'validasi' => 'Validasi', 'acc' => 'Disetujui'];
    $TARGET = 3.0;

    $list = $submissions instanceof \Illuminate\Pagination\AbstractPaginator
        ? $submissions->getCollection()
        : collect($submissions ?? []);

    $rank = ['tolak' => 0, 'acc' => 3];
    $list = $list->sortBy(fn ($s) => $rank[$s->status] ?? 2)->values();

    if ($student) {
        $points  = (float) $student->accumulated_points;
        $pct     = max(0, min(100, $points / $TARGET * 100));
        $eligible = $student->isEligibleForGraduation();
        $initials = mb_strtoupper(collect(preg_split('/\s+/', trim($student->name)))->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
        $needAction = $list->filter(fn ($s) => $s->status === 'tolak')->count();
    }
    $fmt = fn ($n) => number_format((float) $n, 2, ',', '.');
@endphp

<header class="top">
  <div class="meteors" aria-hidden="true"></div>
  <div class="w tb">
    <a class="brand" href="{{ route('skem.index') }}"><i><img src="{{ asset('images/logo-pens.svg') }}" alt="" width="36" height="36"></i><span><b>SKEM PENS</b><small>Satuan Kredit Ekstrakurikuler</small></span></a>
  </div>
  <div class="w hd">
    <div>
      <h1>Status Pengajuan <span class="sk-shine">SKEM</span></h1>
      <p>Pantau perkembangan klaim poin SKEM kamu.</p>
    </div>
    <span class="role">Mahasiswa</span>
  </div>
</header>

<main class="w">
@if(!$student)
  <section class="card lookup" aria-label="Cari pengajuan">
    <div class="lk-head">
      <div><h2>Masukkan NRP kamu</h2><p>Hanya pengajuan dengan NRP tersebut yang ditampilkan.</p></div>
      <span class="lk-cnt" id="nrpCount">0/10</span>
    </div>
    <form method="GET" action="{{ route('skem.track') }}" class="lk-form" autocomplete="off">
      <label class="nrp-in">
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="M8 10h3M8 14h6M15 10h1"/></svg>
        <input id="nrp" type="text" name="nrp" value="{{ $nrp }}" inputmode="numeric" pattern="\d{10}" maxlength="10" placeholder="Contoh: 3125600001" aria-label="NRP" required>
      </label>
      <button class="btn dk" type="submit">Lihat status
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
    </form>
    <div class="err" role="alert">@if($nrp)Data mahasiswa dengan NRP {{ $nrp }} tidak ditemukan.@endif</div>
  </section>
@else
  <section class="idcard">
    <span class="av">{{ $initials ?: '?' }}</span>
    <div class="idinfo">
      <b>{{ $student->name }}</b>
      <span class="nrp">NRP {{ $student->nrp }}</span>
      <small>{{ $student->studyProgram->name }} · {{ $student->studyProgram->department->name }}</small>
    </div>
    <a class="btn sm" href="{{ route('skem.track') }}">Ganti NRP</a>
  </section>

  <section class="goal" aria-label="Akumulasi poin SKEM">
    <div class="gt"><span>Akumulasi poin disetujui</span><b>{{ $fmt($points) }} <small>/ {{ $fmt($TARGET) }} poin</small></b></div>
    <div class="pbar {{ $eligible ? 'done' : '' }}" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $TARGET }}" aria-valuenow="{{ $points }}"><i style="width:{{ $pct }}%"></i></div>
    @if($eligible)
      <div class="alert ok"><svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg><div><b>Memenuhi syarat kelulusan SKEM</b>Poin SKEM kamu sudah mencapai batas minimum.</div></div>
    @else
      <div class="alert run"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><div><b>Belum memenuhi syarat kelulusan</b>Masih kurang {{ $fmt(max(0, $TARGET - $points)) }} poin lagi.</div></div>
    @endif
  </section>

  <div class="stats">
    <div class="st p"><span class="ic"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/></svg></span><div><small>Total pengajuan</small><b>{{ $list->count() }}</b></div></div>
    <div class="st g"><span class="ic"><svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg></span><div><small>Poin disetujui</small><b>{{ $fmt($points) }}</b></div></div>
    <div class="st o"><span class="ic"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg></span><div><small>Perlu tindakan</small><b>{{ $needAction }}</b></div></div>
  </div>

  <div class="listhead"><h2>Pengajuan {{ $student->name }}</h2></div>

  @if($list->isEmpty())
    <div class="empty">
      <div class="ill"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/></svg></div>
      <p>Belum ada pengajuan</p>
      <small>untuk NRP ini. Ajukan klaim pertamamu sekarang.</small>
    </div>
  @else
    <div class="cards">
    @foreach($list as $sub)
      @php
          $s    = $sub->status;
          $info = $ST[$s] ?? [ucfirst((string) $s), 's-amber', '#e0a100'];
          $idx  = array_search($s, array_keys($STEPS), true);
      @endphp
      <article class="sub" style="--c:{{ $info[2] }}">
        <div class="shead"><h3>{{ $sub->activity_name }}</h3><span class="badge {{ $info[1] }}">{{ $info[0] }}</span></div>
        <div class="chips2">
          <span class="idc">{{ $sub->registration_number }}</span>
          @if($sub->created_at)<span>Diajukan {{ $sub->created_at->format('d M Y') }}</span>@endif
          <span>{{ $sub->role }}</span>
          <span class="pt">{{ $sub->points }} poin</span>
        </div>

        @if($s === 'acc')
          <div class="alert ok"><svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg><div><b>Pengajuan disetujui</b>Poin {{ $sub->points }} sudah tercatat sebagai klaim SKEM.</div></div>
        @elseif($s === 'tolak')
          <div class="alert tol"><svg viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg><div><b>Pengajuan ditolak</b>{{ $sub->admin_note ?: 'Pengajuan tidak memenuhi ketentuan.' }}</div></div>
        @else
          <div class="alert run"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><div><b>Sedang diproses</b>Pengajuan ini {{ $s === 'verifikasi' ? 'sedang diverifikasi' : ($s === 'validasi' ? 'sedang divalidasi' : 'menunggu verifikasi') }}.</div></div>
        @endif

        @if($s === 'tolak')
          <div class="aksi"><a class="btn" href="{{ route('skem.create') }}">Ajukan ulang dari awal →</a></div>
        @endif

        @if($idx !== false)
          <div class="prog">
            @foreach(array_values($STEPS) as $i => $label)
              @php $cls = ($s === 'acc' || $i < $idx) ? 'done' : ($i === $idx ? 'cur' : ''); @endphp
              <div class="pst {{ $cls }}"><div class="dot">@if($cls === 'done')<svg viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></svg>@else{{ $i + 1 }}@endif</div><div class="lb">{{ $label }}</div></div>
            @endforeach
          </div>
        @endif

        @if($sub->admin_note && $s !== 'tolak')
          <div class="note"><strong>Catatan petugas:</strong> {{ $sub->admin_note }}</div>
        @endif
      </article>
    @endforeach
    </div>
  @endif

  <div class="cta">
    <div><b>Punya kegiatan baru?</b><small>Ajukan klaim poin SKEM beserta bukti kegiatanmu.</small></div>
    <a class="btn" href="{{ route('skem.create') }}">+ Ajukan klaim baru</a>
  </div>
@endif
</main>

<footer class="foot">Status final ditentukan oleh verifikator dan validator SKEM PENS.</footer>

<script>
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
(function(){
  var i=document.getElementById('nrp'),c=document.getElementById('nrpCount');
  if(!i||!c)return;
  function u(){i.value=i.value.replace(/\D/g,'').slice(0,10);c.textContent=i.value.length+'/10';c.classList.toggle('full',i.value.length===10);}
  i.addEventListener('input',u);u();
})();
</script>
</body>
</html>