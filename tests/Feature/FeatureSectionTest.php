<?php

namespace Tests\Feature;

use App\Models\Feature;
use App\Models\User;
use Tests\TestCase;

class FeatureSectionTest extends TestCase
{
    public function test_homepage_displays_dynamic_features_from_database_without_hardcoded_irrelevant_items(): void
    {
        $response = $this->get(route('homepage'));
        $response->assertStatus(200);

        $response->assertDontSee('studio teknik industri', false);
        $response->assertDontSee('pengujian K3 lingkungan', false);
        $response->assertDontSee('perancangan logistik', false);

        $firstFeature = Feature::orderBy('urutan')->first();
        if ($firstFeature) {
            $response->assertSee($firstFeature->judul);
        }
    }

    public function test_admin_created_updated_and_deleted_feature_reflects_on_homepage(): void
    {
        $admin = User::first();
        if (!$admin) {
            $admin = User::factory()->create(['roles' => 'admin']);
        }

        $uniqueTitle = 'Keunggulan Uji Dinamis ' . uniqid();
        $uniqueDesc = 'Deskripsi keunggulan khusus Program Studi Teknik Informatika.';

        // 1. Tambah keunggulan baru lewat menu admin
        $createRes = $this->actingAs($admin)->post(route('feature.store'), [
            'icon' => 'bi-code-slash',
            'judul' => $uniqueTitle,
            'deskripsi' => '<p>' . $uniqueDesc . '</p>',
            'urutan' => 99,
        ]);
        $createRes->assertRedirect(route('feature.index'));

        $feature = Feature::where('judul', $uniqueTitle)->first();
        $this->assertNotNull($feature);

        // Pastikan langsung tampil di beranda website
        $homeRes = $this->get(route('homepage'));
        $homeRes->assertStatus(200);
        $homeRes->assertSee($uniqueTitle, false);
        $homeRes->assertSee($uniqueDesc, false);
        $homeRes->assertSee('bi bi-code-slash', false);

        // 2. Edit keunggulan
        $updatedTitle = $uniqueTitle . ' Diperbarui';
        $updateRes = $this->actingAs($admin)->put(route('feature.update', $feature->id), [
            'icon' => 'bi bi-cpu',
            'judul' => $updatedTitle,
            'deskripsi' => $uniqueDesc,
            'urutan' => 100,
        ]);
        $updateRes->assertRedirect(route('feature.index'));

        $homeResAfterUpdate = $this->get(route('homepage'));
        $homeResAfterUpdate->assertStatus(200);
        $homeResAfterUpdate->assertSee($updatedTitle, false);
        $homeResAfterUpdate->assertDontSee($uniqueTitle . '</div>', false);

        // 3. Hapus keunggulan (bersihkan data uji)
        $deleteRes = $this->actingAs($admin)->delete(route('feature.destroy', $feature->id));
        $deleteRes->assertRedirect(route('feature.index'));

        $homeResAfterDelete = $this->get(route('homepage'));
        $homeResAfterDelete->assertStatus(200);
        $homeResAfterDelete->assertDontSee($updatedTitle, false);
    }
}
