<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;

class AlumniTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $normalize = fn ($val) => is_string($val) ? trim(preg_replace('/\s+/', ' ', $val)) : $val;

        $this->merge([
            'nama' => $normalize($this->input('nama')),
            'pekerjaan' => $normalize($this->input('pekerjaan')),
            'kategori' => $normalize($this->input('kategori')),
            'pesan' => is_string($this->input('pesan')) ? trim($this->input('pesan')) : $this->input('pesan'),
        ]);
    }

    public function rules(): array
    {
        return [
            'website_url' => ['nullable', 'max:0'], // Honeypot anti-bot
            'nama' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $normalized = mb_strtolower(trim((string) $value));
                    if ($normalized !== '' && Testimonial::whereRaw('LOWER(TRIM(nama)) = ?', [$normalized])->exists()) {
                        $fail('Nama tersebut sudah pernah mengirimkan testimoni sebelumnya.');
                    }
                },
            ],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:150'],
            'bintang' => ['required', 'integer', 'min:1', 'max:5'],
            'pesan' => [
                'required',
                'string',
                'min:10',
                'max:2000',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $normalized = mb_strtolower(trim((string) $value));
                    if ($normalized !== '' && Testimonial::whereRaw('LOWER(TRIM(pesan)) = ?', [$normalized])->exists()) {
                        $fail('Isi pesan testimoni yang sama sudah pernah dikirimkan sebelumnya.');
                    }
                },
            ],
            'captcha_answer' => [
                'required',
                'integer',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $expected = session('testimonial_captcha_answer');
                    if ($expected === null || (int) $value !== (int) $expected) {
                        $fail('Jawaban verifikasi keamanan (CAPTCHA) tidak sesuai. Silakan coba lagi.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'website_url.max' => 'Permintaan terdeteksi sebagai spam.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'pekerjaan.required' => 'Profesi / instansi / angkatan wajib diisi.',
            'kategori.required' => 'Kategori hubungan wajib dipilih.',
            'bintang.required' => 'Rating kepuasan bintang wajib dipilih.',
            'pesan.required' => 'Pesan / testimoni Anda wajib diisi.',
            'pesan.min' => 'Pesan testimoni minimal berisi 10 karakter.',
            'captcha_answer.required' => 'Jawaban verifikasi keamanan (CAPTCHA) wajib diisi.',
            'captcha_answer.integer' => 'Jawaban verifikasi keamanan (CAPTCHA) harus berupa angka.',
        ];
    }
}
