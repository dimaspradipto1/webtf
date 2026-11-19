<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::truncate();

        Contact::create([
            'latitude' => '1.145696',
            'longitude' => '104.0160104',
            'map' => 'https://maps.google.com/maps?q=1.145696,104.0160104&hl=id&z=16&output=embed',
            'no_wa' => '6281234567890',
            'email' => 'informatika@uis.ac.id',
            'alamat' => 'Gedung Fakultas Sains dan Teknologi (FST), Kampus Universitas Ibnu Sina, Jl. Teuku Umar, Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
            'jam_operasional' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
        ]);
    }
}
