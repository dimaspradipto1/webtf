@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Profil Pimpinan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('about.index') }}">Profil Pimpinan & Prodi</a></li>
            <li class="breadcrumb-item active">Tambah Pimpinan</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="bi bi-person-plus-fill me-2"></i>Form Tambah Profil Pimpinan & Detail Lihat Profil
        </h5>
        <a href="{{ route('about.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body pt-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('pimpinan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                {{-- Informasi Utama Kartu Pimpinan --}}
                <div class="col-lg-6">
                    <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-person-vcard me-1"></i> Informasi Utama Pimpinan (Tampil di Daftar Pimpinan)
                        </h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}"
                                   placeholder="Contoh: Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}"
                                   placeholder="Contoh: Rektor Universitas Ibnu Sina (UIS) / Dekan Fakultas Sains dan Teknologi" required>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Baris Tampilan <span class="text-danger">*</span></label>
                                <select name="baris" class="form-select">
                                    <option value="1" {{ old('baris', 1) == 1 ? 'selected' : '' }}>Baris 1 — Atas (2 Kolom: Yayasan & Rektor)</option>
                                    <option value="2" {{ old('baris', 1) == 2 ? 'selected' : '' }}>Baris 2 — Tengah (3 Kolom: Dekan & Wakil Dekan)</option>
                                    <option value="3" {{ old('baris', 1) == 3 ? 'selected' : '' }}>Baris 3 — Bawah (Ka Prodi & Jajaran)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Urutan dalam Baris <span class="text-danger">*</span></label>
                                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 1) }}" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Foto Pimpinan (Tampil Full Tanpa Bingkai)</label>
                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <div class="form-text small">Format: JPG, PNG, WEBP (Maks. 5 MB). Gambar akan ditampilkan penuh tanpa bingkai kartu.</div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Tempat / Tanggal Lahir</label>
                                <input type="text" name="tempat_tanggal_lahir" class="form-control" value="{{ old('tempat_tanggal_lahir') }}"
                                       placeholder="Contoh: Enrekang/13 Mei 1965">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ old('email') }}"
                                       placeholder="Contoh: larisang@uis.ac.id">
                            </div>
                        </div>

                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold small" for="is_active">Tampilkan Pimpinan di Halaman Publik</label>
                        </div>
                    </div>
                </div>

                {{-- Detail Biodata untuk Halaman "Lihat Profil" --}}
                <div class="col-lg-6">
                    <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-file-earmark-person me-1"></i> Detail Biodata Halaman "Lihat Profil"
                        </h6>
                        <p class="text-muted small mb-3">
                            Tuliskan <strong>1 baris untuk setiap poin bullet</strong>. Otomatis ditampilkan sebagai daftar poin pada halaman <strong>Lihat Profil</strong>.
                        </p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Pendidikan</label>
                            <textarea name="pendidikan" rows="4" class="form-control" placeholder="S1 Univ. Muslim Indonesia (UMI) Makassar 1992 : Prodi Teknik Industri&#10;S2 Institute Teknologi Surabaya (ITS) Maret 2003. : Prodi Teknik Industri&#10;S3 Universitas Negeri Padang (UNP) Sept 2020 : Teknologi Terapan">{{ old('pendidikan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Pengalaman Organisasi Kemahasiswaan</label>
                            <textarea name="pengalaman_organisasi" rows="4" class="form-control" placeholder="Ketua Himpunan Mahasiswa Teknik Industri FTI-UMI Makassar 1987-1988&#10;Ketua BEM FTI-UMI Makassar 1988 – 1992">{{ old('pengalaman_organisasi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Pengalaman Kerja</label>
                            <textarea name="pengalaman_kerja" rows="4" class="form-control" placeholder="Dosen FTI-UMI Makassar 1992 – 1997&#10;Dosen Tetap UIM Makassar 2003 – 2009&#10;Dosen PNS DIKTI 2004 – Sekarang">{{ old('pengalaman_kerja') }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold small">Jabatan / Riwayat Jabatan</label>
                            <textarea name="riwayat_jabatan" rows="5" class="form-control" placeholder="Ketua Sekolah Tinggi Teknik Ibnu Sina Batam (STT) 2011 SD 2019&#10;Dekan Fak Teknik Universitas Ibnu Sina Batam (UIS) 2019 – 2024&#10;Rektor Universitas Ibnu Sina Batam (UIS) 2024 – Sekarang">{{ old('riwayat_jabatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ route('about.index') }}" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-dark px-4">
                    <i class="bi bi-save me-1"></i> Simpan Profil Pimpinan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

