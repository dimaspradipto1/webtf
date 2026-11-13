<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ThemeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_bg_color',
        'header_text_color',
        'header_active_bg_color',
        'header_active_text_color',
        'header_login_bg_color',
        'header_login_text_color',
        'header_lang_bg_color',
        'header_lang_text_color',
        'header_shadow_color',
        'header_is_sticky',
        'header_logo',
        'header_title',
        'header_subtitle',
        'topbar_bg_color',
        'topbar_text_color',
        'topbar_social_bg_color',
        'topbar_social_text_color',
        'accent_color',
        'sections_order',
        'footer_bg_color',
        'footer_text_color',
        'footer_heading_color',
        'footer_border_top_color',
        'footer_link_color',
        'footer_link_hover_color',
        'footer_social_bg_color',
        'footer_social_text_color',
        'footer_description',
        'footer_copyright',
    ];

    protected $casts = [
        'sections_order' => 'array',
        'header_is_sticky' => 'boolean',
    ];

    /**
     * Definisi default urutan dan status seluruh section di beranda.
     */
    public static function defaultSections(): array
    {
        return [
            [
                'key' => 'hero_banner',
                'name' => 'Banner Hero Promosi',
                'desc' => 'Slider carousel banner promosi di bagian paling atas beranda',
                'icon' => 'bi-image',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'key' => 'sambutan',
                'name' => 'Sambutan Ketua Program Studi',
                'desc' => 'Pesan dan sambutan resmi Kaprodi S1 Teknik Informatika',
                'icon' => 'bi-person-badge',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'key' => 'keunggulan',
                'name' => 'Mengapa Memilih Teknik Informatika',
                'desc' => 'Pilar keunggulan, kurikulum industri, dan fasilitas prodi',
                'icon' => 'bi-stars',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'key' => 'pmb_banner',
                'name' => 'Banner PMB & Pendaftaran',
                'desc' => 'Ajakan pendaftaran mahasiswa baru dan portal PMB',
                'icon' => 'bi-mortarboard-fill',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'key' => 'fasilitas',
                'name' => 'Fasilitas & Laboratorium',
                'desc' => 'Laboratorium komputer, server, software studio, dan ruang kuliah',
                'icon' => 'bi-laptop',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'key' => 'prestasi',
                'name' => 'Prestasi Mahasiswa',
                'desc' => 'Pencapaian mahasiswa di tingkat nasional dan internasional',
                'icon' => 'bi-trophy-fill',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'key' => 'ormawa',
                'name' => 'Organisasi & Komunitas Mahasiswa',
                'desc' => 'Showcase tumpukan kartu ormawa dan UKM prodi TI',
                'icon' => 'bi-diagram-3-fill',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'key' => 'galeri',
                'name' => 'Galeri Dokumentasi Kampus',
                'desc' => 'Foto kegiatan workshop, seminar, dan praktikum kampus',
                'icon' => 'bi-images',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'key' => 'alumni',
                'name' => 'Alumni & Karir Lulusan',
                'desc' => 'Testimoni alumni dan serapan kerja lulusan TI',
                'icon' => 'bi-briefcase-fill',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'key' => 'layanan_terkait',
                'name' => 'Layanan Terkait Kampus',
                'desc' => 'Carousel 3D portal akademik, perpustakaan, dan tracer study',
                'icon' => 'bi-collection-play-fill',
                'is_active' => true,
                'order' => 10,
            ],
            [
                'key' => 'media_sosial',
                'name' => 'Media Sosial Fakultas & Prodi',
                'desc' => 'Feed dan link akun Instagram, YouTube, dan medsos resmi',
                'icon' => 'bi-instagram',
                'is_active' => true,
                'order' => 11,
            ],
            [
                'key' => 'berita',
                'name' => 'Berita, Pengumuman & Agenda',
                'desc' => 'Artikel berita terkini, pengumuman akademik, dan agenda prodi',
                'icon' => 'bi-newspaper',
                'is_active' => true,
                'order' => 12,
            ],
            [
                'key' => 'partner',
                'name' => 'Mitra Kerjasama Riset & Industri',
                'desc' => 'Logo jejaring mitra perusahaan teknologi dan universitas',
                'icon' => 'bi-handshake-fill',
                'is_active' => true,
                'order' => 13,
            ],
            [
                'key' => 'faq',
                'name' => 'Tanya Jawab (FAQ)',
                'desc' => 'Pertanyaan yang sering diajukan calon mahasiswa dan orang tua',
                'icon' => 'bi-question-circle-fill',
                'is_active' => true,
                'order' => 14,
            ],
        ];
    }

    /**
     * Dapatkan instance setting tunggal (singleton pattern) dengan fallback aman.
     */
    public static function current(): self
    {
        // Pastikan kolom baru otomatis dibuat jika database belum menjalankan migrasi
        try {
            if (Schema::hasTable('theme_settings')) {
                if (!Schema::hasColumn('theme_settings', 'header_logo')) {
                    Schema::table('theme_settings', function (Blueprint $table) {
                        if (!Schema::hasColumn('theme_settings', 'header_logo')) {
                            $table->string('header_logo')->nullable()->after('header_is_sticky');
                        }
                        if (!Schema::hasColumn('theme_settings', 'header_title')) {
                            $table->string('header_title')->nullable()->default('TEKNIK INFORMATIKA')->after('header_logo');
                        }
                        if (!Schema::hasColumn('theme_settings', 'header_subtitle')) {
                            $table->string('header_subtitle')->nullable()->default('Fakultas Sains dan Teknologi')->after('header_title');
                        }
                    });
                }
                if (!Schema::hasColumn('theme_settings', 'header_lang_bg_color')) {
                    Schema::table('theme_settings', function (Blueprint $table) {
                        if (!Schema::hasColumn('theme_settings', 'header_lang_bg_color')) {
                            $table->string('header_lang_bg_color')->nullable()->default('#000000')->after('header_login_text_color');
                        }
                        if (!Schema::hasColumn('theme_settings', 'header_lang_text_color')) {
                            $table->string('header_lang_text_color')->nullable()->default('#ffffff')->after('header_lang_bg_color');
                        }
                    });
                }
            }
        } catch (\Throwable $e) {
            // Lanjutkan jika koneksi DB tidak memiliki izin DDL
        }

        $setting = static::first();
        if (!$setting) {
            $hasLogo = Schema::hasColumn('theme_settings', 'header_logo');
            $hasTitle = Schema::hasColumn('theme_settings', 'header_title');
            $hasSubtitle = Schema::hasColumn('theme_settings', 'header_subtitle');
            $hasLangBg = Schema::hasColumn('theme_settings', 'header_lang_bg_color');
            $hasLangTxt = Schema::hasColumn('theme_settings', 'header_lang_text_color');

            $createData = [
                'header_bg_color' => '#f9dc4b',
                'header_text_color' => '#ffffff',
                'header_active_bg_color' => '#000000',
                'header_active_text_color' => '#ffffff',
                'header_login_bg_color' => '#000000',
                'header_login_text_color' => '#ffffff',
                'header_shadow_color' => '#f9dc4b',
                'header_is_sticky' => true,
                'topbar_bg_color' => '#000000',
                'topbar_text_color' => '#ffffff',
                'topbar_social_bg_color' => '#ffffff',
                'topbar_social_text_color' => '#000000',
                'accent_color' => '#f9dc4b',
                'sections_order' => static::defaultSections(),
                'footer_bg_color' => '#000000',
                'footer_text_color' => '#ffffff',
                'footer_heading_color' => '#f9dc4b',
                'footer_border_top_color' => '#f9dc4b',
                'footer_link_color' => '#ffffff',
                'footer_link_hover_color' => '#f9dc4b',
                'footer_social_bg_color' => '#f9dc4b',
                'footer_social_text_color' => '#000000',
                'footer_description' => 'Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi. Berkomitmen menyelenggarakan pendidikan tinggi teknologi informasi yang unggul, bermartabat, bereputasi nasional dan internasional, serta berjiwa technopreneur berbasis Imtaq.',
                'footer_copyright' => '© ' . date('Y') . ' Program Studi Teknik Informatika — Fakultas Sains dan Teknologi. All rights reserved.',
            ];

            if ($hasLogo) {
                $createData['header_logo'] = null;
            }
            if ($hasTitle) {
                $createData['header_title'] = 'TEKNIK INFORMATIKA';
            }
            if ($hasSubtitle) {
                $createData['header_subtitle'] = 'Fakultas Sains dan Teknologi';
            }
            if ($hasLangBg) {
                $createData['header_lang_bg_color'] = '#000000';
            }
            if ($hasLangTxt) {
                $createData['header_lang_text_color'] = '#ffffff';
            }

            $setting = static::create($createData);
        }
        return $setting;
    }

    public function getHeaderLangBgColorAttribute($value): string
    {
        return !empty($value) ? $value : '#000000';
    }

    public function getHeaderLangTextColorAttribute($value): string
    {
        return !empty($value) ? $value : '#ffffff';
    }

    /**
     * Dapatkan URL logo brand header dengan fallback aman ke logouis.png.
     */
    public function getLogoUrlAttribute(): string
    {
        $logo = $this->attributes['header_logo'] ?? null;
        if (!empty($logo)) {
            if (Storage::disk('public')->exists($logo)) {
                return asset('storage/' . $logo);
            }
            if (file_exists(public_path('storage/' . $logo))) {
                return asset('storage/' . $logo);
            }
        }
        return asset('assets/img/logouis.png');
    }

    /**
     * Dapatkan teks judul utama header dengan fallback default.
     */
    public function getHeaderTitleAttribute($value): string
    {
        return !empty($value) ? $value : 'TEKNIK INFORMATIKA';
    }

    /**
     * Dapatkan teks subjudul header dengan fallback default.
     */
    public function getHeaderSubtitleAttribute($value): string
    {
        return !empty($value) ? $value : 'Fakultas Sains dan Teknologi';
    }

    /**
     * Cek apakah menggunakan logo kustom hasil upload.
     */
    public function hasCustomLogo(): bool
    {
        $logo = $this->attributes['header_logo'] ?? null;
        return !empty($logo) && Storage::disk('public')->exists($logo);
    }

    /**
     * Ambil array section yang sudah terurut dan sinkron dengan default sections.
     */
    public function getActiveSectionsList(): array
    {
        $defaults = static::defaultSections();
        $saved = is_array($this->sections_order) ? $this->sections_order : [];

        // Buat map dari saved order
        $savedMap = [];
        foreach ($saved as $idx => $item) {
            if (isset($item['key'])) {
                $savedMap[$item['key']] = [
                    'order' => $item['order'] ?? ($idx + 1),
                    'is_active' => isset($item['is_active']) ? (bool) $item['is_active'] : true,
                ];
            }
        }

        // Gabungkan dengan defaults agar info deskripsi/nama/icon selalu lengkap
        $merged = [];
        foreach ($defaults as $idx => $def) {
            $k = $def['key'];
            $order = isset($savedMap[$k]['order']) ? (int) $savedMap[$k]['order'] : ($idx + 1);
            $isActive = isset($savedMap[$k]['is_active']) ? (bool) $savedMap[$k]['is_active'] : $def['is_active'];

            $merged[] = array_merge($def, [
                'order' => $order,
                'is_active' => $isActive,
            ]);
        }

        // Urutkan berdasarkan 'order' asc
        usort($merged, fn($a, $b) => $a['order'] <=> $b['order']);

        return $merged;
    }
}

