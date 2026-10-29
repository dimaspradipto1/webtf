@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit SOP</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Portal Layanan</li>
            <li class="breadcrumb-item"><a href="{{ route('template-dokumen.index') }}">SOP</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Berkas SOP
                </h5>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('template-dokumen.update', $templateDokumen->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="icon_preset" value="{{ $templateDokumen->icon_preset ?: 'pdf' }}">

                    <!-- Nama Dokumen SOP -->
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Nama / Judul Dokumen SOP <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $templateDokumen->judul) }}"
                               placeholder="Contoh: SOP Pelaksanaan Seminar Proposal & Sidang Skripsi" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link Google Drive -->
                    <div class="mb-3">
                        <label for="link_drive" class="form-label fw-semibold">
                            Tautan / Link Google Drive Dokumen SOP <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-google"></i></span>
                            <input type="url" id="link_drive" name="link_drive"
                                   class="form-control @error('link_drive') is-invalid @enderror"
                                   value="{{ old('link_drive', $templateDokumen->link_drive) }}"
                                   placeholder="Contoh: https://drive.google.com/file/d/xxxx/view?usp=sharing" required>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Tautan berkas PDF / Google Drive dokumen SOP yang dapat diakses langsung oleh civitas akademika.
                        </div>
                        @error('link_drive')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if(!empty($templateDokumen->link_drive) && $templateDokumen->link_drive !== '#')
                            <div class="mt-2 p-2 bg-light rounded border d-flex align-items-center justify-content-between">
                                <span class="small text-muted text-truncate me-2">
                                    <i class="bi bi-link-45deg text-success me-1"></i>
                                    {{ $templateDokumen->link_drive }}
                                </span>
                                <a href="{{ $templateDokumen->link_drive }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary py-0" style="font-size:11px; white-space:nowrap;">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>Buka Link
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Tipe / Format File -->
                        <div class="col-sm-6">
                            <label for="tipe_file" class="form-label fw-semibold">Format File</label>
                            <input type="text" id="tipe_file" name="tipe_file"
                                   class="form-control @error('tipe_file') is-invalid @enderror"
                                   value="{{ old('tipe_file', $templateDokumen->tipe_file ?: 'PDF') }}"
                                   placeholder="Contoh: PDF atau DOCX">
                            @error('tipe_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Urutan Tampil -->
                        <div class="col-sm-6">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" id="urutan" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $templateDokumen->urutan) }}" min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Switch Aktif -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $templateDokumen->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktifkan (tampil di halaman SOP)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('template-dokumen.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" style="background: #000000; border: none !important;">
                            <i class="bi bi-save me-1"></i> Perbarui SOP
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
