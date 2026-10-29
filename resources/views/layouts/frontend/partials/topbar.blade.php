@php
  $topbar = $topbarSetting ?? \App\Models\Topbar::where('is_active', true)->latest('id')->first();
  $marqueeText = $topbar?->marquee_text ?: 'Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika (UIS)';
  $topbarBadge = $topbar?->badge_text ?: 'TEKNIK INFORMATIKA';
  $topbarIcon = $topbar?->badge_icon ?: 'bi-laptop';

  $sosmedList = [];
  if ($topbar && is_array($topbar->social_media) && count($topbar->social_media) > 0) {
      foreach ($topbar->social_media as $item) {
          if (!empty($item['url'])) {
              $sosmedList[] = [
                  'platform' => $item['platform'] ?? 'Media Sosial',
                  'icon' => !empty($item['icon']) ? $item['icon'] : 'bi-globe',
                  'url' => $item['url']
              ];
          }
      }
  }

  if (empty($sosmedList)) {
      $sosmedList = [
          ['platform' => 'Facebook', 'icon' => 'bi-facebook', 'url' => $topbar?->facebook_url ?: 'https://facebook.com'],
          ['platform' => 'Instagram', 'icon' => 'bi-instagram', 'url' => $topbar?->instagram_url ?: 'https://instagram.com'],
          ['platform' => 'YouTube', 'icon' => 'bi-youtube', 'url' => $topbar?->youtube_url ?: 'https://youtube.com'],
      ];
  }
@endphp

<!-- ═══════════════════════════════════════════════
     TOPBAR HEADER — RUNNING TEXT & SOSMED
═══════════════════════════════════════════════ -->
<div class="topbar-main">
  <div class="container-fluid px-lg-4 px-xl-5">
    <div class="d-flex align-items-center justify-content-between gap-3">
      
      <!-- Sisi Kiri / Tengah: Marquee Running Text -->
      <div class="topbar-marquee-wrapper d-flex align-items-center flex-grow-1 overflow-hidden">
        @if(!empty($topbarBadge))
          <span class="topbar-badge d-none d-sm-inline-flex align-items-center gap-1 text-nowrap me-2 flex-shrink-0">
            <i class="bi {{ $topbarIcon }}"></i>
            <span>{{ $topbarBadge }}</span>
          </span>
        @endif

        <div class="topbar-marquee-container flex-grow-1 overflow-hidden">
          <marquee behavior="scroll" direction="left" scrollamount="5" class="topbar-marquee-text" onmouseover="this.stop();" onmouseout="this.start();">
            {{ $marqueeText }}
          </marquee>
        </div>
      </div>

      <!-- Sisi Kanan: Search Icon & Social Media Buttons -->
      <div class="topbar-actions d-flex align-items-center gap-2 flex-shrink-0">
        <!-- Search Button (Memicu Modal Pencarian Cepat) -->
        <a href="javascript:void(0)" 
           class="topbar-search-btn" 
           data-bs-toggle="modal" 
           data-bs-target="#topbarSearchModal" 
           title="Pencarian Cepat">
          <i class="bi bi-search"></i>
        </a>

        <!-- Ikon Sosial Media -->
        <div class="topbar-socials d-flex align-items-center gap-1">
          @foreach($sosmedList as $s)
            <a href="{{ $s['url'] }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="topbar-sosmed-btn" 
               title="{{ $s['platform'] }}">
              <i class="bi {{ $s['icon'] }}"></i>
            </a>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal Pencarian Cepat -->
<div class="modal fade" id="topbarSearchModal" tabindex="-1" aria-labelledby="topbarSearchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
      <div class="modal-header border-0 py-3" style="background: #000000; color: #ffffff;">
        <h6 class="modal-title fw-bold d-flex align-items-center gap-2 mb-0" id="topbarSearchModalLabel">
          <i class="bi bi-search text-warning"></i> Pencarian Website Teknik Informatika
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4 bg-light">
        <form action="{{ route('homepage.news.category', 'berita-dan-peristiwa') }}" method="GET">
          <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" 
                   name="q" 
                   class="form-control border-start-0 ps-0" 
                   placeholder="Cari berita, pengumuman, artikel..." 
                   autofocus 
                   required>
            <button class="btn btn-warning fw-bold px-4 text-dark" type="submit" style="background: #f9dc4b; border: none;">
              Cari
            </button>
          </div>
          <div class="mt-3 d-flex flex-wrap gap-1 align-items-center">
            <span class="small text-muted me-1">Pencarian populer:</span>
            <a href="{{ route('homepage.portal.page', 'pendaftaran-pmb') }}" class="badge bg-white text-dark border text-decoration-none">PMB</a>
            <a href="{{ route('homepage.kurikulum') }}" class="badge bg-white text-dark border text-decoration-none">Kurikulum OBE</a>
            <a href="{{ route('homepage.kalender-akademik') }}" class="badge bg-white text-dark border text-decoration-none">Kalender Akademik</a>
            <a href="{{ route('homepage.dosen') }}" class="badge bg-white text-dark border text-decoration-none">Dosen</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
/* ═══════════════════════════════════════════════
   TOPBAR MAIN STYLES — HITAM SOLID & WHITE TEXT
═══════════════════════════════════════════════ */
.topbar-main {
  background: #000000 !important;
  color: #ffffff !important;
  font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  height: 36px;
  line-height: 36px;
  position: relative;
  z-index: 1060;
  border-bottom: 1px solid rgba(255, 255, 255, 0.12);
}

.topbar-badge {
  background: #f9dc4b;
  color: #000000;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 0.5px;
  padding: 2px 9px;
  border-radius: 4px;
  height: 22px;
  line-height: 18px;
  text-transform: uppercase;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.topbar-marquee-container {
  min-width: 0;
  height: 36px;
  display: flex;
  align-items: center;
}

.topbar-marquee-text {
  font-size: 13px;
  font-weight: 600;
  color: #ffffff;
  letter-spacing: 0.2px;
  margin: 0;
  padding: 0;
  white-space: nowrap;
}

.topbar-search-btn {
  color: #ffffff !important;
  font-size: 14px;
  width: 26px;
  height: 26px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.topbar-search-btn:hover {
  color: #f9dc4b !important;
  transform: scale(1.1);
}

.topbar-sosmed-btn {
  width: 22px;
  height: 22px;
  background: #ffffff !important;
  color: #000000 !important;
  border-radius: 4px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 11.5px;
  text-decoration: none;
  line-height: 1;
  transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
}

.topbar-sosmed-btn:hover {
  background: #f9dc4b !important;
  color: #000000 !important;
  transform: translateY(-1.5px) scale(1.08);
}

@media (max-width: 575.98px) {
  .topbar-main {
    height: 34px;
    line-height: 34px;
  }
  .topbar-marquee-text {
    font-size: 12px;
  }
  .topbar-sosmed-btn {
    width: 20px;
    height: 20px;
    font-size: 10.5px;
  }
}
</style>

