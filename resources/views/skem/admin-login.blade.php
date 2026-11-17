<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<title>Masuk Admin – SKEM PENS</title>
<link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-pens.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<meta name="theme-color" content="#0b2a4d">
<style>
:root{--b:#174679;--b2:#0b2a4d;--b3:#2b6cb0;--y:#f3c813;--l:#dde5f0;--ink:#0b1b2e;--mute:#47607e;--bad:#b3261e;--badbg:#fdeceb}
*{box-sizing:border-box}
body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px 16px;color:var(--ink);font:16px/1.6 "Segoe UI",system-ui,-apple-system,Roboto,Arial,sans-serif;background:radial-gradient(800px 420px at 85% -10%,#2f74bd66,transparent 60%),linear-gradient(165deg,var(--b2),var(--b))}
.box{background:#fff;border-radius:24px;padding:36px 30px 28px;width:100%;max-width:400px;box-shadow:0 30px 70px rgba(0,0,0,.35);text-align:center}
.logo{display:block;width:76px;height:76px;margin:0 auto 12px}
.brand{display:inline-block;margin:0 0 18px;padding:4px 12px;border-radius:999px;background:var(--b);color:var(--y);font-size:12px;font-weight:800;letter-spacing:1.2px}
h1{margin:0 0 6px;font-size:22px;letter-spacing:-.3px;color:var(--b2)}
p.sub{margin:0 0 22px;color:var(--mute);font-size:14px;line-height:1.5}
.fld{text-align:left;margin-bottom:14px}
label{display:block;font-size:13px;font-weight:700;margin:0 0 6px;color:var(--b2)}
input{width:100%;padding:12px 14px;border:1.5px solid var(--l);border-radius:12px;font:inherit;font-size:16px;color:var(--ink);background:#fff}
input:focus{outline:0;border-color:var(--b3);box-shadow:0 0 0 4px rgba(43,108,176,.15)}
.err{background:var(--badbg);color:var(--bad);border-radius:10px;padding:10px 12px;font-size:13.5px;font-weight:600;margin:0 0 14px;text-align:left}
button{width:100%;border:0;border-radius:12px;background:var(--b);color:#fff;font:inherit;font-weight:700;font-size:15px;padding:13px;cursor:pointer;transition:background .15s;margin-top:6px}
button:hover{background:var(--b2)}
button:focus-visible,.back:focus-visible{outline:3px solid var(--y);outline-offset:2px}
.back{display:inline-block;margin-top:18px;color:var(--b);font-size:14px;font-weight:700;text-decoration:none}
.back:hover{text-decoration:underline}
</style>
</head>
<body>
<form class="box" method="POST" action="{{ route('admin.login.submit') }}" novalidate>
    @csrf
    <img class="logo" src="{{ asset('images/logo-pens.svg') }}" alt="Logo PENS" width="76" height="76">
    <span class="brand">SKEM PENS</span>
    <h1>Masuk Admin</h1>
    <p class="sub">Khusus verifikator dan validator SKEM PENS.</p>

    @if($errors->any())
        <div class="err" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="fld">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
    </div>
    <div class="fld">
        <label for="password">Kata sandi</label>
        <input id="password" type="password" name="password" autocomplete="current-password" required>
    </div>

    <button type="submit">Masuk</button>
    <a class="back" href="{{ route('skem.index') }}">← Kembali ke beranda</a>
</form>
</body>
</html>
