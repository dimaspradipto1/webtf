<!-- ═══════════════════════════════════════════════
     6. FASILITAS & LABORATORIUM
═══════════════════════════════════════════════ -->
<section class="section-bg-sand" id="fasilitas">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Sarana Kampus</div>
      <h2 class="section-title">Fasilitas & <em>Laboratorium</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Menunjang proses riset dan praktikum mahasiswa dengan sarana pengujian berteknologi mutakhir.
      </p>
    </div>

    @php
      $defaultSaranas = collect([
        (object)[
          'icon' => 'bi-cpu-fill',
          'nama' => 'Lab Artificial Intelligence & Data Science',
          'deskripsi' => 'Komputasi performa tinggi untuk riset Machine Learning, Deep Learning, dan analisis Big Data.'
        ],
        (object)[
          'icon' => 'bi-shield-lock-fill',
          'nama' => 'Lab Network & Cyber Security',
          'deskripsi' => 'Dilengkapi perangkat Cisco, Mikrotik, dan simulator pengujian penetrasi keamanan siber.'
        ],
        (object)[
          'icon' => 'bi-laptop-fill',
          'nama' => 'Lab Software Engineering & Web Development',
          'deskripsi' => 'Ruang praktikum coding modern untuk rekayasa perangkat lunak, sistem enterprise, dan komputasi awan.'
        ],
        (object)[
          'icon' => 'bi-camera-reels-fill',
          'nama' => 'Studio Multimedia & Game Development',
          'deskripsi' => 'Fasilitas perancangan UI/UX, animasi 3D, Virtual Reality (VR), dan produksi konten digital kreatif.'
        ],
        (object)[
          'icon' => 'bi-cloud-arrow-up-fill',
          'nama' => 'Pusat Cloud Computing & Server Kampus',
          'deskripsi' => 'Infrastruktur server lokal dan cloud untuk hosting riset, repositori proyek, dan sistem akademik.'
        ],
        (object)[
          'icon' => 'bi-people-fill',
          'nama' => 'Coworking Space & Inkubator Startup TI',
          'deskripsi' => 'Ruang kolaboratif mahasiswa untuk perancangan produk technopreneurship dan pembinaan startup digital.'
        ],
      ]);

      $displaySaranas = (isset($saranas) && $saranas->count() > 0) ? $saranas : $defaultSaranas;
    @endphp

    <div class="row g-4">
      @foreach($displaySaranas as $index => $sarana)
        @php
          $detailUrl = isset($sarana->id)
            ? route('homepage.fasilitas.detail', $sarana->slug ?: $sarana->id)
            : route('homepage.fasilitas');
          $isLab = str_contains(mb_strtolower((string) $sarana->nama), 'lab');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
          <div class="fasilitas-box h-100 d-flex flex-column">
            <div class="fasilitas-icon"><i class="bi {{ $sarana->icon ?? 'bi-building' }}"></i></div>
            <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
            <p class="fasilitas-desc flex-grow-1">{{ $sarana->deskripsi ?: 'Fasilitas yang mendukung kegiatan akademik dan riset mahasiswa.' }}</p>
            <div class="mt-3 pt-2">
              <a href="{{ $detailUrl }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 12.5px;">
                <span>{{ $isLab ? 'Lihat Detail Lab' : 'Lihat Detail' }}</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
