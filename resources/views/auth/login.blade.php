@extends('layouts.auth')

<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIMPEL SOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #9b9ea1;
            /* Sedikit lebih terang agar mirip GitHub modern */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .login-logo {
            font-size: 48px;
            color: #24292f;
            margin-bottom: 24px;
            text-align: center;
        }

        .login-card {
            background-color: #9ba5ae;
            border: 1px solid #d8dee4;
            border-radius: 6px;
            padding: 20px;
            width: 100%;
            max-width: 340px;
            margin-bottom: 16px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
            color: #24292f;
            font-weight: 300;
            font-size: 24px;
        }

        .form-label {
            font-weight: 400;
            font-size: 14px;
            color: #24292f;
        }

        .form-control {
            background-color: #f6f8fa;
            border: 1px solid #d0d7de;
            box-shadow: inset 0 1px 2px rgba(175, 184, 193, 0.2);
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 14px;
            line-height: 20px;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #0969da;
            box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.3);
            outline: none;
        }

        .btn-primary {
            background-color: #2da44e;
            color: #ffffff;
            border: 1px solid rgba(27, 31, 36, 0.15);
            border-radius: 6px;
            font-weight: 600;
            padding: 5px 16px;
            width: 100%;
            margin-top: 16px;
            box-shadow: 0 1px 0 rgba(27, 31, 36, 0.1);
        }

        .btn-primary:hover {
            background-color: #2c974b;
        }

        .login-footer {
            margin-top: 24px;
            font-size: 12px;
            color: #57606a;
            text-align: center;
        }

        .login-footer a {
            color: #0969da;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-logo">
        <i class="fab fa-github"></i>
        <div class="fs-5 fw-bold mt-2">SIMPEL SOS</div>
    </div>

    <h1 class="login-header">Sign in to System</h1>
=======
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
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea

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
<<<<<<< HEAD
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" autofocus required>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label">Password</label>
                    {{-- <a href="#" style="font-size: 12px; text-decoration: none; color: #0969da;">Forgot password?</a> --}}
                </div>
                <input type="password" name="password" class="form-control" required>
=======
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i>Email
                </label>
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="nama@example.com" value="{{ old('email') }}" required autofocus>
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
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

<<<<<<< HEAD
    {{-- BAGIAN YANG DIPERBARUI: Link Daftar --}}
    <div class="p-3 border rounded-3 text-center small"
        style="width: 100%; max-width: 340px; border-color: #d0d7de !important; background-color: white;">
        Belum mempunyai akun? <a href="{{ route('register') }}"
            style="color: #0969da; text-decoration: none;">Daftar</a>.
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('home') }}" class="small text-muted text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="login-footer">
        <span class="text-muted">&copy; 2026 Dinas Sosial</span>
    </div>
</body>

</html>
=======
    <div class="auth-footer">
        <p class="mb-0">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="auth-link">Daftar Sekarang</a>
        </p>
    </div>
</div>
@endsection
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
