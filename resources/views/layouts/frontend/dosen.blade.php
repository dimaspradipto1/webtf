@extends('layouts.frontend.template')

@section('title', ($pageTitle ?? 'Dosen Pengajar') . ' — Teknik Informatika')
@section('meta_description', 'Direktori staf pengajar dan dosen tetap program studi Teknik Informatika (UIS) Teknik Informatika.')

@section('content')
@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'dosen',
    'defaultJudul' => 'Daftar Dosen Pengajar',
    'defaultSubjudul' => 'Tenaga pendidik berkualifikasi magister, doktor, dan profesor berdedikasi tinggi dalam membimbing mahasiswa Program Studi Teknik Informatika.',
    'defaultBreadcrumb' => 'Daftar Dosen Pengajar'
])

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
              <th style="width: 5%;">No</th>
              <th>Nama Dosen & Gelar</th>
              <th style="width: 15%;">Jabatan Fungsional</th>
              <th style="width: 13%;">NIDN</th>
              <th style="width: 18%;">Bidang Keahlian</th>
              <th style="width: 16%;">SINTA / Scholar</th>
              <th style="width: 12%;">Profil</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($dosens) && $dosens->count() > 0)
              @foreach($dosens as $idx => $dosen)
                <tr>
                  <td class="text-center fw-semibold text-muted">{{ ($dosens->currentPage() - 1) * $dosens->perPage() + $idx + 1 }}</td>
                  <td>
                    @if(!empty($dosen->foto))
                      <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $dosen->foto) }}" alt="{{ $dosen->nama_dosen }}" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                          <span class="fw-bold text-dark d-block">{{ $dosen->nama_dosen }}</span>
                          <small class="text-muted">{{ $dosen->prodi?->judul ?? $dosen->prodi_nama }}</small>
                        </div>
                      </div>
                    @else
                      <div>
                        <span class="fw-bold text-dark d-block">{{ $dosen->nama_dosen }}</span>
                        <small class="text-muted">{{ $dosen->prodi?->judul ?? $dosen->prodi_nama }}</small>
                      </div>
                    @endif
                  </td>
                  <td class="text-center">
                    @if(!empty($dosen->jabatan_fungsional))
                      <span class="badge" style="background:#000000; color:#fff; font-size:11.5px; font-weight:600; padding:6px 11px; border-radius:20px;">
                        {{ $dosen->jabatan_fungsional }}
                      </span>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                  <td class="text-center font-monospace fw-bold text-dark" style="font-size: 12.5px;">
                    {{ $dosen->nidn ?: '-' }}
                    @if(!empty($dosen->nuptk))
                      <div class="text-muted fw-normal" style="font-size: 10.5px;">NUPTK: {{ $dosen->nuptk }}</div>
                    @endif
                  </td>
                  <td class="text-center">
                    @if(!empty($dosen->bidang_keahlian))
                      <span class="badge bg-light text-dark border fw-semibold" style="font-size: 11.5px; white-space: normal; line-height: 1.35; padding: 5px 10px;">
                        {{ $dosen->bidang_keahlian }}
                      </span>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center gap-1 flex-wrap">
                      @if(!empty($dosen->link_sinta))
                        <a href="{{ $dosen->link_sinta }}" target="_blank" rel="noopener noreferrer" class="badge text-decoration-none fw-bold" style="background: #1d4ed8; color: #ffffff; padding: 5px 9px; border-radius: 6px; font-size: 11px;" title="Profil SINTA">
                          SINTA
                        </a>
                      @endif
                      @if(!empty($dosen->link_scholar))
                        <a href="{{ $dosen->link_scholar }}" target="_blank" rel="noopener noreferrer" class="badge text-decoration-none fw-bold" style="background: #4285f4; color: #ffffff; padding: 5px 9px; border-radius: 6px; font-size: 11px;" title="Profil Google Scholar">
                          Scholar
                        </a>
                      @endif
                      @if(empty($dosen->link_sinta) && empty($dosen->link_scholar))
                        <span class="text-muted small">-</span>
                      @endif
                    </div>
                  </td>
                  <td class="text-center">
                    @php
                      $rawLink = trim($dosen->link ?? '');
                      $isBarePddikti = false;
                      if ($rawLink !== '') {
                          $parsedLink = parse_url($rawLink);
                          $linkHost = strtolower($parsedLink['host'] ?? '');
                          $linkPath = trim($parsedLink['path'] ?? '', '/');
                          if (str_contains($linkHost, 'pddikti.') && $linkPath === '' && empty($parsedLink['query'])) {
                              $isBarePddikti = true;
                          }
                      }
                      $searchKeyword = trim($dosen->nidn ?: $dosen->nama_dosen);
                      $profileUrl = (!$isBarePddikti && $rawLink !== '')
                          ? $rawLink
                          : ($searchKeyword !== '' ? 'https://pddikti.kemdiktisaintek.go.id/search/' . rawurlencode($searchKeyword) : '');
                    @endphp
                    @if(!empty($profileUrl))
                      <a href="{{ $profileUrl }}" target="_blank" rel="noopener noreferrer" class="btn-lihat-dosen">
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
                <td colspan="7" class="text-center py-5">
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

    <!-- Pagination (10 data per halaman — Aktif Otomatis jika Data Melebihi 10) -->
    @if(isset($dosens) && $dosens->hasPages())
      <div class="mt-4 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 p-3 bg-white rounded-4 border shadow-sm" data-aos="fade-up">
        <div class="small text-muted">
          Menampilkan <strong>{{ $dosens->firstItem() }}</strong> – <strong>{{ $dosens->lastItem() }}</strong> dari <strong>{{ $dosens->total() }}</strong> dosen (10 data per halaman)
        </div>
        <div class="pagination-wrapper mb-0">
          {{ $dosens->links('pagination::bootstrap-5') }}
        </div>
      </div>
    @elseif(isset($dosens) && $dosens->total() > 0)
      <div class="mt-3 text-center small text-muted">
        Menampilkan seluruh <strong>{{ $dosens->total() }}</strong> data dosen (Pagination otomatis aktif jika data melebihi 10 data).
      </div>
    @endif

    <!-- Statistik Jabatan Fungsional Dosen -->
    <div class="mt-5 pt-3 pb-2" data-aos="fade-up">
      <h3 class="text-center fw-bold text-dark mb-4" style="font-size: 28px; letter-spacing: -0.5px; font-family: 'Plus Jakarta Sans', sans-serif;">
        Jabatan Fungsional
      </h3>
      <div class="row text-center g-4 justify-content-center">
        <div class="col-6 col-md-3">
          <div class="jabatan-count-number">{{ $countTenagaPengajar ?? 0 }}</div>
          <div class="jabatan-count-label">Tenaga Pengajar</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="jabatan-count-number">{{ $countAsistenAhli ?? 0 }}</div>
          <div class="jabatan-count-label">Asisten Ahli</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="jabatan-count-number">{{ $countLektor ?? 0 }}</div>
          <div class="jabatan-count-label">Lektor</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="jabatan-count-number">{{ $countLektorKepala ?? 0 }}</div>
          <div class="jabatan-count-label">Lektor Kepala</div>
        </div>
      </div>
    </div>

  </div>
</section>

@push('styles')
<style>
  .jabatan-count-number {
    font-size: 46px;
    font-weight: 800;
    color: #0b1320;
    line-height: 1.1;
    margin-bottom: 8px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .jabatan-count-label {
    font-size: 15.5px;
    font-weight: 600;
    color: #1e293b;
    letter-spacing: 0.1px;
  }
</style>
@endpush
@endsection
