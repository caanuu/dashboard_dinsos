@extends('layouts.auth')

@section('title', 'Registrasi')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-user-plus"></i>
        </div>
        <h1 class="auth-title">Daftar Akun</h1>
        <p class="auth-subtitle">Registrasi untuk mengajukan bantuan sosial</p>
    </div>

    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-2 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label">NIK (16 Digit)</label>
                <input type="text" class="form-control" id="nik" name="nik" 
                       maxlength="16" value="{{ old('nik') }}" required>
            </div>

            <div class="mb-3">
                <label for="no_kk" class="form-label">No. KK (16 Digit)</label>
                <input type="text" class="form-control" id="no_kk" name="no_kk" 
                       maxlength="16" value="{{ old('no_kk') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" 
                       value="{{ old('no_hp') }}" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Minimal 6 karakter</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-user-plus me-2"></i>Daftar
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="auth-link">Login</a>
        </p>
    </div>
</div>
@endsection
