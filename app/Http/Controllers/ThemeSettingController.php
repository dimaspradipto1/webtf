<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
            'header_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:10240',
            'header_title' => 'nullable|string|max:100',
            'header_subtitle' => 'nullable|string|max:150',
            'remove_header_logo' => 'nullable',
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
            'topbar_social_bg_color' => 'nullable|string|max:30',
            'topbar_social_text_color' => 'nullable|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'sections' => 'nullable|array',
            'footer_bg_color' => 'nullable|string|max:30',
            'footer_text_color' => 'nullable|string|max:30',
            'footer_heading_color' => 'nullable|string|max:30',
            'footer_border_top_color' => 'nullable|string|max:30',
            'footer_link_color' => 'nullable|string|max:30',
            'footer_link_hover_color' => 'nullable|string|max:30',
            'footer_social_bg_color' => 'nullable|string|max:30',
            'footer_social_text_color' => 'nullable|string|max:30',
            'footer_description' => 'nullable|string',
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        $setting = ThemeSetting::current();

        $hasLogoCol = Schema::hasColumn('theme_settings', 'header_logo');
        $hasTitleCol = Schema::hasColumn('theme_settings', 'header_title');
        $hasSubtitleCol = Schema::hasColumn('theme_settings', 'header_subtitle');

        // Kelola file logo header jika diunggah atau dihapus
        $logoPath = $hasLogoCol ? $setting->getRawOriginal('header_logo') : null;
        if ($request->boolean('remove_header_logo')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = null;
        }

        if ($request->hasFile('header_logo')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('header_logo')->store('theme/logo', 'public');
        }

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

        $updateData = [
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
            'topbar_social_bg_color' => !empty($validated['topbar_social_bg_color']) ? $validated['topbar_social_bg_color'] : '#ffffff',
            'topbar_social_text_color' => !empty($validated['topbar_social_text_color']) ? $validated['topbar_social_text_color'] : '#000000',
            'accent_color' => !empty($validated['accent_color']) ? $validated['accent_color'] : '#f9dc4b',
            'sections_order' => $processedSections,
            'footer_bg_color' => !empty($validated['footer_bg_color']) ? $validated['footer_bg_color'] : '#000000',
            'footer_text_color' => !empty($validated['footer_text_color']) ? $validated['footer_text_color'] : '#ffffff',
            'footer_heading_color' => !empty($validated['footer_heading_color']) ? $validated['footer_heading_color'] : '#f9dc4b',
            'footer_border_top_color' => !empty($validated['footer_border_top_color']) ? $validated['footer_border_top_color'] : '#f9dc4b',
            'footer_link_color' => !empty($validated['footer_link_color']) ? $validated['footer_link_color'] : '#ffffff',
            'footer_link_hover_color' => !empty($validated['footer_link_hover_color']) ? $validated['footer_link_hover_color'] : '#f9dc4b',
            'footer_social_bg_color' => !empty($validated['footer_social_bg_color']) ? $validated['footer_social_bg_color'] : '#f9dc4b',
            'footer_social_text_color' => !empty($validated['footer_social_text_color']) ? $validated['footer_social_text_color'] : '#000000',
            'footer_description' => $validated['footer_description'] ?? $setting->footer_description,
            'footer_copyright' => $validated['footer_copyright'] ?? $setting->footer_copyright,
        ];

        // Hanya sertakan kolom brand jika kolom tersedia di tabel database
        if ($hasLogoCol) {
            $updateData['header_logo'] = $logoPath;
        }
        if ($hasTitleCol) {
            $updateData['header_title'] = $validated['header_title'] ?? 'TEKNIK INFORMATIKA';
        }
        if ($hasSubtitleCol) {
            $updateData['header_subtitle'] = $validated['header_subtitle'] ?? 'Fakultas Sains dan Teknologi';
        }

        $setting->update($updateData);

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
        $logoPath = $setting->getRawOriginal('header_logo');
        if ($logoPath && Storage::disk('public')->exists($logoPath)) {
            Storage::disk('public')->delete($logoPath);
        }
        $setting->update([
            'header_logo' => null,
            'header_title' => 'TEKNIK INFORMATIKA',
            'header_subtitle' => 'Fakultas Sains dan Teknologi',
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
            'sections_order' => ThemeSetting::defaultSections(),
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
        ]);

        AppServiceProvider::recordContentUpdate();

        Alert::success('Berhasil Direset', 'Pengaturan tema header dan tata letak beranda berhasil dikembalikan ke standar awal.');
        return redirect()->back();
    }
}

