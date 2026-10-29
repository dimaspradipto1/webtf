@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Struktur Organisasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Struktur Organisasi</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-diagram-3 me-2"></i>Unggah Struktur Organisasi (PNG)
                </h5>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('struktur-organisasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="url_struktur" class="form-label fw-bold">Pilih Gambar Struktur Organisasi</label>
                        <input class="form-control @error('url_struktur') is-invalid @enderror" type="file" id="url_struktur" name="url_struktur" accept="image/png,image/jpeg,image/jpg,image/webp">
                        <div class="form-text text-muted">Format yang didukung: <strong>PNG, JPG, WEBP</strong>. Ukuran maksimal: <strong>5 MB</strong>.</div>
                        @error('url_struktur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i> Simpan Gambar
                        </button>

                        @if(isset($struktur) && $struktur->url_struktur)
                            <button type="button" class="btn btn-danger" onclick="Swal.fire({title: 'Hapus Struktur Organisasi?', text: 'Gambar struktur organisasi akan dihapus permanen!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: '<i class=\'bi bi-trash me-1\'></i> Ya, Hapus', cancelButtonText: 'Batal', reverseButtons: true, customClass: { popup: 'rounded-4 shadow-lg border-0', confirmButton: 'px-4 py-2 rounded-3 fw-semibold', cancelButton: 'px-4 py-2 rounded-3 fw-semibold' }}).then((result) => { if(result.isConfirmed) { document.getElementById('delete-form').submit(); } })">
                                <i class="bi bi-trash me-1"></i> Hapus Gambar
                            </button>
                        @endif
                    </div>
                </form>

                @if(isset($struktur) && $struktur->url_struktur)
                    <form id="delete-form" action="{{ route('struktur-organisasi.destroy', $struktur->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-eye me-2"></i>Pratinjau Struktur Organisasi
                </h5>
            </div>
            <div class="card-body pt-4 text-center" id="strukturPreviewContainer" style="overflow: visible !important;">
                @if(isset($struktur) && $struktur->url_struktur)
                    <div class="bg-light p-3 rounded border text-center d-inline-block w-100 position-relative" id="strukturPreviewBox" style="overflow: visible !important;">
                        <div class="position-relative d-inline-block w-100" style="overflow: visible !important;">
                            <img id="strukturPreviewImg" src="{{ asset($struktur->url_struktur) }}" alt="Struktur Organisasi" class="img-fluid rounded border shadow-sm w-100" crossorigin="anonymous">
                            <div id="adminStrukturHotspots" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small" id="strukturPreviewPath">
                        <i class="bi bi-zoom-in me-1"></i>Arahkan kursor (hover) pada kartu di dalam bagan untuk zoom-in kartu · Path: <code>{{ $struktur->url_struktur }}</code>
                    </div>
                @else
                    <div class="bg-light p-3 rounded border text-center d-none w-100 position-relative" id="strukturPreviewBox" style="overflow: visible !important;">
                        <div class="position-relative d-inline-block w-100" style="overflow: visible !important;">
                            <img id="strukturPreviewImg" src="" alt="Struktur Organisasi" class="img-fluid rounded border shadow-sm w-100" crossorigin="anonymous">
                            <div id="adminStrukturHotspots" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small d-none" id="strukturPreviewPath"></div>
                    <div class="py-5 text-center text-muted" id="strukturEmptyState">
                        <i class="bi bi-image fs-1 d-block mb-3 text-secondary"></i>
                        <span>Belum ada gambar struktur organisasi yang diunggah. Tampilan di halaman utama/Tentang Kami akan tetap kosong.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
  .admin-struktur-hotspot {
    position: absolute;
    pointer-events: auto;
    cursor: zoom-in;
    border-radius: 5px;
    background-repeat: no-repeat;
    background-color: #ffffff;
    opacity: 0;
    transform: scale(1);
    transition: transform 0.22s cubic-bezier(0.2, 0.85, 0.3, 1.1),
                opacity 0.15s ease,
                box-shadow 0.22s ease;
    z-index: 5;
  }
  .admin-struktur-hotspot:hover {
    opacity: 1;
    transform: scale(2.4);
    z-index: 100;
    box-shadow: 0 18px 40px rgba(0, 0, 0, 0.32), 0 0 0 2.5px #f9dc4b;
  }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('url_struktur');
    const previewBox = document.getElementById('strukturPreviewBox');
    const previewImg = document.getElementById('strukturPreviewImg');
    const previewPath = document.getElementById('strukturPreviewPath');
    const emptyState = document.getElementById('strukturEmptyState');
    const hotspotsLayer = document.getElementById('adminStrukturHotspots');

    function buildAdminHotspots() {
        if (!previewImg || !hotspotsLayer) return;
        const w = previewImg.naturalWidth;
        const h = previewImg.naturalHeight;
        if (!w || !h) return;

        hotspotsLayer.innerHTML = '';
        const canvas = document.createElement('canvas');
        canvas.width = w;
        canvas.height = h;
        const ctx = canvas.getContext('2d', { willReadFrequently: true });
        ctx.drawImage(previewImg, 0, 0, w, h);

        let imgData;
        try {
            imgData = ctx.getImageData(0, 0, w, h).data;
        } catch (e) {
            return;
        }

        function isDark(x, y) {
            if (x < 0 || x >= w || y < 0 || y >= h) return false;
            const idx = (y * w + x) * 4;
            if (imgData[idx + 3] < 128) return false;
            return imgData[idx] < 95 && imgData[idx + 1] < 95 && imgData[idx + 2] < 95;
        }

        const minCardW = Math.round(w * 0.042);
        const maxCardW = Math.round(w * 0.32);
        const minCardH = Math.round(h * 0.03);
        const maxCardH = Math.round(h * 0.11);

        const horizSegments = [];
        for (let y = 4; y < h - 4; y++) {
            let runStart = -1;
            for (let x = 4; x < w - 4; x++) {
                if (isDark(x, y)) {
                    if (runStart === -1) runStart = x;
                } else if (runStart !== -1) {
                    const len = x - runStart;
                    if (len >= minCardW && len <= maxCardW) {
                        horizSegments.push({ y: y, x1: runStart, x2: x - 1, w: len });
                    }
                    runStart = -1;
                }
            }
        }

        const candidates = [];
        const n = horizSegments.length;
        for (let i = 0; i < n; i++) {
            const top = horizSegments[i];
            if (isDark(top.x1, top.y - 4) && isDark(top.x2, top.y - 4)) continue;
            for (let j = i + 1; j < n; j++) {
                const bot = horizSegments[j];
                const dy = bot.y - top.y;
                if (dy < minCardH) continue;
                if (dy > maxCardH) break;
                if (Math.abs(top.x1 - bot.x1) <= 4 && Math.abs(top.x2 - bot.x2) <= 4) {
                    if (isDark(bot.x1, bot.y + 4) && isDark(bot.x2, bot.y + 4)) continue;
                    const x1 = Math.min(top.x1, bot.x1);
                    const x2 = Math.max(top.x2, bot.x2);
                    const y1 = top.y;
                    const y2 = bot.y;
                    let leftDark = 0, rightDark = 0;
                    for (let yy = y1; yy <= y2; yy++) {
                        if (isDark(x1, yy) || isDark(x1 + 1, yy) || isDark(x1 + 2, yy)) leftDark++;
                        if (isDark(x2, yy) || isDark(x2 - 1, yy) || isDark(x2 - 2, yy)) rightDark++;
                    }
                    if (leftDark >= dy * 0.85 && rightDark >= dy * 0.85) {
                        candidates.push({ x: x1, y: y1, w: x2 - x1, h: y2 - y1 });
                    }
                }
            }
        }

        candidates.sort((a, b) => (b.w * b.h) - (a.w * a.h));
        const finalCards = [];
        for (const c of candidates) {
            let overlaps = false;
            for (const f of finalCards) {
                const ix1 = Math.max(c.x, f.x);
                const iy1 = Math.max(c.y, f.y);
                const ix2 = Math.min(c.x + c.w, f.x + f.w);
                const iy2 = Math.min(c.y + c.h, f.y + f.h);
                if (ix2 > ix1 && iy2 > iy1 && (ix2 - ix1) * (iy2 - iy1) > 0.25 * (c.w * c.h)) {
                    overlaps = true;
                    break;
                }
            }
            if (!overlaps) finalCards.push(c);
        }

        const pad = 4;
        finalCards.forEach(function (card) {
            const cx = Math.max(0, card.x - pad);
            const cy = Math.max(0, card.y - pad);
            const cw = Math.min(w - cx, card.w + pad * 2);
            const ch = Math.min(h - cy, card.h + pad * 2);

            const el = document.createElement('div');
            el.className = 'admin-struktur-hotspot';
            el.style.left = ((cx / w) * 100) + '%';
            el.style.top = ((cy / h) * 100) + '%';
            el.style.width = ((cw / w) * 100) + '%';
            el.style.height = ((ch / h) * 100) + '%';
            el.style.backgroundImage = 'url("' + previewImg.src + '")';
            el.style.backgroundSize = ((w / cw) * 100) + '% ' + ((h / ch) * 100) + '%';
            el.style.backgroundPosition = ((w - cw) > 0 ? (cx / (w - cw)) * 100 : 0) + '% ' + ((h - ch) > 0 ? (cy / (h - ch)) * 100 : 0) + '%';

            let originX = 'center';
            if (cx / w < 0.14) originX = 'left';
            else if ((cx + cw) / w > 0.86) originX = 'right';
            let originY = 'center';
            if (cy / h < 0.12) originY = 'top';
            else if ((cy + ch) / h > 0.88) originY = 'bottom';
            el.style.transformOrigin = originX + ' ' + originY;

            hotspotsLayer.appendChild(el);
        });
    }

    if (previewImg) {
        if (previewImg.complete && previewImg.naturalWidth > 0) {
            buildAdminHotspots();
        }
        previewImg.addEventListener('load', buildAdminHotspots);
    }

    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (ev) {
                if (previewImg) previewImg.src = ev.target.result;
                if (previewBox) {
                    previewBox.classList.remove('d-none');
                    previewBox.classList.add('d-inline-block');
                }
                if (previewPath) {
                    previewPath.classList.remove('d-none');
                    previewPath.innerHTML = 'Pratinjau file terpilih: <code>' + file.name + '</code> (Klik <strong>Simpan Gambar</strong> untuk menyimpan)';
                }
                if (emptyState) emptyState.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
