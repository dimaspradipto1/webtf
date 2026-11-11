<!-- ═══════════════════════════════════════════════
     13. PARTNER & KERJA SAMA (2-ROW INFINITE SLIDER)
═══════════════════════════════════════════════ -->
@php
  $defaultPartners = collect([
    (object)['nama' => 'PT Telkom Indonesia (Persero) Tbk', 'logo' => null],
    (object)['nama' => 'PT Schneider Electric Batam', 'logo' => null],
    (object)['nama' => 'PT Pegatron Technology Indonesia', 'logo' => null],
    (object)['nama' => 'APTIKOM (Asosiasi Pendidikan Tinggi Informatika)', 'logo' => null],
    (object)['nama' => 'PT Infineon Technologies Batam', 'logo' => null],
    (object)['nama' => 'Infinite Studios (Nongsa Digital Park)', 'logo' => null],
    (object)['nama' => 'PT Batamindo Investment Cakrawala', 'logo' => null],
    (object)['nama' => 'Kadin Kota Batam', 'logo' => null],
  ]);

  $displayPartners = (isset($partners) && $partners->count() > 0) ? $partners : $defaultPartners;
@endphp

<section class="section-bg-white py-5" id="mitra">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Jejaring Mitra</div>
      <h2 class="section-title">Mitra <em>Kerjasama</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Teknik Informatika bermitra dengan berbagai sektor industri dan teknologi terkemuka dalam penempatan magang industri, riset terapan, dan rekrutmen lulusan.
      </p>
    </div>
  </div>

  @php
    $totalPartners = $displayPartners->count();
    $half = ceil($totalPartners / 2);
    $rawRow1 = $displayPartners->slice(0, $half);
    $rawRow2 = $displayPartners->slice($half);

    if ($rawRow2->isEmpty()) {
        $rawRow2 = $rawRow1;
    }

    // Perbanyak item agar loop slider terasa panjang dan mulus di layar lebar
    $row1 = collect();
    while ($row1->count() < 8) {
        $row1 = $row1->concat($rawRow1);
    }
    $row2 = collect();
    while ($row2->count() < 8) {
        $row2 = $row2->concat($rawRow2);
    }
  @endphp

  <div class="marquee-wrapper" data-aos="fade-up">
    <!-- Baris 1: Bergerak ke Kiri -->
    <div class="marquee-track-container mb-3">
      <div class="marquee-track marquee-left">
        @foreach($row1 as $p)
          <div class="partner-marquee-card">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
        {{-- Duplicate Set for Continuous Loop --}}
        @foreach($row1 as $p)
          <div class="partner-marquee-card" aria-hidden="true">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
      </div>
    </div>

    <!-- Baris 2: Bergerak ke Kanan -->
    <div class="marquee-track-container">
      <div class="marquee-track marquee-right">
        @foreach($row2 as $p)
          <div class="partner-marquee-card">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
        {{-- Duplicate Set for Continuous Loop --}}
        @foreach($row2 as $p)
          <div class="partner-marquee-card" aria-hidden="true">
            @if($p->logo)
              <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->nama }}" class="partner-marquee-img" loading="lazy">
            @else
              <span class="partner-marquee-text">{{ $p->nama }}</span>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
