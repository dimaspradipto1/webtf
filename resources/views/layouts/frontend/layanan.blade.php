@extends('layouts.frontend.template')

@section('title', 'Fakultas & Program Studi — Teknik Informatika (UIS)')
@section('meta_description', 'Jelajahi fakultas dan program studi unggulan serta fasilitas akademik terpadu di Teknik Informatika (UIS) Batam.')
@section('meta_keywords', 'program studi uis, fakultas teknik, fakultas ekonomi bisnis, fakultas ilmu kesehatan, magister manajemen, teknik informatika batam')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="layanan-hero">
  <div class="container">
    <div class="layanan-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="layanan-hero-title">
        Program Studi & <em>Fasilitas</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <span class="active">Program Studi</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     LAYANAN LIST
═══════════════════════════════════════════════ -->
<section class="section-bg-white">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Akademik & Fasilitas</div>
      <h2 class="section-title">Pendidikan Berkualitas & <em>Fasilitas Modern</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Mencetak profesional muda yang unggul, kompeten, berjiwa entrepreneur, dan siap berkontribusi nyata bagi industri nasional maupun global.
      </p>
    </div>

    <div class="row g-4">
      @forelse($layanans as $layanan)
        @php
          $rincianItems = $layanan->rincian
            ? array_filter(array_map('trim', explode("\n", $layanan->rincian)))
            : [];
        @endphp
        <div class="col-lg-6" data-aos="fade-up">
          <div class="layanan-card-box">
            <div>
              <div class="layanan-card-head">
                <div class="layanan-card-icon"><i class="bi {{ $layanan->icon }}"></i></div>
                <div>
                  <h3 class="layanan-card-title">{{ $layanan->judul }}</h3>
                  @if($layanan->dasar_hukum)
                    <span class="layanan-card-badge">{{ $layanan->dasar_hukum }}</span>
                  @endif
                </div>
              </div>
              <div class="layanan-card-desc mb-3" style="line-height: 1.65; text-align: justify;">
                {!! $layanan->deskripsi !!}
              </div>
              @if(!empty($layanan->rincian))
                @if(str_contains($layanan->rincian, '<') && str_contains($layanan->rincian, '>'))
                  <div class="layanan-rich-rincian small mb-3">
                    {!! $layanan->rincian !!}
                  </div>
                @else
                  <ul class="layanan-card-list">
                    @foreach(array_slice($rincianItems, 0, 4) as $item)
                      <li><i class="bi bi-check-circle-fill"></i> {!! strip_tags($item) !!}</li>
                    @endforeach
                  </ul>
                @endif
              @endif
            </div>
            <div class="d-flex gap-2 flex-wrap">
              @if($layanan->link)
                <a href="{{ $layanan->link }}" target="_blank" rel="noopener noreferrer" class="layanan-detail-btn" style="background:var(--uis-purple); color:#fff; border-color:var(--uis-purple);">
                  Website Prodi <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
              @endif
              <a href="{{ route('homepage.layanan.detail', $layanan->slug ?: $layanan->id) }}" class="layanan-detail-btn">
                Lihat Detail <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">Belum ada data program studi atau fasilitas.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

@endsection
