<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageHeader extends Model
{
    use HasFactory;

    protected $table = 'page_headers';

    protected $fillable = [
        'page_key',
        'judul',
        'subjudul',
        'badge_text',
        'breadcrumb_label',
    ];

    public static string $defaultBadge = 'PROGRAM STUDI TEKNIK INFORMATIKA · FAKULTAS SAINS DAN TEKNOLOGI';

    /**
     * Master defaults untuk seluruh halaman frontend
     */
    public static array $masterDefaults = [
        // ── AKADEMIK ──
        'kalender' => [
            'judul' => 'Kalender Akademik',
            'subjudul' => 'Jadwal perkuliahan, registrasi KRS, UTS, UAS, kerja praktik, dan kegiatan akademik Program Studi Teknik Informatika.',
            'breadcrumb' => 'Kalender Akademik',
            'category' => 'Akademik',
        ],
        'kurikulum' => [
            'judul' => 'Kurikulum & Capaian Pembelajaran',
            'subjudul' => 'Struktur kurikulum berbasis kompetensi dan Outcome-Based Education (OBE) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Kurikulum',
            'category' => 'Akademik',
        ],
        'pedoman' => [
            'judul' => 'Pedoman & Panduan Akademik',
            'subjudul' => 'Buku panduan tata tertib perkuliahan, prosedur kerja praktik, tugas akhir/skripsi, dan etika akademik.',
            'breadcrumb' => 'Pedoman Akademik',
            'category' => 'Akademik',
        ],
        'sistem' => [
            'judul' => 'Portal Sistem Informasi Akademik (SIAKAD)',
            'subjudul' => 'Layanan portal digital terpadu untuk pengisian KRS, presensi, nilai, dan pembelajaran daring.',
            'breadcrumb' => 'SIAKAD & E-Learning',
            'category' => 'Akademik',
        ],

        // ── PROFIL ──
        'sejarah' => [
            'judul' => 'Sejarah YAPISTA & Milestone Program Studi',
            'subjudul' => 'Perjalanan panjang Yayasan Pendidikan Ibnu Sina Batam (YAPISTA) dan sejarah pendirian Program Studi Teknik Informatika.',
            'breadcrumb' => 'Sejarah YAPISTA',
            'category' => 'Profil',
        ],
        'sambutan-kaprodi' => [
            'judul' => 'Sambutan Ketua Program Studi Teknik Informatika',
            'subjudul' => 'Pesan, arah pengembangan, dan komitmen keunggulan akademik dari Ketua Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Sambutan Kaprodi TF',
            'category' => 'Profil',
        ],
        'pimpinan' => [
            'judul' => 'Profil Pimpinan Program Studi',
            'subjudul' => 'Mengenal jajaran pimpinan dan pengelola akademik Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Profil Pimpinan',
            'category' => 'Profil',
        ],
        'struktur-organisasi' => [
            'judul' => 'Struktur Organisasi Program Studi',
            'subjudul' => 'Bagan tata kelola dan susunan pejabat struktural Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Struktur Organisasi',
            'category' => 'Profil',
        ],
        'visi-misi' => [
            'judul' => 'Visi, Misi, Tujuan & Sasaran (VMTS)',
            'subjudul' => 'Komitmen fundamental yang mengarahkan penyelenggaraan Tri Dharma Perguruan Tinggi di Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Visi Misi dan Tujuan TF',
            'category' => 'Profil',
        ],
        'fasilitas' => [
            'judul' => 'Fasilitas Kampus & Laboratorium',
            'subjudul' => 'Sarana laboratorium komputasi modern, perpustakaan, ruang kuliah ber-AC, dan fasilitas penunjang akademik Program Studi Teknik Informatika.',
            'breadcrumb' => 'Fasilitas Kampus',
            'category' => 'Profil',
        ],

        // ── DOSEN & CIVITAS ──
        'dosen' => [
            'judul' => 'Daftar Dosen Pengajar',
            'subjudul' => 'Tenaga pendidik berkualifikasi magister, doktor, dan profesor berdedikasi tinggi dalam membimbing mahasiswa Program Studi Teknik Informatika.',
            'breadcrumb' => 'Daftar Dosen Pengajar',
            'category' => 'Civitas',
        ],

        // ── PORTAL LAYANAN ──
        'tracer-study' => [
            'judul' => 'Tracer Study Alumni Teknik Informatika',
            'subjudul' => 'Kuesioner penelusuran lulusan dan pelacakan jejak karier alumni Program Studi Teknik Informatika.',
            'breadcrumb' => 'Tracer Study',
            'category' => 'Portal Layanan',
        ],
        'testimoni' => [
            'judul' => 'Testimoni & Pengalaman Alumni',
            'subjudul' => 'Cerita inspiratif dan jejak langkah sukses para alumni Program Studi Teknik Informatika di dunia industri dan profesional.',
            'breadcrumb' => 'Testimoni Alumni',
            'category' => 'Portal Layanan',
        ],
        'edokumen' => [
            'judul' => 'E-Dokumen & Berkas Resmi',
            'subjudul' => 'Pusat berkas dokumen resmi, buku pedoman perkuliahan, dan panduan akademik Program Studi Teknik Informatika.',
            'breadcrumb' => 'E-Dokumen',
            'category' => 'Portal Layanan',
        ],
        'sop' => [
            'judul' => 'SOP (Standar Operasional Prosedur)',
            'subjudul' => 'Pusat dokumen Standar Operasional Prosedur (SOP) dan panduan alur teknis Program Studi Teknik Informatika.',
            'breadcrumb' => 'SOP',
            'category' => 'Portal Layanan',
        ],
        'dokumen-akreditasi-tf' => [
            'judul' => 'Dokumen Akreditasi Program Studi Teknik Informatika',
            'subjudul' => 'Sertifikat akreditasi resmi dan dokumen penjaminan mutu Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Dokumen Akreditasi TF',
            'category' => 'Portal Layanan',
        ],
        'sertifikat-akreditasi' => [
            'judul' => 'Sertifikat Akreditasi Program Studi',
            'subjudul' => 'Pusat berkas resmi Sertifikat Akreditasi Program Studi di lingkungan Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Sertifikat Akreditasi',
            'category' => 'Portal Layanan',
        ],
        'laminfokom' => [
            'judul' => 'Akreditasi LAMINFOKOM — Teknik Informatika',
            'subjudul' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer (LAMINFOKOM) untuk Program Studi S1 Teknik Informatika.',
            'breadcrumb' => 'LAMINFOKOM',
            'category' => 'Portal Layanan',
        ],
        'ban-pt' => [
            'judul' => 'Akreditasi BAN-PT',
            'subjudul' => 'Informasi dan dokumen sertifikat akreditasi institusi serta program studi oleh Badan Akreditasi Nasional Perguruan Tinggi.',
            'breadcrumb' => 'BAN-PT',
            'category' => 'Portal Layanan',
        ],
        'beasiswa' => [
            'judul' => 'Program Beasiswa Kuliah',
            'subjudul' => 'Informasi dan panduan pengajuan berbagai program beasiswa bagi mahasiswa Program Studi Teknik Informatika.',
            'breadcrumb' => 'Beasiswa',
            'category' => 'Portal Layanan',
        ],
        'prestasi' => [
            'judul' => 'Prestasi Mahasiswa Teknik Informatika',
            'subjudul' => 'Koleksi prestasi gemilang, medali kejuaraan, dan capaian membanggakan sivitas akademika Teknik Informatika di tingkat regional, nasional, dan internasional.',
            'breadcrumb' => 'Prestasi Mahasiswa',
            'category' => 'Portal Layanan',
        ],
        'organisasi' => [
            'judul' => 'Organisasi & Kegiatan Mahasiswa',
            'subjudul' => 'Wadah pengembangan potensi, kepemimpinan, riset keilmuan, kreativitas, serta kepedulian sosial mahasiswa Teknik Informatika.',
            'breadcrumb' => 'Organisasi Mahasiswa',
            'category' => 'Portal Layanan',
        ],

        // ── PMB ──
        'pendaftaran-pmb' => [
            'judul' => 'Pendaftaran Mahasiswa Baru (PMB)',
            'subjudul' => 'Portal pendaftaran online calon mahasiswa baru Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Pendaftaran PMB',
            'category' => 'PMB',
        ],
        'informasi-pmb' => [
            'judul' => 'Informasi Penerimaan Mahasiswa Baru (PMB)',
            'subjudul' => 'Syarat pendaftaran, jadwal gelombang, rincian biaya pendidikan, dan alur seleksi masuk Program Studi Teknik Informatika.',
            'breadcrumb' => 'Informasi PMB',
            'category' => 'PMB',
        ],
        'pengumuman-pmb' => [
            'judul' => 'Pengumuman Hasil Seleksi PMB',
            'subjudul' => 'Informasi kelulusan seleksi calon mahasiswa baru dan panduan daftar ulang Program Studi Teknik Informatika.',
            'breadcrumb' => 'Pengumuman Hasil Seleksi PMB',
            'category' => 'PMB',
        ],

        // ── INFORMASI & GALERI ──
        'berita' => [
            'judul' => 'Berita & Warta Kampus',
            'subjudul' => 'Kumpulan warta kegiatan akademik, seminar, riset terapan, dan inovasi civitas akademika Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Berita & Warta Kampus',
            'category' => 'Informasi & Galeri',
        ],
        'galeri' => [
            'judul' => 'Galeri Foto & Dokumentasi',
            'subjudul' => 'Dokumentasi visual kegiatan perkuliahan, praktikum laboratorium, seminar nasional, pengabdian masyarakat, dan wisuda.',
            'breadcrumb' => 'Galeri & Dokumentasi',
            'category' => 'Informasi & Galeri',
        ],
        'faq' => [
            'judul' => 'Tanya Jawab (FAQ)',
            'subjudul' => 'Jawaban lengkap atas pertanyaan yang paling sering diajukan seputar pendaftaran, perkuliahan, dan layanan akademik Program Studi Teknik Informatika.',
            'breadcrumb' => 'FAQ',
            'category' => 'Informasi & Galeri',
        ],
        'kontak' => [
            'judul' => 'Hubungi Kami',
            'subjudul' => 'Informasi alamat kampus, kontak resmi, surel, dan saluran konsultasi Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Kontak',
            'category' => 'Kontak',
        ],
        'layanan' => [
            'judul' => 'Program Studi & Fasilitas',
            'subjudul' => 'Jelajahi program studi unggulan serta sarana prasarana akademik terpadu di lingkungan Fakultas Sains dan Teknologi.',
            'breadcrumb' => 'Program Studi',
            'category' => 'Program Studi',
        ],
    ];

    /**
     * Dapatkan header halaman dengan fallback default
     */
    public static function get(string $key, ?string $fallbackJudul = null, ?string $fallbackSubjudul = null, ?string $fallbackBreadcrumb = null): self
    {
        $def = self::$masterDefaults[$key] ?? [];

        $judul = $fallbackJudul ?? ($def['judul'] ?? ucwords(str_replace('-', ' ', $key)));
        $subjudul = $fallbackSubjudul ?? ($def['subjudul'] ?? 'Informasi resmi Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.');
        $breadcrumb = $fallbackBreadcrumb ?? ($def['breadcrumb'] ?? $judul);

        return static::firstOrCreate(
            ['page_key' => $key],
            [
                'judul' => $judul,
                'subjudul' => $subjudul,
                'badge_text' => self::$defaultBadge,
                'breadcrumb_label' => $breadcrumb,
            ]
        );
    }
}
