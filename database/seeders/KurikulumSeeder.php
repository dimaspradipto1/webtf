<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use App\Models\Layanan;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        Kurikulum::truncate();

        $prodiTF = Layanan::where('judul', 'like', '%Teknik Informatika%')->first() ?? Layanan::first();

        $tfCourses = [
            ['semester' => 1, 'kode_mk' => '1TF101', 'nama_mk' => 'Pendidikan Agama & Etika Profesi TI', 'sks' => 2, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF102', 'nama_mk' => 'Pendidikan Pancasila & Kewarganegaraan', 'sks' => 2, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF103', 'nama_mk' => 'Bahasa Indonesia & Penulisan Ilmiah', 'sks' => 2, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF104', 'nama_mk' => 'Kalkulus Informatika', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF105', 'nama_mk' => 'Pengantar Teknologi Informasi & Transformasi Digital', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF106', 'nama_mk' => 'Algoritma & Pemrograman Dasar', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 1, 'kode_mk' => '1TF107', 'nama_mk' => 'Logika Matematika & Matematika Diskrit', 'sks' => 3, 'kategori' => 'Wajib'],

            ['semester' => 2, 'kode_mk' => '2TF201', 'nama_mk' => 'Struktur Data & Algoritma Lanjut', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 2, 'kode_mk' => '2TF202', 'nama_mk' => 'Arsitektur & Organisasi Komputer', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 2, 'kode_mk' => '2TF203', 'nama_mk' => 'Aljabar Linear & Matriks', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 2, 'kode_mk' => '2TF204', 'nama_mk' => 'Sistem Basis Data', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 2, 'kode_mk' => '2TF205', 'nama_mk' => 'Sistem Operasi', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 2, 'kode_mk' => '2TF206', 'nama_mk' => 'Bahasa Inggris untuk Teknologi Informasi', 'sks' => 2, 'kategori' => 'Wajib'],

            ['semester' => 3, 'kode_mk' => '3TF301', 'nama_mk' => 'Pemrograman Berorientasi Objek (OOP)', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 3, 'kode_mk' => '3TF302', 'nama_mk' => 'Pemrograman Web Full-Stack', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 3, 'kode_mk' => '3TF303', 'nama_mk' => 'Jaringan Komputer & Komunikasi Data', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 3, 'kode_mk' => '3TF304', 'nama_mk' => 'Rekayasa Perangkat Lunak (Software Engineering)', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 3, 'kode_mk' => '3TF305', 'nama_mk' => 'Probabilitas & Statistika Komputasi', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 3, 'kode_mk' => '3TF306', 'nama_mk' => 'Interaksi Manusia & Komputer (UI/UX)', 'sks' => 2, 'kategori' => 'Wajib'],

            ['semester' => 4, 'kode_mk' => '4TF401', 'nama_mk' => 'Kecerdasan Buatan (Artificial Intelligence)', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 4, 'kode_mk' => '4TF402', 'nama_mk' => 'Pemrograman Perangkat Bergerak (Mobile Programming)', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 4, 'kode_mk' => '4TF403', 'nama_mk' => 'Keamanan Informasi & Siber (Cyber Security)', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 4, 'kode_mk' => '4TF404', 'nama_mk' => 'Analisis & Desain Sistem Berorientasi Objek', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 4, 'kode_mk' => '4TF405', 'nama_mk' => 'Pembelajaran Mesin (Machine Learning)', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 4, 'kode_mk' => '4TF406', 'nama_mk' => 'Komputasi Awan (Cloud Computing & DevOps)', 'sks' => 3, 'kategori' => 'Wajib'],

            ['semester' => 5, 'kode_mk' => '5TF501', 'nama_mk' => 'Data Science & Big Data Analytics', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 5, 'kode_mk' => '5TF502', 'nama_mk' => 'Internet of Things (IoT) & Sistem Tertanam', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 5, 'kode_mk' => '5TF503', 'nama_mk' => 'Manajemen Proyek Teknologi Informasi', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 5, 'kode_mk' => '5TF504', 'nama_mk' => 'Pengolahan Citra Digital & Computer Vision', 'sks' => 3, 'kategori' => 'Pilihan'],
            ['semester' => 5, 'kode_mk' => '5TF505', 'nama_mk' => 'Technopreneurship & Inovasi Startup Digital', 'sks' => 3, 'kategori' => 'Wajib'],
            ['semester' => 5, 'kode_mk' => '5TF506', 'nama_mk' => 'Metodologi Penelitian Informatika', 'sks' => 3, 'kategori' => 'Wajib'],

            ['semester' => 6, 'kode_mk' => '6TF601', 'nama_mk' => 'Kerja Praktik / Magang Industri', 'sks' => 4, 'kategori' => 'Wajib'],
            ['semester' => 6, 'kode_mk' => '6TF602', 'nama_mk' => 'Deep Learning & Natural Language Processing', 'sks' => 3, 'kategori' => 'Pilihan'],
            ['semester' => 6, 'kode_mk' => '6TF603', 'nama_mk' => 'Audit Sistem Informasi & Tata Kelola TI', 'sks' => 3, 'kategori' => 'Pilihan'],
            ['semester' => 6, 'kode_mk' => '6TF604', 'nama_mk' => 'Kuliah Kerja Nyata (KKN) Tematik Digital', 'sks' => 3, 'kategori' => 'Wajib'],

            ['semester' => 7, 'kode_mk' => '7TF701', 'nama_mk' => 'Proposal & Seminar Tugas Akhir', 'sks' => 2, 'kategori' => 'Wajib'],
            ['semester' => 7, 'kode_mk' => '7TF702', 'nama_mk' => 'Kapita Selekta & Sertifikasi Profesi TI', 'sks' => 2, 'kategori' => 'Wajib'],
            ['semester' => 8, 'kode_mk' => '8TF801', 'nama_mk' => 'Skripsi / Tugas Akhir Sarjana Komputer', 'sks' => 6, 'kategori' => 'Wajib'],
        ];

        foreach ($tfCourses as $idx => $c) {
            Kurikulum::create([
                'layanan_id' => $prodiTF?->id,
                'prodi_nama' => 'Program Sarjana (S1) Teknik Informatika',
                'kode_mk' => $c['kode_mk'],
                'nama_mk' => $c['nama_mk'],
                'semester' => $c['semester'],
                'sks' => $c['sks'],
                'kategori' => $c['kategori'],
                'urutan' => $idx + 1,
                'is_active' => true,
            ]);
        }
    }
}
