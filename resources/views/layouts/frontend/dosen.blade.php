@extends('layouts.frontend.template')

@section('title', ($pageTitle ?? 'Dosen Pengajar') . ' — Teknik Informatika')
@section('meta_description', 'Direktori staf pengajar dan dosen tetap program studi Teknik Informatika (UIS) Teknik Informatika.')

@section('content')
<!-- Header Hero -->
<div class="dosen-hero text-white">
  <div class="container text-center">
    <div class="badge px-3 py-2 rounded-pill mb-2" style="background: #f9dc4b; color: #000000; border: 1px solid #f9dc4b; font-weight: 700; font-size: 13px;">
      <i class="bi bi-person-workspace me-1"></i> Tenaga Pendidik & Dosen Teknik Informatika
    </div>
    <h1 class="fw-bold mb-2 text-white" style="font-size: 34px; color: #ffffff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.35);">Daftar Dosen Pengajar</h1>
    <p class="mx-auto mb-0 text-white" style="max-width: 650px; font-size: 15px; color: rgba(255, 255, 255, 0.92) !important; line-height: 1.65;">
      Tenaga pendidik berkualifikasi magister, doktor, dan profesor berdedikasi tinggi dalam membimbing mahasiswa di bidang teknik, ekonomi bisnis, kesehatan, dan pascasarjana.
    </p>
    <div class="breadcrumb-custom justify-content-center mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <span class="active">Daftar Dosen Pengajar</span>
    </div>
  </div>
</div>

<section class="section-bg-sand py-5">
  <div class="container py-3">

    <!-- Prodi Selector Tabs -->
    @if(isset($prodis) && $prodis->count() > 0)
      <div class="prodi-tab-nav" data-aos="fade-up">
        @foreach($prodis as $p)
          <a href="{{ route('homepage.dosen', ['prodi' => $p->id]) }}" class="prodi-tab-btn {{ ($currentProdi->id ?? 0) === $p->id ? 'active' : '' }}">
            <i class="bi bi-person-badge me-1"></i> Dosen {{ $p->judul }}
          </a>
        @endforeach
      </div>
    @endif

    <!-- Header Banner Kuning / Gold Sesuai Permintaan -->
    <div class="mb-4" data-aos="fade-up">
      <div class="prodi-header-pill">
        Dosen {{ $currentProdi->judul ?? 'Program Studi Teknik Informatika' }}
      </div>
    </div>

    <!-- Summary, Filter & Search Box -->
    <div class="bg-white p-3 p-md-4 rounded-4 shadow-sm border mb-4" data-aos="fade-up">
      <div class="row g-3 align-items-center justify-content-between">
        {{-- Info Total --}}
        <div class="col-lg-5 col-md-6">
          <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; background: #000000;">
              <i class="bi bi-people-fill fs-5"></i>
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-0">{{ $currentProdi->judul ?? 'Program Studi' }}</h5>
              <small class="text-muted">Total Tenaga Pengajar: <strong>{{ $totalDosen }} Dosen</strong></small>
            </div>
          </div>
        </div>

        {{-- Form Pencarian Dosen --}}
        <div class="col-lg-7 col-md-6">
          <form action="{{ route('homepage.dosen') }}" method="GET" class="d-flex gap-2">
            @if(isset($currentProdi))
              <input type="hidden" name="prodi" value="{{ $currentProdi->id }}">
            @endif
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-search"></i>
              </span>
              <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Cari nama dosen, NIDN, NUPTK, jabatan..." value="{{ $search ?? '' }}">
              <button class="btn text-white px-3 fw-semibold" type="submit" style="background: #000000;">
                Cari
              </button>
            </div>
            @if(!empty($search))
              <a href="{{ route('homepage.dosen', ['prodi' => $currentProdi->id ?? '']) }}" class="btn btn-outline-secondary d-flex align-items-center gap-1" title="Reset Pencarian">
                <i class="bi bi-x-circle"></i> <span class="d-none d-sm-inline">Reset</span>
              </a>
            @endif
          </form>
        </div>
      </div>
      @if(!empty($search))
        <div class="mt-2 pt-2 border-top small text-muted">
          Menampilkan hasil pencarian untuk: <strong class="text-dark">"{{ $search }}"</strong> (Ditemukan {{ $totalDosen }} data)
        </div>
      @endif
    </div>

    <!-- Tabel Data Dosen -->
    <div class="dosen-table-card" data-aos="fade-up">
      <div class="table-responsive">
        <table class="table table-dosen">
          <thead>
            <tr>
              <th style="width: 6%;">No</th>
              <th>Nama Dosen & Gelar</th>
              <th style="width: 20%;">Jabatan Fungsional</th>
              <th style="width: 18%;">NIDN</th>
              <th style="width: 18%;">NUPTK</th>
              <th style="width: 14%;">Profil</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($dosens) && $dosens->count() > 0)
              @foreach($dosens as $idx => $dosen)
                <tr>
                  <td class="text-center fw-semibold text-muted">{{ ($dosens->currentPage() - 1) * $dosens->perPage() + $idx + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      @if(!empty($dosen->foto))
                        <img src="{{ asset('storage/' . $dosen->foto) }}" alt="{{ $dosen->nama_dosen }}" class="rounded-circle shadow-sm" style="width: 42px; height: 42px; object-fit: cover; border: 2px solid var(--uis-purple-light);">
                      @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 42px; height: 42px; background: #000000; font-size: 14px;">
                          {{ strtoupper(substr($dosen->nama_dosen, 0, 1)) }}
                        </div>
                      @endif
                      <div>
                        <span class="fw-bold text-dark d-block">{{ $dosen->nama_dosen }}</span>
                        <small class="text-muted">{{ $dosen->prodi?->judul ?? $dosen->prodi_nama }}</small>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    @if(!empty($dosen->jabatan_fungsional))
                      <span class="badge" style="background:#000000; color:#fff; font-size:12px; font-weight:600; padding:6px 12px; border-radius:20px;">
                        {{ $dosen->jabatan_fungsional }}
                      </span>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                  <td class="text-center font-monospace fw-bold text-dark">
                    {{ $dosen->nidn ?: '-' }}
                  </td>
                  <td class="text-center font-monospace fw-semibold text-secondary">
                    {{ $dosen->nuptk ?: '-' }}
                  </td>
                  <td class="text-center">
                    @if(!empty($dosen->link))
                      <a href="{{ $dosen->link }}" target="_blank" class="btn-lihat-dosen">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat
                      </a>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" class="text-center py-5">
                  <i class="bi bi-person-x fs-1 text-muted d-block mb-2"></i>
                  <h6 class="fw-bold text-dark">Data Dosen Belum Tersedia</h6>
                  <p class="text-muted small mb-0">
                    @if(!empty($search))
                      Tidak ditemukan dosen dengan kata kunci "<strong>{{ $search }}</strong>". Silakan coba kata kunci lain.
                    @else
                      Daftar tenaga pengajar untuk program studi ini akan segera diperbarui.
                    @endif
                  </p>
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination (10 data per halaman) -->
    @if(isset($dosens) && $dosens->hasPages())
      <div class="mt-4 d-flex justify-content-center" data-aos="fade-up">
        {{ $dosens->links('pagination::bootstrap-5') }}
      </div>
    @endif

    <!-- Info Bantuan Box -->
    <div class="mt-5 p-4 rounded-4 text-white d-flex flex-wrap align-items-center justify-content-between gap-3 shadow-sm" style="background: #000000; border: 1px solid rgba(255,255,255,0.2);" data-aos="fade-up">
      <div>
        <h5 class="fw-bold text-white mb-1"><i class="bi bi-mortarboard-fill me-2" style="color: #f9dc4b;"></i>Tertarik Menjadi Mahasiswa Bimbingan Dosen Teknik Informatika?</h5>
        <p class="text-white-50 small mb-0">Daftarkan diri Anda pada program sarjana & magister melalui jalur PMB Online Teknik Informatika Batam.</p>
      </div>
      <a href="{{ route('homepage.kontak') }}" class="btn btn-warning rounded-pill px-4 fw-bold" style="color: #000000;">
        <i class="bi bi-arrow-right-circle me-1"></i> Informasi PMB
      </a>
    </div>

  </div>
</section>
@endsection
