@extends('layouts.frontend.template')

@section('title', $sarana->nama . ' — Fasilitas & Laboratorium Teknik Informatika')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) ($sarana->deskripsi ?: $sarana->nama)), 155))

@section('content')
@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'fasilitas',
    'parentUrl' => route('homepage.fasilitas'),
    'parentLabel' => 'Fasilitas & Laboratorium',
    'defaultJudul' => $sarana->nama,
    'defaultSubjudul' => $sarana->deskripsi ?: 'Informasi lengkap ruangan, kepala laboratorium, daftar perangkat, mata kuliah praktikum, dan jadwal pemakaian.',
    'defaultBreadcrumb' => $sarana->nama,
])

@php
    $perangkatList = $sarana->parseLines($sarana->daftar_perangkat);
    $matkulList = $sarana->parseLines($sarana->mata_kuliah_praktikum);
    $jadwalList = $sarana->parseLines($sarana->jadwal_pemakaian);
@endphp

<style>
    .lab-detail-section {
        background: #f8fafc;
        padding: 48px 0 80px;
    }
    .lab-detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 26px 28px;
        box-shadow: 0 8px 26px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }
    .lab-photo-wrap {
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        margin-bottom: 24px;
    }
    .lab-photo-wrap img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
    }
    .lab-photo-placeholder {
        padding: 54px 24px;
        text-align: center;
        color: #ffffff;
    }
    .lab-photo-placeholder .icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: #f9dc4b;
        color: #000000;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 14px;
    }
    .lab-meta-tile {
        background: #fefce8;
        border: 1px solid #f3e8c0;
        border-radius: 14px;
        padding: 14px 16px;
        height: 100%;
    }
    .lab-meta-label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #854d0e;
        margin-bottom: 4px;
    }
    .lab-meta-value {
        font-size: 14.5px;
        font-weight: 700;
        color: #0f172a;
    }
    .lab-list-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: 13.5px;
        color: #1e293b;
    }
    .lab-course-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-size: 13px;
        font-weight: 600;
    }
    .lab-sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        border: 1px solid transparent;
        transition: all 0.18s ease;
    }
    .lab-sidebar-link:hover {
        background: #fefce8;
        border-color: #f3e8c0;
        color: #000000;
    }
    .lab-sidebar-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

<section class="lab-detail-section">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('homepage.fasilitas') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Fasilitas & Laboratorium
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Foto Ruangan --}}
                <div class="lab-photo-wrap">
                    @if($sarana->foto_url)
                        <img src="{{ $sarana->foto_url }}" alt="{{ $sarana->nama }}">
                    @else
                        <div class="lab-photo-placeholder">
                            <div class="icon-circle">
                                <i class="bi {{ $sarana->icon ?? 'bi-pc-display-horizontal' }}"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $sarana->nama }}</h3>
                            <p class="mb-0 opacity-75 small">Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi</p>
                        </div>
                    @endif
                </div>

                {{-- Ringkasan Info Lab --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="lab-meta-tile">
                            <div class="lab-meta-label"><i class="bi bi-person-badge me-1"></i>Kepala Lab / PJ</div>
                            <div class="lab-meta-value">{{ $sarana->kepala_lab ?: 'Pengelola Laboratorium TI' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="lab-meta-tile">
                            <div class="lab-meta-label"><i class="bi bi-geo-alt-fill me-1"></i>Lokasi Ruangan</div>
                            <div class="lab-meta-value">{{ $sarana->lokasi ?: 'Gedung FST — Kampus UIS' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="lab-meta-tile">
                            <div class="lab-meta-label"><i class="bi bi-people-fill me-1"></i>Kapasitas</div>
                            <div class="lab-meta-value">{{ $sarana->kapasitas ?: '30–40 Mahasiswa' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="lab-detail-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill me-2 text-warning"></i>Profil & Fungsi Ruangan</h5>
                    <p class="text-secondary mb-0" style="line-height: 1.75;">
                        {{ $sarana->deskripsi ?: 'Fasilitas laboratorium dan sarana penunjang praktikum serta riset mahasiswa Program Studi S1 Teknik Informatika.' }}
                    </p>
                </div>

                {{-- Daftar Perangkat --}}
                <div class="lab-detail-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-cpu-fill me-2 text-warning"></i>Daftar Perangkat & Spesifikasi</h5>
                    @if(count($perangkatList) > 0)
                        <div class="d-flex flex-column gap-2">
                            @foreach($perangkatList as $perangkat)
                                <div class="lab-list-item">
                                    <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                    <span>{{ $perangkat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">Daftar perangkat sedang diperbarui oleh pengelola laboratorium.</p>
                    @endif
                </div>

                {{-- Mata Kuliah Praktikum --}}
                <div class="lab-detail-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-book-half me-2 text-warning"></i>Mata Kuliah Praktikum</h5>
                    @if(count($matkulList) > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($matkulList as $mk)
                                <span class="lab-course-badge">
                                    <i class="bi bi-terminal-fill text-warning"></i> {{ $mk }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">Daftar mata kuliah praktikum mengikuti jadwal kurikulum semester berjalan.</p>
                    @endif
                </div>

                {{-- Jadwal Pemakaian --}}
                <div class="lab-detail-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-week-fill me-2 text-warning"></i>Jadwal Pemakaian</h5>
                    @if(count($jadwalList) > 0)
                        <div class="d-flex flex-column gap-2">
                            @foreach($jadwalList as $jadwal)
                                <div class="lab-list-item">
                                    <i class="bi bi-clock-fill text-primary mt-1"></i>
                                    <span>{{ $jadwal }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">Senin – Jumat (08.00 – 21.00 WIB) dan Sabtu sesuai jadwal praktikum serta reservasi riset mahasiswa.</p>
                    @endif
                </div>
            </div>

            {{-- Sidebar Fasilitas Lainnya --}}
            <div class="col-lg-4">
                <div class="lab-detail-card">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-buildings me-2 text-warning"></i>Fasilitas & Laboratorium Lainnya</h6>
                    @if($otherSaranas->isNotEmpty())
                        <div class="d-flex flex-column gap-2">
                            @foreach($otherSaranas as $other)
                                <a href="{{ route('homepage.fasilitas.detail', $other->slug ?: $other->id) }}" class="lab-sidebar-link">
                                    <div class="lab-sidebar-icon">
                                        <i class="bi {{ $other->icon ?? 'bi-building' }}"></i>
                                    </div>
                                    <div class="small fw-semibold">{{ $other->nama }}</div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">Belum ada fasilitas lainnya.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
