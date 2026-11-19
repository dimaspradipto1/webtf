<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LowPriorityFixesTest extends TestCase
{
    public function test_r1_topbar_social_links_use_official_campus_urls(): void
    {
        $res = $this->get(route('homepage'));
        $res->assertStatus(200);
        $res->assertSee('universitasibnusina', false);
    }

    public function test_r2_privacy_policy_and_terms_pages_exist_and_are_linked_in_footer(): void
    {
        $home = $this->get(route('homepage'));
        $home->assertStatus(200);
        $home->assertSee(route('homepage.kebijakan-privasi'), false);
        $home->assertSee(route('homepage.syarat-ketentuan'), false);

        $this->get(route('homepage.kebijakan-privasi'))
            ->assertStatus(200)
            ->assertSee('Kebijakan Privasi');

        $this->get(route('homepage.syarat-ketentuan'))
            ->assertStatus(200)
            ->assertSee('Syarat &amp; Ketentuan', false);
    }

    public function test_r5_news_category_validation_message_is_in_indonesian(): void
    {
        $admin = User::first() ?? User::factory()->create(['roles' => 'admin']);

        $res = $this->actingAs($admin)->post(route('news.store'), [
            'title' => 'Judul Uji',
            'description' => 'Deskripsi uji',
            'content' => '<p>Konten uji</p>',
            'status' => 'published',
            'category' => '',
        ]);

        $res->assertSessionHasErrors([
            'category' => 'Kategori berita wajib dipilih.',
        ]);
    }

    public function test_r6_sambutan_kaprodi_route_and_redirect_from_old_url(): void
    {
        $this->get(route('homepage.sambutan-kaprodi'))->assertStatus(200);
        $this->get('/sambutan-rektor')->assertRedirect(route('homepage.sambutan-kaprodi'));
        $this->get('/sambutan-dekan')->assertRedirect(route('homepage.sambutan-kaprodi'));
    }

    public function test_r7_and_r9_login_https_text_and_forgot_password_page(): void
    {
        $login = $this->get(route('login'));
        $login->assertStatus(200);
        $login->assertSee('KONEKSI AMAN (HTTPS)');
        $login->assertDontSee('TERENKRIPSI END-TO-END');
        $login->assertSee(route('password.request'), false);
        $login->assertSee('Lupa Password?');

        $forgot = $this->get(route('password.request'));
        $forgot->assertStatus(200);
        $forgot->assertSee('Lupa Kata Sandi?');

        $reset = $this->get(route('password.reset', ['token' => 'dummy-token']));
        $reset->assertStatus(200);
        $reset->assertSee('Buat Kata Sandi Baru');
    }

    public function test_r10_sitemap_xml_returns_valid_xml(): void
    {
        $res = $this->get('/sitemap.xml');
        $res->assertStatus(200);
        $res->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $res->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $res->assertSee(route('homepage'), false);
    }

    public function test_r11_admin_profile_and_news_create_have_no_empty_img_src(): void
    {
        $admin = User::first() ?? User::factory()->create(['roles' => 'admin']);

        $profile = $this->actingAs($admin)->get(route('user.my-profile'));
        $profile->assertStatus(200);
        $profile->assertDontSee('src=""', false);

        $newsCreate = $this->actingAs($admin)->get(route('news.create'));
        $newsCreate->assertStatus(200);
        $newsCreate->assertDontSee('src=""', false);
    }
}
