<?php

namespace Database\Seeders;

use App\Models\TemplateDokumen;
use Illuminate\Database\Seeder;

class TemplateDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $defaultDrive = 'https://drive.google.com/file/d/1IRByrzj6PpPYTf3xc6UkOwNdgP4WEFuT/view?usp=sharing';

        $data = [
            [
                'judul' => 'SOP Pelaksanaan Perkuliahan & Praktikum Laboratorium',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Pengisian KRS & Bimbingan Akademik (Dosen PA)',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Pengajuan & Pelaksanaan Kerja Praktik (KP)',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Seminar Proposal & Ujian Sidang Skripsi',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Pengajuan Cuti Kuliah & Aktif Kembali',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Penggunaan Fasilitas Laboratorium Komputer & Riset',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'judul' => 'SOP Pengurusan Bebas Pustaka, Yudisium & Ijazah Alumni',
                'tipe_file' => 'PDF',
                'link_drive' => $defaultDrive,
                'icon_preset' => 'pdf',
                'urutan' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            TemplateDokumen::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}

