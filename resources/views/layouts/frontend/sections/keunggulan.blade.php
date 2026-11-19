<!-- ═══════════════════════════════════════════════
     5. MENGAPA MEMILIH Teknik Informatika
═══════════════════════════════════════════════ -->
@if(isset($features) && $features->count() > 0)
<section class="section-bg-white" id="keunggulan">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Keunggulan Kami</div>
      <h2 class="section-title">Mengapa Memilih <em>Teknik Informatika</em>?</h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Kami memberikan ekosistem belajar yang menyeluruh antara pemahaman teoritis berstandar mutakhir dan pelatihan praktikal di lapangan.
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      @foreach($features as $index => $feature)
        @php
          $rawIcon = trim($feature->icon ?? '');
          if (empty($rawIcon)) {
              $iconClass = 'bi bi-star-fill';
          } elseif (str_starts_with($rawIcon, 'bi ') || str_contains($rawIcon, ' bi-')) {
              $iconClass = $rawIcon;
          } else {
              $iconClass = 'bi ' . $rawIcon;
          }
          $delay = (($index % 6) + 1) * 100;
        @endphp
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $delay }}">
          <div class="value-card">
            <div class="value-icon-wrap"><i class="{{ $iconClass }}"></i></div>
            <div class="value-title">{{ $feature->judul }}</div>
            <p class="value-desc">{{ trim(strip_tags(html_entity_decode($feature->deskripsi ?? '', ENT_QUOTES, 'UTF-8'))) }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
