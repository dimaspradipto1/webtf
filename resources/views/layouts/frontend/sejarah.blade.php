@extends('layouts.frontend.template')

@section('title', 'Sejarah YAPISTA — Program Studi Teknik Informatika')
@section('meta_description', 'Sejarah perjalanan Yayasan Pendidikan Ibnu Sina Batam (YAPISTA) dan pendirian Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.')
@section('meta_keywords', 'sejarah yapista, milestone teknik informatika, fakultas sains dan teknologi')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'sejarah',
    'parentUrl' => route('homepage.tentang'),
    'parentLabel' => 'Profil',
    'defaultJudul' => 'Sejarah YAPISTA & Milestone Program Studi',
    'defaultSubjudul' => 'Perjalanan panjang Yayasan Pendidikan Ibnu Sina Batam (YAPISTA) dan sejarah pendirian Program Studi Teknik Informatika.',
    'defaultBreadcrumb' => 'Sejarah YAPISTA'
])

<!-- ═══════════════════════════════════════════════
     SEJARAH NARASI SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container">
    {{-- OPTIONAL VIDEO YOUTUBE EMBED / EXTERNAL LINK PREVIEW DI ATAS --}}
    @if($about?->sejarah_external_url)
      <div class="row mb-5" data-aos="fade-up">
        <div class="col-12">
          @if($about->sejarah_youtube_embed_url)
            <div class="position-relative rounded-4 overflow-hidden shadow-lg border w-100" style="border-color: #e2e8f0; background: #000;">
              <div class="ratio ratio-16x9">
                <iframe
                  src="{{ $about->sejarah_youtube_embed_url }}"
                  title="{{ $about->sejarah_link_label ?: 'Video Sejarah YAPISTA' }}"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin"
                  allowfullscreen>
                </iframe>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2 px-1">
              <span class="fw-semibold small text-dark">
                <i class="bi bi-youtube text-danger me-1"></i> {{ $about->sejarah_link_label ?: 'Video Sejarah YAPISTA & Program Studi Teknik Informatika' }}
              </span>
              <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">Video bermasalah saat diputar?</span>
                <a href="{{ $about->sejarah_external_url }}" target="_blank" rel="noopener noreferrer"
                   class="btn btn-sm text-white fw-semibold d-inline-flex align-items-center gap-1"
                   style="background-color: #000000; font-size: 12.5px; border-radius: 6px; padding: 5px 14px;">
                  <i class="bi bi-youtube text-warning"></i> Buka Langsung di YouTube <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 10px;"></i>
                </a>
              </div>
            </div>
          @else
            <div class="p-4 rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3"
                 style="background: #f8faf9; border: 1px solid #e2e8f0; border-left: 5px solid #000000;">
              <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                     style="width: 48px; height: 48px; background: #f9dc4b; color: #000000; font-size: 22px;">
                  <i class="bi bi-link-45deg"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1 text-dark">{{ $about->sejarah_link_label ?: 'Tautan Eksternal Sejarah YAPISTA' }}</h6>
                  <div class="text-muted small text-break">{{ $about->sejarah_external_url }}</div>
                </div>
              </div>
              <a href="{{ $about->sejarah_external_url }}" target="_blank" rel="noopener noreferrer"
                 class="btn fw-bold d-inline-flex align-items-center gap-2 px-4 py-2 rounded-3 flex-shrink-0"
                 style="background-color: #000000; color: #f9dc4b; font-size: 13.5px;">
                <span>Kunjungi Tautan</span>
                <i class="bi bi-box-arrow-up-right"></i>
              </a>
            </div>
          @endif
        </div>
      </div>
    @endif

    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="section-label">{{ $about?->sejarah_label ?: 'Jejak Langkah YAPISTA & Program Studi' }}</div>
        <h2 class="section-title">
          {{ $about?->sejarah_judul ?: 'Perjalanan Berkelanjutan' }}
          <em>{{ $about?->sejarah_judul_highlight ?: 'Mencetak Profesional Muda' }}</em>
        </h2>
        <div class="divider-line"></div>
        <div class="section-desc" style="text-align: justify; line-height: 1.8; color: #4a5568;">
          <p>
            {{ trim(html_entity_decode(strip_tags($about?->sejarah_deskripsi_1 ?: 'Teknik Informatika (UIS) Batam berdiri dari tonggak sejarah panjang pengabdian Yayasan Pendidikan Ibnu Sina Batam (YAPISNA) sejak tahun 1993 dalam memajukan kualitas sumber daya manusia di kawasan strategis perbatasan Kepulauan Riau.'), ENT_QUOTES, 'UTF-8')) }}
          </p>
          <p>
            {{ trim(html_entity_decode(strip_tags($about?->sejarah_deskripsi_2 ?: 'Melalui penggabungan tiga institusi pendidikan tinggi terkemuka—Sekolah Tinggi Teknik (STT), Sekolah Tinggi Ilmu Ekonomi (STIE), dan Sekolah Tinggi Ilmu Kesehatan (STIKES)—lembaga ini resmi bertransformasi menjadi Teknik Informatika berdasarkan Surat Keputusan Menristekdikti RI. Kini UIS menaungi Fakultas Teknik, Fakultas Ekonomi & Bisnis (FEB), Fakultas Ilmu Kesehatan (FIKES), dan Program Pascasarjana.'), ENT_QUOTES, 'UTF-8')) }}
          </p>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left">
        <div class="card border-0 rounded-4 shadow-sm h-100 position-relative overflow-hidden" 
             style="background: #ffffff; border: 1px solid rgba(0, 0, 0, 0.16) !important; border-top: 5px solid var(--uis-green, #000000) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;">
          <div class="card-body p-4 p-md-5">
            {{-- Header Card --}}
            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" 
                   style="width: 52px; height: 52px; background: #edf6f0; color: #000000; font-size: 24px; border: 1px solid #cce5d4;">
                <i class="bi bi-mortarboard-fill"></i>
              </div>
              <div>
                <h5 class="fw-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; color: #0a2313; letter-spacing: -0.2px;">
                  {{ $about?->sejarah_card_judul ?: 'Kampusnya Profesional Muda' }}
                </h5>
                <div class="fw-semibold" style="font-size: 13px; color: #000000;">
                  {{ $about?->sejarah_card_subjudul ?: 'Pendidikan, Riset Terapan & Kemitraan Industri Global' }}
                </div>
              </div>
            </div>

            {{-- Narasi Utama --}}
            <div class="p-3 rounded-3 mb-4" style="background: #f8faf9; border-left: 4px solid #000000; border-top: 1px solid #eef5f0; border-right: 1px solid #eef5f0; border-bottom: 1px solid #eef5f0;">
              <p class="mb-0" style="font-size: 14.5px; line-height: 1.85; color: #2d3748; text-align: justify;">
                {{ trim(html_entity_decode(strip_tags($about?->sejarah_card_narasi ?: 'Setiap fase perkembangan Teknik Informatika diarahkan untuk memperkuat mutu pembelajaran berbasis teknologi informasi, riset terapan bernilai guna bagi industri manufaktur dan maritim, serta membentuk lulusan berjiwa entrepreneur berbasis Imtaq.'), ENT_QUOTES, 'UTF-8')) }}
              </p>
            </div>

            {{-- Pilar Fokus Institusi --}}
            <div class="d-flex flex-wrap gap-2 pt-2 border-top" style="border-color: #edf2f7 !important;">
              <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: #edf6f0; color: #000000; border: 1px solid #d0e7d7; font-size: 11.5px;">
                <i class="bi bi-laptop me-1"></i> {{ $about?->sejarah_pilar_1 ?: 'Software & AI Engineering' }}
              </span>
              <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: #edf6f0; color: #000000; border: 1px solid #d0e7d7; font-size: 11.5px;">
                <i class="bi bi-gear-fill me-1"></i> {{ $about?->sejarah_pilar_2 ?: 'Multimedia' }}
              </span>
              <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background: #fffbeb; color: #92400e; border: 1px solid #fef3c7; font-size: 11.5px;">
                <i class="bi bi-star-fill me-1 text-warning"></i> {{ $about?->sejarah_pilar_3 ?: 'Networking' }}
              </span>
            </div>

            @if($about?->sejarah_external_url)
              <div class="mt-4 pt-3 border-top" style="border-color: #edf2f7 !important;">
                <a href="{{ $about->sejarah_external_url }}" target="_blank" rel="noopener noreferrer"
                   class="btn w-100 fw-bold d-inline-flex align-items-center justify-content-center gap-2 py-2 px-3 rounded-3"
                   style="background-color: #000000; color: #f9dc4b; font-size: 13.5px;">
                  @if($about->sejarah_youtube_embed_url)
                    <i class="bi bi-youtube text-danger fs-5"></i>
                    <span>{{ $about->sejarah_link_label ?: 'Tonton Video Sejarah di YouTube' }}</span>
                  @else
                    <i class="bi bi-globe2"></i>
                    <span>{{ $about->sejarah_link_label ?: 'Buka Link External Sejarah YAPISTA' }}</span>
                  @endif
                  <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 11px;"></i>
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- PIMPINAN DARI MASA KE MASA --}}
    @php
      $pimpinanEras = $about?->sejarah_pimpinan_list ?? \App\Models\About::defaultSejarahPimpinan();
    @endphp
    @if(!empty($pimpinanEras))
      <div class="row mt-5 pt-4 border-top" style="border-color: #eef2f6 !important;" data-aos="fade-up">
        <div class="col-12">
          <h3 class="fw-bold mb-4" style="font-size: 20px; color: #334155; font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $about?->sejarah_pimpinan_judul ?: 'Pimpinan dari Masa ke Masa' }}
          </h3>

          <div class="d-flex flex-column gap-4">
            @foreach($pimpinanEras as $eraGroup)
              <div>
                <h4 class="fw-bold mb-3" style="font-size: 16.5px; color: #334155; font-family: 'Plus Jakarta Sans', sans-serif;">
                  {{ $eraGroup['era'] ?? '' }}
                </h4>
                <div class="table-responsive rounded-2 overflow-hidden" style="border: 1px solid #f1f5f9;">
                  <table class="table mb-0 align-middle" style="border-collapse: collapse;">
                    <thead>
                      <tr style="background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
                        <th style="width: 36%; padding: 16px 20px; font-size: 15px; font-weight: 700; color: #334155; border-right: 1px solid #f1f5f9;">Periode</th>
                        <th style="padding: 16px 20px; font-size: 15px; font-weight: 700; color: #334155;">Pimpinan</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach(($eraGroup['items'] ?? []) as $row)
                        <tr style="background-color: #ffffff; border-bottom: 1px solid #f1f5f9;">
                          <td style="padding: 16px 20px; font-size: 15px; color: #475569; border-right: 1px solid #f1f5f9;">
                            {{ $row['periode'] ?? '-' }}
                          </td>
                          <td style="padding: 16px 20px; font-size: 15px; color: #475569;">
                            {{ $row['pimpinan'] ?? '-' }}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     TIMELINE MILESTONES
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Linimasa Perkembangan</div>
      <h2 class="section-title">Milestone & <em>Tonggak Sejarah</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Catatan pencapaian dan peristiwa penting dalam perjalanan Teknik Informatika UIS.
      </p>
    </div>

    @if(isset($milestones) && $milestones->count() > 0)
      <div class="timeline-container">
        @foreach($milestones as $index => $m)
          <div class="timeline-item" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}">
            <div class="timeline-badge">
              {{ $m->tahun ?: ($index + 1) }}
            </div>
            <div class="timeline-content">
              <span class="timeline-year-tag"><i class="bi bi-calendar-event me-1"></i> {{ $m->tahun }}</span>
              <h4 class="fw-bold text-dark mb-2">{{ $m->judul }}</h4>
              <p class="text-muted small mb-0" style="line-height: 1.7; text-align: justify;">
                {{ trim(html_entity_decode(strip_tags($m->deskripsi ?? ''), ENT_QUOTES, 'UTF-8')) }}
              </p>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="p-5 text-center bg-white rounded-4 shadow-sm">
        <i class="bi bi-hourglass fs-1 text-muted mb-3 d-block"></i>
        <h5 class="fw-bold text-dark">Data Milestone Belum Tersedia</h5>
        <p class="text-muted small">Data linimasa sejarah dapat ditambahkan melalui panel admin di menu <strong>Sejarah & Milestone</strong>.</p>
      </div>
    @endif

  </div>
</section>

@endsection
