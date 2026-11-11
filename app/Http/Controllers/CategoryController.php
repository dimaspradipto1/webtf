<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar master kategori dengan filter modul.
     */
    public function index(Request $request): View
    {
        Category::ensureTableAndDefaults();

        $activeType = $request->query('type', 'all');
        $search = $request->query('search');

        $query = Category::query();

        if ($activeType !== 'all' && !empty($activeType)) {
            $query->where('type', $activeType);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('type')
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Hitung statistik per modul untuk navigasi tabs
        $stats = [
            'all' => Category::count(),
            'berita' => Category::where('type', 'berita')->count(),
            'unduhan' => Category::where('type', 'unduhan')->count(),
            'galeri' => Category::where('type', 'galeri')->count(),
            'testimoni' => Category::where('type', 'testimoni')->count(),
        ];

        return view('pages.category.index', compact('categories', 'activeType', 'search', 'stats'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::ensureTableAndDefaults();

        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) 
            ? Str::slug($data['slug']) 
            : Category::generateUniqueSlug($data['name'], $data['type']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $data['order'] ?? (Category::where('type', $data['type'])->max('order') + 1);

        Category::create($data);

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('category.index', ['type' => $data['type']])
            ->with('success', "Kategori '{$data['name']}' berhasil ditambahkan.");
    }

    /**
     * Perbarui data kategori.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) 
            ? Str::slug($data['slug']) 
            : Category::generateUniqueSlug($data['name'], $data['type'], $category->id);
        $data['is_active'] = $request->boolean('is_active', true);

        $category->update($data);

        AppServiceProvider::recordContentUpdate();

        return redirect()
            ->route('category.index', ['type' => $category->type])
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui.");
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $type = $category->type;
        $count = $category->items_count;

        $category->delete();

        AppServiceProvider::recordContentUpdate();

        $msg = "Kategori '{$name}' berhasil dihapus.";
        if ($count > 0) {
            $msg .= " Catatan: Terdapat {$count} konten yang sebelumnya memakai kategori ini.";
        }

        return redirect()
            ->route('category.index', ['type' => $type])
            ->with('success', $msg);
    }

    /**
     * Toggle status aktif/nonaktif kategori.
     */
    public function toggle(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);

        AppServiceProvider::recordContentUpdate();

        $statusText = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->back()
            ->with('success', "Kategori '{$category->name}' berhasil {$statusText}.");
    }
}

