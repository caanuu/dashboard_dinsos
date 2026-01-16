<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKASOS - Sistem Informasi Kesejahteraan Sosial Kota Tebing Tinggi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            background: #f8f9fa;
        }

        /* Navbar Modern */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Hero Section - Modern Gradient */
        .hero-section {
            min-height: 90vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 80px 0 60px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        /* Search Box Modern */
        .search-container {
            background: white;
            border-radius: 50px;
            padding: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            max-width: 600px;
        }

        .search-container input {
            border: none;
            outline: none;
            padding: 12px 24px;
            flex: 1;
            font-size: 1rem;
        }

        .search-container button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .search-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        /* Stats Cards */
        .stats-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }

        .stats-card:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
        }

        .stats-label {
            color: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Service Cards - Glassmorphism */
        .service-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.5);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .service-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .service-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* CTA Buttons */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid white;
            padding: 14px 32px;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background: white;
            color: #667eea;
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 4rem;
        }

        /* How It Works */
        .step-card {
            text-align: center;
            padding: 2rem;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .step-desc {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Footer */
        .footer {
            background: #1e293b;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hands-helping me-2"></i>SIKASOS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#cara">Cara Kerja</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="btn btn-gradient btn-sm">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-gradient btn-sm">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">
                        Layanan Sosial<br>
                        <span style="color: #fbbf24;">Mudah & Cepat</span>
                    </h1>
                    <p class="hero-subtitle">
                        Platform digital untuk mengajukan bantuan sosial, BPJS PBI, SKTM, dan layanan kesejahteraan sosial lainnya di Kota Tebing Tinggi.
                    </p>

                    <!-- Search Box -->
                    <form action="{{ route('tracking') }}" method="GET" class="mb-4">
                        <div class="search-container">
                            <input type="text" name="keyword" placeholder="Masukkan nomor tiket untuk tracking..." required>
                            <button type="submit">
                                <i class="fas fa-search me-2"></i>Lacak
                            </button>
                        </div>
                    </form>

                    <!-- CTA Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        @auth
                            @if(Auth::user()->isMasyarakat())
                                <a href="{{ route('masyarakat.applications.create') }}" class="btn btn-outline-custom">
                                    <i class="fas fa-plus-circle me-2"></i>Ajukan Bantuan
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-outline-custom">
                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ $stats['total_masuk'] }}</div>
                                <div class="stats-label">Total Pengajuan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ $stats['tersalurkan'] }}</div>
                                <div class="stats-label">Tersalurkan</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stats-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-number">{{ $stats['diproses'] }}</div>
                                        <div class="stats-label">Sedang Diproses</div>
                                    </div>
                                    <i class="fas fa-sync fa-spin" style="font-size: 3rem; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="features-section" id="layanan">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-subtitle">Berbagai layanan kesejahteraan sosial yang dapat Anda akses</p>

            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-md-6 col-lg-3">
                        <div class="service-card">
                            <div class="service-icon">
                                @if($service->jenis_bantuan == 'tunai')
                                    <i class="fas fa-money-bill-wave"></i>
                                @elseif($service->jenis_bantuan == 'sembako')
                                    <i class="fas fa-box-open"></i>
                                @elseif($service->jenis_bantuan == 'barang')
                                    <i class="fas fa-gift"></i>
                                @else
                                    <i class="fas fa-file-contract"></i>
                                @endif
                            </div>
                            <h3 class="service-title">{{ $service->nama_layanan }}</h3>
                            <p class="service-desc">{{ Str::limit($service->deskripsi ?? 'Layanan bantuan sosial untuk masyarakat', 80) }}</p>
                            <div class="mt-3">
                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 16px; border-radius: 20px;">
                                    {{ ucfirst($service->jenis_bantuan) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>Belum ada layanan yang tersedia
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);" id="cara">
        <div class="container">
            <h2 class="section-title">Cara Mengajukan</h2>
            <p class="section-subtitle">Proses pengajuan bantuan yang mudah dan transparan</p>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="step-title">Daftar Akun</h4>
                        <p class="step-desc">Buat akun dengan NIK dan data diri Anda</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="step-title">Ajukan Bantuan</h4>
                        <p class="step-desc">Pilih jenis bantuan dan upload dokumen</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="step-title">Verifikasi</h4>
                        <p class="step-desc">Petugas akan memverifikasi pengajuan Anda</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4 class="step-title">Selesai</h4>
                        <p class="step-desc">Bantuan siap disalurkan kepada Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="footer-title">
                        <i class="fas fa-hands-helping me-2"></i>SIKASOS
                    </h3>
                    <p class="text-white-50">
                        Sistem Informasi Kesejahteraan Sosial<br>
                        Dinas Sosial Kota Tebing Tinggi
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="mb-3">Hubungi Kami</h5>
                    <p class="text-white-50 mb-1">
                        <i class="fas fa-map-marker-alt me-2"></i>Jl. Contoh No. 123, Tebing Tinggi
                    </p>
                    <p class="text-white-50 mb-1">
                        <i class="fas fa-phone me-2"></i>(0621) 123456
                    </p>
                    <p class="text-white-50">
                        <i class="fas fa-envelope me-2"></i>dinsos@tebingtinggikota.go.id
                    </p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-white-50">
                <small>&copy; 2026 SIKASOS - Dinas Sosial Kota Tebing Tinggi. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
