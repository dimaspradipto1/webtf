<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumniTestimonialRequest;
use App\Models\About;
use App\Models\Agenda;
use App\Models\Akademik;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\ContactMessage;
use App\Models\DesainGrafis;
use App\Models\DesainGrafisSetting;
use App\Models\Dosen;
use App\Models\EmagazineHumas;
use App\Models\FacultyStat;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\HeroHumas;
use App\Models\HomepageStat;
use App\Models\Kurikulum;
use App\Models\Layanan;
use App\Models\LayananHumasItem;
use App\Models\LayananTerkait;
use App\Models\LayananTerkaitSetting;
use App\Models\Milestone;
use App\Models\News;
use App\Models\NilaiPerusahaan;
use App\Models\OrganisasiMahasiswa;
use App\Models\OrganisasiMahasiswaSetting;
use App\Models\Partner;
use App\Models\Penelitian;
use App\Models\PendampinganAcaraSetting;
use App\Models\PermintaanRilisSetting;
use App\Models\Pimpinan;
use App\Models\PmbSetting;
use App\Models\Prestasi;
use App\Models\PusatInformasiHumas;
use App\Models\PusatInformasiHumasSetting;
use App\Models\SambutanDekan;
use App\Models\Sarana;
use App\Models\SocialMedia;
use App\Models\SocialMediaSetting;
use App\Models\StrukturOrganisasi;
use App\Models\SurveyLayananButton;
use App\Models\SurveyLayananSetting;
use App\Models\TemplateDokumen;
use App\Models\TemplateDokumenSetting;
use App\Models\TenagaPendidik;
use App\Models\Testimonial;
use App\Models\TriDharma;
use App\Models\Unduhan;
use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function homepage(Request $request)
    {
        $banners = Banner::where('aktif', true)->orderBy('urutan')->get();
        $features = Feature::orderBy('urutan')->get();
        Sarana::ensureColumns();
        $saranas = Sarana::where('is_active', true)->orderBy('urutan')->get();
        $triDharmas = TriDharma::where('is_active', true)->orderBy('urutan')->get();
        $tenagaPendidiks = TenagaPendidik::with('layanan')->where('is_active', true)->orderBy('urutan')->get();
        $layanans = Layanan::where('aktif', true)->orderBy('urutan')->get();
        $partners = Partner::where('aktif', true)->orderBy('urutan')->get();
        $visiMisis = VisiMisi::orderBy('urutan')->get()->groupBy('tipe');
        $nilaiPerusahaans = NilaiPerusahaan::orderBy('urutan')->get();
        $testimonials = Testimonial::where('aktif', true)->orderByDesc('id')->get();

        $search = trim($request->query('q') ?? $request->query('search') ?? '');
        $newsQuery = News::where('status', 'published');
        if (! empty($search)) {
            $newsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }
        $latestNews = $newsQuery->latest()->paginate(10, ['*'], 'page_berita')->withQueryString();

        if ($request->ajax()) {
            $html = view('layouts.frontend.partials.homepage-news-grid', compact('latestNews', 'search'))->render();

            return response()->json([
                'html' => $html,
                'count' => $latestNews->total(),
                'hasPages' => $latestNews->hasPages(),
            ]);
        }

        $announcements = Announcement::where('is_active', true)
            ->orderBy('urutan')
            ->latest('date')
            ->take(5)
            ->get();
        $agendas = Agenda::where('is_active', true)
            ->orderBy('urutan')
            ->latest('id')
            ->take(5)
            ->get();
        $faqs = Faq::take(6)->get();
        $galleries = Gallery::where(function ($q) {
            $q->where('kategori', 'universitas')->orWhereNull('kategori');
        })->latest()->take(6)->get();
        $prestasis = Prestasi::where('is_active', true)->orderBy('urutan')->latest('id')->take(6)->get();
        $organisasis = OrganisasiMahasiswa::where('is_active', true)->orderBy('urutan')->get();
        $organisasiSetting = OrganisasiMahasiswaSetting::first();
        $about = About::first();
        SambutanDekan::ensureVideoColumns();
        $sambutanDekan = SambutanDekan::first();
        $struktur = StrukturOrganisasi::first();
        $pmbSetting = PmbSetting::first();
        $facultyStat = FacultyStat::where('is_active', true)->latest('id')->first();
        HomepageStat::ensureTable();
        $homepageStats = Schema::hasTable('homepage_stats')
            ? HomepageStat::where('is_active', true)->orderBy('urutan')->orderBy('id')->get()
            : collect();
        $layananTerkaits = LayananTerkait::where('is_active', true)->orderBy('urutan')->get();
        $layananTerkaitSetting = LayananTerkaitSetting::first();
        $socialMedias = SocialMedia::where('is_active', true)
            ->where(function ($q) {
                $q->where('kategori', 'universitas')->orWhereNull('kategori');
            })
            ->orderBy('urutan')
            ->get();
        $socialMediaSetting = SocialMediaSetting::first();

        if (! $facultyStat) {
            $facultyStat = (object) [
                'title' => 'Teknik Informatika Dalam Angka',
                'jumlah_prodi' => 1,
                'total_mahasiswa' => 0,
                'total_dosen' => 0,
                'total_alumni' => 0,
                'image' => null,
            ];
        }

        return view('layouts.frontend.homepage', compact(
            'banners',
            'features',
            'saranas',
            'triDharmas',
            'tenagaPendidiks',
            'layanans',
            'partners',
            'visiMisis',
            'nilaiPerusahaans',
            'testimonials',
            'latestNews',
            'search',
            'announcements',
            'agendas',
            'faqs',
            'galleries',
            'prestasis',
            'organisasis',
            'organisasiSetting',
            'about',
            'sambutanDekan',
            'struktur',
            'pmbSetting',
            'facultyStat',
            'homepageStats',
            'layananTerkaits',
            'layananTerkaitSetting',
            'socialMedias',
            'socialMediaSetting'
        ));
    }

    public function kurikulum(Request $request)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        $selectedProdiId = $request->query('prodi');
        if ($selectedProdiId) {
            $currentProdi = $prodis->firstWhere('id', $selectedProdiId) ?? $prodis->first();
        } else {
            $currentProdi = $prodis->first();
        }

        $query = Kurikulum::where('is_active', true);
        if ($currentProdi) {
            $query->where(function ($q) use ($currentProdi) {
                $q->where('layanan_id', $currentProdi->id)
                  ->orWhereNull('layanan_id');
            });
        }

        $courses = $query->orderBy('semester')->orderBy('urutan')->orderBy('id')->get();
        $coursesBySemester = $courses->groupBy('semester');

        $totalSks = $courses->sum('sks');
        $totalMatakuliah = $courses->count();

        $pageTitle = 'Kurikulum '.($currentProdi?->judul ?? 'Program Studi Teknik Informatika');
        $checksum = md5(($courses->max('updated_at') ?? '') . '_' . $totalMatakuliah);

        return response()->view('layouts.frontend.kurikulum', compact('prodis', 'currentProdi', 'coursesBySemester', 'totalSks', 'totalMatakuliah', 'pageTitle', 'checksum'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function kurikulumCheckUpdated(Request $request)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();
        $selectedProdiId = $request->query('prodi');
        $currentProdi = $selectedProdiId ? ($prodis->firstWhere('id', $selectedProdiId) ?? $prodis->first()) : $prodis->first();

        $query = Kurikulum::where('is_active', true);
        if ($currentProdi) {
            $query->where(function ($q) use ($currentProdi) {
                $q->where('layanan_id', $currentProdi->id)
                  ->orWhereNull('layanan_id');
            });
        }

        $courses = $query->get(['id', 'updated_at']);
        $lastUpdated = $courses->max('updated_at') ?? '';
        $count = $courses->count();
        $checksum = md5($lastUpdated . '_' . $count);

        return response()->json([
            'checksum' => $checksum,
            'count' => $count,
            'last_updated' => (string) $lastUpdated,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function kalenderAkademik()
    {
        $item = AkademikController::getOrCreateItem('kalender');
        $pageTitle = 'Kalender Akademik';
        $kalenderItems = \App\Models\KalenderAkademikItem::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('layouts.frontend.akademik', compact('item', 'pageTitle', 'kalenderItems'));
    }

    public function pedomanAkademik()
    {
        $item = AkademikController::getOrCreateItem('pedoman');
        $pageTitle = 'Pedoman Akademik';

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function sistemAkademik()
    {
        $item = AkademikController::getOrCreateItem('sistem');
        $pageTitle = 'Sistem Akademik & Portal Online';

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function portalPage(string $slug)
    {
        $item = AkademikController::getOrCreateItem($slug);
        $pageTitle = $item->judul;

        if (in_array($slug, ['tracer-study', 'laminfokom', 'ban-pt'])) {
            $defaultUrls = [
                'tracer-study' => 'https://drive.google.com',
                'laminfokom' => 'https://laminfokom.or.id',
                'ban-pt' => 'https://www.banpt.or.id',
            ];
            $url = !empty($item->link_url) ? $item->link_url : ($defaultUrls[$slug] ?? 'https://drive.google.com');
            return redirect()->away($url);
        }

        if (str_starts_with($slug, 'beasiswa-')) {
            $keyword = strtoupper(str_replace('beasiswa-', '', $slug));
            $foundBeasiswa = \App\Models\Beasiswa::where('aktif', true)
                ->where(function ($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%");
                })->first();
            if ($foundBeasiswa && !empty($foundBeasiswa->link)) {
                return redirect()->away($foundBeasiswa->link);
            }
        }

        if ($slug === 'informasi-pmb') {
            $pmb = \App\Models\InformasiPmb::getOrCreate();
            $contact = \App\Models\Contact::first();
            $cleanWa = preg_replace('/[^0-9]/', '', $pmb->no_whatsapp ?? '081270000000');
            if (str_starts_with($cleanWa, '08')) {
                $cleanWa = '628' . substr($cleanWa, 2);
            }
            return view('layouts.frontend.informasi-pmb', compact('item', 'pageTitle', 'pmb', 'contact', 'cleanWa'));
        }

        if ($slug === 'dokumen-akreditasi-tf') {
            $akreditasiItems = \App\Models\AkreditasiDokumen::where('is_active', true)
                ->whereIn('kategori_tab', ['instrumen', 'kelengkapan'])
                ->orderBy('urutan')
                ->orderBy('id')
                ->get();

            return view('layouts.frontend.akademik', compact('item', 'pageTitle', 'akreditasiItems'));
        }

        if ($slug === 'sertifikat-akreditasi') {
            $sertifikatItems = \App\Models\AkreditasiDokumen::where('is_active', true)
                ->where('kategori_tab', 'sertifikat')
                ->orderBy('urutan')
                ->orderBy('id')
                ->get();

            return view('layouts.frontend.akademik', compact('item', 'pageTitle', 'sertifikatItems'));
        }

        if ($slug === 'pengumuman-pmb') {
            $pengumumanPmbItems = \App\Models\PengumumanPmbItem::where('is_active', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->get();

            return view('layouts.frontend.akademik', compact('item', 'pageTitle', 'pengumumanPmbItems'));
        }

        return view('layouts.frontend.akademik', compact('item', 'pageTitle'));
    }

    public function fasilitas()
    {
        $saranas = Sarana::where('is_active', true)->orderBy('urutan')->get();
        $about = About::first();

        return view('layouts.frontend.fasilitas', compact('saranas', 'about'));
    }

    public function dosen(Request $request)
    {
        $prodis = Layanan::where('aktif', true)->orderBy('urutan')->get();

        $selectedProdiId = $request->query('prodi');
        if ($selectedProdiId) {
            $currentProdi = $prodis->firstWhere('id', $selectedProdiId) ?? $prodis->first();
        } else {
            $currentProdi = $prodis->first();
        }

        $search = trim($request->query('q', ''));

        $query = Dosen::where('is_active', true);
        if ($currentProdi) {
            $query->where(function ($q) use ($currentProdi) {
                $q->where('layanan_id', $currentProdi->id)
                  ->orWhereNull('layanan_id');
            });
        }

        // Hitung statistik Jabatan Fungsional Dosen
        $allJabatan = (clone $query)->pluck('jabatan_fungsional')->map(fn($j) => strtolower(trim($j ?? '')));
        $countTenagaPengajar = $allJabatan->filter(fn($j) => str_contains($j, 'pengajar'))->count();
        $countAsistenAhli = $allJabatan->filter(fn($j) => str_contains($j, 'asisten ahli'))->count();
        $countLektor = $allJabatan->filter(fn($j) => str_contains($j, 'lektor') && !str_contains($j, 'kepala'))->count();
        $countLektorKepala = $allJabatan->filter(fn($j) => str_contains($j, 'lektor kepala'))->count();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', "%{$search}%")
                    ->orWhere('nidn', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('jabatan_fungsional', 'like', "%{$search}%");
            });
        }

        $totalDosen = (clone $query)->count();
        $dosens = $query->orderBy('urutan')->orderBy('nama_dosen')->paginate(10)->withQueryString();

        $pageTitle = 'Dosen '.($currentProdi?->judul ?? 'Program Studi Teknik Informatika');

        return view('layouts.frontend.dosen', compact(
            'prodis',
            'currentProdi',
            'dosens',
            'totalDosen',
            'search',
            'pageTitle',
            'countTenagaPengajar',
            'countAsistenAhli',
            'countLektor',
            'countLektorKepala'
        ));
    }

    public function layanan()
    {
        $layanans = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('layouts.frontend.layanan', compact('layanans'));
    }

    public function layananDetail($slug)
    {
        $layanan = Layanan::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! empty($layanan->slug)) {
            return redirect()->route('homepage.layanan.detail', $layanan->slug, 301);
        }

        $layanans = Layanan::where('aktif', true)->orderBy('urutan')->get();

        return view('layouts.frontend.layanan-detail', compact('layanan', 'layanans'));
    }

    public function galeri(Request $request, $kategori = null)
    {
        // Jika ada query param ?kategori=humas, redirect 301 ke URL slug /galeri/humas
        if ($request->has('kategori') && empty($kategori)) {
            $cat = $request->query('kategori');
            if (in_array($cat, ['humas', 'universitas'])) {
                return redirect()->route('homepage.galeri.'.$cat, [], 301);
            }
        }

        $kategori = $kategori ?? $request->query('kategori');

        $query = Gallery::query();
        if ($kategori === 'humas') {
            $query->where('kategori', 'humas');
        } else {
            // Default untuk /galeri atau /galeri/universitas: khusus galeri universitas
            $query->where(function ($q) {
                $q->where('kategori', 'universitas')->orWhereNull('kategori');
            });
            $kategori = 'universitas';
        }

        $galleries = $query->latest()->paginate(12)->withPath(
            $kategori === 'humas' ? url('/galeri/humas') : url('/galeri')
        );

        return view('layouts.frontend.galeri', compact('galleries', 'kategori'));
    }

    public function galeriHumas(Request $request)
    {
        return $this->galeri($request, 'humas');
    }

    public function galeriUniversitas(Request $request)
    {
        return $this->galeri($request, 'universitas');
    }

    public function galeriDetail($slug)
    {
        if ($slug === 'humas') {
            return redirect()->route('homepage.galeri.humas', [], 301);
        }
        if ($slug === 'universitas') {
            return redirect()->route('homepage.galeri.universitas', [], 301);
        }

        $gallery = Gallery::where(function ($q) use ($slug) {
            $q->where('slug', $slug)
                ->orWhere('id', $slug);
        })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! empty($gallery->slug)) {
            return redirect()->route('homepage.galeri.detail', $gallery->slug, 301);
        }

        $otherGalleries = Gallery::where('id', '!=', $gallery->id)
            ->when(! empty($gallery->kategori), fn ($q) => $q->where('kategori', $gallery->kategori))
            ->latest('id')
            ->take(6)
            ->get();

        return view('layouts.frontend.galeri-detail', compact('gallery', 'otherGalleries'));
    }

    public function tentang()
    {
        $about = About::first();
        $features = Feature::orderBy('urutan')->get();
        $milestones = Milestone::orderBy('tahun')->get();
        $partners = Partner::orderBy('urutan')->get();
        $contact = Contact::first();
        $pimpinans = Pimpinan::where('is_active', true)
            ->orderBy('baris')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();
        $pimpinansByBaris = $pimpinans->groupBy('baris');

        return view('layouts.frontend.about', compact(
            'about',
            'features',
            'milestones',
            'partners',
            'contact',
            'pimpinans',
            'pimpinansByBaris'
        ));
    }

    public function pimpinanDetail(string $slug)
    {
        $pimpinan = Pimpinan::where('is_active', true)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug);
                if (is_numeric($slug)) {
                    $q->orWhere('id', (int) $slug);
                }
            })
            ->firstOrFail();

        $contact = Contact::first();

        return view('layouts.frontend.pimpinan-detail', compact('pimpinan', 'contact'));
    }

    public function sambutanDekan()
    {
        $sambutanDekan = SambutanDekan::first();
        $contact = Contact::first();

        return view('layouts.frontend.sambutan-dekan', compact('sambutanDekan', 'contact'));
    }

    public function visiMisi()
    {
        $about = About::first();
        $visiMisis = VisiMisi::orderBy('urutan')->get()->groupBy('tipe');
        $nilaiPerusahaans = NilaiPerusahaan::orderBy('urutan')->get();

        return view('layouts.frontend.visi-misi', compact('about', 'visiMisis', 'nilaiPerusahaans'));
    }

    public function sejarah()
    {
        $about = About::first();
        $milestones = Milestone::orderBy('tahun')->get();

        return view('layouts.frontend.sejarah', compact('about', 'milestones'));
    }

    public function pengumuman(Request $request)
    {
        $search = trim($request->query('q') ?? '');
        $query = Announcement::where('is_active', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('urutan')->latest('date')->paginate(12)->withQueryString();

        return view('layouts.frontend.pengumuman', compact('announcements', 'search'));
    }

    public function pengumumanDetail($slug)
    {
        $announcement = Announcement::where('slug', $slug)->firstOrFail();
        $recentAnnouncements = Announcement::where('is_active', true)
            ->where('id', '!=', $announcement->id)
            ->orderBy('urutan')
            ->latest('date')
            ->take(5)
            ->get();

        return view('layouts.frontend.pengumuman-detail', compact('announcement', 'recentAnnouncements'));
    }

    public function agenda(Request $request)
    {
        $search = trim($request->query('q') ?? '');
        $query = Agenda::where('is_active', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('date_text', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $agendas = $query->orderBy('urutan')->latest('id')->paginate(15)->withQueryString();

        return view('layouts.frontend.agenda', compact('agendas', 'search'));
    }

    public function agendaDetail($slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();
        $recentAgendas = Agenda::where('is_active', true)
            ->where('id', '!=', $agenda->id)
            ->orderBy('urutan')
            ->latest('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.agenda-detail', compact('agenda', 'recentAgendas'));
    }

    public function faq()
    {
        $faqs = Faq::all();

        return view('layouts.frontend.faq', compact('faqs'));
    }

    public function strukturOrganisasi()
    {
        $struktur = StrukturOrganisasi::first();

        return view('layouts.frontend.struktur-organisasi', compact('struktur'));
    }

    public function kontak()
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        session([
            'contact_captcha_a' => $a,
            'contact_captcha_b' => $b,
            'contact_captcha_answer' => $a + $b,
        ]);

        return view('layouts.frontend.contact', [
            'captchaQuestion' => "{$a} + {$b}",
        ]);
    }

    public function submitKontakMessage(Request $request)
    {
        ContactMessage::ensureTable();

        // Honeypot anti-bot
        if ($request->filled('website')) {
            return redirect(route('homepage.kontak') . '#kirim-pesan')
                ->with('contact_success', 'Pesan Anda berhasil dikirim! Tim Program Studi akan membalas melalui email dalam 1–2 hari kerja.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'kategori' => ['required', 'in:PMB,Akademik,Kerja Sama,Lainnya'],
            'pesan' => ['required', 'string', 'min:10', 'max:3000'],
            'captcha_answer' => ['required', 'integer'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'kategori.required' => 'Kategori pesan wajib dipilih.',
            'kategori.in' => 'Kategori pesan tidak valid.',
            'pesan.required' => 'Isi pesan wajib ditulis.',
            'pesan.min' => 'Isi pesan minimal 10 karakter.',
            'captcha_answer.required' => 'Jawaban verifikasi keamanan (CAPTCHA) wajib diisi.',
            'captcha_answer.integer' => 'Jawaban verifikasi keamanan harus berupa angka.',
        ]);

        $expectedAnswer = session('contact_captcha_answer');
        if ($expectedAnswer === null || (int) $validated['captcha_answer'] !== (int) $expectedAnswer) {
            return redirect(route('homepage.kontak') . '#kirim-pesan')
                ->withInput($request->except('captcha_answer'))
                ->withErrors(['captcha_answer' => 'Jawaban verifikasi keamanan (CAPTCHA) salah. Silakan coba lagi.']);
        }

        // Hapus jawaban lama agar tidak bisa dipakai ulang
        session()->forget(['contact_captcha_a', 'contact_captcha_b', 'contact_captcha_answer']);

        $message = ContactMessage::create([
            'nama' => trim($validated['nama']),
            'email' => trim($validated['email']),
            'kategori' => $validated['kategori'],
            'pesan' => trim($validated['pesan']),
            'status' => 'baru',
            'ip_address' => $request->ip(),
            'email_forwarded' => false,
        ]);

        // Teruskan ke email resmi prodi bila konfigurasi mail tersedia (non-blocking)
        $prodiEmail = Contact::value('email');
        if (!empty($prodiEmail) && filter_var($prodiEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                $body = "Pesan baru masuk dari halaman Kontak Website S1 Teknik Informatika:\n\n"
                    . "Nama     : {$message->nama}\n"
                    . "Email    : {$message->email}\n"
                    . "Kategori : {$message->kategori}\n"
                    . "Waktu    : " . now()->format('d/m/Y H:i') . " WIB\n\n"
                    . "Isi Pesan:\n{$message->pesan}\n";

                Mail::raw($body, function ($mail) use ($prodiEmail, $message) {
                    $mail->to($prodiEmail)
                        ->replyTo($message->email, $message->nama)
                        ->subject("[Kontak Web TI - {$message->kategori}] Pesan dari {$message->nama}");
                });

                $message->update(['email_forwarded' => true]);
            } catch (\Throwable $e) {
                // Tetap simpan pesan di menu admin Kontak walau SMTP belum aktif
            }
        }

        return redirect(route('homepage.kontak') . '#kirim-pesan')
            ->with('contact_success', 'Pesan Anda berhasil dikirim! Tim Program Studi akan membalas melalui email dalam 1–2 hari kerja.');
    }

    public function humas()
    {
        $contact = Contact::first();
        $about = About::first();
        $pmbSetting = PmbSetting::first();

        // Ambil berita khusus yang berkategori 'Berita Humas' saja
        $latestNews = News::where('status', 'published')
            ->where('category', 'Berita Humas')
            ->latest()
            ->take(3)
            ->get();

        $faqs = Faq::take(6)->get();
        $socialMedias = SocialMedia::where('is_active', true)
            ->where('kategori', 'humas')
            ->orderBy('urutan')
            ->get();
        $banners = Banner::where('aktif', true)->orderBy('urutan')->get();
        $galleries = Gallery::where('kategori', 'humas')->latest()->take(6)->get();
        $heroHumas = HeroHumas::first();
        $pusatInformasis = PusatInformasiHumas::active()->get();
        $pusatInformasiSetting = PusatInformasiHumasSetting::first();
        $emagazine = EmagazineHumas::first();
        $layananHumasItems = LayananHumasItem::active()->get()->keyBy('kode');

        return view('layouts.frontend.humas', compact(
            'contact', 'about', 'pmbSetting', 'latestNews', 'faqs',
            'socialMedias', 'banners', 'galleries', 'heroHumas',
            'pusatInformasis', 'pusatInformasiSetting', 'emagazine', 'layananHumasItems'
        ));
    }

    public function unduhan(Request $request, $kategori = null)
    {
        // Jika ada ?kategori=image, redirect 301 ke /unduhan/image
        if ($request->has('kategori') && empty($kategori)) {
            $cat = $request->query('kategori');

            return redirect()->route('homepage.unduhan.kategori', $cat, 301);
        }

        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $selectedCat = $kategori ?? $request->query('kategori', 'image');
        $unduhans = Unduhan::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('layouts.frontend.unduhan', compact('unduhans', 'selectedCat', 'contact', 'pmbSetting'));
    }

    public function desainGrafis()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();

        $categoryConfigs = [
            'audit' => [
                'id' => 'audit',
                'name' => 'Auditorium lt. 4 Rektorat',
                'specs' => 'Ukuran: LED TENGAH untuk gedung Auditorium lt. 4 gedung H. Rasit Kurnain (Format 704 x 320 px / Landscape)',
            ],
            'sidang' => [
                'id' => 'sidang',
                'name' => 'Ruang Sidang lt. 2 Rektorat',
                'specs' => 'Ukuran Layar LCD & Proyektor Ruang Sidang Utama lt. 2 (Format 1920 x 1080 px / 16:9 Full HD)',
            ],
            'dekanat' => [
                'id' => 'dekanat',
                'name' => 'Ruang Rapat Dekanat',
                'specs' => 'Format Display TV Ruang Rapat Fakultas / Dekanat (Format 1920 x 1080 px / Full HD)',
            ],
            'spanduk' => [
                'id' => 'spanduk',
                'name' => 'Banner & Spanduk Outdoor',
                'specs' => 'Spanduk Gerbang Depan & Backdrop Panggung Utama (Format 3 x 1 meter & 4 x 2 meter)',
            ],
        ];

        $dbTemplates = DesainGrafis::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        $categories = [];
        foreach ($categoryConfigs as $catKey => $config) {
            $matched = $dbTemplates->where('kategori', $catKey);
            $categories[$catKey] = [
                'id' => $config['id'],
                'name' => $config['name'],
                'specs' => $matched->first()?->spesifikasi ?: $config['specs'],
                'templates' => $matched->map(function ($item) {
                    return [
                        'title' => $item->judul,
                        'desc' => $item->deskripsi,
                        'badge' => $item->badge_teks ?: 'Landscape',
                        'url' => $item->canva_url ?: 'https://www.canva.com',
                        'color' => $item->warna_gradient ?: 'linear-gradient(135deg, #0b6828 0%, #15803d 100%)',
                        'gambar_preview' => $item->preview_url,
                    ];
                })->values()->toArray(),
            ];
        }

        $setting = DesainGrafisSetting::firstOrCreate([], [
            'hero_title' => 'Desain Mudah,',
            'hero_highlight' => 'Siap Digunakan !',
            'hero_subtitle' => 'Kami menyediakan template desain resmi untuk keperluan presentasi LED, ruang sidang, agenda rapat, dan spanduk acara di lingkungan Teknik Informatika.',
            'order_box_title' => 'Pesan desain disini',
            'order_box_text' => 'Butuh desain yang belum tersedia dalam template? Sampaikan kebutuhan acara Anda, dan tim Humas & Promosi UIS siap membantu mewujudkannya.',
            'order_box_btn_text' => 'Pesan Sekarang',
            'track_bar_text' => 'Lacak progress pesanan desain kamu disini!',
            'stat_total' => 82,
            'stat_selesai' => 74,
            'stat_dikerjakan' => 2,
            'stat_menunggu' => 5,
            'guide_title' => 'Langkah Menggunakan Templat Desain',
            'guide_steps' => "1. Pilih Templat\n2. Masuk ke Canva\n3. Edit Teks/Elemen Templat\n4. Desain Siap\n5. Export Desain format .JPG\n6. Klik tombol Share (kanan atas)\n7. Klik Download\n8. Pilih Format .JPG\n9. Atur Quality Spasi ke 100% untuk kualitas terbaik\n10. Klik Download",
        ]);

        $stats = [
            'total' => $setting->stat_total ?? 82,
            'selesai' => $setting->stat_selesai ?? 74,
            'dikerjakan' => $setting->stat_dikerjakan ?? 2,
            'menunggu' => $setting->stat_menunggu ?? 5,
        ];

        return view('layouts.frontend.desain-grafis', compact('contact', 'pmbSetting', 'categories', 'stats', 'setting'));
    }

    public function templateDokumen()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $setting = TemplateDokumenSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_seksi' => 'TEMPLAT DOKUMEN',
                'deskripsi_seksi' => 'Kami menyediakan Templat untuk Desain, Ms. Power Point, Ms. Word dan berbagai format lainnya. Guna menyeragamkan tampilan desain di lingkungan Teknik Informatika.',
            ]
        );
        $templates = TemplateDokumen::active()->get();

        return view('layouts.frontend.template-dokumen', compact('contact', 'pmbSetting', 'setting', 'templates'));
    }

    public function permintaanRilis()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'permintaan-rilis')->first();
        $setting = PermintaanRilisSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Permintaan Rilis',
                'subjudul_hero' => 'Panduan & Layanan Pengajuan Siaran Pers Resmi Teknik Informatika',
                'badge_label' => 'LAYANAN PUBLIKASI & SIARAN PERS',
                'judul_seksi' => 'Ketentuan Permintaan Rilis Berita',
                'deskripsi_seksi' => 'Layanan ini disediakan oleh Biro Humas Teknik Informatika (UIS) guna memfasilitasi sivitas akademika dalam mengajukan rilis berita kegiatan atau siaran pers untuk dipublikasikan pada portal berita resmi uis.ac.id dan media massa mitra universitas.',
                'link_form' => null,
                'email_tujuan' => 'info@uis.ac.id',
                'no_wa' => $contact->no_wa ?? '081234567890',
                'min_kata' => 250,
                'min_paragraf' => 4,
                'is_active' => true,
            ]
        );

        // Nomor WA bersih untuk wa.me link
        $waRaw = $setting->no_wa ?: ($contact->no_wa ?? '');
        $cleanWa = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($cleanWa, '08')) {
            $cleanWa = '628'.substr($cleanWa, 2);
        }

        return view('layouts.frontend.permintaan-rilis', compact('contact', 'pmbSetting', 'item', 'setting', 'cleanWa'));
    }

    public function pendampinganAcara()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'pendampingan-acara')->first();
        $setting = PendampinganAcaraSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Pendampingan Acara',
                'subjudul_hero' => 'Layanan Konsultasi Protokol & Pendampingan Acara Resmi Teknik Informatika',
                'judul_seksi' => 'Pendampingan Acara',
                'sapaan' => 'Halo, Civitas Akademika Teknik Informatika dan Mitra Eksternal!',
                'paragraf_1' => 'Kami hadir untuk mendukung kesuksesan acara dan kegiatan Anda melalui layanan konsultasi yang profesional, terstruktur, dan sesuai dengan Standar Operasional Prosedur (SOP) Teknik Informatika.',
                'paragraf_2' => 'Apakah Anda sedang merencanakan seminar, workshop, kegiatan sosial, atau event lainnya? Tim kami siap membantu dalam hal:',
                'poin_bantuan' => "Perencanaan dan konsep acara,\nStrategi promosi dan publikasi,\nPengelolaan logistik,\nPengurusan SOP dan perizinan, serta\nPendampingan selama pelaksanaan acara.",
                'paragraf_3' => 'Untuk memulai, silakan isi formulir konsultasi melalui tombol “Ajukan Permohonan” berikut:',
                'link_form' => null,
                'tombol_teks' => 'Ajukan Permohonan',
                'no_wa' => '081234567890',
                'is_active' => true,
            ]
        );

        $waRaw = ! empty($setting->no_wa) ? $setting->no_wa : '081234567890';
        $cleanWa = preg_replace('/[^0-9]/', '', $waRaw);
        if (str_starts_with($cleanWa, '08')) {
            $cleanWa = '628'.substr($cleanWa, 2);
        } elseif (str_starts_with($cleanWa, '8')) {
            $cleanWa = '628'.substr($cleanWa, 1);
        }

        return view('layouts.frontend.pendampingan-acara', compact('contact', 'pmbSetting', 'item', 'setting', 'cleanWa'));
    }

    public function surveyLayanan()
    {
        $contact = Contact::first();
        $pmbSetting = PmbSetting::first();
        $item = LayananHumasItem::where('kode', 'survey-layanan')->first();
        $setting = SurveyLayananSetting::firstOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Survey Layanan',
                'subjudul_hero' => 'Kuesioner Evaluasi Kepuasan & Mutu Pelayanan Humas Teknik Informatika',
                'judul_seksi' => 'Survei Evaluasi',
                'deskripsi_seksi' => 'Silakan isi formulir evaluasi kepuasan layanan berikut untuk membantu kami meningkatkan kualitas mutu pelayanan Humas Teknik Informatika.',
                'is_active' => true,
            ]
        );

        $buttons = SurveyLayananButton::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('layouts.frontend.survey-layanan', compact('contact', 'pmbSetting', 'item', 'setting', 'buttons'));
    }

    public function news(Request $request, $categorySlug = null)
    {
        // Jika ada query param ?category=..., redirect 301 ke slug URL
        if ($request->has('category') && empty($categorySlug)) {
            $catParam = $request->query('category');
            $slug = Str::slug($catParam);

            return redirect()->route('homepage.news.category', $slug, 301);
        }

        $search = $request->query('q');
        $query = News::where('status', 'published');

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Ambil daftar kategori berita resmi dari Master Kategori
        $newsCategories = \App\Models\Category::getOptions('berita');

        // Resolving category slug dengan pencocokan persis (exact match)
        $selectedCat = null;
        if (! empty($categorySlug)) {
            // Backward compatibility: slug lama 'berita-dan-peristiwa' diarahkan ke semua berita
            if ($categorySlug === 'berita-dan-peristiwa') {
                return redirect()->route('homepage.news', $search ? ['q' => $search] : [], 301);
            }

            // 1. Cocokkan dengan Master Kategori Berita (slug atau slug dari nama)
            foreach ($newsCategories as $catItem) {
                if (($catItem->slug ?? '') === $categorySlug || Str::slug($catItem->name) === $categorySlug) {
                    $selectedCat = $catItem->name;
                    break;
                }
            }

            // 2. Fallback: cocokkan dengan kategori yang ada di tabel news
            if (! $selectedCat) {
                $knownCategories = News::whereNotNull('category')->pluck('category')->unique();
                foreach ($knownCategories as $cat) {
                    if (Str::slug($cat) === $categorySlug) {
                        $selectedCat = $cat;
                        break;
                    }
                }
            }

            // 3. Jika belum ada di DB, tampilkan nama kategori yang rapi dari slug
            if (! $selectedCat) {
                $selectedCat = Str::title(str_replace('-', ' ', $categorySlug));
            }

            // Gunakan pencocokan persis agar "Berita Humas" tidak tercampur dengan "Berita Universitas"
            $query->where('category', $selectedCat);
        }

        $featured = null;
        if (empty($search) && empty($categorySlug)) {
            $featured = News::where('status', 'published')
                ->where('is_featured', true)
                ->latest()
                ->first();

            if (! $featured) {
                $featured = News::where('status', 'published')
                    ->latest()
                    ->first();
            }
        }

        $newsList = $query
            ->when($featured, fn ($q) => $q->where('id', '!=', $featured->id))
            ->latest()
            ->paginate(10)
            ->withPath($categorySlug ? url('/berita/kategori/'.$categorySlug) : url('/berita'));

        $categories = News::where('status', 'published')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('layouts.frontend.news', compact('featured', 'newsList', 'search', 'categories', 'newsCategories', 'selectedCat', 'categorySlug'));
    }

    public function newsCategory(Request $request, $categorySlug)
    {
        return $this->news($request, $categorySlug);
    }

    public function newsDetail($slug)
    {
        $news = News::where('status', 'published')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        // Redirect numeric ID to slug if available
        if (is_numeric($slug) && ! empty($news->slug)) {
            return redirect()->route('homepage.news.detail', $news->slug, 301);
        }

        $relatedNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(4)
            ->get();

        $categories = News::where('status', 'published')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('layouts.frontend.news-detail', compact('news', 'relatedNews', 'categories'));
    }

    public function prestasi(Request $request)
    {
        $search = $request->query('q');
        $selectedTingkat = $request->query('tingkat');
        $selectedProdi = $request->query('prodi');

        $query = Prestasi::where('is_active', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_prestasi', 'like', "%{$search}%")
                    ->orWhere('nama_mahasiswa', 'like', "%{$search}%")
                    ->orWhere('penyelenggara', 'like', "%{$search}%")
                    ->orWhere('peringkat', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (! empty($selectedTingkat)) {
            $query->where('tingkat', $selectedTingkat);
        }

        if (! empty($selectedProdi)) {
            $query->where('prodi', $selectedProdi);
        }

        $prestasiList = $query->orderBy('urutan')->latest('id')->paginate(9)->withQueryString();

        $tingkatList = ['Internasional', 'Nasional', 'Provinsi / Wilayah', 'Universitas'];

        return view('layouts.frontend.prestasi', compact('prestasiList', 'search', 'selectedTingkat', 'selectedProdi', 'tingkatList'));
    }

    public function prestasiDetail($slug)
    {
        $prestasi = Prestasi::where('is_active', true)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $otherPrestasis = Prestasi::where('is_active', true)
            ->where('id', '!=', $prestasi->id)
            ->orderBy('urutan')
            ->latest('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.prestasi-detail', compact('prestasi', 'otherPrestasis'));
    }

    public function organisasiMahasiswa(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');

        $query = OrganisasiMahasiswa::where('is_active', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_organisasi', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhere('nama_ketua', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (! empty($selectedKategori)) {
            $query->where('kategori', $selectedKategori);
        }

        $organisasiList = $query->orderBy('urutan')->latest('id')->paginate(9)->withQueryString();

        $kategoriList = ['BEM / DPM', 'Himpunan Mahasiswa (HIMA)', 'Unit Kegiatan Mahasiswa (UKM)', 'Komunitas Minat Bakat'];

        return view('layouts.frontend.organisasi', compact('organisasiList', 'search', 'selectedKategori', 'kategoriList'));
    }

    public function organisasiMahasiswaDetail($slug)
    {
        $organisasi = OrganisasiMahasiswa::where('is_active', true)
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->orWhere('id', $slug);
            })
            ->firstOrFail();

        $otherOrganisasis = OrganisasiMahasiswa::where('is_active', true)
            ->where('id', '!=', $organisasi->id)
            ->orderBy('urutan')
            ->latest('id')
            ->take(5)
            ->get();

        return view('layouts.frontend.organisasi-detail', compact('organisasi', 'otherOrganisasis'));
    }

    public function tracerStudy()
    {
        $item = AkademikController::getOrCreateItem('tracer-study');
        $url = !empty($item->link_url) ? $item->link_url : 'https://drive.google.com';

        return redirect()->away($url);
    }

    public function testimoni(Request $request)
    {
        $search = $request->query('q');
        $selectedKategori = $request->query('kategori');
        $selectedRating = $request->query('rating');

        $query = Testimonial::where('aktif', true);

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%")
                    ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        if (! empty($selectedKategori)) {
            $query->where('kategori', $selectedKategori);
        }

        if (! empty($selectedRating)) {
            $query->where('bintang', $selectedRating);
        }

        $testimonials = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Rating Stats for Analytics Chart & Summary
        $allActive = Testimonial::where('aktif', true)->get();
        $totalCount = $allActive->count();
        $avgScore = $totalCount > 0 ? round($allActive->avg('bintang'), 1) : 5.0;

        $ratingCounts = [
            5 => $allActive->where('bintang', 5)->count(),
            4 => $allActive->where('bintang', 4)->count(),
            3 => $allActive->where('bintang', 3)->count(),
            2 => $allActive->where('bintang', 2)->count(),
            1 => $allActive->where('bintang', 1)->count(),
        ];

        $ratingPercentages = [];
        foreach ($ratingCounts as $star => $count) {
            $ratingPercentages[$star] = $totalCount > 0 ? round(($count / $totalCount) * 100) : 0;
        }

        $categories = $allActive->pluck('kategori')->filter()->unique()->values();

        return view('layouts.frontend.testimoni', compact(
            'testimonials',
            'search',
            'selectedKategori',
            'selectedRating',
            'totalCount',
            'avgScore',
            'ratingCounts',
            'ratingPercentages',
            'categories'
        ));
    }

    public function alumniCreateTestimoni()
    {
        $a = random_int(2, 9);
        $b = random_int(1, 9);
        $captchaQuestion = "{$a} + {$b}";
        session([
            'testimonial_captcha_answer' => $a + $b,
            'testimonial_captcha_question' => $captchaQuestion,
        ]);

        return view('layouts.frontend.alumni-form', compact('captchaQuestion'));
    }

    public function storeTestimonial(AlumniTestimonialRequest $request)
    {
        $validated = $request->safe()->only(['nama', 'pekerjaan', 'kategori', 'bintang', 'pesan']);
        $validated['aktif'] = false; // Pending moderasi admin

        Testimonial::create($validated);

        // Hapus jawaban captcha dari sesi agar tidak dapat dipakai ulang (anti-replay)
        session()->forget(['testimonial_captcha_answer', 'testimonial_captcha_question']);

        return redirect()
            ->route('homepage.alumni.create')
            ->with('success', 'Terima kasih atas kontribusi Anda! Testimoni & kisah sukses Anda telah berhasil kami terima dan akan segera ditinjau oleh admin.');
    }

    /**
     * Pencarian global website (Berita, Pengumuman, Agenda, Dosen, dan Halaman Statis / Informasi).
     */
    public function search(Request $request)
    {
        $query = trim((string) ($request->query('q') ?? $request->query('search') ?? ''));
        $tab = $request->query('tab', 'semua');

        $newsResults = collect();
        $announcementResults = collect();
        $agendaResults = collect();
        $dosenResults = collect();
        $pageResults = collect();

        if ($query !== '') {
            $like = "%{$query}%";

            $newsResults = News::where('status', 'published')
                ->where(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('content', 'like', $like)
                        ->orWhere('category', 'like', $like);
                })
                ->latest()
                ->take(20)
                ->get();

            $announcementResults = Announcement::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                        ->orWhere('content', 'like', $like);
                })
                ->orderBy('urutan')
                ->latest('date')
                ->take(20)
                ->get();

            $agendaResults = Agenda::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('location', 'like', $like)
                        ->orWhere('date_text', 'like', $like);
                })
                ->orderBy('urutan')
                ->latest('id')
                ->take(20)
                ->get();

            $dosenResults = Dosen::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('nama_dosen', 'like', $like)
                        ->orWhere('jabatan_fungsional', 'like', $like)
                        ->orWhere('nidn', 'like', $like)
                        ->orWhere('nuptk', 'like', $like)
                        ->orWhere('prodi_nama', 'like', $like);
                })
                ->orderBy('urutan')
                ->take(20)
                ->get();

            // Katalog Halaman Statis Website
            $staticCatalog = [
                [
                    'title' => 'Profil & Pimpinan Program Studi',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-building',
                    'url' => route('homepage.tentang'),
                    'excerpt' => 'Informasi profil program studi, struktur pimpinan, dan identitas Program Studi S1 Teknik Informatika UIS.',
                    'keywords' => 'profil tentang pimpinan kaprodi dekan fakultas teknik informatika',
                ],
                [
                    'title' => 'Sambutan Ketua Program Studi',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-person-badge',
                    'url' => route('homepage.sambutan-kaprodi'),
                    'excerpt' => 'Kata sambutan resmi Ketua Program Studi S1 Teknik Informatika Fakultas Sains dan Teknologi UIS.',
                    'keywords' => 'sambutan kaprodi ketua prodi dekan rektor pengantar',
                ],
                [
                    'title' => 'Visi, Misi, Tujuan & Sasaran (VMTS)',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-bullseye',
                    'url' => route('homepage.visi-misi'),
                    'excerpt' => 'Visi, misi, tujuan, dan sasaran strategis Program Studi Teknik Informatika.',
                    'keywords' => 'visi misi tujuan sasaran vmts arah kebijakan',
                ],
                [
                    'title' => 'Sejarah Program Studi',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-clock-history',
                    'url' => route('homepage.sejarah'),
                    'excerpt' => 'Perjalanan sejarah dan perkembangan Program Studi Teknik Informatika Universitas Ibnu Sina.',
                    'keywords' => 'sejarah milestone perkembangan berdirinya prodi',
                ],
                [
                    'title' => 'Struktur Organisasi',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-diagram-3',
                    'url' => route('homepage.struktur-organisasi'),
                    'excerpt' => 'Bagan struktur organisasi dan tata kelola Program Studi Teknik Informatika.',
                    'keywords' => 'struktur organisasi bagan tata kelola manajemen',
                ],
                [
                    'title' => 'Fasilitas & Sarana Kampus',
                    'type' => 'Halaman Statis',
                    'icon' => 'bi-pc-display',
                    'url' => route('homepage.fasilitas'),
                    'excerpt' => 'Daftar fasilitas laboratorium komputer, ruang kuliah, perpustakaan, dan sarana pendukung pembelajaran.',
                    'keywords' => 'fasilitas sarana prasarana laboratorium lab komputer ruang kuliah',
                ],
                [
                    'title' => 'Kurikulum & Daftar Mata Kuliah (OBE)',
                    'type' => 'Akademik',
                    'icon' => 'bi-journal-bookmark',
                    'url' => route('homepage.kurikulum'),
                    'excerpt' => 'Struktur kurikulum OBE, daftar mata kuliah per semester, SKS, dan dokumen RPS.',
                    'keywords' => 'kurikulum obe mata kuliah sks rps semester silabus',
                ],
                [
                    'title' => 'Kalender Akademik',
                    'type' => 'Akademik',
                    'icon' => 'bi-calendar3',
                    'url' => route('homepage.kalender-akademik'),
                    'excerpt' => 'Jadwal kalender akademik semester ganjil dan genap, pengisian KRS, UTS, UAS, dan wisuda.',
                    'keywords' => 'kalender akademik jadwal kuliah krs uts uas libur semester',
                ],
                [
                    'title' => 'Pedoman Akademik',
                    'type' => 'Akademik',
                    'icon' => 'bi-book',
                    'url' => route('homepage.pedoman-akademik'),
                    'excerpt' => 'Buku pedoman akademik, peraturan perkuliahan, evaluasi studi, dan tugas akhir/skripsi.',
                    'keywords' => 'pedoman akademik panduan peraturan skripsi tugas akhir krs',
                ],
                [
                    'title' => 'Sistem Informasi Akademik (SIAKAD)',
                    'type' => 'Akademik',
                    'icon' => 'bi-laptop',
                    'url' => route('homepage.sistem-akademik'),
                    'excerpt' => 'Akses layanan sistem informasi akademik online untuk mahasiswa dan dosen (KRS, KHS, absensi).',
                    'keywords' => 'sistem akademik siakad portal mahasiswa krs khs nilai',
                ],
                [
                    'title' => 'Pendaftaran PMB (Penerimaan Mahasiswa Baru)',
                    'type' => 'PMB',
                    'icon' => 'bi-pencil-square',
                    'url' => route('homepage.portal.page', 'pendaftaran-pmb'),
                    'excerpt' => 'Informasi pendaftaran mahasiswa baru, jalur masuk, jadwal gelombang, dan persyaratan PMB.',
                    'keywords' => 'pmb pendaftaran mahasiswa baru daftar kuliah beasiswa gelombang',
                ],
                [
                    'title' => 'Informasi PMB',
                    'type' => 'PMB',
                    'icon' => 'bi-info-circle',
                    'url' => route('homepage.portal.page', 'informasi-pmb'),
                    'excerpt' => 'Rincian informasi penerimaan mahasiswa baru Program Studi Teknik Informatika UIS.',
                    'keywords' => 'informasi pmb biaya kuliah syarat pendaftaran prodi',
                ],
                [
                    'title' => 'Prestasi Mahasiswa',
                    'type' => 'Kemahasiswaan',
                    'icon' => 'bi-trophy',
                    'url' => route('homepage.prestasi'),
                    'excerpt' => 'Daftar capaian dan prestasi akademik maupun non-akademik mahasiswa Teknik Informatika.',
                    'keywords' => 'prestasi mahasiswa juara lomba kompetisi penghargaan',
                ],
                [
                    'title' => 'Organisasi Mahasiswa (Ormawa)',
                    'type' => 'Kemahasiswaan',
                    'icon' => 'bi-people',
                    'url' => route('homepage.organisasi'),
                    'excerpt' => 'Himpunan mahasiswa dan organisasi kemahasiswaan di lingkungan Program Studi Teknik Informatika.',
                    'keywords' => 'organisasi mahasiswa ormawa himpunan himati bem ukm',
                ],
                [
                    'title' => 'Galeri Foto & Dokumentasi',
                    'type' => 'Publikasi',
                    'icon' => 'bi-images',
                    'url' => route('homepage.galeri'),
                    'excerpt' => 'Dokumentasi visual kegiatan perkuliahan, praktikum, seminar, dan pengabdian masyarakat.',
                    'keywords' => 'galeri foto dokumentasi kegiatan kampus',
                ],
                [
                    'title' => 'Unduhan & E-Dokumen',
                    'type' => 'Dokumen',
                    'icon' => 'bi-download',
                    'url' => route('homepage.unduhan'),
                    'excerpt' => 'Pusat unduhan formulir akademik, SOP, template dokumen, dan berkas resmi program studi.',
                    'keywords' => 'unduhan download dokumen formulir sop template berkas',
                ],
                [
                    'title' => 'Testimoni Alumni & Tracer Study',
                    'type' => 'Alumni',
                    'icon' => 'bi-chat-quote',
                    'url' => route('homepage.testimoni'),
                    'excerpt' => 'Kisah sukses alumni, ulasan lulusan, dan informasi tracer study Program Studi Teknik Informatika.',
                    'keywords' => 'testimoni alumni tracer study lulusan karir',
                ],
                [
                    'title' => 'FAQ & Pusat Bantuan',
                    'type' => 'Bantuan',
                    'icon' => 'bi-question-circle',
                    'url' => route('homepage.faq'),
                    'excerpt' => 'Pertanyaan yang sering diajukan seputar perkuliahan, pendaftaran, dan layanan program studi.',
                    'keywords' => 'faq pertanyaan bantuan tanya jawab informasi',
                ],
                [
                    'title' => 'Kontak & Lokasi Kampus',
                    'type' => 'Kontak',
                    'icon' => 'bi-telephone',
                    'url' => route('homepage.kontak'),
                    'excerpt' => 'Alamat kampus, nomor WhatsApp/telepon, email resmi, jam operasional, dan peta lokasi.',
                    'keywords' => 'kontak hubungi kami alamat telepon whatsapp email jam operasional peta lokasi',
                ],
            ];

            $qLower = mb_strtolower($query);
            foreach ($staticCatalog as $page) {
                $haystack = mb_strtolower($page['title'].' '.$page['excerpt'].' '.$page['keywords']);
                if (str_contains($haystack, $qLower)) {
                    $pageResults->push((object) $page);
                }
            }

            // Halaman Akademik dari database
            $akademikRouteMap = [
                'kalender_akademik' => route('homepage.kalender-akademik'),
                'kalender-akademik' => route('homepage.kalender-akademik'),
                'pedoman_akademik' => route('homepage.pedoman-akademik'),
                'pedoman-akademik' => route('homepage.pedoman-akademik'),
                'sistem_akademik' => route('homepage.sistem-akademik'),
                'sistem-akademik' => route('homepage.sistem-akademik'),
                'kurikulum' => route('homepage.kurikulum'),
            ];

            $akademikItems = Akademik::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('judul', 'like', $like)
                        ->orWhere('subjudul', 'like', $like)
                        ->orWhere('deskripsi', 'like', $like);
                })
                ->take(10)
                ->get();

            foreach ($akademikItems as $ak) {
                $url = $akademikRouteMap[$ak->tipe] ?? route('homepage.portal.page', Str::slug($ak->tipe ?? 'akademik'));
                $pageResults->push((object) [
                    'title' => $ak->judul,
                    'type' => 'Akademik',
                    'icon' => 'bi-mortarboard',
                    'url' => $url,
                    'excerpt' => Str::limit(trim(strip_tags((string) ($ak->deskripsi ?: $ak->subjudul))), 160),
                ]);
            }

            // Prestasi Mahasiswa
            $prestasiItems = Prestasi::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('judul_prestasi', 'like', $like)
                        ->orWhere('nama_mahasiswa', 'like', $like)
                        ->orWhere('penyelenggara', 'like', $like)
                        ->orWhere('deskripsi', 'like', $like);
                })
                ->take(10)
                ->get();

            foreach ($prestasiItems as $pr) {
                $pageResults->push((object) [
                    'title' => $pr->judul_prestasi,
                    'type' => 'Prestasi',
                    'icon' => 'bi-trophy-fill',
                    'url' => route('homepage.prestasi.detail', $pr->slug),
                    'excerpt' => Str::limit(trim(strip_tags((string) ($pr->deskripsi ?: ($pr->nama_mahasiswa.' — '.$pr->penyelenggara)))), 160),
                ]);
            }

            // Organisasi Mahasiswa
            $ormawaItems = OrganisasiMahasiswa::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('nama_organisasi', 'like', $like)
                        ->orWhere('singkatan', 'like', $like)
                        ->orWhere('deskripsi', 'like', $like);
                })
                ->take(10)
                ->get();

            foreach ($ormawaItems as $orm) {
                $pageResults->push((object) [
                    'title' => $orm->nama_organisasi.($orm->singkatan ? " ({$orm->singkatan})" : ''),
                    'type' => 'Organisasi',
                    'icon' => 'bi-people-fill',
                    'url' => route('homepage.organisasi.detail', $orm->slug),
                    'excerpt' => Str::limit(trim(strip_tags((string) $orm->deskripsi)), 160),
                ]);
            }

            // Unduhan / E-Dokumen
            $unduhanItems = Unduhan::where('is_active', true)
                ->where(function ($q) use ($like) {
                    $q->where('judul', 'like', $like)
                        ->orWhere('deskripsi', 'like', $like)
                        ->orWhere('kategori', 'like', $like);
                })
                ->take(10)
                ->get();

            foreach ($unduhanItems as $und) {
                $pageResults->push((object) [
                    'title' => $und->judul,
                    'type' => 'E-Dokumen',
                    'icon' => 'bi-file-earmark-arrow-down',
                    'url' => route('homepage.unduhan'),
                    'excerpt' => Str::limit(trim(strip_tags((string) $und->deskripsi)), 160),
                ]);
            }

            // FAQ
            $faqItems = Faq::where(function ($q) use ($like) {
                $q->where('question', 'like', $like)
                    ->orWhere('answer', 'like', $like);
            })
                ->take(10)
                ->get();

            foreach ($faqItems as $faq) {
                $pageResults->push((object) [
                    'title' => $faq->question,
                    'type' => 'FAQ',
                    'icon' => 'bi-question-circle-fill',
                    'url' => route('homepage.faq'),
                    'excerpt' => Str::limit(trim(strip_tags((string) $faq->answer)), 160),
                ]);
            }

            // Hindari duplikasi URL halaman statis yang sama persis dengan judul sama
            $pageResults = $pageResults->unique(fn ($item) => mb_strtolower($item->title.'|'.$item->url))->values();
        }

        $counts = [
            'berita' => $newsResults->count(),
            'pengumuman' => $announcementResults->count(),
            'agenda' => $agendaResults->count(),
            'dosen' => $dosenResults->count(),
            'halaman' => $pageResults->count(),
        ];
        $totalResults = array_sum($counts);

        return view('layouts.frontend.search', compact(
            'query',
            'tab',
            'newsResults',
            'announcementResults',
            'agendaResults',
            'dosenResults',
            'pageResults',
            'counts',
            'totalResults'
        ));
    }

    public function kebijakanPrivasi()
    {
        return view('layouts.frontend.kebijakan-privasi');
    }

    public function fasilitasDetail(string $slug)
    {
        Sarana::ensureColumns();

        $hasSlugColumn = Schema::hasColumn('saranas', 'slug');

        $sarana = Sarana::where('is_active', true)
            ->where(function ($q) use ($slug, $hasSlugColumn) {
                if ($hasSlugColumn) {
                    $q->where('slug', $slug);
                    if (ctype_digit($slug)) {
                        $q->orWhere('id', (int) $slug);
                    }
                } else {
                    $q->where('id', ctype_digit($slug) ? (int) $slug : 0);
                }
            })
            ->firstOrFail();

        $otherSaranas = Sarana::where('is_active', true)
            ->where('id', '!=', $sarana->id)
            ->orderBy('urutan')
            ->get();

        return view('layouts.frontend.fasilitas-detail', compact('sarana', 'otherSaranas'));
    }

    public function syaratKetentuan()
    {
        return view('layouts.frontend.syarat-ketentuan');
    }

    public function penelitian(Request $request)
    {
        Penelitian::ensureTable();

        $activeJenis = $request->query('jenis', 'all');
        $activeTahun = $request->query('tahun');
        $search = trim((string) ($request->query('q') ?? $request->query('search') ?? ''));

        $query = Penelitian::where('is_active', true);

        if (in_array($activeJenis, ['penelitian', 'pengabdian'], true)) {
            $query->where('jenis', $activeJenis);
        } else {
            $activeJenis = 'all';
        }

        if (!empty($activeTahun)) {
            $query->where('tahun', (int) $activeTahun);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('ketua', 'like', "%{$search}%")
                    ->orWhere('anggota', 'like', "%{$search}%")
                    ->orWhere('sumber_dana', 'like', "%{$search}%")
                    ->orWhere('bidang_riset', 'like', "%{$search}%");
            });
        }

        $items = $query->orderByDesc('tahun')->orderByDesc('id')->paginate(12)->withQueryString();

        $stats = [
            'all' => Penelitian::where('is_active', true)->count(),
            'penelitian' => Penelitian::where('is_active', true)->where('jenis', 'penelitian')->count(),
            'pengabdian' => Penelitian::where('is_active', true)->where('jenis', 'pengabdian')->count(),
        ];

        $years = Penelitian::where('is_active', true)->select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        Dosen::ensureColumns();

        $bidangRiset = Schema::hasColumn('dosens', 'bidang_keahlian')
            ? Dosen::where('is_active', true)
                ->whereNotNull('bidang_keahlian')
                ->where('bidang_keahlian', '!=', '')
                ->pluck('bidang_keahlian')
                ->unique()
                ->values()
            : collect();

        return view('layouts.frontend.penelitian', compact(
            'items',
            'stats',
            'years',
            'bidangRiset',
            'activeJenis',
            'activeTahun',
            'search'
        ));
    }

    public function sitemap()
    {
        $staticUrls = [
            ['loc' => route('homepage'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('homepage.tentang'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.sambutan-kaprodi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.visi-misi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.sejarah'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.struktur-organisasi'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.fasilitas'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.kurikulum'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.kalender-akademik'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.pedoman-akademik'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.sistem-akademik'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.dosen'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.penelitian'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.news'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('homepage.pengumuman'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('homepage.agenda'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.galeri'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.prestasi'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.organisasi'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.unduhan'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.testimoni'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('homepage.faq'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.kontak'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('homepage.kebijakan-privasi'), 'priority' => '0.4', 'changefreq' => 'yearly'],
            ['loc' => route('homepage.syarat-ketentuan'), 'priority' => '0.4', 'changefreq' => 'yearly'],
        ];

        $urls = collect($staticUrls)->map(fn ($u) => array_merge($u, ['lastmod' => now()->toAtomString()]));

        News::where('status', 'published')->latest()->take(200)->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.news.detail', $item->slug ?? $item->id),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        });

        Announcement::where('is_active', true)->latest('date')->take(100)->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.pengumuman.detail', $item->slug),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        });

        Agenda::where('is_active', true)->latest('id')->take(100)->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.agenda.detail', $item->slug),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ]);
        });

        Prestasi::where('is_active', true)->latest('id')->take(100)->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.prestasi.detail', $item->slug),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ]);
        });

        OrganisasiMahasiswa::where('is_active', true)->orderBy('urutan')->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.organisasi.detail', $item->slug),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]);
        });

        Sarana::where('is_active', true)->orderBy('urutan')->get()->each(function ($item) use (&$urls) {
            $urls->push([
                'loc' => route('homepage.fasilitas.detail', $item->slug ?: $item->id),
                'lastmod' => optional($item->updated_at ?? $item->created_at)->toAtomString() ?? now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ]);
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= '    <lastmod>'.$u['lastmod']."</lastmod>\n";
            $xml .= '    <changefreq>'.$u['changefreq']."</changefreq>\n";
            $xml .= '    <priority>'.$u['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
