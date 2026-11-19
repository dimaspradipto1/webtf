<?php

namespace Tests\Feature;

use App\Models\SambutanDekan;
use App\Models\User;
use Tests\TestCase;

class VideoProfilTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_admin_can_configure_video_profil_and_homepage_embeds_youtube(): void
    {
        $admin = $this->getAdmin();
        SambutanDekan::ensureVideoColumns();
        $original = SambutanDekan::first();
        $backup = $original ? $original->only([
            'nama_dekan',
            'jabatan_dekan',
            'kutipan_singkat',
            'sambutan_dekan',
            'video_judul',
            'video_subjudul',
            'video_url',
            'video_aktif',
        ]) : null;

        try {
            // Admin page shows Video Profil form
            $this->actingAs($admin)->get(route('sambutan-rektor.index'))
                ->assertStatus(200)
                ->assertSee('Video Profil Program Studi (Beranda)');

            // Update with YouTube watch URL
            $this->actingAs($admin)->put(route('sambutan-rektor.update'), [
                'nama_dekan' => $backup['nama_dekan'] ?? 'Kaprodi TI',
                'jabatan_dekan' => $backup['jabatan_dekan'] ?? 'Ketua Program Studi S1 Teknik Informatika',
                'kutipan_singkat' => $backup['kutipan_singkat'] ?? 'Kutipan uji',
                'sambutan_dekan' => $backup['sambutan_dekan'] ?? '<p>Sambutan uji</p>',
                'video_judul' => 'Video Profil Prodi S1 Teknik Informatika UIS',
                'video_subjudul' => 'Durasi 2 menit • Suasana kuliah & lab',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'video_aktif' => 1,
            ])->assertRedirect(route('sambutan-rektor.index'));

            // Homepage embeds converted YouTube URL below Sambutan Kaprodi
            $home = $this->get(route('homepage'));
            $home->assertStatus(200)
                ->assertSee('id="video-profil-prodi"', false)
                ->assertSee('https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0', false)
                ->assertSee('Video Profil Prodi S1 Teknik Informatika UIS');

            // Disabling video_aktif hides the video block on homepage
            $this->actingAs($admin)->put(route('sambutan-rektor.update'), [
                'nama_dekan' => $backup['nama_dekan'] ?? 'Kaprodi TI',
                'jabatan_dekan' => $backup['jabatan_dekan'] ?? 'Ketua Program Studi S1 Teknik Informatika',
                'kutipan_singkat' => $backup['kutipan_singkat'] ?? 'Kutipan uji',
                'sambutan_dekan' => $backup['sambutan_dekan'] ?? '<p>Sambutan uji</p>',
                'video_judul' => 'Video Profil Prodi S1 Teknik Informatika UIS',
                'video_subjudul' => 'Durasi 2 menit',
                'video_url' => 'https://youtu.be/dQw4w9WgXcQ',
            ])->assertRedirect(route('sambutan-rektor.index'));

            $this->get(route('homepage'))
                ->assertStatus(200)
                ->assertDontSee('id="video-profil-prodi"', false);
        } finally {
            if ($original && $backup) {
                $original->update($backup);
            }
        }
    }
}
