@extends('layouts.dashboard.template')

@push('styles')
<style>
    .stat-admin-table {
        font-size: 11.5px !important;
    }
    .stat-admin-table th,
    .stat-admin-table td {
        font-size: 11.5px !important;
        padding: 8px 10px !important;
        vertical-align: middle;
    }
    .stat-admin-table .form-control-sm {
        font-size: 12px !important;
    }
    .stat-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
    }
    .stat-preview-card {
        background: #fefce8;
        border: 1px solid #f3e8c0;
        border-radius: 14px;
        padding: 16px 12px;
        text-align: center;
    }
    .stat-preview-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .stat-preview-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }
    .stat-action-btn {
        width: 28px !important;
        height: 28px !important;
        padding: 0 !important;
        border-radius: 7px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 12px !important;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Angka Statistik Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Konten Beranda</li>
            <li class="breadcrumb-item active">Angka Statistik Beranda</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <strong>Terdapat kesalahan pengisian:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Pratinjau Langsung --}}
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold mb-0"><i class="bi bi-eye me-2 text-primary"></i>Pratinjau Baris Statistik di Beranda</h6>
                <small class="text-muted">Ditampilkan tepat di bawah Banner Hero pada halaman utama website.</small>
            </div>
            <a href="{{ route('homepage') }}#statistik-beranda" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Beranda
            </a>
        </div>
        <div class="stat-preview-grid">
            @forelse($stats->where('is_active', true) as $preview)
                <div class="stat-preview-card">
                    <div class="stat-preview-value">{{ $preview->nilai }}</div>
                    <div class="stat-preview-label">{{ $preview->label }}</div>
                </div>
            @empty
                <div class="text-muted small">Belum ada kotak statistik yang aktif.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Form Edit Massal --}}
<section class="section">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h5 class="card-title p-0 mb-1 fw-bold">
                        <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>Kelola Kotak Angka Statistik
                    </h5>
                    <p class="text-muted small mb-0">Ubah angka mahasiswa aktif, lulusan, dosen tetap, mitra industri, atau peringkat akreditasi setiap semester, lalu klik <strong>Simpan Semua Perubahan</strong>.</p>
                </div>
                <button type="button" class="btn btn-dark btn-sm fw-semibold text-warning" data-bs-toggle="modal" data-bs-target="#modalAddStat">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kotak Statistik
                </button>
            </div>

            <form action="{{ route('homepage-stat.bulk-update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-hover align-middle stat-admin-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 72px;" class="text-center">Urutan</th>
                                <th style="width: 220px;">Angka / Nilai</th>
                                <th>Label Keterangan</th>
                                <th style="width: 110px;" class="text-center">Tampil</th>
                                <th style="width: 72px;" class="text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stats as $i => $stat)
                                <tr>
                                    <td>
                                        <input type="hidden" name="items[{{ $i }}][id]" value="{{ $stat->id }}">
                                        <input type="number" name="items[{{ $i }}][urutan]" class="form-control form-control-sm text-center" value="{{ old("items.$i.urutan", $stat->urutan) }}" min="0" max="999">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $i }}][nilai]" class="form-control form-control-sm fw-bold" value="{{ old("items.$i.nilai", $stat->nilai) }}" placeholder="Contoh: 1.250+ / Baik Sekali" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $i }}][label]" class="form-control form-control-sm" value="{{ old("items.$i.label", $stat->label) }}" placeholder="Contoh: Mahasiswa Aktif" required>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block mb-0">
                                            <input class="form-check-input" type="checkbox" name="items[{{ $i }}][is_active]" value="1" {{ old("items.$i.is_active", $stat->is_active) ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-outline-danger stat-action-btn btn-delete-stat"
                                            title="Hapus"
                                            data-action="{{ route('homepage-stat.destroy', $stat->id) }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Belum ada data statistik beranda. Klik <strong>+ Tambah Kotak Statistik</strong> untuk menambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stats->isNotEmpty())
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-dark text-warning fw-semibold px-4">
                            <i class="bi bi-save me-1"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</section>

{{-- Hidden Delete Form --}}
<form id="formDeleteStat" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalAddStat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Tambah Kotak Statistik</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('homepage-stat.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Angka / Nilai <span class="text-danger">*</span></label>
                        <input type="text" name="nilai" class="form-control" placeholder="Contoh: 1.250+, 24, atau Baik Sekali" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Label Keterangan <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control" placeholder="Contoh: Mahasiswa Aktif" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" min="0" max="999" value="{{ ($stats->max('urutan') ?? 0) + 1 }}">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="addStatActive" name="is_active" value="1" checked>
                        <label class="form-check-label fw-semibold" for="addStatActive">Tampilkan di Beranda</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark text-warning fw-semibold">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForm = document.getElementById('formDeleteStat');
    document.querySelectorAll('.btn-delete-stat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (confirm('Hapus kotak angka statistik ini?')) {
                deleteForm.action = this.dataset.action;
                deleteForm.submit();
            }
        });
    });
});
</script>
@endpush
