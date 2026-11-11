<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Tests\TestCase;

class ContactFeatureTest extends TestCase
{
    public function test_guest_cannot_access_contact_admin(): void
    {
        $response = $this->get(route('contact.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_contact_direct_edit_view(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('contact.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Informasi Kontak', false);
        $response->assertSee('Simpan Perubahan Kontak');
        $response->assertDontSee('entries per page');
    }

    public function test_admin_can_update_contact_information(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['role' => 'admin']);
        }

        $contact = Contact::firstOrCreate([], [
            'no_wa' => '081234567890',
            'email' => 'old@uis.ac.id',
        ]);

        $payload = [
            'no_wa' => '089876543210',
            'email' => 'informatika@uis.ac.id',
            'alamat' => 'Gedung FST Kampus UIS Batam, Jl. Teuku Umar No. 1',
            'latitude' => '1.1444',
            'longitude' => '104.0156',
            'map' => '<iframe src="https://maps.google.com"></iframe>',
        ];

        $response = $this->actingAs($admin)->put(route('contact.update', $contact->id), $payload);
        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');

        $contact->refresh();
        $this->assertEquals('089876543210', $contact->no_wa);
        $this->assertEquals('informatika@uis.ac.id', $contact->email);
        $this->assertEquals('1.1444', $contact->latitude);
    }
}
