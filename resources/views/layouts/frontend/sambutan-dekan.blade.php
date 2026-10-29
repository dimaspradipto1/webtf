@extends('layouts.frontend.template')

@section('title', 'Sambutan Kaprodi TF — Program Studi Teknik Informatika')
@section('meta_description', 'Sambutan resmi Ketua Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')
@section('meta_keywords', 'sambutan kaprodi tf, ketua program studi teknik informatika, fakultas sains dan teknologi')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="rektor-hero">
  <div class="container">
    <div data-aos="fade-up">
      <div class="badge px-3 py-2 rounded-pill mb-2" style="background: #f9dc4b; color: #000000; font-weight: 700; font-size: 12.5px;">
        <i class="bi bi-person-badge me-1"></i> Program Studi Teknik Informatika · Fakultas Sains dan Teknologi
      </div>
      <h1 class="rektor-hero-title">
        Sambutan <em>Kaprodi TF</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil</a>
        <span>/</span>
        <span class="active">Sambutan Kaprodi TF</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     SAMBUTAN KAPRODI CONTENT
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container py-3">
    <div class="row g-5">

      {{-- Left Column: Kaprodi Portrait --}}
      <div class="col-lg-4" data-aos="fade-right">
        <div class="rektor-portrait-box">
          @if(!empty($sambutanDekan?->foto_dekan))
            <img src="{{ asset('storage/' . $sambutanDekan->foto_dekan) }}" alt="{{ $sambutanDekan->nama_dekan ?? 'Kaprodi Teknik Informatika' }}" class="rektor-portrait-img">
          @else
            <div class="rektor-avatar-fallback">
              <i class="bi bi-person-badge"></i>
              <span style="font-size: 14px; font-weight: 600; margin-top: 10px;">Foto Kaprodi TF</span>
            </div>
          @endif

          <h3 class="rektor-name-title">{{ $sambutanDekan->nama_dekan ?? 'Ketua Program Studi Teknik Informatika' }}</h3>
          <span class="rektor-role-badge">
            <i class="bi bi-award-fill me-1"></i> {{ $sambutanDekan->jabatan_dekan ?? 'Kaprodi S1 Teknik Informatika — Fakultas Sains dan Teknologi' }}
          </span>

          <div class="pt-3 border-top mt-3 text-muted small text-start">
            <div class="mb-2"><i class="bi bi-mortarboard me-2" style="color: #000000;"></i> Program Studi S1 Teknik Informatika</div>
            <div><i class="bi bi-geo-alt me-2 text-danger"></i> Fakultas Sains dan Teknologi</div>
          </div>
        </div>
      </div>

      {{-- Right Column: Full Message --}}
      <div class="col-lg-8" data-aos="fade-left">
        <div class="section-label">Sambutan Ketua Program Studi</div>
        <h2 class="section-title mb-4">
          Mencetak Talenta Digital Unggul <em>Inovatif, Entrepreneur & Berkarakter Imtaq</em>
        </h2>

        {{-- Kutipan Singkat --}}
        <div class="rektor-quote-callout">
          <i class="bi bi-quote fs-3 d-block mb-1" style="color: #000000;"></i>
          "{{ strip_tags($sambutanDekan->kutipan_singkat ?? ($sambutanDekan->sambutan_dekan ?? 'Selamat datang di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Kami berkomitmen mencetak sarjana komputer yang menguasai rekayasa perangkat lunak, kecerdasan buatan, dan teknologi informasi mutakhir, berjiwa technopreneur, serta berlandaskan nilai Imtaq.')) }}"
        </div>

        {{-- Isi Lengkap Sambutan --}}
        <div class="sambutan-content-body" style="line-height: 1.85; font-size: 15.5px; color: #334155;">
          @if(!empty($sambutanDekan?->sambutan_dekan))
            {!! $sambutanDekan->sambutan_dekan !!}
          @else
            <p>
              <em>Assalamu’alaikum Warahmatullahi Wabarakatuh,</em><br>
              Salam sejahtera untuk kita semua.
            </p>
            <p>
              Puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, atas limpahan rahmat dan karunia-Nya sehingga <strong>Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi</strong> terus tumbuh dan berkontribusi nyata dalam melahirkan talenta teknologi informasi terbaik di Kepulauan Riau dan Indonesia.
            </p>
            <p>
              Melalui kurikulum berbasis <em>Outcome-Based Education (OBE)</em> yang diselaraskan dengan standar <strong>LAMINFOKOM</strong> serta kebutuhan dunia usaha dan dunia industri (DUDI), Program Studi Teknik Informatika membekali mahasiswa dengan kompetensi unggulan di bidang <strong>Rekayasa Perangkat Lunak (Software Engineering)</strong>, <strong>Kecerdasan Buatan (Artificial Intelligence & Data Science)</strong>, serta <strong>Jaringan & Keamanan Siber (Cyber Security)</strong>.
            </p>
            <p>
              Kepada seluruh mahasiswa, dosen, alumni, dan mitra industri, mari bersama-sama membangun ekosistem akademik dan riset teknologi yang inovatif, kolaboratif, dan berdaya saing global.
            </p>
            <p class="fw-bold mt-4 mb-1">
              <em>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</em>
            </p>
            <p class="text-muted">
              <strong>{{ $sambutanDekan->nama_dekan ?? 'Ketua Program Studi Teknik Informatika' }}</strong><br>
              <small>{{ $sambutanDekan->jabatan_dekan ?? 'Kaprodi S1 Teknik Informatika — Fakultas Sains dan Teknologi' }}</small>
            </p>
          @endif
        </div>

      </div>

    </div>
  </div>
</section>

@endsection
