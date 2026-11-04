<!-- ═══════════════════════════════════════════════
     LAYANAN TERKAIT (MIRROR MOTION / 3D U-CURVE CAROUSEL)
═══════════════════════════════════════════════ -->
@if(isset($layananTerkaits) && $layananTerkaits->count() > 0)
<section class="layanan-terkait-section" id="layanan-terkait">
  {{-- Header inside Container --}}
  <div class="container position-relative">
    <div class="mirror-hall-badge" data-aos="fade-down">
      <span><i class="bi bi-grid-3x3-gap-fill me-1"></i> PORTAL DIGITAL & SISTEM INFORMASI</span>
    </div>
    
    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="layanan-terkait-title">
        {{ $layananTerkaitSetting->judul_seksi ?? 'LAYANAN TERKAIT' }}
      </h2>
      @if(!empty($layananTerkaitSetting?->subjudul_seksi))
        <p class="layanan-terkait-desc">
          “{{ $layananTerkaitSetting->subjudul_seksi }}”
        </p>
      @endif
    </div>
  </div>

<style>
  .uis-cylinder-viewport {
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
    position: relative;
    perspective: 1200px;
    perspective-origin: 50% 50%;
    padding: 20px 0 40px 0;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    touch-action: pan-y;
    -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
    mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
  }
  .uis-cylinder-viewport:active {
    cursor: grabbing;
  }
  .uis-cylinder-track {
    position: relative;
    width: 100%;
    height: 335px;
    transform-style: preserve-3d;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
  }
  .uis-cylinder-card {
    position: absolute;
    top: 0;
    left: 0;
    width: 230px;
    height: 310px;
    transform-style: preserve-3d;
    transform-origin: center bottom;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    will-change: transform, opacity;
    cursor: pointer;
    pointer-events: auto;
  }
  @media (max-width: 768px) {
    .uis-cylinder-card {
      width: 165px;
      height: 235px;
    }
    .uis-cylinder-track {
      height: 255px;
    }
    .uis-cylinder-viewport {
      padding-bottom: 25px;
    }
  }
  .uis-card-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 10px;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    transition: color 0.3s ease;
  }
  .uis-cylinder-card.is-active .uis-card-label {
    color: #f9dc4b;
    text-shadow: 0 0 10px rgba(249, 220, 75, 0.6);
  }
  .uis-card-body {
    width: 100%;
    height: 270px;
    background: linear-gradient(165deg, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.96) 60%, rgba(0, 0, 0, 0.98) 100%);
    border: 1.5px solid rgba(249, 220, 75, 0.35);
    border-radius: 16px;
    padding: 10px;
    display: flex;
    align-items: stretch;
    justify-content: stretch;
    box-sizing: border-box;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  @media (max-width: 768px) {
    .uis-card-body {
      height: 200px;
      padding: 7px;
    }
  }
  .uis-cylinder-card.is-active .uis-card-body,
  .uis-cylinder-card:hover .uis-card-body {
    border-color: rgba(249, 220, 75, 0.9);
    box-shadow: 0 0 32px rgba(249, 220, 75, 0.5), 0 18px 40px rgba(0, 0, 0, 0.75);
  }
  .uis-card-media {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    box-sizing: border-box;
    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.04), 0 4px 14px rgba(0, 0, 0, 0.14);
    overflow: hidden;
    position: relative;
  }
  .uis-card-logo {
    width: 90%;
    height: 90%;
    max-width: 92%;
    max-height: 195px;
    object-fit: contain;
    object-position: center;
    display: block;
    transition: transform 0.35s ease;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.08));
  }
  @media (max-width: 768px) {
    .uis-card-media {
      padding: 6px;
    }
    .uis-card-logo {
      width: 92%;
      height: 92%;
      max-height: 145px;
      max-width: 94%;
    }
  }
  .uis-cylinder-card:hover .uis-card-logo {
    transform: scale(1.06);
  }
</style>

  {{-- Full Width Continuous 3D Cylinder Arc Stage --}}
  <div class="uis-cylinder-viewport position-relative" id="uisCylinderViewport">
    <div class="uis-cylinder-track" id="uisCylinderTrack">
      @php
        $totalCount = $layananTerkaits->count();
        // 4x duplikasi memastikan pita berjalan kontinu tanpa henti (seamless infinite loop)
        $repeats = 4;
      @endphp
      @for($r = 0; $r < $repeats; $r++)
        @foreach($layananTerkaits as $idx => $item)
          @php
            $itemDesc = trim(strip_tags($item->deskripsi ?? 'Akses layanan digital terpadu Teknik Informatika'));
            $itemNum = $idx + 1;
          @endphp
          <div class="uis-cylinder-card"
               data-index="{{ sprintf('%02d', $itemNum) }}"
               data-total="{{ sprintf('%02d', $totalCount) }}"
               data-name="{{ $item->nama }}"
               data-desc="{{ $itemDesc }}"
               data-url="{{ $item->url }}"
               role="button"
               tabindex="0"
               aria-label="Kunjungi Layanan {{ $item->nama }}">
            
            <div class="uis-card-label">{{ $item->nama }}</div>
            <div class="uis-card-body">
              <div class="uis-card-media">
                @if($item->logo_url)
                  <img src="{{ $item->logo_url }}" alt="{{ $item->nama }}" class="uis-card-logo" loading="lazy">
                @else
                  <div class="mirror-card-fallback-icon">
                    <i class="bi {{ $item->icon ?: 'bi-globe' }}"></i>
                    <span class="mirror-fallback-title">{{ $item->nama }}</span>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @endfor
    </div>
    {{-- Interactive Water Ripple Canvas on Reflective Floor --}}
    <canvas id="mirrorWaterCanvas" class="mirror-water-canvas"></canvas>
  </div>

  {{-- Floor Info & Active Details (Mirror Hall Footer) inside Container --}}
  <div class="container position-relative">
    <div class="mirror-hall-floor" data-aos="fade-up" data-aos-delay="200">
      <div class="mirror-counter-badge" id="mirrorCounter">
        01 / {{ sprintf('%02d', $layananTerkaits->count()) }}
      </div>
      <h3 class="mirror-active-title" id="mirrorActiveTitle">
        {{ $layananTerkaits->first()->nama ?? 'Layanan Digital' }}
      </h3>
      <p class="mirror-active-desc" id="mirrorActiveDesc">
        {{ trim(strip_tags($layananTerkaits->first()->deskripsi ?? 'Akses layanan digital terpadu Teknik Informatika')) }}
      </p>
      <a href="{{ $layananTerkaits->first()->url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="mirror-active-cta" id="mirrorActiveBtn">
        <span>Kunjungi Layanan</span>
        <i class="bi bi-arrow-right-circle-fill"></i>
      </a>
    </div>
  </div>
</section>
@endif
