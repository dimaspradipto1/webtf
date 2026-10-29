<?php

namespace Database\Seeders;

use App\Models\AkreditasiDokumen;
use Illuminate\Database\Seeder;

class AkreditasiDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $defaultDrive = 'https://drive.google.com/file/d/1IRByrzj6PpPYTf3xc6UkOwNdgP4WEFuT/view?usp=sharing';

        $data = [
            // Tab 1: Instrumen Akreditasi
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'Kebijakan SPMI',
                'gdrive_url' => $defaultDrive,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'Manual SPMI (Manual PPEPP)',
                'gdrive_url' => $defaultDrive,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'Dokumen Standar SPMI beserta indikatornya',
                'gdrive_url' => $defaultDrive,
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'Formulir / Borang SPMI',
                'gdrive_url' => $defaultDrive,
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'SK Rektor penetapan Kebijakan, Manual, Standar, dan Formulir SPMI',
                'gdrive_url' => $defaultDrive,
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'instrumen',
                'nama_tab' => 'Instrumen Akreditasi',
                'grup' => '1.a Efektivitas SPMI – Ketersediaan dokumen Penetapan standar dan indikatornya',
                'nama_dokumen' => 'Standar/indikator turunan di tingkat UPPS dan Prodi',
                'gdrive_url' => $defaultDrive,
                'urutan' => 6,
                'is_active' => true,
            ],

            // Tab 2: Kelengkapan Dokumen
            [
                'kategori_tab' => 'kelengkapan',
                'nama_tab' => 'Kelengkapan Dokumen Teknik Informatika',
                'grup' => null,
                'nama_dokumen' => 'Buku Panduan Akademik Tahun Terbaru',
                'gdrive_url' => $defaultDrive,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'kelengkapan',
                'nama_tab' => 'Kelengkapan Dokumen Teknik Informatika',
                'grup' => null,
                'nama_dokumen' => 'Peraturan Perkuliahan dan Sistem Penilaian',
                'gdrive_url' => $defaultDrive,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'kelengkapan',
                'nama_tab' => 'Kelengkapan Dokumen Teknik Informatika',
                'grup' => null,
                'nama_dokumen' => 'Panduan PKKMB (Pengenalan Kehidupan Kampus bagi Mahasiswa Baru)',
                'gdrive_url' => $defaultDrive,
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'kelengkapan',
                'nama_tab' => 'Kelengkapan Dokumen Teknik Informatika',
                'grup' => null,
                'nama_dokumen' => 'Buku Pedoman dan Panduan Tracer Study',
                'gdrive_url' => $defaultDrive,
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'kelengkapan',
                'nama_tab' => 'Kelengkapan Dokumen Teknik Informatika',
                'grup' => null,
                'nama_dokumen' => 'Dokumentasi Sosialisasi kepada mahasiswa dan stakeholder',
                'gdrive_url' => $defaultDrive,
                'urutan' => 5,
                'is_active' => true,
            ],

            // Sertifikat Akreditasi
            [
                'kategori_tab' => 'sertifikat',
                'nama_tab' => 'Sertifikat Akreditasi',
                'grup' => null,
                'nama_dokumen' => 'Sertifikat Akreditasi Teknik Informatika',
                'gdrive_url' => $defaultDrive,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'sertifikat',
                'nama_tab' => 'Sertifikat Akreditasi',
                'grup' => null,
                'nama_dokumen' => 'Sertifikat Akreditasi Teknik Industri',
                'gdrive_url' => $defaultDrive,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'sertifikat',
                'nama_tab' => 'Sertifikat Akreditasi',
                'grup' => null,
                'nama_dokumen' => 'Sertifikat Akreditas Logistik',
                'gdrive_url' => $defaultDrive,
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'sertifikat',
                'nama_tab' => 'Sertifikat Akreditasi',
                'grup' => null,
                'nama_dokumen' => 'Sertifikat Teknik Perkapalan',
                'gdrive_url' => $defaultDrive,
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'kategori_tab' => 'sertifikat',
                'nama_tab' => 'Sertifikat Akreditasi',
                'grup' => null,
                'nama_dokumen' => 'Sertifikat Sitem Informasi',
                'gdrive_url' => $defaultDrive,
                'urutan' => 5,
                'is_active' => true,
            ],
        ];

        AkreditasiDokumen::truncate();

        foreach ($data as $item) {
            AkreditasiDokumen::create($item);
        }
    }
}

