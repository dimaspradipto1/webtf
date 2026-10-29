<?php

namespace Database\Seeders;

use App\Models\Unduhan;
use Illuminate\Database\Seeder;

class UnduhanSeeder extends Seeder
{
    public function run(): void
    {
        $defaultDrive = 'https://drive.google.com/file/d/1IRByrzj6PpPYTf3xc6UkOwNdgP4WEFuT/view?usp=sharing';

        $data = [
            [
                'judul' => 'Pedoman Akademik FST',
                'kategori' => 'Dokumen',
                'file_url' => $defaultDrive,
                'file_size' => '2.5 MB',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'judul' => 'Pedoman PMB',
                'kategori' => 'Dokumen',
                'file_url' => $defaultDrive,
                'file_size' => '1.8 MB',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'judul' => 'Pedoman Tata Tertib Kehidupan Mahasiswa',
                'kategori' => 'Dokumen',
                'file_url' => $defaultDrive,
                'file_size' => '1.2 MB',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'judul' => 'Panduan Kerja Praktek (KP)',
                'kategori' => 'Panduan',
                'file_url' => $defaultDrive,
                'file_size' => '3.4 MB',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'judul' => 'Panduan Kuliah Pengabdian Masyarakat (KPM)',
                'kategori' => 'Panduan',
                'file_url' => $defaultDrive,
                'file_size' => '2.9 MB',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'judul' => 'Panduan Penulisan Skripsi',
                'kategori' => 'Panduan',
                'file_url' => $defaultDrive,
                'file_size' => '4.1 MB',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'judul' => 'Panduan Laporan Praktikum',
                'kategori' => 'Panduan',
                'file_url' => $defaultDrive,
                'file_size' => '2.0 MB',
                'urutan' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            Unduhan::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}
