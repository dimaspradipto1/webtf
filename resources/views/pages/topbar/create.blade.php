@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Pengaturan Topbar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('topbar.index') }}">Topbar</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-layout-text-window-reverse me-2 text-primary"></i>Formulir Tambah Pengaturan Topbar
        </h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('topbar.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                {{-- Section 1: Badge Topbar --}}
                <div class="col-12">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-tag-fill me-1 text-primary"></i>1. Badge Kiri Topbar
                    </h6>
                </div>

                <div class="col-md-6">
                    <label for="badge_text" class="form-label fw-semibold text-dark">Teks Badge <span class="text-danger">*</span></label>
                    <input type="text" name="badge_text" id="badge_text" class="form-control @error('badge_text') is-invalid @enderror" placeholder="Contoh: Teknik Informatika" value="{{ old('badge_text', 'Teknik Informatika') }}" required>
                    @error('badge_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="badge_icon" class="form-label fw-semibold text-dark">Ikon Bootstrap Badge</label>
                    <input type="text" name="badge_icon" id="badge_icon" class="form-control @error('badge_icon') is-invalid @enderror" placeholder="Contoh: bi-shield-check" value="{{ old('badge_icon', 'bi-shield-check') }}">
                    <small class="text-muted">Nama class Bootstrap Icons (misal: <code>bi-shield-check</code>, <code>bi-mortarboard-fill</code>)</small>
                    @error('badge_icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section 2: Informasi & Lokasi --}}
                <div class="col-12 mt-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-geo-alt-fill me-1 text-warning"></i>2. Informasi Kampus & Jam Operasional
                    </h6>
                </div>

                <div class="col-md-7">
                    <label for="alamat" class="form-label fw-semibold text-dark">Alamat Singkat Kampus</label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Contoh: Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444" value="{{ old('alamat', 'Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444') }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label for="jam_operasional" class="form-label fw-semibold text-dark">Jam Operasional</label>
                    <input type="text" name="jam_operasional" id="jam_operasional" class="form-control @error('jam_operasional') is-invalid @enderror" placeholder="Contoh: Senin - Sabtu: 08.00 - 17.00 WIB" value="{{ old('jam_operasional', 'Senin - Sabtu: 08.00 - 17.00 WIB') }}">
                    @error('jam_operasional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="telepon" class="form-label fw-semibold text-dark">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" placeholder="Contoh: 123456789 atau 081234567890" value="{{ old('telepon', '123456789') }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold text-dark">Email Resmi</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Contoh: admin@uis.ac.id" value="{{ old('email', 'admin@uis.ac.id') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Section 3: Dynamic Media Sosial Repeater (+) --}}
                <div class="col-12 mt-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="bi bi-share-fill me-1 text-info"></i>3. Akun Media Sosial Topbar (Dinamis)
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold" id="btn-add-sosmed">
                            <i class="bi bi-plus-circle-fill me-1"></i> Tambah Media Sosial
                        </button>
                    </div>

                    <div id="sosmed-wrapper" class="d-flex flex-column gap-2">
                        @php
                            $defaultSosmed = old('social_media', [
                                ['platform' => 'Instagram', 'icon' => 'bi-instagram', 'url' => 'https://instagram.com'],
                                ['platform' => 'YouTube', 'icon' => 'bi-youtube', 'url' => 'https://youtube.com'],
                            ]);
                        @endphp

                        @foreach($defaultSosmed as $index => $item)
                            <div class="sosmed-row p-2 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-2">
                                <div style="min-width: 150px; flex: 1;">
                                    <input type="text" name="social_media[{{ $index }}][platform]" class="form-control form-control-sm" placeholder="Platform (e.g. Instagram)" value="{{ $item['platform'] ?? '' }}">
                                </div>
                                <div style="min-width: 140px; flex: 1;">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="bi {{ !empty($item['icon']) ? $item['icon'] : 'bi-globe' }}"></i></span>
                                        <input type="text" name="social_media[{{ $index }}][icon]" class="form-control form-control-sm sosmed-icon" placeholder="bi-instagram" value="{{ $item['icon'] ?? 'bi-globe' }}">
                                    </div>
                                </div>
                                <div style="min-width: 250px; flex: 2;">
                                    <input type="url" name="social_media[{{ $index }}][url]" class="form-control form-control-sm" placeholder="https://..." value="{{ $item['url'] ?? '' }}">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-sosmed" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i> Klik tombol <strong>+ Tambah Media Sosial</strong> untuk menambah platform baru sesuai kebutuhan.
                    </small>
                </div>

                {{-- Status Aktif --}}
                <div class="col-12 mt-3">
                    <div class="form-check form-switch p-2 bg-light rounded-3 border d-flex align-items-center gap-3">
                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                            Gunakan sebagai Topbar aktif di frontend website
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Pengaturan Topbar
                </button>
                <a href="{{ route('topbar.index') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let sosmedIndex = {{ count($defaultSosmed) }};

        const presetIcons = {
            'instagram': 'bi-instagram',
            'youtube': 'bi-youtube',
            'tiktok': 'bi-tiktok',
            'facebook': 'bi-facebook',
            'linkedin': 'bi-linkedin',
            'twitter': 'bi-twitter-x',
            'x': 'bi-twitter-x',
            'threads': 'bi-threads',
            'whatsapp': 'bi-whatsapp',
            'telegram': 'bi-telegram',
            'spotify': 'bi-spotify',
            'github': 'bi-github',
            'website': 'bi-globe'
        };

        $('#btn-add-sosmed').on('click', function () {
            const html = `
                <div class="sosmed-row p-2 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-2">
                    <div style="min-width: 150px; flex: 1;">
                        <input type="text" name="social_media[${sosmedIndex}][platform]" class="form-control form-control-sm platform-input" placeholder="Platform (e.g. TikTok, X, Threads)">
                    </div>
                    <div style="min-width: 140px; flex: 1;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><i class="bi bi-globe"></i></span>
                            <input type="text" name="social_media[${sosmedIndex}][icon]" class="form-control form-control-sm sosmed-icon" placeholder="bi-globe" value="bi-globe">
                        </div>
                    </div>
                    <div style="min-width: 250px; flex: 2;">
                        <input type="url" name="social_media[${sosmedIndex}][url]" class="form-control form-control-sm" placeholder="https://...">
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-sosmed" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#sosmed-wrapper').append(html);
            sosmedIndex++;
        });

        $(document).on('click', '.btn-remove-sosmed', function () {
            if ($('.sosmed-row').length > 1) {
                $(this).closest('.sosmed-row').remove();
            } else {
                $(this).closest('.sosmed-row').find('input').val('');
            }
        });

        $(document).on('input', '.platform-input', function () {
            const val = $(this).val().toLowerCase().trim();
            const row = $(this).closest('.sosmed-row');
            for (const [key, iconClass] of Object.entries(presetIcons)) {
                if (val.includes(key)) {
                    row.find('.sosmed-icon').val(iconClass);
                    row.find('.input-group-text i').attr('class', 'bi ' + iconClass);
                    break;
                }
            }
        });

        $(document).on('input', '.sosmed-icon', function () {
            const iconClass = $(this).val().trim();
            $(this).closest('.input-group').find('.input-group-text i').attr('class', 'bi ' + (iconClass || 'bi-globe'));
        });
    });
</script>
@endpush
