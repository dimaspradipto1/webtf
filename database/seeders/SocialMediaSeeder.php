<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use App\Models\SocialMediaSetting;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMediaSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'IKUTI FAKULTAS SAINS DAN TEKNOLOGI DI MEDIA SOSIAL',
                'subjudul_seksi' => 'Dapatkan update terbaru, berita inspiratif, dan berbagai informasi menarik lainnya langsung dari platform media sosial kami. Jangan lewatkan momen penting dari Fakultas Sains dan Teknologi, klik ikon di bawah untuk terhubung sekarang juga!',
            ]
        );

        $items = [
            ['nama' => 'TikTok', 'icon' => 'bi-tiktok', 'url' => 'https://tiktok.com/@universitasibnusina', 'urutan' => 1, 'is_active' => true],
            ['nama' => 'Facebook', 'icon' => 'bi-facebook', 'url' => 'https://facebook.com/universitasibnusina', 'urutan' => 2, 'is_active' => true],
            ['nama' => 'Instagram', 'icon' => 'bi-instagram', 'url' => 'https://instagram.com/universitasibnusina', 'urutan' => 3, 'is_active' => true],
            ['nama' => 'WhatsApp', 'icon' => 'bi-whatsapp', 'url' => 'https://wa.me/628123456789', 'urutan' => 4, 'is_active' => true],
            ['nama' => 'YouTube', 'icon' => 'bi-youtube', 'url' => 'https://youtube.com/@universitasibnusina', 'urutan' => 5, 'is_active' => true],
            ['nama' => 'LinkedIn', 'icon' => 'bi-linkedin', 'url' => 'https://linkedin.com/school/universitasibnusina', 'urutan' => 6, 'is_active' => true],
            ['nama' => 'Peta Lokasi Kampus', 'icon' => 'bi-map', 'url' => 'https://maps.google.com/?q=Universitas+Ibnu+Sina+Batam', 'urutan' => 7, 'is_active' => true],
        ];

        foreach ($items as $item) {
            SocialMedia::firstOrCreate(['nama' => $item['nama']], $item);
        }
    }
}
