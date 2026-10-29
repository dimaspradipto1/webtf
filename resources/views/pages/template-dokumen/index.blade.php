@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>SOP (Standar Operasional Prosedur)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Portal Layanan</li>
            <li class="breadcrumb-item active">SOP</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-file-earmark-check me-2 text-warning"></i>Daftar Berkas SOP
        </h5>
        <a href="{{ route('template-dokumen.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah SOP
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info SOP:</strong> Kelola berkas dan tautan dokumen Standar Operasional Prosedur (SOP). Seluruh SOP yang berstatus aktif otomatis tampil pada tabel portal publik <a href="{{ route('homepage.template-dokumen') }}" target="_blank" class="fw-bold text-decoration-underline">/template-dokumen (SOP)</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        @if($templates->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text text-muted" style="font-size: 48px;"></i>
                <p class="mt-2 text-muted fw-semibold">Belum ada dokumen SOP yang ditambahkan.</p>
                <a href="{{ route('template-dokumen.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah SOP Pertama
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center" style="font-size: 13.5px;">
                            <th style="width: 5%;">No</th>
                            <th style="width: 40%; text-align: left;">Nama Dokumen SOP</th>
                            <th style="width: 10%;">Format</th>
                            <th style="width: 18%;">Link Document</th>
                            <th style="width: 8%;">Urutan</th>
                            <th style="width: 9%;">Status</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $index => $item)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>
                                
                                {{-- Judul --}}
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">{{ $item->judul }}</span>
                                </td>

                                {{-- Format --}}
                                <td class="text-center">
                                    <span class="badge" style="background-color: #0b1626; color: #fff; font-size: 11px; padding: 5px 10px;">
                                        .{{ strtolower($item->tipe_file ?: 'pdf') }}
                                    </span>
                                </td>

                                {{-- Link Google Drive --}}
                                <td class="text-center">
                                    @if($item->link_drive && $item->link_drive !== '#')
                                        <a href="{{ $item->link_drive }}" target="_blank" rel="noopener noreferrer" 
                                           class="btn btn-sm text-white rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center gap-1"
                                           style="font-size: 12px; background: #0b1626; border: 1px solid #0b1626;">
                                            <i class="bi bi-file-earmark-text-fill"></i> Document
                                        </a>
                                    @else
                                        <span class="text-muted small"># (Belum Ada Link)</span>
                                    @endif
                                </td>

                                {{-- Urutan --}}
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $item->urutan }}</span>
                                </td>

                                {{-- Status Aktif --}}
                                <td class="text-center">
                                    @if($item->is_active)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                    @else
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                        <a href="{{ route('template-dokumen.edit', $item->id) }}" 
                                           class="btn btn-sm btn-warning text-white" 
                                           style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"
                                           title="Edit SOP">
                                            <i class="bi bi-pencil-fill" style="font-size: 12px;"></i>
                                        </a>
                                        <form action="{{ route('template-dokumen.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="m-0 form-delete-sop">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;"
                                                    title="Hapus SOP"
                                                    data-name="{{ $item->judul }}"
                                                    onclick="confirmDeleteSop(event, this)">
                                                <i class="bi bi-trash-fill" style="font-size: 12px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteSop(e, btn) {
        if (e) e.preventDefault();
        const form = btn.closest('form');
        const itemName = btn.getAttribute('data-name') || 'dokumen SOP ini';

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
