<!-- ═══════════════════════════════════════════════
     6. FASILITAS & LABORATORIUM
═══════════════════════════════════════════════ -->
<section class="section-bg-sand" id="fasilitas">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label mx-auto">Sarana Kampus</div>
      <h2 class="section-title">Fasilitas & <em>Laboratorium</em></h2>
      <div class="divider-line centered"></div>
      <p class="section-desc mx-auto">
        Menunjang proses riset dan praktikum mahasiswa dengan sarana pengujian berteknologi mutakhir.
      </p>
    </div>

    <div class="row g-4">
      @if(isset($saranas) && $saranas->count())
        @foreach($saranas as $index => $sarana)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 100) }}">
            <div class="fasilitas-box">
              <div class="fasilitas-icon"><i class="bi {{ $sarana->icon ?? 'bi-building' }}"></i></div>
              <h4 class="fasilitas-title">{{ $sarana->nama }}</h4>
              <p class="fasilitas-desc">{{ $sarana->deskripsi ?: 'Fasilitas yang mendukung kegiatan akademik dan riset mahasiswa.' }}</p>
            </div>
          </div>
        @endforeach
      @else
        <div class="col-12 text-center text-muted py-4">
          Belum ada data sarana yang dipublikasikan.
        </div>
      @endif
    </div>
  </div>
</section>
