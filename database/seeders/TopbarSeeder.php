<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Topbar;
use Illuminate\Database\Seeder;

class TopbarSeeder extends Seeder
{
    public function run(): void
    {
        Topbar::truncate();

        $contact = Contact::first();

        Topbar::create([
            'badge_text' => 'TEKNIK INFORMATIKA',
            'marquee_text' => 'Fakultas Sains & Teknologi Universitas Ibnu Sina Fakultasnya Teknokrat Unggul — Program Studi S1 Teknik Informatika (UIS)',
            'badge_icon' => 'bi-laptop',
            'alamat' => $contact?->alamat ?? 'Jl. Teuku Umar, Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
            'jam_operasional' => 'Senin - Sabtu: 08.00 - 17.00 WIB',
            'telepon' => $contact?->no_wa ?? '081234567890',
            'email' => $contact?->email ?? 'informatika@uis.ac.id',
            'social_media' => [
                [
                    'platform' => 'Facebook',
                    'icon' => 'bi-facebook',
                    'url' => 'https://facebook.com',
                ],
                [
                    'platform' => 'Instagram',
                    'icon' => 'bi-instagram',
                    'url' => 'https://instagram.com',
                ],
                [
                    'platform' => 'YouTube',
                    'icon' => 'bi-youtube',
                    'url' => 'https://youtube.com',
                ],
            ],
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'linkedin_url' => null,
            'tiktok_url' => null,
            'is_active' => true,
        ]);
    }
}
