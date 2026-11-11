<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Tests\TestCase;

class TestimonialFeatureTest extends TestCase
{
    protected function getAdmin(): User
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }
        return $admin;
    }

    public function test_admin_can_view_create_page_with_custom_category_option(): void
    {
        $admin = $this->getAdmin();

        $response = $this->actingAs($admin)->get(route('testimonial.create'));
        $response->assertStatus(200);
        $response->assertSee('Alumni');
        $response->assertSee('Mahasiswa');
        $response->assertSee('Mitra Industri');
        $response->assertSee('Tambah Kategori Kustom');
        $response->assertDontSee('Pemilik Rumah');
    }

    public function test_admin_can_store_testimonial_with_preset_category(): void
    {
        $admin = $this->getAdmin();

        $payload = [
            'nama' => 'Budi Santoso',
            'pekerjaan' => 'Software Engineer, Tokopedia',
            'kategori' => 'Alumni',
            'bintang' => 5,
            'pesan' => 'Kurikulum Teknik Informatika UIS sangat aplikatif dan sesuai dengan kebutuhan industri saat ini.',
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('testimonial.store'), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $this->assertDatabaseHas('testimonials', [
            'nama' => 'Budi Santoso',
            'kategori' => 'Alumni',
        ]);
    }

    public function test_admin_can_store_testimonial_with_custom_category(): void
    {
        $admin = $this->getAdmin();

        $payload = [
            'nama' => 'Rian Hidayat',
            'pekerjaan' => 'Lead DevOps Engineer, GoTo',
            'kategori' => '__custom__',
            'kategori_custom' => 'Praktisi Cloud & DevOps',
            'bintang' => 5,
            'pesan' => 'Fasilitas laboratorium cloud dan jaringan sangat memadai untuk riset tingkat lanjut.',
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('testimonial.store'), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $this->assertDatabaseHas('testimonials', [
            'nama' => 'Rian Hidayat',
            'kategori' => 'Praktisi Cloud & DevOps',
        ]);
    }

    public function test_admin_can_update_testimonial_with_custom_category(): void
    {
        $admin = $this->getAdmin();

        $testi = Testimonial::create([
            'nama' => 'Maya Indah',
            'pekerjaan' => 'UI/UX Designer',
            'kategori' => 'Alumni',
            'bintang' => 5,
            'pesan' => 'Dosen-dosen sangat suportif dan materi kuliah selalu diperbarui.',
            'aktif' => true,
        ]);

        $payload = [
            'nama' => 'Maya Indah',
            'pekerjaan' => 'Senior Product Designer',
            'kategori' => '__custom__',
            'kategori_custom' => 'Expert Industri Digital',
            'bintang' => 5,
            'pesan' => 'Dosen-dosen sangat suportif dan materi kuliah selalu diperbarui.',
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->put(route('testimonial.update', $testi->id), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $testi->refresh();
        $this->assertEquals('Expert Industri Digital', $testi->kategori);
        $this->assertEquals('Senior Product Designer', $testi->pekerjaan);
    }
}

