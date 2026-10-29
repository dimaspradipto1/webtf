@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Hubungi Kami & Pusat Informasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Beranda Humas</li>
            <li class="breadcrumb-item active">Hubungi Kami & Pusat Informasi</li>
        </ol>
    </nav>
</div>

{{-- Banner Info Penjelasan --}}
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px;">
    <div class="rounded-circle p-2 bg-white shadow-sm text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
        <i class="bi bi-info-circle-fill" style="color: #4f46e5;"></i>
    </div>
    <div>
        <h6 class="fw-bold mb-1" style="color: #312e81;">Pengelolaan Kartu Hubungi Kami & Pusat Informasi</h6>
        <p class="mb-0 text-muted small" style="line-height: 1.5;">
            Menu ini digunakan untuk mengatur kartu pada seksi <strong>"Hubungi Kami & Pusat Informasi"</strong> di halaman <strong>/humas</strong>.
            Anda dapat mengunggah <strong>file gambar background</strong> atau menempelkan <strong>link Google Drive</strong>. Pada tampilan frontend, konten teks sengaja diringkas dan hanya menampilkan background dengan <strong>tombol aksi</strong> menuju tautan yang Anda tentukan.
        </p>
    </div>
</div>

{{-- 1. Pengaturan Judul Seksi Frontend --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-pencil-square me-2" style="color: #000000;"></i>Pengaturan Judul Seksi (Frontend Humas)
        </h5>
        <span class="badge" style="background-color: #000000; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
            <i class="bi bi-globe2 me-1"></i>Tampil di /humas
        </span>
    </div>
    <div class="card-body pt-3 pb-3">
        <form action="{{ route('pusat-informasi.update-setting') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-1">
                <label for="judul_seksi" class="form-label fw-bold text-dark mb-2" style="font-size: 13.5px;">
                    Judul Seksi <span class="text-danger">*</span>
                </label>
                <div class="row g-2 align-items-center">
                    <div class="col-md-9 col-12">
                        <input type="text"
                               id="judul_seksi"
                               name="judul_seksi"
                               class="form-control @error('judul_seksi') is-invalid @enderror"
                               value="{{ old('judul_seksi', $setting->judul_seksi ?? 'Hubungi Kami & Pusat Informasi') }}"
                               placeholder="Contoh: Hubungi Kami & Pusat Informasi"
                               style="height: 42px; border-radius: 8px;"
                               required>
                    </div>
                    <div class="col-md-3 col-12">
                        <button type="submit" class="btn fw-semibold shadow-sm w-100 d-flex align-items-center justify-content-center gap-2" 
                                style="background-color: #000000; color: #ffffff; border: none; height: 42px; border-radius: 8px; transition: all 0.2s ease;">
                            <i class="bi bi-floppy-fill"></i>
                            <span>Simpan Judul</span>
                        </button>
                    </div>
                </div>
                <div class="form-text text-muted mt-2" style="font-size: 12px;">
                    <i class="bi bi-info-circle me-1"></i> Judul utama yang muncul di atas deretan kartu pada halaman Beranda Humas.
                </div>
                @error('judul_seksi')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </form>
    </div>
</div>

{{-- 2. Daftar Kartu Hubungi Kami & Pusat Informasi --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-collection-fill me-2" style="color: #000000;"></i>
            Daftar Kartu Informasi (Total: {{ $cards->count() }})
        </h5>
        <a href="{{ route('pusat-informasi.create') }}" 
           class="btn fw-semibold shadow-sm btn-sm" 
           style="background-color: #000000; color: #ffffff; border: none; padding: 7px 18px; border-radius: 8px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kartu Baru
        </a>
    </div>
    <div class="card-body pt-3">
        @if($cards->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-card-image text-muted" style="font-size: 48px;"></i>
                <p class="mt-2 text-muted fw-semibold">Belum ada kartu informasi yang ditambahkan.</p>
                <a href="{{ route('pusat-informasi.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kartu Sekarang
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center" style="font-size: 13px;">
                            <th style="width: 50px;">No</th>
                            <th style="width: 130px;">Preview Background</th>
                            <th>Judul / Referensi</th>
                            <th style="width: 160px;">Sumber Background</th>
                            <th style="width: 140px;">Teks Tombol</th>
                            <th>Link Tujuan (Button URL)</th>
                            <th style="width: 70px;">Urutan</th>
                            <th style="width: 90px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cards as $index => $item)
                            <tr>
                                <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                
                                {{-- Preview Thumbnail Background --}}
                                <td class="text-center">
                                    @if($item->image_url)
                                        <div class="position-relative mx-auto rounded shadow-sm overflow-hidden" 
                                             style="width: 100px; height: 60px; background: url('{{ $item->image_url }}') center/cover no-repeat; border: 1px solid #dee2e6;">
                                            <div class="position-absolute bottom-0 start-0 end-0 py-1 text-center" 
                                                 style="background: rgba(0,0,0,0.65);">
                                                <span class="badge" style="background: #ffd600; color: #000; font-size: 9px; padding: 2px 6px;">
                                                    {{ $item->button_text ?? 'Lihat' }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mx-auto rounded d-flex align-items-center justify-content-center text-muted" 
                                             style="width: 100px; height: 60px; background: #f1f5f9; border: 1px dashed #cbd5e1; font-size: 11px;">
                                            <i class="bi bi-image me-1"></i> Polos
                                        </div>
                                    @endif
                                </td>

                                {{-- Judul --}}
                                <td>
                                    <span class="fw-bold text-dark d-block">{{ $item->judul ?: 'Kartu #' . ($index + 1) }}</span>
                                    <small class="text-muted">ID: {{ $item->id }}</small>
                                </td>

                                {{-- Sumber Background --}}
                                <td class="text-center">
                                    @if($item->gambar)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-upload me-1"></i> Upload Gambar
                                        </span>
                                    @elseif($item->link_drive)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                            <i class="bi bi-google me-1"></i> Google Drive
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                            Tidak Ada
                                        </span>
                                    @endif
                                </td>

                                {{-- Teks Tombol --}}
                                <td class="text-center">
                                    <span class="badge" style="background: #ffd600; color: #111; font-weight: 700; font-size: 12px; padding: 6px 12px; border-radius: 20px;">
                                        {{ $item->button_text }}
                                    </span>
                                </td>

                                {{-- Button URL --}}
                                <td>
                                    @if($item->button_url)
                                        <a href="{{ $item->button_url }}" target="_blank" class="text-decoration-none d-inline-flex align-items-center gap-1 text-primary fw-medium small" style="word-break: break-all;">
                                            <i class="bi bi-link-45deg fs-6"></i>
                                            <span>{{ Str::limit($item->button_url, 45) }}</span>
                                            @if($item->target_blank)
                                                <i class="bi bi-box-arrow-up-right ms-1 text-muted" style="font-size: 10px;" title="Buka di tab baru"></i>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic small">Belum diatur</span>
                                    @endif
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
                                        <a href="{{ route('pusat-informasi.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit Kartu">
                                            <i class="bi bi-pencil-fill text-dark"></i>
                                        </a>
                                        <form action="{{ route('pusat-informasi.destroy', $item->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu ini?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Kartu">
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

{{-- 3. Live Preview Tampilan Frontend Humas --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #6366f1; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-eye-fill me-2" style="color: #6366f1;"></i>
            Live Preview Tampilan Frontend di Halaman /humas
        </h5>
        <a href="{{ route('homepage.humas') }}" target="_blank" class="btn btn-sm btn-outline-primary fw-semibold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi Halaman Humas
        </a>
    </div>
    <div class="card-body pt-4 pb-4" style="background-color: #f8fafc; border-radius: 0 0 12px 12px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: #1e293b; font-size: 24px;">
                {{ $setting->judul_seksi ?? 'Hubungi Kami & Pusat Informasi' }}
            </h3>
        </div>

        <div class="row g-3 justify-content-center">
            @forelse($cards->where('is_active', true) as $card)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="position-relative rounded-4 shadow-sm overflow-hidden d-flex flex-column justify-content-end p-3 text-center"
                         style="height: 220px; background: {{ $card->image_url ? "url('" . e($card->image_url) . "') center/cover no-repeat" : '#e2e8f0' }}; border: 1px solid rgba(0,0,0,0.08); transition: transform 0.2s ease;">
                        {{-- Dark bottom overlay --}}
                        <div class="position-absolute inset-0 top-0 bottom-0 start-0 end-0" 
                             style="background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.6) 100%); pointer-events: none;"></div>
                        
                        {{-- Button only --}}
                        <div class="position-relative" style="z-index: 2;">
                            <span class="d-inline-block px-4 py-2 fw-bold text-dark rounded-pill shadow-sm"
                                  style="background: #ffd600; font-size: 13px;">
                                {{ $card->button_text ?? 'Lihat' }}
                            </span>
                        </div>
                    </div>
                    @if($card->judul)
                        <div class="text-center mt-2 small text-muted fw-semibold">
                            {{ $card->judul }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-12 text-center text-muted py-3">
                    <em>Tidak ada kartu aktif untuk ditampilkan.</em>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
