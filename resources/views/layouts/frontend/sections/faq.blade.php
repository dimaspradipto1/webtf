<!-- ═══════════════════════════════════════════════
     14. FAQ (FREQUENTLY ASKED QUESTIONS)
═══════════════════════════════════════════════ -->
<section class="section-bg-sand" id="faq">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Tanya Jawab</div>
      <h2 class="section-title">Pertanyaan yang Sering <em>Diajukan</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Jawaban seputar program studi, biaya perkuliahan, fasilitas laboratorium, dan prospek karir di Teknik Informatika.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-9" data-aos="fade-up">
        <div class="accordion" id="homeFaqAccordion">
          @php
            $defaultFaqs = collect([
              (object)[
                'question' => 'Apa saja keunggulan Program Studi S1 Teknik Informatika di UIS?',
                'answer' => 'Program Studi S1 Teknik Informatika UIS memiliki kurikulum berbasis industri terkini (Software Engineering, Artificial Intelligence, Cyber Security, Cloud Computing), dosen bergelar S3 dan praktisi profesional, laboratorium modern, serta kerjasama penempatan magang industri di kawasan industri Batam dan internasional.'
              ],
              (object)[
                'question' => 'Bagaimana prospek kerja dan peluang karir lulusan Teknik Informatika?',
                'answer' => 'Lulusan memiliki prospek karir yang sangat luas dan dibutuhkan di semua sektor, antara lain sebagai Software Engineer, Fullstack Web/Mobile Developer, Data Scientist, Cybersecurity Specialist, Cloud & DevOps Engineer, Network Administrator, IT Consultant, hingga Digital Technopreneur.'
              ],
              (object)[
                'question' => 'Apakah tersedia program beasiswa untuk mahasiswa baru?',
                'answer' => 'Ya, Universitas Ibnu Sina menyediakan berbagai jalur beasiswa, seperti Beasiswa KIP-Kuliah Kemendikbudristek, Beasiswa Prestasi Akademik & Non-Akademik, Beasiswa Hafiz Al-Qur\'an, Beasiswa Mitra Industri, dan potongan biaya pendaftaran gelombang awal.'
              ],
              (object)[
                'question' => 'Bagaimana prosedur pendaftaran mahasiswa baru (PMB)?',
                'answer' => 'Pendaftaran dapat dilakukan secara online melalui portal PMB resmi atau langsung datang ke Sekretariat PMB Kampus UIS. Calon mahasiswa cukup mengisi formulir pendaftaran, melengkapi berkas ijazah/rapor, dan memilih jalur seleksi yang diinginkan.'
              ]
            ]);

            $displayFaqs = (isset($faqs) && $faqs->count() > 0) ? $faqs->take(5) : $defaultFaqs;
          @endphp

          @foreach($displayFaqs as $index => $faq)
            <div class="accordion-item shadow-sm">
              <h2 class="accordion-header" id="headingH{{ $faq->id ?? $index }}">
                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseH{{ $faq->id ?? $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                  <i class="bi bi-question-circle-fill me-2" style="color: var(--uis-purple);"></i>
                  {{ $faq->question ?? $faq->pertanyaan }}
                </button>
              </h2>
              <div id="collapseH{{ $faq->id ?? $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#homeFaqAccordion">
                <div class="accordion-body">
                  {{ $faq->answer ?? $faq->jawaban }}
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="text-center mt-4">
          <a href="{{ route('homepage.faq') }}" class="btn-outline-hero" style="color: var(--uis-purple); border-color: var(--uis-purple);">
            <i class="bi bi-question-circle"></i> Lihat Semua FAQ & Bantuan
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
