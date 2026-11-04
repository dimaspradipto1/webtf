@extends('layouts.frontend.template')

@section('title', $agenda->title . ' — Agenda & Kegiatan Teknik Informatika (UIS)')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($agenda->description ?? $agenda->title), 150))
@section('meta_keywords', 'agenda teknik informatika, jadwal akademik uis, ' . e($agenda->title))

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'agenda',
    'defaultJudul' => 'Agenda & Kegiatan Akademik',
    'defaultSubjudul' => $agenda->title,
    'defaultBreadcrumb' => 'Detail Agenda'
])

@php
    // Google Calendar template URL
    $calTitle = urlencode($agenda->title);
    $calDetails = urlencode($agenda->description ?? '');
    $calLoc = urlencode($agenda->location ?? 'Program Studi Teknik Informatika UIS');
    $startDate = $agenda->start_date ? $agenda->start_date->format('Ymd') : date('Ymd');
    $endDate = $agenda->end_date ? $agenda->end_date->copy()->addDay()->format('Ymd') : ($agenda->start_date ? $agenda->start_date->copy()->addDay()->format('Ymd') : date('Ymd'));
    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$startDate}/{$endDate}&details={$calDetails}&location={$calLoc}";
@endphp

<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="row g-4 justify-content-center">
      
      {{-- Konten Utama Agenda --}}
      <div class="col-lg-8" data-aos="fade-up">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
          
          {{-- Info Waktu & Tanggal Badge --}}
          <div class="d-flex flex-wrap align-items-center gap-2 mb-3 pb-3 border-bottom">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill fw-bold" style="background: #fef08a; color: #854d0e; font-size: 13.5px;">
              <i class="bi bi-calendar4-week"></i>
              <span>{{ $agenda->date_text }}</span>
            </span>
            @if($agenda->location)
              <span class="text-muted d-none d-sm-inline">•</span>
              <span class="text-muted small d-inline-flex align-items-center gap-1">
                <i class="bi bi-geo-alt-fill text-danger"></i>
                <span>{{ $agenda->location }}</span>
              </span>
            @endif
          </div>

          {{-- Judul Lengkap --}}
          <h2 class="fw-bold text-dark mb-4" style="line-height: 1.35; font-size: 26px;">
            {{ $agenda->title }}
          </h2>

          {{-- Lokasi Box Khusus (Jika ada) --}}
          @if($agenda->location)
            <div class="p-3 rounded-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #f8fafc; border-left: 4px solid #f9dc4b;">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                <div>
                  <div class="small text-muted fw-medium">Lokasi Kegiatan</div>
                  <div class="fw-bold text-dark">{{ $agenda->location }}</div>
                </div>
              </div>
              <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($agenda->location . ' UIS Batam') }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-inline-flex align-items-center gap-1" style="height: 36px; white-space: nowrap;">
                <i class="bi bi-map"></i>
                <span>Buka Peta</span>
              </a>
            </div>
          @endif

          {{-- Deskripsi / Rincian Agenda --}}
          <div class="agenda-content text-dark mb-4" style="line-height: 1.8; font-size: 15.5px;">
            @if($agenda->description)
              {!! nl2br(e($agenda->description)) !!}
            @else
              <p class="text-muted fst-italic">Tidak ada deskripsi tambahan untuk agenda ini. Silakan hubungi bagian administrasi akademik Program Studi Teknik Informatika untuk informasi lebih lanjut.</p>
            @endif
          </div>

          {{-- Tombol Tindakan Cepat (Kalender & Tautan Eksternal) --}}
          <div class="p-3 rounded-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #fdfdfd; border: 1.5px dashed #e2e8f0;">
            <div>
              <div class="fw-bold text-dark small mb-1">
                <i class="bi bi-bookmark-check-fill text-warning me-1"></i> Simpan & Ikuti Agenda
              </div>
              <div class="text-muted" style="font-size: 12.5px;">
                Tambahkan agenda ini ke Google Calendar Anda agar tidak ketinggalan jadwal.
              </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-dark rounded-pill px-3 fw-semibold text-white d-inline-flex align-items-center gap-2" style="height: 38px; white-space: nowrap;">
                <i class="bi bi-calendar-plus"></i>
                <span>Google Calendar</span>
              </a>
              @if($agenda->link_url)
                <a href="{{ $agenda->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-2" style="height: 38px; white-space: nowrap;">
                  <i class="bi bi-box-arrow-up-right"></i>
                  <span>Buka Tautan Resmi</span>
                </a>
              @endif
            </div>
          </div>

          {{-- Navigasi Bawah --}}
          <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <a href="{{ route('homepage.agenda') }}" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-semibold d-inline-flex align-items-center gap-2" style="height: 38px; white-space: nowrap;">
              <i class="bi bi-arrow-left"></i>
              <span>Kembali ke Daftar Agenda</span>
            </a>
            <a href="{{ route('homepage') }}#berita" class="btn btn-light rounded-pill px-3 btn-sm text-muted d-inline-flex align-items-center gap-1" style="height: 38px; white-space: nowrap;">
              <i class="bi bi-house"></i>
              <span>Beranda</span>
            </a>
          </div>
        </div>
      </div>

      {{-- Sidebar Agenda Lainnya --}}
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
          <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
            <i class="bi bi-calendar4-week text-warning"></i>
            <span>Agenda Lainnya</span>
          </h5>

          @if(isset($recentAgendas) && $recentAgendas->count() > 0)
            <div class="d-flex flex-column gap-3">
              @foreach($recentAgendas as $rAgenda)
                <a href="{{ route('homepage.agenda.detail', $rAgenda->slug) }}" class="text-decoration-none p-2 rounded-3 hover-bg-light" style="transition: background 0.2s;">
                  <div class="d-inline-flex align-items-center gap-1 px-2 py-0.5 rounded-pill mb-1 fw-bold text-muted" style="background: #fef08a; color: #854d0e !important; font-size: 11px;">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $rAgenda->date_text }}</span>
                  </div>
                  <div class="small fw-semibold text-dark mb-1" style="line-height: 1.4;">
                    {{ $rAgenda->title }}
                  </div>
                  @if($rAgenda->location)
                    <div class="text-muted" style="font-size: 11.5px;">
                      <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $rAgenda->location }}
                    </div>
                  @endif
                </a>
              @endforeach
            </div>
          @else
            <div class="text-muted small">Tidak ada agenda lainnya.</div>
          @endif

          <div class="mt-4 pt-3 border-top text-center">
            <a href="{{ route('homepage.agenda') }}" class="btn btn-outline-dark btn-sm rounded-pill w-100 fw-semibold d-inline-flex align-items-center justify-content-center gap-2" style="height: 38px;">
              <i class="bi bi-calendar-event"></i>
              <span>Lihat Semua Agenda</span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection

