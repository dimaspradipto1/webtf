@extends('layouts.dashboard.template')

@section('title', 'Pengaturan Banner PMB & Pendaftaran')

@section('content')
<div class="pagetitle">
    <h1>Informasi PMB & Pendaftaran</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Profil & Konten UIS</li>
            <li class="breadcrumb-item active">Banner PMB</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            {{-- Alert Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terdapat kesalahan pengisian formulir:</strong>
                    <ul class="mb-0 mt-1 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('pmb-setting.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fw-bold text-dark fs-6">
                            <i class="bi bi-megaphone-fill text-warning me-2"></i> Pengaturan Konten Call to Action (CTA) PMB
                        </h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $pmb->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark small" for="is_active">Tampilkan di Halaman Depan</label>
                        </div>
                    </div>

                    <div class="card-body pt-4">

                        {{-- Section 1: Teks Utama Banner --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-5">
                                <label for="badge_text" class="form-label fw-bold text-dark">
                                    Label / Badge Atas <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="badge_text" name="badge_text" class="form-control @error('badge_text') is-invalid @enderror" value="{{ old('badge_text', $pmb->badge_text) }}" placeholder="PENERIMAAN MAHASISWA BARU (PMB) T.A. 2026/2027" required>
                                <div class="form-text small text-muted">Teks sorotan kecil berlatar kuning di atas judul.</div>
                                @error('badge_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-7">
                                <label for="judul" class="form-label fw-bold text-dark">
                                    Judul Utama Banner PMB <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $pmb->judul) }}" placeholder="Daftar Sekarang & Raih Masa Depan Cerah Bersama Teknik Informatika!" required>
                                <div class="form-text small text-muted">Headline utama yang mencolok bagi calon pendaftar.</div>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label fw-bold text-dark">
                                    Deskripsi Jalur Penerimaan / Keterangan Tambahan
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Tersedia berbagai jalur seleksi: Jalur Bebas Tes / Prestasi, Jalur Reguler, Jalur KIP-Kuliah, dan Jalur Alih Jenjang Karyawan.">{{ old('deskripsi', $pmb->deskripsi) }}</textarea>
                                <div class="form-text small text-muted">Penjelasan jalur masuk atau syarat singkat.</div>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        {{-- Section 2: Tombol & Link URL --}}
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-link-45deg me-1 fs-5"></i> Konfigurasi Tombol Aksi (Buttons)
                        </h6>

                        <div class="row g-4 mb-4">
                            {{-- Tombol 1: Pendaftaran --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #faf7fc; border: 1px solid #ebdcf5;">
                                    <div class="fw-bold text-dark mb-3"><i class="bi bi-box-arrow-up-right me-1 text-warning"></i> Tombol Utama (Warna Oranye)</div>
                                    <div class="mb-3">
                                        <label for="tombol_text_1" class="form-label fw-semibold small text-dark">Teks Tombol 1 <span class="text-danger">*</span></label>
                                        <input type="text" id="tombol_text_1" name="tombol_text_1" class="form-control @error('tombol_text_1') is-invalid @enderror" value="{{ old('tombol_text_1', $pmb->tombol_text_1) }}" placeholder="Daftar PMB Sekarang" required>
                                    </div>
                                    <div class="mb-0">
                                        <label for="tombol_link_1" class="form-label fw-semibold small text-dark">Link / URL Tombol 1 <span class="text-danger">*</span></label>
                                        <input type="text" id="tombol_link_1" name="tombol_link_1" class="form-control @error('tombol_link_1') is-invalid @enderror" value="{{ old('tombol_link_1', $pmb->tombol_link_1) }}" placeholder="https://pmb.uis.ac.id atau /kontak" required>
                                        <div class="form-text small" style="font-size: 11.5px;">Bisa berupa URL portal eksternal (https://...) atau rute internal (/kontak).</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol 2: Konsultasi / WhatsApp --}}
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="fw-bold text-dark mb-3"><i class="bi bi-whatsapp me-1 text-success"></i> Tombol Kedua (WhatsApp / Info)</div>
                                    <div class="mb-3">
                                        <label for="tombol_text_2" class="form-label fw-semibold small text-dark">Teks Tombol 2</label>
                                        <input type="text" id="tombol_text_2" name="tombol_text_2" class="form-control @error('tombol_text_2') is-invalid @enderror" value="{{ old('tombol_text_2', $pmb->tombol_text_2) }}" placeholder="Konsultasi WhatsApp PMB">
                                    </div>
                                    <div class="mb-0">
                                        <label for="tombol_link_2" class="form-label fw-semibold small text-dark">Link / URL Tombol 2</label>
                                        <input type="text" id="tombol_link_2" name="tombol_link_2" class="form-control @error('tombol_link_2') is-invalid @enderror" value="{{ old('tombol_link_2', $pmb->tombol_link_2) }}" placeholder="https://wa.me/6281234567890?text=Halo%20Admin%20PMB">
                                        <div class="form-text small" style="font-size: 11.5px;">Kosongkan jika ingin otomatis memakai WhatsApp utama dari menu Kontak.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        {{-- Section 3: Jadwal Gelombang (Dinamis dengan tombol +) --}}
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-primary mb-0">
                                <i class="bi bi-calendar-check me-1 fs-5"></i> Jadwal Gelombang Pendaftaran
                            </h6>
                            <button type="button" id="btn-add-gelombang" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Gelombang
                            </button>
                        </div>
                        <div class="form-text small text-muted mb-3">
                            Tambahkan atau hapus gelombang pendaftaran sesuai periode yang dibuka.
                        </div>

                        <div id="gelombang-container" class="row g-3 mb-4">
                            @php
                                $activeWaves = old('gelombang_list', $pmb->waves ?? ['Gelombang 1: Jan - Apr', 'Gelombang 2: Mei - Jul', 'Gelombang 3: Agu - Sep']);
                                if (empty($activeWaves)) {
                                    $activeWaves = ['Gelombang 1: Jan - Apr'];
                                }
                            @endphp

                            @foreach($activeWaves as $index => $waveText)
                                <div class="col-md-6 col-lg-4 gelombang-item">
                                    <label class="form-label fw-semibold small text-dark d-flex justify-content-between align-items-center">
                                        <span class="wave-label">Gelombang {{ $loop->iteration }}</span>
                                        <button type="button" class="btn btn-link text-danger p-0 text-decoration-none btn-remove-gelombang" title="Hapus Gelombang ini" style="font-size: 13px;">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar3"></i></span>
                                        <input type="text" name="gelombang_list[]" class="form-control border-start-0" value="{{ $waveText }}" placeholder="Contoh: Gelombang {{ $loop->iteration }}: Jan - Apr" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="card-footer bg-light py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold" style="background: #000000; border: none !important;">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan Banner PMB
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('gelombang-container');
        const btnAdd = document.getElementById('btn-add-gelombang');

        function updateLabels() {
            const items = container.querySelectorAll('.gelombang-item');
            items.forEach((item, idx) => {
                const label = item.querySelector('.wave-label');
                if (label) label.textContent = `Gelombang ${idx + 1}`;
                const input = item.querySelector('input[name="gelombang_list[]"]');
                if (input && !input.value) {
                    input.placeholder = `Contoh: Gelombang ${idx + 1}: Periode Bulan`;
                }
            });
        }

        if (btnAdd) {
            btnAdd.addEventListener('click', function () {
                const total = container.querySelectorAll('.gelombang-item').length + 1;
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4 gelombang-item';
                col.innerHTML = `
                    <label class="form-label fw-semibold small text-dark d-flex justify-content-between align-items-center">
                        <span class="wave-label">Gelombang ${total}</span>
                        <button type="button" class="btn btn-link text-danger p-0 text-decoration-none btn-remove-gelombang" title="Hapus Gelombang ini" style="font-size: 13px;">
                            <i class="bi bi-trash-fill"></i> Hapus
                        </button>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-calendar3"></i></span>
                        <input type="text" name="gelombang_list[]" class="form-control border-start-0" placeholder="Contoh: Gelombang ${total}: Periode Bulan" required>
                    </div>
                `;
                container.appendChild(col);
                col.querySelector('input').focus();
            });
        }

        container.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.btn-remove-gelombang');
            if (removeBtn) {
                const item = removeBtn.closest('.gelombang-item');
                if (container.querySelectorAll('.gelombang-item').length <= 1) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Minimal 1 Gelombang',
                        text: 'Setidaknya harus ada 1 jadwal gelombang pendaftaran.',
                        confirmButtonColor: '#000000'
                    });
                    return;
                }
                item.remove();
                updateLabels();
            }
        });
    });
</script>
@endpush
