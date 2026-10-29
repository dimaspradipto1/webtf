@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Sarana & Fasilitas</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Sarana & Fasilitas</li>
        </ol>
    </nav>
</div>

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'fasilitas',
    'pageTitle' => 'Fasilitas Kampus',
    'defaultJudul' => 'Fasilitas Kampus & Laboratorium',
    'defaultSubjudul' => 'Sarana laboratorium komputasi modern, perpustakaan, ruang kuliah ber-AC, dan fasilitas penunjang akademik Program Studi Teknik Informatika.'
])

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-building-fill me-2 text-primary"></i>Daftar Sarana & Fasilitas
        </h5>
        <a href="{{ route('sarana.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Sarana
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info:</strong> Data sarana ini akan ditampilkan pada seksi
            <strong>"Fasilitas &amp; Laboratorium Modern"</strong> di halaman utama website.
            Icon diisi menggunakan nama class Bootstrap Icons (contoh: <code>bi-shield-check</code>, <code>bi-pc-display</code>).
            Lihat lengkapnya di <a href="https://icons.getbootstrap.com/" target="_blank" class="alert-link">icons.getbootstrap.com</a>.
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
