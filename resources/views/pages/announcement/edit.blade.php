@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Pengumuman</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Pengumuman & Agenda</a></li>
            <li class="breadcrumb-item active">Edit Pengumuman</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-9 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title mb-0 fw-bold text-dark p-0">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Formulir Edit Pengumuman
                </h5>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul Pengumuman --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $announcement->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Tanggal Pengumuman --}}
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-semibold">Tanggal Pengumuman <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control @error('date') is-invalid @enderror"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', $announcement->date ? $announcement->date->format('Y-m-d') : '') }}"
                                   required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Urutan --}}
                        <div class="col-md-6">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampilan</label>
                            <input type="number"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   id="urutan"
                                   name="urutan"
                                   value="{{ old('urutan', $announcement->urutan) }}"
                                   min="1">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Isi Pengumuman --}}
                    <div class="mb-3">
                        <label for="content" class="form-label fw-semibold">Isi / Uraian Pengumuman (Opsional)</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content"
                                  name="content"
                                  rows="4">{{ old('content', $announcement->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- File Lampiran --}}
                        <div class="col-md-6">
                            <label for="file" class="form-label fw-semibold">File Lampiran Dokumen</label>
                            @if($announcement->file_path)
                                <div class="mb-2 p-2 bg-light rounded border d-flex align-items-center justify-content-between">
                                    <div class="small">
                                        <i class="bi bi-file-earmark-check text-success me-1"></i>
                                        <a href="{{ asset('storage/' . $announcement->file_path) }}" target="_blank" class="fw-semibold text-decoration-none">
                                            Lihat File Saat Ini
                                        </a>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="delete_file" id="delete_file" value="1">
                                        <label class="form-check-label text-danger small" for="delete_file">Hapus</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file"
                                   class="form-control @error('file') is-invalid @enderror"
                                   id="file"
                                   name="file">
                            <small class="text-muted">Pilih file baru untuk mengganti. Format: PDF, Word, Gambar (Maks. 50 MB).</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Link URL --}}
                        <div class="col-md-6">
                            <label for="link_url" class="form-label fw-semibold">Tautan Eksternal / Link Terkait</label>
                            <input type="url"
                                   class="form-control @error('link_url') is-invalid @enderror"
                                   id="link_url"
                                   name="link_url"
                                   value="{{ old('link_url', $announcement->link_url) }}">
                            <small class="text-muted">Jika diisi, kartu pengumuman dapat langsung membuka tautan ini.</small>
                            @error('link_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Switch Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Tampilkan Pengumuman di Beranda Website
                            </label>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Perbarui Pengumuman
                        </button>
                        <a href="{{ route('announcements.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

