<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Topbar;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Tampilkan halaman form edit kontak langsung (tanpa tabel).
     */
    public function index(): View
    {
        Contact::ensureSchema();

        $contact = Contact::firstOrCreate([], [
            'no_wa' => '6281234567890',
            'email' => 'informatika@uis.ac.id',
            'alamat' => 'Kampus Utama Universitas Ibnu Sina, Jl. Teuku Umar, Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
            'jam_operasional' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
            'latitude' => '1.1444',
            'longitude' => '104.0156',
        ]);

        return view('pages.contact.index', compact('contact'));
    }

    /**
     * Redirect route create langsung ke halaman edit kontak.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('contact.index');
    }

    /**
     * Simpan pembaruan informasi kontak (untuk backward compatibility jika store dipanggil).
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        return $this->update($request);
    }

    /**
     * Redirect route edit langsung ke halaman kontak utama.
     */
    public function edit(?Contact $contact = null): RedirectResponse
    {
        return redirect()->route('contact.index');
    }

    /**
     * Simpan pembaruan data kontak.
     */
    public function update(ContactRequest $request, ?Contact $contact = null): RedirectResponse
    {
        Contact::ensureSchema();

        $contact = ($contact instanceof Contact && $contact->exists)
            ? $contact
            : Contact::firstOrCreate([]);

        // Ekstrak URL embed jika input map berupa tag iframe untuk menghindari trigger ModSecurity WAF pada cPanel
        $map = $request->map;
        if (!empty($map)) {
            if (preg_match('/src=["\']([^"\']+)["\']/i', $map, $matches)) {
                $map = $matches[1];
            } else {
                $map = trim($map);
            }
        }

        $updateData = [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map' => $map,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        if (Schema::hasColumn('contacts', 'jam_operasional')) {
            $updateData['jam_operasional'] = $request->jam_operasional;
        }

        $contact->update($updateData);

        // Simpan ke file fallback untuk redundansi keamanan di hosting cPanel
        try {
            $fallbackFile = storage_path('app/contact_settings.json');
            $currentSettings = file_exists($fallbackFile) ? json_decode(@file_get_contents($fallbackFile), true) : [];
            if (!is_array($currentSettings)) {
                $currentSettings = [];
            }
            if ($request->filled('jam_operasional')) {
                $currentSettings['jam_operasional'] = $request->jam_operasional;
            }
            @file_put_contents($fallbackFile, json_encode($currentSettings, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {}

        // Sinkronkan ke topbar yang aktif jika tersedia
        try {
            if ($request->filled('jam_operasional') && Schema::hasTable('topbars') && Schema::hasColumn('topbars', 'jam_operasional')) {
                Topbar::where('is_active', true)->update(['jam_operasional' => $request->jam_operasional]);
            }
        } catch (\Throwable $e) {}

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Informasi kontak dan peta lokasi berhasil diperbarui.');
    }

    /**
     * Reset / Hapus data kontak.
     */
    public function destroy(?Contact $contact = null): RedirectResponse
    {
        $contact = ($contact instanceof Contact && $contact->exists)
            ? $contact
            : Contact::firstOrCreate([]);

        $contact->update([
            'latitude' => null,
            'longitude' => null,
            'map' => null,
            'no_wa' => null,
            'email' => null,
            'alamat' => null,
        ]);

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Data kontak berhasil dikosongkan.');
    }
}
