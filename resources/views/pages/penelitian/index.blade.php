@extends('layouts.dashboard.template')

@push('styles')
<style>
    .penelitian-table {
        font-size: 11px !important;
    }
    .penelitian-table th,
    .penelitian-table td {
        font-size: 11px !important;
        padding: 8px 10px !important;
        vertical-align: middle;
    }
    .penelitian-table .badge,
    .penelitian-table .small {
        font-size: 11px !important;
    }
    .penelitian-action-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 2px 0;
    }
    .penelitian-action-btn {
        width: 28px !important;
        height: 28px !important;
        padding: 0 !important;
        border-radius: 7px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 12px !important;
        line-height: 1 !important;
        transition: all 0.18s ease;
    }
    .penelitian-pagination-wrap nav {
        display: flex;
        align-items: center;
    }
    .penelitian-pagination-wrap nav > div:first-child,
    .penelitian-pagination-wrap nav p.small {
        display: none !important;
    }
    .penelitian-pagination-wrap .pagination {
        margin: 0 !important;
        display: flex !important;
        gap: 4px !important;
    }
    .penelitian-pagination-wrap .page-link {
        border-radius: 7px !important;
        padding: 4px 10px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
    }
    .penelitian-pagination-wrap .page-item.active .page-link {
        background-color: #000000 !important;
        border-color: #000000 !important;
        color: #f9dc4b !important;
    }
    .penelitian-pagination-wrap .page-item:not(.disabled) .page-link:hover {
        background-color: #f9dc4b !important;
        border-color: #f9dc4b !important;
        color: #000000 !important;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Penelitian & Pengabdian Masyarakat</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Penelitian & Pengabdian</li>
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

{{-- Filter Tabs --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('penelitian.index', ['jenis' => 'all']) }}"
       class="btn {{ $activeJenis === 'all' ? 'btn-dark text-warning' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-grid-fill me-1"></i> Semua
        <span class="badge {{ $activeJenis === 'all' ? 'bg-warning text-dark' : 'bg-secondary' }} ms-1">{{ $stats['all'] }}</span>
    </a>
    <a href="{{ route('penelitian.index', ['jenis' => 'penelitian']) }}"
       class="btn {{ $activeJenis === 'penelitian' ? 'btn-primary' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-microscope me-1"></i> Penelitian
        <span class="badge {{ $activeJenis === 'penelitian' ? 'bg-white text-primary' : 'bg-primary' }} ms-1">{{ $stats['penelitian'] }}</span>
    </a>
    <a href="{{ route('penelitian.index', ['jenis' => 'pengabdian']) }}"
       class="btn {{ $activeJenis === 'pengabdian' ? 'btn-success' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-people-fill me-1"></i> Pengabdian Masyarakat
        <span class="badge {{ $activeJenis === 'pengabdian' ? 'bg-white text-success' : 'bg-success' }} ms-1">{{ $stats['pengabdian'] }}</span>
    </a>
</div>

<section class="section">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
                <div>
                    <h5 class="card-title p-0 mb-1 fw-bold">
                        <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>Daftar Penelitian & Pengabdian Masyarakat
                    </h5>
                    <p class="text-muted small mb-0">Kelola data Tridharma (Penelitian & Pengabdian Masyarakat) Program Studi per tahun untuk halaman publik dan akreditasi.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="{{ route('penelitian.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                        <input type="hidden" name="jenis" value="{{ $activeJenis }}">
                        <select name="tahun" class="form-select form-select-sm" style="width: 115px;" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ (string) $activeTahun === (string) $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul, ketua, dana..." value="{{ $search }}">
                            <button class="btn btn-outline-secondary" type="submit" aria-label="Cari"><i class="bi bi-search"></i></button>
                        </div>
                    </form>

                    <button type="button" class="btn btn-dark btn-sm fw-semibold text-warning" data-bs-toggle="modal" data-bs-target="#modalAddPenelitian">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Data
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle penelitian-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 42px;" class="text-center">No</th>
                            <th style="width: 68px;" class="text-center">Tahun</th>
                            <th style="width: 110px;">Jenis</th>
                            <th>Judul & Bidang Riset</th>
                            <th style="width: 220px;">Ketua & Anggota</th>
                            <th style="width: 150px;">Sumber Dana</th>
                            <th style="width: 82px;" class="text-center">Status</th>
                            <th style="width: 88px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $items->firstItem() + $index }}</td>
                                <td class="text-center fw-bold">{{ $item->tahun }}</td>
                                <td>
                                    @if($item->jenis === 'pengabdian')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Pengabdian</span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Penelitian</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->judul }}</div>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mt-1">
                                        @if($item->bidang_riset)
                                            <span class="text-muted"><i class="bi bi-tag me-1"></i>{{ $item->bidang_riset }}</span>
                                        @endif
                                        @if($item->link_publikasi)
                                            <a href="{{ $item->link_publikasi }}" target="_blank" rel="noopener" class="text-primary text-decoration-none fw-semibold">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>Publikasi
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->ketua }}</div>
                                    @if($item->anggota)
                                        <div class="text-muted mt-1" style="line-height: 1.35;">Anggota: {{ $item->anggota }}</div>
                                    @endif
                                </td>
                                <td>{{ $item->sumber_dana ?: '-' }}</td>
                                <td class="text-center">
                                    @if($item->is_active)
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="penelitian-action-wrap">
                                        <button type="button"
                                            class="btn btn-outline-primary penelitian-action-btn btn-edit-penelitian"
                                            title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditPenelitian"
                                            data-id="{{ $item->id }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-judul="{{ $item->judul }}"
                                            data-ketua="{{ $item->ketua }}"
                                            data-anggota="{{ $item->anggota }}"
                                            data-sumber_dana="{{ $item->sumber_dana }}"
                                            data-tahun="{{ $item->tahun }}"
                                            data-bidang_riset="{{ $item->bidang_riset }}"
                                            data-link_publikasi="{{ $item->link_publikasi }}"
                                            data-is_active="{{ $item->is_active ? '1' : '0' }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('penelitian.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data penelitian/pengabdian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger penelitian-action-btn" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-journal-x d-block fs-2 mb-2 opacity-50"></i>
                                    Belum ada data penelitian atau pengabdian masyarakat. Klik <strong>+ Tambah Data</strong> untuk mulai menambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                    <div class="small text-muted">
                        Menampilkan {{ $items->firstItem() }} s/d {{ $items->lastItem() }} dari {{ $items->total() }} data
                    </div>
                    <div class="penelitian-pagination-wrap">
                        {{ $items->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<datalist id="bidangRisetList">
    <option value="Rekayasa Perangkat Lunak">
    <option value="Kecerdasan Buatan & Data Science">
    <option value="Jaringan Komputer & Keamanan Siber">
    <option value="Sistem Informasi & Enterprise">
    <option value="Internet of Things (IoT) & Sistem Tertanam">
    <option value="Komputasi Awan & DevOps">
</datalist>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalAddPenelitian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Tambah Penelitian / Pengabdian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penelitian.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Kegiatan <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-select" required>
                                <option value="penelitian" {{ old('jenis', $activeJenis === 'pengabdian' ? 'pengabdian' : 'penelitian') === 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                                <option value="pengabdian" {{ old('jenis', $activeJenis === 'pengabdian' ? 'pengabdian' : 'penelitian') === 'pengabdian' ? 'selected' : '' }}>Pengabdian Masyarakat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" min="2000" max="2100" value="{{ old('tahun', date('Y')) }}" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Sumber Dana</label>
                            <input type="text" name="sumber_dana" class="form-control" placeholder="Contoh: Kemendikbudristek / Hibah Internal UIS" value="{{ old('sumber_dana') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Judul Penelitian / Pengabdian <span class="text-danger">*</span></label>
                            <textarea name="judul" class="form-control" rows="2" required placeholder="Tuliskan judul lengkap kegiatan...">{{ old('judul') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ketua Pelaksana <span class="text-danger">*</span></label>
                            <input type="text" name="ketua" class="form-control" placeholder="Nama lengkap & gelar ketua" value="{{ old('ketua') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bidang Riset / Kelompok Keahlian</label>
                            <input type="text" name="bidang_riset" class="form-control" list="bidangRisetList" placeholder="Contoh: Kecerdasan Buatan & Data Science" value="{{ old('bidang_riset') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Anggota Tim</label>
                            <input type="text" name="anggota" class="form-control" placeholder="Pisahkan dengan koma (misal: Dr. Budi, M.Kom; Andi Pratama)" value="{{ old('anggota') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Tautan Publikasi / Laporan (Opsional)</label>
                            <input type="url" name="link_publikasi" class="form-control" placeholder="https://doi.org/... atau https://jurnal..." value="{{ old('link_publikasi') }}">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="addIsActive" name="is_active" value="1" checked>
                                <label class="form-check-label fw-semibold" for="addIsActive">Tampilkan di halaman publik</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark text-warning fw-semibold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditPenelitian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Penelitian / Pengabdian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditPenelitian" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Kegiatan <span class="text-danger">*</span></label>
                            <select name="jenis" id="editJenis" class="form-select" required>
                                <option value="penelitian">Penelitian</option>
                                <option value="pengabdian">Pengabdian Masyarakat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" id="editTahun" class="form-control" min="2000" max="2100" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Sumber Dana</label>
                            <input type="text" name="sumber_dana" id="editSumberDana" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Judul Penelitian / Pengabdian <span class="text-danger">*</span></label>
                            <textarea name="judul" id="editJudul" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ketua Pelaksana <span class="text-danger">*</span></label>
                            <input type="text" name="ketua" id="editKetua" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bidang Riset / Kelompok Keahlian</label>
                            <input type="text" name="bidang_riset" id="editBidangRiset" class="form-control" list="bidangRisetList">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Anggota Tim</label>
                            <input type="text" name="anggota" id="editAnggota" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Tautan Publikasi / Laporan (Opsional)</label>
                            <input type="url" name="link_publikasi" id="editLinkPublikasi" class="form-control">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editIsActive" name="is_active" value="1">
                                <label class="form-check-label fw-semibold" for="editIsActive">Tampilkan di halaman publik</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark text-warning fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formEdit = document.getElementById('formEditPenelitian');
    const baseUrl = "{{ url('/admin-penelitian') }}";

    document.querySelectorAll('.btn-edit-penelitian').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            formEdit.action = baseUrl + '/' + id;
            document.getElementById('editJenis').value = this.dataset.jenis || 'penelitian';
            document.getElementById('editTahun').value = this.dataset.tahun || '';
            document.getElementById('editSumberDana').value = this.dataset.sumber_dana || '';
            document.getElementById('editJudul').value = this.dataset.judul || '';
            document.getElementById('editKetua').value = this.dataset.ketua || '';
            document.getElementById('editBidangRiset').value = this.dataset.bidang_riset || '';
            document.getElementById('editAnggota').value = this.dataset.anggota || '';
            document.getElementById('editLinkPublikasi').value = this.dataset.link_publikasi || '';
            document.getElementById('editIsActive').checked = this.dataset.is_active === '1';
        });
    });
});
</script>
@endpush
