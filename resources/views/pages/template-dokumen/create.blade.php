@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Template Dokumen</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Layanan Humas</li>
            <li class="breadcrumb-item"><a href="{{ route('template-dokumen.index') }}">Template Dokumen</a></li>
            <li class="breadcrumb-item active">Tambah Baru</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                    <i class="bi bi-plus-circle-fill me-2" style="color: #000000;"></i>Formulir Tambah Template Dokumen
                </h5>
                <a href="{{ route('template-dokumen.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body pt-3 pb-4">
                <form action="{{ route('template-dokumen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 1. Judul & Format File --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-8 col-12">
                            <label for="judul" class="form-label fw-bold text-dark small">
                                Judul / Nama Template <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="judul"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}"
                                   placeholder="Contoh: Presentasi (.pptx), Sampul Laporan (.docx), Kartu Nama (.psd)"
                                   required>
                            <div class="form-text text-muted small">Nama yang tampil persis di bawah kotak ikon pada tampilan publik.</div>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 col-12">
                            <label for="tipe_file" class="form-label fw-bold text-dark small">
                                Format File
                            </label>
                            <input type="text"
                                   id="tipe_file"
                                   name="tipe_file"
                                   class="form-control @error('tipe_file') is-invalid @enderror"
                                   value="{{ old('tipe_file') }}"
                                   placeholder="Contoh: pptx, docx, psd, pdf">
                            <div class="form-text text-muted small">Ekstensi file template.</div>
                            @error('tipe_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. Link Google Drive --}}
                    <div class="card border border-success-subtle bg-success bg-opacity-10 p-3 mb-3" style="border-radius: 10px;">
                        <label for="link_drive" class="form-label fw-bold text-dark mb-1" style="font-size: 14px;">
                            <i class="bi bi-google text-success me-1"></i> Link Google Drive <span class="text-danger">*</span>
                        </label>
                        <p class="text-muted small mb-2">
                            Tempelkan link Google Drive tempat file template disimpan. Pastikan akses link di Google Drive diatur ke <em>"Siapa saja yang memiliki link"</em> (Public / Anyone with the link).
                        </p>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-link-45deg text-success fs-5"></i></span>
                            <input type="text"
                                   id="link_drive"
                                   name="link_drive"
                                   class="form-control @error('link_drive') is-invalid @enderror"
                                   value="{{ old('link_drive') }}"
                                   placeholder="https://drive.google.com/file/d/.../view?usp=sharing"
                                   required>
                        </div>
                        <div class="form-text text-muted small mt-1">Saat pengunjung menekan kartu template di halaman publik, link ini akan langsung terbuka di tab baru.</div>
                        @error('link_drive')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 3. Pilihan Model Ikon Dokumen --}}
                    <div class="card border border-light-subtle bg-light p-3 mb-3" style="border-radius: 10px;">
                        <label class="form-label fw-bold text-dark mb-2" style="font-size: 13.5px;">
                            <i class="bi bi-image me-1 text-primary"></i> Pilihan Ikon Template Dokumen
                        </label>
                        <p class="text-muted small mb-3">
                            Pilih model ikon hijau bawaan (sesuai standar desain identitas visual) atau upload ikon kustom:
                        </p>

                        <div class="row g-2 mb-3">
                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="powerpoint" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset', 'powerpoint') === 'powerpoint' ? 'checked' : '' }}>
                                    <div class="py-2">
                                        <svg viewBox="0 0 80 100" style="width: 48px; height: 60px;">
                                            <path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/>
                                            <path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/>
                                            <text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="46" text-anchor="middle">P</text>
                                        </svg>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">PowerPoint (P)</span>
                                </label>
                            </div>

                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="word" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset') === 'word' ? 'checked' : '' }}>
                                    <div class="py-2">
                                        <svg viewBox="0 0 80 100" style="width: 48px; height: 60px;">
                                            <path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/>
                                            <path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/>
                                            <text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="44" text-anchor="middle">W</text>
                                        </svg>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">Word (W)</span>
                                </label>
                            </div>

                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="idcard" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset') === 'idcard' ? 'checked' : '' }}>
                                    <div class="py-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                        <svg viewBox="0 0 110 80" style="width: 65px; height: 48px;">
                                            <rect x="0" y="0" width="110" height="80" rx="14" fill="#2d7a3e"/>
                                            <circle cx="36" cy="33" r="14" fill="#ffffff"/>
                                            <path d="M16 66 C16 52 25 48 36 48 C47 48 56 52 56 66 Z" fill="#ffffff"/>
                                            <rect x="66" y="24" width="30" height="7" rx="3.5" fill="#ffffff"/>
                                            <rect x="66" y="38" width="30" height="7" rx="3.5" fill="#ffffff"/>
                                            <rect x="66" y="52" width="22" height="7" rx="3.5" fill="#ffffff"/>
                                        </svg>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">Kartu Nama (ID)</span>
                                </label>
                            </div>

                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="excel" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset') === 'excel' ? 'checked' : '' }}>
                                    <div class="py-2">
                                        <svg viewBox="0 0 80 100" style="width: 48px; height: 60px;">
                                            <path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/>
                                            <path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/>
                                            <text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="46" text-anchor="middle">X</text>
                                        </svg>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">Excel (X)</span>
                                </label>
                            </div>

                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="pdf" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset') === 'pdf' ? 'checked' : '' }}>
                                    <div class="py-2">
                                        <svg viewBox="0 0 80 100" style="width: 48px; height: 60px;">
                                            <path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/>
                                            <path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/>
                                            <text x="40" y="65" fill="#ffffff" font-family="Arial" font-weight="900" font-size="28" text-anchor="middle">PDF</text>
                                        </svg>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">Dokumen PDF</span>
                                </label>
                            </div>

                            <div class="col-md-4 col-6">
                                <label class="border rounded p-2 text-center d-block bg-white cursor-pointer position-relative icon-choice-box">
                                    <input type="radio" name="icon_preset" value="custom" class="form-check-input position-absolute top-0 end-0 m-2" {{ old('icon_preset') === 'custom' ? 'checked' : '' }}>
                                    <div class="py-2 d-flex align-items-center justify-content-center text-muted" style="height: 60px;">
                                        <i class="bi bi-upload fs-2"></i>
                                    </div>
                                    <span class="d-block small fw-bold text-dark">Upload Kustom</span>
                                </label>
                            </div>
                        </div>

                        {{-- Input Upload Kustom (tampil jika memilih custom) --}}
                        <div id="custom-icon-upload-wrap" style="display: none;">
                            <label for="custom_icon" class="form-label fw-semibold text-dark small">
                                Upload File Gambar Ikon Kustom (PNG, SVG, JPG)
                            </label>
                            <input type="file"
                                   id="custom_icon"
                                   name="custom_icon"
                                   class="form-control @error('custom_icon') is-invalid @enderror"
                                   accept="image/*">
                            @error('custom_icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 4. Urutan & Status Aktif --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-12">
                            <label for="urutan" class="form-label fw-bold text-dark small">
                                Nomor Urutan Tampilan
                            </label>
                            <input type="number"
                                   id="urutan"
                                   name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $nextUrutan ?? 1) }}"
                                   min="0">
                            <div class="form-text text-muted small">Semakin kecil angkanya, semakin di awal posisinya.</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12 d-flex align-items-center pt-md-3">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-semibold" for="is_active">
                                    Status Aktif (Tampilkan di Publik)
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                        <a href="{{ route('template-dokumen.index') }}" class="btn btn-secondary px-3">Batal</a>
                        <button type="submit" class="btn fw-semibold px-4" style="background-color: #000000; color: #ffffff;">
                            <i class="bi bi-save me-1"></i> Simpan Template Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Live Card Preview Side Box --}}
    <div class="col-lg-4 col-md-12">
        <div class="card shadow-sm border-0 sticky-top" style="top: 90px; border-radius: 12px;">
            <div class="card-header bg-white py-3" style="border-top: 3px solid #047857; border-radius: 12px 12px 0 0;">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-eye-fill me-1 text-success"></i> Live Preview Kartu
                </h6>
                <small class="text-muted">Simulasi tampilan pada halaman /template-dokumen</small>
            </div>
            <div class="card-body p-4 text-center bg-white" style="border-radius: 0 0 12px 12px;">
                <div class="mx-auto rounded-3 d-flex align-items-center justify-content-center mb-3 shadow-sm"
                     style="background-color: #ebf5ee; height: 180px; width: 100%; max-width: 240px; border: 1px solid #d4ebd9;">
                    <div id="live-icon-container">
                        <svg viewBox="0 0 80 100" style="width: 82px; height: 102px;">
                            <path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/>
                            <path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/>
                            <text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="46" text-anchor="middle">P</text>
                        </svg>
                    </div>
                </div>

                <h6 id="live-title-preview" class="fw-bold text-dark mt-2 mb-1" style="font-size: 15px;">
                    Presentasi (.pptx)
                </h6>
                <small id="live-drive-preview" class="text-muted text-truncate d-block small" style="max-width: 220px; margin: 0 auto;">
                    Link Google Drive
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const judulInput = document.getElementById('judul');
        const driveInput = document.getElementById('link_drive');
        const liveTitle = document.getElementById('live-title-preview');
        const liveDrive = document.getElementById('live-drive-preview');
        const liveIcon = document.getElementById('live-icon-container');
        const customUploadWrap = document.getElementById('custom-icon-upload-wrap');
        const customFileInput = document.getElementById('custom_icon');
        const radioPresets = document.querySelectorAll('input[name="icon_preset"]');

        const svgs = {
            powerpoint: '<svg viewBox="0 0 80 100" style="width: 82px; height: 102px;"><path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/><path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/><text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="46" text-anchor="middle">P</text></svg>',
            word: '<svg viewBox="0 0 80 100" style="width: 82px; height: 102px;"><path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/><path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/><text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="44" text-anchor="middle">W</text></svg>',
            idcard: '<svg viewBox="0 0 110 80" style="width: 105px; height: 80px;"><rect x="0" y="0" width="110" height="80" rx="14" fill="#2d7a3e"/><circle cx="36" cy="33" r="14" fill="#ffffff"/><path d="M16 66 C16 52 25 48 36 48 C47 48 56 52 56 66 Z" fill="#ffffff"/><rect x="66" y="24" width="30" height="7" rx="3.5" fill="#ffffff"/><rect x="66" y="38" width="30" height="7" rx="3.5" fill="#ffffff"/><rect x="66" y="52" width="22" height="7" rx="3.5" fill="#ffffff"/></svg>',
            excel: '<svg viewBox="0 0 80 100" style="width: 82px; height: 102px;"><path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/><path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/><text x="40" y="70" fill="#ffffff" font-family="Arial" font-weight="900" font-size="46" text-anchor="middle">X</text></svg>',
            pdf: '<svg viewBox="0 0 80 100" style="width: 82px; height: 102px;"><path d="M10 0 C4.5 0 0 4.5 0 10 L0 90 C0 95.5 4.5 100 10 100 L70 100 C75.5 100 80 95.5 80 90 L80 26 L54 0 Z" fill="#2d7a3e"/><path d="M54 0 L80 26 L54 26 Z" fill="#1b4d27" opacity="0.45"/><text x="40" y="65" fill="#ffffff" font-family="Arial" font-weight="900" font-size="28" text-anchor="middle">PDF</text></svg>'
        };

        if (judulInput && liveTitle) {
            judulInput.addEventListener('input', function () {
                liveTitle.textContent = this.value.trim() || 'Judul Template';
            });
        }

        if (driveInput && liveDrive) {
            driveInput.addEventListener('input', function () {
                liveDrive.textContent = this.value.trim() || 'Link Google Drive';
            });
        }

        function updateIconPreview(val) {
            if (val === 'custom') {
                customUploadWrap.style.display = 'block';
                if (customFileInput && customFileInput.files.length) {
                    // file preview
                } else {
                    liveIcon.innerHTML = '<i class="bi bi-file-earmark-arrow-down text-success" style="font-size: 70px;"></i>';
                }
            } else {
                customUploadWrap.style.display = 'none';
                if (svgs[val]) {
                    liveIcon.innerHTML = svgs[val];
                }
            }
        }

        radioPresets.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    updateIconPreview(this.value);
                }
            });
            if (radio.checked) {
                updateIconPreview(radio.value);
            }
        });

        if (customFileInput) {
            customFileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        liveIcon.innerHTML = '<img src="' + e.target.result + '" style="width:85px;height:95px;object-fit:contain;">';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endpush
