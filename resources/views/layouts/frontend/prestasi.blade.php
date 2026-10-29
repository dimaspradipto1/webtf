@extends('layouts.frontend.template')

@section('title', 'Prestasi Mahasiswa — Teknik Informatika')
@section('meta_description', 'Daftar capaian prestasi, kejuaraan, dan penghargaan mahasiswa Teknik Informatika (UIS) UIS di tingkat regional, nasional, dan internasional.')

@section('content')
<!-- Header Banner -->
<div class="prestasi-hero text-white">
  <div class="container text-center">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: #f9dc4b; color: #000000; border: 1px solid #f9dc4b; font-weight: 700; font-size: 13px; letter-spacing: 0.5px;">
      <i class="bi bi-trophy-fill me-1"></i> Hall of Fame & Prestasi
    </div>
    <h1 class="fw-bold mb-3 text-white" style="font-size: 38px; color: #ffffff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.35);">Prestasi Mahasiswa Teknik Informatika</h1>
    <p class="mx-auto text-white mb-2" style="max-width: 680px; line-height: 1.7; color: rgba(255, 255, 255, 0.92) !important; font-size: 15.5px;">
      Koleksi prestasi gemilang, medali kejuaraan, dan publikasi ilmiah sivitas akademika Teknik Informatika di tingkat regional, nasional, dan internasional.
    </p>
    <div class="breadcrumb-custom justify-content-center mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">Prestasi Mahasiswa</span>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="section-bg-sand py-5">
  <div class="container py-3">

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-4 shadow-sm border mb-5">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2">
          <a href="{{ route('homepage.prestasi') }}" class="cat-pill-item {{ empty($selectedTingkat) && empty($search) ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Semua Tingkat
          </a>
          @foreach($tingkatList as $t)
            <a href="{{ route('homepage.prestasi', ['tingkat' => $t]) }}" class="cat-pill-item {{ ($selectedTingkat ?? '') === $t ? 'active' : '' }}">
              <i class="bi bi-award"></i> {{ $t }}
            </a>
          @endforeach
        </div>

        <form action="{{ route('homepage.prestasi') }}" method="GET" class="d-flex align-items-center gap-2">
          @if(!empty($selectedTingkat))
            <input type="hidden" name="tingkat" value="{{ $selectedTingkat }}">
          @endif
          <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control form-control-sm rounded-pill px-3" placeholder="Cari nama / kejuaraan..." style="max-width: 240px;">
          <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3" style="background: #000000; border-color: #000000;">
            <i class="bi bi-search"></i>
          </button>
        </form>
      </div>

      @if(!empty($selectedTingkat) || !empty($search))
        <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top small text-muted">
          <div>
            @if(!empty($selectedTingkat))
              Menampilkan tingkat: <strong class="text-dark">{{ $selectedTingkat }}</strong>
            @endif
            @if(!empty($search))
              {{ !empty($selectedTingkat) ? '• ' : '' }}Pencarian: <strong class="text-dark">"{{ $search }}"</strong>
            @endif
          </div>
          <a href="{{ route('homepage.prestasi') }}" class="text-danger fw-bold text-decoration-none small">
            <i class="bi bi-x-circle me-1"></i> Reset Filter
          </a>
        </div>
      @endif
    </div>

    <!-- Grid Kartu Prestasi -->
    @if(isset($prestasiList) && $prestasiList->count() > 0)
      <div class="row g-4">
        @foreach($prestasiList as $prestasi)
          @php
            $tingkatBadge = match($prestasi->tingkat) {
                'Internasional' => 'bg-danger text-white',
                'Nasional'      => 'bg-success text-white',
                'Provinsi / Wilayah' => 'bg-warning text-dark',
                default         => 'bg-secondary text-white',
            };
          @endphp
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="prestasi-card-portal">
              <div class="prestasi-thumb-wrap">
                @if(!empty($prestasi->foto))
                  <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->judul_prestasi }}" class="prestasi-thumb">
                @else
                  <div class="d-flex align-items-center justify-content-center h-100 text-white flex-column gap-2" style="background: #000000;">
                    <i class="bi bi-trophy-fill" style="font-size: 44px; color: #f9dc4b;"></i>
                    <span class="small fw-semibold text-white-50">Teknik Informatika Achievement</span>
                  </div>
                @endif
                <span class="prestasi-tingkat-badge badge {{ $tingkatBadge }}">
                  <i class="bi bi-globe me-1"></i>{{ $prestasi->tingkat }}
                </span>
                @if(!empty($prestasi->peringkat))
                  <span class="prestasi-rank-badge">
                    <i class="bi bi-award-fill me-1"></i>{{ $prestasi->peringkat }}
                  </span>
                @endif
              </div>

              <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
                <div>
                  <h4 class="fw-bold mb-2 text-dark" style="font-size: 16.5px; line-height: 1.45;">
                    <a href="{{ route('homepage.prestasi.detail', $prestasi->slug ?? $prestasi->id) }}" class="text-dark text-decoration-none">
                      {{ $prestasi->judul_prestasi }}
                    </a>
                  </h4>

                  <div class="d-flex align-items-center gap-2 mb-3 mt-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 32px; height: 32px; background: #000000; font-size: 13px;">
                      <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                      <div class="fw-semibold text-dark small" style="font-size: 13px;">{{ $prestasi->nama_mahasiswa }}</div>
                      @if($prestasi->prodi)
                        <div class="text-muted" style="font-size: 11px;">{{ $prestasi->prodi }}</div>
                      @endif
                    </div>
                  </div>

                  @if(!empty($prestasi->penyelenggara) || !empty($prestasi->tahun))
                    <div class="d-flex align-items-center justify-content-between text-muted small py-2 px-3 rounded-3 mb-3" style="background: #f8f9fa; font-size: 11.5px;">
                      <span class="text-truncate me-2"><i class="bi bi-building me-1 text-primary"></i>{{ $prestasi->penyelenggara ?? 'Penyelenggara Nasional' }}</span>
                      <span class="fw-bold text-dark flex-shrink-0">{{ $prestasi->tahun ?? '' }}</span>
                    </div>
                  @endif

                  @if(!empty($prestasi->deskripsi))
                    <div class="text-muted small mb-3" style="font-size: 12.5px; line-height: 1.6;">
                      {!! Str::limit(strip_tags($prestasi->deskripsi), 110) !!}
                    </div>
                  @endif
                </div>

                <div class="pt-3 border-top">
                  <a href="{{ route('homepage.prestasi.detail', $prestasi->slug ?? $prestasi->id) }}" class="fw-bold text-decoration-none d-flex align-items-center justify-content-between" style="color: var(--uis-purple); font-size: 13.5px;">
                    <span>Lihat Selengkapnya</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if(method_exists($prestasiList, 'hasPages') && $prestasiList->hasPages())
        <div class="mt-5 d-flex justify-content-center">
          {{ $prestasiList->links('pagination::bootstrap-5') }}
        </div>
      @endif
    @else
      <div class="p-5 text-center bg-white rounded-4 shadow-sm">
        <i class="bi bi-trophy fs-1 text-muted mb-3 d-block"></i>
        <h4 class="fw-bold text-dark">Belum Ada Data Prestasi</h4>
        <p class="text-muted small">Data prestasi mahasiswa Teknik Informatika akan segera diperbarui di sini.</p>
        <a href="{{ route('homepage.prestasi') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4 mt-2">
          Lihat Semua Prestasi
        </a>
      </div>
    @endif

  </div>
</section>
@endsection
