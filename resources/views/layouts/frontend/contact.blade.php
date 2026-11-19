@extends('layouts.frontend.template')

@section('title', 'Hubungi Kami — Teknik Informatika (UIS)')
@section('meta_description', 'Hubungi Teknik Informatika (UIS) untuk informasi program studi, layanan akademik, praktikum laboratorium, dan penerimaan mahasiswa baru.')
@section('meta_keywords', 'kontak uis, alamat teknik informatika, nomor wa uis, lokasi kampus uis')

@section('content')
@php
  $cleanWa = $cleanWa ?? '';
  if (empty($cleanWa) && !empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'kontak',
    'defaultJudul' => 'Hubungi Kami',
    'defaultSubjudul' => 'Informasi alamat kampus, kontak resmi, surel, dan saluran konsultasi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
    'defaultBreadcrumb' => 'Hubungi Kami'
])

<!-- ═══════════════════════════════════════════════
     CONTACT INFO CARDS & MAP
═══════════════════════════════════════════════ -->
<section class="section-bg-white">
  <div class="container">
    
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-geo-alt-fill"></i></div>
          <h4 class="contact-card-title">Alamat Kampus</h4>
          <p class="contact-card-text">
            {{ $contact->alamat ?? 'Gedung Teknik Informatika (UIS), Kampus Terpadu' }}
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-envelope-open-fill"></i></div>
          <h4 class="contact-card-title">Email Resmi</h4>
          <p class="contact-card-text">
            <a href="mailto:{{ $contact->email ?? 'humas@uis.ac.id' }}" class="text-decoration-none fw-bold" style="color: var(--uis-purple);">
              {{ $contact->email ?? 'humas@uis.ac.id' }}
            </a>
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-whatsapp"></i></div>
          <h4 class="contact-card-title">Layanan WhatsApp</h4>
          <p class="contact-card-text">
            @if(!empty($cleanWa))
              <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="text-decoration-none fw-bold text-success">
                <i class="bi bi-whatsapp me-1"></i> {{ $contact->no_wa ?? '0812-3456-7890' }}
              </a>
            @else
              <span>{{ $contact->no_wa ?? '0812-3456-7890' }}</span>
            @endif
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
        <div class="contact-card-box">
          <div class="contact-card-icon"><i class="bi bi-clock-fill"></i></div>
          <h4 class="contact-card-title">Jam Layanan</h4>
          <p class="contact-card-text">
            {!! nl2br(e($contact?->jam_operasional ?: ($topbarSetting?->jam_operasional ?: "Senin – Sabtu: 08.00 – 17.00 WIB"))) !!}
          </p>
        </div>
      </div>
    </div>

    <!-- FORM KIRIM PESAN KE PROGRAM STUDI (A9) -->
    <div id="kirim-pesan" class="card border-0 shadow-sm mb-5" style="border-radius: 24px; border: 1px solid var(--border-light) !important;" data-aos="fade-up">
      <div class="card-body p-4 p-md-5">
        <div class="mb-4">
          <h3 class="fw-bold text-dark mb-1" style="font-size: 1.45rem;">Kirim Pesan ke Program Studi</h3>
          <p class="text-muted mb-0" style="font-size: 0.94rem;">Pertanyaan PMB, akademik, atau kerja sama. Kami membalas dalam 1–2 hari kerja.</p>
        </div>

        @if(session('contact_success'))
          <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('contact_success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Periksa kembali isian formulir Anda:</strong>
            <ul class="mb-0 mt-1 ps-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ route('homepage.kontak.submit') }}" method="POST">
          @csrf
          {{-- Honeypot anti-bot --}}
          <div class="d-none" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label for="contact_nama" class="form-label fw-semibold small text-dark">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" id="contact_nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Nama lengkap" required style="border-radius: 12px; padding: 11px 14px;">
              @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label for="contact_email" class="form-label fw-semibold small text-dark">Email <span class="text-danger">*</span></label>
              <input type="email" id="contact_email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="nama@email.com" required style="border-radius: 12px; padding: 11px 14px;">
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label for="contact_kategori" class="form-label fw-semibold small text-dark">Kategori Pesan <span class="text-danger">*</span></label>
              <select id="contact_kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required style="border-radius: 12px; padding: 11px 14px;">
                @foreach(\App\Models\ContactMessage::KATEGORI_LIST as $kat)
                  <option value="{{ $kat }}" {{ old('kategori', 'PMB') === $kat ? 'selected' : '' }}>Kategori: {{ $kat }}</option>
                @endforeach
              </select>
              @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="mb-4">
            <label for="contact_pesan" class="form-label fw-semibold small text-dark">Isi Pesan <span class="text-danger">*</span></label>
            <textarea id="contact_pesan" name="pesan" rows="4" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tulis pesan atau pertanyaan Anda di sini..." required style="border-radius: 14px; padding: 12px 14px;">{{ old('pesan') }}</textarea>
            @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pt-2">
            <div class="d-flex align-items-center gap-2 p-2 px-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
              <i class="bi bi-shield-check text-success fs-5"></i>
              <label for="contact_captcha" class="small fw-semibold text-dark mb-0 text-nowrap">
                Verifikasi: <strong>{{ $captchaQuestion ?? ((session('contact_captcha_a', 3)) . ' + ' . (session('contact_captcha_b', 4))) }} =</strong>
              </label>
              <input type="number" id="contact_captcha" name="captcha_answer" class="form-control form-control-sm text-center fw-bold @error('captcha_answer') is-invalid @enderror" style="width: 74px; border-radius: 8px;" placeholder="?" required>
            </div>

            <button type="submit" class="btn fw-bold px-4 py-2 d-inline-flex align-items-center justify-content-center gap-2" style="background: #f9dc4b; color: #000000; border-radius: 12px; border: 1px solid #eab308;">
              <i class="bi bi-send-fill"></i>
              <span>Kirim Pesan</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- PETA LOKASI -->
    @php
      $mapIframe = $contact->map_iframe ?? ($contact->map ?? '');
    @endphp
    @if(isset($contact) && !empty($mapIframe))
      <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; border: 1px solid var(--border-light) !important;" data-aos="fade-up">
        <div class="p-3 bg-light border-bottom fw-bold text-dark d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="bi bi-pin-map-fill text-danger me-2 fs-5"></i>
            <span>Lokasi Kampus UIS di Google Maps</span>
          </div>
          @if(!empty($contact->resolved_latitude) && !empty($contact->resolved_longitude))
            <a href="https://www.google.com/maps/search/?api=1&query={{ $contact->resolved_latitude }},{{ $contact->resolved_longitude }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" style="font-size: 12.5px;">
              <i class="bi bi-box-arrow-up-right me-1"></i> Buka Peta Penuh
            </a>
          @endif
        </div>
        <div class="map-responsive-container">
          {!! $mapIframe !!}
        </div>
      </div>
    @endif

  </div>
</section>

@endsection
