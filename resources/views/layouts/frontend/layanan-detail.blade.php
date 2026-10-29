@extends('layouts.frontend.template')

@section('title', $layanan->judul . ' — Teknik Informatika (UIS)')
@section('meta_description', Str::limit(strip_tags($layanan->deskripsi), 160))
@section('meta_keywords', 'uis, ' . strtolower($layanan->judul) . ', teknik informatika')

@section('content')
@php
  $rincianItems = $layanan->rincian
    ? array_filter(array_map('trim', explode("\n", $layanan->rincian)))
    : [];
@endphp

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="layanan-hero">
  <div class="container">
    <div class="layanan-hero-content" data-aos="fade-up" data-aos-duration="700">
      <h1 class="layanan-hero-title">{{ $layanan->judul }}</h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.layanan') }}">Program Studi</a>
        <span>/</span>
        <span class="active">{{ Str::limit($layanan->judul, 35) }}</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand">
  <div class="container">
    <div class="row g-5">

      <!-- LEFT: Sidebar Navigation -->
      <div class="col-lg-4" data-aos="fade-right">
        <div class="ld-sidebar">
          <div class="ld-sidebar-title">
            <i class="bi bi-grid me-2 text-primary" style="color:var(--uis-purple) !important;"></i>Program & Fasilitas Lainnya
          </div>
          <ul class="ld-sidebar-list">
            @foreach($layanans as $item)
              <li>
                <a href="{{ route('homepage.layanan.detail', $item->slug ?: $item->id) }}"
                   class="ld-sidebar-link {{ $item->id === $layanan->id ? 'active' : '' }}">
                  <i class="bi {{ $item->icon }}"></i>
                  <span>{{ $item->judul }}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <!-- RIGHT: Main Detail -->
      <div class="col-lg-8" data-aos="fade-left">
        <div class="ld-content-card">
          @if($layanan->dasar_hukum)
            <span class="ld-badge"><i class="bi bi-award-fill me-1"></i> {{ $layanan->dasar_hukum }}</span>
          @endif

          <h2 class="fw-bold mb-3">{{ $layanan->judul }}</h2>
          <div class="divider-line"></div>

          <div class="fs-6 text-muted mb-4" style="line-height: 1.8; text-align: justify;">
            {!! $layanan->deskripsi !!}
          </div>

          @if(!empty($layanan->rincian))
            <h4 class="fw-bold mb-3 mt-4">Keunggulan & Cakupan Kurikulum / Layanan</h4>
            @if(str_contains($layanan->rincian, '<') && str_contains($layanan->rincian, '>'))
              <div class="p-3 rounded-3 mb-4" style="background: var(--surface-light); border: 1px solid var(--border-light);">
                {!! $layanan->rincian !!}
              </div>
            @else
              <div class="row g-3 mb-4">
                @foreach($rincianItems as $item)
                  <div class="col-12">
                    <div class="p-3 rounded-3" style="background: var(--surface-light); border: 1px solid var(--border-light); display: flex; align-items: flex-start; gap: 12px;">
                      <i class="bi bi-check2-circle fs-5" style="color: var(--uis-purple); margin-top: -2px;"></i>
                      <span class="fw-medium text-dark">{!! strip_tags($item) !!}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          @endif

          <div class="p-4 rounded-4 mt-5" style="background: var(--obsidian-dark); color: white;">
            <h5 class="fw-bold text-white mb-2">Tertarik dengan Program Ini?</h5>
            <p class="text-white-50 small mb-3">Dapatkan informasi pendaftaran, kurikulum, dan jadwal seleksi dengan menghubungi tim layanan UIS.</p>
            <div class="d-flex flex-wrap gap-2">
              @if($layanan->link)
                <a href="{{ $layanan->link }}" target="_blank" rel="noopener noreferrer" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 20px; background: #000000; color: #ffffff; border:none;">
                  <i class="bi bi-box-arrow-up-right"></i> Website Resmi Prodi
                </a>
              @endif
              <a href="{{ route('homepage.kontak') }}" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 20px;">
                <i class="bi bi-envelope"></i> Hubungi Kami
              </a>
              <a href="{{ route('homepage.layanan') }}" class="btn-outline-hero" style="font-size: 13.5px; padding: 10px 20px;">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
