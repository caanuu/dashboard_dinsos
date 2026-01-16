@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-hands-helping"></i>
        </div>
        <h1 class="auth-title">SIKASOS</h1>
        <p class="auth-subtitle">Sistem Informasi Kesejahteraan Sosial<br>Kota Tebing Tinggi</p>
    </div>

    <div class="auth-body">
        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i>Email
                </label>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="nama@example.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i>Password
                </label>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="text-center">
            <a href="{{ route('password.reset') }}" class="auth-link">
                <i class="fas fa-key me-1"></i>Lupa Password?
            </a>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection
