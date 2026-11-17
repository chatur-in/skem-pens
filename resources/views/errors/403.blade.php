<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>403 · SKEM PENS</title>
@include('partials.favicon')
@vite(['resources/css/skem/base.css', 'resources/css/skem/error.css'])
</head>
<body>
<main>
  <p class="code">403</p>
  <h1>Akses ditolak</h1>
  <p class="msg">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>
  <div class="links">
    @guest
      <a href="{{ route('admin.login') }}">Masuk sebagai admin</a>
    @endguest
    <a href="{{ route('skem.index') }}">Kembali ke beranda</a>
  </div>
</main>
</body>
</html>
