<?php

namespace Tests\Feature;

use App\Models\HomepageStat;
use App\Models\User;
use Tests\TestCase;

class HomepageStatTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_homepage_displays_stats_band_below_hero_and_above_sambutan(): void
    {
        $res = $this->get(route('homepage'));
        $res->assertStatus(200);

        $html = $res->getContent();
        $this->assertStringContainsString('id="statistik-beranda"', $html);
        $this->assertStringContainsString('Mahasiswa Aktif', $html);
        $this->assertStringContainsString('Dosen Tetap', $html);
        $this->assertStringContainsString('Akreditasi', $html);

        $posHero = strpos($html, 'id="heroCarousel"');
        $posStat = strpos($html, 'id="statistik-beranda"');
        $posSambutan = strpos($html, 'Sambutan Ketua Program Studi');

        $this->assertNotFalse($posStat);
        if ($posHero !== false) {
            $this->assertGreaterThan($posHero, $posStat, 'Statistik harus berada di bawah Banner Hero.');
        }
        if ($posSambutan !== false) {
            $this->assertLessThan($posSambutan, $posStat, 'Statistik harus berada di atas Sambutan Kaprodi.');
        }
    }

    public function test_admin_can_manage_homepage_stats(): void
    {
        $admin = $this->getAdmin();
        $uniqueLabel = 'Lab Riset Uji ' . uniqid();
        $created = null;

        try {
            $this->actingAs($admin)->get(route('homepage-stat.index'))
                ->assertStatus(200)
                ->assertSee('Angka Statistik Beranda');

            // Create new stat item
            $this->actingAs($admin)->post(route('homepage-stat.store'), [
                'nilai' => '12 Lab',
                'label' => $uniqueLabel,
                'urutan' => 99,
                'is_active' => 1,
            ])->assertRedirect(route('homepage-stat.index'));

            $created = HomepageStat::where('label', $uniqueLabel)->first();
            $this->assertNotNull($created);

            // Bulk update the created item
            $this->actingAs($admin)->put(route('homepage-stat.bulk-update'), [
                'items' => [
                    [
                        'id' => $created->id,
                        'nilai' => '15 Lab',
                        'label' => $uniqueLabel,
                        'urutan' => 99,
                        'is_active' => 1,
                    ],
                ],
            ])->assertRedirect(route('homepage-stat.index'));

            $created->refresh();
            $this->assertSame('15 Lab', $created->nilai);

            // Homepage reflects updated stat
            $this->get(route('homepage'))
                ->assertStatus(200)
                ->assertSee('15 Lab')
                ->assertSee($uniqueLabel);

            // Delete stat item
            $this->actingAs($admin)->delete(route('homepage-stat.destroy', $created->id))
                ->assertRedirect(route('homepage-stat.index'));

            $this->assertDatabaseMissing('homepage_stats', ['id' => $created->id]);
            $created = null;
        } finally {
            if ($created) {
                $created->delete();
            }
        }
    }
}
