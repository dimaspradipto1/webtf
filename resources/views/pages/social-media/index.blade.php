@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>
        @if($kategori === 'humas')
            Media Sosial Humas
        @elseif($kategori === 'universitas')
            Media Sosial Fakultas Sains dan Teknologi
        @else
            Link Media Sosial
        @endif
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            @if($kategori === 'humas')
                <li class="breadcrumb-item">Beranda Humas</li>
                <li class="breadcrumb-item active">Media Sosial Humas</li>
            @else
                <li class="breadcrumb-item">Konten Beranda</li>
                <li class="breadcrumb-item active">{{ $kategori === 'universitas' ? 'Media Sosial Fakultas Sains dan Teknologi' : 'Link Media Sosial' }}</li>
            @endif
        </ol>
    </nav>
</div>

{{-- Tab Filter Kategori Media Sosial --}}
<div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
    <div class="card-body p-2 p-md-3">
        <ul class="nav nav-pills nav-fill gap-2" role="tablist">
            <li class="nav-item">
                <a href="{{ route('social-media.index') }}" 
                   class="nav-link py-2 px-3 fw-semibold d-flex align-items-center justify-content-center gap-2 {{ empty($kategori) ? 'active bg-success text-white' : 'text-secondary bg-light' }}"
                   style="border-radius: 8px;">
                    <i class="bi bi-grid-fill"></i>
                    <span>Semua Media Sosial</span>
                    <span class="badge {{ empty($kategori) ? 'bg-white text-success' : 'bg-secondary text-white' }} rounded-pill">{{ $countAll }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('social-media.index', ['kategori' => 'universitas']) }}" 
                   class="nav-link py-2 px-3 fw-semibold d-flex align-items-center justify-content-center gap-2 {{ $kategori === 'universitas' ? 'active bg-primary text-white' : 'text-secondary bg-light' }}"
                   style="border-radius: 8px;">
                    <i class="bi bi-buildings"></i>
                    <span>Media Sosial Fakultas Sains dan Teknologi</span>
                    <span class="badge {{ $kategori === 'universitas' ? 'bg-white text-primary' : 'bg-secondary text-white' }} rounded-pill">{{ $countUniversitas }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('social-media.index', ['kategori' => 'humas']) }}" 
                   class="nav-link py-2 px-3 fw-semibold d-flex align-items-center justify-content-center gap-2 {{ $kategori === 'humas' ? 'active text-white' : 'text-secondary bg-light' }}"
                   style="border-radius: 8px; {{ $kategori === 'humas' ? 'background-color: #6366f1;' : '' }}">
                    <i class="bi bi-megaphone-fill"></i>
                    <span>Media Sosial Humas</span>
                    <span class="badge {{ $kategori === 'humas' ? 'bg-white text-dark' : 'bg-secondary text-white' }} rounded-pill">{{ $countHumas }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>

@if($kategori !== 'humas')
    {{-- 1. Pengaturan Header Seksi Frontend (Judul, Garis Divider Share, & Teks Kutipan) --}}
    <div class="card shadow-sm border-0 mb-4" id="section-setting-card" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
            <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                <i class="bi bi-pencil-square me-2" style="color: #000000;"></i>Pengaturan Judul & Teks Kutipan Seksi Media Sosial (Beranda Utama)
            </h5>
            <span class="badge" style="background-color: #000000; color: #ffffff; font-size: 11.5px; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                <i class="bi bi-globe2 me-1"></i>Tampil di Beranda Utama
            </span>
        </div>
        <div class="card-body pt-3 pb-4">
            <form action="{{ route('social-media.update-setting') }}" method="POST">
                @csrf
                
                <div class="row g-3">
                    <div class="col-lg-5 col-md-12">
                        <label for="judul_seksi" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                            Judul Seksi <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="judul_seksi"
                               name="judul_seksi"
                               class="form-control @error('judul_seksi') is-invalid @enderror"
                               value="{{ old('judul_seksi', $setting->judul_seksi ?? 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL') }}"
                               placeholder="Contoh: IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL"
                               required>
                        <div class="form-text text-muted" style="font-size: 12px;">Teks judul huruf kapital di atas garis divider icon share.</div>
                        @error('judul_seksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-7 col-md-12">
                        <label for="subjudul_seksi" class="form-label fw-bold text-dark" style="font-size: 13.5px;">
                            Teks Kutipan / Subjudul <span class="text-danger">*</span>
                        </label>
                        <textarea id="subjudul_seksi"
                                  name="subjudul_seksi"
                                  class="form-control @error('subjudul_seksi') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Ketik kalimat ajakan yang tampil di bawah ikon share..."
                                  required>{{ old('subjudul_seksi', $setting->subjudul_seksi ?? '') }}</textarea>
                        <div class="form-text text-muted" style="font-size: 12px;">Kalimat ajakan yang tampil di bawah garis divider share sebelum baris ikon logo.</div>
                        @error('subjudul_seksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Live Preview Tampilan Teks di Frontend --}}
                <div class="mt-4 p-3 p-md-4 rounded-3 border" style="background-color: #fbfdfc;">
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <span class="small fw-bold text-success text-uppercase" style="letter-spacing: 0.5px;">
                            <i class="bi bi-eye-fill me-1"></i> Live Preview Tampilan Teks di Beranda Utama
                        </span>
                        <span class="badge bg-light text-muted border" style="font-size: 11px;">Otomatis berubah saat diketik</span>
                    </div>

                    <div class="text-center py-2 px-1">
                        {{-- Judul Preview --}}
                        <h3 id="preview-heading" class="fw-bold mb-2 text-uppercase" style="color: #2b7044; font-size: 20px; letter-spacing: 0.6px; font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $setting->judul_seksi ?? 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL' }}
                        </h3>

                        {{-- Divider Preview --}}
                        <div class="d-flex align-items-center justify-content-center gap-3 my-2 mx-auto" style="max-width: 380px;">
                            <span style="flex: 1; height: 3px; background-color: #2b7044; border-radius: 2px;"></span>
                            <span style="color: #2b7044; font-size: 18px;"><i class="bi bi-share"></i></span>
                            <span style="flex: 1; height: 3px; background-color: #2b7044; border-radius: 2px;"></span>
                        </div>

                        {{-- Subjudul Kutipan Preview --}}
                        <p id="preview-quote" class="mt-3 mb-0 mx-auto text-dark" style="max-width: 780px; font-size: 14.5px; line-height: 1.6; font-style: normal;">
                            "{{ $setting->subjudul_seksi ?? 'Dapatkan update terbaru, berita inspiratif, dan berbagai informasi menarik lainnya langsung dari platform media sosial kami. Jangan lewatkan momen penting dari Fakultas Sains dan Teknologi, klik ikon di bawah untuk terhubung sekarang juga!' }}"
                        </p>
                    </div>
                </div>

                <div class="col-12 text-end pt-3">
                    <button type="submit" class="btn fw-semibold shadow-sm px-4 py-2" style="background-color: #000000; color: #ffffff; border: none; border-radius: 8px;">
                        <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan Teks Seksi
                    </button>
                </div>
            </form>
        </div>
    </div>
@else
    {{-- Banner Khusus Humas --}}
    <div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px;">
        <div class="rounded-circle p-2 bg-white shadow-sm text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
            <i class="bi bi-camera-reels-fill" style="color: #6366f1;"></i>
        </div>
        <div>
            <h6 class="fw-bold mb-1" style="color: #312e81;">Pengelolaan Media Sosial Humas</h6>
            <p class="mb-0 text-muted small" style="line-height: 1.5;">
                Media sosial di bawah ini tampil khusus di <strong>Beranda Humas</strong> dalam bentuk <strong>Smartphone Card Mockup</strong>. Link video TikTok, Reels, atau YouTube akan <strong>otomatis berputar (autoplay)</strong> tanpa pengunjung harus menekan tombol play.
            </p>
        </div>
    </div>
@endif

{{-- 2. Daftar Logo & Link Media Sosial --}}
<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-top: 3px solid {{ $kategori === 'humas' ? '#6366f1' : '#000000' }}; border-radius: 12px 12px 0 0;">
        <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
            <i class="bi bi-share-fill me-2" style="color: {{ $kategori === 'humas' ? '#6366f1' : '#000000' }};"></i>
            Daftar Link & Logo {{ $kategori === 'humas' ? 'Media Sosial Humas' : ($kategori === 'universitas' ? 'Media Sosial Fakultas Sains dan Teknologi' : 'Media Sosial') }}
        </h5>
        <div class="d-flex align-items-center gap-2">
            @if($kategori !== 'humas')
                <a href="#section-setting-card" class="btn btn-outline-success btn-sm fw-semibold">
                    <i class="bi bi-pencil me-1"></i> Edit Teks Judul & Deskripsi
                </a>
            @endif
            <a href="{{ route('social-media.create', ['kategori' => $kategori ?? 'universitas']) }}" 
               class="btn fw-semibold shadow-sm btn-sm" 
               style="background-color: {{ $kategori === 'humas' ? '#6366f1' : '#000000' }}; color: #ffffff; border: none; padding: 7px 18px; border-radius: 8px;">
                <i class="bi bi-plus-lg me-1"></i> Tambah {{ $kategori === 'humas' ? 'Medsos Humas' : ($kategori === 'universitas' ? 'Medsos Fakultas Sains & Teknologi' : 'Media Sosial') }}
            </a>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert" style="background-color: #e8f4fd; border-color: #b8e0fe; color: #0c5460; border-radius: 8px;">
            <i class="bi bi-info-circle-fill fs-5 me-2 text-info"></i>
            <div>
                @if($kategori === 'humas')
                    <strong>Info Media Sosial Humas:</strong> Platform di bawah ini tampil di halaman <strong>/humas</strong> pada kartu smartphone interaktif. Masukkan link video TikTok atau YouTube untuk pemutaran otomatis (autoplay).
                @elseif($kategori === 'universitas')
                    <strong>Info Media Sosial Fakultas Sains dan Teknologi:</strong> Logo PNG di bawah ini tampil secara horizontal di barisan seksi Media Sosial pada <strong>Beranda Utama Website</strong>.
                @else
                    <strong>Info:</strong> Menampilkan seluruh data media sosial (Fakultas Sains dan Teknologi & Humas). Gunakan tab di atas untuk menyaring per kategori.
                @endif
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="table-responsive">
            {{ $dataTable->table([
                'class' => 'table table-hover table-bordered align-middle',
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const judulInput = document.getElementById('judul_seksi');
            const subjudulInput = document.getElementById('subjudul_seksi');
            const previewHeading = document.getElementById('preview-heading');
            const previewQuote = document.getElementById('preview-quote');

            if (judulInput && previewHeading) {
                judulInput.addEventListener('input', function () {
                    previewHeading.textContent = this.value.trim() ? this.value : 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL';
                });
            }

            if (subjudulInput && previewQuote) {
                subjudulInput.addEventListener('input', function () {
                    const val = this.value.trim();
                    previewQuote.textContent = val ? '"' + val + '"' : '';
                });
            }
        });
    </script>
@endpush
