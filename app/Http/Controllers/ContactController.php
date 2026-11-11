<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Tampilkan halaman form edit kontak langsung (tanpa tabel).
     */
    public function index(): View
    {
        $contact = Contact::firstOrCreate([], [
            'no_wa' => '6281234567890',
            'email' => 'informatika@uis.ac.id',
            'alamat' => 'Kampus Utama Universitas Ibnu Sina, Jl. Teuku Umar, Lubuk Baja Kota, Kec. Lubuk Baja, Kota Batam, Kepulauan Riau 29444',
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
        $contact = Contact::firstOrCreate([]);

        $contact->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map' => $request->map,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }

    /**
     * Redirect route edit langsung ke halaman kontak utama.
     */
    public function edit(Contact $contact): RedirectResponse
    {
        return redirect()->route('contact.index');
    }

    /**
     * Simpan pembaruan data kontak.
     */
    public function update(ContactRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'map' => $request->map,
            'no_wa' => $request->no_wa,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Informasi kontak dan peta lokasi berhasil diperbarui.');
    }

    /**
     * Reset / Hapus data kontak.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
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
