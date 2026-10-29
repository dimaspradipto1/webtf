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
      PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI
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
      
      {{-- Kolom Konten Utama (Full Width) --}}
      <div class="col-12" data-aos="fade-up">
        @if(isset($kalenderItems) && $kalenderItems->count() > 0)
          {{-- Accordion Daftar Kalender Akademik per Tahun (Link Google Drive) --}}
          <div class="kalender-accordion-list">
            @foreach($kalenderItems as $idx => $kItem)
              @php $isOpen = ($idx === 0); @endphp
              <div class="kalender-acc-item {{ $isOpen ? 'active' : '' }}">
                <button type="button"
                        class="kalender-acc-header"
                        onclick="toggleKalenderAcc(this)"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                  <span class="kalender-acc-left">
                    <i class="bi {{ $isOpen ? 'bi-dash-lg' : 'bi-plus-lg' }} kalender-acc-sign"></i>
                    <span class="kalender-acc-title">{{ $kItem->judul_tab }}</span>
                  </span>
                  <i class="bi {{ $isOpen ? 'bi-chevron-down' : 'bi-chevron-right' }} kalender-acc-chevron"></i>
                </button>
                <div class="kalender-acc-body" style="{{ $isOpen ? 'display: block;' : 'display: none;' }}">
                  <div class="kalender-acc-content">
                    <a href="{{ $kItem->gdrive_url ?: '#' }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="kalender-doc-title">
                      {{ $kItem->nama_dokumen }}
                    </a>
                    @if(!empty($kItem->gdrive_url))
                      <a href="{{ $kItem->gdrive_url }}"
                         target="_blank"
                         rel="noopener noreferrer"
                         class="kalender-doc-btn">
                        {{ $kItem->tombol_teks ?: 'Lihat Document' }}
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
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
            @if(!empty(trim(strip_tags($item->deskripsi ?? ''))))
            <div class="article-content" style="font-size: 15.5px; line-height: 1.8; color: #2d3748;">
              {!! $item->deskripsi !!}
            </div>
            @endif

          </div>
        @endif
      </div>

    </div>
  </div>
</section>

@if(isset($kalenderItems) && $kalenderItems->count() > 0)
@push('styles')
<style>
  .kalender-accordion-list {
    border: 1px solid #e5e7eb;
    background: #ffffff;
  }
  .kalender-acc-item {
    border-bottom: 1px solid #e5e7eb;
  }
  .kalender-acc-item:last-child {
    border-bottom: none;
  }
  .kalender-acc-header {
    width: 100%;
    border: none;
    background: #f1f1f1;
    color: #333333;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-align: left;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
  }
  .kalender-acc-header:hover {
    background: #e5e7eb;
  }
  .kalender-acc-item.active .kalender-acc-header {
    background: #0d1522;
    color: #ffffff;
  }
  .kalender-acc-left {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .kalender-acc-sign {
    font-size: 16px;
    font-weight: 800;
    line-height: 1;
  }
  .kalender-acc-chevron {
    font-size: 13px;
  }
  .kalender-acc-body {
    background: #ffffff;
    padding: 24px 22px;
  }
  .kalender-acc-content {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }
  .kalender-doc-title {
    font-size: 13.5px;
    font-weight: 500;
    color: #243b53;
    text-decoration: none;
    letter-spacing: 0.2px;
  }
  .kalender-doc-title:hover {
    color: #000000;
    text-decoration: underline;
  }
  .kalender-doc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #2f4f1d;
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 600;
    padding: 9px 24px;
    border-radius: 50px;
    text-decoration: none !important;
    transition: opacity 0.2s ease, transform 0.15s ease;
  }
  .kalender-doc-btn:hover {
    opacity: 0.92;
    transform: translateY(-1px);
  }
</style>
@endpush

<script>
  function toggleKalenderAcc(button) {
    const currentItem = button.closest('.kalender-acc-item');
    const list = button.closest('.kalender-accordion-list');
    const isAlreadyOpen = currentItem.classList.contains('active');

    list.querySelectorAll('.kalender-acc-item').forEach(function (item) {
      item.classList.remove('active');
      const header = item.querySelector('.kalender-acc-header');
      const body = item.querySelector('.kalender-acc-body');
      const sign = item.querySelector('.kalender-acc-sign');
      const chevron = item.querySelector('.kalender-acc-chevron');

      if (header) header.setAttribute('aria-expanded', 'false');
      if (body) body.style.display = 'none';
      if (sign) {
        sign.classList.remove('bi-dash-lg');
        sign.classList.add('bi-plus-lg');
      }
      if (chevron) {
        chevron.classList.remove('bi-chevron-down');
        chevron.classList.add('bi-chevron-right');
      }
    });

    if (!isAlreadyOpen) {
      currentItem.classList.add('active');
      button.setAttribute('aria-expanded', 'true');
      const body = currentItem.querySelector('.kalender-acc-body');
      const sign = currentItem.querySelector('.kalender-acc-sign');
      const chevron = currentItem.querySelector('.kalender-acc-chevron');

      if (body) body.style.display = 'block';
      if (sign) {
        sign.classList.remove('bi-plus-lg');
        sign.classList.add('bi-dash-lg');
      }
      if (chevron) {
        chevron.classList.remove('bi-chevron-right');
        chevron.classList.add('bi-chevron-down');
      }
    }
  }
</script>
@endif
@endsection
