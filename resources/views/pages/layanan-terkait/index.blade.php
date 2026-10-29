@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Layanan Terkait</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Layanan Terkait</li>
        </ol>
    </nav>
</div>

{{-- 1. Pengaturan Header Seksi Frontend --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #f9dc4b; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-pencil-square me-2" style="color: #f9dc4b;"></i>Pengaturan Judul & Deskripsi Seksi Layanan Terkait
        </h5>
        <span class="badge" style="background-color: #f9dc4b; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">Frontend Header</span>
    </div>
    <div class="card-body pt-3 pb-4">
        <form action="{{ route('layanan-terkait.update-setting') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-lg-5 col-md-12">
                    <label for="judul_seksi" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Judul Seksi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="judul_seksi"
                           name="judul_seksi"
                           class="form-control @error('judul_seksi') is-invalid @enderror"
                           value="{{ old('judul_seksi', $setting->judul_seksi ?? 'LAYANAN TERKAIT') }}"
                           placeholder="Contoh: LAYANAN TERKAIT"
                           required>
                    <div class="form-text text-muted" style="font-size: 12px;">Teks judul utama yang tampil di atas kartu.</div>
                    @error('judul_seksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-7 col-md-12">
                    <label for="subjudul_seksi" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                        Subjudul / Kalimat Deskripsi <span class="text-danger">*</span>
                    </label>
                    <textarea id="subjudul_seksi"
                              name="subjudul_seksi"
                              class="form-control @error('subjudul_seksi') is-invalid @enderror"
                              rows="2"
                              placeholder="Kalimat keterangan pembuka yang tampil di bawah judul..."
                              required>{{ old('subjudul_seksi', $setting->subjudul_seksi ?? '') }}</textarea>
                    <div class="form-text text-muted" style="font-size: 12px;">Kalimat keterangan pembuka yang tampil di bawah judul.</div>
                    @error('subjudul_seksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-end pt-2">
                    <button type="submit" class="btn fw-semibold shadow-sm" style="background-color: #f9dc4b; color: #ffffff; border: none; padding: 8px 20px; border-radius: 8px;">
                        <i class="bi bi-floppy me-1"></i> Simpan Perubahan Teks
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- 2. Daftar Link & Kartu Layanan --}}
<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-grid-fill me-2" style="color: #000000;"></i>Daftar Link & Kartu Layanan
        </h5>
        <a href="{{ route('layanan-terkait.create') }}" class="btn fw-semibold shadow-sm" style="background-color: #f9dc4b; color: #ffffff; border: none; padding: 7px 18px; border-radius: 8px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Layanan
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background-color: #e8f4fd; border-color: #b8e0fe; color: #0c5460; border-radius: 8px;">
            <i class="bi bi-info-circle-fill fs-5 me-2 text-info"></i>
            <div>
                <strong>Info:</strong> Kartu di bawah ini ditampilkan di bawah Hero Banner beranda website untuk akses cepat ke sistem (SIAKAD, SISTER, SINTA, Edlink, dll).
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-hover table-bordered align-middle',
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
