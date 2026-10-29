@extends('layouts.frontend.template')

@section('title', 'Profil Pimpinan & Program Studi — Teknik Informatika')
@section('meta_description', 'Profil Pimpinan dan Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')
@section('meta_keywords', 'profil pimpinan teknik informatika, fakultas sains dan teknologi, program studi teknik informatika')

@section('content')
@php
  $cleanWa = '';
  if (!empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

<!-- ═══════════════════════════════════════════════
     ABOUT HERO BANNER
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <div class="badge px-3 py-2 rounded-pill mb-2" style="background: #f9dc4b; color: #000000; font-weight: 700; font-size: 12.5px;">
        <i class="bi bi-person-vcard me-1"></i> Program Studi Teknik Informatika · Fakultas Sains dan Teknologi
      </div>
      <h1 class="about-hero-title">
        Profil <em>Pimpinan & Prodi</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Profil Pimpinan</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     PROFIL PIMPINAN & PROGRAM STUDI
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container">
    {{-- DAFTAR PROFIL PIMPINAN --}}
    @if(isset($pimpinansByBaris) && $pimpinansByBaris->count() > 0)
      <div class="mb-5 pb-4 border-bottom" style="border-color: #eef2f6 !important;">
        <div class="text-center mb-5" data-aos="fade-up">
          <div class="section-label mx-auto">Jajaran Pimpinan</div>
          <h2 class="section-title">Profil <em>Pimpinan</em></h2>
          <div class="divider-line centered"></div>
        </div>

        <div class="d-flex flex-column gap-5">
          @foreach($pimpinansByBaris as $baris => $items)
            <div class="row justify-content-center g-4 g-lg-5" data-aos="fade-up">
              @php
                $colClass = $items->count() <= 2 ? 'col-lg-5 col-md-6' : 'col-lg-4 col-md-6';
              @endphp
              @foreach($items as $pimpinan)
                <div class="{{ $colClass }} text-center">
                  <div class="d-flex flex-column align-items-center h-100">
                    {{-- Foto Pimpinan Full Tanpa Card Bingkai --}}
                    <div class="mb-3" style="width: 100%; max-width: 245px;">
                      @if($pimpinan->foto)
                        <img src="{{ asset('storage/' . $pimpinan->foto) }}"
                             alt="{{ $pimpinan->nama }}"
                             style="width: 100%; height: auto; display: block; margin: 0 auto; border: none !important; box-shadow: none !important; background: transparent !important;">
                      @else
                        <div class="d-flex flex-column align-items-center justify-content-center mx-auto"
                             style="width: 230px; height: 320px; background: #143622; color: #ffffff;">
                          <i class="bi bi-person-fill" style="font-size: 72px; color: #f9dc4b;"></i>
                          <span class="small fw-semibold px-2 text-center mt-2">{{ $pimpinan->nama }}</span>
                        </div>
                      @endif
                    </div>

                    {{-- Nama & Jabatan --}}
                    <h4 class="fw-bold mb-1" style="font-size: 16.5px; color: #334155; font-family: 'Plus Jakarta Sans', sans-serif;">
                      {{ $pimpinan->nama }}
                    </h4>
                    <div class="mb-3" style="font-size: 14.5px; color: #475569;">
                      {{ $pimpinan->jabatan }}
                    </div>

                    {{-- Tombol Lihat Profil --}}
                    <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}"
                       class="d-inline-flex align-items-center justify-content-center fw-bold text-decoration-none"
                       style="background-color: #0f172a; color: #ffffff; font-size: 13.5px; padding: 7px 22px; border-radius: 999px; transition: all 0.2s ease;">
                      Lihat Profil
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="row">
      <div class="col-12" data-aos="fade-up" data-aos-duration="800">
        <!-- Header Profil -->
        <div class="text-center mb-4">
          <div class="section-label mx-auto">Profil Program Studi · Fakultas Sains dan Teknologi</div>
          <h2 class="section-title">{!! $about->judul_profil ?? 'Program Studi S1 <em>Teknik Informatika</em>' !!}</h2>
          <div class="divider-line centered"></div>
        </div>

        {{-- 1. VIDEO PROFIL DI ATAS (FULL WIDTH) --}}
        @if($about?->hasVideo())
          <div class="w-100 mb-5" data-aos="fade-up" data-aos-delay="100">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border w-100" style="border-color: #e2e8f0; background: #000;">
              @if($about->video_file)
                <video controls class="w-100 d-block" style="max-height: 560px; object-fit: contain;">
                  <source src="{{ asset('storage/' . $about->video_file) }}">
                  Browser Anda tidak mendukung tag video.
                </video>
              @elseif($about->youtube_embed_url)
                <div class="ratio ratio-16x9">
                  <iframe 
                    src="{{ $about->youtube_embed_url }}" 
                    title="Video Profil Teknik Informatika" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen>
                  </iframe>
                </div>
              @endif
            </div>
            @if($about->youtube_watch_url)
              <div class="d-flex justify-content-end align-items-center gap-2 mt-2 px-1">
                <span class="text-muted small">Video bermasalah saat diputar?</span>
                <a href="{{ $about->youtube_watch_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm text-white fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #000000; font-size: 12.5px; border-radius: 6px; padding: 4px 12px;">
                  <i class="bi bi-youtube text-warning"></i> Buka Langsung di YouTube <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 10px;"></i>
                </a>
              </div>
            @endif
          </div>
        @endif

        {{-- 2. DESKRIPSI PARAGRAF DI BAWAH (FULL WIDTH 100%) --}}
        <div class="w-100 p-4 p-md-5 rounded-4 shadow-sm mb-4" style="width: 100% !important; max-width: 100% !important; text-align: justify; font-size: 17px; line-height: 2.0; color: #2d3748; background: #f8faf9; border-left: 6px solid var(--uis-green, #000000); border-top: 1px solid #edf2f7; border-right: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7;" data-aos="fade-up" data-aos-delay="200">
          {!! $about->deskripsi_profil_1 ?? 'Teknik Informatika (UIS) Batam merupakan perguruan tinggi swasta terkemuka di Provinsi Kepulauan Riau yang lahir dari perpaduan keunggulan akademik Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES) di bawah naungan Yayasan Pendidikan Ibnu Sina Batam (YAPISNA). Berlokasi strategis di kawasan industri dan perdagangan internasional Kota Batam, UIS mengelola tiga fakultas unggulan: Fakultas Teknik (Sains & Teknologi), Fakultas Ekonomi dan Bisnis (FEB), serta Fakultas Ilmu Kesehatan (FIKES), beserta Program Pascasarjana (Magister). UIS bertekad mencetak lulusan profesional muda yang inovatif, berdaya saing global, berjiwa entrepreneur, dan berakhlak mulia berlandaskan Iman dan Taqwa (Imtaq).' !!}
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
