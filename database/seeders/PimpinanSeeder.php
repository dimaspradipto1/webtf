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
        Pimpinan::truncate();

        $items = [
            // BARIS 1: Ketua Yayasan & Rektor (2 Kolom)
            [
                'nama' => 'Drg. Andi Tenri Ummu, MM',
                'slug' => 'drg-andi-tenri-ummu-mm',
                'jabatan' => 'Ketua Yayasan Pendidikan Ibnu Sina Batam (YAPISTA)',
                'foto' => 'pimpinan/ketua-yayasan.webp',
                'tempat_tanggal_lahir' => '21 Mei 1986',
                'email' => 'anditenriummu@gmail.com',
                'pendidikan' => implode("\n", [
                    'SDS Ibnu Sina Batam',
                    'SMPS Islamic Village, Tangerang',
                    'SMAS Kartini Batam',
                    'S1 FKG Universitas Prof. Dr. Moestopo (Beragama)',
                    'Profesi Universitas Prof. Dr. Moestopo (Beragama)',
                    'S2 Manajemen Fakultas Ekonomi dan Bisnis Universitas Ibnu Sina',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Pengurus Yayasan Masjid Al Falah Nagoya Batam',
                    'Pengurus PDGI Cabang Batam (2017 – saat ini)',
                    'Pengurus BMPS Kepri (2019 – saat ini)',
                    'Pengurus BMPS Kota Batam (2021 – saat ini)',
                    'Pengurus MDMC Kota Batam',
                    'Anggota KKSS Batam',
                    'Anggota APPERTI',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Direktur PT. Grosirindo KEPRI Indonesia (2009 – 2021)',
                    'Wakil Ketua 2 STIKes Ibnu Sina (2012 – 2014)',
                    'Wakil Ketua 3 STIKes Ibnu Sina (2014 – 2016)',
                    'Sekretaris Eksekutif Yayasan Pendidikan Ibnu Sina Batam (2016 – 2021)',
                    'Ketua Umum Yayasan Pendidikan Ibnu Sina Batam (2021 – saat ini)',
                    'Penanggung Jawab Klinik Ibnu Sina Batam',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Wakil Ketua 2 STIKes Ibnu Sina (2012 – 2014)',
                    'Wakil Ketua 3 STIKes Ibnu Sina (2014 – 2016)',
                    'Sekretaris Eksekutif Yayasan Pendidikan Ibnu Sina Batam (2016 – 2021)',
                    'Ketua Umum Yayasan Pendidikan Ibnu Sina Batam (2021 – saat ini)',
                ]),
                'baris' => 1,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.',
                'slug' => 'assoc-prof-dr-ir-larisang-st-mt-ipu-asean-eng',
                'jabatan' => 'Rektor Universitas Ibnu Sina (UIS)',
                'foto' => 'pimpinan/rektor.webp',
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

            // BARIS 2: Dekan & Wakil Dekan FST (3 Kolom)
            [
                'nama' => 'Assoc. Prof. Ir. Sanusi, ST., M.Eng., Ph.D., IPM',
                'slug' => 'assoc-prof-ir-sanusi-st-meng-phd-ipm',
                'jabatan' => 'Dekan Fakultas Sains & Teknologi Universitas Ibnu Sina',
                'foto' => 'pimpinan/dekan-fst.png',
                'tempat_tanggal_lahir' => 'Parit Baru Tagaraja/26 April 1984',
                'email' => 'sanusi@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'S3 Univ Tun Husein Onn Malaysia Juli 2024',
                    'Profesi Insinyur Universitas Andalas, Juli 2022 : Insinyur Profesional',
                    'S2 Univ. Teknologi Malaysia Lulus tahun 2013 : Prodi Teknik Industri',
                    'S1 Univ. Islam Negeri Sultan Syarif Kasim Riau Lulus tahun 2006 : Prodi Teknik Industri',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Pengurus PII Cabang Batam Ketua Bidang Industri Manufactur, Dirgantara dan Fabrikasi (2022-2025)',
                    'Pengurus PII Cabang Batam Bidang Asistensi sertifikasi Teknik Industri (2019-2022)',
                    'Anggota Majlis Penilai (Assesor) Insinyur Professional Badan Kejuruan Teknik Industri PII/Indonesia (2018-2021)',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Dosen Tetap Prodi Teknik Industri FT UIS 2019 – Sekarang',
                    'Dosen Tetap Prodi Teknik Industri STT Ibnu Sina 2013 – 2019',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Sekretaris Prodi Teknik Industri STT Ibnu Sina : 2015-2019',
                    'Ketua. Prodi Teknik Industri Fakultas Teknik Universitas Ibnu Sina: 2019 – 2024',
                    'Wakil Dekan I Fakultas Teknik – Universitas Ibnu Sina (UIS) April 2022- Sekarang',
                    'Dekan Fakultas Sains dan Teknologi – Universitas Ibnu Sina (UIS) 2024- Sekarang',
                ]),
                'baris' => 2,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Okta Veza, S.Kom., M.Kom',
                'slug' => 'assoc-prof-dr-okta-veza-skom-mkom',
                'jabatan' => 'Wakil Dekan I Fakultas Sains & Teknologi Universitas Ibnu Sina',
                'foto' => 'pimpinan/wadek-1-fst.png',
                'tempat_tanggal_lahir' => 'Batam/ 11 Oktober 1989',
                'email' => 'okta@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'D3 Universitas Putra Indonesia (UPI YPTK) Padang : Prodi.Manajemen Informatika',
                    'S1 STMIK Indonesia Padang : Prodi. Sistem Informasi',
                    'S2 Universitas Putra Indonesia (UPI YPTK) Padang : Prodi Teknik Informatika Konsentrasi Sistem Informasi',
                    'S3 Universitas Putra Indonesia (UPI YPTK) Padang',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'IAII – Ikatan Ahli Informatika Indonesia',
                    'APTIKOM – Asosiasi Pendidikan Tinggi Informatika dan Komputer',
                    'IAENG International Association Of Engineers',
                    'ICSES – International Computer Science And Engineering Society',
                    'Eurasia Research',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Pernah bekerja di beberapa perusahaan Nasional yang bergerak dibidang IT dan saat ini bekerja disebuah Perguruan Tinggi Swasta di Batam Sebagai Dosen Tetap di Program Studi Teknik Informatika Universitas Ibnu Sina.',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    '2015 – 2016 : Staff Laboratorium Teknik Informatika STT Ibnu Sina',
                    '2016 – 2017 : Ka. Lab Teknik Informatika STT Ibnu Sina',
                    '2017 – 2019 : Sekprodi Teknik Informatika STT Ibnu Sina',
                    '2019 – 2022 : Kaprodi Teknik Informatika Universitas Ibnu Sina',
                    '2022 – 2024 : Wakil Dekan – II Fakultas Sains dan Teknologi Universitas Ibnu Sina',
                    '2024 – Sekarang : Wakil Dekan – I Fakultas Sains dan Teknologi Universitas Ibnu Sina',
                ]),
                'baris' => 2,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Andi Hepy Susanti, S.E., MM.',
                'slug' => 'andi-hepy-susanti-se-mm',
                'jabatan' => 'Wakil Dekan II Fakultas Sains & Teknologi Universitas Ibnu Sina',
                'foto' => 'pimpinan/wadek-2-fst.png',
                'tempat_tanggal_lahir' => '-',
                'email' => 'Hepy@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'S1 Sarjana Ekonomi (S.E.)',
                    'S2 Magister Manajemen (M.M.)',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Civitas Akademika Fakultas Sains dan Teknologi Universitas Ibnu Sina',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Dosen Tetap Fakultas Sains dan Teknologi Universitas Ibnu Sina',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Wakil Dekan II Fakultas Sains dan Teknologi Universitas Ibnu Sina',
                ]),
                'baris' => 2,
                'urutan' => 3,
                'is_active' => true,
            ],

            // BARIS 3: Ketua Program Studi FST (3 Kolom)
            [
                'nama' => 'Ir. Herman, ST., MT',
                'slug' => 'ir-herman-st-mt',
                'jabatan' => 'Ketua Program Studi Teknik Industri Fakultas Sains & Teknologi',
                'foto' => 'pimpinan/pimpinan-6.webp',
                'tempat_tanggal_lahir' => 'Batujala/ 02 Juni 1982',
                'email' => 'herman@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'S1 Industri: Sekolah Tinggi Teknik Universitas Ibnu Sina',
                    'Magister Industri: Universitas Andalas',
                    'Profesi Insinyur: Universitas Andalas',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Ikatan Keluarga Alumni STT Ibnu Sina (2018-2022)',
                    'Persatuan Insinyur Indonesia (2022-sekarang)',
                    'Aliansi Nasional Indonesia Sejahtera (2022-sekarang)',
                    'UKM Wilayah Kepri (2022-sekarang)',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Owner Furniture Second Hand (2004-sekarang)',
                    'Karyawan Perusahaan VJB Devisi Teknisi (2004-2005)',
                    'Staff Laboratorium Teknik Industri STT Ibnu Sina (2011-2013)',
                    'Kepala Laboratorium Teknik Industri STT Ibnu Sina (2013-2014)',
                    'Guru SMK Insan Mandiri Batam (2013-2014)',
                    'Sekretaris Prodi Teknik Industri STT Ibnu Sina (2014-2015)',
                    'Kepala Laboratorium Teknik Industri STT Ibnu Sina (2016-2021)',
                    'Ketua Program Studi Teknik Industri FST UIS (2022-sekarang)',
                    'Dosen Teknik Industri FST UIS (2014-sekarang)',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Sekretaris Prodi Teknik Industri STT Ibnu Sina (2014-2015)',
                    'Kepala Laboratorium Teknik Industri STT Ibnu Sina (2016-2021)',
                    'Ketua Program Studi Teknik Industri FST UIS (2022-sekarang)',
                ]),
                'baris' => 3,
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'nama' => 'Dr. Army Trilidia Devega, S.Kom., M.Pd.T',
                'slug' => 'dr-army-trilidia-devega-skom-mpdt',
                'jabatan' => 'Kaprodi Teknik Informatika & (PLT) Kaprodi Sistem Informasi Fakultas Sains & Teknologi',
                'foto' => 'pimpinan/pimpinan-7.webp',
                'tempat_tanggal_lahir' => 'Pangkal Pinang/21 April 1992',
                'email' => 'army@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'S1 Univ. Putra Indonesia “YPTK” Padang 2013: Prodi Teknik Informatika',
                    'S2 Universitas Negeri Padang (UNP) 2018: Prodi Pendidikan Teknik dan Kejuruan',
                    'S3 Universitas Negeri Padang (UNP) 2024: Prodi Pendidikan Teknik dan Kejuruan',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Anggota IGI Sumsel (2014-2017)',
                    'Anggota YPSIM Banten (2021)',
                    'Anggota Asosiasi Dosen Kolaborasi Lintas Perguruan Tinggi (2021-2026)',
                    'Anggota APTIKOM Kepri (2022 – saat ini)',
                    'Pengurus Persit KCK Ranting 1 Kompi Markas Cabang Lxx Yonif Raider Khusus 136 Koorcab Rem 033 (2018 – 2021)',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Kepala Admin CV Rizky Jaya Abadi Lahat (2013-2014)',
                    'Kepala Lab Rekayasa Perangkat Lunak SMK N 1 Lahat (2014-2017)',
                    'Instruktur Akademi Komunitas Negeri (AKN) Lahat (2015 – 2018)',
                    'Kepala Labor Multimedia Fakultas Teknik UIS (2019-2022)',
                    'Ka. Prodi Teknik Informatika Fakultas Sains dan Teknologi UIS (2022 – Sekarang)',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Kepala Laboratorium Multimedia Fakultas Teknik Universitas Ibnu Sina (2019-2022)',
                    'Ketua Program Studi Teknik Informatika Fakultas Sains dan Teknologi Universitas Ibnu Sina (2022-sekarang)',
                ]),
                'baris' => 3,
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'nama' => 'Dr. Albertus Laurensius Setyabudhi, S.T., M.T',
                'slug' => 'dr-albertus-laurensius-setyabudhi-st-mt',
                'jabatan' => 'Kaprodi Teknik Logistik & (PLT) Kaprodi Teknik Perkapalan Fakultas Sains & Teknologi',
                'foto' => 'pimpinan/pimpinan-8.webp',
                'tempat_tanggal_lahir' => '-',
                'email' => 'abyan@uis.ac.id',
                'pendidikan' => implode("\n", [
                    'Master : Magister Manajemen Teknologi',
                    'Major : Technology Management',
                    'Minor : Industrial Management',
                ]),
                'pengalaman_organisasi' => implode("\n", [
                    'Lomba fisika VI',
                    'Lomba fisika VII',
                    'Pekan AIDS 2001',
                    'Program Pengarahan Pengenalan dan Kreativitas Mahasiswa Baru 2000',
                    'Graduation ceremony period I (1999/2000)',
                    'Graduation ceremony period II (1999/2000)',
                ]),
                'pengalaman_kerja' => implode("\n", [
                    'Physics Laboratory In Petra Christian University (2000 – 2003)',
                    'Mechanic technology Laboratory In Petra Christian University (1999-2000)',
                    'The Watchman of student’s examination in Petra Christian University (1999 – 2003)',
                    'Private Tutor (1999 – 2004)',
                    'Production Staff PT. Suparma Tbk. (2003 – 2005)',
                    'Chief of Division in Fillomatic Global Industries (2005)',
                    'Production Supervisor PT. Santos Jaya Abadi (2005 – 2006)',
                    'Product and System Development CV. Dirgahayu (2007)',
                    'Mechanic Engineering Supervisor CV. Dirgahayu (2007 – 2012)',
                    'Site Manager PT. Sandana (2012 – 2013)',
                    'Factory Manager PT. Samator Gas Industri Batam (2013)',
                ]),
                'riwayat_jabatan' => implode("\n", [
                    'Kaprodi Teknik Logistik & (PLT) Kaprodi Teknik Perkapalan Fakultas Sains & Teknologi Universitas Ibnu Sina',
                ]),
                'baris' => 3,
                'urutan' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            Pimpinan::create($item);
        }
    }
}
