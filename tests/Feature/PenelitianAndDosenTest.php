<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Layanan;
use App\Models\Penelitian;
use App\Models\User;
use Tests\TestCase;

class PenelitianAndDosenTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_dosen_expertise_and_sinta_scholar_links_crud_and_public_display(): void
    {
        $admin = $this->getAdmin();
        $layananId = Layanan::value('id');
        $uniqueName = 'Dr. Uji Riset TI ' . uniqid();
        $created = null;

        try {
            $res = $this->actingAs($admin)->post(route('dosen.store'), [
                'layanan_id' => $layananId,
                'nama_dosen' => $uniqueName,
                'nidn' => '1099887766',
                'jabatan_fungsional' => 'Lektor',
                'bidang_keahlian' => 'Kecerdasan Buatan & Data Science',
                'link_sinta' => 'https://sinta.kemdikbud.go.id/authors/profile/6000001',
                'link_scholar' => 'https://scholar.google.com/citations?user=TESTUSER123',
                'link' => 'https://pddikti.kemdikbud.go.id',
                'is_active' => 1,
            ]);

            $res->assertRedirect(route('dosen.index'));

            $created = Dosen::where('nama_dosen', $uniqueName)->first();
            $this->assertNotNull($created);
            $this->assertSame('Kecerdasan Buatan & Data Science', $created->bidang_keahlian);
            $this->assertSame('https://sinta.kemdikbud.go.id/authors/profile/6000001', $created->link_sinta);
            $this->assertSame('https://scholar.google.com/citations?user=TESTUSER123', $created->link_scholar);

            // Public /dosen page should display the new fields
            $public = $this->get(route('homepage.dosen'));
            $public->assertStatus(200);
            $public->assertSee($uniqueName);
            $public->assertSee('Kecerdasan Buatan &amp; Data Science', false);
            $public->assertSee('https://sinta.kemdikbud.go.id/authors/profile/6000001', false);
            $public->assertSee('https://scholar.google.com/citations?user=TESTUSER123', false);

            // Update Dosen
            $updateRes = $this->actingAs($admin)->put(route('dosen.update', $created->id), [
                'layanan_id' => $layananId,
                'nama_dosen' => $uniqueName,
                'nidn' => '1099887766',
                'jabatan_fungsional' => 'Lektor Kepala',
                'bidang_keahlian' => 'Jaringan Komputer & Keamanan Siber',
                'link_sinta' => 'https://sinta.kemdikbud.go.id/authors/profile/6000002',
                'link_scholar' => 'https://scholar.google.com/citations?user=UPDATED456',
                'link' => 'https://pddikti.kemdikbud.go.id',
                'is_active' => 1,
            ]);
            $updateRes->assertRedirect(route('dosen.index'));
            $created->refresh();
            $this->assertSame('Jaringan Komputer & Keamanan Siber', $created->bidang_keahlian);
            $this->assertSame('https://sinta.kemdikbud.go.id/authors/profile/6000002', $created->link_sinta);
        } finally {
            if ($created) {
                $created->delete();
            }
        }
    }

    public function test_penelitian_and_pengabdian_admin_crud_and_public_filters(): void
    {
        $admin = $this->getAdmin();
        $judulPenelitian = 'Deteksi Anomali Jaringan Berbasis Deep Learning ' . uniqid();
        $judulPengabdian = 'Pelatihan Literasi Digital UMKM Batam ' . uniqid();
        $judulDraft = 'Draft Penelitian Tersembunyi ' . uniqid();
        $ids = [];

        try {
            // Admin index page loads
            $this->actingAs($admin)->get(route('penelitian.index'))
                ->assertStatus(200)
                ->assertSee('Penelitian & Pengabdian Masyarakat', false);

            // Store Penelitian
            $this->actingAs($admin)->post(route('penelitian.store'), [
                'jenis' => 'penelitian',
                'judul' => $judulPenelitian,
                'ketua' => 'Assoc. Prof. Okta Veza, S.Kom., M.Kom',
                'anggota' => 'Dr. M. Ropianto, S.Kom., M.Kom',
                'sumber_dana' => 'Kemendikbudristek (DRTPM)',
                'tahun' => 2026,
                'bidang_riset' => 'Jaringan Komputer & Keamanan Siber',
                'link_publikasi' => 'https://doi.org/10.1000/test-penelitian',
                'is_active' => 1,
            ])->assertRedirect();

            // Store Pengabdian
            $this->actingAs($admin)->post(route('penelitian.store'), [
                'jenis' => 'pengabdian',
                'judul' => $judulPengabdian,
                'ketua' => 'Dr. Novi Hendri Adi, S.Kom., M.Kom',
                'anggota' => 'Tim Mahasiswa TI',
                'sumber_dana' => 'Hibah Internal UIS',
                'tahun' => 2025,
                'bidang_riset' => 'Sistem Informasi & Enterprise',
                'is_active' => 1,
            ])->assertRedirect();

            // Store inactive draft (should not appear on public page)
            $draft = Penelitian::create([
                'jenis' => 'penelitian',
                'judul' => $judulDraft,
                'ketua' => 'Dosen Draft',
                'tahun' => 2026,
                'is_active' => false,
            ]);
            $ids[] = $draft->id;

            $pen = Penelitian::where('judul', $judulPenelitian)->first();
            $abdi = Penelitian::where('judul', $judulPengabdian)->first();
            $this->assertNotNull($pen);
            $this->assertNotNull($abdi);
            $ids[] = $pen->id;
            $ids[] = $abdi->id;

            // Public page shows active items and hides draft
            $publicAll = $this->get(route('homepage.penelitian'));
            $publicAll->assertStatus(200)
                ->assertSee($judulPenelitian)
                ->assertSee($judulPengabdian)
                ->assertDontSee($judulDraft);

            // Filter by jenis=penelitian
            $this->get(route('homepage.penelitian', ['jenis' => 'penelitian']))
                ->assertStatus(200)
                ->assertSee($judulPenelitian)
                ->assertDontSee($judulPengabdian);

            // Filter by tahun=2025
            $this->get(route('homepage.penelitian', ['tahun' => 2025]))
                ->assertStatus(200)
                ->assertSee($judulPengabdian)
                ->assertDontSee($judulPenelitian);

            // Update Penelitian
            $judulUpdated = $judulPenelitian . ' (Revisi)';
            $this->actingAs($admin)->put(route('penelitian.update', $pen->id), [
                'jenis' => 'penelitian',
                'judul' => $judulUpdated,
                'ketua' => $pen->ketua,
                'anggota' => $pen->anggota,
                'sumber_dana' => 'Hibah Nasional',
                'tahun' => 2026,
                'bidang_riset' => $pen->bidang_riset,
                'link_publikasi' => $pen->link_publikasi,
                'is_active' => 1,
            ])->assertRedirect();

            $pen->refresh();
            $this->assertSame($judulUpdated, $pen->judul);
            $this->assertSame('Hibah Nasional', $pen->sumber_dana);

            // Delete Penelitian
            $this->actingAs($admin)->delete(route('penelitian.destroy', $pen->id))
                ->assertRedirect(route('penelitian.index'));
            $this->assertDatabaseMissing('penelitians', ['id' => $pen->id]);

            // Sitemap includes /penelitian-pengabdian
            $this->get('/sitemap.xml')
                ->assertStatus(200)
                ->assertSee(route('homepage.penelitian'), false);
        } finally {
            Penelitian::whereIn('id', $ids)->delete();
        }
    }
}
