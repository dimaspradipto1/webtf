<!-- ═══════════════════════════════════════════════
     FOOTER — PROGRAM STUDI TEKNIK INFORMATIKA
     FAKULTAS SAINS DAN TEKNOLOGI
═══════════════════════════════════════════════ -->
<footer class="footer-main">
  <div class="container">
    <div class="row g-5">
      <!-- Brand -->
      <div class="col-lg-4">
        <a href="{{ route('homepage') }}" class="footer-logo mb-3 d-inline-flex align-items-center gap-2 text-decoration-none">
          <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo Teknik Informatika" style="height: 48px; width: auto; object-fit: contain;">
          <div class="d-flex flex-column">
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 16px; color: #f9dc4b; letter-spacing: 0.5px; line-height: 1.15;">TEKNIK INFORMATIKA</span>
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; font-size: 12px; color: #ffffff; letter-spacing: 0.3px;">Fakultas Sains dan Teknologi</span>
          </div>
        </a>
        <p class="footer-desc">
          Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Berkomitmen menyelenggarakan pendidikan tinggi teknologi informasi yang unggul, bermartabat, bereputasi nasional dan internasional, serta berjiwa technopreneur berbasis Imtaq.
        </p>
        <div class="footer-social">
          <a href="https://www.instagram.com/universitasibnusina/" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
          <a href="https://www.facebook.com/universitasibnusina/" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
          <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
          <a href="https://www.youtube.com/@universitasibnusinabatam" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Links Profil -->
      <div class="col-6 col-lg-2">
        <div class="footer-heading">Profil Prodi</div>
        <ul class="footer-links">
          <li><a href="{{ route('homepage') }}"><i class="bi bi-chevron-right"></i> Beranda</a></li>
          <li><a href="{{ route('homepage.sejarah') }}"><i class="bi bi-chevron-right"></i> Sejarah YAPISTA</a></li>
          <li><a href="{{ route('homepage.sambutan-rektor') }}"><i class="bi bi-chevron-right"></i> Sambutan Kaprodi TF</a></li>
          <li><a href="{{ route('homepage.tentang') }}"><i class="bi bi-chevron-right"></i> Profil Pimpinan</a></li>
          <li><a href="{{ route('homepage.struktur-organisasi') }}"><i class="bi bi-chevron-right"></i> Struktur Organisasi</a></li>
          <li><a href="{{ route('homepage.visi-misi') }}"><i class="bi bi-chevron-right"></i> Visi Misi & Tujuan TF</a></li>
          <li><a href="{{ route('homepage.fasilitas') }}"><i class="bi bi-chevron-right"></i> Fasilitas Kampus</a></li>
        </ul>
      </div>

      <!-- Akademik & Portal -->
      <div class="col-6 col-lg-2">
        <div class="footer-heading">Akademik & Portal</div>
        <ul class="footer-links">
          <li><a href="{{ route('homepage.kalender-akademik') }}"><i class="bi bi-chevron-right"></i> Kalender Akademik</a></li>
          <li><a href="{{ route('homepage.kurikulum') }}"><i class="bi bi-chevron-right"></i> Kurikulum TF</a></li>
          <li><a href="{{ route('homepage.dosen') }}"><i class="bi bi-chevron-right"></i> Data Dosen</a></li>
          @php
            $footerTracerItem = \App\Http\Controllers\AkademikController::getOrCreateItem('tracer-study');
            $footerTracerUrl = !empty($footerTracerItem->link_url) ? $footerTracerItem->link_url : 'https://drive.google.com';
          @endphp
          <li><a href="{{ $footerTracerUrl }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-chevron-right"></i> Tracer Study</a></li>
          <li><a href="{{ route('homepage.unduhan') }}"><i class="bi bi-chevron-right"></i> E-Dokumen</a></li>
          <li><a href="{{ route('homepage.template-dokumen') }}"><i class="bi bi-chevron-right"></i> SOP</a></li>
          <li><a href="{{ route('homepage.portal.page', 'dokumen-akreditasi-tf') }}"><i class="bi bi-chevron-right"></i> Akreditasi TF</a></li>
          <li><a href="{{ route('homepage.portal.page', 'sertifikat-akreditasi') }}"><i class="bi bi-chevron-right"></i> Sertifikat Akreditasi</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-4">
        <div class="footer-heading">Kontak Program Studi</div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="bi bi-geo-alt"></i></div>
          <div class="footer-contact-text">
            <strong>Alamat Kampus</strong>
            {{ $contact->alamat ?? 'Jalan Teuku Umar, Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29432' }}
          </div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="bi bi-telephone"></i></div>
          <div class="footer-contact-text">
            <strong>Telepon / WhatsApp</strong>
            {{ $contact->no_wa ?? '(0778) 408 3113' }}
          </div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="bi bi-envelope"></i></div>
          <div class="footer-contact-text">
            <strong>Email Resmi</strong>
            {{ $contact->email ?? 'informatika@uis.ac.id' }}
          </div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="bi bi-clock"></i></div>
          <div class="footer-contact-text">
            <strong>Jam Operasional</strong>
            Senin – Sabtu: 08.00 – 17.00 WIB
          </div>
        </div>
      </div>
    </div>

    <div class="footer-divider"></div>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 footer-bottom">
      <span>© {{ date('Y') }} Program Studi Teknik Informatika — Fakultas Sains dan Teknologi. All rights reserved.</span>
      <div class="d-flex gap-3">
        <a href="#">Kebijakan Privasi</a>
        <a href="#">Syarat & Ketentuan</a>
        <a href="{{ route('login') }}" style="color:var(--uis-yellow);">Portal Admin</a>
      </div>
    </div>
  </div>
</footer>
