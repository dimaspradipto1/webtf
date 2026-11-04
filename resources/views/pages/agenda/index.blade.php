@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Pengumuman & Agenda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Pengumuman & Agenda</li>
            <li class="breadcrumb-item active">Agenda</li>
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

{{-- Tab Navigasi Antar Pengumuman & Agenda --}}
<div class="d-flex gap-2 mb-3">
    <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-semibold bg-white shadow-sm">
        <i class="bi bi-megaphone-fill me-1 text-warning"></i> Pengumuman
        <span class="badge bg-secondary ms-1">{{ $totalAnnouncements ?? 0 }}</span>
    </a>
    <a href="{{ route('agenda.index') }}" class="btn btn-dark rounded-pill px-3 py-2 fw-semibold shadow-sm">
        <i class="bi bi-calendar4-week me-1 text-warning"></i> Agenda
        <span class="badge bg-warning text-dark ms-1">{{ $totalAgendas ?? 0 }}</span>
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-2 py-3 border-bottom">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-calendar4-week text-warning me-2"></i>Daftar Agenda & Kegiatan
            </h5>
            <small class="text-muted">Kelola jadwal perkuliahan, semester antara, ujian, dan agenda kegiatan prodi yang tampil di beranda website.</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('homepage') }}#berita" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-box-arrow-up-right me-1"></i> Preview di Beranda
            </a>
            <a href="{{ route('agenda.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 text-white fw-semibold" style="background: #000000; border: none !important;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Agenda
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-hover table-striped w-100 align-middle']) }}
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

