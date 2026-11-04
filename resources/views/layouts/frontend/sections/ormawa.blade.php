<!-- ═══════════════════════════════════════════════
     9.3 ORGANISASI & KEGIATAN MAHASISWA (ORMAWA DECK SHOWCASE)
═══════════════════════════════════════════════ -->
@if(isset($organisasis) && $organisasis->count() > 0)
<section class="ormawa-deck-section" id="organisasi-mahasiswa">
  <div class="container position-relative">
    <div class="row align-items-center g-5">
      
      <!-- LEFT COLUMN: Editorial & Controls -->
      <div class="col-lg-5" data-aos="fade-right">
        <div class="ormawa-deck-intro">
          
          <div class="ormawa-eyebrow-pill mb-3">
            <span class="eyebrow-dot"></span>
            <span class="eyebrow-text">{{ $organisasiSetting?->badge_teks ?: 'LEMBAGA KEMAHASISWAAN · UIS' }}</span>
          </div>

          <h2 class="ormawa-deck-headline mb-3">
            @if(!empty($organisasiSetting?->judul))
              @php
                $rawJudul = $organisasiSetting->judul;
                $highlight = $organisasiSetting->judul_highlight;
                if (!empty($highlight) && str_contains($rawJudul, $highlight)) {
                    $escapedHighlight = e($highlight);
                    $renderedJudul = str_replace($highlight, '<span class="gradient-text">' . $escapedHighlight . '</span>', e($rawJudul));
                } else {
                    $renderedJudul = e($rawJudul);
                }
              @endphp
              {!! nl2br($renderedJudul) !!}
            @else
              Kiprah & <span class="gradient-text">Kepemimpinan</span><br>
              Mahasiswa UIS
            @endif
          </h2>

          <p class="ormawa-deck-lead mb-4">
            {{ strip_tags($organisasiSetting?->deskripsi ?: 'Eksplorasi ragam organisasi kemahasiswaan, himpunan program studi, dan unit kegiatan minat bakat di Teknik Informatika Batam. Ruang kolaborasi untuk mengasah karakter, kepemimpinan, dan inovasi civitas kampus.') }}
          </p>

          <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
            <a href="{{ !empty($organisasiSetting?->tombol_url) ? $organisasiSetting->tombol_url : route('homepage.organisasi') }}" class="btn-deck-main">
              <span>{{ $organisasiSetting?->tombol_teks ?: 'Jelajahi Semua Organisasi' }}</span>
              <span class="btn-deck-icon"><i class="bi bi-arrow-right"></i></span>
            </a>

            <!-- Deck Navigation Buttons -->
            <div class="deck-arrows-wrap">
              <button type="button" class="btn-deck-arrow" id="deckPrevBtn" aria-label="Organisasi Sebelumnya" title="Sebelumnya">
                <i class="bi bi-arrow-up"></i>
              </button>
              <button type="button" class="btn-deck-arrow" id="deckNextBtn" aria-label="Organisasi Selanjutnya" title="Selanjutnya">
                <i class="bi bi-arrow-down"></i>
              </button>
            </div>
          </div>

          <!-- Micro Hint -->
          <div class="deck-scroll-hint d-flex align-items-center gap-2 text-muted">
            <span class="hint-wheel-icon"><i class="bi bi-mouse"></i></span>
            <span class="hint-text">{{ $organisasiSetting?->hint_teks ?: 'Scroll mouse atau geser kartu untuk menggulir ormawa' }}</span>
          </div>

        </div>
      </div>

      <!-- RIGHT COLUMN: 3D Cascading Stacked Cards + Vertical Tracker -->
      <div class="col-lg-7" data-aos="fade-left">
        <div class="ormawa-showcase-stage" id="ormawaStageArea">
          
          <!-- Stack Container -->
          <div class="ormawa-deck-viewport">
            <div class="ormawa-deck-stack" id="ormawaDeckStack">
              @if(isset($organisasis) && $organisasis->count() > 0)
                @php
                  $themes = [
                    'radial-gradient(circle at 85% 15%, rgba(249, 220, 75, 0.32) 0%, transparent 45%), linear-gradient(155deg, #000000 0%, #000000 48%, #000000 100%)', // Emerald Gold (UIS)
                    'radial-gradient(circle at 85% 15%, rgba(56, 189, 248, 0.35) 0%, transparent 45%), linear-gradient(155deg, #0a192f 0%, #1e3a5f 48%, #050d1a 100%)', // Deep Navy / Blue
                    'radial-gradient(circle at 85% 15%, rgba(216, 180, 254, 0.35) 0%, transparent 45%), linear-gradient(155deg, #2e1065 0%, #6b21a8 48%, #170536 100%)', // Royal Purple
                    'radial-gradient(circle at 85% 15%, rgba(251, 191, 36, 0.35) 0%, transparent 45%), linear-gradient(155deg, #451a03 0%, #b45309 48%, #1c0701 100%)', // Amber Gold
                    'radial-gradient(circle at 85% 15%, rgba(45, 212, 191, 0.35) 0%, transparent 45%), linear-gradient(155deg, #042f2e 0%, #0f766e 48%, #021a19 100%)', // Teal Lagoon
                  ];
                @endphp
                @foreach($organisasis as $index => $ormawa)
                  @php
                    $singkat = $ormawa->singkatan ?: $ormawa->nama_organisasi;
                    $cardTheme = $themes[$index % count($themes)];
                    $initial = strtoupper(substr($ormawa->singkatan ?: $ormawa->nama_organisasi, 0, 2));
                  @endphp
                  <div class="ormawa-deck-card" 
                       data-index="{{ $index }}"
                       data-label="{{ $singkat }}"
                       data-num="{{ sprintf('%02d', $index + 1) }}">
                    
                    <!-- Artistic Card Background (Logo image as full-bleed background) -->
                    <div class="card-artistic-bg" style="background: {{ $cardTheme }};">
                      @if(!empty($ormawa->logo))
                        <img src="{{ asset('storage/' . $ormawa->logo) }}" alt="{{ $ormawa->nama_organisasi }}" class="card-bg-logo-img">
                        <div class="card-bg-logo-overlay"></div>
                      @else
                        <div class="card-mesh-glow"></div>
                        <div class="card-mesh-pattern"></div>
                        <div class="card-organic-wave"></div>
                        <div class="card-bg-watermark">{{ $initial }}</div>
                      @endif
                    </div>

                    <!-- Card Header (Top Bar) -->
                    <div class="card-top-bar">
                      <div class="card-counter-badge">
                        <span>{{ sprintf('%02d', $index + 1) }}</span>
                        <span class="mx-1">/</span>
                        <span>{{ sprintf('%02d', $organisasis->count()) }}</span>
                      </div>
                      <div class="card-cat-badge">
                        {{ strtoupper($ormawa->kategori) }}
                      </div>
                    </div>

                    <!-- Card Body & Footer (Bottom) -->
                    <div class="card-content-bottom">
                      <div class="card-kicker">CHAPTER {{ sprintf('%02d', $index + 1) }} · ORMAWA UIS</div>
                      <h3 class="card-title-text">{{ $singkat }}</h3>
                      <div class="card-subtitle-text">
                        {{ $ormawa->nama_organisasi }}
                        @if(!empty($ormawa->periode))
                          · Periode {{ $ormawa->periode }}
                        @endif
                      </div>
                      <p class="card-desc-snippet">
                        {{ Str::limit(strip_tags($ormawa->deskripsi ?: ($ormawa->visi ?: 'Lembaga kemahasiswaan aktif di lingkungan Teknik Informatika.')), 105) }}
                      </p>

                      <div class="card-meta-row">
                        <div class="card-meta-ketua">
                          <i class="bi bi-person-fill"></i>
                          <span>Ketua: {{ $ormawa->nama_ketua ?: 'Pengurus Ormawa' }}</span>
                        </div>
                        <a href="{{ route('homepage.organisasi.detail', $ormawa->slug) }}" class="card-link-action">
                          <span>Profil Lengkap</span>
                          <i class="bi bi-arrow-up-right"></i>
                        </a>
                      </div>
                    </div>

                  </div>
                @endforeach
              @endif
            </div>
          </div>

          <!-- Vertical Tracker / Progress Timeline (Right side of stack) -->
          @if(isset($organisasis) && $organisasis->count() > 0)
            <div class="ormawa-deck-tracker" id="ormawaTracker">
              <div class="tracker-counter-box">
                <span class="tracker-current-num" id="deckTrackerNum">01</span>
                <span class="tracker-slash">/</span>
                <span class="tracker-total-num">{{ sprintf('%02d', $organisasis->count()) }}</span>
              </div>
              
              <div class="tracker-rail-container" id="deckTrackerRail" title="Klik untuk berpindah">
                <div class="tracker-rail-track">
                  <div class="tracker-rail-thumb" id="deckTrackerThumb"></div>
                </div>
              </div>

              <div class="tracker-active-label" id="deckTrackerLabel">
                {{ $organisasis->first()->singkatan ?: $organisasis->first()->nama_organisasi }}
              </div>
            </div>
          @endif

        </div>
      </div>

    </div>
  </div>
</section>
@endif
