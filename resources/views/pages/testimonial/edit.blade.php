@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Testimoni</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}">Testimoni</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Testimoni Pelanggan
                </h5>
            </div>
            <div class="card-body pt-4">

                {{-- Error Summary --}}
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

                <form action="{{ route('testimonial.update', $testimonial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        {{-- Nama (wajib) --}}
                        <div class="col-md-6">
                            <label for="nama" class="form-label fw-semibold">
                                Nama Pelanggan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nama"
                                   name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $testimonial->nama) }}"
                                   placeholder="Contoh: Budi Nugraha"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pekerjaan / Asal Kota (wajib) --}}
                        <div class="col-md-6">
                            <label for="pekerjaan" class="form-label fw-semibold">
                                Pekerjaan / Jabatan / Asal Instansi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="pekerjaan"
                                   name="pekerjaan"
                                   class="form-control @error('pekerjaan') is-invalid @enderror"
                                   value="{{ old('pekerjaan', $testimonial->pekerjaan) }}"
                                   placeholder="Contoh: Software Engineer PT Telkom / Alumni 2022"
                                   required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Kategori (wajib) --}}
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="kategori" class="form-label fw-semibold mb-0">
                                    Kategori Profil <span class="text-danger">*</span>
                                </label>
                                <a href="{{ route('category.index', ['type' => 'testimoni']) }}" target="_blank" class="small text-primary text-decoration-none">
                                    <i class="bi bi-gear-fill me-1"></i>Kelola Kategori
                                </a>
                            </div>
                            @php
                                $dbCategories = \App\Models\Category::getOptions('testimoni')->pluck('name')->toArray();
                                $defaultPresets = ['Alumni', 'Mahasiswa', 'Dosen / Pengajar', 'Mitra Industri', 'Orang Tua Mahasiswa'];
                                $categoriesList = array_unique(array_filter(array_merge($defaultPresets, $dbCategories, $existingCategories ?? [], [$testimonial->kategori ?? ''])));
                                $currentKat = old('kategori', $testimonial->kategori);
                                $isCustomSelected = !empty($currentKat) && !in_array($currentKat, $categoriesList);
                            @endphp
                            <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach($categoriesList as $cat)
                                    <option value="{{ $cat }}" {{ $currentKat === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                                <option value="__custom__" {{ ($currentKat === '__custom__' || $isCustomSelected) ? 'selected' : '' }}>
                                    ✏️ + Tambah Kategori Kustom (Ketik Sendiri)...
                                </option>
                            </select>

                            {{-- Input teks jika memilih kategori kustom --}}
                            <div id="kategori_custom_group" class="mt-2" style="{{ ($currentKat === '__custom__' || $isCustomSelected) ? 'display:block;' : 'display:none;' }}">
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-primary"><i class="bi bi-pencil-fill"></i></span>
                                    <input type="text"
                                           id="kategori_custom"
                                           name="kategori_custom"
                                           class="form-control"
                                           value="{{ old('kategori_custom', $isCustomSelected ? $currentKat : '') }}"
                                           placeholder="Tulis nama kategori baru (contoh: Praktisi AI, Asosiasi Profesi, dll)">
                                </div>
                                <div class="form-text small text-muted">Ketik nama kategori yang Anda inginkan jika tidak ada di pilihan daftar.</div>
                            </div>

                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bintang (wajib) --}}
                        <div class="col-md-6">
                            <label for="bintang" class="form-label fw-semibold">
                                Rating Bintang <span class="text-danger">*</span>
                            </label>
                            <select id="bintang" name="bintang" class="form-select @error('bintang') is-invalid @enderror" required>
                                <option value="5" {{ old('bintang', $testimonial->bintang) == 5 ? 'selected' : '' }}>5 Bintang (Sangat Puas)</option>
                                <option value="4" {{ old('bintang', $testimonial->bintang) == 4 ? 'selected' : '' }}>4 Bintang (Puas)</option>
                                <option value="3" {{ old('bintang', $testimonial->bintang) == 3 ? 'selected' : '' }}>3 Bintang (Cukup)</option>
                                <option value="2" {{ old('bintang', $testimonial->bintang) == 2 ? 'selected' : '' }}>2 Bintang (Kurang)</option>
                                <option value="1" {{ old('bintang', $testimonial->bintang) == 1 ? 'selected' : '' }}>1 Bintang (Kecewa)</option>
                            </select>
                            @error('bintang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Pesan (wajib) --}}
                    <div class="mb-3">
                        <label for="pesan" class="form-label fw-semibold">
                            Ulasan / Testimoni <span class="text-danger">*</span>
                        </label>
                        <textarea id="pesan"
                                  name="pesan"
                                  class="form-control @error('pesan') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Tuliskan masukan / ulasan pengalaman pelanggan di sini..."
                                  required>{{ old('pesan', $testimonial->pesan) }}</textarea>
                        @error('pesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1"
                                   {{ old('aktif', $testimonial->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="aktif">
                                Aktifkan testimoni (tampil di website)
                            </label>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori');
    const customGroup = document.getElementById('kategori_custom_group');
    const customInput = document.getElementById('kategori_custom');

    function checkCustom() {
        if (!kategoriSelect || !customGroup || !customInput) return;
        if (kategoriSelect.value === '__custom__') {
            customGroup.style.display = 'block';
            customInput.setAttribute('required', 'required');
            customInput.focus();
        } else {
            customGroup.style.display = 'none';
            customInput.removeAttribute('required');
        }
    }

    if (kategoriSelect) {
        kategoriSelect.addEventListener('change', checkCustom);
    }
});
</script>
@endpush
