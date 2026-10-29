<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPmb extends Model
{
    use HasFactory;

    protected $table = 'informasi_pmbs';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'link_pendaftaran',
        'no_whatsapp',
        'banner_hero',
        'brosur_gambar',
        'brosur_pdf',
        'akreditasi_predikat',
        'akreditasi_teks',
        'keunggulan_items',
        'jadwal_gambar',
        'biaya_gambar',
        'alur_gambar',
        'reguler_b_nama',
        'reguler_b_biaya',
        'reguler_b_keterangan',
        'reguler_b_is_best',
        'reguler_a_nama',
        'reguler_a_biaya',
        'reguler_a_keterangan',
        'reguler_a_is_best',
        'reguler_c_nama',
        'reguler_c_biaya',
        'reguler_c_keterangan',
        'reguler_c_is_best',
        'banner_cta',
        'cta_judul',
        'cta_subjudul',
        'is_active',
    ];

    protected $casts = [
        'keunggulan_items' => 'array',
        'reguler_b_is_best' => 'boolean',
        'reguler_a_is_best' => 'boolean',
        'reguler_c_is_best' => 'boolean',
        'is_active' => 'boolean',
    ];

    public static function getOrCreate(): self
    {
        return self::firstOrCreate([], [
            'judul_hero' => 'Penerimaan Mahasiswa Baru FST UIS 2026',
            'subjudul_hero' => 'Tahun Akademik 2026/2027',
            'link_pendaftaran' => 'https://pmb.uis.ac.id',
            'no_whatsapp' => '081270000000',
            'akreditasi_predikat' => 'B',
            'akreditasi_teks' => 'Mutu Sangat Baik Terakreditasi dengan Predikat "B" oleh BAN-PT',
            'cta_judul' => 'Jadilah Bagian Dari Fakultas Sains Dan Teknologi UIS',
            'cta_subjudul' => 'Pendaftaran Telah Dibuka Sekarang',
            'reguler_b_nama' => 'Reguler B',
            'reguler_b_biaya' => 'Rp 625.000 / Bulan',
            'reguler_b_keterangan' => "Uang Kuliah Terjangkau\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa",
            'reguler_a_nama' => 'Reguler A',
            'reguler_a_biaya' => 'Rp 825.000 / Bulan',
            'reguler_a_keterangan' => "Kelas Pagi / Reguler Utama\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa",
            'reguler_c_nama' => 'Reguler C',
            'reguler_c_biaya' => 'Rp 925.000 / Bulan',
            'reguler_c_keterangan' => "Kelas Malam / Karyawan Fleksibel\nBiaya Praktikum Lab Komputer\nFree Akses WiFi Kampus\nPerpustakaan Digital\nJas Almamater Lengkap\nModul Kuliah Digital\nKTM Mahasiswa",
            'keunggulan_items' => [
                ['judul' => 'Biaya Kuliah', 'deskripsi' => 'Biaya terjangkau dengan skema cicilan bulanan yang ringan untuk mahasiswa.'],
                ['judul' => 'Lokasi Kampus', 'deskripsi' => 'Lokasi kampus strategis di pusat kota Batam, mudah dijangkau transportasi umum.'],
                ['judul' => 'Dosen Berpengalaman', 'deskripsi' => 'Dosen berkualifikasi S2 dan S3 lulusan universitas terkemuka dalam dan luar negeri.'],
                ['judul' => 'Pengembangan Bakat', 'deskripsi' => 'Didukung berbagai UKM kemahasiswaan, komunitas riset AI, coding, dan robotika.'],
                ['judul' => 'Waktu Kuliah', 'deskripsi' => 'Tersedia pilihan kelas pagi untuk reguler dan kelas sore/malam untuk yang bekerja.'],
                ['judul' => 'Fasilitas', 'deskripsi' => 'Laboratorium komputer modern ber-AC, koneksi internet berkecepatan tinggi.'],
                ['judul' => 'Beasiswa', 'deskripsi' => 'Tersedia Beasiswa KIP-Kuliah, Yayasan, Beasiswa Prestasi, BPDDI, dan kemitraan.'],
                ['judul' => 'Fasilitas Pendukung', 'deskripsi' => 'Perpustakaan digital terpadu, aula serbaguna, musholla, dan area parkir luas.'],
            ],
            'is_active' => true,
        ]);
    }
}

