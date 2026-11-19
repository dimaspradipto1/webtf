@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Foto Galeri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-7 col-md-9">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-image-fill me-2 text-primary"></i>Form Tambah Foto Galeri
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

                {{-- enctype multipart wajib untuk upload file --}}
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul foto (opsional)">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori Galeri --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="kategori" class="form-label fw-semibold mb-0">
                                Kategori Galeri <span class="text-danger">*</span>
                            </label>
                            <a href="{{ route('category.index', ['type' => 'galeri']) }}" target="_blank" class="small text-primary text-decoration-none">
                                <i class="bi bi-gear-fill me-1"></i>Kelola Kategori
                            </a>
                        </div>
                        @php
                            $selectedKat = old('kategori', 'universitas');
                            $galleryCategories = \App\Models\Category::getOptions('galeri');
                        @endphp
                        <select id="kategori"
                                name="kategori"
                                class="form-select @error('kategori') is-invalid @enderror"
                                required>
                            @foreach($galleryCategories as $item)
                                <option value="{{ $item->slug ?? strtolower($item->name) }}" {{ $selectedKat === ($item->slug ?? strtolower($item->name)) || $selectedKat === $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
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
                                  placeholder="Deskripsi singkat foto (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Foto (wajib, bisa multi) --}}
                    <div class="mb-4">
                        <label for="foto" class="form-label fw-semibold">
                            Foto (Bisa Pilih Lebih dari Satu) <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               id="foto"
                               name="foto[]"
                               multiple
                               data-max-mb="20"
                               class="form-control @error('foto') is-invalid @enderror @error('foto.*') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewFoto(this)">
                        <div class="form-text">Format: JPG, JPEG, PNG, WebP. Bisa pilih banyak foto sekaligus, maks. 20 MB per file.</div>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('foto.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- Preview multi foto --}}
                        <div id="previewWrap" class="mt-3 d-none">
                            <p class="small text-muted mb-1">Preview (<span id="previewCount">0</span> foto dipilih):</p>
                            <div id="previewGrid" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Upload & Simpan
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
        const grid = document.getElementById('previewGrid');
        const count = document.getElementById('previewCount');
        if (!grid) return;
        grid.innerHTML = '';
        if (input.files && input.files.length > 0) {
            if (count) count.textContent = input.files.length;
            Array.from(input.files).forEach(function (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    img.style.width = '110px';
                    img.style.height = '110px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #dee2e6';
                    grid.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
            wrap.classList.remove('d-none');
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endpush
