@extends('layouts.frontend.template')

@section('title', ($query !== '' ? 'Hasil Pencarian: ' . $query : 'Pencarian Website') . ' — Teknik Informatika (UIS)')
@section('meta_description', 'Pencarian global berita, pengumuman, agenda, dosen, dokumen, dan halaman informasi Program Studi Teknik Informatika (UIS).')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'pencarian',
    'defaultJudul' => 'Pencarian Website',
    'defaultSubjudul' => 'Temukan berita, pengumuman resmi, agenda kegiatan, profil dosen, dokumen akademik, serta informasi layanan Program Studi Teknik Informatika.',
    'defaultBreadcrumb' => 'Pencarian'
])

<section class="section-bg-sand py-5">
  <div class="container py-2">

    {{-- Search Bar --}}
    <div class="row justify-content-center mb-4" data-aos="fade-up">
      <div class="col-lg-8">
        <form action="{{ route('homepage.search') }}" method="GET" class="d-flex align-items-center gap-2 p-1 p-md-2 bg-white rounded-pill shadow-sm border">
          <div class="d-flex align-items-center flex-grow-1 ps-3">
            <i class="bi bi-search text-muted me-2" style="font-size: 16px;"></i>
            <input type="text"
                   name="q"
                   value="{{ $query }}"
                   placeholder="Cari berita, pengumuman, agenda, dosen, KRS, kurikulum..."
                   class="form-control border-0 shadow-none p-0 bg-transparent"
                   style="font-size: 15px;"
                   required>
          </div>
          @if($query !== '')
            <a href="{{ route('homepage.search') }}" class="btn btn-sm btn-light rounded-pill px-3 text-muted flex-shrink-0 d-inline-flex align-items-center gap-1" style="height: 42px; font-size: 13.5px; white-space: nowrap;">
              <i class="bi bi-x-circle"></i>
              <span>Reset</span>
            </a>
          @endif
          <button type="submit" class="btn btn-dark rounded-pill px-4 fw-semibold text-white flex-shrink-0 d-inline-flex align-items-center justify-content-center gap-2" style="height: 42px; font-size: 14px; white-space: nowrap;">
            <i class="bi bi-search"></i>
            <span>Cari</span>
          </button>
        </form>
      </div>
    </div>

    @if($query === '')
      {{-- State Awal (Belum Memasukkan Kata Kunci) --}}
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
            <i class="bi bi-search text-muted" style="font-size: 46px; opacity: 0.35;"></i>
            <h5 class="fw-bold mt-3 mb-2">Masukkan Kata Kunci Pencarian</h5>
            <p class="text-muted small mb-4">
              Anda dapat mencari seluruh konten website termasuk Berita, Pengumuman, Agenda, Dosen, E-Dokumen, FAQ, dan halaman informasi lainnya.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
              @foreach(['KRS', 'PMB', 'Kurikulum', 'Kalender Akademik', 'Dosen', 'Beasiswa'] as $sug)
                <a href="{{ route('homepage.search', ['q' => $sug]) }}" class="cat-pill-item">
                  <i class="bi bi-search"></i> {{ $sug }}
                </a>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @else
      {{-- Ringkasan & Filter Tab --}}
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
          <h5 class="fw-bold mb-1">
            Hasil pencarian untuk: <span class="text-dark px-2 py-1 rounded" style="background: #f9dc4b;">"{{ $query }}"</span>
          </h5>
          <p class="text-muted small mb-0">
            Ditemukan <strong>{{ $totalResults }}</strong> hasil yang relevan di seluruh website.
          </p>
        </div>
      </div>

      {{-- Pill Tabs --}}
      <div class="d-flex flex-wrap gap-2 mb-4">
        @php
          $tabs = [
            'semua' => ['label' => 'Semua', 'icon' => 'bi-grid-fill', 'count' => $totalResults],
            'pengumuman' => ['label' => 'Pengumuman', 'icon' => 'bi-megaphone-fill', 'count' => $counts['pengumuman']],
            'berita' => ['label' => 'Berita', 'icon' => 'bi-newspaper', 'count' => $counts['berita']],
            'agenda' => ['label' => 'Agenda', 'icon' => 'bi-calendar-event-fill', 'count' => $counts['agenda']],
            'dosen' => ['label' => 'Dosen', 'icon' => 'bi-person-badge-fill', 'count' => $counts['dosen']],
            'halaman' => ['label' => 'Halaman & Info', 'icon' => 'bi-file-earmark-text-fill', 'count' => $counts['halaman']],
          ];
        @endphp
        @foreach($tabs as $key => $info)
          <a href="{{ route('homepage.search', ['q' => $query, 'tab' => $key]) }}"
             class="cat-pill-item {{ $tab === $key ? 'active' : '' }}">
            <i class="bi {{ $info['icon'] }}"></i>
            <span>{{ $info['label'] }}</span>
            <span class="badge rounded-pill ms-1 {{ $tab === $key ? 'bg-warning text-dark' : 'bg-light text-dark border' }}" style="font-size: 11px;">
              {{ $info['count'] }}
            </span>
          </a>
        @endforeach
      </div>

      @if($totalResults === 0)
        <div class="bg-white rounded-4 p-5 text-center shadow-sm border">
          <i class="bi bi-inbox text-muted" style="font-size: 48px; opacity: 0.35;"></i>
          <h5 class="fw-bold mt-3 mb-2">Tidak Ada Hasil Ditemukan</h5>
          <p class="text-muted small mb-4">
            Maaf, tidak ditemukan Berita, Pengumuman, Agenda, Dosen, maupun halaman yang cocok dengan kata kunci <strong>"{{ $query }}"</strong>.
          </p>
          <a href="{{ route('homepage') }}" class="btn-outline-hero" style="font-size: 13.5px; padding: 10px 22px;">
            <i class="bi bi-house me-1"></i> Kembali ke Beranda
          </a>
        </div>
      @else
        <div class="d-flex flex-column gap-4">

          {{-- 1. PENGUMUMAN --}}
          @if(($tab === 'semua' || $tab === 'pengumuman') && $announcementResults->count() > 0)
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-megaphone-fill text-warning"></i> Pengumuman Resmi
                  <span class="badge bg-dark text-warning rounded-pill">{{ $announcementResults->count() }}</span>
                </h6>
                <a href="{{ route('homepage.pengumuman', ['q' => $query]) }}" class="small fw-semibold text-dark text-decoration-none">
                  Lihat semua pengumuman <i class="bi bi-arrow-right"></i>
                </a>
              </div>
              <div class="row g-3">
                @foreach($announcementResults as $ann)
                  <div class="col-md-6">
                    <a href="{{ route('homepage.pengumuman.detail', $ann->slug) }}" class="d-block bg-white rounded-4 p-4 shadow-sm border text-decoration-none h-100">
                      <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill" style="background: #f9dc4b; color: #000000; font-size: 11px;">Pengumuman</span>
                        @if($ann->date)
                          <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $ann->date->translatedFormat('d M Y') }}</small>
                        @endif
                      </div>
                      <h6 class="fw-bold text-dark mb-2">{{ $ann->title }}</h6>
                      <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(trim(strip_tags((string) $ann->content)), 140) }}</p>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- 2. BERITA --}}
          @if(($tab === 'semua' || $tab === 'berita') && $newsResults->count() > 0)
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-newspaper text-warning"></i> Berita & Artikel
                  <span class="badge bg-dark text-warning rounded-pill">{{ $newsResults->count() }}</span>
                </h6>
                <a href="{{ route('homepage.news', ['q' => $query]) }}" class="small fw-semibold text-dark text-decoration-none">
                  Lihat semua berita <i class="bi bi-arrow-right"></i>
                </a>
              </div>
              <div class="row g-3">
                @foreach($newsResults as $news)
                  <div class="col-md-6">
                    <a href="{{ route('homepage.news.detail', $news->slug ?? $news->id) }}" class="d-flex gap-3 bg-white rounded-4 p-3 shadow-sm border text-decoration-none h-100 align-items-start">
                      @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="rounded-3 flex-shrink-0" style="width: 90px; height: 75px; object-fit: cover;">
                      @else
                        <div class="rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center bg-light text-muted" style="width: 90px; height: 75px;">
                          <i class="bi bi-newspaper fs-4"></i>
                        </div>
                      @endif
                      <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                          <span class="badge bg-dark text-white rounded-pill" style="font-size: 10.5px;">{{ $news->category ?: 'Berita' }}</span>
                          <small class="text-muted">{{ $news->created_at?->translatedFormat('d M Y') }}</small>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px; line-height: 1.35;">{{ $news->title }}</h6>
                        <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(trim(strip_tags((string) ($news->description ?: $news->content))), 110) }}</p>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- 3. AGENDA --}}
          @if(($tab === 'semua' || $tab === 'agenda') && $agendaResults->count() > 0)
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-calendar-event-fill text-warning"></i> Agenda Kegiatan
                  <span class="badge bg-dark text-warning rounded-pill">{{ $agendaResults->count() }}</span>
                </h6>
                <a href="{{ route('homepage.agenda', ['q' => $query]) }}" class="small fw-semibold text-dark text-decoration-none">
                  Lihat semua agenda <i class="bi bi-arrow-right"></i>
                </a>
              </div>
              <div class="row g-3">
                @foreach($agendaResults as $ag)
                  <div class="col-md-6">
                    <a href="{{ route('homepage.agenda.detail', $ag->slug) }}" class="d-block bg-white rounded-4 p-4 shadow-sm border text-decoration-none h-100">
                      <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <span class="badge rounded-pill bg-secondary text-white" style="font-size: 11px;">Agenda</span>
                        @if($ag->date_text)
                          <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $ag->date_text }}</small>
                        @elseif($ag->start_date)
                          <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $ag->start_date->translatedFormat('d M Y') }}</small>
                        @endif
                        @if($ag->location)
                          <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $ag->location }}</small>
                        @endif
                      </div>
                      <h6 class="fw-bold text-dark mb-2">{{ $ag->title }}</h6>
                      <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit(trim(strip_tags((string) $ag->description)), 135) }}</p>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- 4. DOSEN --}}
          @if(($tab === 'semua' || $tab === 'dosen') && $dosenResults->count() > 0)
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-person-badge-fill text-warning"></i> Dosen & Pengajar
                  <span class="badge bg-dark text-warning rounded-pill">{{ $dosenResults->count() }}</span>
                </h6>
                <a href="{{ route('homepage.dosen', ['q' => $query]) }}" class="small fw-semibold text-dark text-decoration-none">
                  Lihat semua dosen <i class="bi bi-arrow-right"></i>
                </a>
              </div>
              <div class="row g-3">
                @foreach($dosenResults as $dsn)
                  <div class="col-md-6 col-lg-4">
                    <div class="bg-white rounded-4 p-3 shadow-sm border h-100 d-flex align-items-center gap-3">
                      <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: #000000; color: #f9dc4b;">
                        <i class="bi bi-person-fill fs-4"></i>
                      </div>
                      <div class="min-w-0 flex-grow-1">
                        <div class="fw-bold text-dark" style="font-size: 14.5px;">{{ $dsn->nama_dosen }}</div>
                        @if($dsn->jabatan_fungsional)
                          <div class="small text-muted">{{ $dsn->jabatan_fungsional }}</div>
                        @endif
                        @if($dsn->nidn)
                          <div class="small text-muted">NIDN: {{ $dsn->nidn }}</div>
                        @endif
                        <a href="{{ $dsn->link ?: route('homepage.dosen', ['q' => $dsn->nama_dosen]) }}"
                           @if($dsn->link) target="_blank" rel="noopener noreferrer" @endif
                           class="small fw-semibold text-dark text-decoration-underline">
                          Lihat Profil <i class="bi bi-arrow-up-right"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          {{-- 5. HALAMAN STATIS & INFORMASI LAINNYA --}}
          @if(($tab === 'semua' || $tab === 'halaman') && $pageResults->count() > 0)
            <div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-file-earmark-text-fill text-warning"></i> Halaman, Akademik & Informasi Lainnya
                  <span class="badge bg-dark text-warning rounded-pill">{{ $pageResults->count() }}</span>
                </h6>
              </div>
              <div class="row g-3">
                @foreach($pageResults as $pg)
                  <div class="col-md-6">
                    <a href="{{ $pg->url }}" class="d-flex align-items-start gap-3 bg-white rounded-4 p-3 shadow-sm border text-decoration-none h-100">
                      <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #f9dc4b; color: #000000;">
                        <i class="bi {{ $pg->icon ?? 'bi-file-earmark-text' }} fs-5"></i>
                      </div>
                      <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-2 mb-1">
                          <span class="badge bg-light text-dark border rounded-pill" style="font-size: 10.5px;">{{ $pg->type }}</span>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">{{ $pg->title }}</h6>
                        @if(!empty($pg->excerpt))
                          <p class="text-muted small mb-0">{{ $pg->excerpt }}</p>
                        @endif
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

        </div>
      @endif
    @endif

  </div>
</section>

@endsection
