<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPEL-SOS | Pelayanan Sosial Terpadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Hero Section Modern (Kembali ke Gradasi Gelap) */
        .hero-section {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            color: white;
            padding: 120px 0 160px 0;
            /* Padding bawah lebih besar untuk floating cards */
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.5;
        }

        /* Floating Cards for Services */
        .service-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border-top: 4px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #0d6efd;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* Stats Counter Modern (Grid Style) */
        .stat-item {
            text-align: center;
            color: white;
            margin-bottom: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        /* Search Box styling */
        .search-box-hero {
            background: white;
            padding: 8px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            width: 100%;
            max-width: 500px;
        }

        .search-input {
            border: none;
            padding-left: 20px;
            outline: none;
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3"
        style="background: rgba(15, 32, 39, 0.9); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-hands-helping text-primary me-2"></i>SIMPEL-SOS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-lg">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn btn-outline-light btn-sm rounded-pill px-4 shadow-sm">Login Petugas</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-pattern"></div>
        <div class="container position-relative z-2">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start mb-5 mb-lg-0">
                    <span
                        class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25 mb-3 px-3 py-2 rounded-pill">
                        <i class="fas fa-check-circle me-1"></i> Pelayanan Publik Digital
                    </span>
                    <h1 class="display-4 fw-bold mb-3">Layanan Sosial <br><span class="text-primary">Terintegrasi &
                            Cepat</span></h1>
                    <p class="lead mb-4 text-white-50 pe-lg-5">
                        Portal resmi Dinas Sosial untuk pengajuan rekomendasi BPJS, SKTM, dan bantuan sosial lainnya.
                        Terintegrasi langsung dengan Data Terpadu (DTKS).
                    </p>

                    <div class="d-flex flex-column align-items-center align-items-lg-start">
                        <form action="{{ route('tracking') }}" method="GET" class="search-box-hero">
                            <input type="text" name="keyword" class="form-control border-0 rounded-pill ps-4 py-2"
                                placeholder="Masukkan Nomor Tiket Anda..." required>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold m-1">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </form>
                        <small class="text-white-50 mt-2"><i class="fas fa-info-circle me-1"></i> Contoh:
                            SKTM-2401-8392</small>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div
                                class="stat-item bg-dark bg-opacity-50 p-4 rounded-4 border border-secondary border-opacity-25">
                                <span class="stat-number text-primary">{{ $stats['total_masuk'] }}</span>
                                <span class="stat-label">Total Permohonan</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div
                                class="stat-item bg-dark bg-opacity-50 p-4 rounded-4 border border-secondary border-opacity-25">
                                <span class="stat-number text-success">{{ $stats['tersalurkan'] }}</span>
                                <span class="stat-label">Bantuan Disalurkan</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div
                                class="stat-item bg-dark bg-opacity-50 p-3 rounded-4 border border-secondary border-opacity-25 d-flex flex-row align-items-center justify-content-between px-4">
                                <div class="text-start">
                                    <span class="d-block fw-bold fs-3 text-white">{{ $stats['diproses'] }}</span>
                                    <span class="small text-white-50">Sedang Diproses</span>
                                </div>
                                <i class="fas fa-sync fa-spin fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="d-flex justify-content-between align-items-end mb-4 px-2">
            <h4 class="fw-bold text-dark m-0 bg-white px-3 py-2 rounded shadow-sm">
                <i class="fas fa-th-large text-primary me-2"></i>Katalog Layanan
            </h4>

            <div>
                {{-- TOMBOL BARU: PERMOHONAN --}}
                <a href="{{ route('public.application.create') }}"
                    class="btn btn-primary shadow fw-bold rounded-pill px-4 me-2">
                    <i class="fas fa-plus-circle me-2"></i> Ajukan Permohonan
                </a>
                <a href="{{ route('lapor.index') }}" class="btn btn-danger shadow fw-bold rounded-pill px-4">
                    <i class="fas fa-bullhorn me-2"></i> Buat Pengaduan
                </a>
            </div>

        </div>

        <div class="row g-4">
            {{-- Loop Data ServiceType dari Controller --}}
            @forelse($services as $service)
                <div class="col-md-4 col-lg-3">
                    <div class="service-card p-4 d-flex flex-column h-100">
                        <div class="icon-box bg-light text-primary">
                            @if ($service->jenis_bantuan == 'tunai')
                                <i class="fas fa-money-bill-wave"></i>
                            @elseif($service->jenis_bantuan == 'sembako')
                                <i class="fas fa-box-open"></i>
                            @else
                                <i class="fas fa-file-contract"></i>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-2">{{ $service->nama_layanan }}</h5>
                        <p class="text-muted small flex-grow-1">
                            {{ Str::limit($service->deskripsi ?? 'Layanan bantuan sosial resmi pemerintah kota.', 60) }}
                        </p>
                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary bg-opacity-10 text-dark">
                                {{ $service->kode_layanan }}
                            </span>
                            <small class="text-primary fw-bold" style="font-size: 0.75rem;">Detail &rarr;</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm">
                        <i class="fas fa-info-circle me-2"></i> Belum ada layanan yang diinput oleh Admin.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <section class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">Alur Pengajuan</h6>
                <h2 class="fw-bold">Bagaimana Cara Mengajukan?</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary border"
                            style="width: 70px; height: 70px; font-size: 1.5rem; font-weight: bold;">1</div>
                        <h6 class="fw-bold">Datang ke Loket / Permohonan Online</h6>
                        <p class="text-muted small">Sediakan KTP, KK, dan Surat Pengantar RT/RW ke Dinas Sosial.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary border"
                            style="width: 70px; height: 70px; font-size: 1.5rem; font-weight: bold;">2</div>
                        <h6 class="fw-bold">Verifikasi Data</h6>
                        <p class="text-muted small">Petugas memvalidasi kelengkapan data & status DTKS Anda.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary border"
                            style="width: 70px; height: 70px; font-size: 1.5rem; font-weight: bold;">3</div>
                        <h6 class="fw-bold">Persetujuan Kadis</h6>
                        <p class="text-muted small">Kepala Dinas meninjau dan menyetujui permohonan secara digital.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3">
                        <div class="bg-success text-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 70px; height: 70px; font-size: 1.5rem; font-weight: bold;">4</div>
                        <h6 class="fw-bold">Selesai</h6>
                        <p class="text-muted small">Terima surat rekomendasi atau bantuan tersalurkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-2"><i class="fas fa-hands-helping me-2"></i>SIMPEL-SOS</h5>
                    <p class="text-white-50 small mb-0">Sistem Informasi Manajemen Pelayanan Sosial. <br> Mewujudkan
                        kesejahteraan sosial yang adil dan merata.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1 fw-bold">Pusat Layanan Sosial</p>
                    <small class="text-white-50">&copy; 2026 Dinas Sosial Kota Contoh.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
