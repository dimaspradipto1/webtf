<?php

namespace App\Providers;

use App\Models\BahasaSetting;
use App\Models\Beasiswa;
use App\Models\Contact;
use App\Models\Layanan;
use App\Models\PmbSetting;
use App\Models\Publikasi;
use App\Models\Topbar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Catat timestamp versi konten saat model Eloquent diupdate/disimpan/dihapus
        Event::listen(['eloquent.saved: *', 'eloquent.deleted: *'], function ($event, $data) {
            if (!empty($data) && is_object($data[0])) {
                $class = get_class($data[0]);
                if (str_starts_with($class, 'App\\Models\\')) {
                    static::recordContentUpdate();
                }
            }
        });

        View::composer('*', function ($view) {
            $contact = Contact::latest('id')->first();
            $pmbSetting = PmbSetting::first();
            $navProdis = Layanan::where('aktif', true)->orderBy('urutan')->get();
            $navPublikasis = Publikasi::where('aktif', true)->orderBy('urutan')->get();
            try {
                $navBeasiswas = Beasiswa::where('aktif', true)->orderBy('urutan')->get();
            } catch (\Throwable $e) {
                $navBeasiswas = collect();
            }
            $topbarSetting = Topbar::where('is_active', true)->latest('id')->first();

            $cleanWa = '';
            $waSource = $topbarSetting?->telepon ?? $contact?->no_wa ?? '';
            if (! empty($waSource)) {
                $cleanWa = preg_replace('/[^0-9]/', '', $waSource);
                if (strpos($cleanWa, '08') === 0) {
                    $cleanWa = '628'.substr($cleanWa, 2);
                }
            }

            try {
                $bahasaList = BahasaSetting::where('is_active', true)->orderBy('urutan')->get();
                $defaultBahasa = $bahasaList->firstWhere('is_default', true) ?? $bahasaList->first();
            } catch (\Throwable $e) {
                $bahasaList = collect();
                $defaultBahasa = null;
            }

            $view->with([
                'contact' => $contact,
                'cleanWa' => $cleanWa,
                'pmbSetting' => $pmbSetting,
                'navProdis' => $navProdis,
                'navPublikasis' => $navPublikasis,
                'navBeasiswas' => $navBeasiswas,
                'topbarSetting' => $topbarSetting,
                'bahasaList' => $bahasaList,
                'defaultBahasa' => $defaultBahasa,
            ]);
        });
    }

    /**
     * Catat timestamp pembaruan konten sistem untuk sinkronisasi realtime frontend
     */
    public static function recordContentUpdate(): void
    {
        $now = now()->getTimestampMs();
        try {
            Cache::forever('frontend_content_version', $now);
            $filePath = storage_path('framework/content_version.txt');
            @file_put_contents($filePath, (string) $now);
        } catch (\Throwable $e) {
            // fallback diam
        }
    }
}
