@extends('layouts.frontend.template')

@section('title', $prestasi->judul_prestasi . ' — Teknik Informatika')
@section('meta_description', Str::limit(strip_tags($prestasi->deskripsi ?? $prestasi->judul_prestasi), 160))

@section('content')
<!-- Header Hero -->
<div class="detail-hero text-white">
  <div class="container">
    <div class="breadcrumb-custom mb-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.prestasi') }}">Prestasi Mahasiswa</a>
      <span>/</span>
      <span class="active">{{ Str::limit($prestasi->judul_prestasi, 35) }}</span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
      @php
        $tingkatBadge = match($prestasi->tingkat) {
            'Internasional' => 'bg-danger text-white',
            'Nasional'      => 'bg-success text-white',
            'Provinsi / Wilayah' => 'bg-warning text-dark',
            default         => 'bg-secondary text-white',
        };
      @endphp
      <span class="badge {{ $tingkatBadge }} px-3 py-2 rounded-pill font-weight-bold" style="font-size: 12px;">
        <i class="bi bi-globe me-1"></i>Tingkat {{ $prestasi->tingkat }}
      </span>
      @if(!empty($prestasi->peringkat))
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
          <i class="bi bi-trophy-fill me-1"></i>{{ $prestasi->peringkat }}
        </span>
      @endif
      @if(!empty($prestasi->tahun))
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12px;">
          <i class="bi bi-calendar3 me-1"></i>Tahun {{ $prestasi->tahun }}
        </span>
      @endif
    </div>
    <h1 class="fw-bold mb-0 text-white" style="font-size: 32px; line-height: 1.4;">
      {{ $prestasi->judul_prestasi }}
    </h1>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">

      <!-- Kolom Kiri: Foto Utama & Deskripsi Rinci -->
      <div class="col-lg-8" data-aos="fade-up">
        
        <!-- Foto / Dokumentasi Prestasi -->
        @if(!empty($prestasi->foto))
          <div class="mb-4 text-center">
            <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->judul_prestasi }}" class="prestasi-img-main img-fluid">
          </div>
        @else
          <div class="p-5 rounded-4 text-center text-white mb-4" style="background: #000000;">
            <i class="bi bi-trophy-fill" style="font-size: 64px; color: #f9dc4b;"></i>
            <h4 class="fw-bold mt-2 mb-0">Prestasi Sivitas Teknik Informatika</h4>
          </div>
        @endif

        <!-- Card Deskripsi Lengkap -->
        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
          <h3 class="fw-bold mb-3 text-dark" style="font-size: 22px;">
            <i class="bi bi-card-text text-primary me-2"></i>Ulasan & Rincian Prestasi
          </h3>
          <div class="divider-line mb-4"></div>

          @if(!empty($prestasi->deskripsi))
            <div class="article-content" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
              {!! $prestasi->deskripsi !!}
            </div>
          @else
            <p class="text-muted">
              Selamat dan sukses atas keberhasilan mahasiswa Teknik Informatika dalam meraih <strong>{{ $prestasi->peringkat ?? 'Prestasi Membanggakan' }}</strong> pada ajang <strong>{{ $prestasi->judul_prestasi }}</strong>.
            </p>
          @endif

          <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
            <a href="{{ route('homepage.prestasi') }}" class="btn btn-outline-secondary rounded-pill px-4" style="font-size: 13.5px;">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Prestasi
            </a>

            @php
              $shareUrl  = urlencode(url()->current());
              $shareText = urlencode("Prestasi Mahasiswa Teknik Informatika: " . $prestasi->judul_prestasi);
            @endphp
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small fw-semibold">Bagikan:</span>
              <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-whatsapp"></i>
              </a>
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="btn btn-sm btn-primary rounded-circle" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-facebook"></i>
              </a>
            </div>
          </div>
        </div>

      </div>

      <!-- Kolom Kanan: Detail Informasi Mahasiswa & Prestasi Lainnya -->
      <div class="col-lg-4" data-aos="fade-left">
        
        <!-- Info Box Peraih Prestasi -->
        <div class="info-badge-card mb-4">
          <h5 class="fw-bold mb-3 text-dark">
            <i class="bi bi-person-badge-fill text-primary me-2"></i>Biodata Prestasi
          </h5>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-person me-1"></i> Nama Mahasiswa</span>
            <span class="info-meta-val text-primary">{{ $prestasi->nama_mahasiswa }}</span>
          </div>

          @if(!empty($prestasi->nim))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-card-heading me-1"></i> NIM</span>
              <span class="info-meta-val">{{ $prestasi->nim }}</span>
            </div>
          @endif

          @if(!empty($prestasi->prodi))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-mortarboard me-1"></i> Program Studi</span>
              <span class="info-meta-val">{{ $prestasi->prodi }}</span>
            </div>
          @endif

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-award me-1"></i> Capaian Juara</span>
            <span class="info-meta-val text-warning fw-bold">{{ $prestasi->peringkat ?? 'Peserta / Finalis' }}</span>
          </div>

          <div class="info-meta-row">
            <span class="info-meta-label"><i class="bi bi-globe me-1"></i> Tingkatan</span>
            <span class="info-meta-val">{{ $prestasi->tingkat }}</span>
          </div>

          @if(!empty($prestasi->penyelenggara))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-building me-1"></i> Penyelenggara</span>
              <span class="info-meta-val" style="font-size: 13px;">{{ $prestasi->penyelenggara }}</span>
            </div>
          @endif

          @if(!empty($prestasi->tahun))
            <div class="info-meta-row">
              <span class="info-meta-label"><i class="bi bi-calendar-event me-1"></i> Tahun</span>
              <span class="info-meta-val">{{ $prestasi->tahun }}</span>
            </div>
          @endif
        </div>

        <!-- Prestasi Lainnya Box -->
        @if(isset($otherPrestasis) && $otherPrestasis->count() > 0)
          <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h5 class="fw-bold mb-3 text-dark">
              <i class="bi bi-trophy text-warning me-2"></i>Prestasi Lainnya
            </h5>
            <div class="d-flex flex-column">
              @foreach($otherPrestasis as $other)
                <a href="{{ route('homepage.prestasi.detail', $other->slug ?? $other->id) }}" class="other-prestasi-item">
                  @if(!empty($other->foto))
                    <img src="{{ asset('storage/' . $other->foto) }}" alt="{{ $other->judul_prestasi }}" class="other-prestasi-img">
                  @else
                    <div class="other-prestasi-img d-flex align-items-center justify-content-center text-white" style="background: #000000;">
                      <i class="bi bi-trophy-fill text-warning"></i>
                    </div>
                  @endif
                  <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 13.5px; line-height: 1.4;">
                      {{ Str::limit($other->judul_prestasi, 55) }}
                    </h6>
                    <div class="text-muted" style="font-size: 11.5px;">
                      <i class="bi bi-person me-1"></i>{{ $other->nama_mahasiswa }}
                    </div>
                  </div>
                </a>
              @endforeach
            </div>

            <div class="mt-3 text-center pt-2 border-top">
              <a href="{{ route('homepage.prestasi') }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill" style="color: #000000; border: none !important;">
                Lihat Semua Prestasi
              </a>
            </div>
          </div>
        @endif

      </div>

    </div>
  </div>
</section>
@endsection
