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

@include('layouts.dashboard.partials.header-setting-card', [
    'pageKey' => 'struktur-organisasi',
    'pageTitle' => 'Struktur Organisasi',
    'defaultJudul' => 'Struktur Organisasi Program Studi',
    'defaultSubjudul' => 'Bagan tata kelola dan susunan pejabat struktural Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.'
])

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
                    @php
                        $strukturPath = public_path($struktur->url_struktur);
                        $strukturVer = file_exists($strukturPath) ? filemtime($strukturPath) : time();
                    @endphp
                    <div class="bg-light p-3 rounded border text-center d-inline-block w-100 position-relative" id="strukturPreviewBox" style="overflow: visible !important;">
                        <div class="position-relative d-inline-block w-100" id="adminStrukturStage" style="overflow: visible !important;">
                            <img id="strukturPreviewImg" src="{{ asset($struktur->url_struktur) . '?v=' . $strukturVer }}" alt="Struktur Organisasi" class="img-fluid rounded border shadow-sm w-100" crossorigin="anonymous">
                            <div id="adminStrukturHotspots" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
                            <canvas id="adminStrukturZoomCanvas" class="admin-struktur-zoom-popup"></canvas>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small" id="strukturPreviewPath">
                        <i class="bi bi-zoom-in me-1"></i>Arahkan kursor (hover) pada kartu di dalam bagan untuk zoom-in 4K HD · Path: <code>{{ $struktur->url_struktur }}</code>
                    </div>
                @else
                    <div class="bg-light p-3 rounded border text-center d-none w-100 position-relative" id="strukturPreviewBox" style="overflow: visible !important;">
                        <div class="position-relative d-inline-block w-100" id="adminStrukturStage" style="overflow: visible !important;">
                            <img id="strukturPreviewImg" src="" alt="Struktur Organisasi" class="img-fluid rounded border shadow-sm w-100" crossorigin="anonymous">
                            <div id="adminStrukturHotspots" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
                            <canvas id="adminStrukturZoomCanvas" class="admin-struktur-zoom-popup"></canvas>
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
    z-index: 10;
  }
  .admin-struktur-zoom-popup {
    position: absolute;
    pointer-events: none;
    z-index: 120;
    background-color: #ffffff;
    border-radius: 9px;
    box-shadow: 0 22px 50px rgba(0, 0, 0, 0.38), 0 0 0 3.5px #f9dc4b;
    opacity: 0;
    transform: scale(0.45);
    transition: opacity 0.16s ease, transform 0.22s cubic-bezier(0.2, 0.85, 0.3, 1.08);
    will-change: transform, opacity;
  }
  .admin-struktur-zoom-popup.is-visible {
    opacity: 1;
    transform: scale(1);
  }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('url_struktur');
    const previewBox = document.getElementById('strukturPreviewBox');
    const stage = document.getElementById('adminStrukturStage');
    const previewImg = document.getElementById('strukturPreviewImg');
    const previewPath = document.getElementById('strukturPreviewPath');
    const emptyState = document.getElementById('strukturEmptyState');
    const hotspotsLayer = document.getElementById('adminStrukturHotspots');
    const zoomCanvas = document.getElementById('adminStrukturZoomCanvas');

    function showAdminZoom(cx, cy, cw, ch) {
        if (!stage || !previewImg || !zoomCanvas) return;
        const w = previewImg.naturalWidth;
        const h = previewImg.naturalHeight;
        const stageRect = stage.getBoundingClientRect();
        const zoomFactor = 2.6;

        const cardDisplayW = (cw / w) * stageRect.width;
        const cardDisplayH = (ch / h) * stageRect.height;
        const targetDisplayW = Math.round(cardDisplayW * zoomFactor);
        const targetDisplayH = Math.round(cardDisplayH * zoomFactor);

        const dpr = Math.max(window.devicePixelRatio || 1, 2);
        zoomCanvas.width = Math.max(cw, Math.round(targetDisplayW * dpr));
        zoomCanvas.height = Math.max(ch, Math.round(targetDisplayH * dpr));
        zoomCanvas.style.width = targetDisplayW + 'px';
        zoomCanvas.style.height = targetDisplayH + 'px';

        const zCtx = zoomCanvas.getContext('2d');
        zCtx.imageSmoothingEnabled = true;
        zCtx.imageSmoothingQuality = 'high';
        zCtx.fillStyle = '#ffffff';
        zCtx.fillRect(0, 0, zoomCanvas.width, zoomCanvas.height);
        zCtx.drawImage(previewImg, cx, cy, cw, ch, 0, 0, zoomCanvas.width, zoomCanvas.height);

        const cardCenterX = ((cx + cw / 2) / w) * stageRect.width;
        const cardCenterY = ((cy + ch / 2) / h) * stageRect.height;

        let leftPx = Math.round(cardCenterX - targetDisplayW / 2);
        let topPx = Math.round(cardCenterY - targetDisplayH / 2);

        leftPx = Math.max(0, Math.min(stageRect.width - targetDisplayW, leftPx));
        topPx = Math.max(-10, Math.min(stageRect.height - targetDisplayH + 10, topPx));

        zoomCanvas.style.left = leftPx + 'px';
        zoomCanvas.style.top = topPx + 'px';
        zoomCanvas.classList.add('is-visible');
    }

    function hideAdminZoom() {
        if (zoomCanvas) zoomCanvas.classList.remove('is-visible');
    }

    function buildAdminHotspots() {
        if (!previewImg || !hotspotsLayer) return;
        const w = previewImg.naturalWidth;
        const h = previewImg.naturalHeight;
        if (!w || !h) return;

        hotspotsLayer.innerHTML = '';
        const analysisW = Math.min(w, 1536);
        const scale = w / analysisW;
        const analysisH = Math.round(h / scale);

        const canvas = document.createElement('canvas');
        canvas.width = analysisW;
        canvas.height = analysisH;
        const ctx = canvas.getContext('2d', { willReadFrequently: true });
        ctx.drawImage(previewImg, 0, 0, analysisW, analysisH);

        let imgData;
        try {
            imgData = ctx.getImageData(0, 0, analysisW, analysisH).data;
        } catch (e) {
            return;
        }

        function isDark(x, y) {
            if (x < 0 || x >= analysisW || y < 0 || y >= analysisH) return false;
            const idx = (y * analysisW + x) * 4;
            if (imgData[idx + 3] < 128) return false;
            return imgData[idx] < 95 && imgData[idx + 1] < 95 && imgData[idx + 2] < 95;
        }

        const minCardW = Math.round(analysisW * 0.042);
        const maxCardW = Math.round(analysisW * 0.32);
        const minCardH = Math.round(analysisH * 0.03);
        const maxCardH = Math.round(analysisH * 0.11);

        const horizSegments = [];
        for (let y = 4; y < analysisH - 4; y++) {
            let runStart = -1;
            for (let x = 4; x < analysisW - 4; x++) {
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
                        candidates.push({
                            x: Math.round(x1 * scale),
                            y: Math.round(y1 * scale),
                            w: Math.round((x2 - x1) * scale),
                            h: Math.round((y2 - y1) * scale)
                        });
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

        const pad = Math.round(w * 0.003);
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

            el.addEventListener('mouseenter', function () {
                showAdminZoom(cx, cy, cw, ch);
            });
            el.addEventListener('mouseleave', hideAdminZoom);

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
