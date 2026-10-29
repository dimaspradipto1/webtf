<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Layanan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $layanans = [
            [
                'icon' => 'bi-laptop',
                'judul' => 'Program Sarjana (S1) Teknik Informatika',
                'slug' => 's1-teknik-informatika',
                'dasar_hukum' => 'SK LAMINFOKOM & Kemdiktisaintek RI',
                'link' => '/kurikulum',
                'deskripsi' => 'Program Studi Sarjana (S1) Teknik Informatika — Fakultas Sains dan Teknologi menyelenggarakan pendidikan tinggi komputer yang berfokus pada Rekayasa Perangkat Lunak (Software Engineering), Kecerdasan Buatan (Artificial Intelligence & Data Science), serta Jaringan & Keamanan Siber (Cyber Security).',
                'rincian' => "Kurikulum berbasis Outcome-Based Education (OBE) standar LAMINFOKOM\nPeminatan: Software Engineering, Artificial Intelligence, & Cyber Security\nLaboratorium Komputasi Cerdas, Jaringan Komputer, & Rekayasa Perangkat Lunak\nSertifikasi kompetensi industri (BNSP, Cisco, Mikrotik, Cloud & AI)",
                'urutan' => 1,
                'aktif' => true,
            ],
        ];

        foreach ($layanans as $l) {
            Layanan::create($l);
        }
    }
}
