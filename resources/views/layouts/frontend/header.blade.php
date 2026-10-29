<!-- ═══════════════════════════════════════════════
     NAVBAR HEADER UTAMA — TEKNIK INFORMATIKA
     FAKULTAS SAINS DAN TEKNOLOGI
═══════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-xl navbar-main sticky-top">
  <div class="container-fluid px-lg-4 px-xl-5">
    <!-- Logo & Nama Prodi + Fakultas -->
    <a class="navbar-brand navbar-brand-custom me-2 me-xl-3" href="{{ route('homepage') }}">
      <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo Teknik Informatika" class="brand-logo-img">
      <div class="d-flex flex-column ms-2 justify-content-center">
        <span class="brand-title-main">TEKNIK INFORMATIKA</span>
        <span class="brand-subtitle-main">Fakultas Sains dan Teknologi</span>
      </div>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav mx-auto gap-1 align-items-center">
        <!-- 1. BERANDA -->
        <li class="nav-item">
          <a href="{{ route('homepage') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage') ? 'active' : '' }}">Beranda</a>
        </li>

        <!-- 2. PROFIL -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.sejarah') || request()->routeIs('homepage.sambutan*') || request()->routeIs('homepage.tentang') || request()->routeIs('homepage.profil-pimpinan') || request()->routeIs('homepage.struktur-organisasi') || request()->routeIs('homepage.visi-misi') || request()->routeIs('homepage.fasilitas') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profil <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.sejarah') ? 'active' : '' }}" href="{{ route('homepage.sejarah') }}">
                <i class="bi bi-hourglass-split"></i> Sejarah YAPISTA
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.sambutan*') ? 'active' : '' }}" href="{{ route('homepage.sambutan-rektor') }}">
                <i class="bi bi-person-badge"></i> Sambutan Kaprodi TF
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.tentang') || request()->routeIs('homepage.profil-pimpinan') ? 'active' : '' }}" href="{{ route('homepage.tentang') }}">
                <i class="bi bi-person-vcard"></i> Profil Pimpinan
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.struktur-organisasi') ? 'active' : '' }}" href="{{ route('homepage.struktur-organisasi') }}">
                <i class="bi bi-diagram-3"></i> Struktur Organisasi
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.visi-misi') ? 'active' : '' }}" href="{{ route('homepage.visi-misi') }}">
                <i class="bi bi-bullseye"></i> Visi Misi dan Tujuan TF
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.fasilitas') ? 'active' : '' }}" href="{{ route('homepage.fasilitas') }}">
                <i class="bi bi-buildings"></i> Fasilitas Kampus
              </a>
            </li>
          </ul>
        </li>

        <!-- 3. AKADEMIK -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ request()->routeIs('homepage.kalender-akademik') || request()->routeIs('homepage.kurikulum') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Akademik <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.kalender-akademik') ? 'active' : '' }}" href="{{ route('homepage.kalender-akademik') }}">
                <i class="bi bi-calendar-event"></i> Kalender Akademik
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.kurikulum') ? 'active' : '' }}" href="{{ route('homepage.kurikulum') }}">
                <i class="bi bi-journal-bookmark-fill"></i> Kurikulum Teknik Informatika
              </a>
            </li>
          </ul>
        </li>

        <!-- 4. DOSEN -->
        <li class="nav-item">
          <a href="{{ route('homepage.dosen') }}" class="nav-link nav-link-custom {{ request()->routeIs('homepage.dosen*') ? 'active' : '' }}">Dosen</a>
        </li>

        <!-- 5. PUBLIKASI -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Publikasi <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            @if(isset($navPublikasis) && $navPublikasis->count() > 0)
              @foreach($navPublikasis as $navPub)
                @php
                  $rawLink = trim($navPub->link ?? '');
                  if (!empty($rawLink) && !str_starts_with($rawLink, 'http://') && !str_starts_with($rawLink, 'https://') && !str_starts_with($rawLink, '/') && !str_starts_with($rawLink, '#')) {
                      $rawLink = 'https://' . $rawLink;
                  }
                  $hasLink = !empty($rawLink);
                  $pubHref = $hasLink ? $rawLink : '#';
                  $isExternal = $hasLink && (str_starts_with($rawLink, 'http://') || str_starts_with($rawLink, 'https://'));
                @endphp
                <li>
                  <a class="dropdown-item dropdown-item-custom"
                     href="{{ $pubHref }}"
                     @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                     title="{{ $navPub->deskripsi ?: $navPub->judul }}">
                    <i class="bi {{ $navPub->icon ?: 'bi-journal-richtext' }}"></i>
                    <span>{{ $navPub->judul }}</span>
                    @if($isExternal)
                      <i class="bi bi-box-arrow-up-right ms-auto text-muted" style="font-size: 10px;" title="Buka website"></i>
                    @endif
                  </a>
                </li>
              @endforeach
            @else
              <li><a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.template-dokumen') }}"><i class="bi bi-file-earmark-word"></i> <span>Template Jurnal FST UIS</span></a></li>
              <li><a class="dropdown-item dropdown-item-custom" href="https://journal.uis.ac.id/index.php/jr" target="_blank"><i class="bi bi-journal-richtext"></i> <span>JR - Jurnal Responsive</span></a></li>
              <li><a class="dropdown-item dropdown-item-custom" href="https://journal.uis.ac.id/index.php/jik" target="_blank"><i class="bi bi-journal-code"></i> <span>JIK - Jurnal Industri Kreatif</span></a></li>
              <li><a class="dropdown-item dropdown-item-custom" href="https://journal.uis.ac.id/index.php/jt-ibsi" target="_blank"><i class="bi bi-journal-text"></i> <span>JT-IBSI - Jurnal Teknik IBSI</span></a></li>
              <li><a class="dropdown-item dropdown-item-custom" href="https://journal.uis.ac.id/index.php/jastis" target="_blank"><i class="bi bi-journal-check"></i> <span>JASTIS - Jurnal Abdimas</span></a></li>
            @endif
          </ul>
        </li>

        <!-- 6. PORTAL -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ (request()->routeIs('homepage.testimoni*') || request()->routeIs('homepage.unduhan*') || request()->routeIs('homepage.template-dokumen*') || (request()->routeIs('homepage.portal.page*') && !in_array(request()->route('slug'), ['pendaftaran-pmb', 'informasi-pmb', 'pengumuman-pmb'])) || request()->routeIs('homepage.news*') || request()->routeIs('homepage.galeri*')) ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            Portal <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <!-- A. TRACER STUDY -->
            @php
              $tracerStudyItem = \App\Http\Controllers\AkademikController::getOrCreateItem('tracer-study');
              $tracerGdriveUrl = !empty($tracerStudyItem->link_url) ? $tracerStudyItem->link_url : 'https://drive.google.com';
            @endphp
            <li>
              <a class="dropdown-item dropdown-item-custom" href="{{ $tracerGdriveUrl }}" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-mortarboard-fill"></i> Tracer Study
              </a>
            </li>
            <!-- B. E-DOKUMEN -->
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.unduhan*') ? 'active' : '' }}" href="{{ route('homepage.unduhan') }}">
                <i class="bi bi-folder2-open"></i> E-Dokumen
              </a>
            </li>
            <!-- C. SOP -->
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->routeIs('homepage.template-dokumen*') ? 'active' : '' }}" href="{{ route('homepage.template-dokumen') }}">
                <i class="bi bi-file-earmark-check"></i> SOP
              </a>
            </li>

            <!-- D. AKREDITASI (Submenu) -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-item-custom dropdown-submenu-toggle d-flex align-items-center justify-content-between" href="javascript:void(0)">
                <span class="d-flex align-items-center gap-2"><i class="bi bi-patch-check-fill"></i> Akreditasi</span>
                <i class="bi bi-chevron-right submenu-arrow" style="font-size: 10px;"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-custom dropdown-submenu-list">
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.portal.page', 'dokumen-akreditasi-tf') }}">
                    <i class="bi bi-file-earmark-pdf"></i> Dokumen Akreditasi TF
                  </a>
                </li>
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.portal.page', 'sertifikat-akreditasi') }}">
                    <i class="bi bi-file-earmark-check"></i> Sertifikat Akreditasi
                  </a>
                </li>
                @php
                  $laminfokomItem = \App\Http\Controllers\AkademikController::getOrCreateItem('laminfokom');
                  $laminfokomUrl = !empty($laminfokomItem->link_url) ? $laminfokomItem->link_url : 'https://laminfokom.or.id';
                  $banPtItem = \App\Http\Controllers\AkademikController::getOrCreateItem('ban-pt');
                  $banPtUrl = !empty($banPtItem->link_url) ? $banPtItem->link_url : 'https://www.banpt.or.id';
                @endphp
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ $laminfokomUrl }}" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-award"></i> LAMINFOKOM
                  </a>
                </li>
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ $banPtUrl }}" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-shield-check"></i> BAN-PT
                  </a>
                </li>
              </ul>
            </li>

            <!-- E. BEASISWA (Submenu) -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-item-custom dropdown-submenu-toggle d-flex align-items-center justify-content-between" href="javascript:void(0)">
                <span class="d-flex align-items-center gap-2"><i class="bi bi-gift-fill"></i> Beasiswa</span>
                <i class="bi bi-chevron-right submenu-arrow" style="font-size: 10px;"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-custom dropdown-submenu-list">
                @if(isset($navBeasiswas) && $navBeasiswas->count() > 0)
                  @foreach($navBeasiswas as $b)
                    @php
                      $rawLink = trim($b->link ?? '');
                      if (!empty($rawLink) && !str_starts_with($rawLink, 'http://') && !str_starts_with($rawLink, 'https://') && !str_starts_with($rawLink, '/') && !str_starts_with($rawLink, '#')) {
                          $rawLink = 'https://' . $rawLink;
                      }
                      $hasLink = !empty($rawLink);
                      $bHref = $hasLink ? $rawLink : '#';
                      $isExternal = $hasLink && (str_starts_with($rawLink, 'http://') || str_starts_with($rawLink, 'https://'));
                    @endphp
                    <li>
                      <a class="dropdown-item dropdown-item-custom"
                         href="{{ $bHref }}"
                         @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                        <i class="bi {{ $b->icon ?: 'bi-award-fill' }}"></i> {{ $b->judul }}
                      </a>
                    </li>
                  @endforeach
                @else
                  <li><span class="dropdown-item dropdown-item-custom text-muted small">Belum ada beasiswa</span></li>
                @endif
              </ul>
            </li>

            <!-- F. INFORMASI (Submenu) -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-item-custom dropdown-submenu-toggle d-flex align-items-center justify-content-between" href="javascript:void(0)">
                <span class="d-flex align-items-center gap-2"><i class="bi bi-newspaper"></i> Informasi</span>
                <i class="bi bi-chevron-right submenu-arrow" style="font-size: 10px;"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-custom dropdown-submenu-list">
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.news.category', 'berita-dan-peristiwa') }}">
                    <i class="bi bi-newspaper"></i> Berita dan Peristiwa
                  </a>
                </li>
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.news.category', 'pengumuman') }}">
                    <i class="bi bi-megaphone"></i> Pengumuman
                  </a>
                </li>
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.news.category', 'undangan') }}">
                    <i class="bi bi-envelope-paper"></i> Undangan
                  </a>
                </li>
                <li>
                  <a class="dropdown-item dropdown-item-custom" href="{{ route('homepage.galeri') }}">
                    <i class="bi bi-images"></i> Galeri
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>

        <!-- 7. PMB (Penerimaan Mahasiswa Baru) -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-custom dropdown-toggle {{ (request()->routeIs('homepage.portal.page*') && in_array(request()->route('slug'), ['pendaftaran-pmb', 'informasi-pmb', 'pengumuman-pmb'])) || request()->is('portal/pendaftaran-pmb') || request()->is('portal/informasi-pmb') || request()->is('portal/pengumuman-pmb') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            PMB <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom">
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->route('slug') === 'pendaftaran-pmb' ? 'active' : '' }}" href="{{ route('homepage.portal.page', 'pendaftaran-pmb') }}">
                <i class="bi bi-pencil-square"></i> Pendaftaran PMB
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->route('slug') === 'informasi-pmb' ? 'active' : '' }}" href="{{ route('homepage.portal.page', 'informasi-pmb') }}">
                <i class="bi bi-info-circle"></i> Informasi PMB
              </a>
            </li>
            <li>
              <a class="dropdown-item dropdown-item-custom {{ request()->route('slug') === 'pengumuman-pmb' ? 'active' : '' }}" href="{{ route('homepage.portal.page', 'pengumuman-pmb') }}">
                <i class="bi bi-megaphone-fill"></i> Pengumuman PMB
              </a>
            </li>
          </ul>
        </li>

        <!-- Pilih Bahasa Dropdown -->
        @if(isset($bahasaList) && $bahasaList->count() > 0)
        <li class="nav-item dropdown uis-lang-nav-item">
          <a class="nav-link nav-link-custom dropdown-toggle uis-lang-toggle" 
             href="#" 
             role="button" 
             data-bs-toggle="dropdown" 
             aria-expanded="false" 
             id="dropdownLangSelect" 
             title="Pilih Bahasa / Select Language">
            <img src="{{ $defaultBahasa?->flag_url ?? asset('assets/img/flags/id.png') }}" 
                 id="uisCurrentFlagImg" 
                 alt="Bendera" 
                 class="uis-flag-img-main" 
                 width="22" 
                 height="15"
                 onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
            <span class="uis-lang-name d-none d-xxl-inline" id="uisCurrentName">{{ $defaultBahasa->nama ?? 'Bahasa Indonesia' }}</span>
            <span class="uis-lang-name d-inline d-xxl-none" id="uisCurrentShort">{{ $defaultBahasa ? (str_contains($defaultBahasa->nama, ' ') ? explode(' ', $defaultBahasa->nama)[1] ?? $defaultBahasa->nama : $defaultBahasa->nama) : 'Indonesia' }}</span>
            <i class="bi bi-chevron-down ms-1" style="font-size: 10px;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-custom dropdown-menu-end uis-lang-menu shadow-lg" aria-labelledby="dropdownLangSelect">
            <li class="px-3 py-1 dropdown-header text-muted text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">
              <i class="bi bi-translate me-1"></i> Select Language
            </li>
            @foreach($bahasaList as $lang)
              <li>
                <a class="dropdown-item dropdown-item-custom uis-lang-item justify-content-between" 
                   href="javascript:void(0)" 
                   onclick="uisChangeLanguage('{{ $lang->kode }}', '{{ addslashes($lang->nama) }}', '{{ $lang->flag_url }}')"
                   data-code="{{ $lang->kode }}"
                   data-name="{{ $lang->nama }}"
                   data-flag="{{ $lang->flag_url }}">
                  <span class="d-flex align-items-center gap-2">
                    <img src="{{ $lang->flag_url }}" 
                         alt="{{ $lang->nama }}" 
                         class="uis-flag-img" 
                         width="22" 
                         height="15"
                         onerror="this.onerror=null; this.src='{{ asset('assets/img/flags/id.png') }}';">
                    <span class="uis-lang-text">{{ $lang->nama }}</span>
                  </span>
                  <i class="bi bi-check2 text-success fw-bold uis-check-icon {{ ($lang->is_default) ? '' : 'd-none' }}" id="check-lang-{{ $lang->kode }}"></i>
                </a>
              </li>
            @endforeach
          </ul>
        </li>
        @endif
      </ul>

      <!-- CTA Buttons -->
      <div class="d-flex align-items-center gap-2 mt-3 mt-xl-0">
        <a href="{{ route('login') }}" class="btn-portal-nav" title="Login">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Handle nested submenu toggle on click (especially for mobile/touch)
  document.querySelectorAll('.dropdown-submenu-toggle').forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const parent = this.closest('.dropdown-submenu');
      const isOpen = parent.classList.contains('show');
      // Close sibling submenus
      parent.parentElement.querySelectorAll('.dropdown-submenu.show').forEach(function (sib) {
        if (sib !== parent) sib.classList.remove('show');
      });
      parent.classList.toggle('show', !isOpen);
    });
  });
});
</script>
