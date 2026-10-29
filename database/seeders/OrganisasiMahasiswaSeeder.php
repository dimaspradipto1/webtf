<?php

namespace Database\Seeders;

use App\Models\OrganisasiMahasiswa;
use Illuminate\Database\Seeder;

class OrganisasiMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        OrganisasiMahasiswa::truncate();

        $ormawas = [
            [
                'nama_organisasi' => 'Himpunan Mahasiswa Teknik Informatika',
                'singkatan' => 'HIMA-TI',
                'slug' => 'hima-ti',
                'kategori' => 'Himpunan Mahasiswa (HIMA)',
                'deskripsi' => '<p>Himpunan Mahasiswa Teknik Informatika (HIMA-TI) Fakultas Sains dan Teknologi UIS adalah wadah utama kreasi, riset teknologi, pengasahan skill software engineering, kecerdasan buatan (AI), serta kepemimpinan mahasiswa program studi S1 Teknik Informatika.</p>',
                'visi' => 'Menjadi himpunan mahasiswa informatika yang inovatif, berdaya saing global, berjiwa technopreneur, dan berakhlak mulia berlandaskan nilai Imtaq.',
                'misi' => "1. Menyelenggarakan bootcamp coding, riset AI, dan workshop sertifikasi industri.\n2. Mengembangkan proyek perangkat lunak dan solusi digital terapan untuk masyarakat.\n3. Membangun jejaring kolaborasi dengan alumni dan industri teknologi nasional maupun internasional.",
                'nama_ketua' => 'Muhammad Fadhil Pratama',
                'nama_wakil' => 'Nabila Putri Az-Zahra',
                'pembina' => 'Dr. Army Trilidia D, S.Kom, M.Pd.T',
                'periode' => '2025/2026',
                'logo' => 'organisasi/logo/EUrbnRcN03u0971kfNt3tHWLsgIOiFDkk13VVebi.png',
                'instagram' => 'https://instagram.com/himati_uis',
                'email' => 'himati@uis.ac.id',
                'link_pendaftaran' => 'https://bit.ly/OpenRecruitmentHIMATI',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama_organisasi' => 'Badan Eksekutif Mahasiswa Fakultas Sains & Teknologi',
                'singkatan' => 'BEM FST',
                'slug' => 'bem-fst',
                'kategori' => 'BEM / DPM',
                'deskripsi' => '<p>BEM Fakultas Sains dan Teknologi merupakan lembaga eksekutif mahasiswa tertinggi di tingkat fakultas yang mewadahi advokasi mahasiswa, sinergi prodi, kegiatan sosial kemasyarakatan, serta penyelenggaraan event teknologi tahunan.</p>',
                'visi' => 'Mewujudkan BEM FST yang progresif, kolaboratif, aspiratif, dan berintegritas tinggi dalam memajukan peradaban sains dan teknologi.',
                'misi' => "1. Mengoptimalkan advokasi dan pelayanan kesejahteraan mahasiswa sains dan teknologi.\n2. Menghadirkan festival inovasi dan pameran karya teknologi mahasiswa (TechFest).\n3. Mempererat sinergi harmonis antar lembaga kemahasiswaan se-fakultas.",
                'nama_ketua' => 'Arya Danendra',
                'nama_wakil' => 'Salsabila Rahma',
                'pembina' => 'Dosen Pembina Kemahasiswaan FST',
                'periode' => '2025/2026',
                'logo' => null,
                'instagram' => 'https://instagram.com/bemfst_uis',
                'email' => 'bem.fst@uis.ac.id',
                'link_pendaftaran' => 'https://bit.ly/DaftarBEMFST',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama_organisasi' => 'Informatika Cyber Security & Coding Club',
                'singkatan' => 'IC3 UIS',
                'slug' => 'ic3-uis',
                'kategori' => 'Unit Kegiatan Mahasiswa (UKM)',
                'deskripsi' => '<p>IC3 UIS adalah komunitas minat bakat khusus mahasiswa Teknik Informatika yang mendalami keamanan siber, ethical hacking, capture-the-flag (CTF), web & mobile app development, serta competitive programming.</p>',
                'visi' => 'Mencetak talenta cyber security dan software developer tangguh yang siap bersaing dalam kompetisi nasional dan industri internasional.',
                'misi' => "1. Mengadakan latihan mingguan CTF (Capture The Flag) dan bug bounty hunt.\n2. Pelatihan intensif fullstack web dan mobile application.\n3. Mengikuti ajang kompetisi GEMASTIK, ICPC, dan kompetisi cyber internasional.",
                'nama_ketua' => 'Reza Firmansyah',
                'nama_wakil' => 'Dimas Aditya',
                'pembina' => 'Dosen Ahli Jaringan & Keamanan Siber',
                'periode' => '2025/2026',
                'logo' => null,
                'instagram' => 'https://instagram.com/ic3_uis',
                'email' => 'ic3@uis.ac.id',
                'link_pendaftaran' => 'https://bit.ly/JoinIC3UIS',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'nama_organisasi' => 'Google Developer Student Club & AI Society',
                'singkatan' => 'GDSC & AI',
                'slug' => 'gdsc-ai',
                'kategori' => 'Komunitas Minat Bakat',
                'deskripsi' => '<p>Komunitas developer mahasiswa berbasis kampus binaan Google Developers yang berfokus pada teknologi Google Cloud, TensorFlow, Machine Learning, Flutter, dan solusi digital bagi UMKM & industri di Batam.</p>',
                'visi' => 'Menjadi inkubator inovator digital dan technopreneur muda berbasis AI dan teknologi modern di Kepulauan Riau.',
                'misi' => "1. Menyelenggarakan Google Solution Challenge dan hackathon tahunan.\n2. Membimbing mahasiswa dalam penguasaan Cloud Computing dan Data Science.\n3. Membangun kolaborasi nyata dengan ekosistem startup dan korporasi teknologi.",
                'nama_ketua' => 'Farhan Maulana',
                'nama_wakil' => 'Siti Nurhaliza',
                'pembina' => 'Dosen Pembina Google Developer Group',
                'periode' => '2025/2026',
                'logo' => null,
                'instagram' => 'https://instagram.com/gdsc_uis',
                'email' => 'gdsc@uis.ac.id',
                'link_pendaftaran' => 'https://bit.ly/JoinGDSCUIS',
                'urutan' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($ormawas as $item) {
            OrganisasiMahasiswa::create($item);
        }
    }
}
