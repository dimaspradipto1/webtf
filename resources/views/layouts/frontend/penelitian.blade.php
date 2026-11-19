@extends('layouts.frontend.template')

@section('content')
@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'penelitian',
    'defaultJudul' => 'Penelitian & Pengabdian Masyarakat',
    'defaultSubjudul' => 'Daftar kegiatan Penelitian dan Pengabdian kepada Masyarakat dosen serta kelompok riset Program Studi S1 Teknik Informatika.',
    'breadcrumb' => [
        ['label' => 'Beranda', 'url' => route('homepage')],
        ['label' => 'Publikasi', 'url' => null],
        ['label' => 'Penelitian & Pengabdian', 'url' => null],
    ],
])

<style>
    .research-section {
        background: #f8fafc;
        padding: 56px 0 80px;
    }
    .research-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
    }
    .research-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .research-filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }
    .research-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        color: #334155;
        background: #ffffff;
        transition: all 0.2s ease;
    }
    .research-tab-btn:hover {
        border-color: #000000;
        color: #000000;
        background: #fef9c3;
    }
    .research-tab-btn.active {
        background: #000000;
        border-color: #000000;
        color: #f9dc4b;
    }
    .research-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    }
    .research-table {
        margin-bottom: 0;
    }
    .research-table thead th {
        background: #000000;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        padding: 14px 16px;
        border: none;
        white-space: nowrap;
    }
    .research-table tbody td {
        padding: 16px;
        vertical-align: top;
        font-size: 13.5px;
        color: #1e293b;
        border-color: #f1f5f9;
    }
    .research-table tbody tr:hover {
        background: #f8fafc;
    }
    .research-badge-penelitian {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .research-badge-pengabdian {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 700;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .research-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #0f172a;
        font-size: 12.5px;
        font-weight: 600;
    }
    .btn-publikasi-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #000000;
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-publikasi-link:hover {
        background: #f9dc4b;
        color: #000000;
    }
</style>

<section class="research-section">
    <div class="container">
        {{-- KPI Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="research-stat-card">
                    <div class="research-stat-icon" style="background: #fef9c3; color: #854d0e;">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Tridharma</div>
                        <div class="fs-4 fw-bold text-dark">{{ $stats['all'] }} Kegiatan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="research-stat-card">
                    <div class="research-stat-icon" style="background: #eff6ff; color: #1d4ed8;">
                        <i class="bi bi-cpu-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Penelitian Dosen</div>
                        <div class="fs-4 fw-bold text-dark">{{ $stats['penelitian'] }} Judul</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="research-stat-card">
                    <div class="research-stat-icon" style="background: #ecfdf5; color: #047857;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Pengabdian Masyarakat</div>
                        <div class="fs-4 fw-bold text-dark">{{ $stats['pengabdian'] }} Kegiatan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kelompok Riset / Bidang Keahlian Dosen --}}
        <div class="research-filter-bar mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div>
                    <h6 class="fw-bold text-dark mb-1"><i class="bi bi-diagram-3-fill me-2 text-warning"></i>Kelompok Riset & Bidang Keahlian</h6>
                    <p class="text-muted small mb-0">Fokus penelitian dosen Program Studi S1 Teknik Informatika beserta profil SINTA & Google Scholar.</p>
                </div>
                <a href="{{ route('homepage.dosen') }}" class="btn btn-sm btn-dark text-warning fw-semibold rounded-pill px-3">
                    <i class="bi bi-person-badge me-1"></i> Lihat Profil & SINTA Dosen
                </a>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @php
                    $defaultClusters = collect([
                        'Rekayasa Perangkat Lunak',
                        'Kecerdasan Buatan & Data Science',
                        'Jaringan Komputer & Keamanan Siber',
                        'Sistem Informasi & Enterprise',
                    ]);
                    $clusters = $bidangRiset->isNotEmpty() ? $bidangRiset : $defaultClusters;
                @endphp
                @foreach($clusters as $cluster)
                    <a href="{{ route('homepage.penelitian', ['q' => $cluster]) }}" class="research-chip text-decoration-none">
                        <i class="bi bi-stars text-warning"></i> {{ $cluster }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Filter & Search Bar --}}
        <div class="research-filter-bar">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('homepage.penelitian', ['jenis' => 'all', 'tahun' => $activeTahun, 'q' => $search]) }}"
                       class="research-tab-btn {{ $activeJenis === 'all' ? 'active' : '' }}">
                        Semua ({{ $stats['all'] }})
                    </a>
                    <a href="{{ route('homepage.penelitian', ['jenis' => 'penelitian', 'tahun' => $activeTahun, 'q' => $search]) }}"
                       class="research-tab-btn {{ $activeJenis === 'penelitian' ? 'active' : '' }}">
                        Penelitian ({{ $stats['penelitian'] }})
                    </a>
                    <a href="{{ route('homepage.penelitian', ['jenis' => 'pengabdian', 'tahun' => $activeTahun, 'q' => $search]) }}"
                       class="research-tab-btn {{ $activeJenis === 'pengabdian' ? 'active' : '' }}">
                        Pengabdian Masyarakat ({{ $stats['pengabdian'] }})
                    </a>
                </div>

                <form action="{{ route('homepage.penelitian') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    <input type="hidden" name="jenis" value="{{ $activeJenis }}">
                    <select name="tahun" class="form-select form-select-sm rounded-pill px-3" style="width: 140px;" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ (string) $activeTahun === (string) $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                        @endforeach
                    </select>
                    <div class="input-group input-group-sm" style="width: 240px;">
                        <input type="text" name="q" class="form-control rounded-start-pill ps-3" placeholder="Cari judul, ketua, dana..." value="{{ $search }}">
                        <button type="submit" class="btn btn-dark text-warning rounded-end-pill px-3" aria-label="Cari">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    @if($activeJenis !== 'all' || $activeTahun || $search !== '')
                        <a href="{{ route('homepage.penelitian') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="research-table-card">
            <div class="table-responsive">
                <table class="table research-table">
                    <thead>
                        <tr>
                            <th style="width: 56px;" class="text-center">No</th>
                            <th style="width: 82px;" class="text-center">Tahun</th>
                            <th style="width: 130px;">Jenis</th>
                            <th>Judul Penelitian / Pengabdian</th>
                            <th style="width: 240px;">Ketua & Anggota</th>
                            <th style="width: 170px;">Sumber Dana</th>
                            <th style="width: 120px;" class="text-center">Publikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $items->firstItem() + $index }}</td>
                                <td class="text-center fw-bold text-dark">{{ $item->tahun }}</td>
                                <td>
                                    @if($item->jenis === 'pengabdian')
                                        <span class="research-badge-pengabdian">Pengabdian</span>
                                    @else
                                        <span class="research-badge-penelitian">Penelitian</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark" style="line-height: 1.45;">{{ $item->judul }}</div>
                                    @if($item->bidang_riset)
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-tag-fill text-warning me-1"></i>{{ $item->bidang_riset }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $item->ketua }}</div>
                                    @if($item->anggota)
                                        <div class="small text-muted mt-1" style="line-height: 1.4;">
                                            <span class="fw-semibold">Anggota:</span> {{ $item->anggota }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->sumber_dana ?: '-' }}</td>
                                <td class="text-center">
                                    @if($item->link_publikasi)
                                        <a href="{{ $item->link_publikasi }}" target="_blank" rel="noopener noreferrer" class="btn-publikasi-link">
                                            <i class="bi bi-box-arrow-up-right"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-journal-text d-block fs-1 mb-2 opacity-50"></i>
                                    <div class="fw-semibold text-dark">Belum ada data penelitian atau pengabdian yang ditemukan.</div>
                                    <div class="small mt-1">Silakan ubah filter pencarian atau hubungi administrator program studi.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 px-4 py-3 border-top bg-light">
                    <div class="small text-muted">
                        Menampilkan {{ $items->firstItem() }} s/d {{ $items->lastItem() }} dari {{ $items->total() }} data
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
