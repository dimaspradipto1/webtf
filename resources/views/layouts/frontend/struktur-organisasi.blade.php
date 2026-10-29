@extends('layouts.frontend.template')

@section('title', 'Struktur Organisasi — Teknik Informatika (UIS)')
@section('meta_description', 'Susunan pimpinan pimpinan, ketua program studi, dan tata kelola organisasi Teknik Informatika (UIS).')
@section('meta_keywords', 'struktur organisasi uis, pimpinan uis, ketua program studi, manajemen uis')

@section('content')

<!-- ═══════════════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════════════ -->
<div class="about-hero">
  <div class="container">
    <div class="about-hero-content" data-aos="fade-up" data-aos-duration="800">
      <h1 class="about-hero-title">
        Struktur <em>Organisasi</em>
      </h1>
      <div class="breadcrumb-custom">
        <a href="{{ route('homepage') }}"><i class="bi bi-house-door-fill me-1"></i>Beranda</a>
        <span>/</span>
        <a href="{{ route('homepage.tentang') }}">Profil</a>
        <span>/</span>
        <span class="active">Struktur Organisasi</span>
      </div>
    </div>
  </div>
</div>

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
            <div class="mb-3 d-flex justify-content-center align-items-center gap-2 text-muted small">
              <i class="bi bi-zoom-in text-dark"></i>
              <span>Arahkan kursor (hover) pada setiap kartu jabatan di dalam bagan untuk memperbesar (zoom-in) kartu tersebut.</span>
            </div>

            <div class="struktur-interactive-stage position-relative mx-auto" id="strukturInteractiveStage" style="max-width: 1240px; width: 100%; overflow: visible;">
              <img
                id="strukturOrgImg"
                src="{{ asset($struktur->url_struktur) }}"
                alt="Struktur Organisasi Teknik Informatika"
                class="img-fluid rounded-3 d-block w-100"
                crossorigin="anonymous"
              >
              <div id="strukturHotspotsLayer" class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none;"></div>
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
    background-repeat: no-repeat;
    background-color: #ffffff;
    opacity: 0;
    transform: scale(1);
    transition: transform 0.24s cubic-bezier(0.2, 0.85, 0.3, 1.1),
                opacity 0.16s ease,
                box-shadow 0.24s ease;
    will-change: transform, opacity;
    z-index: 5;
  }

  .struktur-card-hotspot:hover {
    opacity: 1;
    transform: scale(2.35);
    z-index: 100;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.32), 0 0 0 3px #f9dc4b;
    border-radius: 8px;
  }

  @media (max-width: 768px) {
    .struktur-card-hotspot:hover {
      transform: scale(1.85);
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const img = document.getElementById('strukturOrgImg');
  const layer = document.getElementById('strukturHotspotsLayer');
  if (!img || !layer) return;

  function detectCardRectangles(imageEl) {
    const w = imageEl.naturalWidth;
    const h = imageEl.naturalHeight;
    if (!w || !h) return [];

    const canvas = document.createElement('canvas');
    canvas.width = w;
    canvas.height = h;
    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    ctx.drawImage(imageEl, 0, 0, w, h);

    let imgData;
    try {
      imgData = ctx.getImageData(0, 0, w, h).data;
    } catch (e) {
      return [];
    }

    function isDark(x, y) {
      if (x < 0 || x >= w || y < 0 || y >= h) return false;
      const idx = (y * w + x) * 4;
      const a = imgData[idx + 3];
      if (a < 128) return false;
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

          let leftDark = 0;
          let rightDark = 0;
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

  function buildHotspots() {
    const w = img.naturalWidth;
    const h = img.naturalHeight;
    if (!w || !h) return;

    layer.innerHTML = '';
    const cards = detectCardRectangles(img);
    const pad = 4;

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

      el.style.backgroundImage = 'url("' + img.src + '")';
      el.style.backgroundSize = ((w / cw) * 100) + '% ' + ((h / ch) * 100) + '%';
      const posX = (w - cw) > 0 ? (cx / (w - cw)) * 100 : 0;
      const posY = (h - ch) > 0 ? (cy / (h - ch)) * 100 : 0;
      el.style.backgroundPosition = posX + '% ' + posY + '%';

      // Smart transform-origin so edge cards don't overflow viewport
      let originX = 'center';
      if (cx / w < 0.14) originX = 'left';
      else if ((cx + cw) / w > 0.86) originX = 'right';

      let originY = 'center';
      if (cy / h < 0.12) originY = 'top';
      else if ((cy + ch) / h > 0.88) originY = 'bottom';

      el.style.transformOrigin = originX + ' ' + originY;

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
