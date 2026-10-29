<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::truncate();

        $banners = [
            [
                'judul' => 'Teknik Informatika — Unggul, Profesional & Berintegritas',
                'url' => 'banners/Tb0YYibcNvgugtIoShmS6gQJKDGqxi1fT1j7PHg9.webp',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'judul' => 'Fasilitas Laboratorium Komputasi Modern & Kurikulum Berbasis Industri',
                'url' => 'banners/XpzG6Y4oCBhFY5aFRRGgSaacuH5xuhQ8cOGVAx78.webp',
                'urutan' => 2,
                'aktif' => true,
            ],
        ];

        foreach ($banners as $b) {
            Banner::create($b);
        }
    }
}
