<?php

namespace App\Http\Controllers;

use App\Http\Requests\AkademikRequest;
use App\Models\Akademik;
use App\Models\KalenderAkademikItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AkademikController extends Controller
{
    /**
     * Default defaults for each academic & portal category
     */
    public static array $defaults = [
        'kurikulum' => [
            'judul' => 'Kurikulum Teknik Informatika',
            'subjudul' => 'Struktur kurikulum berbasis kompetensi dan Outcome-Based Education (OBE) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'deskripsi' => '<p>Kurikulum Program Studi Teknik Informatika Fakultas Sains dan Teknologi dirancang untuk menghasilkan lulusan sarjana komputer (S.Kom) yang kompeten di bidang Rekayasa Perangkat Lunak, Kecerdasan Buatan (AI), Keamanan Siber, dan Jaringan Komputer, mengacu pada KKNI dan standar LAMINFOKOM.</p>',
            'link_url' => '',
        ],
        'kalender' => [
            'judul' => 'Kalender Akademik',
            'subjudul' => 'Jadwal perkuliahan, registrasi KRS, UTS, UAS, kerja praktik, dan kegiatan akademik Program Studi Teknik Informatika.',
            'deskripsi' => '<p>Kalender Akademik memuat seluruh linimasa kegiatan perkuliahan Semester Ganjil dan Genap pada Program Studi Teknik Informatika Fakultas Sains dan Teknologi, termasuk masa registrasi ulang, pengisian KRS, bimbingan akademik, seminar proposal, sidang skripsi, hingga yudisium dan wisuda.</p>',
            'link_url' => '',
        ],
        'pedoman' => [
            'judul' => 'Pedoman & Panduan Akademik Program Studi Teknik Informatika',
            'subjudul' => 'Buku panduan tata tertib perkuliahan, prosedur kerja praktik, tugas akhir/skripsi, dan etika akademik.',
            'deskripsi' => '<p>Buku Pedoman Akademik merupakan acuan utama bagi seluruh civitas akademika Program Studi Teknik Informatika Fakultas Sains dan Teknologi dalam menjalankan aktivitas belajar-mengajar, praktikum laboratorium, evaluasi hasil belajar, dan layanan kemahasiswaan.</p>',
            'link_url' => '',
        ],
        'sistem' => [
            'judul' => 'Portal Sistem Informasi Akademik (SIAKAD & E-Learning)',
            'subjudul' => 'Layanan portal digital terpadu untuk pengisian KRS, presensi, nilai, dan pembelajaran daring.',
            'deskripsi' => '<p>Sistem Informasi Akademik (SIAKAD) Program Studi Teknik Informatika memfasilitasi mahasiswa dan dosen dalam proses administrasi perkuliahan secara daring, cepat, dan transparan.</p>',
            'link_url' => 'https://siakad.uis.ac.id',
        ],
        'dokumen-akreditasi-tf' => [
            'judul' => 'Dokumen Akreditasi Program Studi Teknik Informatika',
            'subjudul' => 'Sertifikat akreditasi resmi dan dokumen penjaminan mutu Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'deskripsi' => '<p>Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi berkomitmen menjaga budaya mutu akademik secara berkelanjutan sesuai standar nasional pendidikan tinggi. Halaman ini memuat sertifikat akreditasi dan dokumen pendukung akreditasi Program Studi Teknik Informatika yang dapat diunduh oleh mahasiswa, alumni, dan pemangku kepentingan.</p>',
            'link_url' => '',
        ],
        'laminfokom' => [
            'judul' => 'Akreditasi LAMINFOKOM — Teknik Informatika',
            'subjudul' => 'Lembaga Akreditasi Mandiri Informatika dan Komputer (LAMINFOKOM) untuk Program Studi S1 Teknik Informatika.',
            'deskripsi' => '<p><strong>LAMINFOKOM</strong> (Lembaga Akreditasi Mandiri Informatika dan Komputer) merupakan lembaga akreditasi mandiri yang menilai mutu program studi di bidang informatika dan komputer di Indonesia. Program Studi Teknik Informatika Fakultas Sains dan Teknologi menyelaraskan kurikulum OBE, kualifikasi dosen, fasilitas laboratorium komputasi, dan capaian pembelajaran lulusan sesuai instrumen akreditasi LAMINFOKOM.</p>',
            'link_url' => 'https://laminfokom.or.id',
        ],
        'ban-pt' => [
            'judul' => 'Akreditasi BAN-PT — Badan Akreditasi Nasional Perguruan Tinggi',
            'subjudul' => 'Informasi dan dokumen sertifikat akreditasi institusi serta program studi oleh BAN-PT.',
            'deskripsi' => '<p><strong>BAN-PT</strong> (Badan Akreditasi Nasional Perguruan Tinggi) menyelenggarakan akreditasi perguruan tinggi dan program studi guna menjamin standar pelayanan pendidikan tinggi nasional. Silakan unduh sertifikat atau kunjungi direktori resmi BAN-PT melalui tautan yang tersedia.</p>',
            'link_url' => 'https://www.banpt.or.id',
        ],
        'beasiswa-lpdp' => [
            'judul' => 'Program Beasiswa LPDP',
            'subjudul' => 'Informasi pendaftaran, persyaratan, dan jadwal seleksi Beasiswa Lembaga Pengelola Dana Pendidikan (LPDP).',
            'deskripsi' => '<p><strong>Beasiswa LPDP</strong> merupakan program beasiswa yang diselenggarakan oleh Pemerintah Republik Indonesia melalui Lembaga Pengelola Dana Pendidikan (Kementerian Keuangan) untuk mendukung pengembangan sumber daya manusia unggul Indonesia di bidang sains, teknologi, dan informatika.</p>',
            'link_url' => 'https://lpdp.kemenkeu.go.id',
        ],
        'beasiswa-kip' => [
            'judul' => 'Beasiswa KIP-Kuliah Merdeka',
            'subjudul' => 'Program bantuan biaya pendidikan Kartu Indonesia Pintar (KIP) Kuliah bagi mahasiswa Program Studi Teknik Informatika.',
            'deskripsi' => '<p><strong>KIP-Kuliah Merdeka</strong> memberikan kesempatan kuliah bebas biaya pendidikan dan bantuan biaya hidup bagi lulusan SMA/SMK sederajat yang memiliki potensi akademik baik namun memiliki keterbatasan ekonomi untuk menempuh studi di Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi.</p>',
            'link_url' => 'https://kip-kuliah.kemdiktisaintek.go.id',
        ],
        'beasiswa-bpddi' => [
            'judul' => 'Program Beasiswa BPDDI',
            'subjudul' => 'Informasi dan panduan pengajuan Beasiswa bagi mahasiswa berprestasi Program Studi Teknik Informatika.',
            'deskripsi' => '<p><strong>Beasiswa BPDDI</strong> hadir untuk mendukung mahasiswa dan sivitas akademika di bidang teknologi informasi dan sains dalam meningkatkan kualifikasi akademik, riset inovatif, dan penyelesaian studi tepat waktu.</p>',
            'link_url' => '',
        ],
        'beasiswa-adik' => [
            'judul' => 'Beasiswa Afirmasi Pendidikan Tinggi (ADik)',
            'subjudul' => 'Program Beasiswa Afirmasi Pendidikan Tinggi bagi mahasiswa daerah khusus dan 3T di Program Studi Teknik Informatika.',
            'deskripsi' => '<p><strong>Beasiswa ADik (Afirmasi Pendidikan Tinggi)</strong> merupakan program pemerintah untuk memperluas akses pendidikan tinggi berkualitas bagi putra-putri terbaik dari daerah terdepan, terluar, dan tertinggal (3T) serta anak pekerja migran Indonesia.</p>',
            'link_url' => 'https://adik.kemdiktisaintek.go.id',
        ],
        'pendaftaran-pmb' => [
            'judul' => 'Pendaftaran Mahasiswa Baru (PMB) — Teknik Informatika',
            'subjudul' => 'Portal pendaftaran online calon mahasiswa baru Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi.',
            'deskripsi' => '<p>Selamat datang di layanan <strong>Pendaftaran Mahasiswa Baru (PMB) Program Studi S1 Teknik Informatika — Fakultas Sains dan Teknologi</strong>. Tersedia kelas Reguler Pagi dan Kelas Karyawan/Malam dengan pilihan jalur seleksi Reguler, Prestasi Akademik/Non-Akademik, dan Beasiswa KIP-Kuliah.</p>',
            'link_url' => 'https://pmb.uis.ac.id',
        ],
        'informasi-pmb' => [
            'judul' => 'Informasi Penerimaan Mahasiswa Baru (PMB)',
            'subjudul' => 'Syarat pendaftaran, jadwal gelombang, rincian biaya pendidikan, dan alur seleksi masuk Program Studi Teknik Informatika.',
            'deskripsi' => '<p>Halaman ini memuat informasi lengkap mengenai persyaratan berkas pendaftaran, jadwal gelombang penerimaan mahasiswa baru, rincian biaya kuliah, serta fasilitas penunjang perkuliahan di Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi.</p>',
            'link_url' => 'https://pmb.uis.ac.id',
        ],
        'pengumuman-pmb' => [
            'judul' => 'Pengumuman Hasil Seleksi PMB',
            'subjudul' => 'Informasi kelulusan seleksi calon mahasiswa baru dan panduan daftar ulang Program Studi Teknik Informatika.',
            'deskripsi' => '<p>Calon mahasiswa baru yang telah mengikuti tahapan seleksi dapat melihat pengumuman hasil kelulusan serta jadwal registrasi ulang (her-registrasi) dan Pengenalan Kehidupan Kampus bagi Mahasiswa Baru (PKKMB) pada halaman ini.</p>',
            'link_url' => '',
        ],
    ];

    /**
     * Helper to get or create record by tipe
     */
    public static function getOrCreateItem(string $tipe): Akademik
    {
        $default = self::$defaults[$tipe] ?? [
            'judul' => ucwords(str_replace('-', ' ', $tipe)),
            'subjudul' => 'Informasi resmi Program Studi Teknik Informatika — Fakultas Sains dan Teknologi.',
            'deskripsi' => '<p>Informasi lengkap mengenai ' . htmlspecialchars(ucwords(str_replace('-', ' ', $tipe))) . ' pada Program Studi Teknik Informatika Fakultas Sains dan Teknologi.</p>',
            'link_url' => '',
        ];

        return Akademik::firstOrCreate(
            ['tipe' => $tipe],
            [
                'judul' => $default['judul'],
                'subjudul' => $default['subjudul'],
                'deskripsi' => $default['deskripsi'],
                'link_url' => $default['link_url'],
                'is_active' => true,
            ]
        );
    }

    public function kurikulum(): View
    {
        $item = self::getOrCreateItem('kurikulum');
        $pageTitle = 'Kurikulum Teknik Informatika';
        $tipe = 'kurikulum';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function kalender(): View
    {
        $item = self::getOrCreateItem('kalender');
        $pageTitle = 'Kalender Akademik';
        $tipe = 'kalender';
        $kalenderItems = KalenderAkademikItem::orderBy('urutan')->orderBy('id')->get();

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe', 'kalenderItems'));
    }

    public function storeKalenderItem(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul_tab' => ['required', 'string', 'max:255'],
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'gdrive_url' => ['required', 'url', 'max:1000'],
            'tombol_teks' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'judul_tab.required' => 'Judul Tab Tahun Akademik wajib diisi.',
            'nama_dokumen.required' => 'Nama Dokumen wajib diisi.',
            'gdrive_url.required' => 'Link Google Drive wajib diisi.',
            'gdrive_url.url' => 'Link Google Drive harus berupa URL yang valid (diawali https://).',
        ]);

        $validated['tombol_teks'] = $validated['tombol_teks'] ?: 'Lihat Document';
        $validated['urutan'] = $validated['urutan'] ?? (KalenderAkademikItem::max('urutan') + 1);
        $validated['is_active'] = $request->has('is_active');

        KalenderAkademikItem::create($validated);

        return redirect()
            ->route('akademik.kalender')
            ->with('success', 'Data tahun Kalender Akademik berhasil ditambahkan!');
    }

    public function updateKalenderItem(Request $request, int $id): RedirectResponse
    {
        $kalenderItem = KalenderAkademikItem::findOrFail($id);

        $validated = $request->validate([
            'judul_tab' => ['required', 'string', 'max:255'],
            'nama_dokumen' => ['required', 'string', 'max:255'],
            'gdrive_url' => ['required', 'url', 'max:1000'],
            'tombol_teks' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'judul_tab.required' => 'Judul Tab Tahun Akademik wajib diisi.',
            'nama_dokumen.required' => 'Nama Dokumen wajib diisi.',
            'gdrive_url.required' => 'Link Google Drive wajib diisi.',
            'gdrive_url.url' => 'Link Google Drive harus berupa URL yang valid (diawali https://).',
        ]);

        $validated['tombol_teks'] = $validated['tombol_teks'] ?: 'Lihat Document';
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->has('is_active');

        $kalenderItem->update($validated);

        return redirect()
            ->route('akademik.kalender')
            ->with('success', 'Data tahun Kalender Akademik berhasil diperbarui!');
    }

    public function destroyKalenderItem(int $id): RedirectResponse
    {
        $kalenderItem = KalenderAkademikItem::findOrFail($id);
        $kalenderItem->delete();

        return redirect()
            ->route('akademik.kalender')
            ->with('success', 'Data tahun Kalender Akademik berhasil dihapus!');
    }

    public function pedoman(): View
    {
        $item = self::getOrCreateItem('pedoman');
        $pageTitle = 'Pedoman Akademik';
        $tipe = 'pedoman';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function sistem(): View
    {
        $item = self::getOrCreateItem('sistem');
        $pageTitle = 'Sistem Akademik';
        $tipe = 'sistem';

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function portalEdit(string $tipe): View
    {
        if (! array_key_exists($tipe, self::$defaults)) {
            abort(404);
        }

        $item = self::getOrCreateItem($tipe);
        $pageTitle = self::$defaults[$tipe]['judul'];

        return view('pages.akademik.edit', compact('item', 'pageTitle', 'tipe'));
    }

    public function update(AkademikRequest $request, string $tipe): RedirectResponse
    {
        if (! array_key_exists($tipe, self::$defaults)) {
            abort(404);
        }

        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        $item = self::getOrCreateItem($tipe);

        // Upload File Dokumen (PDF dll)
        if ($request->hasFile('file_dokumen')) {
            if ($item->file_dokumen && Storage::disk('public')->exists($item->file_dokumen)) {
                Storage::disk('public')->delete($item->file_dokumen);
            }
            $file = $request->file('file_dokumen');
            $validated['file_dokumen'] = $file->store('akademik/dokumen', 'public');
            if (empty($validated['file_nama'])) {
                $validated['file_nama'] = $file->getClientOriginalName();
            }
        }

        // Upload Gambar Banner/Cover
        if ($request->hasFile('gambar')) {
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('akademik/gambar', 'public');
        }

        $item->update($validated);

        if (in_array($tipe, ['kurikulum', 'kalender', 'pedoman', 'sistem'])) {
            $routeName = 'akademik.' . $tipe;
            return redirect()
                ->route($routeName)
                ->with('success', "Pengaturan data " . self::$defaults[$tipe]['judul'] . " berhasil diperbarui!");
        }

        return redirect()
            ->route('akademik.portal.edit', $tipe)
            ->with('success', "Pengaturan data " . self::$defaults[$tipe]['judul'] . " berhasil diperbarui!");
    }
}
