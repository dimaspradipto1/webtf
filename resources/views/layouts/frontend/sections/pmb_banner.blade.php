<!-- ═══════════════════════════════════════════════
     PMB BANNER (PENERIMAAN MAHASISWA BARU)
═══════════════════════════════════════════════ -->
@if(!isset($pmbSetting) || $pmbSetting->is_active)
<section class="section-bg-sand" id="pmb">
  <div class="container" data-aos="fade-up">
    <div class="pmb-cta-box">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="badge pmb-badge-wrap px-3 py-2 rounded-pill mb-3" style="background: var(--uis-orange); color: #000000; font-weight: 800; font-size: 12px; letter-spacing: 1px;">
            {{ $pmbSetting->badge_text ?? 'PENERIMAAN MAHASISWA BARU (PMB) T.A. 2026/2027' }}
          </div>
          <h2 class="text-white fw-bold mb-3" style="font-size: clamp(1.5rem, 3.5vw, 2.1rem); line-height: 1.3;">
            {{ $pmbSetting->judul ?? 'Daftar Sekarang & Raih Masa Depan Cerah Bersama Teknik Informatika!' }}
          </h2>
          <div class="text-white mb-4 pmb-desc-content" style="line-height: 1.7; max-width: 620px; opacity: 0.92; font-size: 14.5px;">
            {!! $pmbSetting->deskripsi ?? 'Tersedia berbagai jalur seleksi: Jalur Bebas Tes / Prestasi, Jalur Reguler, Jalur KIP-Kuliah, dan Jalur Alih Jenjang Karyawan.' !!}
          </div>
          <div class="d-flex flex-wrap gap-3 pmb-btn-group">
            @php
              $link1 = $pmbSetting->tombol_link_1 ?? route('homepage.kontak');
              if (!str_starts_with($link1, 'http') && !str_starts_with($link1, '/')) {
                  $link1 = '/' . $link1;
              }
            @endphp
            <a href="{{ $link1 }}" target="{{ str_starts_with($link1, 'http') ? '_blank' : '_self' }}" class="btn-primary-hero">
              <i class="bi bi-pencil-square"></i> {{ $pmbSetting->tombol_text_1 ?? 'Daftar PMB Sekarang' }}
            </a>

            @php
              $link2 = $pmbSetting->tombol_link_2 ?? '';
              if (empty($link2) && !empty($cleanWa)) {
                  $link2 = "https://wa.me/{$cleanWa}?text=" . urlencode("Halo Admin PMB Teknik Informatika, saya ingin konsultasi pendaftaran mahasiswa baru");
              }
            @endphp
            @if(!empty($link2))
              <a href="{{ $link2 }}" target="_blank" class="btn-pmb-wa">
                <i class="bi bi-whatsapp"></i> {{ $pmbSetting->tombol_text_2 ?? 'Konsultasi WhatsApp PMB' }}
              </a>
            @endif
          </div>
        </div>

        <div class="col-lg-4">
          <div class="p-4 rounded-4" style="background: rgba(0, 0, 0, 0.22); border: 1px solid rgba(255, 255, 255, 0.22); backdrop-filter: blur(8px);">
            <h5 class="text-white fw-bold mb-3"><i class="bi bi-calendar-event text-warning me-2"></i>Jadwal Gelombang:</h5>
            <ul class="text-white small list-unstyled mb-0" style="line-height: 2; opacity: 0.95;">
              @php
                $waveList = $pmbSetting->waves ?? ['Gelombang 1: Jan - Apr', 'Gelombang 2: Mei - Jul', 'Gelombang 3: Agu - Sep'];
              @endphp
              @foreach($waveList as $waveItem)
                <li><i class="bi bi-check2 text-warning me-1"></i> {{ $waveItem }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif
