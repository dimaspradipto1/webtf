<!-- ═══════════════════════════════════════════════
     8. PRESTASI MAHASISWA & STUDENT LIFE
═══════════════════════════════════════════════ -->
<section class="section-bg-white" id="prestasi">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Kebanggaan Kampus</div>
      <h2 class="section-title">Prestasi Gemilang <em>Mahasiswa UIS</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Bukti dedikasi, keunggulan riset, dan daya saing mahasiswa Teknik Informatika di berbagai kompetisi ilmiah dan kejuaraan.
      </p>
    </div>

    @php
      $defaultPrestasis = collect([
        (object)[
          'judul_prestasi' => 'Juara 1 Hackathon Smart City & AI Innovation',
          'nama_mahasiswa' => 'Tim ByteCraft UIS',
          'prodi' => 'S1 Teknik Informatika',
          'tingkat' => 'Nasional',
          'peringkat' => 'Juara 1',
          'penyelenggara' => 'Kementerian Kominfo & Aptikom',
          'tahun' => '2025',
          'deskripsi' => 'Pengembangan prototipe sistem pemantauan maritim cerdas berbasis Computer Vision dan IoT berdaya rendah.',
          'foto' => null,
          'slug' => null,
          'id' => 1
        ],
        (object)[
          'judul_prestasi' => 'Medali Emas Gemastik Bidang Software Development',
          'nama_mahasiswa' => 'Rian Hidayat & Tim',
          'prodi' => 'S1 Teknik Informatika',
          'tingkat' => 'Nasional',
          'peringkat' => 'Medali Emas',
          'penyelenggara' => 'Puspresnas Kemendikbudristek',
          'tahun' => '2025',
          'deskripsi' => 'Inovasi platform manajemen data logistik pelabuhan berbasis cloud computing terintegrasi.',
          'foto' => null,
          'slug' => null,
          'id' => 2
        ],
        (object)[
          'judul_prestasi' => 'Best Paper & Prototype International Conference on Cyber Security',
          'nama_mahasiswa' => 'Maya Kartika Putri',
          'prodi' => 'S1 Teknik Informatika',
          'tingkat' => 'Internasional',
          'peringkat' => 'Best Paper',
          'penyelenggara' => 'IEEE Computer Society',
          'tahun' => '2025',
          'deskripsi' => 'Riset implementasi arsitektur zero-trust network security pada infrastruktur komputasi industri.',
          'foto' => null,
          'slug' => null,
          'id' => 3
        ]
      ]);

      $displayPrestasis = (isset($prestasis) && $prestasis->count() > 0) ? $prestasis : $defaultPrestasis;
    @endphp

    <div class="row g-4 mb-5">
      @foreach($displayPrestasis as $index => $prestasi)
        @php
          $tingkatBadge = match($prestasi->tingkat) {
              'Internasional' => 'bg-danger text-white',
              'Nasional'      => 'bg-success text-white',
              'Provinsi / Wilayah' => 'bg-warning text-dark',
              default         => 'bg-secondary text-white',
          };
          $prestasiUrl = !empty($prestasi->slug) ? route('homepage.prestasi.detail', $prestasi->slug) : route('homepage.prestasi');
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
          <div class="prestasi-card">
            <div class="prestasi-img-wrap">
              @if(!empty($prestasi->foto))
                <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->judul_prestasi }}" class="prestasi-img">
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
                  <a href="{{ $prestasiUrl }}" class="text-dark text-decoration-none">
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
                    <span class="text-truncate me-2"><i class="bi bi-building me-1 text-warning"></i>{{ $prestasi->penyelenggara ?? 'Penyelenggara Nasional' }}</span>
                    <span class="fw-bold text-dark flex-shrink-0">{{ $prestasi->tahun ?? '' }}</span>
                  </div>
                @endif

                @if(!empty($prestasi->deskripsi))
                  <div class="text-muted small" style="font-size: 12.5px; line-height: 1.6;">
                    {!! Str::limit(strip_tags($prestasi->deskripsi), 110) !!}
                  </div>
                @endif
              </div>

              <div class="pt-3 border-top mt-3">
                <a href="{{ $prestasiUrl }}" class="fw-bold text-decoration-none d-flex align-items-center justify-content-between" style="color: var(--uis-purple); font-size: 13px;">
                  <span>Lihat Selengkapnya</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Tombol Lihat Semua Prestasi --}}
    <div class="text-center mt-2 mb-5">
      <a href="{{ route('homepage.prestasi') }}" class="btn-uis-pill">
        <i class="bi bi-trophy-fill me-1 text-warning"></i> Lihat Semua Prestasi Mahasiswa
      </a>
    </div>


  </div>
</section>
