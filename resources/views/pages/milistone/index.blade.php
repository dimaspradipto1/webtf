@extends('layouts.dashboard.template')

@section('content')
@php
    $pimpinanEras = old('eras', $about?->sejarah_pimpinan_list ?? \App\Models\About::defaultSejarahPimpinan());
@endphp
<div class="pagetitle">
    <h1>Sejarah YAPISTA & Milestone</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Sejarah YAPISTA</li>
        </ol>
    </nav>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Pengaturan Narasi Sejarah, Link External & Pimpinan dari Masa ke Masa -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-journal-text me-2 text-success"></i>Pengaturan Narasi Sejarah YAPISTA & Pimpinan dari Masa ke Masa
                </h5>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNarasiSejarah" aria-expanded="true">
                    <i class="bi bi-sliders me-1"></i> Tampilkan / Sembunyikan Form
                </button>
            </div>
            <div id="collapseNarasiSejarah" class="collapse show">
                <div class="card-body pt-4">
                    <form action="{{ route('milestone.update-setting') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Kolom Kiri: Narasi Sejarah -->
                            <div class="col-lg-6">
                                <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bi bi-text-left me-1"></i> Bagian Kiri: Jejak Langkah & Narasi Sejarah
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Label Badge Atas</label>
                                        <input type="text" name="sejarah_label" class="form-control"
                                               value="{{ old('sejarah_label', $about?->sejarah_label ?: 'Sejarah YAPISTA & Program Studi') }}"
                                               placeholder="Sejarah YAPISTA & Program Studi">
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Judul Utama (Teks Biasa)</label>
                                            <input type="text" name="sejarah_judul" class="form-control"
                                                   value="{{ old('sejarah_judul', $about?->sejarah_judul ?: 'Perjalanan Berkelanjutan') }}"
                                                   placeholder="Perjalanan Berkelanjutan">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Judul Highlight</label>
                                            <input type="text" name="sejarah_judul_highlight" class="form-control"
                                                   value="{{ old('sejarah_judul_highlight', $about?->sejarah_judul_highlight ?: 'Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)') }}"
                                                   placeholder="Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Paragraf Narasi 1</label>
                                        <textarea name="sejarah_deskripsi_1" rows="4" class="form-control">{{ old('sejarah_deskripsi_1', $about?->sejarah_deskripsi_1 ?: 'Program Studi Teknik Informatika — Fakultas Sains dan Teknologi tumbuh dari tonggak sejarah panjang pengabdian Yayasan Pendidikan Ibnu Sina Batam (YAPISTA) dalam memajukan pendidikan dan sumber daya manusia unggul di kawasan strategis Kota Batam dan Kepulauan Riau.') }}</textarea>
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-semibold small">Paragraf Narasi 2</label>
                                        <textarea name="sejarah_deskripsi_2" rows="4" class="form-control">{{ old('sejarah_deskripsi_2', $about?->sejarah_deskripsi_2 ?: 'Berawal dari pendirian Sekolah Tinggi Teknik (STT) di bawah naungan YAPISTA hingga bertransformasi menjadi Fakultas Sains dan Teknologi, Program Studi S1 Teknik Informatika secara konsisten melahirkan ribuan sarjana komputer dan profesional TI yang berkiprah di perusahaan multinasional, industri manufaktur, instansi pemerintahan, dan technopreneur.') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Kartu Fokus Institusi & Link External / YouTube -->
                            <div class="col-lg-6">
                                <div class="p-3 rounded-3 border bg-light bg-opacity-50 h-100">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bi bi-card-heading me-1"></i> Bagian Kanan: Kartu Fokus Institusi & Link External
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Judul Kartu</label>
                                        <input type="text" name="sejarah_card_judul" class="form-control"
                                               value="{{ old('sejarah_card_judul', $about?->sejarah_card_judul ?: 'Program Studi Teknik Informatika') }}"
                                               placeholder="Program Studi Teknik Informatika">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Subjudul Kartu</label>
                                        <input type="text" name="sejarah_card_subjudul" class="form-control"
                                               value="{{ old('sejarah_card_subjudul', $about?->sejarah_card_subjudul ?: 'Fakultas Sains dan Teknologi') }}"
                                               placeholder="Fakultas Sains dan Teknologi">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Kutipan / Narasi Dalam Kartu</label>
                                        <textarea name="sejarah_card_narasi" rows="4" class="form-control">{{ old('sejarah_card_narasi', $about?->sejarah_card_narasi ?: 'Setiap fase perkembangan Program Studi Teknik Informatika diarahkan untuk memperkuat mutu pembelajaran berbasis Outcome-Based Education (OBE), riset teknologi terapan, serta membentuk lulusan sarjana komputer berjiwa technopreneur berbasis Imtaq.') }}</textarea>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 1</label>
                                            <input type="text" name="sejarah_pilar_1" class="form-control"
                                                   value="{{ old('sejarah_pilar_1', $about?->sejarah_pilar_1 ?: 'Software & AI Engineering') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 2</label>
                                            <input type="text" name="sejarah_pilar_2" class="form-control"
                                                   value="{{ old('sejarah_pilar_2', $about?->sejarah_pilar_2 ?: 'Multimedia') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold small">Badge Pilar 3</label>
                                            <input type="text" name="sejarah_pilar_3" class="form-control"
                                                   value="{{ old('sejarah_pilar_3', $about?->sejarah_pilar_3 ?: 'Networking') }}">
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <h6 class="fw-bold text-dark mb-2">
                                        <i class="bi bi-youtube text-danger me-1"></i> Link External / Video YouTube (Opsional)
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-md-7">
                                            <label class="form-label fw-semibold small">URL Link External / YouTube <span class="text-muted fw-normal">(Opsional)</span></label>
                                            <input type="text" name="sejarah_link_url" class="form-control"
                                                   value="{{ old('sejarah_link_url', $about?->sejarah_link_url) }}"
                                                   placeholder="https://www.youtube.com/watch?v=... atau https://...">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label fw-semibold small">Label Tombol / Judul Link <span class="text-muted fw-normal">(Opsional)</span></label>
                                            <input type="text" name="sejarah_link_label" class="form-control"
                                                   value="{{ old('sejarah_link_label', $about?->sejarah_link_label) }}"
                                                   placeholder="Tonton Video Sejarah YAPISTA">
                                        </div>
                                    </div>
                                    <div class="form-text small mt-1">
                                        Jika diisi link YouTube (<code>youtube.com/watch?v=...</code> atau <code>youtu.be/...</code>), video otomatis ditampilkan (embed) seperti pemutar YouTube beserta tombol link eksternal di halaman Sejarah YAPISTA. Kosongkan jika tidak digunakan.
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian Bawah: Pimpinan dari Masa ke Masa -->
                            <div class="col-12">
                                <div class="p-3 p-md-4 rounded-3 border bg-light bg-opacity-50">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                        <div>
                                            <h6 class="fw-bold text-success mb-1">
                                                <i class="bi bi-people-fill me-1"></i> Pimpinan dari Masa ke Masa
                                            </h6>
                                            <p class="text-muted small mb-0">Kelola daftar periode kepemimpinan dari masa ke masa berdasarkan era institusi.</p>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-dark" id="btnAddEra">
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Era Baru
                                        </button>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Judul Seksi Pimpinan</label>
                                            <input type="text" name="sejarah_pimpinan_judul" class="form-control"
                                                   value="{{ old('sejarah_pimpinan_judul', $about?->sejarah_pimpinan_judul ?: 'Pimpinan dari Masa ke Masa') }}"
                                                   placeholder="Pimpinan dari Masa ke Masa">
                                        </div>
                                    </div>

                                    <div id="erasContainer" class="d-flex flex-column gap-3">
                                        @foreach ($pimpinanEras as $eraIdx => $eraData)
                                            <div class="card border shadow-none era-block" data-era-index="{{ $eraIdx }}">
                                                <div class="card-header bg-white d-flex align-items-center justify-content-between gap-2 py-2">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label fw-semibold small mb-1">Nama Era</label>
                                                        <input type="text" name="eras[{{ $eraIdx }}][era]" class="form-control form-control-sm fw-bold"
                                                               value="{{ $eraData['era'] ?? '' }}"
                                                               placeholder="Contoh: Era Sekolah Tinggi Teknik (STT) Ibnu Sina" required>
                                                    </div>
                                                    <div class="pt-4">
                                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-era" title="Hapus Era">
                                                            <i class="bi bi-trash"></i> Hapus Era
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered align-middle mb-2">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th style="width: 32%;">Periode</th>
                                                                    <th>Pimpinan</th>
                                                                    <th style="width: 90px;" class="text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="era-items-body">
                                                                @php
                                                                    $items = $eraData['items'] ?? [['periode' => '', 'pimpinan' => '']];
                                                                @endphp
                                                                @foreach ($items as $itemIdx => $item)
                                                                    <tr class="era-item-row">
                                                                        <td>
                                                                            <input type="text"
                                                                                   name="eras[{{ $eraIdx }}][items][{{ $itemIdx }}][periode]"
                                                                                   class="form-control form-control-sm"
                                                                                   value="{{ $item['periode'] ?? '' }}"
                                                                                   placeholder="Contoh: 2001–2005" required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                   name="eras[{{ $eraIdx }}][items][{{ $itemIdx }}][pimpinan]"
                                                                                   class="form-control form-control-sm"
                                                                                   value="{{ $item['pimpinan'] ?? '' }}"
                                                                                   placeholder="Contoh: Ir. Zaenal" required>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" title="Hapus Baris">
                                                                                <i class="bi bi-x-lg"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-row">
                                                        <i class="bi bi-plus-lg me-1"></i> Tambah Baris Periode & Pimpinan
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Simpan Narasi Sejarah & Pimpinan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Milestone -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Daftar Milestone
                </h5>
                <a href="{{ route('milestone.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Milestone
                </a>
            </div>
            <div class="card-body pt-4">
                {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle']) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const erasContainer = document.getElementById('erasContainer');
            const btnAddEra = document.getElementById('btnAddEra');

            function reindexEras() {
                const eraBlocks = erasContainer.querySelectorAll('.era-block');
                eraBlocks.forEach((eraBlock, eraIdx) => {
                    eraBlock.dataset.eraIndex = eraIdx;
                    const eraInput = eraBlock.querySelector('input[name*="[era]"]');
                    if (eraInput) {
                        eraInput.name = `eras[${eraIdx}][era]`;
                    }
                    const rows = eraBlock.querySelectorAll('.era-item-row');
                    rows.forEach((row, itemIdx) => {
                        const periodeInput = row.querySelector('input[name*="[periode]"]');
                        const pimpinanInput = row.querySelector('input[name*="[pimpinan]"]');
                        if (periodeInput) periodeInput.name = `eras[${eraIdx}][items][${itemIdx}][periode]`;
                        if (pimpinanInput) pimpinanInput.name = `eras[${eraIdx}][items][${itemIdx}][pimpinan]`;
                    });
                });
            }

            if (btnAddEra) {
                btnAddEra.addEventListener('click', function () {
                    const eraIdx = erasContainer.querySelectorAll('.era-block').length;
                    const wrapper = document.createElement('div');
                    wrapper.className = 'card border shadow-none era-block';
                    wrapper.dataset.eraIndex = eraIdx;
                    wrapper.innerHTML = `
                        <div class="card-header bg-white d-flex align-items-center justify-content-between gap-2 py-2">
                            <div class="flex-grow-1">
                                <label class="form-label fw-semibold small mb-1">Nama Era</label>
                                <input type="text" name="eras[${eraIdx}][era]" class="form-control form-control-sm fw-bold"
                                       placeholder="Contoh: Era Fakultas Sains dan Teknologi (FST) Universitas Ibnu Sina" required>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-era" title="Hapus Era">
                                    <i class="bi bi-trash"></i> Hapus Era
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 32%;">Periode</th>
                                            <th>Pimpinan</th>
                                            <th style="width: 90px;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="era-items-body">
                                        <tr class="era-item-row">
                                            <td>
                                                <input type="text" name="eras[${eraIdx}][items][0][periode]" class="form-control form-control-sm"
                                                       placeholder="Contoh: 2025–sekarang" required>
                                            </td>
                                            <td>
                                                <input type="text" name="eras[${eraIdx}][items][0][pimpinan]" class="form-control form-control-sm"
                                                       placeholder="Contoh: Ir. Sanusi, ST., M.Eng., Ph.D., IPM" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" title="Hapus Baris">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-add-row">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Baris Periode & Pimpinan
                            </button>
                        </div>
                    `;
                    erasContainer.appendChild(wrapper);
                    reindexEras();
                });
            }

            erasContainer.addEventListener('click', function (e) {
                const addRowBtn = e.target.closest('.btn-add-row');
                if (addRowBtn) {
                    const eraBlock = addRowBtn.closest('.era-block');
                    const tbody = eraBlock.querySelector('.era-items-body');
                    const eraIdx = eraBlock.dataset.eraIndex;
                    const itemIdx = tbody.querySelectorAll('.era-item-row').length;

                    const tr = document.createElement('tr');
                    tr.className = 'era-item-row';
                    tr.innerHTML = `
                        <td>
                            <input type="text" name="eras[${eraIdx}][items][${itemIdx}][periode]" class="form-control form-control-sm"
                                   placeholder="Contoh: 2001–2005" required>
                        </td>
                        <td>
                            <input type="text" name="eras[${eraIdx}][items][${itemIdx}][pimpinan]" class="form-control form-control-sm"
                                   placeholder="Contoh: Ir. Zaenal" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" title="Hapus Baris">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                    reindexEras();
                    return;
                }

                const removeRowBtn = e.target.closest('.btn-remove-row');
                if (removeRowBtn) {
                    const tbody = removeRowBtn.closest('.era-items-body');
                    const row = removeRowBtn.closest('.era-item-row');
                    if (tbody.querySelectorAll('.era-item-row').length > 1) {
                        row.remove();
                        reindexEras();
                    } else {
                        row.querySelectorAll('input').forEach(input => input.value = '');
                    }
                    return;
                }

                const removeEraBtn = e.target.closest('.btn-remove-era');
                if (removeEraBtn) {
                    const eraBlock = removeEraBtn.closest('.era-block');
                    if (erasContainer.querySelectorAll('.era-block').length > 1) {
                        eraBlock.remove();
                        reindexEras();
                    } else {
                        alert('Minimal harus terdapat 1 Era kepemimpinan.');
                    }
                }
            });
        });
    </script>
@endpush
