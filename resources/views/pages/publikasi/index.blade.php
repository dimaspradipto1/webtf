@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Menu Publikasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Publikasi dan mitra</li>
            <li class="breadcrumb-item active">Publikasi</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 col-xl-11">

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

        {{-- Info Box --}}
        <div class="alert alert-info d-flex align-items-start gap-3 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #e8f4fd; border-color: #b8e0fe; color: #0c5460;">
            <i class="bi bi-info-circle-fill fs-4 text-primary mt-1"></i>
            <div>
                <h6 class="fw-bold mb-1">Sinkronisasi Menu Dropdown Publikasi di Navbar</h6>
                <p class="mb-0 small">
                    Daftar di bawah ini langsung terhubung dan tersinkronisasi secara otomatis dengan dropdown <strong>Publikasi</strong> pada navbar website utama. Pengunjung yang mengklik menu publikasi di navbar akan langsung diarahkan ke tautan link website / portal jurnal yang Anda atur di sini.
                </p>
            </div>
        </div>

        <form action="{{ route('publikasi.update-all') }}" method="POST" id="form-publikasi-settings">
            @csrf

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 16px;">
                        <i class="bi bi-link-45deg me-2" style="color: #000000;"></i>Daftar Link Menu Publikasi
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('homepage') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Navbar
                        </a>
                        <button type="button" class="btn btn-sm fw-semibold shadow-sm text-white" id="btn-add-publikasi" style="background: #000000; border: none !important;">
                            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Menu Publikasi
                        </button>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div id="publikasi-list-container" class="d-flex flex-column gap-3">
                        @foreach($publikasis as $index => $pub)
                            <div class="card border publikasi-item shadow-none rounded-3" style="background: #fdfdfd;" data-item-index="{{ $index }}">
                                <div class="card-header bg-white d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill publikasi-index-badge px-2 py-1 text-white" style="background: #000000 !important; font-size: 11px;">
                                            Menu #{{ $loop->iteration }}
                                        </span>
                                        <span class="fw-bold text-dark publikasi-title-preview" style="font-size: 14px;">
                                            {{ $pub->judul }}
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none btn-remove-publikasi" title="Hapus menu publikasi ini">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                </div>

                                <div class="card-body pt-3 pb-3">
                                    <input type="hidden" name="publikasis[{{ $index }}][id]" value="{{ $pub->id }}">

                                    <div class="row g-3 align-items-center">
                                        <!-- Nama Menu Publikasi -->
                                        <div class="col-lg-5 col-md-12">
                                            <label class="form-label fw-bold small text-dark mb-1">
                                                Nama Menu Publikasi <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="publikasis[{{ $index }}][judul]"
                                                   class="form-control publikasi-judul-input"
                                                   value="{{ old("publikasis.{$index}.judul", $pub->judul) }}"
                                                   placeholder="Contoh: E-Journal UIS / LPPM / SINTA"
                                                   required>
                                        </div>

                                        <!-- Link / URL Website Tujuan -->
                                        <div class="col-lg-5 col-md-12">
                                            <label class="form-label fw-bold small text-dark mb-1 d-flex align-items-center justify-content-between">
                                                <span><i class="bi bi-globe me-1 text-success"></i>Link / URL Website Tujuan</span>
                                                @if(!empty($pub->link))
                                                    <a href="{{ $pub->link }}" target="_blank" class="text-success text-decoration-none small" style="font-size: 11px;">
                                                        <i class="bi bi-box-arrow-up-right me-1"></i>Test Tautan
                                                    </a>
                                                @endif
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text"
                                                       name="publikasis[{{ $index }}][link]"
                                                       class="form-control font-monospace"
                                                       value="{{ old("publikasis.{$index}.link", $pub->link) }}"
                                                       placeholder="Contoh: https://journal.uis.ac.id atau https://lppm.uis.ac.id">
                                            </div>
                                        </div>

                                        <!-- Icon Bootstrap & Toggle Aktif -->
                                        <div class="col-lg-2 col-md-12">
                                            <label class="form-label fw-bold small text-dark mb-1">
                                                Icon & Tampilkan
                                            </label>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="input-group input-group-sm" style="max-width: 130px;" title="Icon Bootstrap">
                                                    <span class="input-group-text bg-white text-success">
                                                        <i class="bi {{ $pub->icon ?: 'bi-journal-richtext' }} publikasi-icon-preview"></i>
                                                    </span>
                                                    <input type="text"
                                                           name="publikasis[{{ $index }}][icon]"
                                                           class="form-control publikasi-icon-input"
                                                           value="{{ old("publikasis.{$index}.icon", $pub->icon ?: 'bi-journal-richtext') }}"
                                                           placeholder="bi-journal-richtext">
                                                </div>

                                                <div class="form-check form-switch m-0" title="Aktif di dropdown navbar">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="aktif_{{ $index }}"
                                                           name="publikasis[{{ $index }}][aktif]"
                                                           value="1"
                                                           {{ old("publikasis.{$index}.aktif", $pub->aktif) ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center" style="border-radius: 0 0 12px 12px;">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-3 rounded-2">
                        <i class="bi bi-arrow-left me-1"></i> Dashboard
                    </a>
                    <button type="submit" class="btn fw-semibold px-4 py-2 text-white shadow-sm" style="background: #000000; border: none; border-radius: 8px;">
                        <i class="bi bi-save me-1"></i> Simpan & Sinkronkan ke Navbar
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('publikasi-list-container');
    const btnAdd = document.getElementById('btn-add-publikasi');

    // Live update preview title & icon
    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('publikasi-judul-input')) {
            const card = e.target.closest('.publikasi-item');
            const preview = card.querySelector('.publikasi-title-preview');
            preview.textContent = e.target.value.trim() || 'Menu Baru';
        }
        if (e.target.classList.contains('publikasi-icon-input')) {
            const card = e.target.closest('.publikasi-item');
            const iconPreview = card.querySelector('.publikasi-icon-preview');
            const iconClass = e.target.value.trim() || 'bi-journal-richtext';
            iconPreview.className = 'bi ' + iconClass + ' publikasi-icon-preview';
        }
    });

    // Remove item
    container.addEventListener('click', function (e) {
        const btnRemove = e.target.closest('.btn-remove-publikasi');
        if (btnRemove) {
            const allItems = container.querySelectorAll('.publikasi-item');
            if (allItems.length <= 1) {
                alert('Minimal harus menyisakan 1 menu publikasi.');
                return;
            }
            if (confirm('Yakin ingin menghapus menu publikasi ini?')) {
                const card = btnRemove.closest('.publikasi-item');
                card.remove();
                reindexItems();
            }
        }
    });

    // Add new item
    btnAdd.addEventListener('click', function () {
        const allItems = container.querySelectorAll('.publikasi-item');
        const newIndex = new Date().getTime(); // unique index
        const nextNumber = allItems.length + 1;

        const template = `
            <div class="card border publikasi-item shadow-none rounded-3" style="background: #fdfdfc;" data-item-index="${newIndex}">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill publikasi-index-badge px-2 py-1 text-white" style="background: #000000 !important; font-size: 11px;">
                            Menu #${nextNumber}
                        </span>
                        <span class="fw-bold text-dark publikasi-title-preview" style="font-size: 14px;">
                            Menu Baru
                        </span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none btn-remove-publikasi" title="Hapus menu publikasi ini">
                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                    </button>
                </div>

                <div class="card-body pt-3 pb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                Nama Menu Publikasi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="publikasis[${newIndex}][judul]"
                                   class="form-control publikasi-judul-input"
                                   placeholder="Contoh: E-Journal UIS / SINTA Kemendikbud"
                                   required>
                        </div>

                        <div class="col-lg-5 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                <i class="bi bi-globe me-1 text-success"></i>Link / URL Website Tujuan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                                <input type="text"
                                       name="publikasis[${newIndex}][link]"
                                       class="form-control font-monospace"
                                       placeholder="Contoh: https://journal.uis.ac.id">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                Icon & Tampilkan
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="max-width: 130px;" title="Icon Bootstrap">
                                    <span class="input-group-text bg-white text-success">
                                        <i class="bi bi-journal-richtext publikasi-icon-preview"></i>
                                    </span>
                                    <input type="text"
                                           name="publikasis[${newIndex}][icon]"
                                           class="form-control publikasi-icon-input"
                                           value="bi-journal-richtext"
                                           placeholder="bi-journal-richtext">
                                </div>

                                <div class="form-check form-switch m-0" title="Aktif di dropdown navbar">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="publikasis[${newIndex}][aktif]"
                                           value="1"
                                           checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', template);
        reindexItems();
    });

    function reindexItems() {
        const items = container.querySelectorAll('.publikasi-item');
        items.forEach((item, idx) => {
            const badge = item.querySelector('.publikasi-index-badge');
            if (badge) badge.textContent = `Menu #${idx + 1}`;
        });
    }
});
</script>
@endpush
