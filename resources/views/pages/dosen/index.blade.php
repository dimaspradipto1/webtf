@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Tenaga Pendidik / Dosen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Program Studi</li>
            <li class="breadcrumb-item active">Dosen</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'dosen',
    'pageTitle' => 'Daftar Dosen Pengajar',
    'defaultJudul' => 'Daftar Dosen Pengajar',
    'defaultSubjudul' => 'Tenaga pendidik berkualifikasi magister, doktor, dan profesor berdedikasi tinggi dalam membimbing mahasiswa Program Studi Teknik Informatika.'
])

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-person-workspace me-2 text-primary"></i>Daftar Dosen Pengajar UIS
        </h5>
        <div class="d-flex flex-wrap align-items-center gap-2">
            {{-- Tombol Hapus Terpilih --}}
            <button type="button" id="btn-bulk-delete" class="btn btn-danger btn-sm d-none" onclick="confirmBulkDelete()">
                <i class="bi bi-trash-fill me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
            </button>

            {{-- Tombol Hapus Semua --}}
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleteAll()">
                <i class="bi bi-trash3 me-1"></i> Hapus Semua
            </button>

            {{-- Tombol Download Template Excel --}}
            <a href="{{ route('dosen.download-template') }}" class="btn btn-outline-secondary btn-sm" title="Download Template Excel Format Pengisian">
                <i class="bi bi-file-earmark-excel me-1 text-success"></i> Template Excel
            </a>

            {{-- Tombol Import Excel --}}
            <button type="button" class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                <i class="bi bi-file-earmark-arrow-up me-1"></i> Import Excel
            </button>

            {{-- Tombol Tambah Dosen --}}
            <a href="{{ route('dosen.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Dosen
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            Kelola data staf pengajar/dosen masing-masing Program Studi. Anda dapat melakukan pencarian multi-kolom, hapus data terpilih (multi-select), mengosongkan data, hingga impor massal melalui file Excel.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-striped table-bordered align-middle',
                'style' => 'width:100%',
            ]) }}
        </div>
    </div>
</div>

{{-- Form Tersembunyi untuk Bulk Delete --}}
<form id="form-bulk-delete" action="{{ route('dosen.bulk-delete') }}" method="POST" class="d-none">
    @csrf
    <div id="bulk-delete-inputs"></div>
</form>

{{-- Form Tersembunyi untuk Delete All --}}
<form id="form-delete-all" action="{{ route('dosen.delete-all') }}" method="POST" class="d-none">
    @csrf
</form>

{{-- Modal Import Excel --}}
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white" style="background: #000000;">
                <h5 class="modal-title fw-bold" id="importExcelModalLabel">
                    <i class="bi bi-file-earmark-excel me-2 text-warning"></i>Import Data Dosen dari Excel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dosen.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i>Petunjuk Impor:</h6>
                        <ol class="small text-muted mb-2 ps-3">
                            <li>Unduh template resmi terlebih dahulu agar format kolom sesuai.</li>
                            <li>Isi data nama dosen, program studi, jabatan fungsional, NIDN, NUPTK, dan link profil.</li>
                            <li>Simpan dalam format <code>.xlsx</code>, <code>.xls</code>, atau <code>.csv</code> (Maks. 10MB).</li>
                        </ol>
                        <a href="{{ route('dosen.download-template') }}" class="btn btn-sm btn-outline-success fw-semibold">
                            <i class="bi bi-download me-1"></i> Download Format Template Excel (.xlsx)
                        </a>
                    </div>

                    <div class="mb-3">
                        <label for="file_excel" class="form-label fw-semibold text-dark">Pilih File Excel / CSV <span class="text-danger">*</span></label>
                        <input type="file" name="file_excel" id="file_excel" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 text-white fw-semibold">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Mulai Impor Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        $(document).ready(function () {
            // Check All Handler
            $(document).on('change', '#check-all-dosen', function () {
                const isChecked = $(this).is(':checked');
                $('.check-item-dosen').prop('checked', isChecked);
                updateBulkDeleteButton();
            });

            // Single Checkbox Handler
            $(document).on('change', '.check-item-dosen', function () {
                const totalItems = $('.check-item-dosen').length;
                const checkedItems = $('.check-item-dosen:checked').length;
                $('#check-all-dosen').prop('checked', totalItems > 0 && totalItems === checkedItems);
                updateBulkDeleteButton();
            });

            // Re-bind when DataTable redraws
            $(document).on('draw.dt', function () {
                $('#check-all-dosen').prop('checked', false);
                updateBulkDeleteButton();
            });

            function updateBulkDeleteButton() {
                const checkedCount = $('.check-item-dosen:checked').length;
                $('#selected-count').text(checkedCount);
                if (checkedCount > 0) {
                    $('#btn-bulk-delete').removeClass('d-none');
                } else {
                    $('#btn-bulk-delete').addClass('d-none');
                }
            }

            // Confirm Bulk Delete with SweetAlert2
            window.confirmBulkDelete = function () {
                const selected = [];
                $('.check-item-dosen:checked').each(function () {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    Swal.fire('Info', 'Pilih minimal 1 data dosen untuk dihapus.', 'info');
                    return;
                }

                Swal.fire({
                    title: 'Hapus ' + selected.length + ' Dosen Terpilih?',
                    text: 'Data dosen yang dipilih beserta foto profilnya akan dihapus permanen dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus Terpilih',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        const container = $('#bulk-delete-inputs');
                        container.empty();
                        selected.forEach(id => {
                            container.append('<input type="hidden" name="ids[]" value="' + id + '">');
                        });
                        $('#form-bulk-delete').submit();
                    }
                });
            };

            // Confirm Delete All with SweetAlert2
            window.confirmDeleteAll = function () {
                Swal.fire({
                    title: 'Kosongkan SEMUA Data Dosen?',
                    text: 'PERINGATAN: Seluruh data dosen di semua Program Studi akan dihapus permanen!',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-exclamation-triangle-fill me-1"></i> Ya, Hapus Semua Data',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-delete-all').submit();
                    }
                });
            };

            // Confirm Delete Single Item with SweetAlert2
            $(document).on('click', '.btn-delete-dosen-item', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const nama = $(this).data('nama') || 'data dosen ini';

                Swal.fire({
                    title: 'Konfirmasi Hapus Dosen',
                    text: 'Apakah Anda yakin ingin menghapus data dosen "' + nama + '"?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                        cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
