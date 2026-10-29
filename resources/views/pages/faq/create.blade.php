@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah FAQ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow-sm">
            <div class="card-header py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-question-circle-fill me-2 text-primary"></i>Form Tambah FAQ
                </h5>
            </div>
            <div class="card-body pt-4">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Periksa kembali data Anda:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('faq.store') }}" method="POST">
                    @csrf

                    {{-- Pertanyaan --}}
                    <div class="mb-4">
                        <label for="question" class="form-label fw-semibold">
                            Pertanyaan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="question"
                               name="question"
                               class="form-control @error('question') is-invalid @enderror"
                               value="{{ old('question') }}"
                               placeholder="Masukkan pertanyaan"
                               required>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jawaban --}}
                    <div class="mb-4">
                        <label for="answer" class="form-label fw-semibold">
                            Jawaban <span class="text-danger">*</span>
                        </label>
                        <textarea id="answer"
                                  name="answer"
                                  rows="5"
                                  class="form-control @error('answer') is-invalid @enderror"
                                  placeholder="Masukkan jawaban"
                                  required>{{ old('answer') }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select id="category"
                                name="category"
                                class="form-select @error('category') is-invalid @enderror"
                                required>
                            <option value="" disabled {{ old('category') === null ? 'selected' : '' }}>Pilih Kategori</option>
                            <option value="akademik" {{ old('category') === 'akademik' ? 'selected' : '' }}>Akademik & Kurikulum</option>
                            <option value="pendaftaran" {{ old('category') === 'pendaftaran' ? 'selected' : '' }}>Pendaftaran & PMB</option>
                            <option value="fasilitas" {{ old('category') === 'fasilitas' ? 'selected' : '' }}>Fasilitas & Laboratorium</option>
                            <option value="karir" {{ old('category') === 'karir' ? 'selected' : '' }}>Karir & Magang Industri</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('faq.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
