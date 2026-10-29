<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna via DataTables.
     */
    public function index(UserDataTable $dataTables)
    {
        return $dataTables->render('pages.user.index');
    }

    /**
     * Tampilkan form tambah pengguna.
     */
    public function create(): View
    {
        return view('pages.user.create');
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $roles = is_array($request->roles) ? implode(',', array_filter($request->roles)) : $request->roles;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $roles ?: 'user',
        ]);

        alert()->success('Berhasil!', 'Pengguna berhasil ditambahkan.');

        return redirect()->route('user.index');
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit(User $user): View
    {
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update data pengguna.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $roles = is_array($request->roles) ? implode(',', array_filter($request->roles)) : $request->roles;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $roles ?: 'user',
        ];

        // Hanya update password jika field diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        alert()->success('Berhasil!', 'Data pengguna berhasil diperbarui.');

        return redirect()->route('user.index');
    }

    /**
     * Hapus pengguna.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Cegah hapus akun sendiri
        if ($user->id === Auth::id()) {
            alert()->error('Gagal!', 'Anda tidak bisa menghapus akun Anda sendiri.');

            return redirect()->route('user.index');
        }

        $user->delete();

        alert()->success('Berhasil!', 'Pengguna berhasil dihapus.');

        return redirect()->route('user.index');
    }

    /**
     * Tampilkan halaman My Profile untuk user yang sedang login.
     */
    public function myProfile(): View
    {
        $user = Auth::user();

        return view('pages.user.my-profile', compact('user'));
    }

    /**
     * Update profil (nama, email & foto avatar) user yang sedang login.
     */
    public function updateMyProfile(UserRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle upload avatar baru
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('hapus_avatar')) {
            // Jika memilih hapus foto (kembali ke default inisial)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = null;
        }

        $user->update($data);

        alert()->success('Berhasil!', 'Profil akun Anda berhasil diperbarui.');

        return redirect()->route('user.my-profile');
    }

    /**
     * Update password user yang sedang login.
     */
    public function updateMyPassword(UserRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        alert()->success('Berhasil!', 'Password akun Anda berhasil diperbarui.');

        return redirect()->route('user.my-profile');
    }

    /**
     * Tampilkan form update password.
     */
    public function updatePasswordForm(User $user): View
    {
        return view('pages.user.update-password', compact('user'));
    }

    /**
     * Proses update password pengguna (oleh Admin).
     */
    public function updatePassword(UserRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        alert()->success('Berhasil!', 'Password pengguna berhasil diperbarui.');

        return redirect()->route('user.index');
    }
}
