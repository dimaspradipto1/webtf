@extends('layouts.frontend.template')

@section('title', 'Profil Pimpinan & Program Studi — Teknik Informatika')
@section('meta_description', 'Profil Pimpinan dan Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')
@section('meta_keywords', 'profil pimpinan teknik informatika, fakultas sains dan teknologi, program studi teknik informatika')

@section('content')
@php
  $cleanWa = '';
  if (!empty($contact->no_wa)) {
      $cleanWa = preg_replace('/[^0-9]/', '', $contact->no_wa);
      if (strpos($cleanWa, '08') === 0) {
          $cleanWa = '628' . substr($cleanWa, 2);
      }
  }
@endphp

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'pimpinan',
    'parentUrl' => route('homepage.tentang'),
    'parentLabel' => 'Profil',
    'defaultJudul' => 'Profil Pimpinan Program Studi',
    'defaultSubjudul' => 'Mengenal jajaran pimpinan dan pengelola akademik Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
    'defaultBreadcrumb' => 'Profil Pimpinan'
])

<!-- ═══════════════════════════════════════════════
     PROFIL PIMPINAN
═══════════════════════════════════════════════ -->
<section class="section-bg-white py-5">
  <div class="container">
    {{-- DAFTAR PROFIL PIMPINAN --}}
    @if(isset($pimpinansByBaris) && $pimpinansByBaris->count() > 0)
      <div>
        <div class="text-center mb-5" data-aos="fade-up">
          <div class="section-label mx-auto">Jajaran Pimpinan</div>
          <h2 class="section-title">Profil <em>Pimpinan</em></h2>
          <div class="divider-line centered"></div>
        </div>

        <div class="d-flex flex-column gap-5">
          @foreach($pimpinansByBaris as $baris => $items)
            <div class="row justify-content-center g-4 g-lg-5" data-aos="fade-up">
              @php
                $colClass = $items->count() <= 2 ? 'col-lg-5 col-md-6' : 'col-lg-4 col-md-6';
              @endphp
              @foreach($items as $pimpinan)
                <div class="{{ $colClass }} text-center">
                  <div class="d-flex flex-column align-items-center h-100">
                    {{-- Foto Pimpinan Full Tanpa Card Bingkai --}}
                    <div class="mb-3" style="width: 100%; max-width: 245px;">
                      @if($pimpinan->foto)
                        <img src="{{ asset('storage/' . $pimpinan->foto) }}"
                             alt="{{ $pimpinan->nama }}"
                             style="width: 100%; height: auto; display: block; margin: 0 auto; border: none !important; box-shadow: none !important; background: transparent !important;">
                      @else
                        <div class="d-flex flex-column align-items-center justify-content-center mx-auto"
                             style="width: 230px; height: 320px; background: #143622; color: #ffffff;">
                          <i class="bi bi-person-fill" style="font-size: 72px; color: #f9dc4b;"></i>
                          <span class="small fw-semibold px-2 text-center mt-2">{{ $pimpinan->nama }}</span>
                        </div>
                      @endif
                    </div>

                    {{-- Nama & Jabatan --}}
                    <h4 class="fw-bold mb-1" style="font-size: 16.5px; color: #334155; font-family: 'Plus Jakarta Sans', sans-serif;">
                      {{ $pimpinan->nama }}
                    </h4>
                    <div class="mb-3" style="font-size: 14.5px; color: #475569;">
                      {{ $pimpinan->jabatan }}
                    </div>

                    {{-- Tombol Lihat Profil --}}
                    <a href="{{ route('homepage.pimpinan.detail', $pimpinan->slug) }}"
                       class="d-inline-flex align-items-center justify-content-center fw-bold text-decoration-none"
                       style="background-color: #0f172a; color: #ffffff; font-size: 13.5px; padding: 7px 22px; border-radius: 999px; transition: all 0.2s ease;">
                      Lihat Profil
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

@endsection
