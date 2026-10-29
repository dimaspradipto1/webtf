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

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-images me-2 text-primary"></i>Daftar Foto Galeri
        </h5>
        {{-- <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Foto
        </a> --}}
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
