@extends('layouts.frontend.template')

@section('title', 'Agenda & Kegiatan Akademik — Teknik Informatika (UIS)')
@section('meta_description', 'Jadwal kegiatan akademik, masa perkuliahan, semester antara, dan agenda penting Program Studi Teknik Informatika UIS Batam.')
@section('meta_keywords', 'agenda teknik informatika, jadwal akademik uis, kegiatan kampus batam, kalender kegiatan uis')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'agenda',
    'defaultJudul' => 'Agenda & Kegiatan Akademik',
    'defaultSubjudul' => 'Informasi linimasa kegiatan perkuliahan, semester antara, ujian, seminar, dan agenda resmi sivitas akademika Program Studi Teknik Informatika.',
    'defaultBreadcrumb' => 'Agenda & Kegiatan'
])

<section class="section-bg-sand py-5">
  <div class="container py-3">

    {{-- Filter / Search Bar --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-7">
        <form action="{{ route('homepage.agenda') }}" method="GET" class="d-flex align-items-center gap-2 p-1 p-md-2 bg-white rounded-pill shadow-sm border">
          <div class="d-flex align-items-center flex-grow-1 ps-3">
            <i class="bi bi-search text-muted me-2" style="font-size: 15px;"></i>
            <input type="text"
                   name="q"
                   value="{{ $search ?? '' }}"
                   placeholder="Cari agenda kegiatan..."
                   class="form-control border-0 shadow-none p-0 bg-transparent"
                   style="font-size: 14.5px;">
          </div>
          @if(!empty($search))
            <a href="{{ route('homepage.agenda') }}" class="btn btn-sm btn-light rounded-pill px-3 text-muted flex-shrink-0 d-inline-flex align-items-center gap-1" style="height: 42px; font-size: 13.5px; white-space: nowrap;">
              <i class="bi bi-x-circle"></i>
              <span>Reset</span>
            </a>
          @endif
          <button type="submit" class="btn btn-dark rounded-pill px-4 fw-semibold text-white flex-shrink-0 d-inline-flex align-items-center justify-content-center gap-2" style="height: 42px; font-size: 14px; white-space: nowrap;">
            <i class="bi bi-search"></i>
            <span>Cari</span>
          </button>
        </form>
      </div>
    </div>

    {{-- List Agenda Cards --}}
    <div class="row justify-content-center">
      <div class="col-lg-9">
        @if(isset($agendas) && $agendas->count() > 0)
          <div class="d-flex flex-column gap-3">
            @foreach($agendas as $agenda)
              <div class="card border-0 shadow-sm rounded-4 p-4" data-aos="fade-up" style="background: #ffffff; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                  <div class="flex-grow-1">
                    {{-- Badge Waktu / Jadwal --}}
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2 fw-bold" style="background: #fef08a; color: #854d0e; font-size: 13.5px;">
                      <i class="bi bi-calendar4-week"></i>
                      <span>{{ $agenda->date_text }}</span>
                    </div>

                    {{-- Judul Agenda --}}
                    <h4 class="fw-bold text-dark mb-2" style="font-size: 19px; line-height: 1.4;">
                      <a href="{{ route('homepage.agenda.detail', $agenda->slug) }}" class="text-dark text-decoration-none hover-primary">
                        {{ $agenda->title }}
                      </a>
                    </h4>

                    {{-- Lokasi jika ada --}}
                    @if($agenda->location)
                      <div class="text-muted small mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        <span>{{ $agenda->location }}</span>
                      </div>
                    @endif

                    {{-- Deskripsi jika ada --}}
                    @if($agenda->description)
                      <p class="text-secondary small mb-0" style="line-height: 1.6;">
                        {{ \Illuminate\Support\Str::limit($agenda->description, 160) }}
                      </p>
                    @endif
                  </div>

                  {{-- Tombol Aksi / Selengkapnya --}}
                  <div class="d-flex flex-wrap align-items-center gap-2 align-self-start pt-1">
                    @if($agenda->link_url)
                      <a href="{{ $agenda->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-2" style="height: 38px; white-space: nowrap;">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>Buka Tautan</span>
                      </a>
                    @endif
                    <a href="{{ route('homepage.agenda.detail', $agenda->slug) }}" class="btn btn-sm btn-dark rounded-pill px-3 fw-semibold text-white d-inline-flex align-items-center gap-2" style="height: 38px; white-space: nowrap;">
                      <i class="bi bi-arrow-right-circle"></i>
                      <span>Selengkapnya</span>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          <div class="d-flex justify-content-center mt-5">
            {{ $agendas->links() }}
          </div>
        @else
          <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-bold text-dark">Tidak Ada Agenda Ditemukan</h5>
            <p class="text-muted small mb-0">Belum ada agenda atau kegiatan yang sesuai dengan kriteria pencarian.</p>
          </div>
        @endif
      </div>
    </div>

  </div>
</section>

@endsection

