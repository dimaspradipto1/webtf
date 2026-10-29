<?php

namespace Database\Seeders;

use App\Models\VisiMisi;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisiMisi::truncate();

        $data = [
            // VISI
            [
                'tipe' => 'visi',
                'isi' => 'Menjadi Program Studi Teknik Informatika yang unggul, bermartabat, bereputasi nasional dan internasional di bidang Rekayasa Perangkat Lunak, Kecerdasan Buatan, dan Jaringan Komputer serta berjiwa Technopreneur berbasis Imtaq.',
                'urutan' => 1,
            ],

            // MISI
            [
                'tipe' => 'misi',
                'isi' => 'Menyelenggarakan pendidikan dan pengajaran berkualitas di bidang Teknik Informatika berbasis Outcome-Based Education (OBE) untuk menghasilkan lulusan yang kompeten, profesional, berjiwa technopreneur, dan berakhlak mulia.',
                'urutan' => 1,
            ],
            [
                'tipe' => 'misi',
                'isi' => 'Melaksanakan penelitian inovatif dan terapan di bidang rekayasa perangkat lunak, kecerdasan buatan (AI), data science, dan jaringan komputer yang bernilai guna bagi industri dan masyarakat.',
                'urutan' => 2,
            ],
            [
                'tipe' => 'misi',
                'isi' => 'Melaksanakan pengabdian kepada masyarakat berbasis teknologi informasi yang berdaya guna dalam meningkatkan literasi dan transformasi digital masyarakat.',
                'urutan' => 3,
            ],
            [
                'tipe' => 'misi',
                'isi' => 'Menjalin kerjasama strategis dan berkelanjutan dengan dunia usaha dan dunia industri (DUDI), asosiasi profesi TI, serta institusi pendidikan di tingkat nasional dan internasional.',
                'urutan' => 4,
            ],

            // TUJUAN
            [
                'tipe' => 'tujuan',
                'isi' => 'Menghasilkan lulusan Sarjana Komputer (S.Kom) yang unggul dan berdaya saing tinggi di bidang Rekayasa Perangkat Lunak, Kecerdasan Buatan (AI), dan Jaringan Komputer serta berjiwa technopreneur berbasis Imtaq.',
                'urutan' => 1,
            ],
            [
                'tipe' => 'tujuan',
                'isi' => 'Menghasilkan karya penelitian ilmiah dan produk inovasi teknologi informasi yang terpublikasi di tingkat nasional maupun internasional serta mendukung kebutuhan dunia industri.',
                'urutan' => 2,
            ],
            [
                'tipe' => 'tujuan',
                'isi' => 'Mewujudkan kontribusi nyata sivitas akademika melalui program pengabdian kepada masyarakat dalam mempercepat transformasi dan kemandirian digital masyarakat.',
                'urutan' => 3,
            ],
            [
                'tipe' => 'tujuan',
                'isi' => 'Mewujudkan tata kelola program studi yang kredibel, transparan, akuntabel, serta memperluas jejaring kemitraan strategis dengan DUDI dan perguruan tinggi di dalam maupun luar negeri.',
                'urutan' => 4,
            ],

            // SASARAN
            [
                'tipe' => 'sasaran',
                'isi' => 'Peningkatan mutu kurikulum berbasis Outcome-Based Education (OBE) dan MBKM, ketepatan masa studi mahasiswa, serta persentase serapan lulusan di dunia kerja dan wirausaha teknologi (technopreneur).',
                'urutan' => 1,
            ],
            [
                'tipe' => 'sasaran',
                'isi' => 'Peningkatan kuantitas dan kualitas publikasi ilmiah dosen dan mahasiswa pada jurnal nasional terakreditasi (SINTA) dan jurnal internasional bereputasi, serta perolehan Hak Kekayaan Intelektual (HKI).',
                'urutan' => 2,
            ],
            [
                'tipe' => 'sasaran',
                'isi' => 'Peningkatan jumlah kegiatan Pengabdian kepada Masyarakat (PkM) berbasis penerapan solusi teknologi informasi tepat guna bagi instansi, UMKM, dan masyarakat luas.',
                'urutan' => 3,
            ],
            [
                'tipe' => 'sasaran',
                'isi' => 'Peningkatan mutu sumber daya manusia (dosen bersertifikasi pendidik dan kompetensi keahlian TI), kelengkapan sarana laboratorium komputer, serta implementasi kerjasama aktif (MoU/MoA/IA) di tingkat nasional dan internasional.',
                'urutan' => 4,
            ],
        ];

        foreach ($data as $item) {
            VisiMisi::create($item);
        }
    }
}
