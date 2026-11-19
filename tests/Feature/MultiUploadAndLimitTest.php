<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MultiUploadAndLimitTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_sarana_supports_multi_photo_upload_carousel_and_selective_delete(): void
    {
        $admin = $this->getAdmin();
        $nama = 'Lab Multi Foto Uji ' . uniqid();
        $created = null;

        try {
            $img1 = UploadedFile::fake()->image('ruang1.jpg', 800, 600);
            $img2 = UploadedFile::fake()->image('ruang2.jpg', 800, 600);

            $this->actingAs($admin)->post(route('sarana.store'), [
                'icon' => 'bi-pc-display',
                'nama' => $nama,
                'deskripsi' => 'Uji multi upload foto ruangan lab.',
                'foto' => [$img1, $img2],
                'urutan' => 98,
                'is_active' => 1,
            ])->assertRedirect(route('sarana.index'));

            $created = Sarana::where('nama', $nama)->first();
            $this->assertNotNull($created);
            $this->assertCount(2, $created->all_foto_paths);

            // Public detail page shows carousel for multiple photos
            $this->get(route('homepage.fasilitas.detail', $created->slug))
                ->assertStatus(200)
                ->assertSee('id="labPhotoCarousel"', false);

            // Selective delete first photo & keep second
            $firstPath = $created->all_foto_paths[0];
            $secondPath = $created->all_foto_paths[1];

            $this->actingAs($admin)->put(route('sarana.update', $created->id), [
                'icon' => 'bi-pc-display',
                'nama' => $nama,
                'deskripsi' => 'Uji hapus satu foto.',
                'hapus_foto' => [$firstPath],
                'urutan' => 98,
                'is_active' => 1,
            ])->assertRedirect(route('sarana.index'));

            $created->refresh();
            $this->assertCount(1, $created->all_foto_paths);
            $this->assertSame($secondPath, $created->foto);
            $this->assertFalse(Storage::disk('public')->exists($firstPath));
        } finally {
            if ($created) {
                foreach ($created->all_foto_paths as $p) {
                    if (Storage::disk('public')->exists($p)) {
                        Storage::disk('public')->delete($p);
                    }
                }
                $created->delete();
            }
        }
    }

    public function test_gallery_supports_multi_photo_upload(): void
    {
        $admin = $this->getAdmin();
        $judul = 'Dokumentasi Multi Uji ' . uniqid();
        $created = collect();

        try {
            $img1 = UploadedFile::fake()->image('gal1.jpg', 640, 480);
            $img2 = UploadedFile::fake()->image('gal2.jpg', 640, 480);

            $this->actingAs($admin)->post(route('gallery.store'), [
                'judul' => $judul,
                'kategori' => 'universitas',
                'deskripsi' => 'Uji multi upload galeri.',
                'foto' => [$img1, $img2],
            ])->assertRedirect(route('gallery.index'))
                ->assertSessionHas('success', '2 foto galeri berhasil ditambahkan.');

            $created = Gallery::where('judul', 'like', $judul . '%')->get();
            $this->assertCount(2, $created);
        } finally {
            foreach ($created as $item) {
                if ($item->url && Storage::disk('public')->exists($item->url)) {
                    Storage::disk('public')->delete($item->url);
                }
                $item->delete();
            }
        }
    }

    public function test_dashboard_global_upload_limit_is_20_mb(): void
    {
        $admin = $this->getAdmin();

        $this->actingAs($admin)->get(route('sarana.create'))
            ->assertStatus(200)
            ->assertSee("data-max-mb=\"20\"", false)
            ->assertSee("parseFloat(this.getAttribute('data-max-mb') || '20')", false)
            ->assertDontSee('2 * 1024 * 1024');
    }
}
