@extends('layouts.frontend.template')

@section('title', 'Kebijakan Privasi — Teknik Informatika (UIS)')
@section('meta_description', 'Kebijakan Privasi Portal Resmi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) Batam.')

@section('content')

@include('layouts.frontend.partials.hero-header', [
    'pageKey' => 'kebijakan-privasi',
    'defaultJudul' => 'Kebijakan Privasi',
    'defaultSubjudul' => 'Komitmen Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi Universitas Ibnu Sina (UIS) dalam melindungi privasi dan data pengunjung website.',
    'defaultBreadcrumb' => 'Kebijakan Privasi'
])

<section class="section-bg-sand py-5">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm border">
          <p class="text-muted small mb-4">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>

          <h5 class="fw-bold text-dark mb-2">1. Informasi yang Kami Kumpulkan</h5>
          <p class="text-muted mb-4">
            Portal resmi Program Studi S1 Teknik Informatika Universitas Ibnu Sina (UIS) hanya mengumpulkan informasi yang Anda berikan secara sukarela melalui formulir publik (seperti formulir testimoni alumni), mencakup nama, profesi/instansi, kategori hubungan, dan ulasan yang dikirimkan.
          </p>

          <h5 class="fw-bold text-dark mb-2">2. Penggunaan Informasi</h5>
          <p class="text-muted mb-4">
            Informasi yang dikumpulkan digunakan untuk keperluan moderasi konten, peningkatan layanan informasi akademik, serta publikasi testimoni resmi setelah melalui persetujuan administrator program studi. Kami tidak memperjualbelikan atau membagikan data pribadi Anda kepada pihak ketiga di luar keperluan akademik resmi.
          </p>

          <h5 class="fw-bold text-dark mb-2">3. Cookie & Preferensi Bahasa</h5>
          <p class="text-muted mb-4">
            Website ini menggunakan cookie sesi dasar untuk keamanan formulir (CSRF & verifikasi CAPTCHA) serta penyimpanan lokal browser untuk mengingat preferensi bahasa yang Anda pilih.
          </p>

          <h5 class="fw-bold text-dark mb-2">4. Keamanan Data</h5>
          <p class="text-muted mb-4">
            Seluruh komunikasi antara browser Anda dan server website dilindungi menggunakan koneksi aman (HTTPS) serta langkah pengamanan server untuk mencegah akses tidak sah.
          </p>

          <h5 class="fw-bold text-dark mb-2">5. Kontak & Permintaan Penghapusan Data</h5>
          <p class="text-muted mb-0">
            Apabila Anda memiliki pertanyaan mengenai kebijakan privasi ini atau ingin memperbarui/menghapus testimoni yang pernah Anda kirimkan, silakan hubungi kami melalui halaman <a href="{{ route('homepage.kontak') }}" class="fw-semibold text-dark text-decoration-underline">Kontak Program Studi</a>.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
