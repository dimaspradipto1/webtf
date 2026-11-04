<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ThemeSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan tema header dan urutan section beranda.
     */
    public function index()
    {
        $setting = ThemeSetting::current();
        $sections = $setting->getActiveSectionsList();

        return view('pages.theme-setting.index', compact('setting', 'sections'));
    }

    /**
     * Simpan pembaruan warna header dan tata letak section beranda.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'header_bg_color' => 'required|string|max:30',
            'header_text_color' => 'required|string|max:30',
            'header_active_bg_color' => 'required|string|max:30',
            'header_active_text_color' => 'required|string|max:30',
            'header_login_bg_color' => 'required|string|max:30',
            'header_login_text_color' => 'required|string|max:30',
            'header_shadow_color' => 'nullable|string|max:30',
            'header_is_sticky' => 'nullable',
            'topbar_bg_color' => 'required|string|max:30',
            'topbar_text_color' => 'required|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'sections' => 'nullable|array',
        ]);

        $setting = ThemeSetting::current();

        // Olah urutan dan status aktif setiap section
        $sectionsInput = $request->input('sections', []);
        $defaults = ThemeSetting::defaultSections();
        $defaultKeys = array_column($defaults, null, 'key');

        $processedSections = [];
        $order = 1;

        if (is_array($sectionsInput)) {
            foreach ($sectionsInput as $key => $secData) {
                if (isset($defaultKeys[$key])) {
                    $def = $defaultKeys[$key];
                    $processedSections[] = [
                        'key' => $key,
                        'name' => $def['name'],
                        'desc' => $def['desc'],
                        'icon' => $def['icon'],
                        'is_active' => isset($secData['is_active']) && ($secData['is_active'] == '1' || $secData['is_active'] === true),
                        'order' => isset($secData['order']) ? (int) $secData['order'] : $order,
                    ];
                    $order++;
                }
            }
        }

        // Pastikan tidak ada section default yang hilang
        $existingKeys = array_column($processedSections, 'key');
        foreach ($defaults as $def) {
            if (!in_array($def['key'], $existingKeys)) {
                $processedSections[] = array_merge($def, ['order' => $order]);
                $order++;
            }
        }

        // Urutkan berdasarkan kolom order
        usort($processedSections, fn($a, $b) => $a['order'] <=> $b['order']);

        $setting->update([
            'header_bg_color' => $validated['header_bg_color'],
            'header_text_color' => $validated['header_text_color'],
            'header_active_bg_color' => $validated['header_active_bg_color'],
            'header_active_text_color' => $validated['header_active_text_color'],
            'header_login_bg_color' => $validated['header_login_bg_color'],
            'header_login_text_color' => $validated['header_login_text_color'],
            'header_shadow_color' => !empty($validated['header_shadow_color']) ? $validated['header_shadow_color'] : $validated['header_bg_color'],
            'header_is_sticky' => $request->has('header_is_sticky'),
            'topbar_bg_color' => $validated['topbar_bg_color'],
            'topbar_text_color' => $validated['topbar_text_color'],
            'accent_color' => !empty($validated['accent_color']) ? $validated['accent_color'] : '#f9dc4b',
            'sections_order' => $processedSections,
        ]);

        AppServiceProvider::recordContentUpdate();

        Alert::success('Berhasil Disimpan', 'Warna header dan urutan section beranda berhasil diperbarui secara realtime!');
        return redirect()->back();
    }

    /**
     * Kembalikan seluruh pengaturan ke default pabrikan Teknik Informatika.
     */
    public function reset()
    {
        $setting = ThemeSetting::current();
        $setting->update([
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
            'accent_color' => '#f9dc4b',
            'sections_order' => ThemeSetting::defaultSections(),
        ]);

        AppServiceProvider::recordContentUpdate();

        Alert::success('Berhasil Direset', 'Pengaturan tema header dan tata letak beranda berhasil dikembalikan ke standar awal.');
        return redirect()->back();
    }
}

