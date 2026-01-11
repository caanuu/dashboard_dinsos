<!DOCTYPE html>
<html lang="id">

<head>
    <title>Ajukan Permohonan Online - SIMPEL SOS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .hero-header {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            padding: 60px 0 100px;
            color: white;
        }

        .form-container {
            margin-top: -60px;
        }

        .upload-card {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
        }

        .upload-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="hero-header text-center">
        <h2 class="fw-bold">Layanan Mandiri Masyarakat</h2>
        <p class="opacity-75">Isi formulir di bawah ini dengan data yang valid dan dapat dipertanggungjawabkan.</p>
        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill px-4 mt-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="container form-container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if (session('error'))
                    <div class="alert alert-danger shadow-sm mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-file-signature me-2"></i>Input Permohonan Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('public.application.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- SECTION 1: DATA DIRI --}}
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-user-circle me-1"></i> Data Pemohon
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">NIK <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="nik" class="form-control" placeholder="16 Digit NIK"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">No KK <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="no_kk" class="form-control"
                                        placeholder="16 Digit No KK" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control"
                                        placeholder="Sesuai KTP" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">No HP / WA Aktif</label>
                                    <input type="text" name="no_hp" class="form-control" placeholder="08..."
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Penghasilan (Rp) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="penghasilan" class="form-control" placeholder="0"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Jumlah Tanggungan <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_tanggungan" class="form-control" placeholder="0"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan"></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check p-2 bg-light border rounded">
                                        <input class="form-check-input ms-1" type="checkbox" name="is_dtks"
                                            id="dtksCheck">
                                        <label class="form-check-label fw-bold text-success ms-2" for="dtksCheck">
                                            Terdaftar di DTKS (Data Terpadu Kesejahteraan Sosial)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- SECTION 2: PILIH LAYANAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Layanan Bantuan</label>
                                <select name="service_type_id" class="form-select form-select-lg bg-light" required>
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->nama_layanan }}
                                            ({{ ucfirst($service->jenis_bantuan) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>

                            {{-- SECTION 3: UPLOAD DOKUMEN (DIPISAH) --}}
                            <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-file-upload me-1"></i> Upload
                                Dokumen & Foto</h6>
                            <div class="alert alert-info small py-2 mb-3">
                                <i class="fas fa-info-circle"></i> Pisahkan file dokumen (PDF) dan foto persyaratan
                                (JPG/PNG).
                            </div>

                            {{-- 1. Dokumen Proposal (PDF) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">1. Dokumen Proposal / Surat Permohonan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white"><i
                                            class="fas fa-file-pdf"></i></span>
                                    <input type="file" name="file_proposal" class="form-control"
                                        accept="application/pdf" required>
                                </div>
                                <div class="form-text small">Wajib format <strong>PDF</strong>. Maksimal 5MB.</div>
                            </div>

                            {{-- 2. Foto-foto Persyaratan --}}
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card upload-card h-100 p-2">
                                        <label class="form-label fw-bold small text-center mb-2">2. Foto KTP
                                            (Asli)</label>
                                        <div class="text-center mb-2 text-primary"><i
                                                class="fas fa-id-card fa-2x"></i></div>
                                        <input type="file" name="foto_ktp" class="form-control form-control-sm"
                                            accept="image/*" required>
                                        <small class="text-muted text-center mt-1 d-block"
                                            style="font-size: 10px">Format JPG/PNG</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card upload-card h-100 p-2">
                                        <label class="form-label fw-bold small text-center mb-2">3. Kartu
                                            Keluarga</label>
                                        <div class="text-center mb-2 text-success"><i class="fas fa-users fa-2x"></i>
                                        </div>
                                        <input type="file" name="foto_kk" class="form-control form-control-sm"
                                            accept="image/*" required>
                                        <small class="text-muted text-center mt-1 d-block"
                                            style="font-size: 10px">Format JPG/PNG</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card upload-card h-100 p-2">
                                        <label class="form-label fw-bold small text-center mb-2">4. Surat
                                            Pengantar</label>
                                        <div class="text-center mb-2 text-warning"><i
                                                class="fas fa-envelope-open-text fa-2x"></i></div>
                                        <input type="file" name="foto_pengantar"
                                            class="form-control form-control-sm" accept="image/*" required>
                                        <small class="text-muted text-center mt-1 d-block" style="font-size: 10px">TTD
                                            RT/RW</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i> KIRIM PERMOHONAN
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-light py-3">
                        <small class="text-muted">Pastikan seluruh data dan foto yang diunggah terlihat jelas.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
