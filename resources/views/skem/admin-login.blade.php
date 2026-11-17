<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<title>Masuk Admin – SKEM PENS</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-pens.svg') }}">
<meta name="theme-color" content="#0b2a4d">
<style>
:root{
  --navy:#0b2a4d;--blue:#174679;--accent:#3b82f6;--gold:#f3c813;
  --ink:#0f172a;--mute:#64748b;--line:#e2e8f0;
  --bad:#dc2626;--badbg:#fef2f2;
}
*{box-sizing:border-box}
html,body{height:100%}
body{
  margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px 16px;
  font:15px/1.6 Inter,"Segoe UI",system-ui,-apple-system,Roboto,Arial,sans-serif;color:var(--ink);
  -webkit-font-smoothing:antialiased;
  background:
    radial-gradient(700px 500px at 12% 8%,rgba(59,130,246,.45),transparent 60%),
    radial-gradient(600px 460px at 92% 92%,rgba(243,200,19,.22),transparent 60%),
    linear-gradient(160deg,#071a31 0%,var(--navy) 45%,var(--blue) 100%);
  position:relative;overflow-x:hidden;
}
/* dekorasi lingkaran blur di latar */
body:before,body:after{content:"";position:fixed;border-radius:50%;filter:blur(60px);opacity:.35;pointer-events:none;z-index:0}
body:before{width:320px;height:320px;background:#3b82f6;top:-80px;right:-60px}
body:after{width:260px;height:260px;background:var(--gold);bottom:-90px;left:-70px;opacity:.18}

.card{
  position:relative;z-index:1;width:100%;max-width:400px;
  background:rgba(255,255,255,.96);border-radius:26px;padding:34px 30px 28px;
  box-shadow:0 30px 80px -20px rgba(2,8,20,.55),0 0 0 1px rgba(255,255,255,.4) inset;
  animation:rise .5s cubic-bezier(.2,.8,.2,1) both;
}
@keyframes rise{from{opacity:0;transform:translateY(16px) scale(.98)}to{opacity:1;transform:none}}

.brand{display:flex;flex-direction:column;align-items:center;text-align:center;margin-bottom:24px}
.logo-wrap{
  width:72px;height:72px;border-radius:20px;background:#fff;display:grid;place-items:center;
  box-shadow:0 12px 26px -10px rgba(11,42,77,.55),0 0 0 1px var(--line);margin-bottom:14px;
}
.logo-wrap img{width:52px;height:52px;display:block}
.pill{
  display:inline-flex;align-items:center;gap:7px;padding:4px 12px;border-radius:999px;
  background:#eff6ff;color:var(--blue);font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;
}
.pill:before{content:"";width:6px;height:6px;border-radius:50%;background:var(--gold);box-shadow:0 0 0 3px rgba(243,200,19,.25)}

h1{margin:0 0 4px;font-size:24px;font-weight:800;letter-spacing:-.4px;color:var(--ink)}
p.sub{margin:0 0 24px;color:var(--mute);font-size:14px;line-height:1.55}

.err{
  display:flex;align-items:flex-start;gap:10px;background:var(--badbg);color:var(--bad);
  border:1px solid #fecaca;border-radius:14px;padding:11px 13px;font-size:13.5px;font-weight:600;margin:0 0 18px;
}
.err svg{width:18px;height:18px;flex:none;margin-top:1px}

.fld{margin-bottom:16px}
label{display:block;font-size:13px;font-weight:700;margin:0 0 7px;color:#334155}
.inp{position:relative}
.inp > svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);width:18px;height:18px;stroke:#94a3b8;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;pointer-events:none;transition:stroke .2s}
input{
  width:100%;padding:13px 14px 13px 42px;border:1.5px solid var(--line);border-radius:14px;
  font:inherit;font-size:15px;color:var(--ink);background:#f8fafc;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
input.has-toggle{padding-right:46px}
input::placeholder{color:#a0aec0}
input:hover{background:#fff}
input:focus{outline:0;border-color:var(--accent);background:#fff;box-shadow:0 0 0 4px rgba(59,130,246,.15)}
.inp:focus-within > svg{stroke:var(--accent)}

.toggle{
  position:absolute;right:6px;top:50%;transform:translateY(-50%);
  width:36px;height:36px;border:0;border-radius:10px;background:transparent;color:#94a3b8;
  display:grid;place-items:center;cursor:pointer;transition:background .15s,color .15s;padding:0;
}
.toggle:hover{background:#eef2f7;color:var(--blue)}
.toggle svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.toggle:focus-visible,button.submit:focus-visible,.back:focus-visible{outline:3px solid var(--gold);outline-offset:2px}

button.submit{
  width:100%;margin-top:8px;border:0;border-radius:14px;padding:14px;cursor:pointer;
  background:linear-gradient(135deg,var(--accent),var(--blue));color:#fff;
  font:inherit;font-weight:700;font-size:15px;letter-spacing:.2px;
  box-shadow:0 12px 24px -10px rgba(59,130,246,.7);
  transition:transform .15s,box-shadow .2s,filter .2s;
}
button.submit:hover{transform:translateY(-1px);box-shadow:0 16px 30px -10px rgba(59,130,246,.8);filter:brightness(1.05)}
button.submit:active{transform:scale(.98)}

.back{
  display:flex;align-items:center;justify-content:center;gap:6px;margin-top:20px;
  color:var(--mute);font-size:13.5px;font-weight:600;text-decoration:none;transition:color .15s;
}
.back:hover{color:var(--blue)}

@media(max-width:420px){.card{padding:28px 22px 24px;border-radius:22px}h1{font-size:22px}}
@media(prefers-reduced-motion:reduce){.card{animation:none}}
</style>
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
