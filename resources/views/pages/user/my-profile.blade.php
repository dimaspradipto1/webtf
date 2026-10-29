@extends('layouts.dashboard.template')

@section('title', 'My Profile — Profil Pengguna')

@section('content')
<div class="pagetitle">
    <h1>Profil Saya (My Profile)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pengguna</li>
            <li class="breadcrumb-item active">My Profile</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">

        {{-- Left Column: Profile Card --}}
        <div class="col-xl-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center text-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm"
                         style="width: 100px; height: 100px; background: #000000; color: #ffffff; font-size: 40px; font-weight: 700;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                    <span class="badge px-3 py-2 rounded-pill mb-3" style="background: rgba(0, 0, 0, 0.12); color: #000000; font-weight: 700; font-size: 12.5px;">
                        <i class="bi bi-shield-check me-1"></i> {{ strtoupper($user->roles) }}
                    </span>
                    <div class="text-muted small mb-2"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</div>
                    <div class="text-muted small"><i class="bi bi-calendar3 me-1"></i> Bergabung: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Right Column: Profile Tabs --}}
        <div class="col-xl-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body pt-3">
                    
                    {{-- Nav Tabs --}}
                    <ul class="nav nav-tabs nav-tabs-bordered mb-4" id="profileTabs">
                        <li class="nav-item">
                            <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                <i class="bi bi-person-lines-fill me-1"></i> Ringkasan Akun
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                                <i class="bi bi-key-fill me-1"></i> Ganti Password
                            </button>
                        </li>
                    </ul>

                    {{-- Flash Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="tab-content pt-2">

                        {{-- TAB 1: OVERVIEW --}}
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title fw-bold text-dark mb-3">Detail Profil</h5>

                            <div class="row mb-3 pb-2 border-bottom">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8 fw-bold text-dark">{{ $user->name }}</div>
                            </div>

                            <div class="row mb-3 pb-2 border-bottom">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Email</div>
                                <div class="col-lg-9 col-md-8 text-dark">{{ $user->email }}</div>
                            </div>

                            <div class="row mb-3 pb-2 border-bottom">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Hak Akses / Role</div>
                                <div class="col-lg-9 col-md-8">
                                    <span class="badge bg-primary text-uppercase">{{ $user->roles }}</span>
                                </div>
                            </div>

                            <div class="row mb-3 pb-2">
                                <div class="col-lg-3 col-md-4 label text-muted fw-semibold">Waktu Dibuat</div>
                                <div class="col-lg-9 col-md-8 text-dark">{{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }} WIB</div>
                            </div>
                        </div>

                        {{-- TAB 2: EDIT PROFILE --}}
                        <div class="tab-pane fade profile-edit pt-2" id="profile-edit">
                            <form action="{{ route('user.update-my-profile') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn text-white px-4 py-2 fw-semibold" style="background: #000000;">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- TAB 3: GANTI PASSWORD --}}
                        <div class="tab-pane fade pt-2" id="profile-change-password">
                            <form action="{{ route('user.update-my-password') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                {{-- Password Baru --}}
                                <div class="mb-3">
                                    <label for="new_password" class="form-label fw-semibold text-dark">
                                        Password Baru <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="new_password" placeholder="Minimal 6 karakter" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', 'eyeNew')">
                                            <i class="bi bi-eye" id="eyeNew"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Konfirmasi Password Baru --}}
                                <div class="mb-4">
                                    <label for="renew_password" class="form-label fw-semibold text-dark">
                                        Konfirmasi Password Baru <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input name="password_confirmation" type="password" class="form-control" id="renew_password" placeholder="Ulangi password baru" required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('renew_password', 'eyeRenew')">
                                            <i class="bi bi-eye" id="eyeRenew"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn text-white px-4 py-2 fw-semibold" style="background: #000000;">
                                        <i class="bi bi-key me-1"></i> Perbarui Password
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div><!-- End Tab Content -->

                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
function togglePasswordVisibility(inputId, eyeIconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(eyeIconId);
    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endpush
@endsection
