<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 1. Validasi Login
        if ($this->routeIs('loginproses')) {
            return [
                'email' => ['required', 'email', 'max:100'],
                'password' => ['required', 'string', 'min:6'],
            ];
        }

        // 2. Validasi Update Password Pengguna (Admin atau Self)
        if ($this->routeIs('user.updatePassword') || $this->routeIs('user.update-my-password')) {
            return [
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ];
        }

        // 3. Validasi Update My Profile Sendiri
        if ($this->routeIs('user.update-my-profile')) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.($this->user()?->id ?? '')],
                'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
                'hapus_avatar' => ['nullable', 'boolean'],
            ];
        }

        // 4. Validasi CRUD User (Store & Update)
        $userId = $this->route('user')
            ? (is_object($this->route('user')) ? $this->route('user')->id : $this->route('user'))
            : null;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$userId],
            'roles' => ['required'],
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Login & Umum
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            // Password
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            // Nama & Role
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil harus berupa PNG, JPG, JPEG, atau WEBP.',
            'avatar.max' => 'Ukuran file foto profil maksimal 5MB.',
            'roles.required' => 'Role wajib dipilih.',
            'roles.in' => 'Role tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'roles' => 'Role',
        ];
    }
}
