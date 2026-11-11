@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Galeri</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Galeri</li>
        </ol>
    </nav>
</div>

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'galeri',
    'pageTitle' => 'Galeri Foto & Dokumentasi',
    'defaultJudul' => 'Galeri Foto & Dokumentasi',
    'defaultSubjudul' => 'Dokumentasi visual kegiatan perkuliahan, praktikum laboratorium, seminar nasional, pengabdian masyarakat, dan wisuda.'
])

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-2 py-3 border-bottom">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-images text-primary me-2"></i>Daftar Foto Galeri
            </h5>
            <small class="text-muted">Kelola dokumentasi visual kegiatan, praktikum laboratorium, seminar, dan agenda kampus.</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('category.index', ['type' => 'galeri']) }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-tags me-1"></i> Kelola Kategori
            </a>
            <a href="{{ route('homepage.galeri') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Web
            </a>
            <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm fw-semibold">
                <i class="bi bi-plus-lg"></i> Tambah Foto Galeri
            </a>
        </div>
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
