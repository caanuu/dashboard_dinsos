<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #9b9ea1;
            /* Warna background sama dengan Login */
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
            /* Warna kartu sama dengan Login */
            border: 1px solid #d8dee4;
            border-radius: 6px;
            padding: 20px;
            width: 100%;
            max-width: 450px;
            /* Lebih lebar sedikit dari login karena field banyak */
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
    {{-- LOGO SECTION (Agar senada dengan Login) --}}
    <div class="login-logo">
        <i class="fab fa-github"></i>
        <div class="fs-5 fw-bold mt-2">SIMPEL-SOS</div>
    </div>

    <h1 class="login-header">Buat Akun Warga</h1>

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 small w-100 mb-3"
            style="max-width: 450px; background: #ffebe9; border: 1px solid rgba(255,129,130,0.4); color: #cf222e; border-radius: 6px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD FORM --}}
    <div class="login-card shadow-sm">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">NIK (Nomor Induk Kependudukan)</label>
                <input type="number" name="nik" class="form-control" value="{{ old('nik') }}" required
                    placeholder="16 Digit NIK">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Nomor HP / WhatsApp</label>
                <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required
                    placeholder="08...">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-bold">Ulangi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary fw-bold">Daftar Sekarang</button>
        </form>
    </div>

    {{-- LINK LOGIN (KOTAK PUTIH TERPISAH) --}}
    <div class="p-3 border rounded-3 text-center small"
        style="width: 100%; max-width: 450px; border-color: #d0d7de !important; background-color: white;">
        Sudah punya akun? <a href="{{ route('login') }}" style="color: #0969da; text-decoration: none;">Masuk
            disini</a>.
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
