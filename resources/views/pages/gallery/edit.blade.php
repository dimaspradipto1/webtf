@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Foto Galeri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Foto Galeri
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

                <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul (nullable) --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">
                            Judul
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="text"
                               id="judul"
                               name="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $gallery->judul) }}"
                               placeholder="Masukkan judul foto (opsional)">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori Galeri --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">
                            Kategori Galeri <span class="text-danger">*</span>
                        </label>
                        <select id="kategori"
                                name="kategori"
                                class="form-select @error('kategori') is-invalid @enderror"
                                required>
                            <option value="universitas" {{ old('kategori', $gallery->kategori ?? 'universitas') === 'universitas' ? 'selected' : '' }}>
                                Universitas (Galeri & Dokumentasi Universitas)
                            </option>
                            <option value="humas" {{ old('kategori', $gallery->kategori ?? 'universitas') === 'humas' ? 'selected' : '' }}>
                                Humas (Galeri & Kegiatan Humas)
                            </option>
                        </select>
                        <div class="form-text">Foto dengan kategori <strong>Humas</strong> akan otomatis tampil pada halaman Home Humas.</div>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi (nullable) --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">
                            Deskripsi
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Deskripsi singkat foto (opsional)">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto saat ini --}}
                    @if ($gallery->url)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Saat Ini</label>
                            <div>
                                <img src="{{ asset('storage/' . $gallery->url) }}"
                                     alt="{{ $gallery->judul ?? 'Foto' }}"
                                     style="max-width:180px;max-height:180px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6">
                            </div>
                        </div>
                    @endif

                    {{-- Ganti Foto (nullable) --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">
                            Ganti Foto
                            <span class="badge bg-secondary fw-normal ms-1" style="font-size:10px">Opsional</span>
                        </label>
                        <input type="file"
                               id="foto"
                               name="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewFoto(this)">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG, WebP. Maks: 20 MB.
                        </div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Preview foto baru --}}
                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview foto baru:</p>
                            <img id="previewImg"
                                 src=""
                                 alt="Preview"
                                 style="max-width:180px;max-height:180px;object-fit:cover;border-radius:8px;border:2px solid #0d6efd">
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
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
    function previewFoto(input) {
        const wrap = document.getElementById('previewWrap');
        const img  = document.getElementById('previewImg');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                wrap.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endpush
