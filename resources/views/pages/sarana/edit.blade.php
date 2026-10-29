@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Sarana & Fasilitas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sarana.index') }}">Sarana & Fasilitas</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-pencil-square me-2 text-warning"></i>Form Edit Sarana
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

                <form action="{{ route('sarana.update', $sarana->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="icon" class="form-label fw-semibold">
                            Bootstrap Icon Class <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light" id="icon-preview-box" style="font-size:22px;color:#000000;min-width:52px;justify-content:center;">
                                <i class="bi {{ old('icon', $sarana->icon ?? 'bi-building') }}"></i>
                            </span>
                            <input type="text"
                                   id="icon"
                                   name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $sarana->icon ?? 'bi-building') }}"
                                   placeholder="Contoh: bi-shield-check, bi-pc-display, bi-flask"
                                   oninput="updateIconPreview(this.value)">
                        </div>
                        <div class="form-text">
                            Ketik nama class icon Bootstrap.
                            Lihat daftar lengkap di <a href="https://icons.getbootstrap.com/" target="_blank">icons.getbootstrap.com</a>.
                        </div>
                        @error('icon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">
                            Nama Sarana / Fasilitas <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $sarana->nama) }}"
                               placeholder="Contoh: Lab K3 & Higiene Industri">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea id="deskripsi"
                                  name="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Tuliskan keterangan detail sarana/fasilitas...">{{ old('deskripsi', $sarana->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $sarana->urutan ?? 0) }}"
                                   min="0"
                                   placeholder="0">
                            <div class="form-text">Angka kecil tampil lebih dulu.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-semibold">Status Tampil</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $sarana->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Tampilkan di website</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('sarana.index') }}" class="btn btn-secondary">
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

    <div class="col-lg-4 col-md-10 mt-4 mt-lg-0">
        <div class="card shadow-sm border-0" style="background:#ffffff;">
            <div class="card-header bg-transparent border-0 pt-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-eye me-1 text-primary"></i> Preview Frontend</h6>
                <small class="text-muted">Begini tampilan di website</small>
            </div>
            <div class="card-body pt-2">
                <div class="p-3 rounded-3 border bg-white shadow-sm">
                    <div id="prev-icon-wrap" style="width:50px;height:50px;border-radius:12px;background:rgba(0, 0, 0, .12);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <i id="prev-icon" class="bi {{ old('icon', $sarana->icon ?? 'bi-building') }}" style="font-size:24px;color:#000000;"></i>
                    </div>
                    <div id="prev-nama" class="fw-bold mb-1" style="font-size:15px;">{{ $sarana->nama }}</div>
                    <div id="prev-deskripsi" class="text-muted small" style="line-height:1.6;">{{ strip_tags($sarana->deskripsi) ?: 'Deskripsi sarana akan tampil di sini.' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateIconPreview(val) {
    const cleanVal = val.trim();
    const box = document.getElementById('icon-preview-box');
    const prevIcon = document.getElementById('prev-icon');
    const cls = cleanVal || 'bi-building';
    box.innerHTML = '<i class="bi ' + cls + '"></i>';
    prevIcon.className = 'bi ' + cls;
    prevIcon.style.fontSize = '24px';
    prevIcon.style.color = '#000000';
}

document.addEventListener('DOMContentLoaded', function () {
    updateIconPreview(document.getElementById('icon').value);

    document.getElementById('nama').addEventListener('input', function () {
        document.getElementById('prev-nama').textContent = this.value || 'Nama Sarana';
    });

    document.getElementById('deskripsi').addEventListener('input', function () {
        document.getElementById('prev-deskripsi').textContent = this.value || 'Deskripsi sarana akan tampil di sini.';
    });
});
</script>
@endpush
