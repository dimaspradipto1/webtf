  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <!-- 1. Beranda / Dashboard -->
          <li class="nav-item">
              <a class="nav-link {{ Route::is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->

          @php
              $currentUser = Auth::user();
              $isAdmin = $currentUser?->isAdmin();
              $isPenulis = $currentUser?->hasExactRole('penulis');
              $isOrganisasi = $currentUser?->hasExactRole('organisasi');
          @endphp

          @if($isAdmin)
          <!-- 1b. Konten Beranda -->
          <li class="nav-item">
              <a class="nav-link {{ Route::is('banner.*') || Route::is('layanan-terkait.*') || Route::is('social-media.*') || Route::is('feature.*') || Route::is('tridharma.*') || Route::is('pmb-setting.*') || Route::is('faculty-stat.*') || Route::is('partner.*') ? '' : 'collapsed' }}" data-bs-target="#beranda-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-layout-text-window-reverse"></i><span>Konten Beranda</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="beranda-nav" class="nav-content collapse {{ Route::is('banner.*') || Route::is('layanan-terkait.*') || (Route::is('social-media.*') && request('kategori') !== 'humas') || Route::is('feature.*') || Route::is('tridharma.*') || Route::is('pmb-setting.*') || Route::is('faculty-stat.*') || Route::is('partner.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('banner.index') }}" class="{{ Route::is('banner.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Banner Hero</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('layanan-terkait.index') }}" class="{{ Route::is('layanan-terkait.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Layanan Terkait</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('social-media.index', ['kategori' => 'universitas']) }}" class="{{ Route::is('social-media.*') && request('kategori') !== 'humas' ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Media Sosial Prodi</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('faculty-stat.index') }}" class="{{ Route::is('faculty-stat.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Statistik Program Studi</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('feature.index') }}" class="{{ Route::is('feature.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Keunggulan Program Studi</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('tridharma.index') }}" class="{{ Route::is('tridharma.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Tri Dharma</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('pmb-setting.index') }}" class="{{ Route::is('pmb-setting.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Banner PMB & Pendaftaran</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('partner.index') }}" class="{{ Route::is('partner.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Mitra Kerjasama Riset</span>
                      </a>
                  </li>
              </ul>
          </li>

          <!-- 2. PROFIL (Sesuai Urutan Menu Header) -->
          <li class="nav-item">
            <a class="nav-link {{ Route::is('milestone.*') || Route::is('sambutan-dekan.*') || Route::is('sambutan-rektor.*') || Route::is('about.*') || Route::is('pimpinan.*') || Route::is('struktur-organisasi.*') || Route::is('visimisi.*') || Route::is('sarana.*') ? '' : 'collapsed' }}" data-bs-target="#profil-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-building"></i><span>Profil</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="profil-nav" class="nav-content collapse {{ Route::is('milestone.*') || Route::is('sambutan-dekan.*') || Route::is('sambutan-rektor.*') || Route::is('about.*') || Route::is('pimpinan.*') || Route::is('struktur-organisasi.*') || Route::is('visimisi.*') || Route::is('sarana.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('milestone.index') }}" class="{{ Route::is('milestone.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Sejarah YAPISTA</span>
                </a>
              </li>
              <li>
                <a href="{{ route('sambutan-rektor.index') }}" class="{{ Route::is('sambutan-dekan.*') || Route::is('sambutan-rektor.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Sambutan Kaprodi TF</span>
                </a>
              </li>
              <li>
                <a href="{{ route('about.index') }}" class="{{ Route::is('about.*') || Route::is('pimpinan.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Profil Pimpinan</span>
                </a>
              </li>
              <li>
                <a href="{{ route('struktur-organisasi.index') }}" class="{{ Route::is('struktur-organisasi.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Struktur Organisasi</span>
                </a>
              </li>
              <li>
                <a href="{{ route('visimisi.index') }}" class="{{ Route::is('visimisi.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Visi Misi dan Tujuan TF</span>
                </a>
              </li>
              <li>
                <a href="{{ route('sarana.index') }}" class="{{ Route::is('sarana.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Fasilitas Kampus</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- 3. AKADEMIK -->
          <li class="nav-item">
            <a class="nav-link {{ Route::is('akademik.kalender') || Route::is('kurikulum.*') ? '' : 'collapsed' }}" data-bs-target="#akademik-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-mortarboard"></i><span>Akademik</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="akademik-nav" class="nav-content collapse {{ Route::is('akademik.kalender') || Route::is('kurikulum.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('akademik.kalender') }}" class="{{ Route::is('akademik.kalender') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Kalender Akademik</span>
                </a>
              </li>
              <li>
                <a href="{{ route('kurikulum.index') }}" class="{{ Route::is('kurikulum.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Kurikulum Teknik Informatika</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- 4. DOSEN -->
          <li class="nav-item">
            <a class="nav-link {{ Route::is('dosen.*') ? '' : 'collapsed' }}" href="{{ route('dosen.index') }}">
              <i class="bi bi-person-workspace"></i><span>Dosen</span>
            </a>
          </li>

          <!-- 5. PUBLIKASI -->
          <li class="nav-item">
            <a class="nav-link {{ Route::is('publikasi.*') ? '' : 'collapsed' }}" href="{{ route('publikasi.index') }}">
              <i class="bi bi-journal-richtext"></i><span>Publikasi</span>
            </a>
          </li>

          <!-- 6. PORTAL (Tracer Study, E-Dokumen, SOP, Akreditasi, Beasiswa, Informasi, PMB) -->
          <li class="nav-item">
            <a class="nav-link {{ Route::is('testimonial.*') || Route::is('unduhan.*') || Route::is('template-dokumen.*') || Route::is('akademik.portal.*') || Route::is('prestasi.*') || Route::is('organisasi-mahasiswa.*') || Route::is('beasiswa.*') ? '' : 'collapsed' }}" data-bs-target="#portal-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-compass"></i><span>Portal Layanan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="portal-nav" class="nav-content collapse {{ Route::is('testimonial.*') || Route::is('unduhan.*') || Route::is('template-dokumen.*') || Route::is('akademik.portal.*') || Route::is('prestasi.*') || Route::is('organisasi-mahasiswa.*') || Route::is('beasiswa.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('akademik.portal.edit', 'tracer-study') }}" class="{{ request()->route('tipe') === 'tracer-study' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Tracer Study (Link GDrive)</span>
                </a>
              </li>
              <li>
                <a href="{{ route('testimonial.index') }}" class="{{ Route::is('testimonial.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Testimoni Alumni</span>
                </a>
              </li>
              <li>
                <a href="{{ route('unduhan.index') }}" class="{{ Route::is('unduhan.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>E-Dokumen</span>
                </a>
              </li>
              <li>
                <a href="{{ route('template-dokumen.index') }}" class="{{ Route::is('template-dokumen.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>SOP</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'dokumen-akreditasi-tf') }}" class="{{ request()->route('tipe') === 'dokumen-akreditasi-tf' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Dokumen Akreditasi TF</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'sertifikat-akreditasi') }}" class="{{ request()->route('tipe') === 'sertifikat-akreditasi' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Sertifikat Akreditasi</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'laminfokom') }}" class="{{ request()->route('tipe') === 'laminfokom' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>LAMINFOKOM (Link URL)</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'ban-pt') }}" class="{{ request()->route('tipe') === 'ban-pt' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>BAN-PT (Link URL)</span>
                </a>
              </li>
              <li>
                <a href="{{ route('beasiswa.index') }}" class="{{ Route::is('beasiswa.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Beasiswa</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'pendaftaran-pmb') }}" class="{{ request()->route('tipe') === 'pendaftaran-pmb' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Pendaftaran PMB</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'informasi-pmb') }}" class="{{ request()->route('tipe') === 'informasi-pmb' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Informasi PMB</span>
                </a>
              </li>
              <li>
                <a href="{{ route('akademik.portal.edit', 'pengumuman-pmb') }}" class="{{ request()->route('tipe') === 'pengumuman-pmb' ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Pengumuman PMB</span>
                </a>
              </li>
              <li>
                <a href="{{ route('prestasi.index') }}" class="{{ Route::is('prestasi.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Prestasi Mahasiswa</span>
                </a>
              </li>
              <li>
                <a href="{{ route('organisasi-mahasiswa.index') }}" class="{{ Route::is('organisasi-mahasiswa.*') ? 'active' : '' }}">
                  <i class="bi bi-circle"></i><span>Organisasi Mahasiswa</span>
                </a>
              </li>
            </ul>
          </li>
          @elseif($isOrganisasi)
          <li class="nav-item">
            <a class="nav-link {{ Route::is('organisasi-mahasiswa.*') ? '' : 'collapsed' }}" href="{{ route('organisasi-mahasiswa.index') }}">
              <i class="bi bi-people-fill"></i><span>Organisasi Mahasiswa</span>
            </a>
          </li>
          @endif

          @if($isAdmin || $isPenulis)
          <!-- 7. Informasi (Berita, Pengumuman, Undangan, Galeri) -->
          <li class="nav-item">
              <a class="nav-link {{ Route::is('news.*') || Route::is('gallery.*') || Route::is('faq.*') ? '' : 'collapsed' }}" data-bs-target="#informasi-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-newspaper"></i><span>Informasi & Galeri</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="informasi-nav" class="nav-content collapse {{ Route::is('news.*') || Route::is('gallery.*') || Route::is('faq.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('news.index') }}" class="{{ Route::is('news.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Berita, Pengumuman & Undangan</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('news.create') }}" class="{{ Route::is('news.create') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Tulis Berita / Pengumuman</span>
                      </a>
                  </li>
                  @if($isAdmin)
                  <li>
                      <a href="{{ route('gallery.index') }}" class="{{ Route::is('gallery.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Galeri Dokumentasi</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('faq.index') }}" class="{{ Route::is('faq.*') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>FAQ Informasi</span>
                      </a>
                  </li>
                  @endif
              </ul>
          </li>
          @endif

          @if($isAdmin)
          <!-- 8. Kontak -->
          <li class="nav-item">
              <a class="nav-link {{ Route::is('contact.*') ? '' : 'collapsed' }}" href="{{ route('contact.index') }}">
                  <i class="bi bi-telephone"></i>
                  <span>Kontak</span>
              </a>
          </li>
          @endif

          <li class="nav-heading">Pengaturan & Administrator</li>

          <li class="nav-item">
              <a class="nav-link {{ Route::is('user.my-profile') || Route::is('profil.*') ? '' : 'collapsed' }}" href="{{ route('user.my-profile') }}">
                  <i class="bi bi-person"></i>
                  <span>Profil Akun</span>
              </a>
          </li>

          @if($isAdmin)
          <li class="nav-item">
              <a class="nav-link {{ Route::is('bahasa.*') ? '' : 'collapsed' }}" href="{{ route('bahasa.index') }}">
                  <i class="bi bi-translate"></i>
                  <span>Pengaturan Bahasa</span>
              </a>
          </li>

          <li class="nav-item">
              <a class="nav-link {{ Route::is('user.*') ? '' : 'collapsed' }}" href="{{ route('user.index') }}">
                  <i class="bi bi-people"></i>
                  <span>Manajemen Pengguna</span>
              </a>
          </li>
          @endif

      </ul>

  </aside>
