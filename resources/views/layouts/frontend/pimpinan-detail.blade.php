@extends('layouts.frontend.template')

@section('title', $pimpinan->nama . ' — Profil Pimpinan Teknik Informatika')
@section('meta_description', 'Profil lengkap ' . $pimpinan->nama . ' (' . $pimpinan->jabatan . ') — Program Studi Teknik Informatika Fakultas Sains dan Teknologi.')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <div class="badge px-3 py-2 rounded-pill mb-2" style="background: #f9dc4b; color: #000000; font-weight: 700; font-size: 12.5px;">
        <i class="bi bi-person-vcard me-1"></i> Profil Pimpinan · Fakultas Sains dan Teknologi
      </div>
      <h1 class="about-hero-title">
        {{ $pimpinan->nama }}
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil Pimpinan</a>
        <span>/</span>
        <span class="active">{{ $pimpinan->nama }}</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     DETAIL PROFIL PIMPINAN
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container py-2">
    <div class="mb-4">
      <a href="{{ route('homepage.tentang') }}"
         class="d-inline-flex align-items-center gap-2 fw-bold text-decoration-none"
         style="background: #0f172a; color: #ffffff; font-size: 13.5px; padding: 8px 18px; border-radius: 999px;">
        <i class="bi bi-arrow-left"></i> Kembali ke Profil Pimpinan
      </a>
    </div>

    <div class="row g-4 g-lg-5 align-items-start">
      {{-- Kolom Kiri: Foto Full Tanpa Bingkai Card --}}
      <div class="col-lg-5 col-md-5" data-aos="fade-right">
        @if($pimpinan->foto)
          <img src="{{ asset('storage/' . $pimpinan->foto) }}"
               alt="{{ $pimpinan->nama }}"
               style="width: 100%; height: auto; display: block; border: none !important; box-shadow: none !important; background: transparent !important;">
        @else
          <div class="d-flex flex-column align-items-center justify-content-center w-100"
               style="min-height: 480px; background: #143622; color: #ffffff;">
            <i class="bi bi-person-fill" style="font-size: 96px; color: #f9dc4b;"></i>
            <h5 class="fw-bold mt-3 px-3 text-center text-white">{{ $pimpinan->nama }}</h5>
            <p class="small text-warning mb-0 px-3 text-center">{{ $pimpinan->jabatan }}</p>
          </div>
        @endif
      </div>

      {{-- Kolom Kanan: Biodata Lengkap --}}
      <div class="col-lg-7 col-md-7" data-aos="fade-left" style="color: #475569; font-size: 15px; line-height: 1.8;">
        {{-- 1. Profil --}}
        <div class="mb-4">
          <h5 class="fw-bold mb-3" style="font-size: 16px; color: #334155;">Profil</h5>
          <div>Nama : {{ $pimpinan->nama }}</div>
          @if(!empty($pimpinan->tempat_tanggal_lahir))
            <div>Tempat/Tanggal Lahir : {{ $pimpinan->tempat_tanggal_lahir }}</div>
          @endif
          @if(!empty($pimpinan->email))
            <div>Email : {{ $pimpinan->email }}</div>
          @endif
          @if(empty($pimpinan->tempat_tanggal_lahir) && empty($pimpinan->email))
            <div>Jabatan : {{ $pimpinan->jabatan }}</div>
          @endif
        </div>

        {{-- 2. Pendidikan --}}
        @if(!empty($pimpinan->pendidikan_list))
          <div class="mb-4">
            <h5 class="fw-bold mb-2" style="font-size: 16px; color: #334155;">Pendidikan</h5>
            <ul class="ps-4 mb-0">
              @foreach($pimpinan->pendidikan_list as $item)
                <li class="mb-1">{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- 3. Pengalaman Organisasi Kemahasiswaan --}}
        @if(!empty($pimpinan->pengalaman_organisasi_list))
          <div class="mb-4">
            <h5 class="fw-bold mb-2" style="font-size: 16px; color: #334155;">Pengalaman Organisasi Kemahasiswaan</h5>
            <ul class="ps-4 mb-0">
              @foreach($pimpinan->pengalaman_organisasi_list as $item)
                <li class="mb-1">{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- 4. Pengalaman Kerja --}}
        @if(!empty($pimpinan->pengalaman_kerja_list))
          <div class="mb-4">
            <h5 class="fw-bold mb-2" style="font-size: 16px; color: #334155;">Pengalaman Kerja</h5>
            <ul class="ps-4 mb-0">
              @foreach($pimpinan->pengalaman_kerja_list as $item)
                <li class="mb-1">{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- 5. Jabatan --}}
        @if(!empty($pimpinan->riwayat_jabatan_list))
          <div class="mb-4">
            <h5 class="fw-bold mb-2" style="font-size: 16px; color: #334155;">Jabatan</h5>
            <ul class="ps-4 mb-0">
              @foreach($pimpinan->riwayat_jabatan_list as $item)
                <li class="mb-1">{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@endsection

