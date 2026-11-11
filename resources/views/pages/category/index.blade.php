@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kategori</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
    </nav>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <strong>Terdapat kesalahan pengisian:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Tab Navigasi Filter Modul --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('category.index', ['type' => 'all']) }}" 
       class="btn {{ $activeType === 'all' ? 'btn-primary' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-grid-fill me-1"></i> Semua
        <span class="badge {{ $activeType === 'all' ? 'bg-white text-primary' : 'bg-secondary' }} ms-1">{{ $stats['all'] }}</span>
    </a>
    <a href="{{ route('category.index', ['type' => 'berita']) }}" 
       class="btn {{ $activeType === 'berita' ? 'btn-primary' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-newspaper me-1"></i> Berita & Informasi
        <span class="badge {{ $activeType === 'berita' ? 'bg-white text-primary' : 'bg-primary' }} ms-1">{{ $stats['berita'] }}</span>
    </a>
    <a href="{{ route('category.index', ['type' => 'unduhan']) }}" 
       class="btn {{ $activeType === 'unduhan' ? 'btn-info text-white' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-folder2-open me-1"></i> E-Dokumen / SOP
        <span class="badge {{ $activeType === 'unduhan' ? 'bg-white text-info' : 'bg-info text-white' }} ms-1">{{ $stats['unduhan'] }}</span>
    </a>
    <a href="{{ route('category.index', ['type' => 'galeri']) }}" 
       class="btn {{ $activeType === 'galeri' ? 'btn-success' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-images me-1"></i> Galeri
        <span class="badge {{ $activeType === 'galeri' ? 'bg-white text-success' : 'bg-success' }} ms-1">{{ $stats['galeri'] }}</span>
    </a>
    <a href="{{ route('category.index', ['type' => 'testimoni']) }}" 
       class="btn {{ $activeType === 'testimoni' ? 'btn-warning text-dark' : 'btn-outline-secondary bg-white' }} fw-semibold shadow-sm">
        <i class="bi bi-chat-quote-fill me-1"></i> Testimoni
        <span class="badge {{ $activeType === 'testimoni' ? 'bg-dark text-white' : 'bg-warning text-dark' }} ms-1">{{ $stats['testimoni'] }}</span>
    </a>
</div>

<div class="card shadow-sm border-0" style="border-radius: 12px;">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-tags-fill text-primary"></i> Master Kategori Konten
            </h5>
            <small class="text-muted">Kelola seluruh kategori untuk menu Berita, E-Dokumen / Unduhan, Galeri, dan Testimoni di satu tempat.</small>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <form action="{{ route('category.index') }}" method="GET" class="d-flex gap-2">
                @if($activeType !== 'all')
                    <input type="hidden" name="type" value="{{ $activeType }}">
                @endif
                <div class="input-group input-group-sm" style="max-width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama / slug..." value="{{ $search ?? '' }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    @if(!empty($search))
                        <a href="{{ route('category.index', ['type' => $activeType]) }}" class="btn btn-outline-danger"><i class="bi bi-x"></i></a>
                    @endif
                </div>
            </form>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div class="card-body pt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>Nama Kategori</th>
                        <th style="width: 170px;">Modul / Tipe</th>
                        <th>Slug</th>
                        <th style="width: 120px;" class="text-center">Total Konten</th>
                        <th style="width: 100px;" class="text-center">Status</th>
                        <th style="width: 130px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $cat)
                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $categories->firstItem() + $index }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if(!empty($cat->icon))
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 32px; height: 32px; background: {{ $cat->color ? $cat->color.'20' : '#e9ecef' }}; color: {{ $cat->color ?: '#495057' }};">
                                            <i class="bi {{ $cat->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 32px; height: 32px; background: #e9ecef; color: #6c757d;">
                                            <i class="bi bi-tag-fill"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="fw-bold text-dark">{{ $cat->name }}</span>
                                        @if(!empty($cat->description))
                                            <div class="small text-muted text-truncate" style="max-width: 280px;">{{ $cat->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $cat->type_badge_color }} px-2 py-1">
                                    {{ $cat->type_label }}
                                </span>
                            </td>
                            <td>
                                <code class="text-muted small">{{ $cat->slug }}</code>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    {{ $cat->items_count }} item
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('category.toggle', $cat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0" title="Klik untuk mengubah status">
                                        @if($cat->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                                <i class="bi bi-dash-circle-fill me-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-edit-category" 
                                            data-id="{{ $cat->id }}"
                                            data-name="{{ $cat->name }}"
                                            data-slug="{{ $cat->slug }}"
                                            data-type="{{ $cat->type }}"
                                            data-description="{{ $cat->description }}"
                                            data-color="{{ $cat->color }}"
                                            data-icon="{{ $cat->icon }}"
                                            data-order="{{ $cat->order }}"
                                            data-active="{{ $cat->is_active ? 1 : 0 }}"
                                            title="Edit Kategori">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('category.destroy', $cat->id) }}" method="POST" class="d-inline form-delete-category">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-delete-trigger" 
                                                data-name="{{ $cat->name }}" 
                                                data-count="{{ $cat->items_count }}"
                                                title="Hapus Kategori">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada kategori untuk filter ini. Silakan tambah kategori baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $categories->firstItem() }} s/d {{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                </small>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalAddCategory" tabindex="-1" aria-labelledby="modalAddCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalAddCategoryLabel">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="add_type" class="form-label fw-semibold">Tipe Modul / Menu <span class="text-danger">*</span></label>
                        <select name="type" id="add_type" class="form-select" required>
                            <option value="berita" {{ $activeType === 'berita' ? 'selected' : '' }}>📰 Berita & Informasi</option>
                            <option value="unduhan" {{ $activeType === 'unduhan' ? 'selected' : '' }}>📁 E-Dokumen / SOP</option>
                            <option value="galeri" {{ $activeType === 'galeri' ? 'selected' : '' }}>🖼️ Galeri Dokumentasi</option>
                            <option value="testimoni" {{ $activeType === 'testimoni' ? 'selected' : '' }}>💬 Testimoni</option>
                            <option value="faq" {{ $activeType === 'faq' ? 'selected' : '' }}>❓ FAQ Informasi</option>
                            <option value="lainnya">🏷️ Lainnya (Kategori Umum)</option>
                        </select>
                        <div class="form-text small">Pilih menu mana yang akan menggunakan kategori ini.</div>
                    </div>

                    <div class="mb-3">
                        <label for="add_name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="add_name" class="form-control" placeholder="Contoh: Prestasi Mahasiswa, AI & Robotika" required>
                    </div>

                    <div class="mb-3">
                        <label for="add_slug" class="form-label fw-semibold">Slug URL (Opsional)</label>
                        <input type="text" name="slug" id="add_slug" class="form-control font-monospace" placeholder="Otomatis dibuat jika dikosongkan">
                        <div class="form-text small">Digunakan pada URL halaman arsip/kategori.</div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="add_icon" class="form-label fw-semibold">Icon Bootstrap (Opsional)</label>
                            <input type="text" name="icon" id="add_icon" class="form-control" placeholder="Contoh: bi-trophy">
                        </div>
                        <div class="col-md-6">
                            <label for="add_color" class="form-label fw-semibold">Warna Aksen (Opsional)</label>
                            <div class="input-group">
                                <input type="color" name="color" id="add_color" class="form-control form-control-color w-100" value="#0d6efd" title="Pilih warna">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="add_description" class="form-label fw-semibold">Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" id="add_description" class="form-control" rows="2" placeholder="Keterangan singkat tentang cakupan kategori ini..."></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" value="1" checked>
                        <label class="form-check-label fw-semibold" for="add_is_active">Aktifkan Kategori Langsung</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3 fw-semibold"><i class="bi bi-save me-1"></i> Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT KATEGORI --}}
<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="modalEditCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form id="formEditCategory" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="modalEditCategoryLabel">
                        <i class="bi bi-pencil-square me-1"></i> Edit Kategori
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_type" class="form-label fw-semibold">Tipe Modul / Menu <span class="text-danger">*</span></label>
                        <select name="type" id="edit_type" class="form-select" required>
                            <option value="berita">📰 Berita & Informasi</option>
                            <option value="unduhan">📁 E-Dokumen / SOP</option>
                            <option value="galeri">🖼️ Galeri Dokumentasi</option>
                            <option value="testimoni">💬 Testimoni</option>
                            <option value="faq">❓ FAQ Informasi</option>
                            <option value="lainnya">🏷️ Lainnya (Kategori Umum)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_slug" class="form-label fw-semibold">Slug URL</label>
                        <input type="text" name="slug" id="edit_slug" class="form-control font-monospace">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="edit_icon" class="form-label fw-semibold">Icon Bootstrap</label>
                            <input type="text" name="icon" id="edit_icon" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_color" class="form-label fw-semibold">Warna Aksen</label>
                            <input type="color" name="color" id="edit_color" class="form-control form-control-color w-100">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold">Deskripsi Singkat</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <label class="form-check-label fw-semibold" for="edit_is_active">Status Aktif</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark btn-sm px-3 fw-semibold"><i class="bi bi-save me-1"></i> Perbarui Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Category Modal trigger
    const editModalEl = document.getElementById('modalEditCategory');
    const editModal = editModalEl ? new bootstrap.Modal(editModalEl) : null;
    const formEdit = document.getElementById('formEditCategory');

    document.querySelectorAll('.btn-edit-category').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name || '';
            const slug = this.dataset.slug || '';
            const type = this.dataset.type || 'berita';
            const description = this.dataset.description || '';
            const color = this.dataset.color || '#0d6efd';
            const icon = this.dataset.icon || '';
            const active = this.dataset.active === '1';

            if (formEdit) {
                formEdit.action = '{{ url("admin-kategori") }}/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_slug').value = slug;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_description').value = description;
                document.getElementById('edit_color').value = color;
                document.getElementById('edit_icon').value = icon;
                document.getElementById('edit_is_active').checked = active;
            }

            if (editModal) {
                editModal.show();
            }
        });
    });

    // Delete confirmation
    document.querySelectorAll('.btn-delete-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const name = this.dataset.name || 'kategori ini';
            const count = parseInt(this.dataset.count || '0', 10);
            let confirmMsg = 'Apakah Anda yakin ingin menghapus kategori "' + name + '"?';
            if (count > 0) {
                confirmMsg += '\n\nPERHATIAN: Ada ' + count + ' konten yang menggunakan kategori ini!';
            }

            if (confirm(confirmMsg)) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endpush

