@extends('layouts.frontend.template')

@section('title', 'Syarat & Ketentuan — Teknik Informatika (UIS)')
@section('meta_description', 'Syarat dan Ketentuan penggunaan Portal Resmi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) Batam.')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'syarat-ketentuan',
    'defaultJudul' => 'Syarat & Ketentuan',
    'defaultSubjudul' => 'Ketentuan umum penggunaan layanan informasi dan publikasi digital pada Portal Resmi Program Studi S1 Teknik Informatika Universitas Ibnu Sina (UIS).',
    'defaultBreadcrumb' => 'Syarat & Ketentuan'
])

<section class="section-bg-sand py-5">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border">
          <p class="text-muted small mb-4">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

          <h5 class="fw-bold text-dark mb-2">1. Ketentuan Umum</h5>
          <p class="text-muted mb-4">
            Dengan mengakses dan menggunakan portal resmi Program Studi S1 Teknik Informatika Universitas Ibnu Sina (UIS), Anda menyetujui untuk mematuhi seluruh syarat dan ketentuan yang berlaku serta peraturan perundang-undangan di Republik Indonesia.
          </p>

          <h5 class="fw-bold text-dark mb-2">2. Hak Kekayaan Intelektual</h5>
          <p class="text-muted mb-4">
            Seluruh konten teks, dokumen akademik, kurikulum, foto dokumentasi, dan materi publikasi yang ditampilkan di website ini merupakan milik Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi UIS, kecuali dinyatakan lain. Pengutipan untuk kepentingan akademik wajib mencantumkan sumber resmi.
          </p>

          <h5 class="fw-bold text-dark mb-2">3. Kontribusi Pengguna & Moderasi</h5>
          <p class="text-muted mb-4">
            Pengguna yang mengirimkan testimoni atau ulasan melalui formulir publik wajib menyampaikan informasi yang benar, sopan, dan tidak melanggar hukum maupun norma etika akademik. Administrator berhak memoderasi, menolak, atau menghapus kiriman yang tidak sesuai ketentuan.
          </p>

          <h5 class="fw-bold text-dark mb-2">4. Tautan Eksternal</h5>
          <p class="text-muted mb-4">
            Website ini memuat tautan menuju sistem eksternal seperti SIAKAD, PMB, PDDikti, SINTA, dan media sosial resmi. Program Studi tidak bertanggung jawab atas ketersediaan atau kebijakan privasi situs eksternal tersebut.
          </p>

          <h5 class="fw-bold text-dark mb-2">5. Perubahan Ketentuan</h5>
          <p class="text-muted mb-0">
            Program Studi berhak memperbarui syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Informasi lebih lanjut dapat menghubungi kami melalui halaman <a href="{{ route('homepage.kontak') }}" class="fw-semibold text-dark text-decoration-underline">Kontak Program Studi</a>.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
