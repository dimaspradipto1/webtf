<!-- ═══════════════════════════════════════════════
     11. BERITA, PENGUMUMAN & AGENDA (LAYOUT BARU)
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="berita">
  <div class="container py-3">
    <div class="row g-4 g-lg-5">
      
      {{-- KOLOM KIRI (BERITA): 2-KOLOM GRID --}}
      <div class="col-lg-8" data-aos="fade-right">
        {{-- Header Berita + Search Bar --}}
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-newspaper fs-2" style="color: var(--uis-purple, #000000);"></i>
            <h2 class="section-heading-uis mb-0">Berita</h2>
          </div>
          <form action="{{ route('homepage') }}#berita" method="GET" class="news-search-pill" id="homepageNewsSearchForm">
            <input type="text"
                   name="q"
                   id="homepageNewsSearchInput"
                   value="{{ $search ?? request('q', '') }}"
                   placeholder="Cari Berita Lainnya.."
                   autocomplete="off">
            <button type="button"
                    id="homepageNewsSearchClear"
                    class="news-search-clear {{ empty($search) && !request('q') ? 'd-none' : '' }}"
                    aria-label="Hapus Pencarian"
                    title="Hapus Pencarian">
              <i class="bi bi-x-circle-fill"></i>
            </button>
            <button type="submit" id="homepageNewsSearchBtn" aria-label="Cari Berita">
              <i class="bi bi-search" id="homepageNewsSearchIcon"></i>
              <span class="spinner-border spinner-border-sm d-none" id="homepageNewsSearchSpinner" role="status" aria-hidden="true" style="width: 14px; height: 14px; border-width: 2px;"></span>
            </button>
          </form>
        </div>

        {{-- Container Grid Berita (Mendukung Live Search AJAX & Server-side Filter) --}}
        <div id="homepageNewsGridContainer" class="news-grid-container position-relative">
          @include('layouts.frontend.partials.homepage-news-grid', ['latestNews' => $latestNews, 'search' => $search ?? request('q', '')])
        </div>

        {{-- Tombol Lihat Berita Lainnya --}}
        <div class="text-center mt-3 pt-2">
          <a href="{{ route('homepage.news') }}{{ !empty($search) ? '?q=' . urlencode($search) : '' }}" class="btn-uis-pill" id="btnSeeAllNews">
            Lihat Berita Lainnya
          </a>
        </div>
      </div>

      {{-- KOLOM KANAN (PENGUMUMAN & AGENDA) --}}
      <div class="col-lg-4" data-aos="fade-left">
        
        {{-- SECTION PENGUMUMAN --}}
        <div class="mb-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-megaphone-fill fs-3" style="color: var(--uis-purple, #000000);"></i>
              <h3 class="section-heading-uis mb-0" style="font-size: 24px;">Pengumuman</h3>
            </div>
            <a href="{{ route('homepage.pengumuman') }}" class="small fw-semibold text-decoration-none" style="color: #64748b;">
              Semua <i class="bi bi-arrow-right"></i>
            </a>
          </div>

          <div class="announcement-list">
            @if(isset($announcements) && $announcements->count() > 0)
              @foreach($announcements as $ann)
                @php
                  $annUrl = $ann->link_url ?: ($ann->file_path ? asset('storage/'.$ann->file_path) : route('homepage.pengumuman.detail', $ann->slug));
                  $isExternal = !empty($ann->link_url) || !empty($ann->file_path);
                @endphp
                <a href="{{ $annUrl }}" class="announcement-card-box text-decoration-none" {{ $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                  <div class="announcement-card-title">{{ $ann->title }}</div>
                  <div class="announcement-card-date">{{ $ann->date ? \Carbon\Carbon::parse($ann->date)->translatedFormat('d F Y') : ($ann->created_at ? $ann->created_at->translatedFormat('d F Y') : '-') }}</div>
                </a>
              @endforeach
            @else
              {{-- Default Item Pengumuman Fakultas --}}
              <div class="announcement-card-box">
                <div class="announcement-card-title">Pengumuman Pengisian KRS dan validasi KRS Tahun Akademik 2026/2027 Gasal</div>
                <div class="announcement-card-date">15 August 2026</div>
              </div>
              <div class="announcement-card-box">
                <div class="announcement-card-title">Pengumuman Semester Antara TA. 2025-2026</div>
                <div class="announcement-card-date">1 August 2026</div>
              </div>
            @endif
          </div>
        </div>

        {{-- SECTION AGENDA --}}
        <div class="mt-4 pt-3 border-top">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-calendar4-week fs-3" style="color: var(--uis-purple, #000000);"></i>
            <h3 class="section-heading-uis mb-0" style="font-size: 24px;">Agenda</h3>
          </div>

          <div class="agenda-list">
            @if(isset($agendas) && $agendas->count() > 0)
              @foreach($agendas as $agenda)
                <div class="agenda-row mb-3">
                  <div class="agenda-time-text">{{ $agenda->date_text }}:</div>
                  @if($agenda->link_url)
                    <a href="{{ $agenda->link_url }}" target="_blank" rel="noopener noreferrer" class="agenda-badge-card d-block text-decoration-none" title="Buka tautan agenda">
                      {{ $agenda->title }} <i class="bi bi-box-arrow-up-right ms-1 text-muted" style="font-size:11px"></i>
                    </a>
                  @else
                    <a href="{{ route('homepage.agenda.detail', $agenda->slug) }}" class="agenda-badge-card d-block text-decoration-none" title="Lihat detail agenda">
                      {{ $agenda->title }}
                    </a>
                  @endif
                </div>
              @endforeach
            @else
              <div class="agenda-row mb-3">
                <div class="agenda-time-text">20 - 31 Juli 2026:</div>
                <div class="agenda-badge-card">
                  Pendaftaran Semester Antara
                </div>
              </div>

              <div class="agenda-row mb-3">
                <div class="agenda-time-text">03 - 28 Agustus 2026:</div>
                <div class="agenda-badge-card">
                  Perkuliahan Semester Antara
                </div>
              </div>

              <div class="agenda-row mb-3">
                <div class="agenda-time-text">31 Agustus - 05 September 2026:</div>
                <div class="agenda-badge-card">
                  Penyerahan Nilai Semester Antara
                </div>
              </div>
            @endif

            <div class="mt-3">
              <a href="{{ route('homepage.agenda') }}" class="btn-agenda-pill">
                Lihat Seluruh Agenda
              </a>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
