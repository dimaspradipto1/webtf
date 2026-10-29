<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Layanan;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        Dosen::truncate();

        $prodiTF = Layanan::where('judul', 'like', '%Teknik Informatika%')->first() ?? Layanan::first();

        $tfDosens = [
            ['nama_dosen' => 'Assoc. Prof. Dr. Ir. Larisang, S.T., M.T., IPU., ASEAN Eng.', 'jabatan_fungsional' => 'Lektor Kepala', 'nidn' => '1012057501', 'nuptk' => '7544753655110012'],
            ['nama_dosen' => 'Dr. Ir. H. M. Ansyar Bora, S.T., M.T., IPM', 'jabatan_fungsional' => 'Lektor Kepala', 'nidn' => '1018087801', 'nuptk' => '8150756658110023'],
            ['nama_dosen' => 'Okta Veza, S.Kom., M.Kom', 'jabatan_fungsional' => 'Lektor / Kaprodi Teknik Informatika', 'nidn' => '1024108801', 'nuptk' => '6356766667110034'],
            ['nama_dosen' => 'M. Ropianto, S.Kom., M.Kom', 'jabatan_fungsional' => 'Lektor', 'nidn' => '1015038402', 'nuptk' => '5647762663110045'],
            ['nama_dosen' => 'Novi Hendri Adi, S.Kom., M.Kom', 'jabatan_fungsional' => 'Lektor', 'nidn' => '1009118601', 'nuptk' => '4441764665110056'],
            ['nama_dosen' => 'Fadli Suandi, S.T., M.Kom', 'jabatan_fungsional' => 'Lektor', 'nidn' => '1021048503', 'nuptk' => '3753763664110067'],
            ['nama_dosen' => 'Ririt Dwiputri Permatasari, S.T., M.SI', 'jabatan_fungsional' => 'Lektor', 'nidn' => '1014078702', 'nuptk' => '2046765666210078'],
            ['nama_dosen' => 'Ahmad Hamdan, S.Kom., M.Kom', 'jabatan_fungsional' => 'Asisten Ahli', 'nidn' => '1005099001', 'nuptk' => '1237768669110089'],
        ];

        foreach ($tfDosens as $idx => $d) {
            Dosen::create([
                'layanan_id' => $prodiTF?->id,
                'prodi_nama' => 'Program Sarjana (S1) Teknik Informatika',
                'nama_dosen' => $d['nama_dosen'],
                'jabatan_fungsional' => $d['jabatan_fungsional'],
                'nidn' => $d['nidn'],
                'nuptk' => $d['nuptk'],
                'link' => 'https://pddikti.kemdiktisaintek.go.id',
                'urutan' => $idx + 1,
                'is_active' => true,
            ]);
        }
    }
}
