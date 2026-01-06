<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dinas Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: white;
            border-bottom: none;
            padding-top: 30px;
            text-align: center;
            border-radius: 15px 15px 0 0 !important;
        }

        .logo-dinsos {
            width: 60px;
            margin-bottom: 10px;
        }

        .btn-primary {
            padding: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card card-login">
        <div class="card-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Lambang_Kementerian_Sosial_RI.png/482px-Lambang_Kementerian_Sosial_RI.png"
                class="logo-dinsos" alt="Logo">
            <h4 class="fw-bold text-dark">SIMPEL-SOS</h4>
            <p class="text-muted small">Sistem Manajemen Pelayanan Sosial</p>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted small">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg"
                        placeholder="admin@dinsos.go.id" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">MASUK SISTEM</button>
            </form>
        </div>
        <div class="card-footer text-center bg-white border-0 pb-4 rounded-bottom">
            <small class="text-muted">&copy; {{ date('Y') }} Dinas Sosial Kota Contoh</small>
        </div>
    </div>
</body>

</html>
