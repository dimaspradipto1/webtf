<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'judul' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ];

        $isArrayFoto = is_array($this->file('foto'));

        if ($this->isMethod('POST')) {
            if ($isArrayFoto) {
                $rules['foto'] = ['required', 'array', 'min:1'];
                $rules['foto.*'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
            } else {
                $rules['foto'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
            }
        } else {
            if ($isArrayFoto) {
                $rules['foto'] = ['nullable', 'array'];
                $rules['foto.*'] = ['image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
            } else {
                $rules['foto'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 20 MB.',
            'foto.*.image' => 'Setiap file harus berupa gambar.',
            'foto.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'foto.*.max' => 'Ukuran setiap gambar maksimal 20 MB.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori galeri wajib dipilih.',
        ];
    }
}
