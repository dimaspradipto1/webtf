<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementAndAgendaTest extends TestCase
{
    protected function getAdminUser(): User
    {
        $admin = User::first();
        if (! $admin) {
            $admin = User::factory()->create([
                'roles' => ['admin'],
                'name' => 'Admin Test',
                'email' => 'admin_test_'.time().'@test.com',
                'password' => bcrypt('password'),
            ]);
        }

        return $admin;
    }

    public function test_guest_cannot_access_admin_announcements_or_agenda(): void
    {
        $response1 = $this->get(route('announcements.index'));
        $response1->assertRedirect(route('login'));

        $response2 = $this->get(route('agenda.index'));
        $response2->assertRedirect(route('login'));
    }

    public function test_admin_can_access_announcements_and_agenda_index(): void
    {
        $admin = $this->getAdminUser();

        $responseAnn = $this->actingAs($admin)->get(route('announcements.index'));
        $responseAnn->assertStatus(200);

        $responseAgenda = $this->actingAs($admin)->get(route('agenda.index'));
        $responseAgenda->assertStatus(200);
    }

    public function test_admin_can_crud_announcement(): void
    {
        $admin = $this->getAdminUser();

        // Create
        $responseCreate = $this->actingAs($admin)->post(route('announcements.store'), [
            'title' => 'Pengumuman Uji Coba Sistem Baru',
            'date' => '2026-11-04',
            'content' => 'Deskripsi detail pengumuman uji coba.',
            'link_url' => 'https://example.com/pengumuman-baru',
            'is_active' => '1',
            'urutan' => 10,
        ]);
        $responseCreate->assertRedirect(route('announcements.index'));

        $announcement = Announcement::where('title', 'Pengumuman Uji Coba Sistem Baru')->first();
        $this->assertNotNull($announcement);
        $this->assertEquals('pengumuman-uji-coba-sistem-baru', $announcement->slug);

        // Update
        $responseUpdate = $this->actingAs($admin)->put(route('announcements.update', $announcement->id), [
            'title' => 'Pengumuman Uji Coba Diperbarui',
            'date' => '2026-11-05',
            'content' => 'Uraian baru setelah revisi.',
            'is_active' => '1',
            'urutan' => 5,
        ]);
        $responseUpdate->assertRedirect(route('announcements.index'));
        $announcement->refresh();
        $this->assertEquals('Pengumuman Uji Coba Diperbarui', $announcement->title);
        $this->assertEquals(5, $announcement->urutan);

        // Delete
        $responseDelete = $this->actingAs($admin)->delete(route('announcements.destroy', $announcement->id));
        $responseDelete->assertRedirect(route('announcements.index'));
        $this->assertNull(Announcement::find($announcement->id));
    }

    public function test_admin_can_crud_agenda(): void
    {
        $admin = $this->getAdminUser();

        // Create
        $responseCreate = $this->actingAs($admin)->post(route('agenda.store'), [
            'title' => 'Workshop Kecerdasan Buatan & Robotika',
            'date_text' => '10 - 12 November 2026',
            'location' => 'Auditorium Lantai 3',
            'description' => 'Pelatihan AI tingkat lanjut.',
            'is_active' => '1',
            'urutan' => 8,
        ]);
        $responseCreate->assertRedirect(route('agenda.index'));

        $agenda = Agenda::where('title', 'Workshop Kecerdasan Buatan & Robotika')->first();
        $this->assertNotNull($agenda);
        $this->assertEquals('10 - 12 November 2026', $agenda->date_text);

        // Update
        $responseUpdate = $this->actingAs($admin)->put(route('agenda.update', $agenda->id), [
            'title' => 'Workshop Kecerdasan Buatan Terapan',
            'date_text' => '15 - 17 November 2026',
            'location' => 'Laboratorium AI',
            'is_active' => '1',
            'urutan' => 4,
        ]);
        $responseUpdate->assertRedirect(route('agenda.index'));
        $agenda->refresh();
        $this->assertEquals('Workshop Kecerdasan Buatan Terapan', $agenda->title);
        $this->assertEquals('15 - 17 November 2026', $agenda->date_text);

        // Delete
        $responseDelete = $this->actingAs($admin)->delete(route('agenda.destroy', $agenda->id));
        $responseDelete->assertRedirect(route('agenda.index'));
        $this->assertNull(Agenda::find($agenda->id));
    }

    public function test_public_pages_and_homepage_render_correctly(): void
    {
        // Public homepage
        $responseHome = $this->get(route('homepage'));
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Pengumuman');
        $responseHome->assertSee('Agenda');

        // Public pengumuman list
        $responseAnn = $this->get(route('homepage.pengumuman'));
        $responseAnn->assertStatus(200);

        // Public agenda list
        $responseAgenda = $this->get(route('homepage.agenda'));
        $responseAgenda->assertStatus(200);

        // Public pengumuman detail
        $firstAnn = Announcement::first();
        if ($firstAnn) {
            $responseDetail = $this->get(route('homepage.pengumuman.detail', $firstAnn->slug));
            $responseDetail->assertStatus(200);
            $responseDetail->assertSee($firstAnn->title);
        }
    }
}
