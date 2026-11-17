<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">
<title>403 – Akses Ditolak · SKEM PENS</title>
@include('partials.favicon')
@vite(['resources/css/skem/base.css', 'resources/css/skem/error.css'])
</head>
<body>
<main class="card">
  <div class="icon" aria-hidden="true">
    <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2.5"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
  </div>
  <p class="code">Error 403</p>
  <h1>Akses ditolak</h1>
  <p class="msg">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>

  <div class="actions">
    @guest
      <a class="btn btn-primary" href="{{ route('admin.login') }}">Masuk sebagai admin</a>
    @endguest
    <a class="btn btn-ghost" href="{{ route('skem.index') }}">Kembali ke beranda</a>
  </div>

  <div class="brand">SKEM PENS · Politeknik Elektronika Negeri Surabaya</div>
</main>
</body>
</html>
