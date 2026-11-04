<!-- ═══════════════════════════════════════════════
     MEDIA SOSIAL (IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL)
═══════════════════════════════════════════════ -->
@if(isset($socialMedias) && $socialMedias->count() > 0)
<section class="social-media-section" id="media-sosial">
  <div class="container">
    {{-- Header Judul Seksi --}}
    <h2 class="social-media-title" data-aos="fade-up">
      {{ $socialMediaSetting->judul_seksi ?? 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL' }}
    </h2>

    {{-- Divider Garis Ikon Share --}}
    <div class="social-divider-wrap" data-aos="fade-up" data-aos-delay="50">
      <span class="social-divider-line"></span>
      <span class="social-divider-icon"><i class="bi bi-share"></i></span>
      <span class="social-divider-line"></span>
    </div>

    {{-- Deskripsi Kutipan Ajakan --}}
    @if(!empty($socialMediaSetting?->subjudul_seksi))
      <p class="social-media-quote" data-aos="fade-up" data-aos-delay="100">
        {{ $socialMediaSetting->subjudul_seksi }}
      </p>
    @endif

    {{-- Tombol Baris Ikon Media Sosial --}}
    <div class="social-media-grid" data-aos="fade-up" data-aos-delay="150">
      @foreach($socialMedias as $sm)
        <a href="{{ $sm->url }}"
           target="_blank"
           rel="noopener noreferrer"
           class="social-media-btn"
           title="{{ $sm->nama }}"
           aria-label="{{ $sm->nama }}">
          @if($sm->logo_url)
            <img src="{{ $sm->logo_url }}" alt="{{ $sm->nama }}" class="social-media-img-logo">
          @else
            <i class="bi {{ $sm->icon ?: 'bi-globe' }} social-media-icon-fallback"></i>
          @endif
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif
