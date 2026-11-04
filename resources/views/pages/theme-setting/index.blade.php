@extends('layouts.dashboard.template')

@push('styles')
<style>
  .theme-preview-card {
    background: #111827;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
  }
  .theme-preview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }
  .preview-badge {
    background: rgba(249, 220, 75, 0.15);
    color: #f9dc4b;
    border: 1px solid rgba(249, 220, 75, 0.3);
    font-size: 11px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 99px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .mockup-navbar {
    border-radius: 12px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
  }
  .mockup-brand {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .mockup-logo {
    width: 38px;
    height: 38px;
    object-fit: contain;
  }
  .mockup-title {
    font-size: 14px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: 0.5px;
  }
  .mockup-subtitle {
    font-size: 11px;
    font-weight: 500;
    opacity: 0.85;
  }
  .mockup-nav-links {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .mockup-link {
    font-size: 12px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .mockup-btn-login {
    font-size: 12px;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  
  /* Color Presets Pill */
  .preset-palette-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 600;
    color: #1e293b;
    transition: all 0.2s ease;
  }
  .preset-palette-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: #cbd5e1;
  }
  .preset-color-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    display: inline-block;
    border: 1px solid rgba(0,0,0,0.15);
  }

  /* Color Input Group */
  .color-picker-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 8px 12px;
    transition: border-color 0.2s;
  }
  .color-picker-box:focus-within {
    border-color: #f9dc4b;
    box-shadow: 0 0 0 3px rgba(249, 220, 75, 0.2);
  }
  .color-input-native {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    padding: 0;
    background: transparent;
  }
  .color-input-native::-webkit-color-swatch-wrapper {
    padding: 0;
  }
  .color-input-native::-webkit-color-swatch {
    border: 1px solid rgba(0,0,0,0.15);
    border-radius: 8px;
  }

  /* Sortable Section Items */
  .section-sortable-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .section-item-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    transition: all 0.2s ease;
    user-select: none;
  }
  .section-item-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
  }
  .section-item-card.sortable-chosen {
    background: #fffbeb !important;
    border-color: #f59e0b !important;
    box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15) !important;
  }
  .section-drag-handle {
    cursor: grab;
    color: #94a3b8;
    font-size: 18px;
    display: flex;
    align-items: center;
    padding: 4px;
  }
  .section-drag-handle:active {
    cursor: grabbing;
  }
  .section-order-badge {
    width: 28px;
    height: 28px;
    background: #f1f5f9;
    color: #334155;
    font-weight: 800;
    font-size: 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .section-info-main {
    flex-grow: 1;
    min-width: 0;
  }
  .section-title-text {
    font-weight: 700;
    font-size: 14px;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-desc-text {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .section-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .btn-move-section {
    width: 30px;
    height: 30px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 12px;
    transition: all 0.15s ease;
  }
  .btn-move-section:hover:not(:disabled) {
    background: #000000;
    color: #ffffff;
    border-color: #000000;
  }
  .btn-move-section:disabled {
    opacity: 0.35;
    cursor: not-allowed;
  }
  .form-switch .form-check-input {
    width: 2.6em;
    height: 1.4em;
    cursor: pointer;
  }
  .form-switch .form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
  }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Warna Header & Tata Letak Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Tampilan & Navigasi</li>
            <li class="breadcrumb-item active">Warna Header & Tata Letak</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ═══════════════════════════════════════════════════════════
     1. LIVE PREVIEW CARD (REAL-TIME INTERAKTIF)
═══════════════════════════════════════════════════════════ -->
<div class="theme-preview-card">
  <div class="theme-preview-header">
    <div class="d-flex align-items-center gap-2">
      <span class="preview-badge"><i class="bi bi-eye-fill me-1"></i> Live Preview Header</span>
      <span class="text-white-50 small d-none d-sm-inline">Tampilan otomatis berubah saat memilih warna di bawah</span>
    </div>
    <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-light d-inline-flex align-items-center gap-1" style="font-size: 11.5px; border-radius: 8px;">
      <i class="bi bi-box-arrow-up-right"></i> Buka Website
    </a>
  </div>

  <!-- Mockup Navbar -->
  <div class="mockup-navbar" id="mockupNavbar" style="background-color: {{ $setting->header_bg_color }};">
    <!-- Brand -->
    <div class="mockup-brand">
      <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo" class="mockup-logo">
      <div>
        <div class="mockup-title" id="mockupTitle" style="color: {{ $setting->header_text_color }};">TEKNIK INFORMATIKA</div>
        <div class="mockup-subtitle" id="mockupSubtitle" style="color: {{ $setting->header_text_color }};">Fakultas Sains dan Teknologi</div>
      </div>
    </div>

    <!-- Nav Links (Desktop) -->
    <div class="mockup-nav-links d-none d-lg-flex">
      <span class="mockup-link" id="mockupLinkActive" style="background-color: {{ $setting->header_active_bg_color }}; color: {{ $setting->header_active_text_color }};">
        Beranda
      </span>
      <span class="mockup-link" id="mockupLinkNormal1" style="color: {{ $setting->header_text_color }};">
        Profil <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
      </span>
      <span class="mockup-link" id="mockupLinkNormal2" style="color: {{ $setting->header_text_color }};">
        Akademik <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
      </span>
      <span class="mockup-link" id="mockupLinkNormal3" style="color: {{ $setting->header_text_color }};">
        Dosen
      </span>
      <span class="mockup-link" id="mockupLinkNormal4" style="color: {{ $setting->header_text_color }};">
        PMB
      </span>
    </div>

    <!-- Login Button -->
    <div>
      <span class="mockup-btn-login" id="mockupBtnLogin" style="background-color: {{ $setting->header_login_bg_color }}; color: {{ $setting->header_login_text_color }};">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </span>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     FORM PENGATURAN TEMA & TATA LETAK
═══════════════════════════════════════════════════════════ -->
<form action="{{ route('theme.update') }}" method="POST" id="themeSettingForm">
  @csrf
  <input type="hidden" name="header_shadow_color" id="input_header_shadow_color" value="{{ old('header_shadow_color', $setting->header_shadow_color ?? $setting->header_bg_color) }}">
  <input type="hidden" name="accent_color" id="input_accent_color" value="{{ old('accent_color', $setting->accent_color ?? '#f9dc4b') }}">

  <div class="row g-4">

    <!-- ── KOLOM KIRI: PENGATURAN WARNA HEADER & TOPBAR ────── -->
    <div class="col-lg-5">
      
      <!-- Card Palet Preset Cepat -->
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0">
          <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-palette text-warning"></i> Palet Warna Siap Pakai (Preset)
          </h6>
          <p class="text-muted small mb-0">Klik salah satu palet untuk menerapkan kombinasi warna selaras secara instan</p>
        </div>
        <div class="card-body pt-0">
          <div class="d-flex flex-wrap gap-2">
            
            <!-- Preset 1: Kuning Khas FST UIS (Default) -->
            <button type="button" class="preset-palette-btn" onclick="applyPreset('#f9dc4b', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff')">
              <span class="preset-color-dot" style="background: #f9dc4b;"></span>
              <span>Kuning Khas UIS (Default)</span>
            </button>

            <!-- Preset 2: Hitam Elegan / Dark Modern -->
            <button type="button" class="preset-palette-btn" onclick="applyPreset('#000000', '#ffffff', '#f9dc4b', '#000000', '#f9dc4b', '#000000', '#000000', '#ffffff')">
              <span class="preset-color-dot" style="background: #000000;"></span>
              <span>Hitam Elegan (Dark Minimalist)</span>
            </button>

            <!-- Preset 3: Putih Bersih / Clean Light -->
            <button type="button" class="preset-palette-btn" onclick="applyPreset('#ffffff', '#1e293b', '#000000', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff')">
              <span class="preset-color-dot" style="background: #ffffff; border-color: #cbd5e1;"></span>
              <span>Putih Bersih (Clean Light)</span>
            </button>

            <!-- Preset 4: Biru Teknologi / Tech Slate -->
            <button type="button" class="preset-palette-btn" onclick="applyPreset('#0f172a', '#f8fafc', '#38bdf8', '#0f172a', '#38bdf8', '#0f172a', '#020617', '#ffffff')">
              <span class="preset-color-dot" style="background: #0f172a;"></span>
              <span>Biru Teknologi (Tech Slate)</span>
            </button>

            <!-- Preset 5: Hijau Zamrud / Emerald UIS -->
            <button type="button" class="preset-palette-btn" onclick="applyPreset('#064e3b', '#ffffff', '#10b981', '#ffffff', '#10b981', '#ffffff', '#022c22', '#ffffff')">
              <span class="preset-color-dot" style="background: #064e3b;"></span>
              <span>Hijau Zamrud (Emerald)</span>
            </button>

          </div>
        </div>
      </div>

      <!-- Card Kustomisasi Warna Header -->
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0">
          <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-sliders text-primary"></i> Kustomisasi Warna Header & Navbar
          </h6>
          <p class="text-muted small mb-0">Ubah detail warna sesuai identitas brand program studi</p>
        </div>
        <div class="card-body pt-0">

          <!-- 1. Background Header -->
          <div class="mb-3">
            <label class="form-label fw-semibold small text-dark mb-1">Warna Background Header / Navbar</label>
            <div class="color-picker-box">
              <input type="color" class="color-input-native" id="input_header_bg_color" name="header_bg_color" value="{{ old('header_bg_color', $setting->header_bg_color) }}" oninput="syncColor(this, 'text_header_bg_color')">
              <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_bg_color" value="{{ old('header_bg_color', $setting->header_bg_color) }}" oninput="syncColorFromText(this, 'input_header_bg_color')">
            </div>
          </div>

          <!-- 2. Teks / Brand Header -->
          <div class="mb-3">
            <label class="form-label fw-semibold small text-dark mb-1">Warna Teks Judul & Menu Normal</label>
            <div class="color-picker-box">
              <input type="color" class="color-input-native" id="input_header_text_color" name="header_text_color" value="{{ old('header_text_color', $setting->header_text_color) }}" oninput="syncColor(this, 'text_header_text_color')">
              <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_text_color" value="{{ old('header_text_color', $setting->header_text_color) }}" oninput="syncColorFromText(this, 'input_header_text_color')">
            </div>
          </div>

          <div class="row g-2 mb-3">
            <!-- 3. Background Menu Aktif -->
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Bg Menu Aktif</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_header_active_bg_color" name="header_active_bg_color" value="{{ old('header_active_bg_color', $setting->header_active_bg_color) }}" oninput="syncColor(this, 'text_header_active_bg_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_active_bg_color" value="{{ old('header_active_bg_color', $setting->header_active_bg_color) }}" oninput="syncColorFromText(this, 'input_header_active_bg_color')">
              </div>
            </div>
            <!-- 4. Teks Menu Aktif -->
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Teks Menu Aktif</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_header_active_text_color" name="header_active_text_color" value="{{ old('header_active_text_color', $setting->header_active_text_color) }}" oninput="syncColor(this, 'text_header_active_text_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_active_text_color" value="{{ old('header_active_text_color', $setting->header_active_text_color) }}" oninput="syncColorFromText(this, 'input_header_active_text_color')">
              </div>
            </div>
          </div>

          <div class="row g-2 mb-3">
            <!-- 5. Background Tombol Login -->
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Bg Tombol Login</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_header_login_bg_color" name="header_login_bg_color" value="{{ old('header_login_bg_color', $setting->header_login_bg_color) }}" oninput="syncColor(this, 'text_header_login_bg_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_login_bg_color" value="{{ old('header_login_bg_color', $setting->header_login_bg_color) }}" oninput="syncColorFromText(this, 'input_header_login_bg_color')">
              </div>
            </div>
            <!-- 6. Teks Tombol Login -->
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Teks Tombol Login</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_header_login_text_color" name="header_login_text_color" value="{{ old('header_login_text_color', $setting->header_login_text_color) }}" oninput="syncColor(this, 'text_header_login_text_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_login_text_color" value="{{ old('header_login_text_color', $setting->header_login_text_color) }}" oninput="syncColorFromText(this, 'input_header_login_text_color')">
              </div>
            </div>
          </div>

          <!-- 7. Sticky Header Toggle -->
          <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
            <div>
              <div class="fw-bold small text-dark">Sticky Header (Melayang)</div>
              <div class="text-muted" style="font-size: 11.5px;">Header tetap terlihat di bagian atas saat halaman di-scroll</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" name="header_is_sticky" id="header_is_sticky" value="1" {{ old('header_is_sticky', $setting->header_is_sticky) ? 'checked' : '' }}>
            </div>
          </div>

        </div>
      </div>

      <!-- Card Topbar & Aksen -->
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0">
          <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-window-dock text-dark"></i> Warna Topbar Bilah Atas
          </h6>
          <p class="text-muted small mb-0">Pengaturan warna bilah teks berjalan (marquee) di atas header</p>
        </div>
        <div class="card-body pt-0">
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Background Topbar</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_topbar_bg_color" name="topbar_bg_color" value="{{ old('topbar_bg_color', $setting->topbar_bg_color) }}" oninput="syncColor(this, 'text_topbar_bg_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_topbar_bg_color" value="{{ old('topbar_bg_color', $setting->topbar_bg_color) }}" oninput="syncColorFromText(this, 'input_topbar_bg_color')">
              </div>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold small text-dark mb-1">Teks Marquee Topbar</label>
              <div class="color-picker-box">
                <input type="color" class="color-input-native" id="input_topbar_text_color" name="topbar_text_color" value="{{ old('topbar_text_color', $setting->topbar_text_color) }}" oninput="syncColor(this, 'text_topbar_text_color')">
                <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_topbar_text_color" value="{{ old('topbar_text_color', $setting->topbar_text_color) }}" oninput="syncColorFromText(this, 'input_topbar_text_color')">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- ── KOLOM KANAN: PENGATURAN TATA LETAK & URUTAN SECTION ────── -->
    <div class="col-lg-7">
      <div class="card shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
          <div>
            <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
              <i class="bi bi-arrows-expand text-success"></i> Urutan & Visibilitas Section Beranda
            </h6>
            <p class="text-muted small mb-0">Geser (drag) atau gunakan tombol panah untuk mengubah tata letak antar bagian beranda</p>
          </div>
          <div class="badge bg-light text-dark border">
            Total: {{ count($sections) }} Section
          </div>
        </div>
        <div class="card-body pt-0">

          <div class="alert alert-light border d-flex align-items-center gap-2 py-2 px-3 mb-3" style="border-radius: 10px; font-size: 12.5px;">
            <i class="bi bi-info-circle text-primary fs-5"></i>
            <div>
              <strong>Tips:</strong> Matikan saklar (toggle switch) pada section yang ingin disembunyikan sementara dari beranda website tanpa menghapus isinya.
            </div>
          </div>

          <!-- Container List Section Sortable -->
          <div class="section-sortable-list" id="sortableSectionContainer">
            @foreach($sections as $index => $sec)
              <div class="section-item-card" data-key="{{ $sec['key'] }}">
                
                <!-- Drag Handle & Order Badge -->
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                  <span class="section-drag-handle" title="Tahan dan geser untuk memindahkan urutan">
                    <i class="bi bi-grip-vertical"></i>
                  </span>
                  <span class="section-order-badge badge-number">{{ $index + 1 }}</span>
                </div>

                <!-- Info Section -->
                <div class="section-info-main">
                  <div class="section-title-text">
                    <i class="bi {{ $sec['icon'] ?? 'bi-layout-text-window' }} text-primary"></i>
                    <span>{{ $sec['name'] }}</span>
                  </div>
                  <div class="section-desc-text">{{ $sec['desc'] ?? '' }}</div>
                </div>

                <!-- Actions: Up/Down Buttons & Toggle Active -->
                <div class="section-actions">
                  <!-- Up Button -->
                  <button type="button" class="btn-move-section btn-move-up" onclick="moveSection(this, -1)" title="Pindahkan ke atas">
                    <i class="bi bi-chevron-up"></i>
                  </button>
                  <!-- Down Button -->
                  <button type="button" class="btn-move-section btn-move-down" onclick="moveSection(this, 1)" title="Pindahkan ke bawah">
                    <i class="bi bi-chevron-down"></i>
                  </button>

                  <!-- Toggle Switch Active -->
                  <div class="form-check form-switch ms-2 mb-0" title="Tampilkan atau sembunyikan section ini di beranda">
                    <input class="form-check-input section-active-toggle" 
                           type="checkbox" 
                           name="sections[{{ $sec['key'] }}][is_active]" 
                           value="1" 
                           {{ !empty($sec['is_active']) ? 'checked' : '' }}>
                  </div>

                  <!-- Hidden Input Order -->
                  <input type="hidden" class="section-order-input" name="sections[{{ $sec['key'] }}][order]" value="{{ $index + 1 }}">
                </div>

              </div>
            @endforeach
          </div>

          <!-- Bottom Sticky Actions -->
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-4 mt-4 border-top">
            <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2" onclick="confirmReset()" style="border-radius: 10px; font-weight: 600;">
              <i class="bi bi-arrow-counterclockwise"></i> Reset ke Standar Awal
            </button>

            <button type="submit" class="btn btn-warning px-4 py-2 text-dark fw-bold d-inline-flex align-items-center gap-2 shadow-sm" style="background: #f9dc4b; border: none; border-radius: 10px;">
              <i class="bi bi-check2-circle fs-5"></i> Simpan Perubahan Tampilan
            </button>
          </div>

        </div>
      </div>
    </div>

  </div>
</form>

<!-- Form Reset Terpisah -->
<form id="formResetTheme" action="{{ route('theme.reset') }}" method="POST" class="d-none">
  @csrf
</form>

@endsection

@push('scripts')
<!-- SortableJS untuk Drag and Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('sortableSectionContainer');

  // Inisialisasi SortableJS Drag & Drop
  if (container) {
    Sortable.create(container, {
      animation: 200,
      handle: '.section-drag-handle',
      ghostClass: 'sortable-chosen',
      onEnd: function () {
        updateSectionOrders();
      }
    });
  }

  // Update urutan awal dan disable tombol edge
  updateSectionOrders();
  refreshPreview();
});

// Fungsi memindahkan baris section dengan tombol panah naik/turun
function moveSection(btn, direction) {
  const card = btn.closest('.section-item-card');
  const container = document.getElementById('sortableSectionContainer');
  
  if (direction === -1) {
    const prev = card.previousElementSibling;
    if (prev) {
      container.insertBefore(card, prev);
    }
  } else if (direction === 1) {
    const next = card.nextElementSibling;
    if (next) {
      container.insertBefore(next, card);
    }
  }
  updateSectionOrders();
}

// Sinkronkan nomor urut badge dan hidden input
function updateSectionOrders() {
  const cards = document.querySelectorAll('#sortableSectionContainer .section-item-card');
  cards.forEach((card, idx) => {
    const num = idx + 1;
    const badge = card.querySelector('.badge-number');
    const orderInput = card.querySelector('.section-order-input');
    const btnUp = card.querySelector('.btn-move-up');
    const btnDown = card.querySelector('.btn-move-down');

    if (badge) badge.textContent = num;
    if (orderInput) orderInput.value = num;

    if (btnUp) btnUp.disabled = (idx === 0);
    if (btnDown) btnDown.disabled = (idx === cards.length - 1);
  });
}

// Sinkronkan Color Picker Native dengan Text Input Hex & Live Preview
function syncColor(colorInput, textInputId) {
  const textInput = document.getElementById(textInputId);
  if (textInput) {
    textInput.value = colorInput.value.toUpperCase();
  }
  if (colorInput.id === 'input_header_bg_color') {
    const shadowInput = document.getElementById('input_header_shadow_color');
    if (shadowInput) shadowInput.value = colorInput.value;
  }
  refreshPreview();
}

function syncColorFromText(textInput, colorInputId) {
  const colorInput = document.getElementById(colorInputId);
  let val = textInput.value.trim();
  if (!val.startsWith('#')) {
    val = '#' + val;
  }
  if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
    if (colorInput) colorInput.value = val;
    if (colorInputId === 'input_header_bg_color') {
      const shadowInput = document.getElementById('input_header_shadow_color');
      if (shadowInput) shadowInput.value = val;
    }
    refreshPreview();
  }
}

// Terapkan Palet Preset
function applyPreset(bg, text, actBg, actText, logBg, logText, topBg, topText) {
  setFieldColor('header_bg_color', bg);
  setFieldColor('header_text_color', text);
  setFieldColor('header_active_bg_color', actBg);
  setFieldColor('header_active_text_color', actText);
  setFieldColor('header_login_bg_color', logBg);
  setFieldColor('header_login_text_color', logText);
  setFieldColor('topbar_bg_color', topBg);
  setFieldColor('topbar_text_color', topText);
  const shadowInput = document.getElementById('input_header_shadow_color');
  if (shadowInput) shadowInput.value = bg;
  refreshPreview();
}

function setFieldColor(name, colorVal) {
  const colorInput = document.getElementById('input_' + name);
  const textInput = document.getElementById('text_' + name);
  if (colorInput) colorInput.value = colorVal;
  if (textInput) textInput.value = colorVal.toUpperCase();
}

// Refresh Live Interactive Preview Header Mockup
function refreshPreview() {
  const bg = document.getElementById('input_header_bg_color')?.value || '#f9dc4b';
  const text = document.getElementById('input_header_text_color')?.value || '#ffffff';
  const actBg = document.getElementById('input_header_active_bg_color')?.value || '#000000';
  const actText = document.getElementById('input_header_active_text_color')?.value || '#ffffff';
  const logBg = document.getElementById('input_header_login_bg_color')?.value || '#000000';
  const logText = document.getElementById('input_header_login_text_color')?.value || '#ffffff';

  const mockupNav = document.getElementById('mockupNavbar');
  const mockupTitle = document.getElementById('mockupTitle');
  const mockupSubtitle = document.getElementById('mockupSubtitle');
  const mockupActive = document.getElementById('mockupLinkActive');
  const mockupLogin = document.getElementById('mockupBtnLogin');

  if (mockupNav) mockupNav.style.backgroundColor = bg;
  if (mockupTitle) mockupTitle.style.color = text;
  if (mockupSubtitle) mockupSubtitle.style.color = text;

  if (mockupActive) {
    mockupActive.style.backgroundColor = actBg;
    mockupActive.style.color = actText;
  }

  for (let i = 1; i <= 4; i++) {
    const el = document.getElementById('mockupLinkNormal' + i);
    if (el) el.style.color = text;
  }

  if (mockupLogin) {
    mockupLogin.style.backgroundColor = logBg;
    mockupLogin.style.color = logText;
  }
}

// Konfirmasi Reset ke Default
function confirmReset() {
  if (confirm('Apakah Anda yakin ingin mengembalikan seluruh warna header dan urutan section ke standar awal?')) {
    document.getElementById('formResetTheme').submit();
  }
}
</script>
@endpush

