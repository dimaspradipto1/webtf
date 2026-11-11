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
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get(route('contact.index'));
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Informasi Kontak', false);
        $response->assertSee('Simpan Perubahan Kontak');
        $response->assertDontSee('entries per page');
        // Pastikan route URL menggunakan slug admin-kontak tanpa ID
        $this->assertStringContainsString('admin-kontak', route('contact.index'));
        $this->assertStringContainsString('admin-kontak', route('contact.update'));
    }

    public function test_admin_can_update_contact_information_using_slug_route_without_id(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
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
            'map' => '<iframe src="https://maps.google.com/embed/test"></iframe>',
        ];

        // Kirim via POST langsung ke route('contact.update') tanpa ID pada URL
        $response = $this->actingAs($admin)->post(route('contact.update'), $payload);
        $response->assertRedirect(route('contact.index'));
        $response->assertSessionHas('success');

        $contact->refresh();
        $this->assertEquals('089876543210', $contact->no_wa);
        $this->assertEquals('informatika@uis.ac.id', $contact->email);
        $this->assertEquals('1.1444', $contact->latitude);
        // Tag iframe harus otomatis diekstrak menjadi URL aman untuk menghindari blokir ModSecurity cPanel
        $this->assertEquals('https://maps.google.com/embed/test', $contact->map);
        $this->assertEquals('https://maps.google.com/embed/test', $contact->map_embed_url);
        $this->assertStringContainsString('<iframe src="https://maps.google.com/embed/test"', $contact->map_iframe);
    }

    public function test_legacy_contact_url_redirects_to_slug_route(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $response = $this->actingAs($admin)->get('/contact');
        $response->assertRedirect(route('contact.index'));
    }
}
