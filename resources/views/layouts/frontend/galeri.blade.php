@extends('layouts.frontend.template')

@php
  $isHumas = ($kategori ?? '') === 'humas';
@endphp

@section('title', ($isHumas ? 'Galeri & Kegiatan Humas' : 'Galeri & Dokumentasi') . ' — Teknik Informatika (UIS)')
@section('meta_description', $isHumas ? 'Galeri foto liputan, publikasi, dan dokumentasi kegiatan Humas Teknik Informatika (UIS).' : 'Galeri foto kegiatan akademik, praktikum laboratorium, pengabdian masyarakat, dan wisuda Teknik Informatika (UIS).')
@section('meta_keywords', 'galeri uis, dokumentasi uis, foto kampus uis, humas uis, teknik informatika batam')

@section('content')

@if($isHumas)
  @include('layouts.frontend.partials.hero-header', [
      'pageKey' => 'galeri',
      'parentUrl' => route('homepage.humas'),
      'parentLabel' => 'Humas',
      'defaultJudul' => 'Galeri & Kegiatan Humas',
      'defaultSubjudul' => 'Dokumentasi visual kegiatan kehumasan dan publikasi kampus.',
      'defaultBreadcrumb' => 'Galeri Humas'
  ])
@else
  @include('layouts.frontend.partials.hero-header', [
      'pageKey' => 'galeri',
      'defaultJudul' => 'Galeri Foto & Dokumentasi',
      'defaultSubjudul' => 'Dokumentasi visual kegiatan perkuliahan, praktikum laboratorium, seminar nasional, pengabdian masyarakat, dan wisuda.',
      'defaultBreadcrumb' => 'Galeri & Dokumentasi'
  ])
@endif

<!-- ═══════════════════════════════════════════════
     GALLERY GRID
═══════════════════════════════════════════════ -->
<section class="section-bg-white">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      @if($isHumas)
        <div class="section-label mx-auto">Dokumentasi Humas</div>
        <h2 class="section-title">Galeri & <em>Kegiatan Humas</em></h2>
        <div class="divider-line centered"></div>
        <p class="section-desc mx-auto">
          Kumpulan dokumentasi publikasi, liputan media, siaran pers, dan seluruh kegiatan kehumasan Teknik Informatika.
        </p>
      @else
        <div class="section-label mx-auto">Dokumentasi Kampus</div>
        <h2 class="section-title">Aktivitas & <em>Kegiatan Mahasiswa</em></h2>
        <div class="divider-line centered"></div>
        <p class="section-desc mx-auto">
          Kumpulan dokumentasi praktikum laboratorium, pengabdian masyarakat, seminar nasional, dan momen prestasi civitas akademika UIS.
        </p>
      @endif
    </div>

    @if($isHumas)
      {{-- Dedicated Humas Action Bar (Tanpa Univ) --}}
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 p-3 rounded-4" style="background: #eaf7ee; border: 1.5px solid #b7e4c7;" data-aos="fade-up">
        <div class="d-flex align-items-center gap-2">
          <span class="badge rounded-pill px-3 py-2" style="background: #000000; color: #ffffff; font-size: 13.5px;">
            <i class="bi bi-megaphone-fill me-1"></i> Dokumentasi Humas
          </span>
          <span class="text-muted small fw-semibold">Menampilkan seluruh foto kegiatan Humas ({{ $galleries->total() ?? $galleries->count() }} foto)</span>
        </div>
        <a href="{{ route('homepage.humas') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Humas
        </a>
      </div>
    @endif

    @if($galleries->isEmpty())
      <div class="col-12 text-center py-5">
        <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
        <p class="text-muted">Belum ada foto dokumentasi yang diunggah.</p>
        <a href="{{ route('homepage') }}" class="btn-primary-hero mt-3">
          <i class="bi bi-house"></i> Kembali ke Beranda
        </a>
      </div>
    @else
      <div class="row g-4">
        @foreach($galleries as $item)
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <a href="{{ route('homepage.galeri.detail', $item->slug ?? $item->id) }}" class="text-decoration-none d-block">
              <div class="galeri-item-card">
                @if(!empty($item->url))
                  <img src="{{ asset('storage/' . $item->url) }}" alt="{{ $item->judul ?? 'Dokumentasi UIS' }}" class="galeri-img-wrap">
                @else
                  <div class="d-flex align-items-center justify-content-center text-white" style="height: 220px; background: #000000;">
                    <i class="bi bi-camera-fill fs-1 text-white-50"></i>
                  </div>
                @endif
                @if(!empty($item->judul))
                  <div class="galeri-caption">
                    <h6 class="text-dark mb-1 fw-bold" style="font-size: 15px; color: #1e293b !important;">{{ $item->judul }}</h6>
                    @if(!empty($item->deskripsi))
                      <small class="text-muted d-block" style="font-size: 13px; line-height: 1.5; color: #64748b !important;">{!! Str::limit(strip_tags($item->deskripsi), 90) !!}</small>
                    @endif
                    <div class="mt-2 text-primary fw-bold small d-flex align-items-center gap-1" style="font-size: 12.5px; color: var(--uis-purple) !important;">
                      <span>Lihat Detail</span>
                      <i class="bi bi-arrow-right"></i>
                    </div>
                  </div>
                @endif
              </div>
            </a>
          </div>
        @endforeach
      </div>

      @if(method_exists($galleries, 'links'))
        <div class="d-flex justify-content-center mt-5">
          {{ $galleries->links() }}
        </div>
      @endif
    @endif
  </div>
</section>

@endsection
