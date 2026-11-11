@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kontak</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Periksa kembali data Anda:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'kontak',
    'pageTitle' => 'Kontak',
    'defaultJudul' => 'Hubungi Kami',
    'defaultSubjudul' => 'Informasi alamat kampus, kontak resmi, surel, dan saluran konsultasi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.'
])

<div class="card shadow-sm border-0" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-0">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-telephone-fill text-primary"></i> Pengaturan Informasi Kontak & Lokasi
                </h5>
                <p class="text-muted small mb-0">Kelola nomor kontak resmi, email prodi, jam operasional, alamat kampus, serta embed peta Google Maps yang tampil di website</p>
            </div>
            <a href="{{ route('homepage.kontak') }}" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-box-arrow-up-right"></i> Lihat di Web
            </a>
        </div>
    </div>
    <div class="card-body pt-2">
        <form action="{{ route('contact.update') }}" method="POST" id="contact-form">
            @csrf

            <div class="row g-3">
                {{-- Nomor WhatsApp --}}
                <div class="col-md-6">
                    <label for="no_wa" class="form-label fw-semibold text-dark">
                        <i class="bi bi-whatsapp text-success me-1"></i> Nomor WhatsApp
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                        <input type="text"
                               id="no_wa"
                               name="no_wa"
                               class="form-control @error('no_wa') is-invalid @enderror"
                               value="{{ old('no_wa', $contact->no_wa) }}"
                               placeholder="Contoh: 081234567890 atau 6281234567890">
                    </div>
                    <div class="form-text small text-muted">Nomor ini terhubung ke tombol chat WhatsApp dan kontak cepat di seluruh website.</div>
                    @error('no_wa')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold text-dark">
                        <i class="bi bi-envelope-at text-danger me-1"></i> Alamat Email Resmi
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $contact->email) }}"
                               placeholder="Contoh: informatika@uis.ac.id">
                    </div>
                    <div class="form-text small text-muted">Surel resmi untuk komunikasi sivitas akademika & mitra universitas.</div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lengkap --}}
                <div class="col-12">
                    <label for="alamat" class="form-label fw-semibold text-dark">
                        <i class="bi bi-geo-alt text-primary me-1"></i> Alamat Lengkap Kampus
                    </label>
                    <textarea id="alamat"
                              name="alamat"
                              class="form-control @error('alamat') is-invalid @enderror"
                              rows="3"
                              placeholder="Tuliskan nama gedung, fakultas, jalan, kelurahan, kecamatan, dan kode pos...">{{ old('alamat', $contact->alamat) }}</textarea>
                    <div class="form-text small text-muted">Alamat fisik yang ditampilkan pada kartu kontak dan footer website.</div>
                    @error('alamat')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jam Operasional --}}
                <div class="col-12">
                    <label for="jam_operasional" class="form-label fw-semibold text-dark">
                        <i class="bi bi-clock-history text-warning me-1"></i> Jam Operasional
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-clock"></i></span>
                        <input type="text"
                               id="jam_operasional"
                               name="jam_operasional"
                               class="form-control @error('jam_operasional') is-invalid @enderror"
                               value="{{ old('jam_operasional', $contact->jam_operasional) }}"
                               placeholder="Contoh: Senin – Sabtu: 08.00 – 17.00 WIB">
                    </div>
                    <div class="form-text small text-muted">Jadwal operasional layanan kampus yang ditampilkan pada kartu kontak dan footer website.</div>
                    @error('jam_operasional')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Koordinat Latitude & Longitude --}}
                <div class="col-md-6">
                    <label for="latitude" class="form-label fw-semibold text-dark">
                        <i class="bi bi-compass me-1"></i> Koordinat Latitude
                    </label>
                    <input type="text"
                           id="latitude"
                           name="latitude"
                           class="form-control @error('latitude') is-invalid @enderror"
                           value="{{ old('latitude', $contact->latitude) }}"
                           placeholder="Contoh: 1.1444 atau -6.2088">
                    @error('latitude')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="longitude" class="form-label fw-semibold text-dark">
                        <i class="bi bi-compass me-1"></i> Koordinat Longitude
                    </label>
                    <input type="text"
                           id="longitude"
                           name="longitude"
                           class="form-control @error('longitude') is-invalid @enderror"
                           value="{{ old('longitude', $contact->longitude) }}"
                           placeholder="Contoh: 104.0156 atau 106.8456">
                    @error('longitude')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Map Embed (URL / Link Aman) --}}
                <div class="col-12">
                    <label for="map" class="form-label fw-semibold text-dark">
                        <i class="bi bi-map text-warning me-1"></i> Tautan / URL Embed Google Maps
                    </label>
                    <textarea id="map"
                              name="map"
                              class="form-control font-monospace @error('map') is-invalid @enderror"
                              rows="3"
                              placeholder="Contoh: https://www.google.com/maps/embed?pb=... atau tempel kode iframe (otomatis diekstrak aman)">{{ old('map', $contact->map_embed_url ?? $contact->map) }}</textarea>
                    <div class="form-text small text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i>
                        Anda dapat menempelkan URL Google Maps langsung atau kode <code>&lt;iframe&gt;</code>. Sistem otomatis mengekstrak tautan URL amannya agar tidak terblokir firewall hosting / cPanel.
                    </div>
                    @error('map')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    @php
                        $previewIframe = $contact->map_iframe;
                    @endphp
                    <div id="map-preview-wrapper" class="mt-3 p-3 bg-light rounded-3 border {{ empty($previewIframe) ? 'd-none' : '' }}">
                        <label class="form-label fw-semibold text-dark small mb-2 d-flex align-items-center gap-1">
                            <i class="bi bi-eye"></i> Pratinjau Peta Saat Ini:
                        </label>
                        <div id="map-preview-container" class="ratio ratio-21x9 rounded overflow-hidden shadow-sm" style="max-height: 280px;">
                            {!! $previewIframe !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                <button type="submit" id="btn-submit-contact" class="btn btn-primary px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-save"></i> Simpan Perubahan Kontak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapInput = document.getElementById('map');
    const form = document.getElementById('contact-form');
    const previewWrapper = document.getElementById('map-preview-wrapper');
    const previewContainer = document.getElementById('map-preview-container');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    function cleanMapValue(raw) {
        if (!raw) return '';
        var trimmed = raw.trim();
        var match = trimmed.match(/src=["']([^"']+)["']/i);
        if (match && match[1]) {
            return match[1];
        }
        return trimmed.replace(/^[<"']+|[>"']+$/g, '');
    }

    function updatePreview() {
        var url = cleanMapValue(mapInput ? mapInput.value : '');
        if (!url && latInput && lngInput && latInput.value && lngInput.value) {
            url = 'https://maps.google.com/maps?q=' + encodeURIComponent(latInput.value.trim() + ',' + lngInput.value.trim()) + '&hl=id&z=16&output=embed';
        }

        if (url && previewContainer && previewWrapper) {
            previewContainer.innerHTML = '<iframe src="' + url + '" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
            previewWrapper.classList.remove('d-none');
        }
    }

    if (mapInput) {
        mapInput.addEventListener('paste', function () {
            setTimeout(function () {
                var cleaned = cleanMapValue(mapInput.value);
                if (cleaned !== mapInput.value) {
                    mapInput.value = cleaned;
                }
                updatePreview();
            }, 50);
        });

        mapInput.addEventListener('change', function () {
            mapInput.value = cleanMapValue(mapInput.value);
            updatePreview();
        });
    }

    if (latInput && lngInput) {
        latInput.addEventListener('change', updatePreview);
        lngInput.addEventListener('change', updatePreview);
    }

    if (form) {
        form.addEventListener('submit', function () {
            if (mapInput) {
                mapInput.value = cleanMapValue(mapInput.value);
            }
        });
    }
});
</script>
@endpush
