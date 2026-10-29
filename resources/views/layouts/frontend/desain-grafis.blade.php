@extends('layouts.frontend.template')

@section('title', 'Templat & Layanan Desain Grafis — Teknik Informatika (UIS)')
@section('meta_description', 'Pusat templat desain grafis resmi Teknik Informatika (UIS) Batam. Templat LED Auditorium, Ruang Sidang, Rapat Dekanat, Banner & Spanduk siap pakai di Canva.')
@section('meta_keywords', 'desain grafis uis, templat canva uis, template led auditorium uis, spanduk uis, humas uis desain')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
  $defaultWaUrl = !empty($cleanWa) 
      ? 'https://wa.me/' . $cleanWa . '?text=' . rawurlencode('Halo Tim Humas UIS, saya ingin memesan kebutuhan desain grafis baru yang belum tersedia di templat.') 
      : route('homepage.kontak');

  $orderWaUrl = !empty($setting->order_box_wa_url) ? $setting->order_box_wa_url : $defaultWaUrl;

  // Parsing panduan langkah teks
  $guideStepsList = [];
  if (!empty($setting->guide_steps)) {
      $rawLines = explode("\n", str_replace("\r", "", $setting->guide_steps));
      foreach ($rawLines as $line) {
          $trim = trim($line);
          if (!empty($trim)) {
              // Hilangkan angka di awal bila ada
              $cleanText = preg_replace('/^\d+[\.\)]\s*/', '', $trim);
              $guideStepsList[] = $cleanText;
          }
      }
  }
  if (empty($guideStepsList)) {
      $guideStepsList = [
          'Pilih Templat',
          'Masuk ke Canva',
          'Edit Teks/Elemen Templat',
          'Desain Siap',
          'Export Desain format .JPG',
          'Klik tombol Share (kanan atas)',
          'Klik Download',
          'Pilih Format .JPG',
          'Atur Quality Spasi ke 100% untuk kualitas terbaik',
          'Klik Download'
      ];
  }
@endphp

<style>
  :root {
    --uis-dg-darkgreen: #000000;
    --uis-dg-deepgreen: #000000;
    --uis-dg-gold: #f9dc4b;
    --uis-dg-yellow: #f59e0b;
    --uis-dg-lime: #84cc16;
  }

  .desain-grafis-page {
    background: #f8fafc;
    min-height: 100vh;
    perspective: 1000px;
  }

  /* ══════════════════════════════════════════════════════
     1. HERO SECTION WITH 3D FLOATING PARTICLES & WAVES
  ══════════════════════════════════════════════════════ */
  .dg-hero-section {
    background: linear-gradient(180deg, #000000 0%, #000000 60%, #000000 100%);
    position: relative;
    padding: 70px 0 150px 0;
    color: #ffffff;
    overflow: hidden;
  }

  /* 3D Floating Motion Graphic Elements */
  .dg-hero-floating-shape {
    position: absolute;
    pointer-events: none;
    z-index: 1;
    opacity: 0.15;
    animation: float3D 8s ease-in-out infinite alternate;
  }
  .dg-hero-shape-1 {
    top: 10%;
    left: 4%;
    font-size: 80px;
    color: #f9dc4b;
    animation-duration: 9s;
    filter: drop-shadow(0 15px 25px rgba(250, 204, 21, 0.4));
  }
  .dg-hero-shape-2 {
    bottom: 25%;
    right: 5%;
    font-size: 110px;
    color: #34d399;
    animation-duration: 11s;
    animation-delay: -3s;
  }
  .dg-hero-shape-3 {
    top: 20%;
    right: 42%;
    font-size: 60px;
    color: #60a5fa;
    animation-duration: 7s;
    animation-delay: -2s;
  }

  @keyframes float3D {
    0% {
      transform: translateY(0px) rotate(0deg) scale(1);
    }
    50% {
      transform: translateY(-20px) rotate(8deg) scale(1.05);
    }
    100% {
      transform: translateY(15px) rotate(-6deg) scale(0.95);
    }
  }

  /* SVG Dripping Top Pattern Overlay */
  .dg-hero-drip-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    opacity: 0.18;
    pointer-events: none;
  }

  /* Bottom Wave Shape Divider */
  .dg-hero-wave-bottom {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    z-index: 2;
  }
  .dg-hero-wave-bottom svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 75px;
  }

  .dg-hero-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 46px;
    font-weight: 800;
    line-height: 1.15;
    color: #ffffff;
    margin-bottom: 18px;
    letter-spacing: -0.5px;
    text-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
  }
  .dg-hero-title span.highlight-yellow {
    color: #f9dc4b;
    background: linear-gradient(135deg, #fef08a 0%, #f9dc4b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 2px 8px rgba(250, 204, 21, 0.4));
  }

  .dg-hero-subtitle {
    font-size: 16px;
    color: #e2e8f0;
    line-height: 1.6;
    max-width: 540px;
    margin-bottom: 0;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
  }

  /* 3D Pesan Desain Box (Right Column) */
  .dg-order-card {
    background: #fbfbf9;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 48px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.15);
    max-width: 440px;
    margin-left: auto;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-style: preserve-3d;
  }
  .dg-order-card:hover {
    transform: translateY(-8px) rotateY(-3deg) rotateX(3deg);
    box-shadow: 0 32px 64px rgba(0, 0, 0, 0.45);
  }
  .dg-order-card-header {
    background: linear-gradient(90deg, #f9dc4b 0%, #f9dc4b 100%);
    color: #ffffff;
    padding: 14px 22px;
    font-weight: 800;
    font-size: 16.5px;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
  }
  .dg-order-card-body {
    padding: 24px 24px 26px 24px;
    color: #334155;
  }
  .dg-order-card-text {
    font-size: 13.5px;
    line-height: 1.55;
    color: #475569;
    margin-bottom: 22px;
  }
  .dg-btn-gold {
    background: linear-gradient(135deg, #f9dc4b 0%, #f9dc4b 100%);
    color: #1e293b;
    font-weight: 800;
    font-size: 14px;
    padding: 10px 24px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
    border: none;
    box-shadow: 0 6px 16px rgba(212, 160, 23, 0.35);
  }
  .dg-btn-gold:hover {
    background: linear-gradient(135deg, #f9dc4b 0%, #eab308 100%);
    color: #000000;
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 10px 24px rgba(212, 160, 23, 0.5);
  }

  /* ══════════════════════════════════════════════════════
     2. 3D TRACKING BAR & 4 METRIC STATS
  ══════════════════════════════════════════════════════ */
  .dg-overlap-container {
    position: relative;
    z-index: 10;
    margin-top: -70px;
    margin-bottom: 60px;
  }

  /* Rounded Olive-Green Tracking Bar */
  .dg-track-bar {
    background: linear-gradient(135deg, #000000 0%, #000000 100%);
    border-radius: 50px;
    padding: 12px 18px 12px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 18px 36px rgba(0, 0, 0, 0.18), inset 0 1px 1px rgba(255, 255, 255, 0.25);
    max-width: 920px;
    margin: 0 auto 32px auto;
    color: #ffffff;
    transition: all 0.3s ease;
  }
  .dg-track-bar:hover {
    box-shadow: 0 22px 42px rgba(0, 0, 0, 0.24);
    transform: translateY(-2px);
  }
  .dg-track-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-grow: 1;
  }
  .dg-track-search-icon {
    font-size: 22px;
    color: #d9f99d;
    filter: drop-shadow(0 2px 6px rgba(217, 249, 157, 0.4));
  }
  .dg-track-text {
    font-size: 15.5px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.2px;
  }
  .dg-track-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .dg-track-arrow {
    font-size: 24px;
    color: #ffffff;
    animation: bounceRight 2s infinite ease-in-out;
  }
  @keyframes bounceRight {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(5px); }
  }
  .dg-btn-track {
    background: linear-gradient(135deg, #f9dc4b 0%, #f9dc4b 100%);
    color: #1e293b;
    font-size: 13.5px;
    font-weight: 800;
    padding: 8px 24px;
    border-radius: 50px;
    border: none;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
  .dg-btn-track:hover {
    background: #f9dc4b;
    color: #000;
    transform: scale(1.06);
  }

  /* 4 Metric Cards with 3D elevation */
  .dg-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    max-width: 920px;
    margin: 0 auto;
  }
  .dg-stat-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07);
    border-left: 6px solid #22c55e;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
  }
  .dg-stat-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 18px 36px rgba(15, 23, 42, 0.14);
  }
  .dg-stat-card.stat-selesai { border-left-color: #000000; }
  .dg-stat-card.stat-proses   { border-left-color: #f59e0b; }
  .dg-stat-card.stat-tunggu   { border-left-color: #0284c7; }

  .dg-stat-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.6px;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 4px;
  }
  .dg-stat-number {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 34px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: 2px;
  }
  .dg-stat-sub {
    font-size: 11px;
    color: #94a3b8;
  }

  /* ══════════════════════════════════════════════════════
     3. SECTION TEMPLAT DESAIN (3D PERSPECTIVE CARDS)
  ══════════════════════════════════════════════════════ */
  .dg-template-section {
    padding: 30px 0 70px 0;
  }
  .dg-section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    text-align: center;
    margin-bottom: 26px;
    letter-spacing: -0.5px;
  }

  /* Filter Pills */
  .dg-filter-pills {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 18px;
  }
  .dg-filter-pill-btn {
    border: none;
    background: #e2e8f0;
    color: #334155;
    font-size: 14px;
    font-weight: 700;
    padding: 9px 24px;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .dg-filter-pill-btn:hover {
    background: #cbd5e1;
    color: #0f172a;
    transform: translateY(-2px);
  }
  .dg-filter-pill-btn.active {
    background: #334155;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(51, 65, 85, 0.35);
  }

  .dg-spec-note {
    text-align: center;
    font-size: 13.5px;
    color: #64748b;
    margin-bottom: 38px;
    max-width: 820px;
    margin-left: auto;
    margin-right: auto;
  }

  /* 3D Template Cards (Canva Preview) */
  .dg-template-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    max-width: 1180px;
    margin: 0 auto;
  }
  .dg-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 26px rgba(15, 23, 42, 0.08);
    border: 1px solid #f1f5f9;
    transition: all 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    flex-direction: column;
    transform-style: preserve-3d;
  }
  .dg-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 42px rgba(15, 23, 42, 0.16);
    border-color: #cbd5e1;
  }
  .dg-card-preview {
    height: 125px;
    width: 100%;
    position: relative;
    padding: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: #ffffff;
    transition: all 0.3s ease;
  }
  .dg-card-preview-header {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.92;
  }
  .dg-card-preview-body {
    font-size: 14.5px;
    font-weight: 700;
    line-height: 1.25;
    text-shadow: 0 2px 6px rgba(0,0,0,0.4);
  }
  .dg-card-preview-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    color: #ffffff;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 20px;
    font-weight: 600;
  }
  .dg-card-body {
    padding: 16px 16px 18px 16px;
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #ffffff;
  }
  .dg-card-title {
    font-size: 15.5px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 2px;
  }
  .dg-card-source {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 14px;
  }
  .dg-btn-edit {
    background: linear-gradient(135deg, #f9dc4b 0%, #f9dc4b 100%);
    color: #1e293b;
    font-weight: 800;
    font-size: 13px;
    padding: 7px 0;
    width: 105px;
    margin: 0 auto;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.25s ease;
    box-shadow: 0 4px 10px rgba(212, 160, 23, 0.3);
  }
  .dg-btn-edit:hover {
    background: linear-gradient(135deg, #f9dc4b 0%, #ca8a04 100%);
    color: #000000;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 16px rgba(212, 160, 23, 0.5);
  }

  /* ══════════════════════════════════════════════════════
     4. SECTION INFOGRAFIS PANDUAN PENGGUNAAN (FULL IMAGE)
  ══════════════════════════════════════════════════════ */
  .dg-guide-section {
    padding: 30px 0 100px 0;
  }
  .dg-guide-full-image-container {
    max-width: 1180px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 28px;
    padding: 10px;
    box-shadow: 0 20px 48px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(226, 232, 240, 0.8);
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-style: preserve-3d;
  }
  .dg-guide-full-image-container:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 30px 60px rgba(15, 23, 42, 0.14);
  }
  .dg-guide-main-img {
    width: 100%;
    height: auto;
    border-radius: 20px;
    display: block;
    cursor: zoom-in;
    transition: all 0.3s ease;
  }

  /* Responsive Adjustments */
  @media (max-width: 991.98px) {
    .dg-hero-title {
      font-size: 34px;
    }
    .dg-order-card {
      margin: 30px auto 0 auto;
    }
    .dg-stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .dg-template-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .dg-steps-visual-grid {
      grid-template-columns: repeat(2, 1fr);
      margin-top: 24px;
    }
    .dg-guide-container {
      padding: 30px 20px;
    }
  }

  @media (max-width: 575.98px) {
    .dg-hero-title {
      font-size: 28px;
    }
    .dg-stats-grid {
      grid-template-columns: 1fr;
    }
    .dg-template-grid {
      grid-template-columns: 1fr;
    }
    .dg-steps-visual-grid {
      grid-template-columns: 1fr;
    }
    .dg-track-bar {
      border-radius: 20px;
      flex-direction: column;
      gap: 12px;
      text-align: center;
    }
  }
</style>

<div class="desain-grafis-page">

  <!-- ══════════════════════════════════════════════════════
       1. HERO SECTION WITH 3D PARTICLES & WAVES
  ══════════════════════════════════════════════════════ -->
  <section class="dg-hero-section">
    
    <!-- 3D Floating Shapes -->
    <i class="bi bi-brush-fill dg-hero-floating-shape dg-hero-shape-1"></i>
    <i class="bi bi-palette-fill dg-hero-floating-shape dg-hero-shape-2"></i>
    <i class="bi bi-layers-fill dg-hero-floating-shape dg-hero-shape-3"></i>

    <!-- SVG Drip Top -->
    <div class="dg-hero-drip-top">
      <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,0 C150,90 350,-40 500,60 C650,160 850,-20 1000,70 C1150,160 1350,-10 1440,40 L1440,0 L0,0 Z" fill="#ffffff"/>
      </svg>
    </div>

    <div class="container position-relative" style="z-index: 5;">
      <div class="row align-items-center">
        
        <!-- Left Hero Text (Dynamic from setting) -->
        <div class="col-lg-7 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="700">
          <h1 class="dg-hero-title">
            {{ $setting->hero_title ?? 'Desain Mudah,' }}<br>
            <span class="highlight-yellow">{{ $setting->hero_highlight ?? 'Siap Digunakan !' }}</span>
          </h1>
          <p class="dg-hero-subtitle">
            {{ $setting->hero_subtitle ?? 'Kami menyediakan template desain resmi untuk keperluan presentasi LED, ruang sidang, agenda rapat, dan spanduk acara di lingkungan Teknik Informatika.' }}
          </p>
        </div>

        <!-- Right "Pesan Desain Disini" Box (Dynamic from setting) -->
        <div class="col-lg-5" data-aos="fade-left" data-aos-duration="700">
          <div class="dg-order-card">
            <div class="dg-order-card-header">
              <i class="bi bi-palette-fill me-2"></i> {{ $setting->order_box_title ?? 'Pesan desain disini' }}
            </div>
            <div class="dg-order-card-body">
              <p class="dg-order-card-text">
                {{ $setting->order_box_text ?? 'Butuh desain yang belum tersedia dalam template? Sampaikan kebutuhan acara Anda, dan tim Humas & Promosi UIS siap membantu mewujudkannya.' }}
              </p>
              <a href="{{ $orderWaUrl }}" target="_blank" class="dg-btn-gold">
                <i class="bi bi-whatsapp me-1"></i> {{ $setting->order_box_btn_text ?? 'Pesan Sekarang' }}
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom Wave Divider -->
    <div class="dg-hero-wave-bottom">
      <svg viewBox="0 0 1440 75" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,35 C280,75 450,0 720,35 C990,75 1160,0 1440,35 L1440,75 L0,75 Z" fill="#f8fafc"/>
      </svg>
    </div>
  </section>


  <!-- ══════════════════════════════════════════════════════
       2. TRACKING BAR & 4 METRIC STATS OVERLAP
  ══════════════════════════════════════════════════════ -->
  <div class="container dg-overlap-container">
    
    <!-- Tracking Bar (Dynamic from setting) -->
    <div class="dg-track-bar" data-aos="fade-up" data-aos-duration="600">
      <div class="dg-track-left">
        <i class="bi bi-search dg-track-search-icon"></i>
        <span class="dg-track-text">{{ $setting->track_bar_text ?? 'Lacak progress pesanan desain kamu disini!' }}</span>
      </div>
      <div class="dg-track-right">
        <i class="bi bi-arrow-right dg-track-arrow"></i>
        <button type="button" class="dg-btn-track" onclick="trackDesignPrompt()">Lacak</button>
      </div>
    </div>

    <!-- 4 Stats Cards (Dynamic from setting) -->
    <div class="dg-stats-grid" data-aos="fade-up" data-aos-delay="100">
      <div class="dg-stat-card">
        <div class="dg-stat-label">TOTAL PROJECT</div>
        <div class="dg-stat-number">{{ $stats['total'] ?? 82 }}</div>
        <div class="dg-stat-sub">7 hari yang lalu</div>
      </div>

      <div class="dg-stat-card stat-selesai">
        <div class="dg-stat-label">SELESAI</div>
        <div class="dg-stat-number">{{ $stats['selesai'] ?? 74 }}</div>
        <div class="dg-stat-sub">7 hari yang lalu</div>
      </div>

      <div class="dg-stat-card stat-proses">
        <div class="dg-stat-label">DIKERJAKAN</div>
        <div class="dg-stat-number">{{ $stats['dikerjakan'] ?? 2 }}</div>
        <div class="dg-stat-sub">7 hari yang lalu</div>
      </div>

      <div class="dg-stat-card stat-tunggu">
        <div class="dg-stat-label">MENUNGGU</div>
        <div class="dg-stat-number">{{ $stats['menunggu'] ?? 5 }}</div>
        <div class="dg-stat-sub">7 hari yang lalu</div>
      </div>
    </div>

  </div>


  <!-- ══════════════════════════════════════════════════════
       3. TEMPLAT DESAIN SIAP DIGUNAKAN!
  ══════════════════════════════════════════════════════ -->
  <section class="dg-template-section">
    <div class="container">
      
      <h2 class="dg-section-title" data-aos="fade-up">
        Templat desain siap digunakan!
      </h2>

      <!-- Category Filter Pills -->
      <div class="dg-filter-pills" data-aos="fade-up" data-aos-delay="100">
        @foreach($categories as $catKey => $cat)
        <button type="button" 
                class="dg-filter-pill-btn {{ $loop->first ? 'active' : '' }}" 
                data-cat="{{ $catKey }}"
                data-specs="{{ $cat['specs'] }}"
                onclick="switchTemplateCategory('{{ $catKey }}', this)">
          <i class="bi bi-geo-alt-fill"></i> {{ $cat['name'] }}
        </button>
        @endforeach
      </div>

      <!-- Specification Subtitle -->
      <div class="dg-spec-note" id="dg-current-specs" data-aos="fade-up" data-aos-delay="150">
        {{ $categories['audit']['specs'] ?? 'Ukuran: LED TENGAH untuk gedung Auditorium lt. 4 gedung H. Rasit Kurnain (Format 704 x 320 px / Landscape)' }}
      </div>

      <!-- Template Cards Grid by Category -->
      @foreach($categories as $catKey => $cat)
      <div class="dg-template-grid dg-cat-group {{ $loop->first ? '' : 'd-none' }}" id="group-{{ $catKey }}" data-aos="fade-up" data-aos-delay="200">
        @forelse($cat['templates'] as $tpl)
        <div class="dg-card">
          <!-- Banner Preview -->
          <div class="dg-card-preview" style="@if(!empty($tpl['gambar_preview'])) background: linear-gradient(rgba(0,0,0,0.20), rgba(0,0,0,0.50)), url('{{ $tpl['gambar_preview'] }}') center/cover no-repeat; @else background: {{ $tpl['color'] }}; @endif">
            <span class="dg-card-preview-badge">{{ $tpl['badge'] }}</span>
            <div class="dg-card-preview-header">
              <i class="bi bi-mortarboard-fill me-1"></i> UIS HUMAS
            </div>
            <div class="dg-card-preview-body">
              {{ $tpl['title'] }}
              @if(!empty($tpl['desc']))
              <div style="font-size: 11px; font-weight: 500; opacity: 0.9;">{{ $tpl['desc'] }}</div>
              @endif
            </div>
          </div>

          <!-- Card Content -->
          <div class="dg-card-body">
            <div>
              <div class="dg-card-title">{{ $tpl['title'] }}</div>
              <div class="dg-card-source">tersedia di canva.com</div>
            </div>
            <div>
              <a href="{{ $tpl['url'] }}" target="_blank" class="dg-btn-edit">
                <i class="bi bi-pencil-square me-1"></i> Edit
              </a>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="bi bi-inbox fs-1 d-block mb-2"></i>
          Belum ada templat aktif untuk kategori ini.
        </div>
        @endforelse
      </div>
      @endforeach

    </div>
  </section>


  <!-- ══════════════════════════════════════════════════════
       4. SECTION INFOGRAFIS PANDUAN PENGGUNAAN (GAMBAR LENGKAP)
  ══════════════════════════════════════════════════════ -->
  <section class="dg-guide-section">
    <div class="container">
      <div class="dg-guide-full-image-container" data-aos="fade-up" data-aos-duration="700">
        @if(!empty($setting->guide_image))
          <img src="{{ asset('storage/' . $setting->guide_image) }}" 
               alt="Panduan Langkah Menggunakan Templat Desain" 
               class="dg-guide-main-img"
               onclick="window.open(this.src, '_blank')"
               title="Klik untuk melihat resolusi penuh">
        @else
          <img src="{{ asset('storage/desain_grafis/guide/guide_steps.png') }}" 
               alt="Panduan Langkah Menggunakan Templat Desain" 
               class="dg-guide-main-img"
               onclick="window.open(this.src, '_blank')"
               title="Klik untuk melihat resolusi penuh">
        @endif
      </div>
    </div>
  </section>

</div>

<script>
  function switchTemplateCategory(catKey, btn) {
    document.querySelectorAll('.dg-filter-pill-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const specs = btn.getAttribute('data-specs');
    document.getElementById('dg-current-specs').textContent = specs;

    document.querySelectorAll('.dg-cat-group').forEach(group => {
      group.classList.add('d-none');
    });

    const targetGroup = document.getElementById('group-' + catKey);
    if (targetGroup) {
      targetGroup.classList.remove('d-none');
    }
  }

  function trackDesignPrompt() {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: 'Lacak Progress Pesanan Desain',
        text: 'Masukkan nomor WhatsApp atau ID Tiket pesanan Anda:',
        input: 'text',
        inputPlaceholder: 'Contoh: 08123456789 atau #DESAIN-102',
        showCancelButton: true,
        confirmButtonColor: '#000000',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="bi bi-search me-1"></i> Lacak Sekarang',
        cancelButtonText: 'Batal',
        customClass: {
          popup: 'rounded-4 shadow-lg border-0'
        }
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          Swal.fire({
            icon: 'info',
            title: 'Status Pesanan: ' + result.value,
            html: '<div class="text-start mt-2"><strong>Status:</strong> <span class="badge bg-success">Selesai / Sedang Dikerjakan</span><br><small class="text-muted">Untuk konfirmasi revisi atau pengiriman file resolusi tinggi, silakan hubungi WhatsApp Humas UIS.</small></div>',
            confirmButtonColor: '#000000',
            customClass: {
              popup: 'rounded-4 shadow-lg border-0'
            }
          });
        }
      });
    } else {
      const code = prompt('Masukkan ID Pesanan atau Nomor WA Anda:');
      if (code) {
        alert('Pesanan ' + code + ' sedang diproses oleh Tim Desain Humas UIS.');
      }
    }
  }
</script>
@endsection
