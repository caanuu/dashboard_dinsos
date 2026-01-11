<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <title>Layanan Pengaduan Masyarakat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gh-bg: #0d1117;
            --gh-card-bg: #161b22;
            --gh-border: #30363d;
            --gh-text-main: #c9d1d9;
            --gh-text-muted: #8b949e;
            --gh-btn-green: #238636;
            --gh-btn-green-hover: #2ea043;
            --gh-input-bg: #0d1117;
            --gh-link: #58a6ff;
        }

        body {
            background-color: var(--gh-bg);
            color: var(--gh-text-main);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
        }

        /* Navbar Simple ala GitHub */
        .gh-navbar {
            background-color: #161b22;
            padding: 16px;
            border-bottom: 1px solid var(--gh-border);
        }

        /* Card Style ala GitHub Repo/Issue */
        .gh-card {
            background-color: var(--gh-card-bg);
            border: 1px solid var(--gh-border);
            border-radius: 6px;
        }

        .gh-card-header {
            background-color: var(--gh-card-bg);
            /* Seamless header */
            border-bottom: 1px solid var(--gh-border);
            padding: 16px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        /* Form Inputs */
        .form-control {
            background-color: var(--gh-input-bg);
            border: 1px solid var(--gh-border);
            color: var(--gh-text-main);
            border-radius: 6px;
            padding: 8px 12px;
        }

        .form-control:focus {
            background-color: var(--gh-input-bg);
            border-color: var(--gh-link);
            box-shadow: 0 0 0 3px rgba(88, 166, 255, 0.15);
            color: var(--gh-text-main);
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        /* Buttons */
        .btn-gh-primary {
            background-color: var(--gh-btn-green);
            color: white;
            border: 1px solid rgba(240, 246, 252, 0.1);
            font-weight: 600;
            border-radius: 6px;
            padding: 6px 16px;
        }

        .btn-gh-primary:hover {
            background-color: var(--gh-btn-green-hover);
            border-color: rgba(240, 246, 252, 0.1);
            color: white;
        }

        .btn-gh-secondary {
            background-color: #21262d;
            color: var(--gh-text-main);
            border: 1px solid rgba(240, 246, 252, 0.1);
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 16px;
        }

        .btn-gh-secondary:hover {
            background-color: #30363d;
            border-color: #8b949e;
            color: #c9d1d9;
        }

        /* Typography & Utilities */
        .text-gh-muted {
            color: var(--gh-text-muted) !important;
        }

        .text-gh-link {
            color: var(--gh-link);
            text-decoration: none;
        }

        .text-gh-link:hover {
            text-decoration: underline;
        }

        /* Alert styling */
        .alert-success-gh {
            background-color: rgba(35, 134, 54, 0.15);
            border: 1px solid rgba(35, 134, 54, 0.4);
            color: #3fb950;
        }
    </style>
</head>

<body>
    <div class="gh-navbar d-flex align-items-center justify-content-center mb-5">
        <i class="fab fa-noted fa-2x text-white me-2"></i>
        <span class="fw-bold fs-5">Layanan Pengaduan</span>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="mb-4 text-center">
                    <h2 class="fw-light mb-2">Buat Laporan Baru</h2>
                    <p class="text-gh-muted small">
                        Silakan isi formulir di bawah ini untuk menyampaikan masalah pelayanan. <br>
                        Laporan akan tercatat sebagai <span class="badge border border-secondary text-gh-muted">Issue
                            Open</span> di sistem kami.
                    </p>
                </div>

                <div class="gh-card shadow-sm">
                    <div class="gh-card-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold small">Formulir Pengaduan</span>
                        <small class="text-gh-muted"><i class="fas fa-lock me-1"></i>Enkripsi SSL</small>
                    </div>

                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success-gh rounded-3 text-center mb-4 p-4">
                                <div class="mb-2"><i class="far fa-check-circle fa-3x"></i></div>
                                <h5 class="fw-bold">Laporan Berhasil Dibuat!</h5>
                                <p class="mb-3 small">{{ session('success') }}</p>
                                <a href="{{ route('home') }}" class="btn btn-gh-secondary btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        @else
                            <form action="{{ route('lapor.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Nama Pelapor <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pelapor" class="form-control" required
                                        placeholder="Masukkan nama lengkap...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        NIK
                                        <span class="text-gh-muted fw-normal ms-1">(Opsional)</span>
                                    </label>
                                    <input type="text" name="nik_pelapor" class="form-control"
                                        placeholder="Nomor Induk Kependudukan">
                                    <div class="form-text text-gh-muted" style="font-size: 12px;">
                                        Kami menjaga privasi data kependudukan Anda.
                                    </div>
                                </div>

                                <hr class="border-secondary opacity-25 my-4">

                                <div class="mb-4">
                                    <label class="form-label d-flex justify-content-between">
                                        Isi Laporan
                                        <a href="#" class="text-gh-link small fw-normal"
                                            style="font-size: 12px;">Panduan menulis laporan</a>
                                    </label>
                                    <div class="gh-card p-0 mb-2">
                                        <div
                                            class="bg-dark border-bottom border-secondary p-2 rounded-top d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-dark text-gh-muted py-0"
                                                disabled>Write</button>
                                            <button type="button" class="btn btn-sm btn-dark text-gh-muted py-0"
                                                disabled>Preview</button>
                                        </div>
                                        <textarea name="isi_aduan" class="form-control border-0 rounded-0 rounded-bottom" rows="6" required
                                            placeholder="Jelaskan detail masalah, lokasi, dan saran perbaikan..." style="resize: vertical; min-height: 150px;"></textarea>
                                    </div>
                                    <div class="form-text text-gh-muted" style="font-size: 12px;">
                                        <i class="fab fa-markdown me-1"></i>Styling dengan Markdown didukung.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 align-items-center mt-4">
                                    <a href="{{ route('home') }}"
                                        class="text-gh-muted text-decoration-none small me-2">Batalkan</a>
                                    <button type="submit" class="btn btn-gh-primary">
                                        Submit new issue
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-4 d-flex justify-content-center gap-3">
                    <span class="text-gh-muted small">&copy; 2026 Dinas Sosial</span>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
