@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-key"></i>
        </div>
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Masukkan email dan NIK untuk reset password</p>
    </div>

    <div class="auth-body">
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.reset') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label">NIK (16 Digit)</label>
                <input type="text" class="form-control" id="nik" name="nik" 
                       maxlength="16" value="{{ old('nik') }}" required>
                <small class="text-muted">NIK digunakan untuk verifikasi identitas</small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Minimal 6 karakter</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-check me-2"></i>Reset Password
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
            </a>
        </p>
    </div>
</div>
@endsection
