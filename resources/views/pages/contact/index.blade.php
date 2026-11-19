@extends('layouts.dashboard.template')

@section('content')
<style>
    .inbox-table { font-size: 11px !important; }
    .inbox-table th, .inbox-table td { font-size: 11px !important; padding: 8px 10px !important; vertical-align: middle; }
    .inbox-table .badge { font-size: 11px !important; }
    .inbox-action-wrap { display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
    .inbox-action-btn { width: 28px !important; height: 28px !important; padding: 0 !important; border-radius: 7px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-size: 12px !important; }
</style>
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

{{-- PESAN MASUK PENGUNJUNG (A9) --}}
<div id="pesan-masuk" class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-inbox-fill text-primary"></i> Pesan Masuk Pengunjung
                @if(($unreadCount ?? 0) > 0)
                    <span class="badge bg-danger rounded-pill" style="font-size: 11px;">{{ $unreadCount }} Baru</span>
                @endif
            </h5>
            <p class="text-muted small mb-0">Daftar pesan dari formulir halaman Kontak publik. Pesan juga otomatis diteruskan ke email resmi prodi bila SMTP aktif.</p>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle inbox-table mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 38px;" class="text-center">No</th>
                        <th style="width: 115px;">Tanggal</th>
                        <th style="width: 190px;">Pengirim</th>
                        <th style="width: 95px;">Kategori</th>
                        <th>Isi Pesan</th>
                        <th style="width: 90px;" class="text-center">Status</th>
                        <th style="width: 110px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $idx => $msg)
                        <tr class="{{ $msg->status === 'baru' ? 'table-warning bg-opacity-10' : '' }}">
                            <td class="text-center text-muted">{{ method_exists($messages, 'firstItem') ? $messages->firstItem() + $idx : $idx + 1 }}</td>
                            <td class="text-muted text-nowrap">{{ optional($msg->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $msg->nama }}</div>
                                <div class="text-muted">{{ $msg->email }}</div>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $msg->kategori }}</span></td>
                            <td>
                                <div class="text-dark">{{ \Illuminate\Support\Str::limit($msg->pesan, 95) }}</div>
                                @if($msg->email_forwarded)
                                    <span class="text-success" style="font-size: 10.5px;"><i class="bi bi-envelope-check me-1"></i>Terkirim ke email prodi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($msg->status === 'dibalas')
                                    <span class="badge bg-success-subtle text-success">Dibalas</span>
                                @elseif($msg->status === 'dibaca')
                                    <span class="badge bg-info-subtle text-info">Dibaca</span>
                                @else
                                    <span class="badge bg-warning text-dark">Baru</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="inbox-action-wrap">
                                    <button type="button"
                                        class="btn btn-outline-primary inbox-action-btn btn-view-msg"
                                        title="Lihat & Balas"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalViewContactMsg"
                                        data-id="{{ $msg->id }}"
                                        data-nama="{{ $msg->nama }}"
                                        data-email="{{ $msg->email }}"
                                        data-kategori="{{ $msg->kategori }}"
                                        data-pesan="{{ $msg->pesan }}"
                                        data-tanggal="{{ optional($msg->created_at)->format('d M Y, H:i') }} WIB"
                                        data-status="{{ $msg->status }}"
                                        data-status-url="{{ route('contact.messages.status', $msg->id) }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="mailto:{{ $msg->email }}?subject={{ rawurlencode('Re: [' . $msg->kategori . '] Pesan Website TI UIS') }}"
                                       class="btn btn-outline-success inbox-action-btn"
                                       title="Balas via Email">
                                        <i class="bi bi-reply-fill"></i>
                                    </a>
                                    <form action="{{ route('contact.messages.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger inbox-action-btn" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-envelope-open d-block fs-3 mb-1 opacity-50"></i>
                                Belum ada pesan masuk dari pengunjung website.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($messages, 'hasPages') && $messages->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal Detail Pesan Masuk --}}
<div class="modal fade" id="modalViewContactMsg" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h6 class="modal-title fw-bold"><i class="bi bi-envelope-open me-2 text-warning"></i>Detail Pesan Pengunjung</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div id="msgModalNama" class="fw-bold text-dark fs-6"></div>
                        <div id="msgModalEmail" class="text-muted small"></div>
                    </div>
                    <span id="msgModalKategori" class="badge bg-primary-subtle text-primary border border-primary-subtle"></span>
                </div>
                <div class="small text-muted mb-2"><i class="bi bi-clock me-1"></i><span id="msgModalTanggal"></span></div>
                <div id="msgModalPesan" class="p-3 rounded-3 bg-light border text-dark small mb-3" style="white-space: pre-wrap; line-height: 1.65;"></div>

                <form id="msgStatusForm" method="POST" class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex align-items-center gap-2">
                        <label for="msgModalStatusSelect" class="small fw-semibold mb-0">Status:</label>
                        <select name="status" id="msgModalStatusSelect" class="form-select form-select-sm" style="width: 120px;">
                            <option value="baru">Baru</option>
                            <option value="dibaca">Dibaca</option>
                            <option value="dibalas">Dibalas</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-dark text-warning fw-semibold">Simpan Status</button>
                    </div>
                    <a id="msgModalReplyLink" href="#" class="btn btn-sm btn-success fw-semibold">
                        <i class="bi bi-reply-fill me-1"></i> Balas Email
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

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
                        <div id="map-preview-container" class="rounded overflow-hidden shadow-sm border" style="height: 320px;">
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

    function extractCoordsFromMap(raw) {
        if (!raw) return null;
        var m = raw.match(/!2d(-?\d+\.\d+)!3d(-?\d+\.\d+)/);
        if (m) return { lat: m[2], lng: m[1] };
        m = raw.match(/!3d(-?\d+\.\d+)!2d(-?\d+\.\d+)/);
        if (m) return { lat: m[1], lng: m[2] };
        var all = Array.from(raw.matchAll(/!1d(-?\d+\.\d+)!2d(-?\d+\.\d+)/g));
        if (all.length > 0) {
            var last = all[all.length - 1];
            var la = parseFloat(last[1]), ln = parseFloat(last[2]);
            if (la >= -90 && la <= 90 && ln >= -180 && ln <= 180) {
                return { lat: last[1], lng: last[2] };
            }
        }
        m = raw.match(/(?:@|[?&]q=)(-?\d+\.\d+),\s*(-?\d+\.\d+)/);
        if (m) return { lat: m[1], lng: m[2] };
        return null;
    }

    function syncCoordsFromMap(raw) {
        var coords = extractCoordsFromMap(raw);
        if (coords && latInput && lngInput) {
            latInput.value = coords.lat;
            lngInput.value = coords.lng;
        }
    }

    function updatePreview() {
        var url = cleanMapValue(mapInput ? mapInput.value : '');
        if (!url && latInput && lngInput && latInput.value && lngInput.value) {
            url = 'https://maps.google.com/maps?q=' + encodeURIComponent(latInput.value.trim() + ',' + lngInput.value.trim()) + '&hl=id&z=16&output=embed';
        }

        if (url && previewContainer && previewWrapper) {
            previewContainer.innerHTML = '<iframe src="' + url + '" width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
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
                syncCoordsFromMap(cleaned);
                updatePreview();
            }, 50);
        });

        mapInput.addEventListener('change', function () {
            mapInput.value = cleanMapValue(mapInput.value);
            syncCoordsFromMap(mapInput.value);
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

    // Populate modal detail pesan masuk
    document.querySelectorAll('.btn-view-msg').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('msgModalNama').textContent = this.dataset.nama || '';
            document.getElementById('msgModalEmail').textContent = this.dataset.email || '';
            document.getElementById('msgModalKategori').textContent = this.dataset.kategori || '';
            document.getElementById('msgModalTanggal').textContent = this.dataset.tanggal || '';
            document.getElementById('msgModalPesan').textContent = this.dataset.pesan || '';
            document.getElementById('msgModalStatusSelect').value = this.dataset.status || 'baru';
            document.getElementById('msgStatusForm').action = this.dataset.statusUrl || '#';
            const subject = encodeURIComponent('Re: [' + (this.dataset.kategori || 'Kontak') + '] Pesan Website TI UIS');
            document.getElementById('msgModalReplyLink').href = 'mailto:' + (this.dataset.email || '') + '?subject=' + subject;
        });
    });
});
</script>
@endpush
