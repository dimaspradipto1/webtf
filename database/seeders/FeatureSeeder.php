<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feature::truncate();

        $features = [
            [
                'icon' => 'bi-book-half',
                'judul' => 'Kurikulum Berbasis Industri & AI',
                'deskripsi' => 'Materi kuliah diselaraskan dengan kebutuhan industri teknologi informasi, rekayasa perangkat lunak, kecerdasan buatan, dan standar kompetensi global.',
                'urutan' => 1,
            ],
            [
                'icon' => 'bi-person-video3',
                'judul' => 'Dosen Ahli & Praktisi TI',
                'deskripsi' => 'Diajar langsung oleh akademisi berkualifikasi magister (S2), doktor (S3), dan praktisi industri berpengalaman di bidang pengembangan software, jaringan, dan keamanan siber.',
                'urutan' => 2,
            ],
            [
                'icon' => 'bi-cpu-fill',
                'judul' => 'Laboratorium Komputasi Mutakhir',
                'deskripsi' => 'Dilengkapi laboratorium pemrograman, komputasi AI & data science, jaringan komputer Cisco, serta fasilitas riset teknologi informasi modern.',
                'urutan' => 3,
            ],
            [
                'icon' => 'bi-buildings-fill',
                'judul' => '100+ Mitra Industri & Korporasi',
                'deskripsi' => 'Kerjasama magang, proyek riset, dan penempatan kerja luas di kawasan industri Batamindo, Panbil, perusahaan teknologi, BUMN, dan instansi perbankan.',
                'urutan' => 4,
            ],
            [
                'icon' => 'bi-stars',
                'judul' => 'Karakter Imtaq & Technopreneur',
                'deskripsi' => 'Pembinaan karakter profesional muda yang jujur, amanah, berjiwa wirausaha digital mandiri, serta berlandaskan keimanan dan ketaqwaan.',
                'urutan' => 5,
            ],
            [
                'icon' => 'bi-award-fill',
                'judul' => 'Sertifikasi Kompetensi SKPI & BNSP',
                'deskripsi' => 'Kesempatan memperoleh Surat Keterangan Pendamping Ijazah (SKPI) dan sertifikasi kompetensi keahlian bidang TI berstandar nasional maupun internasional.',
                'urutan' => 6,
            ],
        ];

        foreach ($features as $f) {
            Feature::create($f);
        }
    }
}
