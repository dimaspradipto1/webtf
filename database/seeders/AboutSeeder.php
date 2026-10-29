<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::truncate();

        About::create([
            // Profil Fakultas
            'judul_profil' => 'Pusat Keunggulan Pendidikan & Pelayanan Kesehatan',
            'deskripsi_profil_1' => 'Fakultas Ilmu Kesehatan (FIKES) berdedikasi menyelenggarakan pendidikan tinggi berkualitas di bidang kesehatan dengan kurikulum modern yang berorientasi pada capaian kompetensi, riset inovatif, dan pelayanan masyarakat.',
            'deskripsi_profil_2' => 'FIKES didukung oleh tenaga pendidik berkualifikasi magister dan doktor, sarana laboratorium terpadu berstandar nasional, serta jejaring kemitraan rumah sakit pendidikan terkemuka.',

            // Visi
            'visi_judul' => 'Visi Kami',
            'visi_icon' => 'bi-eye',
            'visi' => 'Menjadi Fakultas Ilmu Kesehatan yang unggul, terkemuka, dan berdaya saing global dalam penyelenggaraan Tri Dharma Perguruan Tinggi yang berlandaskan nilai integritas dan kemanusiaan.',

            // Misi
            'misi_judul' => 'Misi Kami',
            'misi_icon' => 'bi-rocket-takeoff',
            'misi' => "Menyelenggarakan pendidikan akademik dan profesi kesehatan yang berkualitas dan berstandar nasional/internasional.\nMengembangkan penelitian terapan dan inovatif di bidang ilmu kesehatan yang bermanfaat bagi masyarakat.\nMelaksanakan pengabdian kepada masyarakat secara berkelanjutan demi meningkatkan derajat kesehatan publik.\nMenjalin kerjasama strategis dengan institusi pelayanan kesehatan, rumah sakit, dan mitra global.",

            // Nilai Budaya Civitas
            'judul_nilai' => 'Nilai Budaya Civitas',
            'deskripsi_nilai' => 'Prinsip dasar yang melandasi seluruh proses pembelajaran, riset, dan pelayanan kesehatan di lingkungan FIKES.',

            // Nilai 1 — Integritas
            'nilai_1_judul' => 'Integritas',
            'nilai_1_deskripsi' => 'Menjunjung tinggi etika profesi, moralitas luhur, dan kejujuran akademik dalam setiap pengajaran dan riset.',
            'nilai_1_icon' => 'bi-shield-fill-check',

            // Nilai 2 — Keunggulan
            'nilai_2_judul' => 'Keunggulan',
            'nilai_2_deskripsi' => 'Senantiasa meningkatkan standar mutu akademik demi mencetak lulusan tenaga kesehatan berkualifikasi unggul.',
            'nilai_2_icon' => 'bi-award-fill',

            // Nilai 3 — Humanis
            'nilai_3_judul' => 'Humanis',
            'nilai_3_deskripsi' => 'Mengedepankan rasa empati, kasih sayang, dan kepedulian tulus terhadap pasien dan masyarakat.',
            'nilai_3_icon' => 'bi-heart-fill',

            // Nilai 4 — Inovatif
            'nilai_4_judul' => 'Inovatif',
            'nilai_4_deskripsi' => 'Adaptif terhadap perkembangan sains dan teknologi kesehatan terkini dalam pendidikan dan riset terapan.',
            'nilai_4_icon' => 'bi-lightning-charge-fill',

            // Pimpinan dari Masa ke Masa (Sejarah YAPISTA)
            'sejarah_pimpinan_judul' => 'Pimpinan dari Masa ke Masa',
            'sejarah_pimpinan' => About::defaultSejarahPimpinan(),
        ]);
    }
}
