<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'category' => ['required', 'string', 'in:akademik,pendaftaran,fasilitas,karir,pemesanan,spesifikasi,pengiriman'],
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan wajib diisi.',
            'question.string' => 'Pertanyaan harus berupa string.',
            'question.max' => 'Pertanyaan maksimal 255 karakter.',
            'answer.required' => 'Jawaban wajib diisi.',
            'answer.string' => 'Jawaban harus berupa string.',
            'category.required' => 'Kategori wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}
