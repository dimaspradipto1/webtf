@extends('layouts.frontend.template')

@section('title', 'Formulir Ulasan & Testimoni Alumni — Teknik Informatika (UIS)')
@section('meta_description', 'Portal khusus pengisian testimoni dan kisah sukses alumni serta civitas akademika Teknik Informatika.')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(249, 220, 75, 0.15); border: 1px solid rgba(249, 220, 75, 0.4);">
        <i class="bi bi-mortarboard-fill text-warning"></i>
        <span class="text-warning small fw-bold">PORTAL KHUSUS ALUMNI & CIVITAS</span>
      </div>
      <h1 style="font-size: 36px; font-weight: 800; color: var(--white); margin-bottom: 10px;">
        Formulir <em style="font-style: normal; color: var(--uis-orange);">Testimoni & Pengalaman</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.testimoni') }}">Testimoni Alumni</a>
        <span>/</span>
        <span class="active">Formulir Testimoni</span>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════
     FORMULIR KHUSUS PENGISIAN TESTIMONI ALUMNI
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        
        <!-- Info Card Moderasi -->
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-3 p-4 mb-4" style="border-radius: 16px; background: #eef7ff; border-left: 5px solid #0088ff !important;">
          <i class="bi bi-shield-check fs-2 text-primary mt-1"></i>
          <div>
            <h6 class="fw-bold text-dark mb-1">Verifikasi & Moderasi Ulasan</h6>
            <p class="small text-muted mb-0">
              Formulir ini dikhususkan bagi alumni, mahasiswa, maupun mitra industri dan institusi Teknik Informatika. Setiap testimoni yang dikirimkan akan diverifikasi oleh admin sebelum ditampilkan di halaman website resmi demi menjaga validitas data.
            </p>
          </div>
        </div>

        <div class="card border-0 shadow-lg p-4 p-md-5" style="border-radius: 24px; background: var(--white); border: 1px solid #d8e8dc !important;">
          
          <div class="text-center mb-4">
            <div class="section-label mx-auto">Kisah Sukses Alumni</div>
            <h3 class="fw-bold mb-2 text-dark">Bagikan Jejak Karier & Pengalaman Anda</h3>
            <p class="text-muted small" style="max-width: 520px; margin: 0 auto;">
              Cerita dan pengalaman Anda akan sangat menginspirasi calon mahasiswa baru serta membanggakan almamater Teknik Informatika.
            </p>
          </div>

          @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 p-3" role="alert" style="border-radius: 12px;">
              <i class="bi bi-check-circle-fill me-3 fs-3 text-success"></i>
              <div>
                <strong>Berhasil Terkirim!</strong>
                <div class="small">{{ session('success') }}</div>
              </div>
            </div>
          @endif

          @if(isset($errors) && $errors->any())
            <div class="alert alert-danger mb-4" style="border-radius: 12px;">
              <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('homepage.alumni.store') }}" method="POST">
            @csrf

            {{-- Honeypot Anti-Bot (Disembunyikan dari pengguna asli) --}}
            <div style="position: absolute; left: -9999px; top: -9999px;" aria-hidden="true">
              <label for="website_url">Website</label>
              <input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off" value="">
            </div>
            
            <div class="row g-3">
              {{-- Nama Lengkap --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" placeholder="Contoh: Budi Santoso, S.Kom" value="{{ old('nama') }}" required style="border-radius: 12px; font-size: 14px;">
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Profesi / Pekerjaan --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Profesi / Jabatan / Tempat Bekerja <span class="text-danger">*</span></label>
                <input type="text" name="pekerjaan" class="form-control form-control-lg @error('pekerjaan') is-invalid @enderror" placeholder="Contoh: Software Engineer / Network Specialist / Konsultan IT" value="{{ old('pekerjaan') }}" required style="border-radius: 12px; font-size: 14px;">
                @error('pekerjaan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Kategori Hubungan --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Kategori Hubungan <span class="text-danger">*</span></label>
                @php
                  $kategoriOptions = ['Alumni', 'Mahasiswa', 'Mitra Industri', 'Dosen & Staff', 'Industri / Perusahaan', 'Pengguna Lulusan / Stakeholder'];
                  $oldKategori = old('kategori', 'Alumni');
                  $isCustom = $oldKategori && !in_array($oldKategori, $kategoriOptions);
                @endphp
                <select id="kategoriSelect" name="_kategori_select" class="form-select form-select-lg @error('kategori') is-invalid @enderror" style="border-radius: 12px; font-size: 14px;" onchange="handleKategoriChange(this)">
                  <option value="" disabled {{ (!$oldKategori || $isCustom) ? '' : '' }}>-- Pilih Kategori --</option>
                  <option value="Alumni" {{ $oldKategori == 'Alumni' ? 'selected' : '' }}>Alumni Prodi Teknik Informatika</option>
                  <option value="Mahasiswa" {{ $oldKategori == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa Aktif</option>
                  <option value="Mitra Industri" {{ $oldKategori == 'Mitra Industri' ? 'selected' : '' }}>Mitra Dunia Usaha & Industri (DUDI)</option>
                  <option value="Dosen & Staff" {{ $oldKategori == 'Dosen & Staff' ? 'selected' : '' }}>Dosen & Tenaga Kependidikan</option>
                  <option value="Industri / Perusahaan" {{ $oldKategori == 'Industri / Perusahaan' ? 'selected' : '' }}>Industri / Perusahaan</option>
                  <option value="Pengguna Lulusan / Stakeholder" {{ $oldKategori == 'Pengguna Lulusan / Stakeholder' ? 'selected' : '' }}>Pengguna Lulusan / Stakeholder</option>
                  <option value="__custom__" {{ $isCustom ? 'selected' : '' }}>✏️ Lainnya (Ketik Sendiri)</option>
                </select>
                {{-- Hidden actual value field --}}
                <input type="hidden" id="kategoriValue" name="kategori" value="{{ $isCustom ? $oldKategori : ($oldKategori ?: 'Alumni') }}">
                {{-- Custom input (shown when Lainnya selected) --}}
                <div id="kategoriCustomWrap" style="margin-top: 8px; display: {{ $isCustom ? 'block' : 'none' }};">
                  <input type="text" id="kategoriCustomInput" class="form-control form-control-lg" placeholder="Contoh: Manufaktur, BUMN, Perbankan, IT Konsultan..." value="{{ $isCustom ? $oldKategori : '' }}" style="border-radius: 12px; font-size: 14px; border-color: #dee2e6;" oninput="document.getElementById('kategoriValue').value = this.value">
                  <div class="small text-muted mt-1"><i class="bi bi-info-circle me-1"></i>Tuliskan kategori Anda secara spesifik.</div>
                </div>
                @error('kategori')
                  <div class="invalid-feedback" style="display:block;">{{ $message }}</div>
                @enderror
              </div>

              {{-- Rating Bintang --}}
              <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Tingkat Kepuasan (Rating) <span class="text-danger">*</span></label>
                <select name="bintang" class="form-select form-select-lg @error('bintang') is-invalid @enderror" required style="border-radius: 12px; font-size: 14px;">
                  <option value="5" {{ old('bintang', 5) == 5 ? 'selected' : '' }}>★★★★★ (5 Bintang - Sangat Puas)</option>
                  <option value="4" {{ old('bintang') == 4 ? 'selected' : '' }}>★★★★☆ (4 Bintang - Puas)</option>
                  <option value="3" {{ old('bintang') == 3 ? 'selected' : '' }}>★★★☆☆ (3 Bintang - Cukup)</option>
                  <option value="2" {{ old('bintang') == 2 ? 'selected' : '' }}>★★☆☆☆ (2 Bintang - Kurang)</option>
                  <option value="1" {{ old('bintang') == 1 ? 'selected' : '' }}>★☆☆☆☆ (1 Bintang - Sangat Kurang)</option>
                </select>
                @error('bintang')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Pesan Ulasan --}}
              <div class="col-12">
                <label class="form-label fw-semibold text-dark">Pesan, Ulasan & Testimoni Anda <span class="text-danger">*</span></label>
                <textarea name="pesan" rows="5" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tuliskan pengalaman belajar, suasana perkuliahan di Teknik Informatika, bimbingan para dosen, laboratorium, atau kemudahan berkarir setelah lulus..." required style="border-radius: 12px; font-size: 14px;">{{ old('pesan') }}</textarea>
                @error('pesan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Verifikasi Keamanan (CAPTCHA) --}}
              <div class="col-12 mt-3">
                <div class="p-3 rounded-4 border d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #fffdf2; border-color: #f9dc4b !important;">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #000000; color: #f9dc4b;">
                      <i class="bi bi-shield-lock-fill fs-5"></i>
                    </div>
                    <div>
                      <label for="captcha_answer" class="form-label fw-bold text-dark mb-0" style="font-size: 14px;">
                        Verifikasi Keamanan (CAPTCHA) <span class="text-danger">*</span>
                      </label>
                      <div class="small text-muted">
                        Berapa hasil dari <strong class="text-dark fs-6 px-2 py-0 rounded" style="background: #f9dc4b;">{{ $captchaQuestion ?? session('testimonial_captcha_question', '3 + 4') }}</strong> ?
                      </div>
                    </div>
                  </div>
                  <div style="min-width: 150px; flex: 0 1 180px;">
                    <input type="number"
                           id="captcha_answer"
                           name="captcha_answer"
                           class="form-control form-control-lg text-center fw-bold @error('captcha_answer') is-invalid @enderror"
                           placeholder="Hasil angka"
                           required
                           autocomplete="off"
                           style="border-radius: 12px; font-size: 15px;">
                    @error('captcha_answer')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              {{-- Tombol Kirim --}}
              <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-primary-hero px-5 py-3 shadow" style="cursor: pointer; border-radius: 30px; font-size: 15px;">
                  <i class="bi bi-send-fill me-2"></i> Kirim Testimoni Saya
                </button>
              </div>

            </div>
          </form>

          <div class="text-center mt-4 pt-3 border-top" style="border-color: #f2e9f7 !important;">
            <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Login Portal
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  function handleKategoriChange(selectEl) {
    const val = selectEl.value;
    const hiddenInput  = document.getElementById('kategoriValue');
    const customWrap   = document.getElementById('kategoriCustomWrap');
    const customInput  = document.getElementById('kategoriCustomInput');

    if (val === '__custom__') {
      customWrap.style.display = 'block';
      customInput.focus();
      hiddenInput.value = customInput.value || '';
    } else {
      customWrap.style.display = 'none';
      customInput.value = '';
      hiddenInput.value = val;
    }
  }

  // Sync on page load (for validation errors)
  document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('kategoriSelect');
    if (sel) handleKategoriChange(sel);
  });
</script>
@endpush
