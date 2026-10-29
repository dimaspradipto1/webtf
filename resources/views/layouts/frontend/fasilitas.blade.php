@extends('layouts.frontend.template')

@section('title', 'Fasilitas Kampus — Program Studi Teknik Informatika')
@section('meta_description', 'Fasilitas laboratorium komputasi, sarana riset, dan penunjang akademik Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')

@section('content')

@php
  $hFasilitas = \App\Models\PageHeader::get('fasilitas');
@endphp
<!-- ═══════════════════════════════════════════════
     HERO HEADER & BREADCRUMB
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange, #f9dc4b); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      {{ $hFasilitas->badge_text ?: 'PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI' }}
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">{{ $hFasilitas->judul }}</h1>
    @if(!empty($hFasilitas->subjudul))
      <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
        {{ $hFasilitas->subjudul }}
      </p>
    @endif
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.tentang') }}">Profil</a>
      <span>/</span>
      <span class="active">{{ $hFasilitas->breadcrumb_label ?: 'Fasilitas Kampus' }}</span>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     DAFTAR FASILITAS & LABORATORIUM
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Sarana & Prasarana Prodi</div>
      <h2 class="section-title">Fasilitas & <em>Laboratorium</em> Teknik Informatika</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Menunjang kegiatan perkuliahan, praktikum rekayasa perangkat lunak, kecerdasan buatan (AI), jaringan komputer, dan riset mahasiswa Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.
      </p>
    </div>

    <div class="row g-4">
      @if(isset($saranas) && $saranas->count() > 0)
        @foreach($saranas as $index => $sarana)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
            <div class="fasilitas-box h-100">
              <div class="fasilitas-icon"><i class="bi {{ $sarana->icon ?? 'bi-pc-display-horizontal' }}"></i></div>
              <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
              <p class="fasilitas-desc">{{ $sarana->deskripsi ?: 'Fasilitas laboratorium dan sarana penunjang akademik mahasiswa Program Studi Teknik Informatika.' }}</p>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted py-5 bg-white rounded-4 shadow-sm">
          <i class="bi bi-buildings fs-1 d-block mb-2"></i>
          Belum ada data fasilitas kampus yang dipublikasikan.
        </div>
      @endif
    </div>
  </div>
</section>

@endsection

