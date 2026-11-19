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
        $uniqueName = 'Budi Santoso ' . uniqid();

        $payload = [
            'nama' => $uniqueName,
            'pekerjaan' => 'Software Engineer, Tokopedia',
            'kategori' => 'Alumni',
            'bintang' => 5,
            'pesan' => 'Kurikulum Teknik Informatika UIS sangat aplikatif dan sesuai dengan kebutuhan industri saat ini. #' . uniqid(),
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('testimonial.store'), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $this->assertDatabaseHas('testimonials', [
            'nama' => $uniqueName,
            'kategori' => 'Alumni',
        ]);

        Testimonial::where('nama', $uniqueName)->delete();
    }

    public function test_admin_can_store_testimonial_with_custom_category(): void
    {
        $admin = $this->getAdmin();
        $uniqueName = 'Rian Hidayat ' . uniqid();

        $payload = [
            'nama' => $uniqueName,
            'pekerjaan' => 'Lead DevOps Engineer, GoTo',
            'kategori' => '__custom__',
            'kategori_custom' => 'Praktisi Cloud & DevOps',
            'bintang' => 5,
            'pesan' => 'Fasilitas laboratorium cloud dan jaringan sangat memadai untuk riset tingkat lanjut. #' . uniqid(),
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('testimonial.store'), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $this->assertDatabaseHas('testimonials', [
            'nama' => $uniqueName,
            'kategori' => 'Praktisi Cloud & DevOps',
        ]);

        Testimonial::where('nama', $uniqueName)->delete();
    }

    public function test_admin_can_update_testimonial_with_custom_category(): void
    {
        $admin = $this->getAdmin();
        $uniqueName = 'Maya Indah ' . uniqid();
        $uniquePesan = 'Dosen-dosen sangat suportif dan materi kuliah selalu diperbarui. #' . uniqid();

        $testi = Testimonial::create([
            'nama' => $uniqueName,
            'pekerjaan' => 'UI/UX Designer',
            'kategori' => 'Alumni',
            'bintang' => 5,
            'pesan' => $uniquePesan,
            'aktif' => true,
        ]);

        $payload = [
            'nama' => $uniqueName,
            'pekerjaan' => 'Senior Product Designer',
            'kategori' => '__custom__',
            'kategori_custom' => 'Expert Industri Digital',
            'bintang' => 5,
            'pesan' => $uniquePesan,
            'aktif' => 1,
        ];

        $response = $this->actingAs($admin)->put(route('testimonial.update', $testi->id), $payload);
        $response->assertRedirect(route('testimonial.index'));

        $testi->refresh();
        $this->assertEquals('Expert Industri Digital', $testi->kategori);
        $this->assertEquals('Senior Product Designer', $testi->pekerjaan);

        $testi->delete();
    }

    public function test_public_testimonial_form_requires_captcha_and_blocks_duplicates_and_spam(): void
    {
        // 1. Form menampilkan CAPTCHA
        $formRes = $this->get(route('homepage.alumni.create'));
        $formRes->assertStatus(200);
        $formRes->assertSee('Verifikasi Keamanan (CAPTCHA)');
        $formRes->assertSee('name="captcha_answer"', false);

        $expectedAnswer = session('testimonial_captcha_answer');
        $this->assertNotNull($expectedAnswer);

        $uniqueName = 'Alumni Uji Captcha ' . uniqid();
        $uniquePesan = 'Pengalaman belajar di Teknik Informatika UIS sangat luar biasa dan relevan. #' . uniqid();

        try {
            // 2. Jawaban CAPTCHA salah ditolak
            $wrongRes = $this->post(route('homepage.alumni.store'), [
                'nama' => $uniqueName,
                'pekerjaan' => 'Backend Engineer',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => $uniquePesan,
                'captcha_answer' => $expectedAnswer + 99,
            ]);
            $wrongRes->assertSessionHasErrors('captcha_answer');

            // 3. Jawaban CAPTCHA benar diterima sebagai pending
            $okRes = $this->post(route('homepage.alumni.store'), [
                'nama' => $uniqueName,
                'pekerjaan' => 'Backend Engineer',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => $uniquePesan,
                'captcha_answer' => $expectedAnswer,
            ]);
            $okRes->assertRedirect(route('homepage.alumni.create'));
            $okRes->assertSessionHas('success');

            $this->assertDatabaseHas('testimonials', [
                'nama' => $uniqueName,
                'aktif' => 0,
            ]);

            // 4. Nama duplikat (case-insensitive) ditolak
            $this->get(route('homepage.alumni.create'));
            $newAnswer = session('testimonial_captcha_answer');

            $dupRes = $this->post(route('homepage.alumni.store'), [
                'nama' => strtoupper($uniqueName),
                'pekerjaan' => 'Frontend Engineer',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => 'Pesan berbeda namun nama sama untuk uji duplikasi #' . uniqid(),
                'captcha_answer' => $newAnswer,
            ]);
            $dupRes->assertSessionHasErrors('nama');

            // 5. Request ke-4 dalam 10 menit diblokir throttle:3,10 (HTTP 429)
            $throttledRes = $this->post(route('homepage.alumni.store'), [
                'nama' => 'Alumni Keempat ' . uniqid(),
                'pekerjaan' => 'QA Engineer',
                'kategori' => 'Alumni',
                'bintang' => 5,
                'pesan' => 'Pesan keempat untuk menguji pembatas rate limit #' . uniqid(),
                'captcha_answer' => $newAnswer,
            ]);
            $throttledRes->assertStatus(429);
        } finally {
            Testimonial::where('nama', $uniqueName)->delete();
        }
    }
}

