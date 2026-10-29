<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopbarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'badge_text' => ['required', 'string', 'max:100'],
            'marquee_text' => ['nullable', 'string', 'max:1000'],
            'badge_icon' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'jam_operasional' => ['nullable', 'string', 'max:100'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'email', 'max:100'],
            'social_media' => ['nullable', 'array'],
            'social_media.*.platform' => ['nullable', 'string', 'max:100'],
            'social_media.*.icon' => ['nullable', 'string', 'max:50'],
            'social_media.*.url' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'badge_text.required' => 'Label badge topbar wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}
