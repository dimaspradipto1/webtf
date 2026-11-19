<?php

namespace Tests\Feature;

use App\Models\Sarana;
use App\Models\User;
use Tests\TestCase;

class FasilitasDetailTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_admin_can_create_and_update_lab_details_and_public_can_view_detail_page(): void
    {
        $admin = $this->getAdmin();
        $namaLab = 'Laboratorium Uji Cloud & DevOps ' . uniqid();
        $created = null;

        try {
            $res = $this->actingAs($admin)->post(route('sarana.store'), [
                'icon' => 'bi-cloud-check-fill',
                'nama' => $namaLab,
                'deskripsi' => 'Fasilitas praktikum komputasi awan, container, dan orkestrasi server.',
                'kepala_lab' => 'Dr. Okta Veza, S.Kom., M.Kom',
                'lokasi' => 'Gedung FST Lt. 3, R.302',
                'kapasitas' => '36 Mahasiswa',
                'daftar_perangkat' => "36 Unit Workstation Core i7\n2 Unit Server Rack Dell PowerEdge\nSwitch Managed 10 Gbps",
                'mata_kuliah_praktikum' => "Komputasi Awan\nAdministrasi Sistem Linux\nDevOps & CI/CD",
                'jadwal_pemakaian' => "Senin - Jumat: 08.00 - 17.00 WIB\nSabtu: 09.00 - 14.00 WIB",
                'urutan' => 99,
                'is_active' => 1,
            ]);

            $res->assertRedirect(route('sarana.index'));

            $created = Sarana::where('nama', $namaLab)->first();
            $this->assertNotNull($created);
            $this->assertNotEmpty($created->slug);
            $this->assertSame('Dr. Okta Veza, S.Kom., M.Kom', $created->kepala_lab);

            $detailUrl = route('homepage.fasilitas.detail', $created->slug);

            // Homepage & /fasilitas-kampus link to detail page
            $this->get(route('homepage'))
                ->assertStatus(200)
                ->assertSee($detailUrl, false)
                ->assertSee('Lihat Detail Lab');

            $this->get(route('homepage.fasilitas'))
                ->assertStatus(200)
                ->assertSee($detailUrl, false)
                ->assertSee('Lihat Detail Lab');

            // Detail page renders all laboratory details
            $this->get($detailUrl)
                ->assertStatus(200)
                ->assertSee($namaLab)
                ->assertSee('Dr. Okta Veza, S.Kom., M.Kom')
                ->assertSee('Gedung FST Lt. 3, R.302')
                ->assertSee('36 Mahasiswa')
                ->assertSee('36 Unit Workstation Core i7')
                ->assertSee('Komputasi Awan')
                ->assertSee('Senin - Jumat: 08.00 - 17.00 WIB');

            // Update lab detail
            $this->actingAs($admin)->put(route('sarana.update', $created->id), [
                'icon' => 'bi-cloud-check-fill',
                'nama' => $namaLab,
                'deskripsi' => 'Deskripsi terbaru lab cloud.',
                'kepala_lab' => 'Dr. Novi Hendri Adi, S.Kom., M.Kom',
                'lokasi' => 'Gedung FST Lt. 3, R.305',
                'kapasitas' => '40 Mahasiswa',
                'daftar_perangkat' => '40 Unit Workstation Core i9',
                'mata_kuliah_praktikum' => 'Cloud Native Architecture',
                'jadwal_pemakaian' => 'Senin - Sabtu: 08.00 - 20.00 WIB',
                'urutan' => 99,
                'is_active' => 1,
            ])->assertRedirect(route('sarana.index'));

            $created->refresh();
            $this->assertSame('Dr. Novi Hendri Adi, S.Kom., M.Kom', $created->kepala_lab);

            // Sitemap includes detail URL
            $this->get('/sitemap.xml')
                ->assertStatus(200)
                ->assertSee($detailUrl, false);
        } finally {
            if ($created) {
                $created->delete();
            }
        }
    }
}
