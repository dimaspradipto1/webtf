@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Kurikulum Program Studi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Akademik</li>
            <li class="breadcrumb-item active">Kurikulum</li>
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

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'kurikulum',
    'pageTitle' => 'Kurikulum Program Studi',
    'defaultJudul' => 'Kurikulum & Capaian Pembelajaran',
    'defaultSubjudul' => 'Struktur kurikulum berbasis kompetensi dan Outcome-Based Education (OBE) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.'
])

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-journal-text me-2 text-primary"></i>Daftar Kurikulum & Matakuliah UIS
        </h5>
        <a href="{{ route('kurikulum.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Matakuliah
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            Kelola daftar matakuliah kurikulum per program studi dan per semester. Anda dapat mengunggah file RPS (Rencana Pembelajaran Semester) dalam format PDF untuk diunduh mahasiswa.
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
@endpush
