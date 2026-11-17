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
:root{--b:#174679;--b2:#0b2a4d;--b3:#2b6cb0;--y:#f3c813;--l:#dde5f0;--ink:#0b1b2e;--mute:#5a6f88;--bad:#b3261e;--badbg:#fdeceb}
*{box-sizing:border-box}
html,body{height:100%}
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px 16px;color:var(--ink);font:15px/1.6 "Segoe UI",system-ui,-apple-system,Roboto,Arial,sans-serif;-webkit-font-smoothing:antialiased;background:radial-gradient(900px 480px at 88% -12%,#2f74bd55,transparent 60%),radial-gradient(700px 420px at -10% 110%,#f3c81322,transparent 60%),linear-gradient(165deg,var(--b2),var(--b))}
.card{width:100%;max-width:420px;background:#fff;border-radius:22px;overflow:hidden;box-shadow:0 30px 70px rgba(0,0,0,.35)}
.head{background:linear-gradient(160deg,#fff 0%,#f4f8fd 100%);padding:30px 28px 22px;text-align:center;border-bottom:4px solid var(--y)}
.logo{display:block;width:84px;height:84px;margin:0 auto 14px;padding:8px;border-radius:20px;background:#fff;box-shadow:0 8px 22px rgba(11,42,77,.18)}
.brand{display:inline-block;padding:5px 14px;border-radius:999px;background:var(--b);color:var(--y);font-size:11.5px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase}
.body{padding:26px 28px 24px}
h1{margin:0 0 4px;font-size:21px;font-weight:800;letter-spacing:-.3px;color:var(--b2);text-align:center}
p.sub{margin:0 0 22px;color:var(--mute);font-size:13.5px;text-align:center;line-height:1.5}
.fld{margin-bottom:16px}
label{display:block;font-size:13px;font-weight:700;margin:0 0 7px;color:var(--b2)}
input{width:100%;padding:12px 14px;border:1.5px solid var(--l);border-radius:12px;font:inherit;font-size:15px;color:var(--ink);background:#fff;transition:border-color .15s,box-shadow .15s}
input::placeholder{color:#9aa9bb}
input:focus{outline:0;border-color:var(--b3);box-shadow:0 0 0 4px rgba(43,108,176,.15)}
.err{display:flex;align-items:center;gap:8px;background:var(--badbg);color:var(--bad);border:1px solid #f3c6c2;border-radius:12px;padding:10px 13px;font-size:13.5px;font-weight:600;margin:0 0 16px}
button.submit{width:100%;margin-top:6px;border:0;border-radius:12px;background:linear-gradient(180deg,var(--b),var(--b2));color:#fff;font:inherit;font-weight:800;font-size:15px;padding:13px;cursor:pointer;box-shadow:0 10px 20px -8px rgba(23,70,121,.6);transition:transform .15s,box-shadow .15s}
button.submit:hover{transform:translateY(-1px);box-shadow:0 14px 24px -8px rgba(23,70,121,.7)}
button.submit:active{transform:scale(.98)}
button.submit:focus-visible,.back:focus-visible{outline:3px solid var(--y);outline-offset:2px}
.back{display:block;text-align:center;margin-top:18px;color:var(--b);font-size:13.5px;font-weight:700;text-decoration:none}
.back:hover{text-decoration:underline}
@media(max-width:420px){.head{padding:24px 20px 18px}.body{padding:22px 20px 20px}}
</style>
</head>
<body>
<main class="card">
  <div class="head">
    <img class="logo" src="{{ asset('images/logo-pens.svg') }}" alt="Logo PENS" width="84" height="84">
    <span class="brand">SKEM PENS</span>
  </div>

  <form class="body" method="POST" action="{{ route('admin.login.submit') }}" novalidate>
    @csrf
    <h1>Masuk Admin</h1>
    <p class="sub">Khusus verifikator dan validator SKEM PENS.</p>

    @if($errors->any())
      <div class="err" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="fld">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@pens.ac.id" autocomplete="username" required autofocus>
    </div>
    <div class="fld">
      <label for="password">Kata sandi</label>
      <input id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
    </div>

    <button class="submit" type="submit">Masuk</button>
    <a class="back" href="{{ route('skem.index') }}">← Kembali ke beranda</a>
  </form>
</main>
</body>
</html>
