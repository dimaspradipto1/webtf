@extends('layouts.frontend.template')

@section('title', 'Struktur Organisasi — Teknik Informatika (UIS)')
@section('meta_description', 'Susunan pimpinan pimpinan, ketua program studi, dan tata kelola organisasi Teknik Informatika (UIS).')
@section('meta_keywords', 'struktur organisasi uis, pimpinan uis, ketua program studi, manajemen uis')

@section('content')

@php
  $hStruktur = \App\Models\PageHeader::get('struktur-organisasi');
@endphp
<!-- ═══════════════════════════════════════════════
     HERO HEADER & BREADCRUMB
═══════════════════════════════════════════════ -->
<section class="akademik-hero">
  <div class="container position-relative" data-aos="fade-up">
    <div class="badge px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange, #f9dc4b); color: #000000; font-weight: 800; font-size: 11.5px; letter-spacing: 0.8px;">
      {{ $hStruktur->badge_text ?: 'PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI' }}
    </div>
    <h1 class="display-6 fw-bold text-white mb-2">{{ $hStruktur->judul }}</h1>
    @if(!empty($hStruktur->subjudul))
      <p class="lead text-white-50 mb-0" style="max-width: 760px; font-size: 16px;">
        {{ $hStruktur->subjudul }}
      </p>
    @endif
    <div class="breadcrumb-custom mt-3">
      <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
      <span>/</span>
      <a href="{{ route('homepage.tentang') }}">Profil</a>
      <span>/</span>
      <span class="active">{{ $hStruktur->breadcrumb_label ?: 'Struktur Organisasi' }}</span>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     STRUKTUR ORGANISASI SECTION
═══════════════════════════════════════════════ -->
<section class="section-bg-sand">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Tata Kelola Program Studi · Fakultas Sains dan Teknologi</div>
      <h2 class="section-title">Bagan <em>Kepemimpinan & Organisasi</em> Teknik Informatika</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Tata kelola yang profesional, transparan, dan akuntabel di bawah pimpinan Fakultas Sains dan Teknologi serta Ketua Program Studi Teknik Informatika.
      </p>
    </div>

    <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-12">
        <div class="struktur-card text-center p-3 p-md-4" style="overflow: visible !important;">
          @if(isset($struktur) && $struktur->url_struktur)
            @php
              $strukturPath = public_path($struktur->url_struktur);
              $strukturVer = file_exists($strukturPath) ? filemtime($strukturPath) : time();
            @endphp
            <div class="mb-3 d-flex justify-content-center align-items-center gap-2 text-muted small">
              <i class="bi bi-zoom-in text-dark"></i>
              <span>Arahkan kursor (hover) pada setiap kartu jabatan di dalam bagan untuk memperbesar (zoom-in 4K HD) kartu tersebut.</span>
            </div>

            <div class="struktur-interactive-stage position-relative mx-auto" id="strukturInteractiveStage" style="max-width: 1240px; width: 100%; overflow: visible;">
              <img
                id="strukturOrgImg"
                src="{{ asset($struktur->url_struktur) . '?v=' . $strukturVer }}"
                alt="Struktur Organisasi Teknik Informatika"
                class="img-fluid rounded-3 d-block w-100"
                crossorigin="anonymous"
              >
              <div id="strukturHotspotsLayer" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
              <canvas id="strukturZoomCanvas" class="struktur-zoom-popup"></canvas>
            </div>
          @else
            <div class="py-5">
              <i class="bi bi-diagram-3 fs-1 text-muted d-block mb-3"></i>
              <h5 class="fw-bold">Bagan Struktur Organisasi</h5>
              <p class="text-muted small">Bagan susunan organisasi dapat diperbarui melalui panel administrator.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .struktur-card-hotspot {
    position: absolute;
    pointer-events: auto;
    cursor: zoom-in;
    border-radius: 6px;
    z-index: 10;
  }

  .struktur-zoom-popup {
    position: absolute;
    pointer-events: none;
    z-index: 120;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 24px 55px rgba(0, 0, 0, 0.38), 0 0 0 4px #f9dc4b;
    opacity: 0;
    transform: scale(0.45);
    transition: opacity 0.16s ease, transform 0.22s cubic-bezier(0.2, 0.85, 0.3, 1.08);
    will-change: transform, opacity;
  }

  .struktur-zoom-popup.is-visible {
    opacity: 1;
    transform: scale(1);
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const stage = document.getElementById('strukturInteractiveStage');
  const img = document.getElementById('strukturOrgImg');
  const layer = document.getElementById('strukturHotspotsLayer');
  const zoomCanvas = document.getElementById('strukturZoomCanvas');
  if (!stage || !img || !layer || !zoomCanvas) return;

  function detectCardRectangles(imageEl) {
    const w = imageEl.naturalWidth;
    const h = imageEl.naturalHeight;
    if (!w || !h) return [];

    // Use a fast analysis resolution (~1536px wide) so detection is instant even on 4K images
    const analysisW = Math.min(w, 1536);
    const scale = w / analysisW;
    const analysisH = Math.round(h / scale);

    const canvas = document.createElement('canvas');
    canvas.width = analysisW;
    canvas.height = analysisH;
    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    ctx.drawImage(imageEl, 0, 0, analysisW, analysisH);

    let imgData;
    try {
      imgData = ctx.getImageData(0, 0, analysisW, analysisH).data;
    } catch (e) {
      return [];
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

          let leftDark = 0;
          let rightDark = 0;
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
        if (ix2 > ix1 && iy2 > iy1) {
          const interArea = (ix2 - ix1) * (iy2 - iy1);
          if (interArea > 0.25 * (c.w * c.h)) {
            overlaps = true;
            break;
          }
        }
      }
      if (!overlaps) {
        finalCards.push(c);
      }
    }

    return finalCards;
  }

  function showCardZoom(cx, cy, cw, ch) {
    const w = img.naturalWidth;
    const h = img.naturalHeight;
    const stageRect = stage.getBoundingClientRect();
    const zoomFactor = window.innerWidth <= 768 ? 1.9 : 2.45;

    const cardDisplayW = (cw / w) * stageRect.width;
    const cardDisplayH = (ch / h) * stageRect.height;
    const targetDisplayW = Math.round(cardDisplayW * zoomFactor);
    const targetDisplayH = Math.round(cardDisplayH * zoomFactor);

    // Render at native 4K source resolution (or Retina DPR, whichever is higher) so there is zero blur!
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
    zCtx.drawImage(img, cx, cy, cw, ch, 0, 0, zoomCanvas.width, zoomCanvas.height);

    // Calculate centered position clamped within stage bounds
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

  function hideCardZoom() {
    zoomCanvas.classList.remove('is-visible');
  }

  function buildHotspots() {
    const w = img.naturalWidth;
    const h = img.naturalHeight;
    if (!w || !h) return;

    layer.innerHTML = '';
    const cards = detectCardRectangles(img);
    const pad = Math.round(w * 0.003);

    cards.forEach(function (card) {
      const cx = Math.max(0, card.x - pad);
      const cy = Math.max(0, card.y - pad);
      const cw = Math.min(w - cx, card.w + pad * 2);
      const ch = Math.min(h - cy, card.h + pad * 2);

      const el = document.createElement('div');
      el.className = 'struktur-card-hotspot';
      el.style.left = ((cx / w) * 100) + '%';
      el.style.top = ((cy / h) * 100) + '%';
      el.style.width = ((cw / w) * 100) + '%';
      el.style.height = ((ch / h) * 100) + '%';

      el.addEventListener('mouseenter', function () {
        showCardZoom(cx, cy, cw, ch);
      });
      el.addEventListener('mouseleave', hideCardZoom);

      layer.appendChild(el);
    });
  }

  if (img.complete && img.naturalWidth > 0) {
    buildHotspots();
  } else {
    img.addEventListener('load', buildHotspots);
  }
});
</script>

@endsection
