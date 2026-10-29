<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::truncate();

        $faqs = [
            // Akademik & Kurikulum
            [
                'question' => 'Apa saja bidang peminatan dan fokus keilmuan di Program Studi S1 Teknik Informatika?',
                'answer' => 'Program Studi S1 Teknik Informatika berfokus pada 3 bidang keunggulan utama: Rekayasa Perangkat Lunak (Software Engineering & Mobile Development), Kecerdasan Buatan (Artificial Intelligence & Data Science), serta Jaringan Komputer & Keamanan Siber (Cyber Security & Cloud Computing) yang diselaraskan dengan kurikulum Outcome-Based Education (OBE).',
                'category' => 'akademik',
            ],
            [
                'question' => 'Bagaimana status akreditasi Program Studi S1 Teknik Informatika?',
                'answer' => 'Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi telah terakreditasi oleh LAM-INFOKOM (Lembaga Akreditasi Mandiri Informatika dan Komputer) serta BAN-PT dengan jaminan standar mutu kurikulum nasional dan keterhubungan industri.',
                'category' => 'akademik',
            ],
            [
                'question' => 'Berapa lama masa studi dan berapa total SKS untuk lulus S1 Teknik Informatika?',
                'answer' => 'Masa studi normal dapat diselesaikan dalam 8 semester (4 tahun) dengan total beban studi 144 SKS, termasuk program Magang Industri Bersertifikat (MBKM), riset terapan, dan tugas akhir/skripsi.',
                'category' => 'akademik',
            ],

            // Pendaftaran & PMB
            [
                'question' => 'Bagaimana alur pendaftaran mahasiswa baru di S1 Teknik Informatika?',
                'answer' => 'Pendaftaran dapat dilakukan secara online melalui portal resmi PMB Teknik Informatika UIS atau datang langsung ke ruang sekretariat PMB di kampus dengan membawa fotokopi ijazah/SKL, rapor, KK/KTP, dan pas foto terbaru.',
                'category' => 'pendaftaran',
            ],
            [
                'question' => 'Apakah lulusan SMK / Non-IPA bisa mendaftar di Program Studi S1 Teknik Informatika?',
                'answer' => 'Bisa. S1 Teknik Informatika menerima lulusan SMA/SMK/MA dari semua jurusan (baik IPA, IPS, RPL, TKJ, Multimedia, maupun bidang kejuruan lainnya). Program studi menyelenggarakan matrikulasi algoritma dan dasar pemrograman bagi mahasiswa baru.',
                'category' => 'pendaftaran',
            ],
            [
                'question' => 'Apakah tersedia program beasiswa untuk mahasiswa Teknik Informatika?',
                'answer' => 'Ya, tersedia berbagai pilihan beasiswa, antara lain KIP-Kuliah (Kemendikbudristek), Beasiswa Prestasi Akademik & Kejuaraan IT/Lomba Coding, Beasiswa Yayasan Pendidikan Ibnu Sina (YAPISNA), serta beasiswa kemitraan industri.',
                'category' => 'pendaftaran',
            ],

            // Fasilitas & Laboratorium
            [
                'question' => 'Fasilitas laboratorium apa saja yang disediakan untuk mahasiswa Teknik Informatika?',
                'answer' => 'Tersedia Laboratorium Komputasi Cerdas & AI, Laboratorium Rekayasa Perangkat Lunak, Laboratorium Jaringan & Cyber Security, Studio Multimedia & Desain Grafis, serta server komputasi berkecepatan tinggi dengan koneksi internet serat optik.',
                'category' => 'fasilitas',
            ],
            [
                'question' => 'Di mana saja mahasiswa Teknik Informatika melaksanakan magang industri?',
                'answer' => 'Mahasiswa melaksanakan magang di berbagai korporasi teknologi, industri manufaktur multinasional di Batam (kawasan Batamindo, Muka Kuning, Kabil, Nongsa Digital Park), BUMN, instansi perbankan, software house, dan startup digital.',
                'category' => 'fasilitas',
            ],
            [
                'question' => 'Bagaimana prospek karir lulusan S1 Teknik Informatika?',
                'answer' => 'Lulusan memiliki prospek karir luas sebagai Software Engineer, Fullstack Web & Mobile Developer, AI & Data Scientist, Cloud & Cyber Security Specialist, Database Administrator, IT Consultant, Project Manager IT, hingga Technopreneur pendiri startup digital.',
                'category' => 'karir',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
