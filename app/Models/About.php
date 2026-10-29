<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';

    protected $fillable = [
        'judul_profil',
        'deskripsi_profil_1',
        'deskripsi_profil_2',
        'video_url',
        'video_file',
        'visi',
        'visi_judul',
        'visi_icon',
        'misi',
        'misi_judul',
        'misi_icon',
        'judul_nilai',
        'deskripsi_nilai',
        'nilai_1_judul',
        'nilai_1_deskripsi',
        'nilai_1_icon',
        'nilai_2_judul',
        'nilai_2_deskripsi',
        'nilai_2_icon',
        'nilai_3_judul',
        'nilai_3_deskripsi',
        'nilai_3_icon',
        'nilai_4_judul',
        'nilai_4_deskripsi',
        'nilai_4_icon',
        'sejarah_label',
        'sejarah_judul',
        'sejarah_judul_highlight',
        'sejarah_deskripsi_1',
        'sejarah_deskripsi_2',
        'sejarah_card_judul',
        'sejarah_card_subjudul',
        'sejarah_card_narasi',
        'sejarah_pilar_1',
        'sejarah_pilar_2',
        'sejarah_pilar_3',
        'sejarah_link_url',
        'sejarah_link_label',
        'sejarah_pimpinan_judul',
        'sejarah_pimpinan',
    ];

    protected $casts = [
        'sejarah_pimpinan' => 'array',
    ];

    /**
     * Default data Pimpinan dari Masa ke Masa
     */
    public static function defaultSejarahPimpinan(): array
    {
        return [
            [
                'era' => 'Era Sekolah Tinggi Teknik (STT) Ibnu Sina',
                'items' => [
                    ['periode' => '2001–2005', 'pimpinan' => 'Ir. Zaenal'],
                    ['periode' => '2005–2009', 'pimpinan' => 'Ir. Anwar Badruzaman, MT'],
                    ['periode' => '2009–2013', 'pimpinan' => 'Assoc. Prof. Dr. Ir. Larisang, MT., IPU'],
                    ['periode' => '2013–2018', 'pimpinan' => 'Assoc. Prof. Dr. Ir. Larisang, MT., IPU'],
                ],
            ],
            [
                'era' => 'Era Fakultas Teknik (FT) Universitas Ibnu Sina',
                'items' => [
                    ['periode' => '2019–2024', 'pimpinan' => 'Assoc. Prof. Dr. Ir. Larisang, MT., IPU'],
                ],
            ],
            [
                'era' => 'Era Fakultas Sains dan Teknologi (FST) Universitas Ibnu Sina',
                'items' => [
                    ['periode' => '2025–sekarang', 'pimpinan' => 'Ir. Sanusi, ST., M.Eng., Ph.D., IPM'],
                ],
            ],
        ];
    }

    public function getSejarahPimpinanListAttribute(): array
    {
        $data = $this->sejarah_pimpinan;
        if (is_array($data) && count($data) > 0) {
            return $data;
        }

        return self::defaultSejarahPimpinan();
    }

    /**
     * Ekstrak 11 digit video ID YouTube dari sejarah_link_url jika berupa link YouTube.
     */
    public function getSejarahYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->sejarah_link_url)) {
            return null;
        }

        $input = trim($this->sejarah_link_url);

        if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $input, $frameMatch)) {
            $input = $frameMatch[1];
        }

        if (preg_match('/^[a-zA-Z0-9_\-]{11}$/', $input)) {
            return $input;
        }

        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|live|shorts)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/i', $input, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function getSejarahYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->sejarah_youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/embed/' . $id;
        }

        return null;
    }

    public function getSejarahExternalUrlAttribute(): ?string
    {
        if (empty($this->sejarah_link_url)) {
            return null;
        }

        $id = $this->sejarah_youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/watch?v=' . $id;
        }

        $url = trim($this->sejarah_link_url);
        if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $url, $frameMatch)) {
            return $frameMatch[1];
        }

        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://') && ! str_starts_with($url, '/')) {
            return 'https://' . $url;
        }

        return $url;
    }

    /**
     * Cek apakah terdapat video (baik URL maupun file upload).
     */
    public function hasVideo(): bool
    {
        return ! empty($this->video_url) || ! empty($this->video_file);
    }

    /**
     * Ekstrak 11 digit video ID YouTube dari segala jenis format link atau kode iframe.
     */
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $input = trim($this->video_url);

        // Jika user mem-paste seluruh kode <iframe>
        if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $input, $frameMatch)) {
            $input = $frameMatch[1];
        }

        // Jika user langsung memasukkan 11 karakter video ID
        if (preg_match('/^[a-zA-Z0-9_\-]{11}$/', $input)) {
            return $input;
        }

        // Regex universal untuk segala macam variasi format URL YouTube
        if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?|live|shorts)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_\-]{11})/i', $input, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Konversi URL video YouTube / external ke format embed iframe resmi.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/embed/'.$id;
        }

        if (! empty($this->video_url)) {
            $url = trim($this->video_url);
            if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $url, $frameMatch)) {
                return $frameMatch[1];
            }

            return $url;
        }

        return null;
    }

    /**
     * URL tautan langsung ke halaman tonton YouTube.
     */
    public function getYoutubeWatchUrlAttribute(): ?string
    {
        $id = $this->youtube_video_id;
        if ($id) {
            return 'https://www.youtube.com/watch?v='.$id;
        }

        return ! empty($this->video_url) ? trim($this->video_url) : null;
    }
}
