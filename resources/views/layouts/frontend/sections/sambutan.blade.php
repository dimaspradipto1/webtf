<!-- ═══════════════════════════════════════════════
     3. SAMBUTAN KETUA PROGRAM STUDI (KAPRODI)
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5" id="sambutan-kaprodi">
  <span id="profil-singkat" style="position: relative; top: -80px; visibility: hidden; display: block;"></span>
  <div class="container py-2">
    <!-- Header Section Full -->
    <div class="row justify-content-center text-center mb-4" data-aos="fade-up">
      <div class="col-12">
        <div class="section-label mx-auto">Sambutan Ketua Program Studi</div>
        <h2 class="section-title mb-1">
          Sambutan Ketua Program Studi S1 Teknik Informatika
        </h2>
        <p class="fw-bold mb-2" style="color: #000000; font-size: 15px; letter-spacing: 0.4px;">Fakultas Sains dan Teknologi — Universitas Ibnu Sina</p>
        <div class="divider-line centered"></div>
      </div>
    </div>

    <!-- CONTENT SAMBUTAN KAPRODI: FOTO KIRI & PESAN/SAMBUTAN KANAN -->
    <div class="row g-4 align-items-center" data-aos="fade-up" data-aos-delay="150">
      
      {{-- Kolom Kiri: Foto & Identitas Kaprodi --}}
      <div class="col-lg-4 col-md-5">
        <div class="p-3 rounded-4 shadow-sm text-center h-100 d-flex flex-column justify-content-between" style="background: #ffffff; border: 1px solid #e2e8f0; transition: transform 0.25s ease;">
          <div>
            <div class="position-relative mx-auto mb-3" style="max-width: 290px; border-radius: 16px; overflow: hidden; border: 3px solid #f9dc4b; box-shadow: 0 10px 25px rgba(0,0,0,0.08); background: #f8fafc;">
              @if(!empty($sambutanDekan?->foto_dekan))
                <img src="{{ asset('storage/' . $sambutanDekan->foto_dekan) }}" 
                     alt="{{ $sambutanDekan->nama_dekan ?? 'Ketua Program Studi S1 Teknik Informatika' }}" 
                     class="img-fluid w-100 d-block" 
                     style="object-fit: cover; aspect-ratio: 3/4; max-height: 380px;">
              @else
                <div class="rektor-avatar-fallback" style="height: 330px; border-radius: 14px; margin: 0; max-width: 100%;">
                  <i class="bi bi-person-badge"></i>
                  <span style="font-size: 14px; font-weight: 600; margin-top: 10px;">Foto Ka Prodi</span>
                </div>
              @endif
              
              <div class="position-absolute bottom-0 start-0 end-0 p-2 text-center" style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 60%, transparent 100%);">
                <span class="badge px-3 py-1" style="background-color: #f9dc4b; color: #000000; font-weight: 700; font-size: 11px; letter-spacing: 0.5px;">
                  <i class="bi bi-patch-check-fill me-1"></i> KAPRODI S1 TEKNIK INFORMATIKA
                </span>
              </div>
            </div>

            <h3 class="fw-bold mb-1" style="font-size: 18.5px; color: #0f172a; line-height: 1.35;">
              {{ $sambutanDekan->nama_dekan ?? 'Dr. Army Trilidia D, S.Kom, M.Pd.T' }}
            </h3>
            <p class="text-muted small mb-2" style="font-size: 13.5px; font-weight: 600;">
              {{ $sambutanDekan->jabatan_dekan ?? 'Ketua Program Studi S1 Teknik Informatika' }}
            </p>
          </div>

          <div class="pt-2 border-top mt-2 small text-muted text-center" style="font-size: 12.5px;">
            <span class="d-inline-block px-2 py-1 rounded bg-light border me-1 mb-1 text-dark fw-semibold">
              <i class="bi bi-mortarboard-fill text-warning me-1"></i> S1 Teknik Informatika
            </span>
            <span class="d-inline-block px-2 py-1 rounded bg-light border mb-1 text-dark fw-semibold">
              <i class="bi bi-building text-secondary me-1"></i> Sains & Teknologi
            </span>
          </div>
        </div>
      </div>

      {{-- Kolom Kanan: Pesan Singkat & Ringkasan Sambutan --}}
      <div class="col-lg-8 col-md-7">
        <div class="h-100 d-flex flex-column justify-content-between">
          
          <div>
            {{-- Kutipan Singkat / Quote Card --}}
            <div class="p-3 p-md-4 rounded-4 shadow-sm mb-4 position-relative" style="background: #fffdf5; border-left: 5px solid #f9dc4b; border-top: 1px solid #fef3c7; border-right: 1px solid #fef3c7; border-bottom: 1px solid #fef3c7;">
              <div class="d-flex align-items-start gap-3">
                <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: #f9dc4b; color: #000000; box-shadow: 0 4px 10px rgba(249, 220, 75, 0.4);">
                  <i class="bi bi-quote fs-4"></i>
                </div>
                <div class="flex-grow-1">
                  <div class="fw-bold mb-1" style="font-size: 12.5px; color: #92400e; letter-spacing: 0.5px; text-transform: uppercase;">
                    Pesan & Komitmen Kaprodi
                  </div>
                  <p class="fst-italic mb-0" style="color: #1e293b; font-size: 15.5px; line-height: 1.7; font-weight: 500;">
                    "{{ strip_tags($sambutanDekan->kutipan_singkat ?? 'Selamat datang di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Kami berkomitmen mencetak sarjana komputer yang menguasai rekayasa perangkat lunak, kecerdasan buatan, dan teknologi informasi mutakhir, berjiwa technopreneur, serta berlandaskan nilai Imtaq.') }}"
                  </p>
                </div>
              </div>
            </div>

            {{-- Isi Sambutan --}}
            <div class="p-4 rounded-4 shadow-sm mb-4" style="background: #f8fafc; border-left: 5px solid #000000; border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; font-size: 15px; line-height: 1.85; color: #334155; text-align: justify;">
              @if(!empty($sambutanDekan?->sambutan_dekan))
                {!! $sambutanDekan->sambutan_dekan !!}
              @else
                <p>
                  <em>Assalamu’alaikum Warahmatullahi Wabarakatuh,</em><br>
                  Salam sejahtera untuk kita semua.
                </p>
                <p>
                  Puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya sehingga <strong>Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi</strong> terus tumbuh dan berkontribusi nyata dalam melahirkan talenta teknologi informasi terbaik di Kepulauan Riau dan Indonesia.
                </p>
                <p>
                  Melalui kurikulum berbasis <em>Outcome-Based Education (OBE)</em> yang diselaraskan dengan standar <strong>LAMINFOKOM</strong> serta kebutuhan dunia usaha dan dunia industri (DUDI), Program Studi Teknik Informatika membekali mahasiswa dengan kompetensi unggulan di bidang <strong>Rekayasa Perangkat Lunak (Software Engineering)</strong>, <strong>Kecerdasan Buatan (Artificial Intelligence & Data Science)</strong>, serta <strong>Jaringan & Keamanan Siber (Cyber Security)</strong>.
                </p>
                <p class="mb-0">
                  Kepada seluruh mahasiswa, dosen, alumni, dan mitra industri, mari bersama-sama membangun ekosistem akademik dan riset teknologi yang inovatif, kolaboratif, dan berdaya saing global.
                </p>
              @endif
            </div>
          </div>

          {{-- CTA Buttons --}}
          <div class="d-flex flex-wrap align-items-center gap-3">
            <a href="{{ route('homepage.sambutan-rektor') }}" class="btn-primary-hero d-inline-flex align-items-center gap-2">
              <i class="bi bi-chat-quote-fill"></i>
              <span>Baca Sambutan Selengkapnya</span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>

        </div>
      </div>

    </div>

  </div>
</section>
