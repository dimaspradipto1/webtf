@extends('layouts.frontend.template')

@section('title', 'Pengumuman Resmi — Teknik Informatika (UIS)')
@section('meta_description', 'Kumpulan pengumuman akademik, KRS, beasiswa, dan warta penting Program Studi Teknik Informatika UIS Batam.')
@section('meta_keywords', 'pengumuman teknik informatika, krs uis, pengumuman akademik batam')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'pengumuman',
    'defaultJudul' => 'Pengumuman Resmi',
    'defaultSubjudul' => 'Informasi penting, edaran akademik, jadwal KRS, dan instruksi resmi untuk seluruh mahasiswa dan sivitas akademika Teknik Informatika.',
    'defaultBreadcrumb' => 'Pengumuman'
])

<section class="section-bg-sand py-5">
  <div class="container py-3">

    {{-- Filter / Search Bar --}}
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-7">
        <form action="{{ route('homepage.pengumuman') }}" method="GET" class="d-flex align-items-center gap-2 p-2 bg-white rounded-pill shadow-sm border">
          <input type="text"
                 name="q"
                 value="{{ $search ?? '' }}"
                 placeholder="Cari judul atau isi pengumuman..."
                 class="form-control border-0 rounded-pill ps-3 shadow-none">
          @if(!empty($search))
            <a href="{{ route('homepage.pengumuman') }}" class="btn btn-sm btn-light rounded-pill px-3 text-muted">
              Reset
            </a>
          @endif
          <button type="submit" class="btn btn-dark rounded-pill px-4 fw-semibold text-white">
            <i class="bi bi-search me-1"></i> Cari
          </button>
        </form>
      </div>
    </div>

    {{-- List Pengumuman Cards --}}
    <div class="row justify-content-center">
      <div class="col-lg-9">
        @if(isset($announcements) && $announcements->count() > 0)
          <div class="d-flex flex-column gap-3">
            @foreach($announcements as $ann)
              @php
                $targetUrl = $ann->link_url ?: ($ann->file_path ? asset('storage/'.$ann->file_path) : route('homepage.pengumuman.detail', $ann->slug));
                $isExternal = !empty($ann->link_url) || !empty($ann->file_path);
              @endphp
              <div class="card border-0 shadow-sm rounded-4 p-4" data-aos="fade-up" style="background: #ffffff; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                  <div class="flex-grow-1">
                    {{-- Tanggal --}}
                    <div class="d-inline-flex align-items-center gap-1 text-muted small mb-2 fw-medium">
                      <i class="bi bi-calendar3 text-primary"></i>
                      <span>{{ $ann->date ? \Carbon\Carbon::parse($ann->date)->translatedFormat('d F Y') : '-' }}</span>
                    </div>

                    {{-- Judul --}}
                    <h4 class="fw-bold text-dark mb-2" style="font-size: 19px; line-height: 1.4;">
                      <a href="{{ $targetUrl }}" class="text-dark text-decoration-none hover-primary" {{ $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                        {{ $ann->title }}
                      </a>
                    </h4>

                    {{-- Excerpt content --}}
                    @if($ann->content)
                      @php
                        $clean = trim(html_entity_decode(strip_tags($ann->content), ENT_QUOTES, 'UTF-8'));
                      @endphp
                      <p class="text-secondary small mb-0" style="line-height: 1.6;">
                        {{ \Illuminate\Support\Str::limit($clean, 160) }}
                      </p>
                    @endif
                  </div>

                  {{-- Action Buttons --}}
                  <div class="d-flex flex-column align-items-end gap-2">
                    @if($ann->file_path)
                      <a href="{{ asset('storage/' . $ann->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold">
                        <i class="bi bi-download me-1"></i> Unduh Lampiran
                      </a>
                    @endif
                    @if($ann->link_url)
                      <a href="{{ $ann->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Tautan
                      </a>
                    @endif
                    @if(!$ann->link_url && !$ann->file_path)
                      <a href="{{ route('homepage.pengumuman.detail', $ann->slug) }}" class="btn btn-sm btn-dark rounded-pill px-3 fw-semibold text-white">
                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          <div class="d-flex justify-content-center mt-5">
            {{ $announcements->links() }}
          </div>
        @else
          <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
            <i class="bi bi-megaphone-fill fs-1 text-muted d-block mb-3"></i>
            <h5 class="fw-bold text-dark">Tidak Ada Pengumuman Ditemukan</h5>
            <p class="text-muted small mb-0">Belum ada pengumuman yang sesuai dengan kriteria pencarian.</p>
          </div>
        @endif
      </div>
    </div>

  </div>
</section>

@endsection

