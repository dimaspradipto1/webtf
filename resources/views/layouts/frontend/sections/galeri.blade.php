<!-- ═══════════════════════════════════════════════
     9.5 GALERI DOKUMENTASI & KEGIATAN KAMPUS
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5" id="galeri">
  <div class="container py-3">
    <div class="d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3" data-aos="fade-up">
      <div>
        <div class="section-label mb-2">Dokumentasi Visual</div>
        <h2 class="section-title mb-0">Galeri & <em>Kegiatan Teknik Informatika</em></h2>
      </div>
      <a href="{{ route('homepage.galeri.universitas') }}" class="btn-outline-hero" style="color: var(--uis-purple); border-color: var(--uis-purple); font-size: 13.5px; padding: 10px 22px;">
        <i class="bi bi-images me-1"></i> Lihat Semua Galeri
      </a>
    </div>

    @php
      $defaultGalleries = collect([
        (object)[
          'judul' => 'Praktikum Komputasi Awan & Jaringan di Lab Cisco UIS',
          'deskripsi' => 'Aktivitas mahasiswa dalam implementasi routing, switching, dan simulasi keamanan jaringan.',
          'url' => null,
          'slug' => null,
          'id' => 1
        ],
        (object)[
          'judul' => 'Workshop Technopreneurship & Pembuatan Startup Digital',
          'deskripsi' => 'Pelatihan intensif pengembangan MVP aplikasi mobile bersama praktisi industri teknologi.',
          'url' => null,
          'slug' => null,
          'id' => 2
        ],
        (object)[
          'judul' => 'Kunjungan Industri ke Kawasan Manufaktur & Data Center Batam',
          'deskripsi' => 'Pengenalan operasional infrastruktur server skala enterprise dan lini produksi otomatis.',
          'url' => null,
          'slug' => null,
          'id' => 3
        ]
      ]);

      $displayGalleries = (isset($galleries) && $galleries->count() > 0) ? $galleries->take(6) : $defaultGalleries;
    @endphp

    <div class="row g-4">
      @foreach($displayGalleries as $index => $gal)
        @php
          $galUrl = !empty($gal->slug) ? route('homepage.galeri.detail', $gal->slug) : route('homepage.galeri.universitas');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
          <a href="{{ $galUrl }}" class="gallery-card-item d-block text-decoration-none">
            <div class="gallery-img-container">
              @if(!empty($gal->url))
                <img src="{{ asset('storage/' . $gal->url) }}" alt="{{ $gal->judul }}" class="gallery-card-img" loading="lazy">
              @else
                <div class="gallery-fallback-box">
                  <i class="bi bi-camera-fill fs-1 text-white-50"></i>
                </div>
              @endif
              <div class="gallery-card-overlay">
                <span class="gallery-tag"><i class="bi bi-tag-fill me-1"></i>Dokumentasi</span>
                <h5 class="gallery-card-title">{{ $gal->judul }}</h5>
                @if(!empty($gal->deskripsi))
                  <p class="gallery-card-desc mb-0">{!! Str::limit(strip_tags($gal->deskripsi), 90) !!}</p>
                @endif
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
