@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>E-Dokumen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Portal Layanan</li>
            <li class="breadcrumb-item active">E-Dokumen</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-folder2-open me-2 text-warning"></i>Daftar Berkas E-Dokumen
        </h5>
        <a href="{{ route('unduhan.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah E-Dokumen
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info E-Dokumen:</strong> Kelola berkas dan panduan dokumen resmi akademik (seperti Pedoman Akademik FST, Panduan Skripsi, Panduan KP, dll). Seluruh dokumen yang berstatus aktif otomatis tampil pada tabel portal publik <a href="{{ route('homepage.unduhan') }}" target="_blank" class="fw-bold text-decoration-underline">/unduhan (E-Dokumen)</a>.
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
@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
        function confirmDeleteUnduhan(e, btn) {
            if (e) e.preventDefault();
            const form = btn.closest('form');
            const itemName = btn.getAttribute('data-name') || 'item unduhan ini';

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus "' + itemName + '"? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash-fill me-1"></i> Ya, Hapus!',
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
        }
    </script>
@endpush
