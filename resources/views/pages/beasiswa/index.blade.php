@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Menu Beasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Portal Layanan</li>
            <li class="breadcrumb-item active">Beasiswa</li>
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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Info Box --}}
        <div class="alert alert-info d-flex align-items-start gap-3 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #e8f4fd; border-color: #b8e0fe; color: #0c5460;">
            <i class="bi bi-info-circle-fill fs-4 text-primary mt-1"></i>
            <div>
                <h6 class="fw-bold mb-1">Sinkronisasi Menu Dropdown Beasiswa di Navbar</h6>
                <p class="mb-0 small">
                    Daftar di bawah ini langsung terhubung dan tersinkronisasi secara otomatis dengan dropdown <strong>Beasiswa</strong> pada navbar website utama. Pengunjung yang mengklik menu beasiswa di navbar akan langsung diarahkan ke tautan link website / portal beasiswa resmi yang Anda atur di sini.
                </p>
            </div>
        </div>

        <form action="{{ route('beasiswa.update-all') }}" method="POST" id="form-beasiswa-settings">
            @csrf

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
                    <h5 class="mb-0 fw-bold text-dark" style="font-size: 16px;">
                        <i class="bi bi-gift-fill me-2" style="color: #000000;"></i>Daftar Link Menu Beasiswa
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('homepage') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Navbar
                        </a>
                        <button type="button" class="btn btn-sm fw-semibold shadow-sm text-white" id="btn-add-beasiswa" style="background: #000000; border: none !important;">
                            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Menu Beasiswa
                        </button>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div id="beasiswa-list-container" class="d-flex flex-column gap-3">
                        @foreach($beasiswas as $index => $b)
                            <div class="card border beasiswa-item shadow-none rounded-3" style="background: #fdfdfd;" data-item-index="{{ $index }}">
                                <div class="card-header bg-white d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill beasiswa-index-badge px-2 py-1 text-white" style="background: #000000 !important; font-size: 11px;">
                                            Menu #{{ $loop->iteration }}
                                        </span>
                                        <span class="fw-bold text-dark beasiswa-title-preview" style="font-size: 14px;">
                                            {{ $b->judul }}
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none btn-remove-beasiswa" title="Hapus menu beasiswa ini">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                </div>

                                <div class="card-body pt-3 pb-3">
                                    <input type="hidden" name="beasiswas[{{ $index }}][id]" value="{{ $b->id }}">

                                    <div class="row g-3 align-items-center">
                                        <!-- Nama Menu Beasiswa -->
                                        <div class="col-lg-5 col-md-12">
                                            <label class="form-label fw-bold small text-dark mb-1">
                                                Nama Menu Beasiswa <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="beasiswas[{{ $index }}][judul]"
                                                   class="form-control beasiswa-judul-input"
                                                   value="{{ old("beasiswas.{$index}.judul", $b->judul) }}"
                                                   placeholder="Contoh: LPDP / KIP / BPDDI / ADIK"
                                                   required>
                                        </div>

                                        <!-- Link / URL Website Tujuan -->
                                        <div class="col-lg-5 col-md-12">
                                            <label class="form-label fw-bold small text-dark mb-1 d-flex align-items-center justify-content-between">
                                                <span><i class="bi bi-globe me-1 text-success"></i>Link / URL Website Tujuan</span>
                                                @if(!empty($b->link))
                                                    <a href="{{ $b->link }}" target="_blank" class="text-success text-decoration-none small" style="font-size: 11px;">
                                                        <i class="bi bi-box-arrow-up-right me-1"></i>Test Tautan
                                                    </a>
                                                @endif
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                                                <input type="text"
                                                       name="beasiswas[{{ $index }}][link]"
                                                       class="form-control font-monospace"
                                                       value="{{ old("beasiswas.{$index}.link", $b->link) }}"
                                                       placeholder="Contoh: https://lpdp.kemenkeu.go.id/">
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
                                                        <i class="bi {{ $b->icon ?: 'bi-award-fill' }} beasiswa-icon-preview"></i>
                                                    </span>
                                                    <input type="text"
                                                           name="beasiswas[{{ $index }}][icon]"
                                                           class="form-control beasiswa-icon-input"
                                                           value="{{ old("beasiswas.{$index}.icon", $b->icon ?: 'bi-award-fill') }}"
                                                           placeholder="bi-award-fill">
                                                </div>

                                                <div class="form-check form-switch m-0" title="Aktif di dropdown navbar">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           id="aktif_{{ $index }}"
                                                           name="beasiswas[{{ $index }}][aktif]"
                                                           value="1"
                                                           {{ old("beasiswas.{$index}.aktif", $b->aktif) ? 'checked' : '' }}>
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
    const container = document.getElementById('beasiswa-list-container');
    const btnAdd = document.getElementById('btn-add-beasiswa');

    // Live update preview title & icon
    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('beasiswa-judul-input')) {
            const card = e.target.closest('.beasiswa-item');
            const preview = card.querySelector('.beasiswa-title-preview');
            preview.textContent = e.target.value.trim() || 'Menu Baru';
        }
        if (e.target.classList.contains('beasiswa-icon-input')) {
            const card = e.target.closest('.beasiswa-item');
            const iconPreview = card.querySelector('.beasiswa-icon-preview');
            const iconClass = e.target.value.trim() || 'bi-award-fill';
            iconPreview.className = 'bi ' + iconClass + ' beasiswa-icon-preview';
        }
    });

    // Remove item
    container.addEventListener('click', function (e) {
        const btnRemove = e.target.closest('.btn-remove-beasiswa');
        if (btnRemove) {
            const allItems = container.querySelectorAll('.beasiswa-item');
            if (allItems.length <= 1) {
                alert('Minimal harus menyisakan 1 menu beasiswa.');
                return;
            }
            if (confirm('Yakin ingin menghapus menu beasiswa ini?')) {
                const card = btnRemove.closest('.beasiswa-item');
                card.remove();
                reindexItems();
            }
        }
    });

    // Add new item
    if (btnAdd) {
        btnAdd.addEventListener('click', function () {
            const allItems = container.querySelectorAll('.beasiswa-item');
            const newIndex = allItems.length > 0 ? (parseInt(allItems[allItems.length - 1].getAttribute('data-item-index')) + 1) : 0;
            const newNumber = allItems.length + 1;

            const html = `
            <div class="card border beasiswa-item shadow-none rounded-3" style="background: #fdfdfc;" data-item-index="${newIndex}">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill beasiswa-index-badge px-2 py-1 text-white" style="background: #000000 !important; font-size: 11px;">
                            Menu #${newNumber}
                        </span>
                        <span class="fw-bold text-dark beasiswa-title-preview" style="font-size: 14px;">
                            Menu Baru
                        </span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none btn-remove-beasiswa" title="Hapus menu beasiswa ini">
                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                    </button>
                </div>

                <div class="card-body pt-3 pb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                Nama Menu Beasiswa <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="beasiswas[${newIndex}][judul]"
                                   class="form-control beasiswa-judul-input"
                                   placeholder="Contoh: GARUDA / INDONESIA MAJU"
                                   required>
                        </div>

                        <div class="col-lg-5 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                <i class="bi bi-globe me-1 text-success"></i>Link / URL Website Tujuan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg"></i></span>
                                <input type="text"
                                       name="beasiswas[${newIndex}][link]"
                                       class="form-control font-monospace"
                                       placeholder="Contoh: https://beasiswa.kemdikbud.go.id/">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-12">
                            <label class="form-label fw-bold small text-dark mb-1">
                                Icon & Tampilkan
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="max-width: 130px;" title="Icon Bootstrap">
                                    <span class="input-group-text bg-white text-success">
                                        <i class="bi bi-award-fill beasiswa-icon-preview"></i>
                                    </span>
                                    <input type="text"
                                           name="beasiswas[${newIndex}][icon]"
                                           class="form-control beasiswa-icon-input"
                                           value="bi-award-fill"
                                           placeholder="bi-award-fill">
                                </div>

                                <div class="form-check form-switch m-0" title="Aktif di dropdown navbar">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="aktif_${newIndex}"
                                           name="beasiswas[${newIndex}][aktif]"
                                           value="1"
                                           checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            reindexItems();
            const lastItem = container.querySelector('.beasiswa-item:last-child');
            if (lastItem) {
                const inputJudul = lastItem.querySelector('.beasiswa-judul-input');
                if (inputJudul) inputJudul.focus();
            }
        });
    }

    function reindexItems() {
        const items = container.querySelectorAll('.beasiswa-item');
        items.forEach((item, idx) => {
            const badge = item.querySelector('.beasiswa-index-badge');
            if (badge) badge.textContent = 'Menu #' + (idx + 1);
        });
    }
});
</script>
@endpush

