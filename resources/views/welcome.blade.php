<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Sosial Kota Contoh - Pelayanan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i
                    class="fas fa-hands-helping me-2"></i>SIMPEL-SOS</a>
            <div class="d-flex">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm px-4">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-4">Login Petugas</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Pelayanan Kesejahteraan Sosial<br>Cepat, Tepat, & Transparan</h1>
            <p class="lead mb-4">Layanan rekomendasi BPJS, SKTM, dan bantuan sosial dalam satu pintu digital.</p>
        </div>
    </header>

    <div class="container py-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="fas fa-file-signature feature-icon"></i>
                    <h5 class="fw-bold">Pengajuan Mudah</h5>
                    <p class="text-muted">Proses administrasi surat rekomendasi dan bantuan dilakukan secara digital.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="fas fa-database feature-icon"></i>
                    <h5 class="fw-bold">Terintegrasi DTKS</h5>
                    <p class="text-muted">Validasi data otomatis dengan Data Terpadu Kesejahteraan Sosial.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <i class="fas fa-print feature-icon"></i>
                    <h5 class="fw-bold">Cetak Mandiri</h5>
                    <p class="text-muted">Surat rekomendasi yang disetujui dapat langsung dicetak dengan QR Code.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 text-center">
        <div class="container">
            <small>&copy; 2024 Dinas Sosial Kota Contoh. All rights reserved.</small>
        </div>
    </footer>
</body>

</html>
