<?php

namespace Tests\Feature;

use App\Models\ThemeSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeSettingTest extends TestCase
{
    public function test_guest_cannot_access_theme_setting(): void
    {
        $response = $this->get(route('theme.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_theme_setting(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('theme.index'));
        $response->assertStatus(200);
        $response->assertSee('Warna Header');
    }

    public function test_admin_can_update_theme_and_sections(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $payload = [
            'header_bg_color' => '#000000',
            'header_text_color' => '#ffffff',
            'header_active_bg_color' => '#f9dc4b',
            'header_active_text_color' => '#000000',
            'header_login_bg_color' => '#f9dc4b',
            'header_login_text_color' => '#000000',
            'header_shadow_color' => '#000000',
            'header_is_sticky' => '1',
            'topbar_bg_color' => '#111827',
            'topbar_text_color' => '#ffffff',
            'topbar_social_bg_color' => '#f9dc4b',
            'topbar_social_text_color' => '#000000',
            'accent_color' => '#f9dc4b',
            'footer_bg_color' => '#020617',
            'footer_text_color' => '#cbd5e1',
            'footer_heading_color' => '#38bdf8',
            'footer_border_top_color' => '#38bdf8',
            'footer_link_color' => '#94a3b8',
            'footer_link_hover_color' => '#38bdf8',
            'footer_social_bg_color' => '#38bdf8',
            'footer_social_text_color' => '#020617',
            'footer_description' => 'Program Studi Teknik Informatika UIS Batam Unggul & Terpercaya.',
            'footer_copyright' => '© 2026 S1 Teknik Informatika UIS Batam',
            'sections' => [
                'berita' => ['order' => 1, 'is_active' => '1'],
                'hero_banner' => ['order' => 2, 'is_active' => '1'],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('theme.update'), $payload);
        $response->assertRedirect();

        $setting = ThemeSetting::current();
        $this->assertEquals('#000000', $setting->header_bg_color);
        $this->assertEquals('#f9dc4b', $setting->header_active_bg_color);
        $this->assertEquals('#f9dc4b', $setting->topbar_social_bg_color);
        $this->assertEquals('#000000', $setting->topbar_social_text_color);
        $this->assertEquals('#020617', $setting->footer_bg_color);
        $this->assertEquals('#38bdf8', $setting->footer_heading_color);
        $this->assertEquals('© 2026 S1 Teknik Informatika UIS Batam', $setting->footer_copyright);

        // Test without header_shadow_color and accent_color (should not throw Undefined array key)
        $payloadMinimal = [
            'header_bg_color' => '#1e3a8a',
            'header_text_color' => '#ffffff',
            'header_active_bg_color' => '#3b82f6',
            'header_active_text_color' => '#ffffff',
            'header_login_bg_color' => '#3b82f6',
            'header_login_text_color' => '#ffffff',
            'topbar_bg_color' => '#0f172a',
            'topbar_text_color' => '#ffffff',
        ];
        $responseMinimal = $this->actingAs($admin)->post(route('theme.update'), $payloadMinimal);
        $responseMinimal->assertRedirect();
        $setting->refresh();
        $this->assertEquals('#1e3a8a', $setting->header_bg_color);
        $this->assertEquals('#1e3a8a', $setting->header_shadow_color);

        // Reset back to default
        $this->actingAs($admin)->post(route('theme.reset'));
        $setting->refresh();
        $this->assertEquals('#f9dc4b', $setting->header_bg_color);
        $this->assertEquals('#ffffff', $setting->topbar_social_bg_color);
        $this->assertEquals('#000000', $setting->topbar_social_text_color);
        $this->assertEquals('#000000', $setting->footer_bg_color);
        $this->assertEquals('#f9dc4b', $setting->footer_heading_color);
    }
}
