<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Dosen;
use App\Models\News;
use App\Models\User;
use Tests\TestCase;

class GlobalSearchTest extends TestCase
{
    public function test_topbar_search_form_uses_global_search_route(): void
    {
        $response = $this->get(route('homepage'));
        $response->assertStatus(200);
        $response->assertSee('action="' . route('homepage.search') . '"', false);
        $response->assertDontSee('action="' . route('homepage.news.category', 'berita-dan-peristiwa') . '"', false);
    }

    public function test_global_search_finds_announcements_news_agendas_dosen_and_static_pages(): void
    {
        $user = User::first() ?? User::factory()->create(['roles' => 'admin']);
        $token = 'KRSUJI' . uniqid();

        $announcement = null;
        $agenda = null;
        $news = null;
        $dosen = null;

        try {
            $announcement = Announcement::create([
                'title' => "Pengisian KRS dan Validasi {$token}",
                'date' => now()->toDateString(),
                'content' => 'Jadwal resmi pengisian KRS mahasiswa Teknik Informatika.',
                'is_active' => true,
                'urutan' => 1,
            ]);

            $agenda = Agenda::create([
                'title' => "Sosialisasi Akademik {$token}",
                'date_text' => '25 November 2026',
                'location' => 'Aula FST UIS',
                'description' => 'Agenda sosialisasi kurikulum dan pengisian KRS.',
                'is_active' => true,
                'urutan' => 1,
            ]);

            $news = News::create([
                'user_id' => $user->id,
                'title' => "Berita Kampus {$token}",
                'slug' => 'berita-kampus-' . strtolower($token),
                'category' => 'Akademik',
                'description' => 'Ringkasan berita akademik terbaru.',
                'content' => '<p>Konten berita akademik lengkap.</p>',
                'status' => 'published',
            ]);

            $dosen = Dosen::create([
                'nama_dosen' => "Dr. Dosen {$token}, M.Kom",
                'jabatan_fungsional' => 'Lektor',
                'nidn' => '1099887766',
                'prodi_nama' => 'Teknik Informatika',
                'is_active' => true,
                'urutan' => 1,
            ]);

            $res = $this->get(route('homepage.search', ['q' => $token]));
            $res->assertStatus(200);
            $res->assertSee("Pengisian KRS dan Validasi {$token}");
            $res->assertSee("Sosialisasi Akademik {$token}");
            $res->assertSee("Berita Kampus {$token}");
            $res->assertSee("Dr. Dosen {$token}, M.Kom");

            // Uji pencarian kata kunci "KRS" menemukan pengumuman dan halaman statis terkait KRS
            $krsRes = $this->get(route('homepage.search', ['q' => 'KRS']));
            $krsRes->assertStatus(200);
            $krsRes->assertSee("Pengisian KRS dan Validasi {$token}");
            $krsRes->assertSee('Kalender Akademik');
            $krsRes->assertDontSee('Belum Ada Berita');

            // Uji halaman /cari tanpa query
            $emptyRes = $this->get(route('homepage.search'));
            $emptyRes->assertStatus(200);
            $emptyRes->assertSee('Masukkan Kata Kunci Pencarian');
        } finally {
            $announcement?->delete();
            $agenda?->delete();
            $news?->delete();
            $dosen?->delete();
        }
    }
}
