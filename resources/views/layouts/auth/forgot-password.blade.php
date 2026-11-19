<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password — Portal Admin Teknik Informatika (UIS)</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logouis.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0a0a0a;
      color: #ffffff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .auth-card {
      width: 100%;
      max-width: 440px;
      background: #141414;
      border: 1px solid rgba(249, 220, 75, 0.25);
      border-radius: 20px;
      padding: 36px 32px;
      box-shadow: 0 24px 60px rgba(0, 0, 0, 0.6);
    }
    .form-control {
      background: #1d1d1d;
      border: 1px solid rgba(255, 255, 255, 0.14);
      color: #ffffff;
      border-radius: 12px;
      padding: 12px 14px;
    }
    .form-control:focus {
      background: #1d1d1d;
      color: #ffffff;
      border-color: #f9dc4b;
      box-shadow: 0 0 0 3px rgba(249, 220, 75, 0.2);
    }
    .btn-gold {
      background: #f9dc4b;
      color: #000000;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      padding: 12px 18px;
      width: 100%;
      transition: all 0.2s ease;
    }
    .btn-gold:hover {
      background: #ffffff;
      color: #000000;
    }
  </style>
</head>
<body>
  <div class="auth-card">
    <div class="text-center mb-4">
      <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" style="height: 54px;" class="mb-3">
      <h4 class="fw-bold mb-1">Lupa Kata Sandi?</h4>
      <p class="text-secondary small mb-0">Masukkan alamat email akun Anda untuk menerima tautan reset kata sandi.</p>
    </div>

    @if(session('status'))
      <div class="alert alert-success small rounded-3">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('status') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger small rounded-3">
        <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label small fw-semibold text-light">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@uis.ac.id" required autofocus>
      </div>
      <button type="submit" class="btn btn-gold mt-2">
        <i class="bi bi-envelope-arrow-up me-1"></i> Kirim Tautan Reset Password
      </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top border-secondary border-opacity-25">
      <a href="{{ route('login') }}" class="small text-warning text-decoration-none fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Login
      </a>
    </div>
  </div>
</body>
</html>
