<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,webp|max:10240',
            'link_url' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul pengumuman wajib diisi.',
            'date.required' => 'Tanggal pengumuman wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'file.max' => 'Ukuran file lampiran maksimal 10 MB.',
            'file.mimes' => 'Format lampiran yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, WEBP.',
        ];
    }
}

