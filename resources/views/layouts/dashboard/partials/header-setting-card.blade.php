@php
    /** @var string $pageKey */
    /** @var string $pageTitle */
    $currentHeader = \App\Models\PageHeader::get($pageKey, $defaultJudul ?? null, $defaultSubjudul ?? null, $defaultBreadcrumb ?? null);
@endphp

<form action="{{ route('page-header.update', $pageKey) }}" method="POST" class="mb-4">
    @csrf
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-sliders text-warning fs-5"></i>
                <h6 class="card-title mb-0 p-0 fw-bold text-dark">Pengaturan Header Halaman {{ $pageTitle }}</h6>
            </div>
            <span class="badge rounded-pill px-3 py-1 text-dark" style="background: rgba(249, 220, 75, 0.25); border: 1px solid #f9dc4b; font-size: 11.5px; font-weight: 700;">
                <i class="bi bi-eye-fill me-1"></i> Header & Breadcrumb Frontend
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="header_judul_{{ $pageKey }}" class="form-label fw-semibold small text-dark">Judul Utama Halaman <span class="text-danger">*</span></label>
                    <input type="text" 
                           id="header_judul_{{ $pageKey }}" 
                           name="judul" 
                           class="form-control" 
                           value="{{ old('judul', $currentHeader->judul) }}" 
                           placeholder="Ketik judul utama header..." 
                           required>
                </div>
                <div class="col-md-6">
                    <label for="header_subjudul_{{ $pageKey }}" class="form-label fw-semibold small text-dark">Subjudul / Ringkasan Header</label>
                    <input type="text" 
                           id="header_subjudul_{{ $pageKey }}" 
                           name="subjudul" 
                           class="form-control" 
                           value="{{ old('subjudul', $currentHeader->subjudul) }}" 
                           placeholder="Ketik ringkasan singkat pengantar header...">
                </div>
            </div>
        </div>
        <div class="card-footer bg-light py-3 text-end">
            <button type="submit" class="btn px-4 rounded-3 fw-bold text-white shadow-sm" style="background: #000000; border: none !important;">
                <i class="bi bi-check2-circle me-1" style="color: #f9dc4b;"></i> Simpan Header
            </button>
        </div>
    </div>
</form>

