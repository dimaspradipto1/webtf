@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola {{ $pageTitle }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Akademik</li>
            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pada input form:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($tipe === 'kalender' && isset($kalenderItems))
            <!-- ═══════════════════════════════════════════════════════════
                 DAFTAR TAHUN & LINK GOOGLE DRIVE KALENDER AKADEMIK
            ═══════════════════════════════════════════════════════════ -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-google text-success fs-4"></i>
                        <div>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Daftar Dokumen Kalender Akademik per Tahun (Link Google Drive)</h5>
                            <div class="small text-muted">Kelola daftar akordion Kalender Akademik per Tahun Akademik beserta tautan dokumen Google Drive.</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm px-3 py-2 rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahKalender">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Tahun Kalender
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">Urutan</th>
                                    <th style="width: 24%;">Judul Tab / Tahun Akademik</th>
                                    <th style="width: 26%;">Nama Dokumen</th>
                                    <th>Link Google Drive</th>
                                    <th class="text-center" style="width: 100px;">Status</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kalenderItems as $kItem)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $kItem->urutan }}</span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $kItem->judul_tab }}</td>
                                    <td>{{ $kItem->nama_dokumen }}</td>
                                    <td>
                                        @if($kItem->gdrive_url)
                                            <a href="{{ $kItem->gdrive_url }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-inline-flex align-items-center gap-1 small fw-semibold text-primary">
                                                <i class="bi bi-box-arrow-up-right"></i> {{ Str::limit($kItem->gdrive_url, 48) }}
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($kItem->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditKalender{{ $kItem->id }}" title="Sunting">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <form action="{{ route('akademik.kalender.item.destroy', $kItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus {{ $kItem->judul_tab }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada daftar tahun Kalender Akademik.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Modal Edit per Item --}}
            @foreach($kalenderItems as $kItem)
            <div class="modal fade" id="modalEditKalender{{ $kItem->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <form action="{{ route('akademik.kalender.item.update', $kItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-bottom py-3">
                                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Sunting {{ $kItem->judul_tab }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Judul Tab / Tahun Akademik <span class="text-danger">*</span></label>
                                        <input type="text" name="judul_tab" class="form-control" value="{{ $kItem->judul_tab }}" placeholder="Contoh: Kalender Akademik 2026/2027" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Nama Dokumen <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_dokumen" class="form-control" value="{{ $kItem->nama_dokumen }}" placeholder="Contoh: KALENDER AKADEMIK UIS 2026-2027" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small"><i class="bi bi-google text-success me-1"></i>Link Google Drive Dokumen <span class="text-danger">*</span></label>
                                        <input type="url" name="gdrive_url" class="form-control" value="{{ $kItem->gdrive_url }}" placeholder="https://drive.google.com/file/d/.../view?usp=sharing" required>
                                        <div class="form-text small">Masukkan link Google Drive dokumen Kalender Akademik (pastikan akses diset ke "Anyone with the link").</div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold small">Teks Tombol</label>
                                        <input type="text" name="tombol_teks" class="form-control" value="{{ $kItem->tombol_teks ?: 'Lihat Document' }}" placeholder="Lihat Document">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold small">Urutan Tampil</label>
                                        <input type="number" name="urutan" class="form-control" value="{{ $kItem->urutan }}" min="0">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch" id="activeEdit{{ $kItem->id }}" name="is_active" value="1" {{ $kItem->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold small" for="activeEdit{{ $kItem->id }}">Tampilkan di Halaman</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light py-2">
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Modal Tambah Tahun Kalender Baru --}}
            <div class="modal fade" id="modalTambahKalender" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <form action="{{ route('akademik.kalender.item.store') }}" method="POST">
                            @csrf
                            <div class="modal-header border-bottom py-3">
                                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Tambah Tahun Kalender Akademik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Judul Tab / Tahun Akademik <span class="text-danger">*</span></label>
                                        <input type="text" name="judul_tab" class="form-control" placeholder="Contoh: Kalender Akademik 2026/2027" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Nama Dokumen <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_dokumen" class="form-control" placeholder="Contoh: KALENDER AKADEMIK UIS 2026-2027" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small"><i class="bi bi-google text-success me-1"></i>Link Google Drive Dokumen <span class="text-danger">*</span></label>
                                        <input type="url" name="gdrive_url" class="form-control" placeholder="https://drive.google.com/file/d/.../view?usp=sharing" required>
                                        <div class="form-text small">Tempelkan link Google Drive untuk dokumen Kalender Akademik.</div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold small">Teks Tombol</label>
                                        <input type="text" name="tombol_teks" class="form-control" value="Lihat Document" placeholder="Lihat Document">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold small">Urutan Tampil</label>
                                        <input type="number" name="urutan" class="form-control" value="{{ ($kalenderItems->max('urutan') ?? 0) + 1 }}" min="0">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch" id="activeNewKalender" name="is_active" value="1" checked>
                                            <label class="form-check-label fw-semibold small" for="activeNewKalender">Tampilkan di Halaman</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light py-2">
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold"><i class="bi bi-plus-lg me-1"></i> Tambah Kalender</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            @if($tipe !== 'kalender')
            <form action="{{ route('akademik.update', $tipe) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $icons = [
                                    'kurikulum' => 'bi-journal-text text-primary',
                                    'kalender'  => 'bi-calendar-check text-warning',
                                    'pedoman'   => 'bi-book text-success',
                                    'sistem'    => 'bi-laptop text-info',
                                ];
                                $iconClass = $icons[$tipe] ?? 'bi-mortarboard text-primary';
                            @endphp
                            <i class="bi {{ $iconClass }} fs-4"></i>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Formulir Informasi {{ $pageTitle }}</h5>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold small text-muted" for="is_active">Tampilkan di Menu</label>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- Judul & Subjudul --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label fw-semibold small text-dark">Judul Utama <span class="text-danger">*</span></label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $item->judul) }}" placeholder="Contoh: {{ $pageTitle }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="subjudul" class="form-label fw-semibold small text-dark">Subjudul / Ringkasan</label>
                                <input type="text" id="subjudul" name="subjudul" class="form-control @error('subjudul') is-invalid @enderror" value="{{ old('subjudul', $item->subjudul) }}" placeholder="Keterangan singkat pengantar...">
                            </div>
                        </div>

                        {{-- Link URL / Portal Eksternal (Opsional) --}}
                        <div class="mb-3">
                            <label for="link_url" class="form-label fw-semibold small text-dark">
                                <i class="bi bi-link-45deg text-primary"></i> Link Eksternal / Portal URL <span class="text-muted fw-normal">(Opsional - Terutama untuk SIAKAD/E-Learning)</span>
                            </label>
                            <input type="text" id="link_url" name="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url', $item->link_url) }}" placeholder="https://siakad.uis.ac.id">
                            <div class="form-text small text-muted">Jika diisi, pengunjung yang mengklik menu dapat langsung diarahkan ke portal tersebut.</div>
                        </div>

                        {{-- Deskripsi Konten Lengkap --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold small text-dark">Konten / Keterangan Lengkap</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control tinymce-editor @error('deskripsi') is-invalid @enderror" rows="10" placeholder="Tuliskan detail informasi, panduan, jadwal, atau instruksi akademik di sini...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        {{-- Upload Dokumen & Banner --}}
                        <div class="row g-4 mb-3">
                            {{-- Dokumen PDF/Doc --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #faf7fc; border: 1px solid #ebdcf5;">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="bi bi-file-earmark-pdf text-danger me-1"></i> File Dokumen Unduhan (PDF / DOC)
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <label for="file_nama" class="form-label fw-semibold small text-dark">Nama Label File</label>
                                        <input type="text" id="file_nama" name="file_nama" class="form-control" value="{{ old('file_nama', $item->file_nama) }}" placeholder="Contoh: Kalender Akademik 2026-2027.pdf">
                                    </div>

                                    <div class="mb-2">
                                        <label for="file_dokumen" class="form-label fw-semibold small text-dark">Upload File Dokumen Baru</label>
                                        <input type="file" id="file_dokumen" name="file_dokumen" class="form-control @error('file_dokumen') is-invalid @enderror" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                                        <div class="form-text small">Format: PDF, DOC, DOCX, XLS (Maks. 20MB)</div>
                                    </div>

                                    @if($item->file_dokumen)
                                        <div class="mt-3 p-2 bg-white rounded border d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2 text-truncate">
                                                <i class="bi bi-file-earmark-check-fill text-success fs-5"></i>
                                                <span class="small fw-semibold text-truncate">{{ $item->file_nama ?: 'Dokumen Terlampir' }}</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                                <i class="bi bi-download me-1"></i> Unduh
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Gambar Banner / Cover --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="bi bi-image text-primary me-1"></i> Gambar Banner / Infografis Cover
                                    </h6>

                                    <div class="mb-2">
                                        <label for="gambar" class="form-label fw-semibold small text-dark">Upload Gambar Baru</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                        <div class="form-text small">Format: JPEG, PNG, JPG, WEBP (Maks. 5 MB)</div>
                                    </div>

                                    @if($item->gambar)
                                        <div class="mt-3 text-center p-2 bg-white rounded border">
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;">
                                            <div class="small text-muted mt-1">Gambar saat ini terpasang</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold" style="background: #000000; border: none !important;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Data {{ $pageTitle }}
                        </button>
                    </div>
                </div>
            </form>
            @endif

        </div>
    </div>
</section>
@endsection
