<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Portal Teknik Informatika (UIS)</title>
  <meta name="description" content="Portal Login Resmi Teknik Informatika (UIS) Batam — Sistem Informasi Terpadu Mahasiswa, Dosen, dan Tenaga Kependidikan.">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('frontend/img/logouis.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/img/logouis.png') }}">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --uis-green:          #000000;
      --uis-green-dark:     #000000;
      --uis-green-deep:     #000000;
      --uis-green-light:    #f9dc4b;
      --uis-green-subtle:   #d4edd9;
      --uis-yellow:         #f9dc4b;
      --uis-yellow-hover:   #f9dc4b;
      
      --brand-primary:      var(--uis-green);
      --brand-primary-dark: var(--uis-green-dark);
      --brand-primary-light:var(--uis-green-light);
      --brand-accent:       var(--uis-yellow);
      
      --text-heading:       #0a2313;
      --text-body:          #2a4734;
      --text-muted:         #4b6855;
      --text-light:         #769280;

      --bg-page:            #edf6f0;
      --card-bg:            #FFFFFF;
      --border-color:       #d0e7d7;

      --shadow-card:        0 14px 34px -5px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.05);
      --shadow-primary:     0 8px 18px -3px rgba(0, 0, 0, 0.4);
      --transition-smooth:  all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    html, body {
      height: 100vh;
      max-height: 100vh;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--bg-page);
      color: var(--text-body);
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow: hidden; /* Pas di layar tanpa scroll vertikal di desktop */
    }

    /* ── LAYOUT SHELL ── */
    .auth-container {
      display: flex;
      height: 100vh;
      max-height: 100vh;
      width: 100vw;
      overflow: hidden;
      position: relative;
    }

    /* ── LEFT SHOWCASE PANEL (FOTO ASLI GEDUNG TANPA TINT HIJAU) ── */
    .showcase-panel {
      flex: 1.15;
      position: relative;
      background-color: var(--uis-green-deep);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 32px 42px;
    }

    /* Foto Asli Gedung Kampus UIS - Natural Tanpa Hijau */
    .showcase-bg {
      position: absolute;
      inset: 0;
      background-image: url("{{ asset('frontend/img/gedung-uis.jpg') }}");
      background-size: cover;
      background-position: center bottom;
      transform: scale(1.02);
      transition: transform 10s ease;
      z-index: 1;
    }
    .auth-container:hover .showcase-bg {
      transform: scale(1.06);
    }

    /* Scrim minimal di bagian atas untuk logo */
    .showcase-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.45) 0%,
        rgba(0, 0, 0, 0) 25%
      );
      z-index: 2;
    }

    .showcase-content {
      position: relative;
      z-index: 3;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Header Brand (Warna Resmi Hijau UIS & Kuning Emas) */
    .showcase-brand {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      align-self: flex-start;
      background: rgba(0, 0, 0, 0.82);
      backdrop-filter: blur(12px);
      border: 1.5px solid rgba(249, 220, 75, 0.45);
      padding: 8px 18px;
      border-radius: 100px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    }
    .showcase-logo-wrap {
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .showcase-logo-wrap img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .showcase-brand-text h2 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 800;
      color: #FFFFFF;
      line-height: 1.1;
    }
    .showcase-brand-text span {
      font-size: 11px;
      color: var(--uis-yellow);
      font-weight: 600;
      letter-spacing: 0.2px;
    }

    /* ── RIGHT AUTH PANEL (WARNA RESMI UIS: HIJAU LEMBUT & ELEGAN) ── */
    .auth-panel {
      flex: 0.95;
      background: linear-gradient(155deg, #f9dc4b 0%, #edf6f0 50%, #e2efe6 100%);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      padding: 24px 36px;
      height: 100vh;
      max-height: 100vh;
      overflow-y: auto;
      position: relative;
    }

    /* Top navigation bar */
    .auth-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      max-width: 420px;
      margin-bottom: 12px;
    }
    .btn-back-home {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--brand-primary);
      text-decoration: none;
      padding: 6px 14px;
      border-radius: 8px;
      border: 1.5px solid rgba(0, 0, 0, 0.25);
      background: #FFFFFF;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
      transition: var(--transition-smooth);
    }
    .btn-back-home:hover {
      color: #FFFFFF;
      border-color: var(--brand-primary);
      background: var(--brand-primary);
      transform: translateX(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .auth-badge-status {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 11.5px;
      color: var(--brand-primary);
      font-weight: 700;
      background: #FFFFFF;
      padding: 5px 12px;
      border-radius: 20px;
      border: 1.5px solid rgba(0, 0, 0, 0.25);
      white-space: nowrap;
      flex-shrink: 0;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    .auth-badge-status span:first-child {
      width: 6px;
      height: 6px;
      background: #22C55E;
      border-radius: 50%;
      box-shadow: 0 0 6px #22C55E;
    }

    /* Main form container */
    .auth-card-wrapper {
      width: 100%;
      max-width: 420px;
      margin: auto 0;
    }

    .auth-card {
      background: var(--card-bg);
      border-radius: 20px;
      padding: 26px 28px;
      border: 1.5px solid rgba(0, 0, 0, 0.16);
      border-top: 4px solid var(--brand-primary);
      box-shadow: var(--shadow-card);
      position: relative;
    }

    .auth-header {
      margin-bottom: 18px;
    }
    .auth-badge-top {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--brand-primary-light);
      color: var(--brand-primary);
      font-size: 11px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      padding: 3px 8px;
      border-radius: 6px;
      margin-bottom: 8px;
      border: 1px solid rgba(0, 0, 0, 0.15);
    }
    .auth-header h2 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: var(--text-heading);
      letter-spacing: -0.5px;
      margin-bottom: 4px;
    }
    .auth-header p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.45;
    }

    /* Alert Boxes */
    .alert-modern {
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 12.5px;
      font-weight: 500;
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 16px;
      line-height: 1.4;
    }
    .alert-modern-err {
      background: #FEF2F2;
      border: 1px solid #FEE2E2;
      color: #991B1B;
    }
    .alert-modern-ok {
      background: #F0FDF4;
      border: 1px solid #DCFCE7;
      color: #166534;
    }

    /* Form Elements */
    .form-group {
      margin-bottom: 14px;
    }
    .form-label-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 6px;
    }
    .form-label {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-heading);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .form-label-hint {
      font-size: 11px;
      color: var(--text-light);
      font-weight: 400;
    }

    .input-box {
      position: relative;
      display: flex;
      align-items: center;
    }
    .input-box .input-icon-lead {
      position: absolute;
      left: 14px;
      color: var(--text-light);
      font-size: 15px;
      pointer-events: none;
      transition: color 0.2s ease;
    }
    .custom-input {
      width: 100%;
      height: 44px;
      background: #FFFFFF;
      border: 1.5px solid var(--border-color);
      border-radius: 10px;
      padding: 0 42px 0 40px;
      font-size: 13.5px;
      color: var(--text-heading);
      font-family: 'Inter', sans-serif;
      outline: none;
      transition: var(--transition-smooth);
    }
    .custom-input::placeholder {
      color: #769280;
      font-size: 13px;
    }
    .custom-input:focus {
      background: #FFFFFF;
      border-color: var(--brand-primary);
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.16);
    }
    .input-box:focus-within .input-icon-lead {
      color: var(--brand-primary);
    }
    .custom-input.has-error {
      border-color: #EF4444;
      background: #FFFBFB;
    }

    .btn-toggle-eye {
      position: absolute;
      right: 10px;
      background: transparent;
      border: none;
      color: var(--text-light);
      cursor: pointer;
      padding: 6px;
      font-size: 15px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
    }
    .btn-toggle-eye:hover {
      color: var(--text-heading);
    }

    .error-feedback {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 11.5px;
      color: #DC2626;
      margin-top: 4px;
      font-weight: 500;
    }

    /* Actions Row */
    .form-options-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      font-size: 12.5px;
    }
    .remember-wrapper {
      display: flex;
      align-items: center;
      gap: 7px;
      cursor: pointer;
      user-select: none;
    }
    .remember-wrapper input[type="checkbox"] {
      width: 15px;
      height: 15px;
      accent-color: var(--brand-primary);
      cursor: pointer;
      border-radius: 4px;
    }
    .remember-wrapper span {
      color: var(--text-body);
      font-weight: 500;
    }

    /* Submit CTA */
    .btn-submit-login {
      width: 100%;
      height: 44px;
      background: linear-gradient(180deg, #057a2c 0%, #000000 100%);
      color: #FFFFFF;
      border: none;
      border-radius: 10px;
      font-size: 14.5px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      box-shadow: var(--shadow-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: var(--transition-smooth);
    }
    .btn-submit-login:hover {
      background: linear-gradient(180deg, #000000 0%, #024a19 100%);
      transform: translateY(-1px);
      box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.4);
    }
    .btn-submit-login:active {
      transform: translateY(0);
    }

    /* Alumni & Mitra Card */
    .alumni-card {
      margin-top: 14px;
      padding: 10px 14px;
      border-radius: 12px;
      background: #F4FAF6;
      border: 1.5px solid rgba(0, 0, 0, 0.18);
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      transition: var(--transition-smooth);
    }
    .alumni-card:hover {
      background: #F0FDF4;
      border-color: rgba(0, 0, 0, 0.35);
      transform: translateY(-1px);
    }
    .alumni-card-icon {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: var(--brand-primary-light);
      color: var(--brand-primary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .alumni-card-text {
      flex: 1;
    }
    .alumni-card-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 12px;
      font-weight: 700;
      color: var(--text-heading);
    }
    .alumni-card-sub {
      font-size: 11px;
      color: var(--text-muted);
      line-height: 1.3;
    }
    .alumni-card-arrow {
      color: var(--text-light);
      font-size: 12px;
    }

    /* Auth Footer */
    .auth-bottom-info {
      text-align: center;
      margin-top: 14px;
    }
    .security-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      color: var(--text-muted);
      margin-bottom: 4px;
    }
    .security-badge i {
      color: var(--brand-primary);
      font-size: 12px;
    }
    .auth-copyright {
      font-size: 11px;
      color: var(--text-light);
    }

    /* ── RESPONSIVE DESIGN ── */
    @media (max-width: 992px) {
      .showcase-panel {
        display: none; /* Pada tablet & mobile hanya fokus form */
      }
      .auth-panel {
        flex: 1;
        padding: 24px 20px;
      }
      html, body {
        overflow-y: auto; /* Izinkan scroll jika layar sangat kecil */
      }
    }
  </style>
</head>

<body>

<div class="auth-container">

  <!-- ══════════════════════════════════════════════════════════════════════
       LEFT SHOWCASE PANEL (FOTO ASLI GEDUNG UIS DENGAN WARNA NATURAL)
  ══════════════════════════════════════════════════════════════════════ -->
  <aside class="showcase-panel">
    <!-- Foto Asli Gedung Kampus UIS -->
    <div class="showcase-bg"></div>
    <div class="showcase-overlay"></div>

    <div class="showcase-content">
      <!-- Top Branding -->
      <a href="{{ route('homepage') }}" class="showcase-brand">
        <div class="showcase-logo-wrap">
          <img src="{{ asset('frontend/img/logouis.png') }}" alt="Lambang Resmi UIS">
        </div>
        <div class="showcase-brand-text">
          <h2>Teknik Informatika</h2>
          <span>Portal Akademik & Administrasi Terpadu</span>
        </div>
      </a>
    </div>
  </aside>

  <!-- ══════════════════════════════════════════════════════════════════════
       RIGHT AUTH PANEL (PAS DI LAYAR & TERTATA RAPI)
  ══════════════════════════════════════════════ -->
  <main class="auth-panel">
    <!-- Top Bar Navigation -->
    <div class="auth-topbar">
      <a href="{{ route('homepage') }}" class="btn-back-home">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Beranda</span>
      </a>

      <div class="auth-badge-status">
        <span></span>
        <span>Sistem Aktif</span>
      </div>
    </div>

    <!-- Center Card Wrapper -->
    <div class="auth-card-wrapper">
      <div class="auth-card">
        <!-- Auth Header -->
        <div class="auth-header">
          <div class="auth-badge-top">
            <i class="bi bi-shield-lock-fill"></i>
            <span>AUTENTIKASI AKUN</span>
          </div>
          <h2>Masuk ke Akun Anda</h2>
          <p>Gunakan kredensial resmi untuk mengakses panel kontrol sistem.</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
          <div class="alert-modern alert-modern-ok">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
          </div>
        @endif

        @if ($errors->has('email') && str_contains($errors->first('email'), 'salah'))
          <div class="alert-modern alert-modern-err">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ $errors->first('email') }}</div>
          </div>
        @endif

        <!-- Login Form -->
        <form id="formLogin" action="{{ route('loginproses') }}" method="POST" novalidate>
          @csrf

          <!-- Email / Username Field -->
          <div class="form-group">
            <div class="form-label-row">
              <label for="email" class="form-label">Email Institusi / Akun</label>
              <span class="form-label-hint">contoh: admin@uis.ac.id</span>
            </div>
            <div class="input-box">
              <i class="bi bi-envelope input-icon-lead"></i>
              <input 
                type="email" 
                id="email" 
                name="email" 
                class="custom-input {{ $errors->has('email') && !str_contains($errors->first('email'), 'salah') ? 'has-error' : '' }}" 
                placeholder="nama@uis.ac.id" 
                value="{{ old('email') }}" 
                autocomplete="email"
                required
              >
            </div>
            @error('email')
              @if (!str_contains($message, 'salah'))
                <div class="error-feedback">
                  <i class="bi bi-exclamation-circle-fill"></i>
                  <span>{{ $message }}</span>
                </div>
              @endif
            @enderror
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <div class="form-label-row">
              <label for="password" class="form-label">Kata Sandi</label>
            </div>
            <div class="input-box">
              <i class="bi bi-lock-fill input-icon-lead"></i>
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="custom-input {{ $errors->has('password') ? 'has-error' : '' }}" 
                placeholder="Masukkan kata sandi Anda" 
                autocomplete="current-password"
                required
              >
              <button type="button" id="togglePw" class="btn-toggle-eye" aria-label="Lihat kata sandi">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
            @error('password')
              <div class="error-feedback">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <!-- Options Row (Ingat Saya) -->
          <div class="form-options-row">
            <label class="remember-wrapper">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <span>Ingat saya di perangkat ini</span>
            </label>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-submit-login" id="btnMasuk">
            <span>Masuk ke Portal</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>

        <!-- Alumni / Mitra Public Action Card -->
        <a href="{{ route('homepage.alumni.create') }}" class="alumni-card">
          <div class="alumni-card-icon">
            <i class="bi bi-mortarboard-fill"></i>
          </div>
          <div class="alumni-card-text">
            <div class="alumni-card-title">
              <span>Alumni atau Mitra UIS?</span>
            </div>
            <div class="alumni-card-sub">
              Kirimkan ulasan & testimoni tanpa perlu login
            </div>
          </div>
          <i class="bi bi-chevron-right alumni-card-arrow"></i>
        </a>
      </div>

      <!-- Security & Copyright Footer -->
      <div class="auth-bottom-info">
        <div class="security-badge">
          <i class="bi bi-shield-check"></i>
          <span>Koneksi aman SSL 256-bit • Portal Resmi UIS</span>
        </div>
        <div class="auth-copyright">
          &copy; {{ date('Y') }} Teknik Informatika (UIS). Hak cipta dilindungi.
        </div>
      </div>
    </div>

    <!-- Empty bottom element for flex balance -->
    <div></div>
  </main>

</div>

<!-- Password Toggle Script -->
<script>
  document.getElementById('togglePw').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    const isPw  = input.type === 'password';

    input.type = isPw ? 'text' : 'password';
    icon.className = isPw ? 'bi bi-eye-slash' : 'bi bi-eye';
  });
</script>

</body>
</html>
