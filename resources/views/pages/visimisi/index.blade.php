@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Visi, Misi, Tujuan & Sasaran (VMTS)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">VMTS (Visi, Misi, Tujuan & Sasaran)</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-flag me-2 text-primary"></i>Daftar Visi, Misi, Tujuan & Sasaran (VMTS)
        </h5>
        <a href="{{ route('visimisi.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Poin VMTS
        </a>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Tips:</strong> Kelola keempat komponen <strong>VMTS</strong> (<span class="badge bg-primary">Visi</span>, <span class="badge bg-info text-dark">Misi</span>, <span class="badge bg-success">Tujuan</span>, dan <span class="badge bg-warning text-dark">Sasaran</span>) — tambahkan poin satu per satu sesuai tipenya dan atur <strong>Urutan</strong> tampilnya.
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
