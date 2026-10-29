@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Template Dokumen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item active">Template Dokumen</li>
        </ol>
    </nav>
</div>

{{-- Banner Info Penjelasan --}}
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px;">
    <div class="rounded-circle p-2 bg-white shadow-sm text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
        <i class="bi bi-file-earmark-text-fill" style="color: #047857;"></i>
    </div>
    <div>
        <h6 class="fw-bold mb-1" style="color: #000000;">Pengelolaan Template Dokumen Resmi</h6>
        <p class="mb-0 text-muted small" style="line-height: 1.5;">
            Di halaman ini Anda dapat menambahkan dan mengelola template dokumen resmi (seperti <strong>Presentasi .pptx</strong>, <strong>Sampul Laporan .docx</strong>, <strong>Kartu Nama .psd</strong>, dsb) dengan menautkan <strong>Link Google Drive</strong>. Tampilan publik otomatis tersusun rapi pada halaman <a href="{{ route('homepage.template-dokumen') }}" target="_blank" class="fw-bold text-success text-decoration-underline">/template-dokumen</a>.
        </p>
    </div>
</div>

{{-- 1. Pengaturan Teks Header Seksi --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-pencil-square me-2" style="color: #000000;"></i>Pengaturan Judul & Deskripsi Seksi Frontend
        </h5>
        <span class="badge" style="background-color: #000000; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
            <i class="bi bi-globe2 me-1"></i>Halaman Publik
        </span>
    </div>
    <div class="card-body pt-3 pb-4">
        <form action="{{ route('template-dokumen.update-setting') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-5 col-12">
                    <label for="judul_seksi" class="form-label fw-bold text-dark small">
                        Judul Seksi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="judul_seksi"
                           name="judul_seksi"
                           class="form-control @error('judul_seksi') is-invalid @enderror"
                           value="{{ old('judul_seksi', $setting->judul_seksi ?? 'TEMPLATE DOKUMEN') }}"
                           placeholder="Contoh: TEMPLATE DOKUMEN"
                           required>
                    <div class="form-text text-muted small">Judul hijau huruf kapital di bagian atas seksi.</div>
                    @error('judul_seksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-7 col-12">
                    <label for="deskripsi_seksi" class="form-label fw-bold text-dark small">
                        Deskripsi / Dasar Aturan Seksi
                    </label>
                    <textarea id="deskripsi_seksi"
                              name="deskripsi_seksi"
                              rows="3"
                              class="form-control @error('deskripsi_seksi') is-invalid @enderror"
                              placeholder="Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word...">{{ old('deskripsi_seksi', $setting->deskripsi_seksi) }}</textarea>
                    <div class="form-text text-muted small">Teks penjelasan di bawah judul yang menerangkan tujuan & dasar aturan templat.</div>
                    @error('deskripsi_seksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-end pt-2">
                    <button type="submit" class="btn fw-semibold shadow-sm px-4" style="background-color: #000000; color: #ffffff; border: none; border-radius: 8px;">
                        <i class="bi bi-floppy-fill me-1"></i> Simpan Teks Seksi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- 2. Daftar Template Dokumen --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-collection-fill me-2" style="color: #000000;"></i>
            Daftar Template Dokumen (Total: {{ $templates->count() }})
        </h5>
        <a href="{{ route('template-dokumen.create') }}" 
           class="btn fw-semibold shadow-sm btn-sm" 
           style="background-color: #000000; color: #ffffff; border: none; padding: 7px 18px; border-radius: 8px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Template Baru
        </a>
    </div>
    <div class="card-body pt-3">
        @if($templates->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text text-muted" style="font-size: 48px;"></i>
                <p class="mt-2 text-muted fw-semibold">Belum ada template dokumen yang ditambahkan.</p>
                <a href="{{ route('template-dokumen.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Template Pertama
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center" style="font-size: 13px;">
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">Ikon</th>
                            <th>Judul Template</th>
                            <th style="width: 120px;">Format File</th>
                            <th>Link Google Drive</th>
                            <th style="width: 70px;">Urutan</th>
                            <th style="width: 90px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $index => $item)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                
                                {{-- Ikon --}}
                                <td class="text-center py-2">
                                    <div class="d-inline-flex align-items-center justify-content-center p-2 rounded" 
                                         style="background: #eef7ee; border: 1px solid #d1e7dd; width: 70px; height: 70px;">
                                        <div style="transform: scale(0.55); transform-origin: center;">
                                            {!! $item->icon_html !!}
                                        </div>
                                    </div>
                                </td>

                                {{-- Judul --}}
                                <td>
                                    <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">{{ $item->judul }}</span>
                                    <small class="text-muted">Preset: {{ ucfirst($item->icon_preset) }}</small>
                                </td>

                                {{-- Format --}}
                                <td class="text-center">
                                    <span class="badge" style="background-color: #000000; color: #fff; font-size: 11px; padding: 5px 10px;">
                                        .{{ strtolower($item->tipe_file ?: 'file') }}
                                    </span>
                                </td>

                                {{-- Link Google Drive --}}
                                <td>
                                    <a href="{{ $item->link_drive }}" target="_blank" rel="noopener noreferrer" 
                                       class="d-inline-flex align-items-center gap-1 text-decoration-none fw-semibold text-primary small"
                                       style="word-break: break-all;">
                                        <i class="bi bi-google text-primary fs-6"></i>
                                        <span>{{ Str::limit($item->link_drive, 45) }}</span>
                                        <i class="bi bi-box-arrow-up-right ms-1 text-muted" style="font-size: 10px;"></i>
                                    </a>
                                </td>

                                {{-- Urutan --}}
                                <td class="text-center fw-bold">{{ $item->urutan }}</td>

                                {{-- Status Aktif --}}
                                <td class="text-center">
                                    @if($item->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('template-dokumen.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit Template">
                                            <i class="bi bi-pencil-fill text-dark"></i>
                                        </a>
                                        <form action="{{ route('template-dokumen.destroy', $item->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Template">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- 3. Live Preview Tampilan Publik --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #047857; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-eye-fill me-2" style="color: #047857;"></i>
            Live Preview Tampilan Publik (/template-dokumen)
        </h5>
        <a href="{{ route('homepage.template-dokumen') }}" target="_blank" class="btn btn-sm btn-outline-success fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik
        </a>
    </div>
    <div class="card-body pt-5 pb-5 text-center" style="background-color: #ffffff; border-radius: 0 0 12px 12px;">
        <div class="container" style="max-width: 900px;">
            {{-- Heading --}}
            <h2 class="fw-bold text-uppercase mb-3" style="color: #000000; font-size: 26px; letter-spacing: 0.8px;">
                {{ $setting->judul_seksi ?? 'TEMPLAT DOKUMEN' }}
            </h2>

            {{-- Deskripsi --}}
            <p class="text-muted mx-auto mb-5" style="max-width: 780px; font-size: 13.5px; line-height: 1.6;">
                {{ $setting->deskripsi_seksi ?? 'Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word dan berbagai format lainnya...' }}
            </p>

            {{-- Grid Cards persis seperti screenshot --}}
            <div class="row g-4 justify-content-center">
                @forelse($templates->where('is_active', true) as $card)
                    <div class="col-md-4 col-sm-6 col-12">
                        <a href="{{ $card->link_drive }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block text-center group-card">
                            {{-- Soft greenish backdrop card --}}
                            <div class="rounded-3 d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm"
                                 style="background-color: #ebf5ee; height: 180px; width: 100%; border: 1px solid #d4ebd9; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                                <div style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.06));">
                                    {!! $card->icon_html !!}
                                </div>
                            </div>
                            {{-- Label bawah persis screenshot --}}
                            <h6 class="fw-bold text-dark mt-2 mb-0" style="font-size: 14.5px;">
                                {{ $card->judul }}
                            </h6>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-muted py-4">
                        <em>Belum ada template aktif yang ditampilkan.</em>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
