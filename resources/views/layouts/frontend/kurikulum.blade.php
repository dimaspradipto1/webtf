@extends('layouts.frontend.template')

@section('title', ($pageTitle ?? 'Kurikulum Program Studi') . ' — Teknik Informatika')
@section('meta_description', 'Struktur kurikulum lengkap per semester dan unduhan silabus RPS program studi Teknik Informatika (UIS) Teknik Informatika.')

@section('content')
@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'kurikulum',
    'parentLabel' => 'Akademik',
    'defaultJudul' => 'Kurikulum & Capaian Pembelajaran',
    'defaultSubjudul' => 'Struktur kurikulum berbasis kompetensi dan Outcome-Based Education (OBE) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
    'defaultBreadcrumb' => 'Kurikulum'
])

<section class="section-bg-sand py-5">
  <div class="container py-3">

    <!-- Prodi Selector Tabs -->
    @if(isset($prodis) && $prodis->count() > 0)
      <div class="prodi-tab-nav" data-aos="fade-up">
        @foreach($prodis as $p)
          <a href="{{ route('homepage.kurikulum', ['prodi' => $p->id]) }}" class="prodi-tab-btn {{ ($currentProdi->id ?? 0) === $p->id ? 'active' : '' }}">
            <i class="bi bi-mortarboard me-1"></i> {{ $p->judul }}
          </a>
        @endforeach
      </div>
    @endif

    <!-- Header Banner Kuning / Gold Sesuai Permintaan -->
    <div class="text-center" data-aos="fade-up">
      <div class="prodi-header-pill">
        Kurikulum {{ $currentProdi->judul ?? 'Program Studi Teknik Informatika' }}
      </div>
    </div>

    <!-- Summary & Info -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm border" data-aos="fade-up">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="width: 44px; height: 44px; background: #000000;">
          <i class="bi bi-book-half fs-5"></i>
        </div>
        <div>
          <h5 class="fw-bold text-dark mb-0">{{ $currentProdi->judul ?? 'Program Studi' }}</h5>
          <small class="text-muted">Total Beban Studi: <strong>{{ $totalSks }} SKS</strong> &bull; Total Matakuliah: <strong>{{ $totalMatakuliah }} MK</strong></small>
        </div>
      </div>
      <div class="mt-2 mt-md-0">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 12.5px;">
          <i class="bi bi-check-circle-fill me-1"></i> Kurikulum Berlaku 2026/2027
        </span>
      </div>
    </div>

    <!-- Tabel Kurikulum Berkelompok Per Semester -->
    <div class="kurikulum-table-card" data-aos="fade-up">
      <div class="table-responsive">
        <table class="table table-kurikulum">
          <thead>
            <tr>
              <th style="width: 6%;">No</th>
              <th style="width: 16%;">Kode_MK</th>
              <th>Nama Matakuliah</th>
              <th style="width: 10%;">Semester</th>
              <th style="width: 12%;">Jumlah SKS</th>
              <th style="width: 14%;">RPS</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($coursesBySemester) && $coursesBySemester->count() > 0)
              @php
                $romawi = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII'];
              @endphp
              @foreach($coursesBySemester as $sem => $courseList)
                <!-- Heading Semester -->
                <tr class="semester-heading-row">
                  <td colspan="6">
                    <div class="d-flex align-items-center justify-content-between">
                      <span><i class="bi bi-calendar3 me-2 text-primary"></i>SEMESTER {{ $romawi[$sem] ?? $sem }}</span>
                      <span class="badge bg-secondary font-monospace fw-normal" style="font-size: 11px;">
                        Subtotal: {{ $courseList->sum('sks') }} SKS
                      </span>
                    </div>
                  </td>
                </tr>

                @foreach($courseList as $idx => $course)
                  <tr>
                    <td class="text-center fw-semibold text-muted">{{ $idx + 1 }}</td>
                    <td class="text-center font-monospace fw-bold text-dark">{{ $course->kode_mk }}</td>
                    <td>
                      <span class="fw-bold text-dark">{{ $course->nama_mk }}</span>
                      @if($course->kategori && $course->kategori !== 'Wajib')
                        <span class="badge bg-light text-secondary border ms-1" style="font-size: 10px;">{{ $course->kategori }}</span>
                      @endif
                      @if(!empty($course->deskripsi))
                        <small class="text-muted d-block mt-1" style="font-size: 11.5px;">{{ $course->deskripsi }}</small>
                      @endif
                    </td>
                    <td class="text-center fw-bold">{{ $course->semester_romawi }}</td>
                    <td class="text-center">
                      <span class="badge bg-warning text-dark px-2 py-1 fw-bold" style="font-size: 12px;">{{ $course->sks }}</span>
                    </td>
                    <td class="text-center">
                      @if(!empty($course->rps_url))
                        <a href="{{ $course->rps_url }}" target="_blank" class="btn-rps-download" style="white-space: nowrap; display: inline-flex; align-items: center; justify-content: center; gap: 5px;">
                          @if(!empty($course->link_rps) && empty($course->file_rps))
                            <i class="bi bi-box-arrow-up-right"></i> Link RPS
                          @else
                            <i class="bi bi-download"></i> Download RPS
                          @endif
                        </a>
                      @else
                        <button class="btn btn-sm btn-light border text-muted rounded-pill px-3 py-1" style="font-size: 11px; white-space: nowrap;" disabled>
                          <i class="bi bi-file-earmark-text me-1"></i> RPS
                        </button>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @endforeach
            @else
              <tr>
                <td colspan="6" class="text-center py-5">
                  <i class="bi bi-journal-x fs-1 text-muted d-block mb-2"></i>
                  <h6 class="fw-bold text-dark">Data Matakuliah Belum Tersedia</h6>
                  <p class="text-muted small mb-0">Daftar kurikulum untuk program studi ini akan segera diperbarui oleh pimpinan.</p>
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>

{{-- Real-Time Synchronization Listener: Frontend otomatis terupdate saat admin melakukan perubahan --}}
<script>
  (function() {
    let currentChecksum = "{{ $checksum ?? '' }}";
    const checkUrl = "{{ route('homepage.kurikulum.check-updated', ['prodi' => $currentProdi->id ?? '']) }}";

    function checkKurikulumUpdate() {
      fetch(checkUrl, { cache: 'no-store' })
        .then(response => response.json())
        .then(data => {
          if (data && data.checksum && data.checksum !== currentChecksum) {
            currentChecksum = data.checksum;
            // Reload halaman secara otomatis jika ada perubahan data dari admin
            window.location.reload();
          }
        })
        .catch(() => {});
    }

    // Periksa saat pengguna kembali aktif ke tab browser ini
    document.addEventListener('visibilitychange', function() {
      if (document.visibilityState === 'visible') {
        checkKurikulumUpdate();
      }
    });

    window.addEventListener('focus', checkKurikulumUpdate);

    // Polling berkala setiap 6 detik ketika halaman aktif
    setInterval(function() {
      if (document.visibilityState === 'visible') {
        checkKurikulumUpdate();
      }
    }, 6000);
  })();
</script>
@endsection
