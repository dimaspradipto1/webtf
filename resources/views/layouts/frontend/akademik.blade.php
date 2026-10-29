@extends('layouts.frontend.template')

@section('title', $item->judul . ' — Teknik Informatika')
@section('meta_description', Str::limit(strip_tags($item->subjudul ?? $item->deskripsi), 160))

@section('content')
<!-- ═══════════════════════════════════════════════
     HERO HEADER
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      LAYANAN AKADEMIK Teknik Informatika
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">{{ $item->judul }}</h1>
    @if($item->subjudul)
      <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
        {{ $item->subjudul }}
      </p>
    @endif
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">{{ $pageTitle }}</span>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="row g-4">
      
      {{-- Kolom Konten Utama --}}
      <div class="col-lg-8" data-aos="fade-up">
        <div class="akademik-card">
          
          {{-- Banner Gambar jika ada --}}
          @if($item->gambar)
            <div class="mb-4 rounded-4 overflow-hidden shadow-sm">
              <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-100 img-fluid" style="max-height: 420px; object-fit: cover;">
            </div>
          @endif

          {{-- Dokumen Unduhan (PDF dll) --}}
          @if($item->file_dokumen)
            <div class="doc-download-box d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
              <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-white shadow-sm text-danger fs-3">
                  <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>
                <div>
                  <h6 class="fw-bold text-dark mb-1">{{ $item->file_nama ?: 'Dokumen ' . $pageTitle }}</h6>
                  <div class="small text-muted">Klik tombol di samping untuk mengunduh dokumen resmi (PDF).</div>
                </div>
              </div>
              <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 22px; white-space: nowrap;">
                <i class="bi bi-download"></i> Unduh File PDF
              </a>
            </div>
          @endif

          {{-- Portal Link Eksternal (SIAKAD dll) --}}
          @if(!empty($item->link_url))
            <div class="p-4 rounded-4 mb-4 text-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3" style="background: #000000; border: 1px solid #000000;">
              <div>
                <h5 class="fw-bold text-white mb-1"><i class="bi bi-laptop me-2" style="color: #f9dc4b;"></i>Akses Langsung Sistem Online</h5>
                <p class="text-white-50 small mb-0">Klik tombol untuk masuk ke portal sistem resmi Teknik Informatika.</p>
              </div>
              <a href="{{ $item->link_url }}" target="_blank" class="btn-primary-hero" style="font-size: 13.5px; padding: 10px 24px; white-space: nowrap;">
                Buka Portal <i class="bi bi-box-arrow-up-right ms-1"></i>
              </a>
            </div>
          @endif

          {{-- Isi Teks Deskripsi --}}
          <div class="article-content" style="font-size: 15.5px; line-height: 1.8; color: #2d3748;">
            {!! $item->deskripsi !!}
          </div>

        </div>
      </div>

      {{-- Kolom Sidebar Navigasi Akademik --}}
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Widget Menu Akademik Lainnya --}}
        <div class="nav-akademik-sidebar mb-4">
          <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
            <i class="bi bi-mortarboard-fill text-primary me-2"></i>Menu Akademik
          </h6>
          <nav class="d-flex flex-column">
            <a href="{{ route('homepage.kurikulum') }}" class="nav-akademik-link {{ request()->routeIs('homepage.kurikulum') ? 'active' : '' }}">
              <i class="bi bi-journal-text"></i> Kurikulum
            </a>
            <a href="{{ route('homepage.kalender-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.kalender-akademik') ? 'active' : '' }}">
              <i class="bi bi-calendar-check"></i> Kalender Akademik
            </a>
            <a href="{{ route('homepage.pedoman-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.pedoman-akademik') ? 'active' : '' }}">
              <i class="bi bi-book"></i> Pedoman Akademik
            </a>
            <a href="{{ route('homepage.sistem-akademik') }}" class="nav-akademik-link {{ request()->routeIs('homepage.sistem-akademik') ? 'active' : '' }}">
              <i class="bi bi-laptop"></i> Sistem Akademik
            </a>
          </nav>
        </div>

        {{-- Widget Kontak / PMB --}}
        <div class="p-4 rounded-4 text-white" style="background: #000000; border: 1px solid #000000;">
          <div class="badge px-3 py-1 rounded-pill mb-2" style="background: #f9dc4b; color: #000000; font-weight: 800; font-size: 11px;">
            INFORMASI PMB
          </div>
          <h5 class="fw-bold text-white mb-2">Butuh Bantuan Akademik?</h5>
          <p class="text-white-50 small mb-3">
            Hubungi Bagian Tata Usaha & Layanan Akademik Teknik Informatika untuk informasi lebih lanjut.
          </p>
          <a href="{{ route('homepage.kontak') }}" class="btn btn-outline-light w-100 rounded-3 fw-bold py-2" style="font-size: 13.5px;">
            <i class="bi bi-telephone me-1"></i> Hubungi Kami
          </a>
        </div>

      </div>

    </div>
  </div>
</section>
@endsection
