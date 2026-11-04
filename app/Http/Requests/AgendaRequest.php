<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'date_text' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul agenda / kegiatan wajib diisi.',
            'date_text.required' => 'Teks jadwal agenda wajib diisi (contoh: 20 - 31 Juli 2026).',
        ];
    }
}

