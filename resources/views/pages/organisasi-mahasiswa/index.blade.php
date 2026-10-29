@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Organisasi & Kegiatan Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Kemahasiswaan</li>
            <li class="breadcrumb-item active">Organisasi & Kegiatan</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'organisasi',
    'pageTitle' => 'Organisasi & Kegiatan Mahasiswa',
    'defaultJudul' => 'Organisasi & Kegiatan Mahasiswa',
    'defaultSubjudul' => 'Wadah pengembangan potensi, kepemimpinan, riset keilmuan, kreativitas, serta kepedulian sosial mahasiswa Teknik Informatika.'
])

{{-- 1. Pengaturan Header & Editorial Seksi Organisasi Mahasiswa --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-pencil-square me-2" style="color: #000000;"></i>Pengaturan Judul & Deskripsi Seksi Homepage (Organisasi Mahasiswa)
        </h5>
        <span class="badge" style="background-color: #000000; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">Frontend Section Header</span>
    </div>
    <div class="card-body pt-3 pb-4">
        <form action="{{ route('organisasi-mahasiswa.update-setting') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label for="badge_teks" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Teks Badge / Kategori Atas
                    </label>
                    <input type="text"
                           id="badge_teks"
                           name="badge_teks"
                           class="form-control @error('badge_teks') is-invalid @enderror"
                           value="{{ old('badge_teks', $setting->badge_teks ?? 'LEMBAGA KEMAHASISWAAN · UIS') }}"
                           placeholder="Contoh: LEMBAGA KEMAHASISWAAN · UIS">
                    <div class="form-text text-muted" style="font-size: 12px;">Label pill hijau kecil di atas judul utama.</div>
                    @error('badge_teks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-5 col-md-6">
                    <label for="judul" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Judul Utama <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="judul"
                           name="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul', $setting->judul ?? 'Kiprah & Kepemimpinan Mahasiswa UIS') }}"
                           placeholder="Contoh: Kiprah & Kepemimpinan Mahasiswa UIS"
                           required>
                    <div class="form-text text-muted" style="font-size: 12px;">Kalimat headline judul utama di kolom kiri.</div>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-3 col-md-12">
                    <label for="judul_highlight" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Kata Sorot (Gradient Text)
                    </label>
                    <input type="text"
                           id="judul_highlight"
                           name="judul_highlight"
                           class="form-control @error('judul_highlight') is-invalid @enderror"
                           value="{{ old('judul_highlight', $setting->judul_highlight ?? 'Kepemimpinan') }}"
                           placeholder="Contoh: Kepemimpinan">
                    <div class="form-text text-muted" style="font-size: 12px;">Kata di dalam judul yang diberi efek warna gradien khusus.</div>
                    @error('judul_highlight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Deskripsi Pengantar
                    </label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              rows="3"
                              placeholder="Eksplorasi ragam organisasi kemahasiswaan...">{{ old('deskripsi', $setting->deskripsi ?? '') }}</textarea>
                    <div class="form-text text-muted" style="font-size: 12px;">Paragraf keterangan pembuka di bawah judul utama.</div>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-6">
                    <label for="tombol_teks" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Teks Tombol Aksi
                    </label>
                    <input type="text"
                           id="tombol_teks"
                           name="tombol_teks"
                           class="form-control @error('tombol_teks') is-invalid @enderror"
                           value="{{ old('tombol_teks', $setting->tombol_teks ?? 'Jelajahi Semua Organisasi') }}"
                           placeholder="Contoh: Jelajahi Semua Organisasi">
                    <div class="form-text text-muted" style="font-size: 12px;">Teks pada tombol utama di bawah paragraf.</div>
                    @error('tombol_teks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-6">
                    <label for="tombol_url" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Link / URL Tombol
                    </label>
                    <input type="text"
                           id="tombol_url"
                           name="tombol_url"
                           class="form-control @error('tombol_url') is-invalid @enderror"
                           value="{{ old('tombol_url', $setting->tombol_url ?? '') }}"
                           placeholder="Kosongkan untuk link default (halaman ormawa)">
                    <div class="form-text text-muted" style="font-size: 12px;">Jika dikosongkan, otomatis mengarah ke halaman daftar ormawa.</div>
                    @error('tombol_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4 col-md-12">
                    <label for="hint_teks" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Teks Petunjuk Scroll
                    </label>
                    <input type="text"
                           id="hint_teks"
                           name="hint_teks"
                           class="form-control @error('hint_teks') is-invalid @enderror"
                           value="{{ old('hint_teks', $setting->hint_teks ?? 'Scroll mouse atau geser kartu untuk menggulir ormawa') }}"
                           placeholder="Contoh: Scroll mouse atau geser kartu untuk menggulir ormawa">
                    <div class="form-text text-muted" style="font-size: 12px;">Keterangan petunjuk kecil di samping ikon mouse.</div>
                    @error('hint_teks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-end pt-2">
                    <button type="submit" class="btn fw-semibold shadow-sm text-white" style="background-color: #000000; border: none; padding: 8px 22px; border-radius: 8px;">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-people-fill me-2 text-primary"></i>Daftar Lembaga & Organisasi Mahasiswa UIS
        </h5>
        <a href="{{ route('organisasi-mahasiswa.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Organisasi
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            Kelola data organisasi kemahasiswaan (BEM, Himpunan Mahasiswa Program Studi, UKM, Komunitas) lengkap dengan profil, logo, visi-misi, susunan pengurus, dan link pendaftaran anggota baru.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
@endpush
