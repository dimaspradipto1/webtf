<?php

namespace Database\Seeders;

use App\Models\KalenderAkademikItem;
use Illuminate\Database\Seeder;

class KalenderAkademikSeeder extends Seeder
{
    public function run(): void
    {
        KalenderAkademikItem::truncate();

        $items = [
            [
                'judul_tab' => 'Kalender Akademik 2026/2027',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2026-2027',
                'gdrive_url' => 'https://drive.google.com/file/d/1IRByrzj6PpPYTf3xc6UkOwNdgP4WEFuT/view?usp=sharing',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'judul_tab' => 'Kalender Akademik 2025/2026',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2025-2026',
                'gdrive_url' => 'https://drive.google.com/open?id=13kSKrPpU6UOc797Y2CHZJiOCU0Ssp58u&usp=drive_copy',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'judul_tab' => 'Kalender Akademik 2024/2025',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2024-2025',
                'gdrive_url' => 'https://drive.google.com/open?id=13kSKrPpU6UOc797Y2CHZJiOCU0Ssp58u&usp=drive_copy',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'judul_tab' => 'Kalender Akademik 2023/2024',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2023-2024',
                'gdrive_url' => 'https://drive.google.com/file/d/1fJ9mYK8Mwm-pbCbe9K_s4WXCKPWhB0pD/view?usp=drive_link',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'judul_tab' => 'Kalender Akademik 2022/2023',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2022-2023',
                'gdrive_url' => 'https://drive.google.com/file/d/1fJ9mYK8Mwm-pbCbe9K_s4WXCKPWhB0pD/view?usp=drive_link',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'judul_tab' => 'Kalender Akademik 2021/2022',
                'nama_dokumen' => 'KALENDER AKADEMIK UIS 2021-2022',
                'gdrive_url' => 'https://drive.google.com/file/d/1iVlL7ZJ2BcfPo7dJCmPmYRub8hiRyzl3/view?usp=drive_link',
                'tombol_teks' => 'Lihat Document',
                'urutan' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            KalenderAkademikItem::create($item);
        }
    }
}

