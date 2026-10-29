@extends('layouts.frontend.template')

@section('title', 'Hubungi Kami — Teknik Informatika (UIS)')
@section('meta_description', 'Hubungi Teknik Informatika (UIS) untuk informasi program studi, layanan akademik, praktikum laboratorium, dan penerimaan mahasiswa baru.')
@section('meta_keywords', 'kontak uis, alamat teknik informatika, nomor wa uis, lokasi kampus uis')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="contact-hero">
  <div class="container">
    <div class="contact-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="contact-hero-title">
        Hubungi <em>UIS</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Hubungi Kami</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     CONTACT INFO CARDS & MAP
═══════════════════════════════════════════════ -->
<section class="section-bg-white">
  <div class="container">
    
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-geo-alt-fill"></i></div>
          <h4 class="contact-card-title">Alamat Kampus</h4>
          <p class="contact-card-text">
            {{ $contact->alamat ?? 'Gedung Teknik Informatika (UIS), Kampus Terpadu' }}
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-envelope-open-fill"></i></div>
          <h4 class="contact-card-title">Email Resmi</h4>
          <p class="contact-card-text">
            <a href="mailto:{{ $contact->email ?? 'humas@uis.ac.id' }}" class="text-decoration-none fw-bold" style="color: var(--uis-purple);">
              {{ $contact->email ?? 'humas@uis.ac.id' }}
            </a>
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-whatsapp"></i></div>
          <h4 class="contact-card-title">Layanan WhatsApp</h4>
          <p class="contact-card-text">
            @if(!empty($cleanWa))
              <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="text-decoration-none fw-bold text-success">
                <i class="bi bi-whatsapp me-1"></i> {{ $contact->no_wa ?? '0812-3456-7890' }}
              </a>
            @else
              <span>{{ $contact->no_wa ?? '0812-3456-7890' }}</span>
            @endif
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-clock-fill"></i></div>
          <h4 class="contact-card-title">Jam Layanan</h4>
          <p class="contact-card-text">
            Senin - Jumat: 08.00 - 16.00 WIB<br>
            Sabtu: 08.00 - 13.00 WIB
          </p>
        </div>
      </div>
    </div>

    <!-- PETA LOKASI -->
    @if(isset($contact) && !empty($contact->map))
      <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; border: 1px solid var(--border-light) !important;" data-aos="fade-up">
        <div class="p-3 bg-light border-bottom fw-bold text-dark d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="bi bi-pin-map-fill text-danger me-2 fs-5"></i>
            <span>Lokasi Kampus UIS di Google Maps</span>
          </div>
          @if(!empty($contact->latitude) && !empty($contact->longitude))
            <a href="https://www.google.com/maps/search/?api=1&query={{ $contact->latitude }},{{ $contact->longitude }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" style="font-size: 12.5px;">
              <i class="bi bi-box-arrow-up-right me-1"></i> Buka Peta Penuh
            </a>
          @endif
        </div>
        <div class="map-responsive-container">
          {!! $contact->map !!}
        </div>
      </div>
    @endif

  </div>
</section>

@endsection
