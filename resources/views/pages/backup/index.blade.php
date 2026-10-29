@extends('layouts.dashboard.template')

@section('title', 'Backup Database & Storage — Teknik Informatika UIS')

@section('content')
<div class="pagetitle">
    <h1>Backup Database & Storage</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengaturan & Administrator</li>
            <li class="breadcrumb-item active">Backup Database & Storage</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-12">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Target Storage & Status Banner --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill">
                                    <i class="bi bi-hdd-fill me-1"></i> Drive Target: {{ $targetInfo['is_drive_d'] ? 'Drive D:' : 'Lokal' }}
                                </span>
                                <span class="badge bg-success fw-bold px-3 py-2 rounded-pill">
                                    <i class="bi bi-clock-history me-1"></i> Jadwal Otomatis Harian Aktif (01:00 WIB)
                                </span>
                            </div>
                            <h4 class="fw-bold mb-1 text-dark">Pusat Backup & Pemulihan Sistem</h4>
                            <p class="text-muted mb-2 small" style="line-height: 1.6;">
                                File cadangan database MySQL (<code>.sql</code>) dan berkas media storage (<code>.zip</code>) otomatis disimpan langsung ke direktori aman di Drive D:.
                            </p>
                            <div class="d-flex align-items-center flex-wrap gap-2 pt-1">
                                <span class="badge bg-light text-dark border font-monospace px-3 py-2 rounded-3 text-break">
                                    <i class="bi bi-folder2-open text-warning me-1"></i> {{ $targetInfo['directory'] }}
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-3" onclick="copyPath('{{ addslashes($targetInfo['directory']) }}')">
                                    <i class="bi bi-clipboard me-1"></i> Salin Lokasi
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="p-3 bg-light rounded-4 border">
                                <div class="d-flex justify-content-between align-items-center mb-1 small fw-bold">
                                    <span>Kapasitas Drive Target</span>
                                    <span class="text-primary">{{ $targetInfo['free_space'] }} Bebas</span>
                                </div>
                                <div class="progress mb-2" style="height: 10px; border-radius: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $targetInfo['used_percent'] }}%;" aria-valuenow="{{ $targetInfo['used_percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small text-muted">
                                    <span>Total: {{ $targetInfo['total_space'] }}</span>
                                    <span>{{ $targetInfo['total_files'] }} File Backup ({{ $targetInfo['total_backup_size'] }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Cards --}}
            <div class="row g-4 mb-4">
                {{-- Card 1: Backup Database --}}
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 p-3 text-warning bg-warning bg-opacity-10 fs-3">
                                        <i class="bi bi-filetype-sql"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Backup Database</h5>
                                        <small class="text-muted">Struktur & Data MySQL</small>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3">
                                    Mengekspor seluruh tabel, struktur data, relasi, dan konten website ke file SQL standar.
                                </p>
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Format Penamaan File:</small>
                                    <code class="small text-dark font-monospace bg-light p-1 rounded d-block">
                                        {{ now('Asia/Jakarta')->format('Y-m-d') }}_namafile.sql
                                    </code>
                                </div>
                            </div>
                            <form action="{{ route('backup.database') }}" method="POST" onsubmit="return confirmBackup(this, 'Database SQL')">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control form-control-sm rounded-3" placeholder="Label tambahan (opsional)">
                                </div>
                                <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3 py-2 text-dark shadow-sm">
                                    <i class="bi bi-database-down me-1"></i> Backup Database Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Backup Storage --}}
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 p-3 text-primary bg-primary bg-opacity-10 fs-3">
                                        <i class="bi bi-file-earmark-zip"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Backup Storage</h5>
                                        <small class="text-muted">Berkas & Media Upload</small>
                                    </div>
                                </div>
                                <p class="text-muted small mb-3">
                                    Mengompres seluruh foto, avatar, dokumen unduhan, dan aset publik ke dalam satu arsip ZIP.
                                </p>
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-1">Format Penamaan File:</small>
                                    <code class="small text-dark font-monospace bg-light p-1 rounded d-block">
                                        {{ now('Asia/Jakarta')->format('Y-m-d') }}_namafile.zip
                                    </code>
                                </div>
                            </div>
                            <form action="{{ route('backup.storage') }}" method="POST" onsubmit="return confirmBackup(this, 'Storage Uploads')">
                                @csrf
                                <div class="mb-2">
                                    <input type="text" name="name" class="form-control form-control-sm rounded-3" placeholder="Label tambahan (opsional)">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 py-2 shadow-sm">
                                    <i class="bi bi-file-zip-fill me-1"></i> Backup Storage Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Backup Lengkap --}}
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 p-3 text-warning bg-warning bg-opacity-20 fs-3">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0 text-white">Backup Lengkap</h5>
                                        <small class="text-light opacity-75">Database + Storage Sekaligus</small>
                                    </div>
                                </div>
                                <p class="small text-light opacity-75 mb-3" style="line-height: 1.5;">
                                    Menjalankan proses pencadangan menyeluruh untuk menjamin keamanan integritas data sistem dan seluruh berkas media website.
                                </p>
                                <div class="mb-3">
                                    <small class="text-light opacity-75 d-block mb-1">Target Penyimpanan:</small>
                                    <div class="small font-monospace text-warning bg-black bg-opacity-40 p-2 rounded">
                                        <i class="bi bi-hdd me-1"></i> D:\website teknik informatika
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('backup.all') }}" method="POST" onsubmit="return confirmBackup(this, 'Database dan Storage sekaligus')">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3 py-2 text-dark shadow">
                                    <i class="bi bi-arrow-repeat me-1"></i> Jalankan Backup Lengkap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Backup List --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Daftar File Backup di Drive D:</h5>
                        <p class="text-muted small mb-0">Arsip backup database dan storage yang tersimpan di <code>{{ $targetInfo['directory'] }}</code></p>
                    </div>
                    <div>
                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ count($backups) }} File Tersedia</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="backupTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">No</th>
                                    <th>Nama File Backup</th>
                                    <th class="text-center" style="width: 140px;">Tipe</th>
                                    <th style="width: 130px;">Ukuran File</th>
                                    <th style="width: 210px;">Waktu Dibuat</th>
                                    <th class="text-center" style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($item['type'] === 'database')
                                                    <i class="bi bi-database-fill text-warning fs-4"></i>
                                                @else
                                                    <i class="bi bi-file-earmark-zip-fill text-primary fs-4"></i>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark font-monospace">{{ $item['filename'] }}</div>
                                                    <small class="text-muted font-monospace">{{ $item['path'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($item['type'] === 'database')
                                                <span class="badge bg-warning bg-opacity-15 text-dark fw-bold px-3 py-2 rounded-pill border border-warning">
                                                    <i class="bi bi-database me-1"></i> Database SQL
                                                </span>
                                            @else
                                                <span class="badge bg-primary bg-opacity-15 text-primary fw-bold px-3 py-2 rounded-pill border border-primary">
                                                    <i class="bi bi-archive me-1"></i> Storage ZIP
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                                {{ $item['size'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small fw-bold text-dark">{{ $item['created_at'] }}</div>
                                            <small class="text-muted">{{ $item['created_at_human'] }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('backup.download', $item['filename']) }}" class="btn btn-sm btn-outline-success rounded-3" title="Unduh File">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                                <form action="{{ route('backup.destroy', $item['filename']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file backup {{ $item['filename'] }}? Tindakan ini tidak dapat dibatalkan.');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus File">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                                <h6 class="fw-bold">Belum Ada File Backup</h6>
                                                <p class="small mb-3">Klik tombol <strong>Backup Sekarang</strong> di atas untuk membuat arsip cadangan pertama Anda.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Informasi Jadwal Otomatis Harian --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-gear-wide-connected text-warning"></i>
                        Informasi Jadwal Backup Otomatis Harian
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-calendar2-check text-success me-1"></i> Jadwal Laravel Scheduler</h6>
                                <p class="small text-muted mb-2">
                                    Sistem telah terkonfigurasi untuk mengeksekusi backup database dan storage setiap hari secara otomatis:
                                </p>
                                <ul class="small text-muted mb-0 ps-3">
                                    <li><strong>Waktu Eksekusi:</strong> Setiap hari pukul 01:00 WIB</li>
                                    <li><strong>Tipe Backup:</strong> Database MySQL (.sql) & Storage (.zip)</li>
                                    <li><strong>Lokasi Simpan:</strong> <code>{{ $targetInfo['directory'] }}</code></li>
                                    <li><strong>Format File:</strong> <code>date_namafile</code></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-terminal text-primary me-1"></i> Perintah Manual via Command Line</h6>
                                <p class="small text-muted mb-2">
                                    Backup otomatis juga dapat dipicu kapan saja melalui terminal / Windows Task Scheduler:
                                </p>
                                <div class="bg-dark text-white p-2 rounded small font-monospace mb-2">
                                    php artisan system:backup
                                </div>
                                <small class="text-muted d-block">
                                    File batch otomatis <code>backup-daily.bat</code> telah disiapkan di root proyek untuk penjadwalan via Windows Task Scheduler.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Script Helper --}}
<script>
function copyPath(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Lokasi direktori berhasil disalin ke clipboard:\n' + text);
        });
    } else {
        prompt('Salin lokasi direktori:', text);
    }
}

function confirmBackup(form, label) {
    const btn = form.querySelector('button[type="submit"]');
    if (confirm('Jalankan proses backup ' + label + ' sekarang?')) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Sedang Memproses Backup...';
        return true;
    }
    return false;
}
</script>
@endsection

