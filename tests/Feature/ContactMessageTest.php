<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    private function getAdmin(): User
    {
        return User::where('roles', 'admin')->first() ?? User::first();
    }

    public function test_public_contact_form_validates_captcha_and_stores_message_for_admin(): void
    {
        $admin = $this->getAdmin();
        $uniqueEmail = 'calon.mhs.' . uniqid() . '@example.com';
        $created = null;

        try {
            // GET /kontak generates CAPTCHA session and displays form
            $page = $this->get(route('homepage.kontak'));
            $page->assertStatus(200)
                ->assertSee('Kirim Pesan ke Program Studi')
                ->assertSee('Kategori: PMB');

            $expectedAnswer = session('contact_captcha_answer');
            $this->assertNotNull($expectedAnswer);

            // Wrong CAPTCHA is rejected
            $wrongRes = $this->post(route('homepage.kontak.submit'), [
                'nama' => 'Calon Mahasiswa Uji',
                'email' => $uniqueEmail,
                'kategori' => 'PMB',
                'pesan' => 'Halo, saya ingin bertanya tentang jadwal pendaftaran PMB S1 Teknik Informatika.',
                'captcha_answer' => $expectedAnswer + 5,
            ]);
            $wrongRes->assertSessionHasErrors(['captcha_answer']);
            $this->assertDatabaseMissing('contact_messages', ['email' => $uniqueEmail]);

            // Valid CAPTCHA stores message
            $okRes = $this->post(route('homepage.kontak.submit'), [
                'nama' => 'Calon Mahasiswa Uji',
                'email' => $uniqueEmail,
                'kategori' => 'PMB',
                'pesan' => 'Halo, saya ingin bertanya tentang jadwal pendaftaran PMB S1 Teknik Informatika.',
                'captcha_answer' => $expectedAnswer,
            ]);
            $okRes->assertRedirect(route('homepage.kontak') . '#kirim-pesan')
                ->assertSessionHas('contact_success');

            $created = ContactMessage::where('email', $uniqueEmail)->first();
            $this->assertNotNull($created);
            $this->assertSame('baru', $created->status);
            $this->assertSame('PMB', $created->kategori);

            // Admin Kontak page shows the incoming message
            $this->actingAs($admin)->get(route('contact.index'))
                ->assertStatus(200)
                ->assertSee('Pesan Masuk Pengunjung')
                ->assertSee('Calon Mahasiswa Uji')
                ->assertSee($uniqueEmail);

            // Admin updates status to dibalas
            $this->actingAs($admin)->patch(route('contact.messages.status', $created->id), [
                'status' => 'dibalas',
            ])->assertRedirect(route('contact.index') . '#pesan-masuk');

            $created->refresh();
            $this->assertSame('dibalas', $created->status);
            $this->assertNotNull($created->read_at);

            // Admin deletes message
            $this->actingAs($admin)->delete(route('contact.messages.destroy', $created->id))
                ->assertRedirect(route('contact.index') . '#pesan-masuk');

            $this->assertDatabaseMissing('contact_messages', ['id' => $created->id]);
            $created = null;
        } finally {
            if ($created) {
                $created->delete();
            }
        }
    }
}
