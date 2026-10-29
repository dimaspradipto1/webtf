@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Prestasi Mahasiswa</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Kemahasiswaan</li>
            <li class="breadcrumb-item active">Prestasi Mahasiswa</li>
        </ol>
    </nav>
</div>

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'prestasi',
    'pageTitle' => 'Prestasi Mahasiswa',
    'defaultJudul' => 'Prestasi Mahasiswa Teknik Informatika',
    'defaultSubjudul' => 'Koleksi prestasi gemilang, medali kejuaraan, dan capaian membanggakan sivitas akademika Teknik Informatika di tingkat regional, nasional, dan internasional.'
])

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-trophy-fill text-warning me-2"></i>Daftar Prestasi Mahasiswa
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('homepage') }}#prestasi" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Preview di Website
            </a>
            <a href="{{ route('prestasi.create') }}" class="btn btn-primary btn-sm" style="background: #000000; border: none !important;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Prestasi
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info:</strong> Data prestasi mahasiswa yang berstatus <strong>Aktif</strong> akan otomatis ditampilkan pada showcase kartu <strong>Prestasi Mahasiswa</strong> di beranda website.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle']) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
