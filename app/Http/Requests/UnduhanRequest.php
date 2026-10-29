<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnduhanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? true : false,
            'urutan' => $this->filled('urutan') ? (int) $this->urutan : 0,
            'kategori' => $this->filled('kategori') ? $this->kategori : 'Dokumen',
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'file' => ['nullable', 'file', 'max:51200'], // maks 50MB
            'file_url' => ['nullable', 'url', 'max:1000'],
            'file_size' => ['nullable', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Nama / Judul dokumen wajib diisi.',
            'judul.max' => 'Nama judul dokumen maksimal 255 karakter.',
            'file.file' => 'Berkas harus berupa file yang valid.',
            'file.max' => 'Ukuran file maksimal 50 MB.',
            'file_url.url' => 'Format tautan/link dokumen tidak valid.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
