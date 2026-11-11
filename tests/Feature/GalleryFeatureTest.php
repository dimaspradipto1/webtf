<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryFeatureTest extends TestCase
{
    private function getAdminUser(): User
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }
        return $admin;
    }

    protected function setUp(): void
    {
        parent::setUp();
        Gallery::where('judul', 'like', '%Kegiatan Praktikum Robotika%')
            ->orWhere('judul', 'like', '%Dokumentasi Seminar%')
            ->delete();
    }

    protected function tearDown(): void
    {
        Gallery::where('judul', 'like', '%Kegiatan Praktikum Robotika%')
            ->orWhere('judul', 'like', '%Dokumentasi Seminar%')
            ->delete();
        parent::tearDown();
    }

    public function test_guest_cannot_access_gallery_index(): void
    {
        $response = $this->get(route('gallery.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_gallery_index_and_see_create_button(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get(route('gallery.index'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Foto Galeri', false);
        $response->assertSee('Tambah Foto Galeri', false);
        $response->assertSee(route('gallery.create'), false);
        $response->assertSee('Kelola Kategori', false);
    }

    public function test_legacy_gallery_url_redirects_to_gallery_index(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/gallery');
        $response->assertRedirect(route('gallery.index'));
    }

    public function test_admin_can_access_gallery_create(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get(route('gallery.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Foto Galeri', false);
        $response->assertSee('Form Tambah Foto Galeri', false);
        $response->assertSee(route('gallery.store'), false);
    }

    public function test_admin_can_store_gallery_item_with_upload(): void
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();

        $file = UploadedFile::fake()->image('campus_activity.jpg', 800, 600);

        $payload = [
            'judul' => 'Kegiatan Praktikum Robotika 2026',
            'kategori' => 'universitas',
            'deskripsi' => 'Dokumentasi praktikum mahasiswa di laboratorium robotika FST UIS.',
            'foto' => $file,
        ];

        $response = $this->actingAs($admin)->post(route('gallery.store'), $payload);
        $response->assertRedirect(route('gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'judul' => 'Kegiatan Praktikum Robotika 2026',
            'kategori' => 'universitas',
        ]);

        $gallery = Gallery::where('judul', 'Kegiatan Praktikum Robotika 2026')->first();
        $this->assertNotNull($gallery);
        $this->assertNotNull($gallery->url);
        Storage::disk('public')->assertExists($gallery->url);
    }

    public function test_admin_can_access_gallery_edit_and_update(): void
    {
        $admin = $this->getAdminUser();

        $gallery = Gallery::create([
            'judul' => 'Foto Dokumentasi Seminar Lama',
            'kategori' => 'humas',
            'deskripsi' => 'Deskripsi lama sebelum update',
            'url' => 'gallery/dummy.jpg',
        ]);

        $response = $this->actingAs($admin)->get(route('gallery.edit', $gallery->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Foto Galeri', false);
        $response->assertSee('Foto Dokumentasi Seminar Lama', false);

        $updateResponse = $this->actingAs($admin)->put(route('gallery.update', $gallery->id), [
            'judul' => 'Foto Dokumentasi Seminar Nasional 2026',
            'kategori' => 'humas',
            'deskripsi' => 'Deskripsi baru yang sudah diperbarui',
        ]);

        $updateResponse->assertRedirect(route('gallery.index'));

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'judul' => 'Foto Dokumentasi Seminar Nasional 2026',
            'deskripsi' => 'Deskripsi baru yang sudah diperbarui',
        ]);
    }
}
