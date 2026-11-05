@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Matakuliah Kurikulum</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kurikulum.index') }}">Kurikulum</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-plus-circle me-2 text-primary"></i>Formulir Tambah Matakuliah
        </h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('kurikulum.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                {{-- Baris 1: Informasi Akademik --}}
                <div class="col-md-6">
                    <label for="layanan_id" class="form-label fw-semibold text-dark">Program Studi <span class="text-danger">*</span></label>
                    <select name="layanan_id" id="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('layanan_id') == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->judul }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="semester" class="form-label fw-semibold text-dark">Semester <span class="text-danger">*</span></label>
                    <select name="semester" id="semester" class="form-select @error('semester') is-invalid @enderror" required>
                        @for($s = 1; $s <= 8; $s++)
                            <option value="{{ $s }}" {{ old('semester', 1) == $s ? 'selected' : '' }}>
                                Semester {{ $s }}
                            </option>
                        @endfor
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="sks" class="form-label fw-semibold text-dark">Jumlah SKS <span class="text-danger">*</span></label>
                    <input type="number" name="sks" id="sks" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', 3) }}" min="1" max="12" required>
                    @error('sks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 2: Detail Matakuliah (Pas 12 Kolom) --}}
                <div class="col-md-3">
                    <label for="kode_mk" class="form-label fw-semibold text-dark">Kode Matakuliah <span class="text-danger">*</span></label>
                    <input type="text" name="kode_mk" id="kode_mk" class="form-control @error('kode_mk') is-invalid @enderror" placeholder="Contoh: K3-101" value="{{ old('kode_mk') }}" required>
                    @error('kode_mk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nama_mk" class="form-label fw-semibold text-dark">Nama Matakuliah <span class="text-danger">*</span></label>
                    <input type="text" name="nama_mk" id="nama_mk" class="form-control @error('nama_mk') is-invalid @enderror" placeholder="Contoh: Keselamatan & Kesehatan Kerja" value="{{ old('nama_mk') }}" required>
                    @error('nama_mk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="kategori" class="form-label fw-semibold text-dark">Sifat / Kategori MK</label>
                    <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror">
                        <option value="Wajib" {{ old('kategori') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                        <option value="Pilihan" {{ old('kategori') == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                        <option value="Praktikum" {{ old('kategori') == 'Praktikum' ? 'selected' : '' }}>Praktikum</option>
                        <option value="Tugas Akhir / Skripsi" {{ old('kategori') == 'Tugas Akhir / Skripsi' ? 'selected' : '' }}>Tugas Akhir / Skripsi</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 3: Dokumen / Link RPS (Opsional) --}}
                <div class="col-12">
                    <div class="p-3 rounded-3 bg-light border">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold text-dark mb-0">
                                <i class="bi bi-file-earmark-arrow-down me-1 text-primary"></i> Dokumen Silabus / RPS (Rencana Pembelajaran Semester)
                            </label>
                            <span class="badge bg-secondary">Opsional</span>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="file_rps" class="form-label fw-semibold small text-secondary">Opsi 1: Upload File Dokumen (PDF / DOC)</label>
                                <input type="file" name="file_rps" id="file_rps" class="form-control @error('file_rps') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                <small class="text-muted d-block mt-1">Format PDF/DOC (Maks. 50MB)</small>
                                @error('file_rps')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="link_rps" class="form-label fw-semibold small text-secondary">Opsi 2: Tautan / Link RPS (Google Drive / Cloud)</label>
                                <input type="url" name="link_rps" id="link_rps" class="form-control @error('link_rps') is-invalid @enderror" placeholder="https://drive.google.com/..." value="{{ old('link_rps') }}">
                                <small class="text-muted d-block mt-1">Masukkan link jika file disimpan di Google Drive / Cloud.</small>
                                @error('link_rps')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Baris 4: Deskripsi Ringkas / Capaian Pembelajaran (TinyMCE) --}}
                <div class="col-12">
                    <label for="deskripsi" class="form-label fw-semibold text-dark">
                        Capaian Pembelajaran / Deskripsi Ringkas <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror" placeholder="Tuliskan ringkasan materi atau capaian pembelajaran matakuliah ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Baris 5: Status Aktif --}}
                <div class="col-12">
                    <div class="form-check form-switch p-2 bg-light rounded-3 border d-flex align-items-center gap-3">
                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                            Tampilkan matakuliah ini pada tabel kurikulum publik
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Matakuliah
                </button>
                <a href="{{ route('kurikulum.index') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
