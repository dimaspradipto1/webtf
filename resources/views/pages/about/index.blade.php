@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Profil Pimpinan & Prodi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Profil Pimpinan & Prodi</li>
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

{{-- 1. KELOLA PROFIL PIMPINAN --}}
<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <div>
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-people-fill me-2 text-dark"></i>Daftar Profil Pimpinan (YAPISTA, Universitas, Fakultas & Prodi)
            </h5>
            <small class="text-muted">Kelola foto pimpinan, jabatan, urutan baris tampilan, serta biodata lengkap untuk menu <strong>Lihat Profil</strong>.</small>
        </div>
        <a href="{{ route('pimpinan.create') }}" class="btn btn-dark btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Profil Pimpinan
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th style="width: 95px;" class="text-center">Foto</th>
                        <th>Nama Lengkap & Gelar</th>
                        <th>Jabatan</th>
                        <th style="width: 130px;" class="text-center">Baris / Urutan</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <th style="width: 190px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pimpinans ?? [] as $idx => $item)
                        <tr>
                            <td class="text-center">{{ $idx + 1 }}</td>
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" style="width: 64px; height: auto; display: block; margin: 0 auto;">
                                @else
                                    <span class="badge bg-secondary">Belum ada foto</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                @if($item->email || $item->tempat_tanggal_lahir)
                                    <div class="small text-muted mt-1">
                                        @if($item->tempat_tanggal_lahir)
                                            <span><i class="bi bi-calendar3 me-1"></i>{{ $item->tempat_tanggal_lahir }}</span>
                                        @endif
                                        @if($item->email)
                                            <span class="ms-2"><i class="bi bi-envelope me-1"></i>{{ $item->email }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->jabatan }}</td>
                            <td class="text-center">
                                <span class="badge bg-dark">Baris {{ $item->baris }}</span>
                                <div class="small text-muted mt-1">Urutan #{{ $item->urutan }}</div>
                            </td>
                            <td class="text-center">
                                @if($item->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('homepage.pimpinan.detail', $item->slug) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="Lihat Profil Publik">
                                        <i class="bi bi-eye"></i> Lihat Profil
                                    </a>
                                    <a href="{{ route('pimpinan.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pimpinan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pimpinan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data Profil Pimpinan. Klik tombol <strong>Tambah Profil Pimpinan</strong> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 2. PROFIL PROGRAM STUDI / TENTANG KAMI --}}
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-info-circle-fill me-2 text-primary"></i>Profil Program Studi (Deskripsi & Video Profil)
        </h5>
        @if(!\App\Models\About::exists())
        <a href="{{ route('about.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Profil
        </a>
        @endif
    </div>
    <div class="card-body pt-3">
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
@endpush
