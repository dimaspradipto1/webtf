<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsFeatureTest extends TestCase
{
    public function test_guest_cannot_access_news_create(): void
    {
        $response = $this->get(route('news.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_news_create_with_slug_url(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('news.create'));
        $response->assertStatus(200);
        $response->assertSee('admin-berita', false);
        $response->assertSee('Terbitkan Berita', false);
    }

    public function test_admin_can_store_news_with_safe_base64_content(): void
    {
        Storage::fake('public');

        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $rawHtml = '<p>Kunjungi kami di <a href="https://uis.ac.id" class="btn btn-primary">Website Resmi UIS</a> sekarang juga!</p>';
        $safeContent = 'B64_SAFE:' . base64_encode($rawHtml);

        $thumbnail = UploadedFile::fake()->image('cover.jpg', 600, 400);

        $payload = [
            'title' => 'Pengumuman Penerimaan Mahasiswa Baru dengan Link Tombol',
            'description' => 'Kutipan berita tentang pendaftaran mahasiswa baru',
            'content' => $safeContent,
            'status' => 'published',
            'category' => 'Berita Universitas',
            'thumbnail' => $thumbnail,
        ];

        $response = $this->actingAs($admin)->post(route('news.store'), $payload);
        $response->assertRedirect(route('news.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('news', [
            'title' => 'Pengumuman Penerimaan Mahasiswa Baru dengan Link Tombol',
            'status' => 'published',
        ]);

        $news = News::where('title', 'Pengumuman Penerimaan Mahasiswa Baru dengan Link Tombol')->first();
        $this->assertNotNull($news);
        // Konten harus ter-decode kembali menjadi HTML asli di database
        $this->assertStringContainsString('Website Resmi UIS', $news->content);
        $this->assertStringContainsString('btn btn-primary', $news->content);
    }

    public function test_legacy_news_url_redirects_to_slug_route(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get('/news');
        $response->assertRedirect(route('news.index'));

        $createResponse = $this->actingAs($admin)->get('/news/create');
        $createResponse->assertRedirect(route('news.create'));
    }

    public function test_frontend_news_category_filter_uses_exact_match(): void
    {
        $admin = User::first() ?? User::factory()->create(['roles' => 'admin']);
        $uniqueTitle = 'Berita Khusus Universitas ' . uniqid();

        $news = News::create([
            'user_id' => $admin->id,
            'title' => $uniqueTitle,
            'slug' => 'berita-khusus-universitas-' . uniqid(),
            'category' => 'Berita Universitas',
            'description' => 'Ringkasan berita universitas.',
            'content' => '<p>Konten berita universitas.</p>',
            'status' => 'published',
        ]);

        try {
            // Kategori Berita Humas tidak boleh menampilkan berita dari Berita Universitas
            $humasRes = $this->get(route('homepage.news.category', 'berita-humas'));
            $humasRes->assertStatus(200);
            $humasRes->assertSee('Berita Humas');
            $humasRes->assertDontSee($uniqueTitle);

            // Kategori Berita Universitas harus menampilkan berita tersebut
            $univRes = $this->get(route('homepage.news.category', 'berita-universitas'));
            $univRes->assertStatus(200);
            $univRes->assertSee('Berita Universitas');
            $univRes->assertSee($uniqueTitle);

            // Slug lama berita-dan-peristiwa redirect bersih ke /berita
            $legacyRes = $this->get(route('homepage.news.category', 'berita-dan-peristiwa'));
            $legacyRes->assertRedirect(route('homepage.news'));
        } finally {
            $news->delete();
        }
    }
}

