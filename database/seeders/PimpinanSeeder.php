<?php

namespace Database\Seeders;

use App\Models\Pimpinan;
use Illuminate\Database\Seeder;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Drg. Andi Tenri Ummu, MM',
                'slug' => 'drg-andi-tenri-ummu-mm',
                'jabatan' => 'Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)',
                'foto' => 'pimpinan/ketua-yayasan.jpg',
                'tempat_tanggal_lahir' => '-',
                'email' => 'yayasan@uis.ac.id',
                'pendidikan' => "S1 Kedokteran Gigi (drg.)\nS2 Magister Manajemen (MM)",
                'pengalaman_organisasi' => "Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)",
                'pengalaman_kerja' => "Pimpinan Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)",
                'riwayat_jabatan' => "Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)",
                'baris' => 1,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.',
                'slug' => 'assoc-prof-dr-ir-larisang-st-mt-ipu-asean-eng',
                'jabatan' => 'Rektor Universitas Ibnu Sina (UIS)',
                'foto' => 'pimpinan/rektor.jpg',
                'tempat_tanggal_lahir' => 'Enrekang/13 Mei 1965',
                'email' => 'larisang@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'S1 Univ. Muslim Indonesia (UMI) Makassar 1992 : Prodi Teknik Industri',
                    'S2 Institute Teknologi Surabaya (ITS) Maret 2003. : Prodi Teknik Industri',
                    'S3 Universitas Negeri Padang (UNP) Sept 2020 : Teknologi Terapan',
                    'Profesi Insinyur Universitas Andalas, Juli 2022 : Insinyur Profesional',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Ketua Himpunan Mahasiswa Teknik Industri FTI-UMI Makassar 1987-1988',
                    'Ketua BEM FTI-UMI Makassar 1988 – 1992',
                    'Ketua Himpunan Mahasiswa Islam (HMI) Komisariat FTI-UMI Makassar 1988 – 1992',
                    'Ketua Ikatan Alumni FTI UMI Makassar 1992- 1997',
                    'Ketua LSM Lembaga Pemberdayaan Masyarakat Indonesia 1995-1999',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Dosen FTI-UMI Makassar 1992 – 1997',
                    'Dosen Tetap UIM Makassar 2003 – 2009',
                    'Dosen PNS DIKTI 2004 – Sekarang',
                    'Dosen Tetap DPK pada Univ. Ibnu Sina 2009 – sekarang',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Kepala Laboratorium APK – Fakultas Teknologi Industri – Universitas Muslim Indonesia (UMI) Makassar 1992-1995',
                    'Kepala Laboratorium Fak. Teknik – Universitas Islam Makassar (UIM) 2003 sd 2005',
                    'Ketua. Prodi Teknik Industri dan Elektro – Universitas Islam Makassar (UIM) 2004 sd 2006',
                    'Wakil Dekan I dan III Fakultas Teknik – Universitas Islam Makassar (UIM) 2006 -2009',
                    'Wakil Dekan I Sekolah Tinggi Teknik Ibnu Sina (STT) Batam 2009-2011',
                    'Ketua Sekolah Tinggi Teknik Ibnu Sina Batam (STT) 2011 SD 2019',
                    'Dekan Fak Teknik Universitas Ibnu Sina Batam (UIS) 2019 – 2024',
                    'Rektor Universitas Ibnu Sina Batam (UIS) 2024 – Sekarang',
                ]),
                'baris' => 1,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Assoc. Prof. Ir. Sanusi, ST., M.Eng., Ph.D., IPM',
                'slug' => 'assoc-prof-ir-sanusi-st-meng-phd-ipm',
                'jabatan' => 'Dekan Fakultas Sains dan Teknologi',
                'foto' => 'pimpinan/dekan-fst.jpg',
                'tempat_tanggal_lahir' => '-',
                'email' => 'sanusi@uis.ac.id',
                'pendidikan' => "S1 Sarjana Teknik (S.T.)\nS2 Master of Engineering (M.Eng.)\nS3 Doctor of Philosophy (Ph.D.)\nProfesi Insinyur (Ir., IPM)",
                'pengalaman_organisasi' => "Persatuan Insinyur Indonesia (PII)",
                'pengalaman_kerja' => "Dosen Tetap Fakultas Sains dan Teknologi Universitas Ibnu Sina",
                'riwayat_jabatan' => "Dekan Fakultas Sains dan Teknologi (FST) Universitas Ibnu Sina (2025 – Sekarang)",
                'baris' => 2,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Okta Veza, S.Kom., M.Kom',
                'slug' => 'assoc-prof-dr-okta-veza-skom-mkom',
                'jabatan' => 'Wakil Dekan I Fakultas Sains dan Teknologi',
                'foto' => 'pimpinan/wadek-1-fst.jpg',
                'tempat_tanggal_lahir' => '-',
                'email' => 'oktaveza@uis.ac.id',
                'pendidikan' => "S1 Sarjana Komputer (S.Kom)\nS2 Magister Komputer (M.Kom)\nS3 Doktor (Dr.)",
                'pengalaman_organisasi' => "Asosiasi Pendidikan Tinggi Informatika dan Komputer (APTIKOM)",
                'pengalaman_kerja' => "Dosen Tetap Program Studi Teknik Informatika — Fakultas Sains dan Teknologi",
                'riwayat_jabatan' => "Wakil Dekan I Fakultas Sains dan Teknologi Universitas Ibnu Sina",
                'baris' => 2,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Andi Hepy Susanti, S.E., MM.',
                'slug' => 'andi-hepy-susanti-se-mm',
                'jabatan' => 'Wakil Dekan II Fakultas Sains dan Teknologi',
                'foto' => 'pimpinan/wadek-2-fst.jpg',
                'tempat_tanggal_lahir' => '-',
                'email' => 'andihepy@uis.ac.id',
                'pendidikan' => "S1 Sarjana Ekonomi (S.E.)\nS2 Magister Manajemen (M.M.)",
                'pengalaman_organisasi' => "Civitas Akademika Fakultas Sains dan Teknologi Universitas Ibnu Sina",
                'pengalaman_kerja' => "Dosen Tetap Fakultas Sains dan Teknologi Universitas Ibnu Sina",
                'riwayat_jabatan' => "Wakil Dekan II Fakultas Sains dan Teknologi Universitas Ibnu Sina",
                'baris' => 2,
                'urutan' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            Pimpinan::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}

