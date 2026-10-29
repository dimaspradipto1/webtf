@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Informasi Penerimaan Mahasiswa Baru (PMB)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Portal Layanan</li>
            <li class="breadcrumb-item active">Informasi PMB</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

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

            <form action="{{ route('akademik.informasi-pmb.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ═══════════════════════════════════════════════════════════
                     1. HEADER UTAMA & LINK PENDAFTARAN
                ═══════════════════════════════════════════════════════════ -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                            <div>
                                <h5 class="card-title mb-0 p-0 fw-bold text-dark">Header Utama & Portal PMB</h5>
                                <div class="small text-muted">Atur teks pembuka, link pendaftaran online, dan kontak WhatsApp resmi.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('homepage.portal.page', 'informasi-pmb') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Publik
                            </a>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $pmb->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold small text-muted" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Judul Utama Halaman <span class="text-danger">*</span></label>
                                <input type="text" name="judul_hero" class="form-control" value="{{ old('judul_hero', $pmb->judul_hero) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">Subjudul / Tahun Akademik</label>
                                <input type="text" name="subjudul_hero" class="form-control" value="{{ old('subjudul_hero', $pmb->subjudul_hero) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark"><i class="bi bi-link-45deg text-primary me-1"></i>Link Portal Pendaftaran Online</label>
                                <input type="url" name="link_pendaftaran" class="form-control" value="{{ old('link_pendaftaran', $pmb->link_pendaftaran) }}" placeholder="https://pmb.uis.ac.id">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark"><i class="bi bi-whatsapp text-success me-1"></i>No. WhatsApp Konsultasi PMB</label>
                                <input type="text" name="no_whatsapp" class="form-control" value="{{ old('no_whatsapp', $pmb->no_whatsapp) }}" placeholder="081270000000">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-dark"><i class="bi bi-image text-info me-1"></i>Upload Banner Hero Utama (Opsional - Format PNG/JPG/WEBP)</label>
                                <input type="file" name="banner_hero" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Jika diupload, gambar banner ini akan menggantikan grafis banner atas. Rekomendasi ukuran: 1920x600 px.</div>
                                @if($pmb->banner_hero)
                                    <div class="mt-2 p-2 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                        <small class="text-muted"><i class="bi bi-check-circle-fill text-success me-1"></i>Banner aktif tersimpan</small>
                                        <a href="{{ asset('storage/' . $pmb->banner_hero) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-0">Lihat Gambar</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════
                     2. BROSUR PMB (GAMBAR PNG & FILE PDF DOKUMEN)
                ═══════════════════════════════════════════════════════════ -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-image-fill text-danger fs-4"></i>
                        <div>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Brosur PMB (Gambar & Download PDF)</h5>
                            <div class="small text-muted">Upload gambar pamflet/flyer brosur PMB beserta file PDF untuk pengunjung mengunduh.</div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark"><i class="bi bi-file-earmark-image text-primary me-1"></i>Upload Gambar Brosur (PNG / JPG / WEBP)</label>
                                <input type="file" name="brosur_gambar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Tampilan gambar brosur depan yang akan dimuat langsung di halaman publik.</div>
                                @if($pmb->brosur_gambar)
                                    <div class="mt-3 text-center p-2 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $pmb->brosur_gambar) }}" alt="Brosur PMB" class="img-fluid rounded" style="max-height: 220px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Gambar Brosur Aktif</span></div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>Upload File Brosur PDF</label>
                                <input type="file" name="brosur_pdf" class="form-control" accept="application/pdf">
                                <div class="form-text small">File PDF resmi yang diunduh pengunjung saat mengklik tombol "Download Brosur PDF".</div>
                                @if($pmb->brosur_pdf)
                                    <div class="mt-3 p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="bi bi-file-pdf-fill text-danger fs-3 me-2"></i>
                                            <span class="fw-semibold small text-dark">File PDF Brosur Terunggah</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $pmb->brosur_pdf) }}" target="_blank" class="btn btn-sm btn-danger px-3 rounded-pill">
                                            <i class="bi bi-download me-1"></i> Buka PDF
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════
                     3. JADWAL PMB & JENIS BIAYA (UPLOAD INFOGRAFIS PNG)
                ═══════════════════════════════════════════════════════════ -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-event-fill text-warning fs-4"></i>
                        <div>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Infografis Jadwal PMB & Jenis Biaya (PNG/JPG)</h5>
                            <div class="small text-muted">Upload file gambar infografis tabel jadwal gelombang dan rincian jenis biaya kuliah.</div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Jadwal PMB -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">
                                    <i class="bi bi-calendar-check text-success me-1"></i>Upload Gambar Infografis Jadwal PMB
                                </label>
                                <input type="file" name="jadwal_gambar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Gambar tabel jadwal gelombang pendaftaran, tes, dan her-registrasi.</div>
                                @if($pmb->jadwal_gambar)
                                    <div class="mt-3 text-center p-2 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $pmb->jadwal_gambar) }}" alt="Jadwal PMB" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Infografis Jadwal Aktif</span></div>
                                    </div>
                                @endif
                            </div>

                            <!-- Jenis Biaya -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">
                                    <i class="bi bi-cash-stack text-success me-1"></i>Upload Gambar Infografis Jenis Biaya
                                </label>
                                <input type="file" name="biaya_gambar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Gambar tabel rincian biaya kuliah per semester / komponen SPP dan SKS.</div>
                                @if($pmb->biaya_gambar)
                                    <div class="mt-3 text-center p-2 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $pmb->biaya_gambar) }}" alt="Jenis Biaya" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Infografis Biaya Aktif</span></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════
                     4. PAKET KELAS PMB (REGULER A, B, C)
                ═══════════════════════════════════════════════════════════ -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-tag-fill text-info fs-4"></i>
                        <div>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Paket Kelas PMB & Biaya Bulanan</h5>
                            <div class="small text-muted">Sesuaikan 3 kartu pilihan kelas perkuliahan (Reguler B, Reguler A, dan Reguler C).</div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Paket Reguler B -->
                            <div class="col-lg-4">
                                <div class="p-3 rounded-4 border bg-light h-100">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="fw-bold text-dark mb-0">Paket 1 (Pilihan Populer)</h6>
                                        <span class="badge bg-warning text-dark">Best Choice</span>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Nama Kelas</label>
                                        <input type="text" name="reguler_b_nama" class="form-control form-control-sm" value="{{ old('reguler_b_nama', $pmb->reguler_b_nama) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Biaya / Tarif</label>
                                        <input type="text" name="reguler_b_biaya" class="form-control form-control-sm" value="{{ old('reguler_b_biaya', $pmb->reguler_b_biaya) }}">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold">Rincian Fasilitas (1 baris 1 poin)</label>
                                        <textarea name="reguler_b_keterangan" class="form-control form-control-sm" rows="6">{{ old('reguler_b_keterangan', $pmb->reguler_b_keterangan) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Paket Reguler A -->
                            <div class="col-lg-4">
                                <div class="p-3 rounded-4 border bg-light h-100">
                                    <h6 class="fw-bold text-dark mb-2">Paket 2 (Reguler Pagi)</h6>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Nama Kelas</label>
                                        <input type="text" name="reguler_a_nama" class="form-control form-control-sm" value="{{ old('reguler_a_nama', $pmb->reguler_a_nama) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Biaya / Tarif</label>
                                        <input type="text" name="reguler_a_biaya" class="form-control form-control-sm" value="{{ old('reguler_a_biaya', $pmb->reguler_a_biaya) }}">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold">Rincian Fasilitas (1 baris 1 poin)</label>
                                        <textarea name="reguler_a_keterangan" class="form-control form-control-sm" rows="6">{{ old('reguler_a_keterangan', $pmb->reguler_a_keterangan) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Paket Reguler C -->
                            <div class="col-lg-4">
                                <div class="p-3 rounded-4 border bg-light h-100">
                                    <h6 class="fw-bold text-dark mb-2">Paket 3 (Karyawan / Eksekutif)</h6>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Nama Kelas</label>
                                        <input type="text" name="reguler_c_nama" class="form-control form-control-sm" value="{{ old('reguler_c_nama', $pmb->reguler_c_nama) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Biaya / Tarif</label>
                                        <input type="text" name="reguler_c_biaya" class="form-control form-control-sm" value="{{ old('reguler_c_biaya', $pmb->reguler_c_biaya) }}">
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold">Rincian Fasilitas (1 baris 1 poin)</label>
                                        <textarea name="reguler_c_keterangan" class="form-control form-control-sm" rows="6">{{ old('reguler_c_keterangan', $pmb->reguler_c_keterangan) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════════════════════
                     5. ALUR PENDAFTARAN & BANNER CTA BAWAH
                ═══════════════════════════════════════════════════════════ -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-3-fill text-success fs-4"></i>
                        <div>
                            <h5 class="card-title mb-0 p-0 fw-bold text-dark">Alur Pendaftaran & Banner Ajakan Bawah (CTA)</h5>
                            <div class="small text-muted">Upload gambar infografis 9 alur pendaftaran dan banner penutup bawah.</div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Alur Pendaftaran -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">
                                    <i class="bi bi-diagram-3 text-primary me-1"></i>Upload Infografis Alur Pendaftaran (PNG/JPG)
                                </label>
                                <input type="file" name="alur_gambar" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Gambar panduan langkah 1-9 pendaftaran PMB.</div>
                                @if($pmb->alur_gambar)
                                    <div class="mt-3 text-center p-2 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $pmb->alur_gambar) }}" alt="Alur Pendaftaran" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Infografis Alur Aktif</span></div>
                                    </div>
                                @endif
                            </div>

                            <!-- Banner CTA Bawah -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-dark">
                                    <i class="bi bi-badge-ad text-primary me-1"></i>Upload Banner Ajakan Bawah (PNG/JPG)
                                </label>
                                <input type="file" name="banner_cta" class="form-control" accept="image/png,image/jpeg,image/webp">
                                <div class="form-text small">Banner penutup di bagian bawah halaman sebelum footer.</div>
                                @if($pmb->banner_cta)
                                    <div class="mt-3 text-center p-2 bg-light rounded-3 border">
                                        <img src="{{ asset('storage/' . $pmb->banner_cta) }}" alt="Banner CTA" class="img-fluid rounded" style="max-height: 180px; object-fit: contain;">
                                        <div class="mt-2"><span class="badge bg-success">Banner CTA Aktif</span></div>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <label class="form-label small fw-semibold">Judul CTA Bawah</label>
                                    <input type="text" name="cta_judul" class="form-control form-control-sm" value="{{ old('cta_judul', $pmb->cta_judul) }}">
                                </div>
                                <div class="mt-2">
                                    <label class="form-label small fw-semibold">Subjudul CTA Bawah</label>
                                    <input type="text" name="cta_subjudul" class="form-control form-control-sm" value="{{ old('cta_subjudul', $pmb->cta_subjudul) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm" style="background: #000000; border: none !important;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Data & Berkas PMB
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</section>
@endsection

