<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'icon_preset' => $this->filled('icon_preset') ? $this->icon_preset : 'pdf',
            'is_active' => $this->has('is_active') ? true : false,
            'urutan' => $this->filled('urutan') ? (int) $this->urutan : 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'tipe_file' => ['nullable', 'string', 'max:50'],
            'link_drive' => ['required', 'string', 'max:1000'],
            'icon_preset' => ['nullable', 'string', 'max:50'],
            'custom_icon' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:5120'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Nama / Judul dokumen SOP wajib diisi.',
            'judul.max' => 'Nama judul dokumen maksimal 255 karakter.',
            'link_drive.required' => 'Link Google Drive dokumen SOP wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
