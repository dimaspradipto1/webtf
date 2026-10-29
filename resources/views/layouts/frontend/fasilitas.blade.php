@extends('layouts.frontend.template')

@section('title', 'Fasilitas Kampus — Program Studi Teknik Informatika')
@section('meta_description', 'Fasilitas laboratorium komputasi, sarana riset, dan penunjang akademik Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'fasilitas',
    'parentUrl' => route('homepage.tentang'),
    'parentLabel' => 'Profil',
    'defaultJudul' => 'Fasilitas Kampus & Laboratorium',
    'defaultSubjudul' => 'Sarana laboratorium komputasi modern, perpustakaan, ruang kuliah ber-AC, dan fasilitas penunjang akademik Program Studi Teknik Informatika.',
    'defaultBreadcrumb' => 'Fasilitas Kampus'
])

<!-- ═══════════════════════════════════════════════
     DAFTAR FASILITAS & LABORATORIUM
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Sarana & Prasarana Prodi</div>
      <h2 class="section-title">Fasilitas & <em>Laboratorium</em> Teknik Informatika</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Menunjang kegiatan perkuliahan, praktikum rekayasa perangkat lunak, kecerdasan buatan (AI), jaringan komputer, dan riset mahasiswa Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.
      </p>
    </div>

    <div class="row g-4">
      @if(isset($saranas) && $saranas->count() > 0)
        @foreach($saranas as $index => $sarana)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
            <div class="fasilitas-box h-100">
              <div class="fasilitas-icon"><i class="bi {{ $sarana->icon ?? 'bi-pc-display-horizontal' }}"></i></div>
              <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
              <p class="fasilitas-desc">{{ $sarana->deskripsi ?: 'Fasilitas laboratorium dan sarana penunjang akademik mahasiswa Program Studi Teknik Informatika.' }}</p>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted py-5 bg-white rounded-4 shadow-sm">
          <i class="bi bi-buildings fs-1 d-block mb-2"></i>
          Belum ada data fasilitas kampus yang dipublikasikan.
        </div>
      @endif
    </div>
  </div>
</section>

@endsection

