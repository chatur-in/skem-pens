<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<title>Masuk Admin – SKEM PENS</title>
@include('partials.favicon')
@vite(['resources/css/skem/base.css', 'resources/css/skem/admin-login.css'])
</head>
<body>
<main class="card">
  <div class="brand">
    <div class="logo-wrap">
      <img src="{{ asset('images/logo-pens.svg') }}" alt="Logo PENS" width="52" height="52">
    </div>
    <span class="pill">SKEM PENS</span>
  </div>

  <h1>Masuk Admin</h1>
  <p class="sub">Khusus verifikator dan validator SKEM PENS.</p>

  <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
    @csrf

    @if($errors->any())
      <div class="err" role="alert">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="fld">
      <label for="email">Email</label>
      <div class="inp">
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M3.5 7l8.5 6 8.5-6"/></svg>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@pens.ac.id" autocomplete="username" required autofocus>
      </div>
    </div>

    <div class="fld">
      <label for="password">Kata sandi</label>
      <div class="inp">
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="11" width="14" height="10" rx="2.5"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
        <input id="password" class="has-toggle" type="password" name="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
        <button type="button" class="toggle" id="togglePw" aria-label="Tampilkan kata sandi" aria-pressed="false">
          <svg id="eyeOn" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg id="eyeOff" viewBox="0 0 24 24" aria-hidden="true" style="display:none"><path d="M3 3l18 18M10.6 6.1A10 10 0 0 1 12 6c6.5 0 10 6 10 6a17 17 0 0 1-3.2 3.9M6.6 6.6A17 17 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4.4-1"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/></svg>
        </button>
      </div>
    </div>

    <button class="submit" type="submit">Masuk</button>
  </form>

  <a class="back" href="{{ route('skem.index') }}">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
    Kembali ke beranda
  </a>
</main>

<script>
(function(){
  var btn=document.getElementById('togglePw');
  var pw=document.getElementById('password');
  var on=document.getElementById('eyeOn');
  var off=document.getElementById('eyeOff');
  btn.addEventListener('click',function(){
    var show=pw.type==='password';
    pw.type=show?'text':'password';
    on.style.display=show?'none':'';
    off.style.display=show?'':'none';
    btn.setAttribute('aria-pressed',String(show));
    btn.setAttribute('aria-label',show?'Sembunyikan kata sandi':'Tampilkan kata sandi');
    pw.focus();
  });
})();
</script>
</body>
</html>
