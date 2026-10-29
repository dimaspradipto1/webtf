@extends('layouts.frontend.template')

@section('title', ($pmb->judul_hero ?: 'Informasi Penerimaan Mahasiswa Baru (PMB)') . ' — Teknik Informatika UIS')
@section('meta_description', 'Informasi resmi Penerimaan Mahasiswa Baru (PMB) FST UIS tahun akademik 2026/2027. Jadwal pendaftaran, rincian biaya kuliah, brosur, dan alur pendaftaran.')

@section('content')

<!-- ═══════════════════════════════════════════════════════════
     HERO BANNER PMB FST UIS (FULL WIDTH)
═══════════════════════════════════════════════════════════ -->
@if(!empty($pmb->banner_hero))
  {{-- Fullwidth Custom Uploaded Banner Image --}}
  <section class="pmb-hero-section p-0 m-0 w-100 position-relative overflow-hidden" style="background: #063122;">
    <div class="w-100 p-0 m-0">
      <img src="{{ asset('storage/' . $pmb->banner_hero) }}" 
           alt="{{ $pmb->judul_hero }}" 
           class="w-100 d-block" 
           style="width: 100%; height: auto; display: block; object-fit: contain;">
    </div>
  </section>
@else
  {{-- Beautiful Default Hero matching Screenshot --}}
  <section class="pmb-hero-section py-4 py-lg-5" style="background: #063122; color: #ffffff;">
    <div class="container">
      <div class="pmb-hero-card p-4 p-md-5 rounded-4 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #073826 0%, #0d5239 50%, #063122 100%); border: 1px solid rgba(249, 220, 75, 0.3);">
        <div class="row align-items-center g-4">
          <div class="col-lg-8">
            <div class="d-flex flex-wrap gap-2 mb-3">
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #dc3545; font-size: 12px;">
                <i class="bi bi-broadcast me-1"></i> Pendaftaran Dibuka
              </span>
              <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #f9dc4b; color: #000000; font-size: 12px;">
                Gelombang 1
              </span>
              <span class="badge px-3 py-2 rounded-pill fw-semibold bg-white text-dark" style="font-size: 12px;">
                Kelas Reguler & Karyawan
              </span>
            </div>
            
            <h1 class="fw-bolder display-6 text-white mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.5px;">
              {{ $pmb->judul_hero ?: 'Penerimaan Mahasiswa Baru FST UIS 2026' }}
            </h1>
            <p class="fs-5 text-warning fw-semibold mb-4" style="color: #f9dc4b !important;">
              {{ $pmb->subjudul_hero ?: 'Tahun Akademik 2026/2027' }}
            </p>

            <div class="d-flex flex-wrap align-items-center gap-3">
              <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" rel="noopener noreferrer" class="btn px-4 py-2 fw-bold rounded-pill text-dark shadow" style="background: #f9dc4b; font-size: 15px;">
                <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
              </a>
              @if(!empty($pmb->no_whatsapp))
                <a href="https://wa.me/{{ $cleanWa }}?text=Halo%20Admin%20PMB%20FST%20UIS,%20saya%20ingin%20konsultasi%20pendaftaran" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light px-4 py-2 fw-bold rounded-pill" style="font-size: 15px;">
                  <i class="bi bi-whatsapp text-success me-1"></i> Tanya Admin PMB
                </a>
              @endif
              <a href="#brosur" class="btn btn-link text-white-50 text-decoration-none small">
                <i class="bi bi-arrow-down-circle me-1"></i> Lihat Brosur & Biaya
              </a>
            </div>
          </div>

          <div class="col-lg-4 text-center text-lg-end">
            <div class="d-inline-block p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-25 backdrop-blur text-center">
              <div class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2 fw-bold" style="font-size: 11px;">
                <i class="bi bi-qr-code-scan me-1"></i> Portal PMB Online
              </div>
              <div class="bg-white p-2 rounded-3 d-inline-block shadow-sm mb-2">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode($pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id') }}" alt="QR Code PMB" width="120" height="120" class="img-fluid">
              </div>
              <div class="text-white small fw-bold font-monospace">pmb.uis.ac.id</div>
              @if(!empty($pmb->no_whatsapp))
                <div class="text-white-50 small mt-1"><i class="bi bi-telephone me-1"></i>{{ $pmb->no_whatsapp }}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif

<!-- ═══════════════════════════════════════════════════════════
     STICKY QUICK NAVIGATION BAR
═══════════════════════════════════════════════════════════ -->
<nav class="pmb-quicknav sticky-top bg-white border-bottom shadow-sm" style="z-index: 1020;">
  <div class="container">
    <div class="d-flex align-items-center justify-content-start justify-content-md-center overflow-auto py-2 gap-2" style="white-space: nowrap;">
      <a href="#brosur" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-file-earmark-image me-1"></i> Brosur PMB
      </a>
      <a href="#keunggulan" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-patch-check-fill me-1"></i> Keunggulan FST UIS
      </a>
      <a href="#jadwal" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-calendar-event me-1"></i> Jadwal PMB 2026
      </a>
      <a href="#biaya" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-cash-stack me-1"></i> Jenis Biaya
      </a>
      <a href="#kelas" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-layers-fill me-1"></i> Kelas PMB
      </a>
      <a href="#alur" class="btn btn-sm btn-pmb-nav">
        <i class="bi bi-diagram-3 me-1"></i> Alur Pendaftaran
      </a>
      <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn btn-sm fw-bold px-3 ms-md-2" style="background: #000000; color: #f9dc4b; border-radius: 20px;">
        <i class="bi bi-pencil-square me-1"></i> Daftar Online
      </a>
    </div>
  </div>
</nav>

<div class="container py-5">

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 1: BROSUR PMB FST UIS
  ═══════════════════════════════════════════════════════════ -->
  <section id="brosur" class="pmb-section mb-5 pt-3">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0;">
      <div class="card-header bg-white py-3 border-bottom text-center">
        <span class="badge px-4 py-2 rounded-pill fw-bold fs-6" style="background: #073826; color: #ffffff;">
          <i class="bi bi-file-earmark-richtext me-2 text-warning"></i>Brosur PMB FST UIS 2026
        </span>
      </div>
      <div class="card-body p-4 text-center">
        @if(!empty($pmb->brosur_gambar))
          <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $pmb->brosur_gambar) }}" alt="Brosur PMB FST UIS" class="img-fluid rounded-3 shadow border" style="max-height: 850px; width: auto; max-width: 100%;">
          </div>
        @else
          {{-- Mockup Brosur Elegan jika belum upload gambar brosur --}}
          <div class="p-4 p-md-5 rounded-4 mx-auto mb-4 border" style="max-width: 780px; background: linear-gradient(180deg, #fefefb 0%, #f6f8f5 100%);">
            <div class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2 fw-bold">FAKULTAS SAINS & TEKNOLOGI UIS</div>
            <h3 class="fw-bold text-dark mb-2">Brosur Resmi Penerimaan Mahasiswa Baru 2026/2027</h3>
            <p class="text-muted small mb-4">Dapatkan rincian program studi, prospek karir lulusan, beasiswa, dan kurikulum OBE Teknik Informatika.</p>
            <div class="p-3 bg-white rounded-3 shadow-sm d-inline-block border mb-3">
              <i class="bi bi-file-earmark-pdf-fill text-danger display-3 d-block mb-2"></i>
              <div class="fw-bold text-dark">Brosur-PMB-FST-UIS-2026.pdf</div>
              <small class="text-muted">Format Berkas Digital Resmi</small>
            </div>
          </div>
        @endif

        @if(!empty($pmb->brosur_pdf))
          <div>
            <a href="{{ asset('storage/' . $pmb->brosur_pdf) }}" target="_blank" rel="noopener noreferrer" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
              <i class="bi bi-download me-1"></i> Download Brosur (PDF)
            </a>
          </div>
        @endif
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 2: KEUNGGULAN FST UIS & AKREDITASI
  ═══════════════════════════════════════════════════════════ -->
  <section id="keunggulan" class="pmb-section mb-5 pt-3">
    <!-- Akreditasi Banner -->
    <div class="p-4 p-md-5 rounded-4 mb-4 shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #0a4d35 0%, #157347 100%); color: #ffffff;">
      <div class="row align-items-center g-4">
        <div class="col-md-4 text-center">
          <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-lg border border-3 border-warning" style="width: 140px; height: 140px; background: radial-gradient(circle, #f9dc4b 0%, #c99c15 100%); color: #000000;">
            <div class="text-center">
              <i class="bi bi-patch-check-fill d-block fs-3"></i>
              <span class="display-5 fw-black fw-bolder lh-1">{{ $pmb->akreditasi_predikat ?: 'B' }}</span>
              <div class="small fw-bold text-uppercase" style="font-size: 11px;">BAN-PT</div>
            </div>
          </div>
        </div>
        <div class="col-md-8 text-center text-md-start">
          <div class="badge bg-warning text-dark px-3 py-1 rounded-pill mb-2 fw-bold">MUTU TERJAMIN</div>
          <h2 class="fw-bold text-white mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $pmb->akreditasi_teks ?: 'Mutu Sangat Baik Terakreditasi dengan Predikat "B" oleh BAN-PT' }}
          </h2>
          <p class="text-white-50 mb-0">Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi UIS berkomitmen menghadirkan kurikulum berbasis kompetensi industri dan fasilitas laboratorium komputasi modern.</p>
        </div>
      </div>
    </div>

    <!-- 8 Poin Keunggulan Grid -->
    <div class="row g-3">
      @php
        $features = $pmb->keunggulan_items ?: [
            ['judul' => 'Biaya Kuliah', 'deskripsi' => 'Biaya terjangkau dengan skema cicilan bulanan yang ringan untuk mahasiswa.', 'icon' => 'bi-cash-coin'],
            ['judul' => 'Lokasi Kampus', 'deskripsi' => 'Lokasi kampus strategis di pusat kota Batam, mudah dijangkau transportasi umum.', 'icon' => 'bi-geo-alt-fill'],
            ['judul' => 'Dosen Berpengalaman', 'deskripsi' => 'Dosen berkualifikasi S2 dan S3 lulusan universitas terkemuka dalam dan luar negeri.', 'icon' => 'bi-person-workspace'],
            ['judul' => 'Pengembangan Bakat', 'deskripsi' => 'Didukung berbagai UKM kemahasiswaan, komunitas riset AI, coding, dan robotika.', 'icon' => 'bi-trophy-fill'],
            ['judul' => 'Waktu Kuliah', 'deskripsi' => 'Tersedia pilihan kelas pagi untuk reguler dan kelas sore/malam untuk yang bekerja.', 'icon' => 'bi-clock-fill'],
            ['judul' => 'Fasilitas', 'deskripsi' => 'Laboratorium komputer modern ber-AC, koneksi internet berkecepatan tinggi.', 'icon' => 'bi-laptop'],
            ['judul' => 'Beasiswa', 'deskripsi' => 'Tersedia Beasiswa KIP-Kuliah, Yayasan, Beasiswa Prestasi, BPDDI, dan kemitraan.', 'icon' => 'bi-award-fill'],
            ['judul' => 'Fasilitas Pendukung', 'deskripsi' => 'Perpustakaan digital terpadu, aula serbaguna, musholla, dan area parkir luas.', 'icon' => 'bi-buildings-fill'],
        ];
      @endphp
      @foreach($features as $idx => $f)
        <div class="col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 p-3 hover-lift" style="background: #ffffff; border: 1px solid #edf2f7 !important;">
            <div class="d-flex align-items-start gap-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 46px; height: 46px; background: #073826;">
                <i class="bi {{ $f['icon'] ?? 'bi-check-circle-fill' }} fs-5"></i>
              </div>
              <div>
                <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ $f['judul'] }}</h6>
                <p class="text-muted small mb-0" style="line-height: 1.5;">{{ $f['deskripsi'] }}</p>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 3: JADWAL PMB FST UIS 2026
  ═══════════════════════════════════════════════════════════ -->
  <section id="jadwal" class="pmb-section mb-5 pt-3">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0;">
      <div class="card-header bg-white py-3 border-bottom text-center">
        <span class="badge px-4 py-2 rounded-pill fw-bold fs-6" style="background: #073826; color: #ffffff;">
          <i class="bi bi-calendar-check-fill me-2 text-warning"></i>JADWAL PMB FST UIS 2026
        </span>
      </div>
      <div class="card-body p-4 text-center">
        @if(!empty($pmb->jadwal_gambar))
          <img src="{{ asset('storage/' . $pmb->jadwal_gambar) }}" alt="Jadwal PMB FST UIS 2026" class="img-fluid rounded-3 shadow border" style="max-height: 700px; width: auto; max-width: 100%;">
        @else
          {{-- Fallback Tabel Jadwal Gelombang --}}
          <div class="table-responsive">
            <table class="table table-bordered align-middle text-start mb-0">
              <thead style="background: #073826; color: #ffffff;">
                <tr>
                  <th class="text-center" style="width: 60px;">No</th>
                  <th>Gelombang Pendaftaran</th>
                  <th>Periode Pendaftaran</th>
                  <th>Ujian / Seleksi Masuk</th>
                  <th>Pengumuman Hasil</th>
                  <th>Registrasi Ulang</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center fw-bold">1</td>
                  <td class="fw-bold text-primary">Gelombang 1 (Early Bird / Beasiswa)</td>
                  <td>02 Januari &mdash; 30 April 2026</td>
                  <td>Setiap Sabtu</td>
                  <td>3 Hari Setelah Tes</td>
                  <td>Maks. 14 Hari</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">2</td>
                  <td class="fw-bold text-success">Gelombang 2 (Reguler)</td>
                  <td>01 Mei &mdash; 31 Juli 2026</td>
                  <td>Setiap Sabtu</td>
                  <td>3 Hari Setelah Tes</td>
                  <td>Maks. 14 Hari</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">3</td>
                  <td class="fw-bold text-warning">Gelombang 3 (Gelombang Terakhir)</td>
                  <td>01 Agustus &mdash; 25 September 2026</td>
                  <td>Setiap Sabtu</td>
                  <td>3 Hari Setelah Tes</td>
                  <td>Maks. 7 Hari</td>
                </tr>
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 4: JENIS BIAYA
  ═══════════════════════════════════════════════════════════ -->
  <section id="biaya" class="pmb-section mb-5 pt-3">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0;">
      <div class="card-header bg-white py-3 border-bottom text-center">
        <span class="badge px-4 py-2 rounded-pill fw-bold fs-6" style="background: #073826; color: #ffffff;">
          <i class="bi bi-cash-stack me-2 text-warning"></i>JENIS BIAYA
        </span>
      </div>
      <div class="card-body p-4 text-center">
        @if(!empty($pmb->biaya_gambar))
          <img src="{{ asset('storage/' . $pmb->biaya_gambar) }}" alt="Jenis Biaya PMB FST UIS" class="img-fluid rounded-3 shadow border" style="max-height: 700px; width: auto; max-width: 100%;">
        @else
          {{-- Fallback Infografis Biaya --}}
          <div class="row g-3 text-start">
            <div class="col-md-4">
              <div class="p-4 rounded-4 border bg-light h-100">
                <div class="badge bg-secondary mb-2">BIAYA REGISTRASI</div>
                <h5 class="fw-bold text-dark">Formulir Pendaftaran</h5>
                <h4 class="fw-bold text-success mb-2">Rp 250.000</h4>
                <p class="text-muted small mb-0">Biaya satu kali saat pendaftaran akun online dan verifikasi berkas awal.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-4 rounded-4 border bg-light h-100">
                <div class="badge bg-primary mb-2">SPP / BIAYA KULIAH</div>
                <h5 class="fw-bold text-dark">SPP Bulanan Fleksibel</h5>
                <h4 class="fw-bold text-success mb-2">Mulai Rp 625.000<small class="fs-6 text-muted">/bln</small></h4>
                <p class="text-muted small mb-0">Dapat diangsur per bulan atau per semester tanpa denda memberatkan.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-4 rounded-4 border bg-light h-100">
                <div class="badge bg-warning text-dark mb-2">PRAKTIKUM & SARANA</div>
                <h5 class="fw-bold text-dark">Jas, KTM, & Praktikum</h5>
                <h4 class="fw-bold text-success mb-2">All-in Terpadu</h4>
                <p class="text-muted small mb-0">Mencakup pemakaian laboratorium komputer, perpustakaan, WiFi, dan fasilitas kampus.</p>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 5: KELAS PMB (3 PILIHAN KELAS)
  ═══════════════════════════════════════════════════════════ -->
  <section id="kelas" class="pmb-section mb-5 pt-3">
    <div class="text-center mb-4">
      <h3 class="fw-bold text-dark" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kelas PMB</h3>
      <p class="text-muted small">Pilihan kelas perkuliahan fleksibel sesuai kebutuhan Anda.</p>
    </div>

    @php
      $isBestB = (bool)($pmb->reguler_b_is_best ?? true);
      $isBestA = (bool)($pmb->reguler_a_is_best ?? false);
      $isBestC = (bool)($pmb->reguler_c_is_best ?? false);
    @endphp

    <div class="row g-4 justify-content-center">
      <!-- Reguler B -->
      <div class="col-lg-4 col-md-6 order-md-1 order-lg-1">
        <div class="pmb-pricing-card rounded-4 p-4 text-white position-relative {{ $isBestB ? 'shadow-lg' : 'shadow' }} h-100 d-flex flex-column" 
             style="background: {{ $isBestB ? 'linear-gradient(180deg, #360f0f 0%, #1f0606 100%)' : 'linear-gradient(180deg, #2b0b0b 0%, #170404 100%)' }}; border: {{ $isBestB ? '2px solid #f9dc4b' : '1px solid rgba(255, 255, 255, 0.1)' }};">
          @if($isBestB)
            <div class="badge-ribbon position-absolute top-0 end-0 mt-3 me-3">
              <span class="badge px-3 py-1 rounded-pill fw-bold text-dark" style="background: #f9dc4b; font-size: 11px;">
                <i class="bi bi-star-fill text-dark me-1"></i> Best Choice
              </span>
            </div>
          @endif
          <div class="mb-3">
            <h5 class="fw-bold mb-1" style="{{ $isBestB ? 'color: #f9dc4b !important;' : '' }}">{{ $pmb->reguler_b_nama ?: 'Reguler B' }}</h5>
            <div class="display-6 fw-bold text-white mb-0">{{ $pmb->reguler_b_biaya ?: 'Rp 625.000' }}</div>
            <small class="text-white-50">per bulan</small>
          </div>
          <hr class="border-secondary opacity-25">
          <ul class="list-unstyled mb-4 flex-grow-1">
            @php
              $linesB = explode("\n", $pmb->reguler_b_keterangan ?: "Uang Kuliah Terjangkau\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa");
            @endphp
            @foreach($linesB as $line)
              @if(!empty(trim($line)))
                <li class="d-flex align-items-center gap-2 mb-2 small text-light">
                  <i class="bi bi-check-circle-fill text-warning flex-shrink-0" style="color: #f9dc4b !important;"></i>
                  <span>{{ trim($line) }}</span>
                </li>
              @endif
            @endforeach
          </ul>
          @if($isBestB)
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn w-100 fw-bold py-2 rounded-pill shadow-sm" style="background: #f9dc4b; color: #000000;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @else
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn btn-outline-warning w-100 fw-bold py-2 rounded-pill" style="color: #f9dc4b; border-color: #f9dc4b;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @endif
        </div>
      </div>

      <!-- Reguler A -->
      <div class="col-lg-4 col-md-6 order-md-2 order-lg-2">
        <div class="pmb-pricing-card rounded-4 p-4 text-white position-relative {{ $isBestA ? 'shadow-lg' : 'shadow' }} h-100 d-flex flex-column" 
             style="background: {{ $isBestA ? 'linear-gradient(180deg, #360f0f 0%, #1f0606 100%)' : 'linear-gradient(180deg, #2b0b0b 0%, #170404 100%)' }}; border: {{ $isBestA ? '2px solid #f9dc4b' : '1px solid rgba(255, 255, 255, 0.1)' }};">
          @if($isBestA)
            <div class="badge-ribbon position-absolute top-0 end-0 mt-3 me-3">
              <span class="badge px-3 py-1 rounded-pill fw-bold text-dark" style="background: #f9dc4b; font-size: 11px;">
                <i class="bi bi-star-fill text-dark me-1"></i> Best Choice
              </span>
            </div>
          @endif
          <div class="mb-3">
            <h5 class="fw-bold mb-1" style="{{ $isBestA ? 'color: #f9dc4b !important;' : '' }}">{{ $pmb->reguler_a_nama ?: 'Reguler A' }}</h5>
            <div class="display-6 fw-bold text-white mb-0">{{ $pmb->reguler_a_biaya ?: 'Rp 825.000' }}</div>
            <small class="text-white-50">per bulan (Kelas Pagi Utama)</small>
          </div>
          <hr class="border-secondary opacity-25">
          <ul class="list-unstyled mb-4 flex-grow-1">
            @php
              $linesA = explode("\n", $pmb->reguler_a_keterangan ?: "Kelas Pagi / Reguler Utama\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa");
            @endphp
            @foreach($linesA as $line)
              @if(!empty(trim($line)))
                <li class="d-flex align-items-center gap-2 mb-2 small text-light">
                  <i class="bi bi-check-circle-fill text-warning flex-shrink-0" style="color: #f9dc4b !important;"></i>
                  <span>{{ trim($line) }}</span>
                </li>
              @endif
            @endforeach
          </ul>
          @if($isBestA)
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn w-100 fw-bold py-2 rounded-pill shadow-sm" style="background: #f9dc4b; color: #000000;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @else
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn btn-outline-warning w-100 fw-bold py-2 rounded-pill" style="color: #f9dc4b; border-color: #f9dc4b;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @endif
        </div>
      </div>

      <!-- Reguler C -->
      <div class="col-lg-4 col-md-6 order-md-3 order-lg-3">
        <div class="pmb-pricing-card rounded-4 p-4 text-white position-relative {{ $isBestC ? 'shadow-lg' : 'shadow' }} h-100 d-flex flex-column" 
             style="background: {{ $isBestC ? 'linear-gradient(180deg, #360f0f 0%, #1f0606 100%)' : 'linear-gradient(180deg, #2b0b0b 0%, #170404 100%)' }}; border: {{ $isBestC ? '2px solid #f9dc4b' : '1px solid rgba(255, 255, 255, 0.1)' }};">
          @if($isBestC)
            <div class="badge-ribbon position-absolute top-0 end-0 mt-3 me-3">
              <span class="badge px-3 py-1 rounded-pill fw-bold text-dark" style="background: #f9dc4b; font-size: 11px;">
                <i class="bi bi-star-fill text-dark me-1"></i> Best Choice
              </span>
            </div>
          @endif
          <div class="mb-3">
            <h5 class="fw-bold mb-1" style="{{ $isBestC ? 'color: #f9dc4b !important;' : '' }}">{{ $pmb->reguler_c_nama ?: 'Reguler C' }}</h5>
            <div class="display-6 fw-bold text-white mb-0">{{ $pmb->reguler_c_biaya ?: 'Rp 925.000' }}</div>
            <small class="text-white-50">per bulan (Karyawan / Eksekutif)</small>
          </div>
          <hr class="border-secondary opacity-25">
          <ul class="list-unstyled mb-4 flex-grow-1">
            @php
              $linesC = explode("\n", $pmb->reguler_c_keterangan ?: "Kelas Malam / Karyawan Fleksibel\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa");
            @endphp
            @foreach($linesC as $line)
              @if(!empty(trim($line)))
                <li class="d-flex align-items-center gap-2 mb-2 small text-light">
                  <i class="bi bi-check-circle-fill text-warning flex-shrink-0" style="color: #f9dc4b !important;"></i>
                  <span>{{ trim($line) }}</span>
                </li>
              @endif
            @endforeach
          </ul>
          @if($isBestC)
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn w-100 fw-bold py-2 rounded-pill shadow-sm" style="background: #f9dc4b; color: #000000;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @else
            <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" class="btn btn-outline-warning w-100 fw-bold py-2 rounded-pill" style="color: #f9dc4b; border-color: #f9dc4b;">
              Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 6: ALUR PENDAFTARAN
  ═══════════════════════════════════════════════════════════ -->
  <section id="alur" class="pmb-section mb-5 pt-3">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0;">
      <div class="card-header bg-white py-3 border-bottom text-center">
        <span class="badge px-4 py-2 rounded-pill fw-bold fs-6" style="background: #073826; color: #ffffff;">
          <i class="bi bi-diagram-3-fill me-2 text-warning"></i>Alur Pendaftaran PMB
        </span>
      </div>
      <div class="card-body p-4 text-center">
        @if(!empty($pmb->alur_gambar))
          <img src="{{ asset('storage/' . $pmb->alur_gambar) }}" alt="Alur Pendaftaran PMB FST UIS" class="img-fluid rounded-3 shadow border" style="max-height: 700px; width: auto; max-width: 100%;">
        @else
          {{-- Fallback Infografis Alur 9 Langkah --}}
          <div class="p-4 rounded-4 text-white text-start shadow" style="background: linear-gradient(135deg, #2b0707 0%, #1a0404 100%);">
            <div class="row align-items-center g-4">
              <div class="col-lg-5 text-center">
                <div class="rounded-4 overflow-hidden shadow-sm border border-secondary">
                  <img src="{{ asset('assets/img/logouis.png') }}" alt="Gedung Kampus UIS" class="img-fluid p-4" style="max-height: 220px; object-fit: contain;">
                </div>
                <div class="badge bg-warning text-dark mt-3 px-3 py-2 rounded-pill fw-bold">PROSES MUDAH & CEPAT</div>
              </div>
              <div class="col-lg-7">
                <h4 class="fw-bold text-warning mb-3" style="color: #f9dc4b !important;">9 Tahapan Alur Pendaftaran Online:</h4>
                <div class="row g-2">
                  @php
                    $steps = [
                      '1. Login akun pmb.uis.ac.id',
                      '2. Input Data Pendaftaran',
                      '3. Upload Syarat Pendaftaran',
                      '4. Verifikasi Pendaftaran',
                      '5. Proses Seleksi Pendaftar',
                      '6. Pengumuman Kelulusan',
                      '7. Pembayaran Daftar Ulang',
                      '8. Upload Berkas Daftar Ulang',
                      '9. Informasi NIM Mahasiswa',
                    ];
                  @endphp
                  @foreach($steps as $s)
                    <div class="col-12 col-md-6">
                      <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white bg-opacity-10 border border-white border-opacity-10">
                        <i class="bi bi-check2-circle text-warning fs-5" style="color: #f9dc4b !important;"></i>
                        <span class="small fw-semibold text-white">{{ $s }}</span>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>

  <!-- ═══════════════════════════════════════════════════════════
       SECTION 7: BANNER CTA BAWAH
  ═══════════════════════════════════════════════════════════ -->
  <section class="pmb-cta-section mb-4">
    @if(!empty($pmb->banner_cta))
      <div class="rounded-4 overflow-hidden shadow-lg border">
        <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" rel="noopener noreferrer">
          <img src="{{ asset('storage/' . $pmb->banner_cta) }}" alt="Daftar Sekarang PMB FST UIS" class="w-100 img-fluid">
        </a>
      </div>
    @else
      <div class="p-4 p-md-5 rounded-4 shadow-lg text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #0d3b66 0%, #001f3f 100%); border: 1px solid rgba(255, 255, 255, 0.15);">
        <div class="position-relative" style="z-index: 2;">
          <h2 class="display-6 fw-bolder mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            {{ $pmb->cta_judul ?: 'Jadilah Bagian Dari Fakultas Sains Dan Teknologi UIS' }}
          </h2>
          <p class="fs-5 text-white-50 mb-4">
            {{ $pmb->cta_subjudul ?: 'Pendaftaran Telah Dibuka Sekarang' }}
          </p>
          <a href="{{ $pmb->link_pendaftaran ?: 'https://pmb.uis.ac.id' }}" target="_blank" rel="noopener noreferrer" class="btn px-5 py-3 fw-bold rounded-pill shadow-lg text-dark" style="background: #f9dc4b; font-size: 16px;">
            <i class="bi bi-pencil-square me-2"></i> Daftar Sekarang
          </a>
        </div>
      </div>
    @endif
  </section>

</div>

@push('styles')
<style>
  html {
    scroll-behavior: smooth;
  }
  .btn-pmb-nav {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: #073826;
    background: #edf7f2;
    border-radius: 20px;
    padding: 6px 14px;
    transition: all 0.2s ease;
  }
  .btn-pmb-nav:hover,
  .btn-pmb-nav:focus {
    background: #073826;
    color: #ffffff;
  }
  .hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
  }
  .pmb-section {
    scroll-margin-top: 70px;
  }
</style>
@endpush

@endsection

