<?php

namespace Tests\Feature;

use App\Models\ThemeSetting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_can_update_header_brand_logo_and_titles(): void
    {
        Storage::fake('public');

        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $logoFile = UploadedFile::fake()->image('custom_logo.png', 100, 100);

        $payload = [
            'header_title' => 'TEKNIK KOMPUTER & INFORMATIKA',
            'header_subtitle' => 'Fakultas Sains, Teknologi & Desain',
            'header_logo' => $logoFile,
            'header_bg_color' => '#1e293b',
            'header_text_color' => '#ffffff',
            'header_active_bg_color' => '#f59e0b',
            'header_active_text_color' => '#000000',
            'header_login_bg_color' => '#f59e0b',
            'header_login_text_color' => '#000000',
            'topbar_bg_color' => '#0f172a',
            'topbar_text_color' => '#ffffff',
        ];

        $response = $this->actingAs($admin)->post(route('theme.update'), $payload);
        $response->assertRedirect();

        $setting = ThemeSetting::current();
        $this->assertEquals('TEKNIK KOMPUTER & INFORMATIKA', $setting->header_title);
        $this->assertEquals('Fakultas Sains, Teknologi & Desain', $setting->header_subtitle);
        $this->assertNotNull($setting->header_logo);
        Storage::disk('public')->assertExists($setting->header_logo);
        $this->assertStringContainsString('storage/' . $setting->header_logo, $setting->logo_url);

        // Verify public homepage shows the custom title and subtitle
        $homeResponse = $this->get(route('homepage'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('TEKNIK KOMPUTER & INFORMATIKA');
        $homeResponse->assertSee('Fakultas Sains, Teknologi & Desain');

        // Test remove custom logo via remove_header_logo flag
        $removePayload = array_merge($payload, [
            'remove_header_logo' => '1',
            'header_logo' => null,
        ]);
        $removeResponse = $this->actingAs($admin)->post(route('theme.update'), $removePayload);
        $removeResponse->assertRedirect();

        $setting->refresh();
        $this->assertNull($setting->header_logo);
        $this->assertStringContainsString('assets/img/logouis.png', $setting->logo_url);

        // Reset to default
        $this->actingAs($admin)->post(route('theme.reset'));
        $setting->refresh();
        $this->assertEquals('TEKNIK INFORMATIKA', $setting->header_title);
        $this->assertEquals('Fakultas Sains dan Teknologi', $setting->header_subtitle);
    }

    public function test_can_update_header_bg_color_to_custom_green(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $payload = [
            'header_bg_color' => '#5d866c',
            'header_text_color' => '#ffffff',
            'header_active_bg_color' => '#000000',
            'header_active_text_color' => '#ffffff',
            'header_login_bg_color' => '#000000',
            'header_login_text_color' => '#ffffff',
            'header_shadow_color' => '#5d866c',
            'topbar_bg_color' => '#000000',
            'topbar_text_color' => '#ffffff',
        ];

        $response = $this->actingAs($admin)->post(route('theme.update'), $payload);
        $response->assertRedirect();

        $setting = ThemeSetting::current();
        $this->assertEquals('#5d866c', $setting->header_bg_color);

        $homeResponse = $this->get(route('homepage'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('--hdr-bg: #5d866c;', false);

        // Reset
        $this->actingAs($admin)->post(route('theme.reset'));
    }

    public function test_hero_banner_renders_default_gray_image_when_no_banners_uploaded(): void
    {
        // Nonaktifkan semua banner sementara
        \App\Models\Banner::query()->update(['aktif' => false]);

        $homeResponse = $this->get(route('homepage'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('default-hero-banner.svg', false);
        $homeResponse->assertSee('default-hero-banner.jpg', false);
        $homeResponse->assertDontSee('Banner Promosi & Iklan Fakultas dapat diunggah', false);

        // Kembalikan status aktif banner
        \App\Models\Banner::query()->update(['aktif' => true]);
    }
}
