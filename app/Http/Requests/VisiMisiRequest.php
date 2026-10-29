<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisiMisiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipe' => ['required', 'in:visi,misi,tujuan,sasaran'],
            'isi' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipe.required' => 'Tipe wajib dipilih.',
            'tipe.in' => 'Tipe harus Visi, Misi, Tujuan, atau Sasaran.',
            'isi.required' => 'Isi wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ];
    }
}
