@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kontak</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Kontak</li>
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
    'pageKey' => 'kontak',
    'pageTitle' => 'Kontak',
    'defaultJudul' => 'Hubungi Kami',
    'defaultSubjudul' => 'Informasi alamat kampus, kontak resmi, surel, dan saluran konsultasi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.'
])

<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0 fw-semibold">
            <i class="bi bi-telephone-fill me-2 text-primary"></i>Daftar Kontak
        </h5>
        @if(!\App\Models\Contact::exists())
        <a href="{{ route('contact.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kontak
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
