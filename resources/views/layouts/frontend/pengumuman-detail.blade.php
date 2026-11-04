@extends('layouts.frontend.template')

@section('title', $announcement->title . ' — Teknik Informatika (UIS)')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? $announcement->title), 150))

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'pengumuman',
    'defaultJudul' => 'Pengumuman Resmi',
    'defaultSubjudul' => $announcement->title,
    'defaultBreadcrumb' => 'Detail Pengumuman'
])

<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="row g-4 justify-content-center">
      
      {{-- Konten Utama Pengumuman --}}
      <div class="col-lg-8" data-aos="fade-up">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
          {{-- Info Tanggal --}}
          <div class="d-flex align-items-center gap-2 text-muted small mb-3 pb-3 border-bottom">
            <span class="badge bg-warning text-dark px-3 py-1 fw-bold">PENGUMUMAN</span>
            <span>•</span>
            <span><i class="bi bi-calendar3 me-1 text-primary"></i> {{ $announcement->date ? \Carbon\Carbon::parse($announcement->date)->translatedFormat('l, d F Y') : '-' }}</span>
          </div>

          {{-- Judul Lengkap --}}
          <h2 class="fw-bold text-dark mb-4" style="line-height: 1.35; font-size: 26px;">
            {{ $announcement->title }}
          </h2>

          {{-- Isi / Konten Pengumuman --}}
          <div class="announcement-content text-dark mb-4" style="line-height: 1.8; font-size: 15.5px;">
            {!! nl2br(e($announcement->content)) !!}
          </div>

          {{-- Tombol Lampiran / Link --}}
          @if($announcement->file_path || $announcement->link_url)
            <div class="p-3 rounded-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #f8fafc; border: 1.5px dashed #cbd5e1;">
              <div>
                <div class="fw-bold text-dark small mb-1"><i class="bi bi-paperclip me-1 text-primary"></i> Dokumen & Lampiran Terkait</div>
                <div class="text-muted" style="font-size: 12.5px;">Silakan unduh atau buka tautan di bawah ini untuk informasi lebih detail.</div>
              </div>
              <div class="d-flex gap-2">
                @if($announcement->file_path)
                  <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold">
                    <i class="bi bi-download me-1"></i> Unduh Berkas
                  </a>
                @endif
                @if($announcement->link_url)
                  <a href="{{ $announcement->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tautan
                  </a>
                @endif
              </div>
            </div>
          @endif

          <div class="pt-3 border-top d-flex align-items-center justify-content-between">
            <a href="{{ route('homepage.pengumuman') }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-semibold">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengumuman
            </a>
            <a href="{{ route('homepage') }}#berita" class="btn btn-light rounded-pill px-3 btn-sm text-muted">
              Beranda
            </a>
          </div>
        </div>
      </div>

      {{-- Sidebar Pengumuman Lainnya --}}
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
          <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
            <i class="bi bi-megaphone-fill text-warning me-2"></i>Pengumuman Lainnya
          </h5>

          @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
            <div class="d-flex flex-column gap-3">
              @foreach($recentAnnouncements as $rAnn)
                <a href="{{ route('homepage.pengumuman.detail', $rAnn->slug) }}" class="text-decoration-none p-2 rounded-3 hover-bg-light" style="transition: background 0.2s;">
                  <div class="small fw-semibold text-dark mb-1" style="line-height: 1.4;">
                    {{ $rAnn->title }}
                  </div>
                  <div class="text-muted" style="font-size: 11.5px;">
                    <i class="bi bi-calendar3 me-1"></i>{{ $rAnn->date ? \Carbon\Carbon::parse($rAnn->date)->translatedFormat('d M Y') : '-' }}
                  </div>
                </a>
              @endforeach
            </div>
          @else
            <div class="text-muted small">Tidak ada pengumuman lainnya.</div>
          @endif
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
