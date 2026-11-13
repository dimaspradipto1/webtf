@extends('layouts.dashboard.template')

@push('styles')
<style>
  /* ── Tab Navigation Modern ── */
  .custom-theme-pills {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 6px;
    display: flex;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
  }
  .custom-theme-pills .nav-link {
    border-radius: 12px;
    color: #475569;
    background: transparent;
    padding: 10px 18px;
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }
  .custom-theme-pills .nav-link:hover {
    background: #f8fafc;
    color: #0f172a;
  }
  .custom-theme-pills .nav-link.active {
    background: #0f172a !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
  }
  .custom-theme-pills .nav-link.active .tab-icon {
    color: #f9dc4b !important;
  }
  .custom-theme-pills .nav-link.active .tab-subtitle {
    color: rgba(255, 255, 255, 0.75) !important;
  }

  /* ── Frame Mockup Browser Preview ── */
  .browser-frame-card {
    background: #0b0f19;
    border-radius: 18px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.28);
    overflow: hidden;
    margin-bottom: 24px;
    transition: all 0.3s ease;
  }
  .browser-frame-bar {
    background: #111827;
    padding: 10px 18px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .browser-dots {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .browser-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
  }
  .browser-dot.red { background: #ef4444; }
  .browser-dot.yellow { background: #f59e0b; }
  .browser-dot.green { background: #10b981; }
  
  .browser-address-bar {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    font-size: 11.5px;
    font-family: monospace;
    padding: 3px 14px;
    border-radius: 99px;
    display: flex;
    align-items: center;
    gap: 6px;
    max-width: 320px;
    width: 100%;
    justify-content: center;
  }
  .preview-live-badge {
    background: rgba(249, 220, 75, 0.18);
    color: #f9dc4b;
    border: 1px solid rgba(249, 220, 75, 0.35);
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 99px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .pulse-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #f9dc4b;
    animation: pulse 1.6s infinite ease-in-out;
  }
  @keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.4); opacity: 0.5; }
  }

  /* ── Header Mockup ── */
  .mockup-topbar {
    padding: 7px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.3px;
    transition: all 0.2s ease;
  }
  .mockup-topbar-marquee {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .mockup-navbar {
    padding: 14px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.25s ease;
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
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
  }
  .mockup-subtitle {
    font-size: 11px;
    font-weight: 500;
    opacity: 0.88;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  }
  .mockup-nav-links {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .mockup-link {
    font-size: 12px;
    font-weight: 700;
    padding: 6px 11px;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.2s ease;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
    white-space: nowrap;
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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  }
  .mockup-btn-lang {
    font-size: 11.5px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    white-space: nowrap;
  }

  /* ── Footer Mockup ── */
  .mockup-footer {
    padding: 24px 24px 16px;
    transition: all 0.25s ease;
  }
  .mockup-footer-social-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12.5px;
    transition: all 0.2s ease;
  }
  .mockup-footer-link-item {
    font-size: 11.5px;
    display: flex;
    align-items: center;
    gap: 5px;
    line-height: 1.6;
    transition: all 0.2s ease;
  }

  /* ── Presets & Color Input Box ── */
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

  /* ── Sortable Section Items ── */
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
  
  /* Sticky Action Bar */
  .sticky-bottom-actions {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Warna Header, Footer & Tata Letak Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Tampilan & Navigasi</li>
            <li class="breadcrumb-item active">Warna Header, Footer & Layout</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
        <i class="bi bi-check-circle-fill me-2 fs-5 text-success align-middle"></i>
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- ═══════════════════════════════════════════════════════════
     TAB NAVIGASI: HEADER | FOOTER | TATA LETAK SECTION
═══════════════════════════════════════════════════════════ -->
<ul class="nav nav-pills custom-theme-pills mb-4" id="themeTabs" role="tablist">
  
  <!-- Tab 1: Header & Topbar -->
  <li class="nav-item flex-fill" role="presentation">
    <button class="nav-link active w-100 d-flex align-items-center justify-content-center gap-2" 
            id="tab-header-btn" 
            data-bs-toggle="pill" 
            data-bs-target="#tab-header-pane" 
            type="button" 
            role="tab" 
            aria-controls="tab-header-pane" 
            aria-selected="true">
      <i class="bi bi-window-dock fs-5 tab-icon"></i>
      <div class="text-start">
        <div class="fw-bold fs-6">Header & Topbar</div>
        <div class="small text-muted tab-subtitle" style="font-size: 11px;">Preview & pengaturan navbar atas</div>
      </div>
    </button>
  </li>

  <!-- Tab 2: Footer Website -->
  <li class="nav-item flex-fill" role="presentation">
    <button class="nav-link w-100 d-flex align-items-center justify-content-center gap-2" 
            id="tab-footer-btn" 
            data-bs-toggle="pill" 
            data-bs-target="#tab-footer-pane" 
            type="button" 
            role="tab" 
            aria-controls="tab-footer-pane" 
            aria-selected="false">
      <i class="bi bi-layout-sidebar-inset-reverse fs-5 tab-icon"></i>
      <div class="text-start">
        <div class="fw-bold fs-6">Footer Website</div>
        <div class="small text-muted tab-subtitle" style="font-size: 11px;">Preview, warna & konten bawah</div>
      </div>
    </button>
  </li>

  <!-- Tab 3: Tata Letak & Section Beranda -->
  <li class="nav-item flex-fill" role="presentation">
    <button class="nav-link w-100 d-flex align-items-center justify-content-center gap-2" 
            id="tab-sections-btn" 
            data-bs-toggle="pill" 
            data-bs-target="#tab-sections-pane" 
            type="button" 
            role="tab" 
            aria-controls="tab-sections-pane" 
            aria-selected="false">
      <i class="bi bi-arrows-expand fs-5 tab-icon"></i>
      <div class="text-start">
        <div class="fw-bold fs-6">Tata Letak Beranda</div>
        <div class="small text-muted tab-subtitle" style="font-size: 11px;">Urutan & visibilitas 14 section</div>
      </div>
    </button>
  </li>

</ul>

<!-- ═══════════════════════════════════════════════════════════
     FORM UTAMA: MEMBUNGKUS SELURUH TAB
═══════════════════════════════════════════════════════════ -->
<form action="{{ route('theme.update') }}" method="POST" id="themeSettingForm" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="header_shadow_color" id="input_header_shadow_color" value="{{ old('header_shadow_color', $setting->header_shadow_color ?? $setting->header_bg_color) }}">
  <input type="hidden" name="accent_color" id="input_accent_color" value="{{ old('accent_color', $setting->accent_color ?? '#f9dc4b') }}">

  <div class="tab-content" id="themeTabsContent">

    <!-- ─────────────────────────────────────────────────────────────
         TAB PANE 1: HEADER & TOPBAR DENGAN PREVIEW HEADER
    ───────────────────────────────────────────────────────────── -->
    <div class="tab-pane fade show active" id="tab-header-pane" role="tabpanel" aria-labelledby="tab-header-btn">
      
      <!-- 1. LIVE PREVIEW HEADER & TOPBAR (Lengkap di Bagian Atas) -->
      <div class="browser-frame-card">
        <div class="browser-frame-bar">
          <div class="browser-dots">
            <span class="browser-dot red"></span>
            <span class="browser-dot yellow"></span>
            <span class="browser-dot green"></span>
          </div>
          <div class="browser-address-bar d-none d-sm-flex">
            <i class="bi bi-lock-fill text-warning"></i>
            <span>https://tf.uis.ac.id/</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="preview-live-badge"><span class="pulse-dot"></span> Live Preview Header</span>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-light d-none d-md-inline-flex align-items-center gap-1" style="font-size: 11px; border-radius: 6px;">
              <i class="bi bi-box-arrow-up-right"></i> Website
            </a>
          </div>
        </div>

        <!-- Mockup Topbar -->
        <div class="mockup-topbar" id="mockupTopbar" style="background-color: {{ $setting->topbar_bg_color }}; color: {{ $setting->topbar_text_color }};">
          <div class="mockup-topbar-marquee">
            <i class="bi bi-megaphone-fill text-warning"></i>
            <span>Fakultas Sains & Teknologi Universitas Ibnu Sina — Program Studi S1 Teknik Informatika (UIS)</span>
          </div>
          <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <i class="bi bi-search" id="mockupTopbarSearch" style="font-size: 11px; color: {{ $setting->topbar_social_text_color ?? '#ffffff' }};"></i>
            <span class="badge rounded-circle p-1" id="mockupTopbarSosmed1" style="background-color: {{ $setting->topbar_social_bg_color ?? '#ffffff' }}; color: {{ $setting->topbar_social_text_color ?? '#000000' }}; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px;"><i class="bi bi-facebook"></i></span>
            <span class="badge rounded-circle p-1" id="mockupTopbarSosmed2" style="background-color: {{ $setting->topbar_social_bg_color ?? '#ffffff' }}; color: {{ $setting->topbar_social_text_color ?? '#000000' }}; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px;"><i class="bi bi-instagram"></i></span>
            <span class="badge rounded-circle p-1" id="mockupTopbarSosmed3" style="background-color: {{ $setting->topbar_social_bg_color ?? '#ffffff' }}; color: {{ $setting->topbar_social_text_color ?? '#000000' }}; width: 18px; height: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px;"><i class="bi bi-youtube"></i></span>
          </div>
        </div>

        <!-- Mockup Navbar -->
        <div class="mockup-navbar" id="mockupNavbar" style="background-color: {{ $setting->header_bg_color }};">
          <!-- Brand -->
          <div class="mockup-brand">
            <img src="{{ $setting->logo_url }}" alt="Logo" class="mockup-logo" id="mockupLogo">
            <div>
              <div class="mockup-title" id="mockupTitle" style="color: {{ $setting->header_text_color }};">{{ $setting->header_title ?: 'TEKNIK INFORMATIKA' }}</div>
              <div class="mockup-subtitle" id="mockupSubtitle" style="color: {{ $setting->header_text_color }};">{{ $setting->header_subtitle ?: 'Fakultas Sains dan Teknologi' }}</div>
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
              Publikasi <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
            </span>
            <span class="mockup-link" id="mockupLinkNormal5" style="color: {{ $setting->header_text_color }};">
              Portal <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
            </span>
            <span class="mockup-link" id="mockupLinkNormal6" style="color: {{ $setting->header_text_color }};">
              Kontak
            </span>
            <span class="mockup-link" id="mockupLinkNormal7" style="color: {{ $setting->header_text_color }};">
              PMB <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
            </span>
            <span class="mockup-btn-lang" id="mockupBtnLang" style="background-color: {{ $setting->header_lang_bg_color }}; color: {{ $setting->header_lang_text_color }};">
              <img src="{{ asset('assets/img/flags/id.png') }}" alt="ID" style="width: 18px; height: 12px; object-fit: cover; border-radius: 2px;">
              <span>Bahasa Indonesia</span>
              <i class="bi bi-chevron-down" style="font-size: 9px;"></i>
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

      <!-- 2. IDENTITAS BRAND & LOGO HEADER -->
      <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-shield-check text-warning"></i> Identitas Logo & Teks Brand Header
              </h6>
              <p class="text-muted small mb-0">Atur logo prodi/UIS, judul utama, dan subjudul fakultas yang tampil di header dan footer</p>
            </div>
            <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 11.5px; border-radius: 8px;">
              <i class="bi bi-arrow-repeat text-primary me-1"></i> Sinkron ke Header & Footer
            </span>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="row g-4 align-items-center">
            
            <!-- Kolom Upload Logo Brand -->
            <div class="col-lg-4 col-md-5">
              <label class="form-label fw-semibold small text-dark mb-2 d-flex align-items-center gap-1">
                <i class="bi bi-image text-warning"></i> Logo Brand Header
              </label>
              <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border">
                <div class="logo-preview-box text-center p-2 bg-white rounded-3 shadow-sm border flex-shrink-0" style="width: 72px; height: 72px; display: flex; align-items: center; justify-content: center;">
                  <img src="{{ $setting->logo_url }}" id="header_logo_preview" alt="Preview Logo" style="max-height: 56px; max-width: 56px; object-fit: contain;">
                </div>
                <div class="flex-grow-1">
                  <input type="file" name="header_logo" id="input_header_logo" accept="image/png,image/jpeg,image/webp,image/svg+xml" class="form-control form-control-sm" onchange="previewHeaderLogo(this)">
                  <div class="text-muted mt-1" style="font-size: 11px;">PNG, JPG, WEBP, SVG (Maks. 10MB). Rekomendasi transparan.</div>
                  @if($setting->hasCustomLogo())
                    <div class="form-check mt-2">
                      <input class="form-check-input" type="checkbox" name="remove_header_logo" value="1" id="remove_header_logo" onchange="toggleRemoveLogo(this)">
                      <label class="form-check-label text-danger small fw-semibold" for="remove_header_logo" style="font-size: 11px; cursor: pointer;">
                        <i class="bi bi-arrow-counterclockwise"></i> Gunakan Logo Default UIS
                      </label>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- Kolom Judul Utama & Subjudul -->
            <div class="col-lg-8 col-md-7">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-dark mb-1 d-flex align-items-center gap-1" for="input_header_title">
                    <i class="bi bi-type-h1 text-primary"></i> Judul Utama Header
                  </label>
                  <input type="text" 
                         class="form-control" 
                         id="input_header_title" 
                         name="header_title" 
                         value="{{ old('header_title', $setting->header_title) }}" 
                         placeholder="TEKNIK INFORMATIKA" 
                         maxlength="100"
                         oninput="updateHeaderBrandPreview()"
                         style="border-radius: 10px; font-weight: 700; font-size: 13.5px;">
                  <div class="text-muted mt-1" style="font-size: 11px;">Contoh: <strong>TEKNIK INFORMATIKA</strong> (Teks baris atas tebal)</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-dark mb-1 d-flex align-items-center gap-1" for="input_header_subtitle">
                    <i class="bi bi-type text-info"></i> Subjudul Header
                  </label>
                  <input type="text" 
                         class="form-control" 
                         id="input_header_subtitle" 
                         name="header_subtitle" 
                         value="{{ old('header_subtitle', $setting->header_subtitle) }}" 
                         placeholder="Fakultas Sains dan Teknologi" 
                         maxlength="150"
                         oninput="updateHeaderBrandPreview()"
                         style="border-radius: 10px; font-size: 13.5px;">
                  <div class="text-muted mt-1" style="font-size: 11px;">Contoh: <strong>Fakultas Sains dan Teknologi</strong> (Teks baris bawah)</div>
                </div>
              </div>

              <div class="mt-3 p-2 px-3 bg-light rounded-3 d-flex align-items-center gap-2 text-muted" style="font-size: 11.5px;">
                <i class="bi bi-info-circle-fill text-warning flex-shrink-0"></i>
                <span>Teks judul dan subjudul ini akan langsung tampil di navbar header, footer situs, dan judul dashboard admin.</span>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- 3. PENGATURAN KONTROL WARNA HEADER & TOPBAR (2 Kolom) -->
      <div class="row g-4">
        
        <!-- Kolom Kiri: Preset & Warna Topbar -->
        <div class="col-lg-5">
          <!-- Card Presets -->
          <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 border-0">
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-palette text-warning"></i> Palet Warna Siap Pakai (Preset)
              </h6>
              <p class="text-muted small mb-0">Klik salah satu kombinasi warna untuk menerapkan tema secara instan</p>
            </div>
            <div class="card-body pt-0">
              <div class="d-flex flex-wrap gap-2">
                <!-- Preset 1: Kuning Khas UIS (Default) -->
                <button type="button" class="preset-palette-btn" onclick="applyPreset('#f9dc4b', '#000000', '#000000', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff', '#f9dc4b', '#f9dc4b', '#ffffff', '#f9dc4b', '#f9dc4b', '#000000', '#ffffff', '#000000')">
                  <span class="preset-color-dot" style="background: #f9dc4b;"></span>
                  <span>Kuning Khas UIS (Default)</span>
                </button>
                <!-- Preset 2: Hitam Elegan -->
                <button type="button" class="preset-palette-btn" onclick="applyPreset('#000000', '#ffffff', '#f9dc4b', '#000000', '#f9dc4b', '#000000', '#000000', '#ffffff', '#0b0f19', '#e2e8f0', '#f9dc4b', '#f9dc4b', '#e2e8f0', '#f9dc4b', '#f9dc4b', '#000000', '#f9dc4b', '#000000')">
                  <span class="preset-color-dot" style="background: #000000;"></span>
                  <span>Hitam Elegan (Dark Modern)</span>
                </button>
                <!-- Preset 3: Putih Bersih -->
                <button type="button" class="preset-palette-btn" onclick="applyPreset('#ffffff', '#1e293b', '#000000', '#ffffff', '#000000', '#ffffff', '#000000', '#ffffff', '#1e293b', '#f8fafc', '#f9dc4b', '#f9dc4b', '#cbd5e1', '#ffffff', '#ffffff', '#1e293b', '#ffffff', '#1e293b')">
                  <span class="preset-color-dot" style="background: #ffffff; border-color: #cbd5e1;"></span>
                  <span>Putih Bersih (Clean Light)</span>
                </button>
                <!-- Preset 4: Biru Teknologi -->
                <button type="button" class="preset-palette-btn" onclick="applyPreset('#0f172a', '#f8fafc', '#38bdf8', '#0f172a', '#38bdf8', '#0f172a', '#020617', '#ffffff', '#020617', '#cbd5e1', '#38bdf8', '#38bdf8', '#94a3b8', '#38bdf8', '#38bdf8', '#020617', '#38bdf8', '#020617')">
                  <span class="preset-color-dot" style="background: #0f172a;"></span>
                  <span>Biru Teknologi (Tech Slate)</span>
                </button>
                <!-- Preset 5: Hijau Zamrud -->
                <button type="button" class="preset-palette-btn" onclick="applyPreset('#064e3b', '#ffffff', '#10b981', '#ffffff', '#10b981', '#ffffff', '#022c22', '#ffffff', '#022c22', '#d1fae5', '#34d399', '#10b981', '#a7f3d0', '#ffffff', '#10b981', '#022c22', '#10b981', '#022c22')">
                  <span class="preset-color-dot" style="background: #064e3b;"></span>
                  <span>Hijau Zamrud (Emerald)</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Card Topbar -->
          <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 border-0">
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-window-dock text-dark"></i> Warna Topbar Bilah Atas
              </h6>
              <p class="text-muted small mb-0">Warna bilah teks marquee dan tombol icon medsos/search di atas navbar</p>
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
                  <label class="form-label fw-semibold small text-dark mb-1">Teks Marquee</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_topbar_text_color" name="topbar_text_color" value="{{ old('topbar_text_color', $setting->topbar_text_color) }}" oninput="syncColor(this, 'text_topbar_text_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_topbar_text_color" value="{{ old('topbar_text_color', $setting->topbar_text_color) }}" oninput="syncColorFromText(this, 'input_topbar_text_color')">
                  </div>
                </div>
              </div>

              <!-- Baris Pengaturan Icon Medsos & Search Topbar -->
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Bg Tombol Icon</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_topbar_social_bg_color" name="topbar_social_bg_color" value="{{ old('topbar_social_bg_color', $setting->topbar_social_bg_color ?? '#ffffff') }}" oninput="syncColor(this, 'text_topbar_social_bg_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_topbar_social_bg_color" value="{{ old('topbar_social_bg_color', $setting->topbar_social_bg_color ?? '#ffffff') }}" oninput="syncColorFromText(this, 'input_topbar_social_bg_color')">
                  </div>
                </div>
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Warna Icon Medsos & Search</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_topbar_social_text_color" name="topbar_social_text_color" value="{{ old('topbar_social_text_color', $setting->topbar_social_text_color ?? '#000000') }}" oninput="syncColor(this, 'text_topbar_social_text_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_topbar_social_text_color" value="{{ old('topbar_social_text_color', $setting->topbar_social_text_color ?? '#000000') }}" oninput="syncColorFromText(this, 'input_topbar_social_text_color')">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Kustomisasi Navbar Utama -->
        <div class="col-lg-7">
          <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 border-0">
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-sliders text-primary"></i> Kustomisasi Warna Navbar Header
              </h6>
              <p class="text-muted small mb-0">Sesuaikan kombinasi warna sesuai identitas brand program studi</p>
            </div>
            <div class="card-body pt-0">
              
              <!-- 1. Background Header -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark mb-1">Warna Background Navbar Header</label>
                <div class="color-picker-box">
                  <input type="color" class="color-input-native" id="input_header_bg_color" name="header_bg_color" value="{{ old('header_bg_color', $setting->header_bg_color) }}" oninput="syncColor(this, 'text_header_bg_color')">
                  <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_bg_color" value="{{ old('header_bg_color', $setting->header_bg_color) }}" oninput="syncColorFromText(this, 'input_header_bg_color')">
                </div>
              </div>

              <!-- 2. Teks Judul & Menu Normal -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark mb-1">Warna Teks Judul Prodi & Menu Normal</label>
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

              <div class="row g-2 mb-3">
                <!-- 7. Background Tombol Bahasa -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Bg Tombol Bahasa</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_header_lang_bg_color" name="header_lang_bg_color" value="{{ old('header_lang_bg_color', $setting->header_lang_bg_color) }}" oninput="syncColor(this, 'text_header_lang_bg_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_lang_bg_color" value="{{ old('header_lang_bg_color', $setting->header_lang_bg_color) }}" oninput="syncColorFromText(this, 'input_header_lang_bg_color')">
                  </div>
                </div>
                <!-- 8. Teks Tombol Bahasa -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Teks Tombol Bahasa</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_header_lang_text_color" name="header_lang_text_color" value="{{ old('header_lang_text_color', $setting->header_lang_text_color) }}" oninput="syncColor(this, 'text_header_lang_text_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_header_lang_text_color" value="{{ old('header_lang_text_color', $setting->header_lang_text_color) }}" oninput="syncColorFromText(this, 'input_header_lang_text_color')">
                  </div>
                </div>
              </div>

              <!-- 9. Sticky Header Toggle -->
              <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                <div>
                  <div class="fw-bold small text-dark">Sticky Header (Melayang saat di-scroll)</div>
                  <div class="text-muted" style="font-size: 11.5px;">Header tetap menempel di bagian paling atas layar saat pengunjung men-scroll halaman</div>
                </div>
                <div class="form-check form-switch m-0">
                  <input class="form-check-input" type="checkbox" name="header_is_sticky" id="header_is_sticky" value="1" {{ old('header_is_sticky', $setting->header_is_sticky) ? 'checked' : '' }}>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────
         TAB PANE 2: FOOTER WEBSITE DENGAN PREVIEW FOOTER
    ───────────────────────────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-footer-pane" role="tabpanel" aria-labelledby="tab-footer-btn">
      
      <!-- 1. LIVE PREVIEW FOOTER (Lengkap di Bagian Atas) -->
      <div class="browser-frame-card">
        <div class="browser-frame-bar">
          <div class="browser-dots">
            <span class="browser-dot red"></span>
            <span class="browser-dot yellow"></span>
            <span class="browser-dot green"></span>
          </div>
          <div class="browser-address-bar d-none d-sm-flex">
            <i class="bi bi-layout-sidebar-inset-reverse text-warning"></i>
            <span>Preview Footer Website</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <span class="preview-live-badge"><span class="pulse-dot"></span> Live Preview Footer</span>
            <a href="{{ url('/') }}#footer" target="_blank" class="btn btn-sm btn-outline-light d-none d-md-inline-flex align-items-center gap-1" style="font-size: 11px; border-radius: 6px;">
              <i class="bi bi-box-arrow-up-right"></i> Buka Website
            </a>
          </div>
        </div>

        <!-- Mockup Footer Lengkap 4 Kolom -->
        <div class="mockup-footer" id="mockupFooter" style="background-color: {{ $setting->footer_bg_color ?? '#000000' }}; border-top: 4px solid {{ $setting->footer_border_top_color ?? '#f9dc4b' }};">
          <div class="row g-4">
            
            <!-- Kolom 1: Brand, Deskripsi & Medsos -->
            <div class="col-lg-4">
              <div class="d-flex align-items-center gap-2 mb-2">
                <img src="{{ $setting->logo_url }}" id="mockupFooterLogo" alt="Logo" style="height: 38px; width: auto; object-fit: contain;">
                <div>
                  <div class="fw-bold" id="mockupFooterBrandTitle" style="font-size: 14px; color: {{ $setting->footer_heading_color ?? '#f9dc4b' }}; line-height: 1.15;">{{ $setting->header_title ?: 'TEKNIK INFORMATIKA' }}</div>
                  <div id="mockupFooterBrandSubtitle" style="font-size: 11px; color: {{ $setting->footer_text_color ?? '#ffffff' }}; opacity: 0.85;">{{ $setting->header_subtitle ?: 'Fakultas Sains dan Teknologi' }}</div>
                </div>
              </div>
              <p class="mb-3" id="mockupFooterDesc" style="font-size: 12px; line-height: 1.5; color: {{ $setting->footer_text_color ?? '#ffffff' }}; opacity: 0.9;">
                {{ $setting->footer_description ?: 'Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Berkomitmen menyelenggarakan pendidikan tinggi teknologi informasi yang unggul, bermartabat, bereputasi nasional dan internasional.' }}
              </p>
              <div class="d-flex gap-2">
                <span class="mockup-footer-social-icon" id="mockupFooterSocial1" style="background: {{ $setting->footer_social_bg_color ?? '#f9dc4b' }}; color: {{ $setting->footer_social_text_color ?? '#000000' }};"><i class="bi bi-instagram"></i></span>
                <span class="mockup-footer-social-icon" id="mockupFooterSocial2" style="background: {{ $setting->footer_social_bg_color ?? '#f9dc4b' }}; color: {{ $setting->footer_social_text_color ?? '#000000' }};"><i class="bi bi-facebook"></i></span>
                <span class="mockup-footer-social-icon" id="mockupFooterSocial3" style="background: {{ $setting->footer_social_bg_color ?? '#f9dc4b' }}; color: {{ $setting->footer_social_text_color ?? '#000000' }};"><i class="bi bi-whatsapp"></i></span>
                <span class="mockup-footer-social-icon" id="mockupFooterSocial4" style="background: {{ $setting->footer_social_bg_color ?? '#f9dc4b' }}; color: {{ $setting->footer_social_text_color ?? '#000000' }};"><i class="bi bi-youtube"></i></span>
              </div>
            </div>

            <!-- Kolom 2: Profil Prodi -->
            <div class="col-6 col-lg-2">
              <div class="fw-bold mb-2 pb-1" id="mockupFooterHeading1" style="font-size: 13px; color: {{ $setting->footer_heading_color ?? '#f9dc4b' }}; border-bottom: 2px solid rgba(255,255,255,0.1);">Profil Prodi</div>
              <div class="d-flex flex-column gap-1">
                <span class="mockup-footer-link-item" id="mockupFooterLink1" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Beranda</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink2" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Sejarah YAPISTA</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink3" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Sambutan Kaprodi</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink4" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Visi & Misi</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink5" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Fasilitas Kampus</span>
              </div>
            </div>

            <!-- Kolom 3: Akademik & Portal -->
            <div class="col-6 col-lg-2">
              <div class="fw-bold mb-2 pb-1" id="mockupFooterHeading2" style="font-size: 13px; color: {{ $setting->footer_heading_color ?? '#f9dc4b' }}; border-bottom: 2px solid rgba(255,255,255,0.1);">Akademik</div>
              <div class="d-flex flex-column gap-1">
                <span class="mockup-footer-link-item" id="mockupFooterLink6" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Kalender Akademik</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink7" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Kurikulum TF</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink8" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Data Dosen</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink9" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> Tracer Study</span>
                <span class="mockup-footer-link-item" id="mockupFooterLink10" style="color: {{ $setting->footer_link_color ?? '#ffffff' }};"><i class="bi bi-chevron-right" style="font-size: 9px;"></i> E-Dokumen</span>
              </div>
            </div>

            <!-- Kolom 4: Kontak Prodi -->
            <div class="col-lg-4">
              <div class="fw-bold mb-2 pb-1" id="mockupFooterHeading3" style="font-size: 13px; color: {{ $setting->footer_heading_color ?? '#f9dc4b' }}; border-bottom: 2px solid rgba(255,255,255,0.1);">Kontak Program Studi</div>
              <div class="d-flex flex-column gap-2" style="font-size: 11.5px; color: {{ $setting->footer_text_color ?? '#ffffff' }};" id="mockupFooterContact">
                <div class="d-flex align-items-start gap-2">
                  <i class="bi bi-geo-alt-fill text-warning mt-1"></i>
                  <span>Jalan Teuku Umar, Lubuk Baja, Kota Batam, Kepulauan Riau 29432</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-telephone-fill text-warning"></i>
                  <span>(0778) 408 3113</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-envelope-fill text-warning"></i>
                  <span>informatika@uis.ac.id</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="bi bi-clock-fill text-warning"></i>
                  <span>Senin – Sabtu: 08.00 – 17.00 WIB</span>
                </div>
              </div>
            </div>

          </div>

          <!-- Bottom Divider & Copyright Mockup -->
          <div class="mt-3 pt-3 border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-2" style="border-color: rgba(255,255,255,0.15) !important;">
            <div style="font-size: 11px; color: {{ $setting->footer_text_color ?? '#ffffff' }}; opacity: 0.85;" id="mockupFooterCopyright">
              {{ $setting->footer_copyright ?: '© ' . date('Y') . ' Program Studi Teknik Informatika — Fakultas Sains dan Teknologi. All rights reserved.' }}
            </div>
            <div class="d-flex gap-3" style="font-size: 11px;">
              <span id="mockupFooterBottomLink1" style="color: {{ $setting->footer_link_color ?? '#ffffff' }}; opacity: 0.85;">Kebijakan Privasi</span>
              <span id="mockupFooterBottomLink2" style="color: {{ $setting->footer_link_color ?? '#ffffff' }}; opacity: 0.85;">Syarat & Ketentuan</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. PENGATURAN KONTROL FOOTER (2 Kolom) -->
      <div class="row g-4">
        
        <!-- Kolom Kiri: Kustomisasi Warna Footer -->
        <div class="col-lg-6">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 border-0">
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-palette-fill text-warning"></i> Warna Elemen Footer
              </h6>
              <p class="text-muted small mb-0">Ubah warna background, garis tepi atas, teks, dan tombol medsos</p>
            </div>
            <div class="card-body pt-0">

              <div class="row g-2 mb-3">
                <!-- Background Footer -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Background Footer</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_bg_color" name="footer_bg_color" value="{{ old('footer_bg_color', $setting->footer_bg_color ?? '#000000') }}" oninput="syncColor(this, 'text_footer_bg_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_bg_color" value="{{ old('footer_bg_color', $setting->footer_bg_color ?? '#000000') }}" oninput="syncColorFromText(this, 'input_footer_bg_color')">
                  </div>
                </div>
                <!-- Garis Batas Atas (Border Top) -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Garis Batas Atas (Border)</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_border_top_color" name="footer_border_top_color" value="{{ old('footer_border_top_color', $setting->footer_border_top_color ?? '#f9dc4b') }}" oninput="syncColor(this, 'text_footer_border_top_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_border_top_color" value="{{ old('footer_border_top_color', $setting->footer_border_top_color ?? '#f9dc4b') }}" oninput="syncColorFromText(this, 'input_footer_border_top_color')">
                  </div>
                </div>
              </div>

              <div class="row g-2 mb-3">
                <!-- Heading / Judul Kolom Footer -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Judul Kolom / Heading</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_heading_color" name="footer_heading_color" value="{{ old('footer_heading_color', $setting->footer_heading_color ?? '#f9dc4b') }}" oninput="syncColor(this, 'text_footer_heading_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_heading_color" value="{{ old('footer_heading_color', $setting->footer_heading_color ?? '#f9dc4b') }}" oninput="syncColorFromText(this, 'input_footer_heading_color')">
                  </div>
                </div>
                <!-- Teks Normal Footer -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Teks Normal & Kontak</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_text_color" name="footer_text_color" value="{{ old('footer_text_color', $setting->footer_text_color ?? '#ffffff') }}" oninput="syncColor(this, 'text_footer_text_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_text_color" value="{{ old('footer_text_color', $setting->footer_text_color ?? '#ffffff') }}" oninput="syncColorFromText(this, 'input_footer_text_color')">
                  </div>
                </div>
              </div>

              <div class="row g-2 mb-3">
                <!-- Link Footer Normal -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Tautan / Link</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_link_color" name="footer_link_color" value="{{ old('footer_link_color', $setting->footer_link_color ?? '#ffffff') }}" oninput="syncColor(this, 'text_footer_link_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_link_color" value="{{ old('footer_link_color', $setting->footer_link_color ?? '#ffffff') }}" oninput="syncColorFromText(this, 'input_footer_link_color')">
                  </div>
                </div>
                <!-- Link Hover Footer -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Link Saat Disorot (Hover)</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_link_hover_color" name="footer_link_hover_color" value="{{ old('footer_link_hover_color', $setting->footer_link_hover_color ?? '#f9dc4b') }}" oninput="syncColor(this, 'text_footer_link_hover_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_link_hover_color" value="{{ old('footer_link_hover_color', $setting->footer_link_hover_color ?? '#f9dc4b') }}" oninput="syncColorFromText(this, 'input_footer_link_hover_color')">
                  </div>
                </div>
              </div>

              <div class="row g-2">
                <!-- Sosmed Background -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Bg Tombol Medsos</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_social_bg_color" name="footer_social_bg_color" value="{{ old('footer_social_bg_color', $setting->footer_social_bg_color ?? '#f9dc4b') }}" oninput="syncColor(this, 'text_footer_social_bg_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_social_bg_color" value="{{ old('footer_social_bg_color', $setting->footer_social_bg_color ?? '#f9dc4b') }}" oninput="syncColorFromText(this, 'input_footer_social_bg_color')">
                  </div>
                </div>
                <!-- Sosmed Icon Color -->
                <div class="col-6">
                  <label class="form-label fw-semibold small text-dark mb-1">Ikon Medsos</label>
                  <div class="color-picker-box">
                    <input type="color" class="color-input-native" id="input_footer_social_text_color" name="footer_social_text_color" value="{{ old('footer_social_text_color', $setting->footer_social_text_color ?? '#000000') }}" oninput="syncColor(this, 'text_footer_social_text_color')">
                    <input type="text" class="form-control form-control-sm border-0 bg-transparent fw-bold" id="text_footer_social_text_color" value="{{ old('footer_social_text_color', $setting->footer_social_text_color ?? '#000000') }}" oninput="syncColorFromText(this, 'input_footer_social_text_color')">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Konten Teks & Copyright Footer -->
        <div class="col-lg-6">
          <div class="card shadow-sm border-0 h-100" style="border-radius: 16px;">
            <div class="card-header bg-white py-3 border-0">
              <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-textarea-t text-primary"></i> Konten & Teks Footer
              </h6>
              <p class="text-muted small mb-0">Ubah teks deskripsi visi prodi dan hak cipta di bagian footer</p>
            </div>
            <div class="card-body pt-0">

              <!-- Deskripsi Footer -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark mb-1">Deskripsi Singkat Program Studi</label>
                <textarea class="form-control" name="footer_description" id="input_footer_description" rows="4" placeholder="Tuliskan deskripsi visi/profil singkat pada footer..." oninput="updateFooterTextPreview()">{{ old('footer_description', $setting->footer_description) }}</textarea>
                <div class="form-text" style="font-size: 11px;">Teks ini ditampilkan di bawah logo prodi pada kolom pertama footer website.</div>
              </div>

              <!-- Copyright Footer -->
              <div class="mb-3">
                <label class="form-label fw-semibold small text-dark mb-1">Teks Hak Cipta (Copyright)</label>
                <input type="text" class="form-control" name="footer_copyright" id="input_footer_copyright" value="{{ old('footer_copyright', $setting->footer_copyright) }}" placeholder="Contoh: © 2026 Program Studi Teknik Informatika — Fakultas Sains dan Teknologi" oninput="updateFooterTextPreview()">
                <div class="form-text" style="font-size: 11px;">Teks ini tampil di baris paling bawah footer website publik.</div>
              </div>

              <div class="alert alert-light border d-flex align-items-center gap-2 py-2 px-3 mb-0" style="border-radius: 10px; font-size: 12px;">
                <i class="bi bi-info-circle text-primary fs-5"></i>
                <div>
                  <strong>Live Preview:</strong> Teks yang Anda ketikkan di atas akan langsung terupdate pada mockup preview di atas secara real-time.
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ─────────────────────────────────────────────────────────────
         TAB PANE 3: URUTAN & VISIBILITAS SECTION BERANDA
    ───────────────────────────────────────────────────────────── -->
    <div class="tab-pane fade" id="tab-sections-pane" role="tabpanel" aria-labelledby="tab-sections-btn">
      <div class="card shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
          <div>
            <h6 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
              <i class="bi bi-arrows-expand text-success"></i> Urutan & Visibilitas Section Beranda
            </h6>
            <p class="text-muted small mb-0">Geser (drag) atau gunakan tombol panah untuk mengubah tata letak antar bagian beranda</p>
          </div>
          <div class="badge bg-light text-dark border px-3 py-2" style="border-radius: 8px; font-size: 12px;">
            Total: <strong>{{ count($sections) }} Section</strong>
          </div>
        </div>
        <div class="card-body pt-0">

          <div class="alert alert-light border d-flex align-items-center gap-2 py-2 px-3 mb-3" style="border-radius: 10px; font-size: 12.5px;">
            <i class="bi bi-info-circle text-primary fs-5"></i>
            <div>
              <strong>Tips Pengaturan:</strong> Matikan saklar (toggle switch) pada section yang ingin disembunyikan sementara dari beranda website tanpa menghapus isinya.
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

        </div>
      </div>
    </div>

  </div>

  <!-- ═══════════════════════════════════════════════════════════
       BAR AKSI PERSISTEN / STICKY DI BAGIAN BAWAH
  ═══════════════════════════════════════════════════════════ -->
  <div class="sticky-bottom-actions p-3 mt-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <button type="button" class="btn btn-outline-danger d-inline-flex align-items-center gap-2" onclick="confirmReset()" style="border-radius: 10px; font-weight: 600;">
      <i class="bi bi-arrow-counterclockwise"></i> Reset ke Standar Awal
    </button>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 600;">
        <i class="bi bi-box-arrow-up-right"></i> Buka Website Publik
      </a>
      <button type="submit" class="btn btn-warning px-4 py-2 text-dark fw-bold d-inline-flex align-items-center gap-2 shadow-sm" style="background: #f9dc4b; border: none; border-radius: 10px;">
        <i class="bi bi-check2-circle fs-5"></i> Simpan Perubahan Tampilan
      </button>
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
  updateHeaderBrandPreview();

  // Pertahankan Tab Aktif dari localStorage atau URL hash
  const activeTabTarget = localStorage.getItem('themeSettingActiveTab') || window.location.hash;
  if (activeTabTarget) {
    const triggerEl = document.querySelector(`button[data-bs-target="${activeTabTarget}"]`);
    if (triggerEl) {
      bootstrap.Tab.getOrCreateInstance(triggerEl).show();
    }
  }

  // Simpan Tab yang dipilih saat berganti tab
  document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(btn => {
    btn.addEventListener('shown.bs.tab', function (e) {
      const target = e.target.getAttribute('data-bs-target');
      localStorage.setItem('themeSettingActiveTab', target);
      if (history.replaceState) {
        history.replaceState(null, null, target);
      }
    });
  });
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

// Terapkan Palet Preset Lengkap (Header, Topbar, dan Footer)
function applyPreset(bg, text, actBg, actText, logBg, logText, topBg, topText, ftrBg, ftrTxt, ftrHead, ftrBorder, ftrLink, ftrLinkHov, ftrSocBg, ftrSocTxt, topSocBg, topSocTxt, langBg, langText) {
  setFieldColor('header_bg_color', bg);
  setFieldColor('header_text_color', text);
  setFieldColor('header_active_bg_color', actBg);
  setFieldColor('header_active_text_color', actText);
  setFieldColor('header_login_bg_color', logBg);
  setFieldColor('header_login_text_color', logText);
  setFieldColor('header_lang_bg_color', langBg || logBg);
  setFieldColor('header_lang_text_color', langText || logText);
  setFieldColor('topbar_bg_color', topBg);
  setFieldColor('topbar_text_color', topText);

  if (topSocBg) setFieldColor('topbar_social_bg_color', topSocBg);
  if (topSocTxt) setFieldColor('topbar_social_text_color', topSocTxt);

  if (ftrBg) setFieldColor('footer_bg_color', ftrBg);
  if (ftrTxt) setFieldColor('footer_text_color', ftrTxt);
  if (ftrHead) setFieldColor('footer_heading_color', ftrHead);
  if (ftrBorder) setFieldColor('footer_border_top_color', ftrBorder);
  if (ftrLink) setFieldColor('footer_link_color', ftrLink);
  if (ftrLinkHov) setFieldColor('footer_link_hover_color', ftrLinkHov);
  if (ftrSocBg) setFieldColor('footer_social_bg_color', ftrSocBg);
  if (ftrSocTxt) setFieldColor('footer_social_text_color', ftrSocTxt);

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

// Update Teks Preview Footer saat mengetik di textarea / input
function updateFooterTextPreview() {
  const descInput = document.getElementById('input_footer_description');
  const copyInput = document.getElementById('input_footer_copyright');
  const descEl = document.getElementById('mockupFooterDesc');
  const copyEl = document.getElementById('mockupFooterCopyright');

  if (descInput && descEl) {
    descEl.textContent = descInput.value.trim() || 'Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Berkomitmen menyelenggarakan pendidikan tinggi teknologi informasi yang unggul, bermartabat, bereputasi nasional dan internasional.';
  }
  if (copyInput && copyEl) {
    copyEl.textContent = copyInput.value.trim() || '© ' + new Date().getFullYear() + ' Program Studi Teknik Informatika — Fakultas Sains dan Teknologi. All rights reserved.';
  }
}

// Refresh Live Interactive Preview Header, Topbar & Footer Mockup
function refreshPreview() {
  // 1. Header Values
  const bg = document.getElementById('input_header_bg_color')?.value || '#f9dc4b';
  const text = document.getElementById('input_header_text_color')?.value || '#000000';
  const actBg = document.getElementById('input_header_active_bg_color')?.value || '#000000';
  const actText = document.getElementById('input_header_active_text_color')?.value || '#ffffff';
  const logBg = document.getElementById('input_header_login_bg_color')?.value || '#000000';
  const logText = document.getElementById('input_header_login_text_color')?.value || '#ffffff';
  const langBg = document.getElementById('input_header_lang_bg_color')?.value || '#000000';
  const langText = document.getElementById('input_header_lang_text_color')?.value || '#ffffff';

  // 1b. Topbar Values
  const topBg = document.getElementById('input_topbar_bg_color')?.value || '#000000';
  const topText = document.getElementById('input_topbar_text_color')?.value || '#ffffff';
  const topSocBg = document.getElementById('input_topbar_social_bg_color')?.value || '#ffffff';
  const topSocTxt = document.getElementById('input_topbar_social_text_color')?.value || '#000000';

  const mockupTopbar = document.getElementById('mockupTopbar');
  if (mockupTopbar) {
    mockupTopbar.style.backgroundColor = topBg;
    mockupTopbar.style.color = topText;
  }
  const topbarSearch = document.getElementById('mockupTopbarSearch');
  if (topbarSearch) {
    topbarSearch.style.color = topSocTxt;
  }
  for (let s = 1; s <= 3; s++) {
    const soc = document.getElementById('mockupTopbarSosmed' + s);
    if (soc) {
      soc.style.backgroundColor = topSocBg;
      soc.style.color = topSocTxt;
    }
  }

  const mockupNav = document.getElementById('mockupNavbar');
  const mockupTitle = document.getElementById('mockupTitle');
  const mockupSubtitle = document.getElementById('mockupSubtitle');
  const mockupActive = document.getElementById('mockupLinkActive');
  const mockupLogin = document.getElementById('mockupBtnLogin');
  const mockupLang = document.getElementById('mockupBtnLang');

  if (mockupNav) mockupNav.style.backgroundColor = bg;
  if (mockupTitle) mockupTitle.style.color = text;
  if (mockupSubtitle) mockupSubtitle.style.color = text;

  if (mockupActive) {
    mockupActive.style.backgroundColor = actBg;
    mockupActive.style.color = actText;
  }

  for (let i = 1; i <= 7; i++) {
    const el = document.getElementById('mockupLinkNormal' + i);
    if (el) el.style.color = text;
  }

  if (mockupLogin) {
    mockupLogin.style.backgroundColor = logBg;
    mockupLogin.style.color = logText;
  }

  if (mockupLang) {
    mockupLang.style.backgroundColor = langBg;
    mockupLang.style.color = langText;
  }

  // 2. Footer Values
  const ftrBg = document.getElementById('input_footer_bg_color')?.value || '#000000';
  const ftrTxt = document.getElementById('input_footer_text_color')?.value || '#ffffff';
  const ftrHead = document.getElementById('input_footer_heading_color')?.value || '#f9dc4b';
  const ftrBorder = document.getElementById('input_footer_border_top_color')?.value || '#f9dc4b';
  const ftrLink = document.getElementById('input_footer_link_color')?.value || '#ffffff';
  const ftrSocBg = document.getElementById('input_footer_social_bg_color')?.value || '#f9dc4b';
  const ftrSocTxt = document.getElementById('input_footer_social_text_color')?.value || '#000000';

  const mockupFooter = document.getElementById('mockupFooter');
  const ftrBrandTitle = document.getElementById('mockupFooterBrandTitle');
  const ftrBrandSubtitle = document.getElementById('mockupFooterBrandSubtitle');
  const ftrDesc = document.getElementById('mockupFooterDesc');
  const ftrHead1 = document.getElementById('mockupFooterHeading1');
  const ftrHead2 = document.getElementById('mockupFooterHeading2');
  const ftrHead3 = document.getElementById('mockupFooterHeading3');
  const ftrContact = document.getElementById('mockupFooterContact');
  const ftrCopyright = document.getElementById('mockupFooterCopyright');
  const ftrBottom1 = document.getElementById('mockupFooterBottomLink1');
  const ftrBottom2 = document.getElementById('mockupFooterBottomLink2');

  if (mockupFooter) {
    mockupFooter.style.backgroundColor = ftrBg;
    mockupFooter.style.borderTop = `4px solid ${ftrBorder}`;
  }
  if (ftrBrandTitle) ftrBrandTitle.style.color = ftrHead;
  if (ftrBrandSubtitle) ftrBrandSubtitle.style.color = ftrTxt;
  if (ftrDesc) ftrDesc.style.color = ftrTxt;
  if (ftrHead1) ftrHead1.style.color = ftrHead;
  if (ftrHead2) ftrHead2.style.color = ftrHead;
  if (ftrHead3) ftrHead3.style.color = ftrHead;
  if (ftrContact) ftrContact.style.color = ftrTxt;
  if (ftrCopyright) ftrCopyright.style.color = ftrTxt;
  if (ftrBottom1) ftrBottom1.style.color = ftrLink;
  if (ftrBottom2) ftrBottom2.style.color = ftrLink;

  for (let j = 1; j <= 10; j++) {
    const flink = document.getElementById('mockupFooterLink' + j);
    if (flink) flink.style.color = ftrLink;
  }

  for (let s = 1; s <= 4; s++) {
    const soc = document.getElementById('mockupFooterSocial' + s);
    if (soc) {
      soc.style.backgroundColor = ftrSocBg;
      soc.style.color = ftrSocTxt;
    }
  }
}

// Konfirmasi Reset ke Default
function confirmReset() {
  if (confirm('Apakah Anda yakin ingin mengembalikan seluruh warna header, footer, dan urutan section ke standar awal?')) {
    document.getElementById('formResetTheme').submit();
  }
}

// Brand Header & Logo Preview Helper
const defaultLogoUrl = "{{ asset('assets/img/logouis.png') }}";
const currentLogoUrl = "{{ $setting->logo_url }}";

function updateHeaderBrandPreview() {
  const titleInput = document.getElementById('input_header_title');
  const subtitleInput = document.getElementById('input_header_subtitle');
  
  const title = (titleInput && titleInput.value.trim()) ? titleInput.value.trim() : 'TEKNIK INFORMATIKA';
  const subtitle = (subtitleInput && subtitleInput.value.trim()) ? subtitleInput.value.trim() : 'Fakultas Sains dan Teknologi';
  
  const mockupTitle = document.getElementById('mockupTitle');
  const mockupSubtitle = document.getElementById('mockupSubtitle');
  const mockupFooterBrandTitle = document.getElementById('mockupFooterBrandTitle');
  const mockupFooterBrandSubtitle = document.getElementById('mockupFooterBrandSubtitle');
  
  if (mockupTitle) mockupTitle.textContent = title;
  if (mockupSubtitle) mockupSubtitle.textContent = subtitle;
  if (mockupFooterBrandTitle) mockupFooterBrandTitle.textContent = title;
  if (mockupFooterBrandSubtitle) mockupFooterBrandSubtitle.textContent = subtitle;
}

function previewHeaderLogo(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const result = e.target.result;
      const mockupLogo = document.getElementById('mockupLogo');
      const mockupFooterLogo = document.getElementById('mockupFooterLogo');
      const previewImg = document.getElementById('header_logo_preview');
      if (mockupLogo) mockupLogo.src = result;
      if (mockupFooterLogo) mockupFooterLogo.src = result;
      if (previewImg) previewImg.src = result;
    };
    reader.readAsDataURL(input.files[0]);

    const removeCb = document.getElementById('remove_header_logo');
    if (removeCb) removeCb.checked = false;
  }
}

function toggleRemoveLogo(checkbox) {
  const mockupLogo = document.getElementById('mockupLogo');
  const mockupFooterLogo = document.getElementById('mockupFooterLogo');
  const previewImg = document.getElementById('header_logo_preview');
  const fileInput = document.getElementById('input_header_logo');

  if (checkbox.checked) {
    if (fileInput) fileInput.value = '';
    if (mockupLogo) mockupLogo.src = defaultLogoUrl;
    if (mockupFooterLogo) mockupFooterLogo.src = defaultLogoUrl;
    if (previewImg) previewImg.src = defaultLogoUrl;
  } else {
    if (mockupLogo) mockupLogo.src = currentLogoUrl;
    if (mockupFooterLogo) mockupFooterLogo.src = currentLogoUrl;
    if (previewImg) previewImg.src = currentLogoUrl;
  }
}
</script>
@endpush
