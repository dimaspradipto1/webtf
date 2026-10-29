@extends('layouts.frontend.template')

@section('title', 'Visi, Misi, Tujuan & Sasaran TF — Program Studi Teknik Informatika')
@section('meta_description', 'Visi, Misi, Tujuan, dan Sasaran (VMTS) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.')
@section('meta_keywords', 'vmts tf, visi misi tf, tujuan sasaran teknik informatika, fakultas sains dan teknologi')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'visi-misi',
    'parentUrl' => route('homepage.tentang'),
    'parentLabel' => 'Profil',
    'defaultJudul' => 'Visi, Misi, Tujuan & Sasaran (VMTS)',
    'defaultSubjudul' => 'Komitmen fundamental yang mengarahkan penyelenggaraan Tri Dharma Perguruan Tinggi di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
    'defaultBreadcrumb' => 'Visi Misi dan Tujuan TF'
])

<!-- ═══════════════════════════════════════════════
     VMTS (VISI, MISI, TUJUAN & SASARAN) CARDS
═══════════════════════════════════════════════ -->
<section class="section-bg-sand py-5">
  <div class="container py-3">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-label">Arah & Landasan Program Studi (VMTS)</div>
      <h2 class="section-title">Visi, Misi, Tujuan & Sasaran <em>Teknik Informatika</em></h2>
      <p class="section-desc mx-auto" style="max-width: 680px;">
        Komitmen fundamental yang mengarahkan penyelenggaraan Tri Dharma Perguruan Tinggi di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      {{-- 1. Visi --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi {{ $about->visi_icon ?? 'bi-eye' }}"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">Visi Program Studi TF</h3>
          
          @php $visiPoin = $visiMisis['visi'] ?? collect(); @endphp
          @if($visiPoin->count())
            @foreach($visiPoin as $v)
              <p class="value-desc" style="font-size:15.5px; line-height:1.9; text-align: justify;">
                {{ $v->isi }}
              </p>
            @endforeach
          @else
            <p class="value-desc" style="font-size:15.5px; line-height:1.9; text-align: justify;">
              {{ $about->visi ?? 'Menjadi Program Studi Teknik Informatika yang unggul, bermartabat, bereputasi nasional dan internasional di bidang Rekayasa Perangkat Lunak, Kecerdasan Buatan, dan Jaringan Komputer serta berjiwa Technopreneur berbasis Imtaq.' }}
            </p>
          @endif
        </div>
      </div>

      {{-- 2. Misi --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi {{ $about->misi_icon ?? 'bi-rocket-takeoff' }}"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">Misi Program Studi TF</h3>
          @php
            $misiPoin = ($visiMisis['misi'] ?? collect())->pluck('isi');
            if ($misiPoin->isEmpty()) {
              $misiPoin = collect([
                'Menyelenggarakan pendidikan dan pengajaran berkualitas di bidang Teknik Informatika berbasis Outcome-Based Education (OBE) untuk menghasilkan lulusan yang kompeten, profesional, berjiwa technopreneur, dan berakhlak mulia.',
                'Melaksanakan penelitian inovatif dan terapan di bidang rekayasa perangkat lunak, kecerdasan buatan (AI), data science, dan jaringan komputer yang bernilai guna bagi industri dan masyarakat.',
                'Melaksanakan pengabdian kepada masyarakat berbasis teknologi informasi yang berdaya guna dalam meningkatkan literasi dan transformasi digital masyarakat.',
                'Menjalin kerjasama strategis dan berkelanjutan dengan dunia usaha dan dunia industri (DUDI), asosiasi profesi TI, serta institusi pendidikan di tingkat nasional dan internasional.',
              ]);
            }
          @endphp
          <ul class="value-desc" style="font-size:15px; line-height:1.8; padding-left: 20px; text-align: justify; margin: 0;">
            @foreach($misiPoin as $poin)
              <li class="mb-3">{{ $poin }}</li>
            @endforeach
          </ul>
        </div>
      </div>

      {{-- 3. Tujuan --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi bi-bullseye"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">Tujuan Program Studi TF</h3>
          @php
            $tujuanPoin = ($visiMisis['tujuan'] ?? collect())->pluck('isi');
            if ($tujuanPoin->isEmpty()) {
              $tujuanPoin = collect([
                'Menghasilkan lulusan Sarjana Komputer (S.Kom) yang unggul dan berdaya saing tinggi di bidang Rekayasa Perangkat Lunak, Kecerdasan Buatan (AI), dan Jaringan Komputer serta berjiwa technopreneur berbasis Imtaq.',
                'Menghasilkan karya penelitian ilmiah dan produk inovasi teknologi informasi yang terpublikasi di tingkat nasional maupun internasional serta mendukung kebutuhan dunia industri.',
                'Mewujudkan kontribusi nyata sivitas akademika melalui program pengabdian kepada masyarakat dalam mempercepat transformasi dan kemandirian digital masyarakat.',
                'Mewujudkan tata kelola program studi yang kredibel, transparan, akuntabel, serta memperluas jejaring kemitraan strategis dengan DUDI dan perguruan tinggi di dalam maupun luar negeri.',
              ]);
            }
          @endphp
          <ul class="value-desc" style="font-size:15px; line-height:1.8; padding-left: 20px; text-align: justify; margin: 0;">
            @foreach($tujuanPoin as $poin)
              <li class="mb-3">{{ $poin }}</li>
            @endforeach
          </ul>
        </div>
      </div>

      {{-- 4. Sasaran --}}
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="value-card h-100 p-4 p-md-5">
          <div class="value-icon-wrap mb-4">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
          <h3 class="value-title mb-3" style="font-size:24px;">Sasaran Program Studi TF</h3>
          @php
            $sasaranPoin = ($visiMisis['sasaran'] ?? collect())->pluck('isi');
            if ($sasaranPoin->isEmpty()) {
              $sasaranPoin = collect([
                'Peningkatan mutu kurikulum berbasis Outcome-Based Education (OBE) dan MBKM, ketepatan masa studi mahasiswa, serta persentase serapan lulusan di dunia kerja dan wirausaha teknologi (technopreneur).',
                'Peningkatan kuantitas dan kualitas publikasi ilmiah dosen dan mahasiswa pada jurnal nasional terakreditasi (SINTA) dan jurnal internasional bereputasi, serta perolehan Hak Kekayaan Intelektual (HKI).',
                'Peningkatan jumlah kegiatan Pengabdian kepada Masyarakat (PkM) berbasis penerapan solusi teknologi informasi tepat guna bagi instansi, UMKM, dan masyarakat luas.',
                'Peningkatan mutu sumber daya manusia (dosen bersertifikasi pendidik dan kompetensi keahlian TI), kelengkapan sarana laboratorium komputer, serta implementasi kerjasama aktif (MoU/MoA/IA) di tingkat nasional dan internasional.',
              ]);
            }
          @endphp
          <ul class="value-desc" style="font-size:15px; line-height:1.8; padding-left: 20px; text-align: justify; margin: 0;">
            @foreach($sasaranPoin as $poin)
              <li class="mb-3">{{ $poin }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection
