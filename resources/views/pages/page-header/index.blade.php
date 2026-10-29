@extends('layouts.dashboard.template')

@section('title', 'Pengaturan Header & Breadcrumb Halaman Frontend')

@section('content')
<div class="pagetitle">
    <h1>Pengaturan Header & Breadcrumb Halaman</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item active">Header & Breadcrumb Frontend</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada input form:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Info Alert --}}
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4 rounded-4" style="background: #eef7ff; color: #0369a1;">
                <i class="bi bi-info-circle-fill fs-4 mt-1 text-primary"></i>
                <div>
                    <h6 class="fw-bold mb-1" style="color: #0c4a6e;">Pusat Kontrol Header & Breadcrumb Frontend</h6>
                    <p class="mb-0 small" style="line-height: 1.6;">
                        Semua judul utama dan ringkasan subjudul yang tampil pada banner hero atas di halaman publik dapat disesuaikan di sini. Perubahan akan langsung tersinkronisasi ke tampilan hero banner dan navigasi breadcrumb di seluruh halaman frontend website.
                    </p>
                </div>
            </div>

            {{-- Nav Tabs Kategori --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-2 p-md-3">
                    <ul class="nav nav-pills nav-fill flex-wrap gap-2" id="headerTabs" role="tablist">
                        @foreach($categories as $catName => $keys)
                            @php
                                $tabId = Str::slug($catName);
                                $isActive = ($activeTab === $catName) || ($loop->first && empty(request('tab')));
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2 px-3 fw-bold rounded-3 {{ $isActive ? 'active' : 'bg-light text-dark' }}" 
                                        id="tab-{{ $tabId }}" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#content-{{ $tabId }}" 
                                        type="button" 
                                        role="tab"
                                        style="{{ $isActive ? 'background: #000000; color: #ffffff;' : '' }}">
                                    @php
                                        $catIcons = [
                                            'Akademik' => 'bi-mortarboard',
                                            'Profil' => 'bi-building',
                                            'Civitas' => 'bi-person-workspace',
                                            'Portal Layanan' => 'bi-compass',
                                            'PMB' => 'bi-person-plus',
                                            'Informasi & Galeri' => 'bi-newspaper',
                                        ];
                                        $icon = $catIcons[$catName] ?? 'bi-folder';
                                    @endphp
                                    <i class="bi {{ $icon }} me-1 {{ $isActive ? 'text-warning' : 'text-primary' }}"></i>
                                    {{ $catName }}
                                    <span class="badge {{ $isActive ? 'bg-warning text-dark' : 'bg-secondary text-white' }} rounded-pill ms-1">{{ count($keys) }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Tab Content --}}
            <div class="tab-content" id="headerTabsContent">
                @foreach($categories as $catName => $keys)
                    @php
                        $tabId = Str::slug($catName);
                        $isActive = ($activeTab === $catName) || ($loop->first && empty(request('tab')));
                    @endphp
                    <div class="tab-pane fade {{ $isActive ? 'show active' : '' }}" id="content-{{ $tabId }}" role="tabpanel">
                        <div class="row g-4">
                            @foreach($keys as $pageKey)
                                @php
                                    $h = $headers[$pageKey] ?? \App\Models\PageHeader::get($pageKey);
                                    $meta = \App\Models\PageHeader::$masterDefaults[$pageKey] ?? [];
                                    $pageLabel = $meta['judul'] ?? ucwords(str_replace('-', ' ', $pageKey));
                                @endphp
                                <div class="col-12">
                                    <form action="{{ route('page-header.update', $pageKey) }}" method="POST">
                                        @csrf
                                        <div class="card shadow-sm border-0 rounded-4">
                                            <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-sliders text-warning fs-5"></i>
                                                    <h6 class="card-title mb-0 p-0 fw-bold text-dark">
                                                        Pengaturan Header Halaman {{ $pageLabel }}
                                                    </h6>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-light text-muted border px-2 py-1 small">
                                                        Key: <code>{{ $pageKey }}</code>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-dark">
                                                            Judul Utama Halaman <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" 
                                                               name="judul" 
                                                               class="form-control" 
                                                               value="{{ old('judul', $h->judul) }}" 
                                                               placeholder="Judul besar header halaman..." 
                                                               required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-dark">
                                                            Subjudul / Ringkasan Header
                                                        </label>
                                                        <input type="text" 
                                                               name="subjudul" 
                                                               class="form-control" 
                                                               value="{{ old('subjudul', $h->subjudul) }}" 
                                                               placeholder="Ketik ringkasan singkat pengantar...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-tag-fill text-warning me-1"></i> Tampil pada breadcrumb: <strong>{{ $h->breadcrumb_label ?: $h->judul }}</strong>
                                                </small>
                                                <button type="submit" class="btn px-4 rounded-3 fw-bold text-white shadow-sm" style="background: #000000; border: none !important;">
                                                    <i class="bi bi-check2-circle me-1" style="color: #f9dc4b;"></i> Simpan Header
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
@endsection

