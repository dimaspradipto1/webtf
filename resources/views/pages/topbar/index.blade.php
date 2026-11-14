@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div>
        <h1>Pengaturan Topbar & Marquee</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Pengaturan</li>
                <li class="breadcrumb-item active">Topbar & Marquee</li>
            </ol>
        </nav>
    </div>
    <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
        <i class="bi bi-box-arrow-up-right"></i> Lihat di Website
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali isian Anda:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Live Preview Topbar --}}
<div class="card border-0 shadow-sm mb-3 overflow-hidden" style="border-radius: 12px;">
    <div class="px-3 py-2 d-flex align-items-center justify-content-between" style="background: #000000; color: #ffffff; font-size: 12.5px;">
        <div class="d-flex align-items-center gap-2 overflow-hidden me-3" style="flex: 1;">
            <span class="badge bg-warning text-dark fw-bold flex-shrink-0" style="font-size: 10px;">
                <i class="bi bi-broadcast me-1"></i>PREVIEW TOPBAR
            </span>
            <marquee behavior="scroll" direction="left" scrollamount="5" id="liveMarqueePreview" class="fw-semibold">
                {{ old('marquee_text', $topbar->marquee_text ?? 'Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika (UIS)') }}
            </marquee>
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <i class="bi bi-search text-white" style="font-size: 12px;"></i>
            @php
                $previewSosmed = old('social_media', $topbar->social_media ?? []);
                if (empty($previewSosmed)) {
                    $previewSosmed = [
                        ['platform' => 'Facebook', 'icon' => 'bi-facebook', 'url' => 'https://facebook.com'],
                        ['platform' => 'Instagram', 'icon' => 'bi-instagram', 'url' => 'https://instagram.com'],
                        ['platform' => 'YouTube', 'icon' => 'bi-youtube', 'url' => 'https://youtube.com'],
                    ];
                }
            @endphp
            @foreach($previewSosmed as $ps)
                @if(!empty($ps['url']))
                    <span class="badge rounded-circle bg-white text-dark d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px;" title="{{ $ps['platform'] ?? '' }}">
                        <i class="bi {{ !empty($ps['icon']) ? $ps['icon'] : 'bi-globe' }}"></i>
                    </span>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between border-bottom">
        <div>
            <h5 class="mb-0 fw-bold text-dark">
                <i class="bi bi-window-dock me-2 text-primary"></i>Form Pengaturan Topbar Header & Marquee
            </h5>
            <small class="text-muted">Ubah teks berjalan (marquee), badge, informasi singkat, dan tautan media sosial yang tampil di bilah paling atas website.</small>
        </div>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('topbar.update') }}" method="POST">
            @csrf

            <div class="row g-3">
                {{-- Section 1: Marquee & Badge Topbar --}}
                <div class="col-12">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-2">
                        <i class="bi bi-broadcast me-1 text-danger"></i>1. Teks Berjalan (Marquee) & Badge Topbar
                    </h6>
                </div>

                <div class="col-12">
                    <label for="marquee_text" class="form-label fw-semibold text-dark">Teks Marquee (Berjalan) <span class="text-danger">*</span></label>
                    <textarea name="marquee_text" id="marquee_text" rows="2" class="form-control @error('marquee_text') is-invalid @enderror" placeholder="Contoh: Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika" required oninput="document.getElementById('liveMarqueePreview').textContent = this.value">{{ old('marquee_text', $topbar->marquee_text ?? 'Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika (UIS)') }}</textarea>
                    <small class="text-muted">Teks pengumuman berjalan / running text yang tampil di bilah topbar paling atas website.</small>
                    @error('marquee_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="badge_text" class="form-label fw-semibold text-dark">Teks Badge <span class="text-danger">*</span></label>
                    <input type="text" name="badge_text" id="badge_text" class="form-control @error('badge_text') is-invalid @enderror" value="{{ old('badge_text', $topbar->badge_text ?? 'TEKNIK INFORMATIKA') }}" required>
                    @error('badge_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="badge_icon" class="form-label fw-semibold text-dark">Ikon Bootstrap Badge</label>
                    <input type="text" name="badge_icon" id="badge_icon" class="form-control @error('badge_icon') is-invalid @enderror" value="{{ old('badge_icon', $topbar->badge_icon ?? 'bi-laptop') }}">
                    <small class="text-muted">Nama class Bootstrap Icons (misal: <code>bi-laptop</code>, <code>bi-shield-check</code>)</small>
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
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $topbar->alamat) }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label for="jam_operasional" class="form-label fw-semibold text-dark">Jam Operasional</label>
                    <input type="text" name="jam_operasional" id="jam_operasional" class="form-control @error('jam_operasional') is-invalid @enderror" value="{{ old('jam_operasional', $topbar->jam_operasional) }}">
                    @error('jam_operasional')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="telepon" class="form-label fw-semibold text-dark">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $topbar->telepon) }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold text-dark">Email Resmi</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $topbar->email) }}">
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
                            $existingSosmed = old('social_media', $topbar->social_media ?? []);
                            if (empty($existingSosmed)) {
                                $existingSosmed = [
                                    ['platform' => 'Facebook', 'icon' => 'bi-facebook', 'url' => 'https://facebook.com'],
                                    ['platform' => 'Instagram', 'icon' => 'bi-instagram', 'url' => 'https://instagram.com'],
                                    ['platform' => 'YouTube', 'icon' => 'bi-youtube', 'url' => 'https://youtube.com'],
                                ];
                            }
                        @endphp

                        @foreach($existingSosmed as $index => $item)
                            <div class="sosmed-row p-2 bg-light rounded-3 border d-flex flex-wrap align-items-center gap-2">
                                <div style="min-width: 150px; flex: 1;">
                                    <input type="text" name="social_media[{{ $index }}][platform]" class="form-control form-control-sm platform-input" placeholder="Platform (e.g. Instagram)" value="{{ $item['platform'] ?? '' }}">
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
                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $topbar->is_active ?? true) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                            Tampilkan Topbar aktif di frontend website
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                    <i class="bi bi-save me-1"></i> Simpan Pengaturan Topbar
                </button>
                <a href="{{ route('theme.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-palette me-1"></i> Atur Warna Topbar & Header
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let sosmedIndex = {{ count($existingSosmed) }};

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
