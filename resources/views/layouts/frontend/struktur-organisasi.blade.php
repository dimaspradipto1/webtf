@extends('layouts.frontend.template')

@section('title', 'Struktur Organisasi — Teknik Informatika (UIS)')
@section('meta_description', 'Susunan pimpinan pimpinan, ketua program studi, dan tata kelola organisasi Teknik Informatika (UIS).')
@section('meta_keywords', 'struktur organisasi uis, pimpinan uis, ketua program studi, manajemen uis')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="about-hero-title">
        Struktur <em>Organisasi</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil</a>
        <span>/</span>
        <span class="active">Struktur Organisasi</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     STRUKTUR ORGANISASI SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-sand">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Tata Kelola Program Studi · Fakultas Sains dan Teknologi</div>
      <h2 class="section-title">Bagan <em>Kepemimpinan & Organisasi</em> Teknik Informatika</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Tata kelola yang profesional, transparan, dan akuntabel di bawah pimpinan Fakultas Sains dan Teknologi serta Ketua Program Studi Teknik Informatika.
      </p>
    </div>

    <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-lg-10">
        <div class="struktur-card text-center">
          @if(isset($struktur) && $struktur->url_struktur)
            <img
              src="{{ asset($struktur->url_struktur) }}"
              alt="Struktur Organisasi UIS"
              class="img-fluid rounded-4"
              style="max-width: 900px; width: 100%;"
            >
          @else
            <div class="py-5">
              <i class="bi bi-diagram-3 fs-1 text-muted d-block mb-3"></i>
              <h5 class="fw-bold">Bagan Struktur Organisasi</h5>
              <p class="text-muted small">Bagan susunan organisasi dapat diperbarui melalui panel administrator.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
