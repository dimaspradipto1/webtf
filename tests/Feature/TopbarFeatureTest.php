<?php

namespace Tests\Feature;

use App\Models\Topbar;
use App\Models\User;
use Tests\TestCase;

class TopbarFeatureTest extends TestCase
{
    public function test_guest_cannot_access_topbar_admin(): void
    {
        $response = $this->get(route('topbar.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_topbar_direct_edit_view_without_datatable(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('topbar.index'));
        $response->assertStatus(200);
        $response->assertSee('Form Pengaturan Topbar Header & Marquee', false);
        $response->assertSee('Simpan Pengaturan Topbar', false);
        $response->assertSee('name="marquee_text"', false);
        $response->assertSee('name="badge_text"', false);
        $response->assertDontSee('Data Pengaturan Topbar Header');
        $response->assertDontSee('entries per page');
        $this->assertStringContainsString('admin-topbar', route('topbar.index'));
        $this->assertStringContainsString('admin-topbar', route('topbar.update'));
    }

    public function test_admin_can_save_topbar_settings_directly_via_slug_route(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $payload = [
            'marquee_text' => 'Selamat Datang di Program Studi S1 Teknik Fisika Fakultas Sains & Teknologi UIS Batam',
            'badge_text' => 'TEKNIK FISIKA',
            'alamat' => 'Gedung Fakultas Sains dan Teknologi (FST), Batam',
            'jam_operasional' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
            'telepon' => '6281234567890',
            'email' => 'fst@uis.ac.id',
            'is_active' => 1,
            'social_media' => [
                [
                    'platform' => 'Instagram',
                    'icon' => 'bi bi-instagram',
                    'url' => 'https://instagram.com/uis.batam',
                ],
                [
                    'platform' => 'YouTube',
                    'icon' => 'bi bi-youtube',
                    'url' => 'https://youtube.com/@uisbatam',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('topbar.update'), $payload);
        $response->assertRedirect(route('topbar.index'));
        $response->assertSessionHas('success');

        $topbar = Topbar::where('is_active', true)->latest('id')->first();
        $this->assertNotNull($topbar);
        $this->assertEquals('Selamat Datang di Program Studi S1 Teknik Fisika Fakultas Sains & Teknologi UIS Batam', $topbar->marquee_text);
        $this->assertEquals('TEKNIK FISIKA', $topbar->badge_text);
        $this->assertEquals('6281234567890', $topbar->telepon);
        $this->assertEquals('fst@uis.ac.id', $topbar->email);
        $this->assertCount(2, $topbar->social_media);
        $this->assertEquals('Instagram', $topbar->social_media[0]['platform']);
    }

    public function test_legacy_create_and_edit_topbar_urls_redirect_to_direct_edit_page(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $this->actingAs($admin)->get('/admin-topbar/create')
            ->assertRedirect(route('topbar.index'));

        $this->actingAs($admin)->get('/admin-topbar/1/edit')
            ->assertRedirect(route('topbar.index'));
    }
}
