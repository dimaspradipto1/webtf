<!-- ═══════════════════════════════════════════════
     10. ALUMNI & KARIER
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="alumni">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Kisah Sukses Alumni</div>
      <h2 class="section-title">Jejak Karir <em>Alumni Teknik Informatika</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Lulusan Teknik Informatika telah berkarier di berbagai perusahaan multinasional, industri manufaktur, sektor logistik maritim, perbankan, instansi BUMN, pemerintahan, serta sukses menjadi wirausahawan mandiri.
      </p>
    </div>

    <!-- Swiper Testimonial Slider -->
    <div class="position-relative px-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper alumniSwiper pb-5">
    @php
      $defaultTestimonials = collect([
        (object)[
          'nama' => 'Rizky Ramadhan, S.Kom',
          'pekerjaan' => 'Senior Software Engineer, Tech Unicorn',
          'kategori' => 'Alumni',
          'bintang' => 5,
          'pesan' => 'Kurikulum Teknik Informatika UIS sangat aplikatif dengan kebutuhan industri terkini. Fondasi algoritma dan software engineering yang kuat sangat membantu karir saya.'
        ],
        (object)[
          'nama' => 'Dwi Nurhaliza, S.Kom',
          'pekerjaan' => 'Cybersecurity Analyst, BUMN Perbankan',
          'kategori' => 'Alumni',
          'bintang' => 5,
          'pesan' => 'Fasilitas laboratorium jaringan dan keamanan siber yang mutakhir memungkinkan kami melakukan praktikum langsung dan meraih sertifikasi internasional sebelum wisuda.'
        ],
        (object)[
          'nama' => 'Ahmad Fauzi, S.Kom',
          'pekerjaan' => 'Cloud & DevOps Specialist, Multinasional Corp',
          'kategori' => 'Alumni',
          'bintang' => 5,
          'pesan' => 'Dosen yang berdedikasi serta lingkungan akademik yang kolaboratif membuka wawasan luas untuk bersaing di kancah nasional maupun internasional.'
        ],
        (object)[
          'nama' => 'Siti Aisyah, S.Kom',
          'pekerjaan' => 'AI & Data Scientist, Industri Digital',
          'kategori' => 'Alumni',
          'bintang' => 5,
          'pesan' => 'Pembelajaran berbasis riset terapan di prodi Teknik Informatika memberikan keterampilan analisis data dan machine learning yang sangat diminati pasar kerja saat ini.'
        ]
      ]);

      $displayTestimonials = (isset($testimonials) && $testimonials->count() > 0) ? $testimonials : $defaultTestimonials;
    @endphp

        <div class="swiper-wrapper">
          @foreach($displayTestimonials as $index => $testi)
            @php
              $initials = '';
              $words = explode(' ', $testi->nama);
              foreach ($words as $w) {
                  $initials .= strtoupper(substr($w, 0, 1));
              }
              $initials = substr($initials, 0, 2);
            @endphp
            <div class="swiper-slide h-auto">
              <div class="testi-card h-100 shadow-sm" style="background: #ffffff; border: 1.5px solid #f0e6f5; border-radius: 20px; padding: 28px 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease;">
                <div>
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="testi-stars m-0" style="color: #f9dc4b; font-size: 15px; display: flex; gap: 3px;">
                      @for($s = 1; $s <= 5; $s++)
                        <i class="bi bi-star{{ $s <= $testi->bintang ? '-fill' : '' }}"></i>
                      @endfor
                    </div>
                    <span class="badge" style="background: #f9dc4b; color: #000000; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 8px;">
                      {{ $testi->kategori ?? 'Alumni' }}
                    </span>
                  </div>
                  <p class="testi-text mb-4" style="font-size: 14px; line-height: 1.6; color: #333333; font-style: italic;">"{{ $testi->pesan }}"</p>
                </div>
                <div class="testi-author pt-3 border-top d-flex align-items-center gap-3" style="border-color: #f7effa !important;">
                  <div class="testi-avatar flex-shrink-0" style="width: 44px; height: 44px; border-radius: 50%; background: #000000; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">{{ $initials ?: 'AL' }}</div>
                  <div>
                    <div class="testi-name text-dark fw-bold" style="font-size: 14px; line-height: 1.3;">{{ $testi->nama }}</div>
                    <div class="testi-role text-muted small" style="font-size: 12px;">{{ $testi->pekerjaan ?? 'Alumni Teknik Informatika' }}</div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div>
      </div>

      <!-- Navigation Arrows -->
      <div class="swiper-button-prev alumni-prev" style="color: #000000;"></div>
      <div class="swiper-button-next alumni-next" style="color: #000000;"></div>
    </div>

    <div class="text-center mt-3" data-aos="fade-up">
      <a href="{{ route('homepage.testimoni') }}" class="btn-outline-hero px-4 py-2" style="color: var(--uis-purple); border-color: var(--uis-purple); border-radius: 25px; font-weight: 600;">
        <i class="bi bi-chat-heart me-1"></i> Lihat Semua Ulasan Alumni
      </a>
    </div>
  </div>
</section>
