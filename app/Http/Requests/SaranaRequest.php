<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaranaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isArrayFoto = is_array($this->file('foto'));

        return [
            'icon' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'foto' => $isArrayFoto
                ? ['nullable', 'array']
                : ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'foto.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:20480'],
            'hapus_foto' => ['nullable', 'array'],
            'hapus_foto.*' => ['string'],
            'kepala_lab' => ['nullable', 'string', 'max:200'],
            'lokasi' => ['nullable', 'string', 'max:200'],
            'kapasitas' => ['nullable', 'string', 'max:100'],
            'daftar_perangkat' => ['nullable', 'string', 'max:5000'],
            'mata_kuliah_praktikum' => ['nullable', 'string', 'max:5000'],
            'jadwal_pemakaian' => ['nullable', 'string', 'max:5000'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'icon.required' => 'Icon Bootstrap wajib diisi.',
            'nama.required' => 'Nama sarana / laboratorium wajib diisi.',
            'foto.image' => 'Foto ruangan harus berupa file gambar.',
            'foto.max' => 'Ukuran foto ruangan maksimal 20 MB.',
            'foto.*.image' => 'Setiap foto ruangan harus berupa file gambar (JPG, PNG, WEBP).',
            'foto.*.max' => 'Ukuran setiap foto ruangan maksimal 20 MB.',
        ];
    }
}
