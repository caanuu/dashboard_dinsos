@extends('layouts.sikasos')

@section('content')
    <!-- Page Header -->
    <div class="glass-card p-4 mb-4">
        <h2 class="text-white fw-bold mb-2">
            <i class="fas fa-plus-circle me-2"></i>Ajukan Bantuan Sosial
        </h2>
        <p class="text-white mb-0" style="opacity: 0.9;">
            Lengkapi formulir di bawah untuk mengajukan bantuan sosial
        </p>
    </div>

    <form action="{{ route('masyarakat.applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Informasi Pengajuan -->
                <div class="content-card mb-4">
                    <h5 class="fw-bold mb-4" style="color: #1e293b;">
                        <i class="fas fa-file-alt me-2" style="color: #667eea;"></i>Informasi Pengajuan
                    </h5>
                    
                    <div class="mb-3">
                        <label for="service_type_id" class="form-label fw-semibold">Jenis Layanan Bantuan <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg" id="service_type_id" name="service_type_id" required>
                            <option value="">-- Pilih Jenis Layanan --</option>
                            @foreach($serviceTypes as $service)
                                <option value="{{ $service->id }}" {{ old('service_type_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->nama_layanan }} ({{ ucfirst($service->jenis_bantuan) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($resident)
                        <input type="hidden" name="resident_id" value="{{ $resident->id }}">
                        
                        <div class="alert alert-info rounded-4">
                            <strong><i class="fas fa-info-circle me-2"></i>Data Pemohon:</strong><br>
                            <strong>Nama:</strong> {{ $resident->nama_lengkap }}<br>
                            <strong>NIK:</strong> {{ $resident->nik }}<br>
                            <strong>Alamat:</strong> {{ $resident->alamat }}
                        </div>
                    @else
                        <div class="alert alert-warning rounded-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Data resident tidak ditemukan. Silakan hubungi admin.
                        </div>
                    @endif
                </div>

                <!-- Upload Dokumen -->
                <div class="content-card">
                    <h5 class="fw-bold mb-4" style="color: #1e293b;">
                        <i class="fas fa-upload me-2" style="color: #667eea;"></i>Upload Dokumen Pendukung
                    </h5>
                    
                    <div class="mb-4">
                        <label for="file_ktp" class="form-label fw-semibold">File KTP</label>
                        <input type="file" class="form-control file-input" id="file_ktp" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'preview_ktp')">
                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                        <div id="preview_ktp" class="file-preview mt-2"></div>
                    </div>

                    <div class="mb-4">
                        <label for="file_kk" class="form-label fw-semibold">File Kartu Keluarga</label>
                        <input type="file" class="form-control file-input" id="file_kk" name="file_kk" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'preview_kk')">
                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                        <div id="preview_kk" class="file-preview mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label for="file_pendukung" class="form-label fw-semibold">File Pendukung Lainnya</label>
                        <input type="file" class="form-control file-input" id="file_pendukung" name="file_pendukung" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'preview_pendukung')">
                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                        <div id="preview_pendukung" class="file-preview mt-2"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Info Card -->
                <div class="glass-card p-4 mb-4">
                    <h5 class="text-white fw-bold mb-3">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h5>
                    <ul class="text-white small mb-0" style="opacity: 0.9;">
                        <li class="mb-2">Pastikan semua data yang diisi sudah benar</li>
                        <li class="mb-2">Upload dokumen pendukung yang diperlukan</li>
                        <li class="mb-2">Pengajuan akan diverifikasi oleh petugas</li>
                        <li class="mb-2">Anda akan mendapatkan nomor tiket setelah submit</li>
                        <li>Gunakan nomor tiket untuk tracking status</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    <button type="submit" class="btn-glass btn-solid btn-lg">
                        <i class="fas fa-paper-plane"></i>
                        <span>Submit Pengajuan</span>
                    </button>
                    <a href="{{ route('masyarakat.dashboard') }}" class="btn-glass btn-lg text-center">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </a>
                </div>
            </div>
        </div>
    </form>

    <style>
        .file-preview {
            display: none;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
        }

        .file-preview.show {
            display: block;
        }

        .file-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
        }

        .file-preview .file-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-preview .file-icon {
            font-size: 3rem;
            color: #ef4444;
        }
    </style>

    <script>
        function previewFile(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                const fileType = file.type;
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

                reader.onload = function(e) {
                    if (fileType.startsWith('image/')) {
                        preview.innerHTML = `
                            <div class="file-info">
                                <img src="${e.target.result}" alt="Preview">
                                <div>
                                    <strong>${fileName}</strong><br>
                                    <small class="text-muted">${fileSize} MB</small>
                                </div>
                            </div>
                        `;
                    } else if (fileType === 'application/pdf') {
                        preview.innerHTML = `
                            <div class="file-info">
                                <i class="fas fa-file-pdf file-icon"></i>
                                <div>
                                    <strong>${fileName}</strong><br>
                                    <small class="text-muted">${fileSize} MB - PDF Document</small>
                                </div>
                            </div>
                        `;
                    }
                    preview.classList.add('show');
                }

                reader.readAsDataURL(file);
            } else {
                preview.classList.remove('show');
                preview.innerHTML = '';
            }
        }
    </script>
@endsection
