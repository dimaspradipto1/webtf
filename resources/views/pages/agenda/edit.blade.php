@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Agenda</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Pengumuman & Agenda</a></li>
            <li class="breadcrumb-item active">Edit Agenda</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-9 col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="card-title mb-0 fw-bold text-dark p-0">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Formulir Edit Agenda
                </h5>
            </div>
            <div class="card-body pt-4">
                <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Agenda --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Nama / Judul Agenda <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $agenda->title) }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Teks Jadwal / Rentang Waktu --}}
                        <div class="col-md-7">
                            <label for="date_text" class="form-label fw-semibold">Waktu / Jadwal Teks <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('date_text') is-invalid @enderror"
                                   id="date_text"
                                   name="date_text"
                                   value="{{ old('date_text', $agenda->date_text) }}"
                                   required>
                            <small class="text-muted">Teks ini yang akan langsung tampil di atas badge agenda beranda.</small>
                            @error('date_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Urutan --}}
                        <div class="col-md-5">
                            <label for="urutan" class="form-label fw-semibold">Urutan Tampilan</label>
                            <input type="number"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   id="urutan"
                                   name="urutan"
                                   value="{{ old('urutan', $agenda->urutan) }}"
                                   min="1">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Tanggal Mulai --}}
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-semibold">Tanggal Mulai (Opsional)</label>
                            <input type="date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ old('start_date', $agenda->start_date ? $agenda->start_date->format('Y-m-d') : '') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-semibold">Tanggal Selesai (Opsional)</label>
                            <input type="date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ old('end_date', $agenda->end_date ? $agenda->end_date->format('Y-m-d') : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Lokasi Kegiatan --}}
                        <div class="col-md-6">
                            <label for="location" class="form-label fw-semibold">Lokasi / Tempat (Opsional)</label>
                            <input type="text"
                                   class="form-control @error('location') is-invalid @enderror"
                                   id="location"
                                   name="location"
                                   value="{{ old('location', $agenda->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Link URL --}}
                        <div class="col-md-6">
                            <label for="link_url" class="form-label fw-semibold">Tautan Info / Pendaftaran (Opsional)</label>
                            <input type="url"
                                   class="form-control @error('link_url') is-invalid @enderror"
                                   id="link_url"
                                   name="link_url"
                                   value="{{ old('link_url', $agenda->link_url) }}">
                            @error('link_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi Agenda --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Keterangan / Catatan Agenda (Opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="3">{{ old('description', $agenda->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Switch Aktif --}}
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   role="switch"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $agenda->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Tampilkan Agenda di Beranda Website
                            </label>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Perbarui Agenda
                        </button>
                        <a href="{{ route('agenda.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

