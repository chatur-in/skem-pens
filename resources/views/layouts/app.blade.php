<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SKEM PENS')</title>
    <style>
        :root{--b:#174679;--b2:#0b2a4d;--b3:#2b6cb0;--y:#f6c90e;--bg:#f5f8fd;--l:#dde5f0;--ink:#0b1b2e;--mute:#47607e;--ok:#12703a;--okbg:#e6f6ec;--bad:#b3261e;--badbg:#fdeceb;--warn:#8a4b00;--warnbg:#fff6e0}
        *{box-sizing:border-box} body{margin:0;background:var(--bg);color:var(--ink);font:15px/1.6 "Segoe UI",sans-serif}
        .w{max-width:1160px;margin:0 auto;padding:0 20px}
        .nav{background:#0b2a4deb;color:#fff;border-bottom:1px solid #ffffff1a;position:sticky;top:0;z-index:50}
        .nv{display:flex;align-items:center;gap:20px;height:62px}
        .brand{display:inline-flex;align-items:center;gap:10px;color:#fff;text-decoration:none;font-weight:800}
        .btn{display:inline-flex;align-items:center;gap:6px;border-radius:10px;padding:9px 16px;font-weight:700;text-decoration:none;cursor:pointer;border:0}
        .btn.y{background:var(--y);color:#10233b}
        .btn.g{background:#ffffff14;color:#fff;border:1px solid #ffffff50}
    </style>
    @stack('styles')
</head>
<body>
    <nav class="nav">
        <div class="w nv">
            <a class="brand" href="{{ route('skem.index') }}">SKEM PENS</a>
            <div style="margin-left:auto; display:flex; gap:10px;">
                <a href="{{ route('skem.create') }}" class="btn g">Ajukan</a>
                <a href="{{ route('skem.track') }}" class="btn g">Pantau</a>
                <a href="{{ route('admin.dashboard') }}" class="btn y">Admin</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer style="background:var(--b2); color:#b9cde6; padding:24px 0; margin-top:60px; text-align:center; font-size:14px;">
        <div class="w">
            <p>SKEM PENS &copy; {{ date('Y') }} - Politeknik Elektronika Negeri Surabaya</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>