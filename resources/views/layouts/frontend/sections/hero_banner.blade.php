<!-- ═══════════════════════════════════════════════
     1. HERO BANNER (FULL IMAGE PROMOTION)
═══════════════════════════════════════════════ -->
<section class="hero-slider-section p-0">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500" data-bs-pause="false" data-bs-wrap="true" data-bs-touch="true">
    
    @php
      $activeBanners = isset($banners) ? $banners->filter(fn($b) => !empty($b->url) || !empty($b->gambar)) : collect();
    @endphp

    @if($activeBanners->count() > 1)
      <div class="carousel-indicators">
        @foreach($activeBanners as $index => $banner)
          <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $loop->iteration }}"></button>
        @endforeach
      </div>
    @endif

    <div class="carousel-inner">
      @if($activeBanners->count() > 0)
        @foreach($activeBanners as $index => $banner)
          @php $imgPath = $banner->url ?? $banner->gambar; @endphp
          <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <img src="{{ asset('storage/' . $imgPath) }}" 
                 alt="{{ $banner->judul ?? 'Banner Promosi Teknik Informatika' }}" 
                 class="hero-banner-img"
                 onerror="this.onerror=null;this.src='{{ asset('frontend/img/default-hero-banner.svg') }}';">
          </div>
        @endforeach
      @else
        <div class="carousel-item active">
          <picture>
            <source srcset="{{ asset('frontend/img/default-hero-banner.svg') }}" type="image/svg+xml">
            <img src="{{ asset('frontend/img/default-hero-banner.jpg') }}" 
                 alt="Banner Default Teknik Informatika" 
                 class="hero-banner-img"
                 style="width: 100%; height: auto; display: block; object-fit: contain;">
          </picture>
        </div>
      @endif
    </div>

    @if($activeBanners->count() > 1)
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Selanjutnya</span>
      </button>
    @endif

  </div>
</section>
