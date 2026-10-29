@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>E-Magazine & Buku Saku Profil Kampus</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Beranda Humas</li>
            <li class="breadcrumb-item active">E-Magazine & Buku Saku</li>
        </ol>
    </nav>
</div>

{{-- Banner Info Penjelasan --}}
<div class="alert alert-primary border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-4" style="background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px;">
    <div class="rounded-circle p-2 bg-white shadow-sm text-primary fs-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
        <i class="bi bi-book-half" style="color: #000000;"></i>
    </div>
    <div>
        <h6 class="fw-bold mb-1" style="color: #14532d;">Pengelolaan Seksi E-Magazine & Buku Saku Universitas</h6>
        <p class="mb-0 text-muted small" style="line-height: 1.5;">
            Menu ini mengatur tampilan seksi <strong>"E-Magazine Profil Universitas"</strong> pada halaman publik <strong>/humas</strong> (tepat di bawah banner Hotline Helpdesk).
            Terdapat 2 tab interaktif: <strong>E-Magazine</strong> dan <strong>Buku Saku</strong>, lengkap dengan teks judul, deskripsi, pratinjau interaktif, dan tautan/berkas dokumen unduhan.
        </p>
    </div>
</div>

<form action="{{ route('emagazine-humas.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 1. Pengaturan Utama Seksi --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between" style="border-top: 3px solid #000000; border-radius: 12px 12px 0 0;">
            <h5 class="mb-0 fw-bold" style="color: #2b2f32; font-size: 16px;">
                <i class="bi bi-gear-fill me-2" style="color: #000000;"></i>Pengaturan Umum Seksi
            </h5>
            <a href="{{ route('homepage.humas') }}#emagazine-section" target="_blank" class="btn btn-sm btn-outline-success">
                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di /humas
            </a>
        </div>
        <div class="card-body pt-3 pb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-8 col-12">
                    <label for="judul_seksi" class="form-label fw-bold text-dark small">
                        Judul Utama Seksi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="judul_seksi"
                           name="judul_seksi"
                           class="form-control @error('judul_seksi') is-invalid @enderror"
                           value="{{ old('judul_seksi', $emagazine->judul_seksi ?? 'E-Magazine Profil Universitas') }}"
                           placeholder="Contoh: E-Magazine Profil Universitas"
                           required>
                    @error('judul_seksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 col-12">
                    <label class="form-label fw-bold text-dark small d-block">Status Tampilan di Halaman /humas</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" {{ old('is_active', $emagazine->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label text-dark fw-semibold small" for="is_active">
                            Aktifkan & Tampilkan Seksi Ini
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Tab Navigasi Pengaturan: Tab 1 & Tab 2 --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-header bg-white py-3" style="border-top: 3px solid #f9dc4b; border-radius: 12px 12px 0 0;">
            <ul class="nav nav-pills card-header-pills" id="emagzTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold px-4" id="tab1-tab" data-bs-toggle="pill" data-bs-target="#tab1-content" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-book-half me-1"></i> Tab 1: E-Magazine
                    </button>
                </li>
                <li class="nav-item ms-2" role="presentation">
                    <button class="nav-link fw-bold px-4" id="tab2-tab" data-bs-toggle="pill" data-bs-target="#tab2-content" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-journal-bookmark me-1"></i> Tab 2: Buku Saku
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="emagzTabsContent">

                {{-- ══════════════════════════════════════════
                     TAB 1: E-MAGAZINE
                ══════════════════════════════════════════ --}}
                <div class="tab-pane fade show active" id="tab1-content" role="tabpanel" aria-labelledby="tab1-tab">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="badge bg-success px-2 py-1">TAB 1</span>
                        <h6 class="fw-bold text-dark mb-0">Konten Publikasi E-Magazine</h6>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-12">
                            <label for="tab_1_label" class="form-label fw-bold text-dark small">Label Tombol Tab</label>
                            <input type="text" id="tab_1_label" name="tab_1_label" class="form-control"
                                   value="{{ old('tab_1_label', $emagazine->tab_1_label ?? 'E-Magazine') }}" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="tab_1_badge_text" class="form-label fw-bold text-dark small">Teks Label di Sampul Miniatur</label>
                            <input type="text" id="tab_1_badge_text" name="tab_1_badge_text" class="form-control"
                                   value="{{ old('tab_1_badge_text', $emagazine->tab_1_badge_text ?? 'PROFIL 2026') }}"
                                   placeholder="Contoh: PROFIL 2026">
                            <div class="form-text small text-muted">Tampil di bawah ikon buku sampul hijau (jika tidak upload custom cover).</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tab_1_judul" class="form-label fw-bold text-dark small">Judul E-Magazine</label>
                        <input type="text" id="tab_1_judul" name="tab_1_judul" class="form-control"
                               value="{{ old('tab_1_judul', $emagazine->tab_1_judul ?? 'E-Magazine Edisi Eksklusif Profil Kampus') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tab_1_deskripsi" class="form-label fw-bold text-dark small">Deskripsi Penjelasan Singkat</label>
                        <textarea id="tab_1_deskripsi" name="tab_1_deskripsi" rows="3" class="form-control">{{ old('tab_1_deskripsi', $emagazine->tab_1_deskripsi) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Cover Image Opsional --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_1_cover_image" class="form-label fw-bold text-dark small">Gambar Sampul Custom (Opsional)</label>
                            <input type="file" id="tab_1_cover_image" name="tab_1_cover_image" class="form-control" accept="image/*">
                            <div class="form-text small text-muted">Format: JPG, PNG, WEBP (Maks 5 MB). Jika dikosongkan, menggunakan miniatur kartu default UIS.</div>

                            @if($emagazine->tab_1_cover_image)
                                <div class="mt-2 p-2 border rounded d-flex align-items-center justify-content-between bg-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $emagazine->tab_1_cover_image) }}" alt="Cover Tab 1" style="width: 48px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <span class="small fw-semibold text-truncate" style="max-width: 180px;">{{ basename($emagazine->tab_1_cover_image) }}</span>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="hapus_cover_tab_1" id="hapus_cover_tab_1" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="hapus_cover_tab_1">Hapus</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Pratinjau Interaktif --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_1_btn_preview_url" class="form-label fw-bold text-dark small">Tautan Pratinjau Interaktif (Flipbook / URL)</label>
                            <input type="text" id="tab_1_btn_preview_url" name="tab_1_btn_preview_url" class="form-control"
                                   value="{{ old('tab_1_btn_preview_url', $emagazine->tab_1_btn_preview_url) }}"
                                   placeholder="https://... atau /frontend/img/gedung-uis.jpg">
                            <div class="form-text small text-muted">Link viewer Flipbook daring, Google Drive, atau gambar pratinjau.</div>
                            <div class="mt-2">
                                <label for="tab_1_btn_preview_text" class="form-label small text-muted mb-1">Teks Tombol Pratinjau:</label>
                                <input type="text" id="tab_1_btn_preview_text" name="tab_1_btn_preview_text" class="form-control form-control-sm"
                                       value="{{ old('tab_1_btn_preview_text', $emagazine->tab_1_btn_preview_text ?? 'Pratinjau Interaktif') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Berkas Dokumen Unduhan --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_1_file_download" class="form-label fw-bold text-dark small">Upload File Dokumen Unduh (PDF / DOCX)</label>
                            <input type="file" id="tab_1_file_download" name="tab_1_file_download" class="form-control" accept=".pdf,.docx,.zip">
                            <div class="form-text small text-muted">Maksimal 25 MB. Berkas PDF/DOCX yang dapat langsung diunduh pengunjung.</div>

                            @if($emagazine->tab_1_file_download)
                                <div class="mt-2 p-2 border rounded d-flex align-items-center justify-content-between bg-light">
                                    <div class="small">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i>
                                        <a href="{{ asset('storage/' . $emagazine->tab_1_file_download) }}" target="_blank" class="fw-semibold text-primary">
                                            {{ basename($emagazine->tab_1_file_download) }}
                                        </a>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="hapus_file_tab_1" id="hapus_file_tab_1" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="hapus_file_tab_1">Hapus</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- URL Alternatif Unduhan --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_1_download_url" class="form-label fw-bold text-dark small">Atau Tautan URL Eksternal Unduhan (Google Drive dsb)</label>
                            <input type="text" id="tab_1_download_url" name="tab_1_download_url" class="form-control"
                                   value="{{ old('tab_1_download_url', $emagazine->tab_1_download_url) }}"
                                   placeholder="https://drive.google.com/...">
                            <div class="form-text small text-muted">Dipakai jika tidak ingin mengupload berkas PDF langsung ke server web.</div>
                            <div class="mt-2">
                                <label for="tab_1_btn_download_text" class="form-label small text-muted mb-1">Teks Tombol Unduh:</label>
                                <input type="text" id="tab_1_btn_download_text" name="tab_1_btn_download_text" class="form-control form-control-sm"
                                       value="{{ old('tab_1_btn_download_text', $emagazine->tab_1_btn_download_text ?? 'Unduh Dokumen') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     TAB 2: BUKU SAKU
                ══════════════════════════════════════════ --}}
                <div class="tab-pane fade" id="tab2-content" role="tabpanel" aria-labelledby="tab2-tab">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="badge bg-warning text-dark px-2 py-1">TAB 2</span>
                        <h6 class="fw-bold text-dark mb-0">Konten Publikasi Buku Saku</h6>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 col-12">
                            <label for="tab_2_label" class="form-label fw-bold text-dark small">Label Tombol Tab</label>
                            <input type="text" id="tab_2_label" name="tab_2_label" class="form-control"
                                   value="{{ old('tab_2_label', $emagazine->tab_2_label ?? 'Buku Saku') }}" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="tab_2_badge_text" class="form-label fw-bold text-dark small">Teks Label di Sampul Miniatur</label>
                            <input type="text" id="tab_2_badge_text" name="tab_2_badge_text" class="form-control"
                                   value="{{ old('tab_2_badge_text', $emagazine->tab_2_badge_text ?? 'BUKU SAKU') }}"
                                   placeholder="Contoh: BUKU SAKU">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tab_2_judul" class="form-label fw-bold text-dark small">Judul Buku Saku</label>
                        <input type="text" id="tab_2_judul" name="tab_2_judul" class="form-control"
                               value="{{ old('tab_2_judul', $emagazine->tab_2_judul ?? 'Buku Saku Panduan Mahasiswa & Akademik') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tab_2_deskripsi" class="form-label fw-bold text-dark small">Deskripsi Penjelasan Singkat</label>
                        <textarea id="tab_2_deskripsi" name="tab_2_deskripsi" rows="3" class="form-control">{{ old('tab_2_deskripsi', $emagazine->tab_2_deskripsi) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Cover Image Tab 2 --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_2_cover_image" class="form-label fw-bold text-dark small">Gambar Sampul Custom (Opsional)</label>
                            <input type="file" id="tab_2_cover_image" name="tab_2_cover_image" class="form-control" accept="image/*">
                            <div class="form-text small text-muted">Format: JPG, PNG, WEBP (Maks 5 MB).</div>

                            @if($emagazine->tab_2_cover_image)
                                <div class="mt-2 p-2 border rounded d-flex align-items-center justify-content-between bg-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $emagazine->tab_2_cover_image) }}" alt="Cover Tab 2" style="width: 48px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        <span class="small fw-semibold text-truncate" style="max-width: 180px;">{{ basename($emagazine->tab_2_cover_image) }}</span>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="hapus_cover_tab_2" id="hapus_cover_tab_2" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="hapus_cover_tab_2">Hapus</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Pratinjau Interaktif Tab 2 --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_2_btn_preview_url" class="form-label fw-bold text-dark small">Tautan Pratinjau Interaktif</label>
                            <input type="text" id="tab_2_btn_preview_url" name="tab_2_btn_preview_url" class="form-control"
                                   value="{{ old('tab_2_btn_preview_url', $emagazine->tab_2_btn_preview_url) }}"
                                   placeholder="https://... atau /frontend/img/gedung-uis.jpg">
                            <div class="mt-2">
                                <label for="tab_2_btn_preview_text" class="form-label small text-muted mb-1">Teks Tombol Pratinjau:</label>
                                <input type="text" id="tab_2_btn_preview_text" name="tab_2_btn_preview_text" class="form-control form-control-sm"
                                       value="{{ old('tab_2_btn_preview_text', $emagazine->tab_2_btn_preview_text ?? 'Pratinjau Interaktif') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Berkas Dokumen Unduhan Tab 2 --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_2_file_download" class="form-label fw-bold text-dark small">Upload File Dokumen Unduh (PDF / DOCX)</label>
                            <input type="file" id="tab_2_file_download" name="tab_2_file_download" class="form-control" accept=".pdf,.docx,.zip">
                            <div class="form-text small text-muted">Maksimal 25 MB. Berkas PDF/DOCX yang dapat langsung diunduh pengunjung.</div>

                            @if($emagazine->tab_2_file_download)
                                <div class="mt-2 p-2 border rounded d-flex align-items-center justify-content-between bg-light">
                                    <div class="small">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i>
                                        <a href="{{ asset('storage/' . $emagazine->tab_2_file_download) }}" target="_blank" class="fw-semibold text-primary">
                                            {{ basename($emagazine->tab_2_file_download) }}
                                        </a>
                                    </div>
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="hapus_file_tab_2" id="hapus_file_tab_2" value="1">
                                        <label class="form-check-label text-danger small fw-semibold" for="hapus_file_tab_2">Hapus</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- URL Alternatif Unduhan Tab 2 --}}
                        <div class="col-md-6 col-12">
                            <label for="tab_2_download_url" class="form-label fw-bold text-dark small">Atau Tautan URL Eksternal Unduhan</label>
                            <input type="text" id="tab_2_download_url" name="tab_2_download_url" class="form-control"
                                   value="{{ old('tab_2_download_url', $emagazine->tab_2_download_url) }}"
                                   placeholder="https://drive.google.com/...">
                            <div class="mt-2">
                                <label for="tab_2_btn_download_text" class="form-label small text-muted mb-1">Teks Tombol Unduh:</label>
                                <input type="text" id="tab_2_btn_download_text" name="tab_2_btn_download_text" class="form-control form-control-sm"
                                       value="{{ old('tab_2_btn_download_text', $emagazine->tab_2_btn_download_text ?? 'Unduh Dokumen') }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-end gap-2" style="border-radius: 0 0 12px 12px;">
            <button type="submit" class="btn btn-success fw-bold px-4 shadow-sm" style="background: #000000; border: none !important;">
                <i class="bi bi-save2-fill me-1"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</form>
@endsection
