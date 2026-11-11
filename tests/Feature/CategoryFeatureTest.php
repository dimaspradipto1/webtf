<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    public function test_guest_cannot_access_category_index(): void
    {
        $response = $this->get(route('category.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_category_index_and_see_defaults(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('category.index'));
        $response->assertStatus(200);
        $response->assertSee('Master Kategori Konten', false);
        $response->assertSee('Berita & Informasi', false);
        $response->assertSee('Berita Universitas', false);
        $response->assertSee('Berita Humas', false);
    }

    public function test_admin_can_create_new_category_with_auto_generated_slug(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $payload = [
            'name' => 'Kecerdasan Buatan & AI',
            'type' => 'berita',
            'description' => 'Kategori artikel mengenai riset AI dan Machine Learning',
            'color' => '#6610f2',
            'icon' => 'bi-robot',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('category.store'), $payload);
        $response->assertRedirect(route('category.index', ['type' => 'berita']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'name' => 'Kecerdasan Buatan & AI',
            'slug' => 'kecerdasan-buatan-ai',
            'type' => 'berita',
        ]);
    }

    public function test_admin_can_update_category(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $category = Category::where('type', 'berita')->first();
        $this->assertNotNull($category);

        $payload = [
            'name' => 'Berita Kampus Terpadu',
            'type' => 'berita',
            'slug' => 'berita-kampus-terpadu',
            'description' => 'Seputar kegiatan civitas kampus',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('category.update', $category->id), $payload);
        $response->assertRedirect(route('category.index', ['type' => 'berita']));
        $response->assertSessionHas('success');

        $category->refresh();
        $this->assertEquals('Berita Kampus Terpadu', $category->name);
        $this->assertEquals('berita-kampus-terpadu', $category->slug);
    }

    public function test_admin_can_toggle_category_status(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $category = Category::first();
        $this->assertNotNull($category);
        $originalStatus = $category->is_active;

        $response = $this->actingAs($admin)->post(route('category.toggle', $category->id));
        $response->assertRedirect();

        $category->refresh();
        $this->assertEquals(!$originalStatus, $category->is_active);
    }

    public function test_admin_can_delete_category(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $category = Category::create([
            'name' => 'Kategori Sementara Untuk Dihapus',
            'slug' => 'kategori-sementara-hapus',
            'type' => 'berita',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('category.destroy', $category->id));
        $response->assertRedirect(route('category.index', ['type' => 'berita']));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_news_create_form_displays_dynamic_categories(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        Category::create([
            'name' => 'Inovasi Startup Mahasiswa',
            'slug' => 'inovasi-startup-mahasiswa',
            'type' => 'berita',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('news.create'));
        $response->assertStatus(200);
        $response->assertSee('Inovasi Startup Mahasiswa', false);
        $response->assertSee('Kelola Kategori', false);
    }

    public function test_sidebar_displays_kategori_menu_above_kontak(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee(route('category.index'), false);
        $response->assertSee('Kategori', false);
        $response->assertSee(route('contact.index'), false);
    }
}
