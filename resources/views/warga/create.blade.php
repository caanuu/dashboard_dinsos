@extends('layouts.admin')
@section('title', 'Buat Permohonan Baru')

@section('content')
    {{-- CSS Khusus untuk halaman ini --}}
    <style>
        .upload-card {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
            cursor: pointer;
            background-color: #fff;
        }

        .upload-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .form-label {
            font-size: 0.9rem;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Menampilkan Error Validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.application.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card shadow border-0">
                    {{-- Header Biru seperti referensi --}}
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-file-signature me-2"></i>Input Permohonan Baru</h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- SECTION 1: DATA DIRI --}}
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                            <i class="fas fa-user-circle me-1"></i> Data Pemohon
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">NIK (Sesuai Akun)</label>
                                {{-- NIK Readonly sesuai logika admin (karena user sudah login) --}}
                                <input type="text" class="form-control bg-light" value="{{ $user->nik }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">No. Kartu Keluarga <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="no_kk" class="form-control"
                                    value="{{ $resident->no_kk ?? '' }}" placeholder="16 Digit No KK" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control"
                                    value="{{ $resident->nama_lengkap ?? $user->name }}" placeholder="Sesuai KTP" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="pekerjaan" class="form-control"
                                    value="{{ $resident->pekerjaan ?? '' }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Penghasilan Bulanan (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="penghasilan" class="form-control"
                                    value="{{ $resident->penghasilan ?? '' }}" placeholder="Contoh: 2000000" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Jumlah Tanggungan <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="jumlah_tanggungan" class="form-control"
                                    value="{{ $resident->jumlah_tanggungan ?? '' }}" placeholder="0" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-muted">Alamat Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan">{{ $resident->alamat ?? '' }}</textarea>
                            </div>

                            {{-- Checkbox DTKS dengan Style Box --}}
                            <div class="col-12">
                                <div class="form-check p-2 bg-light border rounded">
                                    <input class="form-check-input ms-1" type="checkbox" name="is_dtks" id="dtksCheck"
                                        {{ isset($resident) && $resident->is_dtks ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-success ms-2" for="dtksCheck">
                                        Saya terdaftar di DTKS (Data Terpadu Kesejahteraan Sosial)
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: PILIH LAYANAN --}}
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2 mt-4">
                            <i class="fas fa-hands-helping me-1"></i> Jenis Layanan
                        </h6>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Layanan Bantuan</label>
                            <select name="service_type_id" class="form-select form-select-lg bg-light" required>
                                <option value="">-- Pilih Jenis Layanan --</option>
                                @foreach ($services as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_layanan }}
                                        {{ isset($s->jenis_bantuan) ? '(' . ucfirst($s->jenis_bantuan) . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SECTION 3: UPLOAD DOKUMEN --}}
                        <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2 mt-4">
                            <i class="fas fa-file-upload me-1"></i> Upload Dokumen & Foto
                        </h6>

                        <div class="alert alert-info small py-2 mb-3">
                            <i class="fas fa-info-circle me-1"></i> Pisahkan file dokumen (PDF) dan foto persyaratan
                            (JPG/PNG).
                        </div>

                        {{-- 1. Dokumen Proposal (PDF) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small">1. Dokumen Proposal / Surat Permohonan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white"><i class="fas fa-file-pdf"></i></span>
                                <input type="file" name="file_proposal" class="form-control" accept="application/pdf"
                                    required>
                            </div>
                            <div class="form-text small">Wajib format <strong>PDF</strong>.</div>
                        </div>

                        {{-- 2. Grid Foto Persyaratan --}}
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card upload-card h-100 p-3 text-center">
                                    <label class="form-label fw-bold small mb-2">2. Foto KTP (Asli)</label>
                                    <div class="mb-2 text-primary"><i class="fas fa-id-card fa-2x"></i></div>
                                    <input type="file" name="foto_ktp" class="form-control form-control-sm"
                                        accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card upload-card h-100 p-3 text-center">
                                    <label class="form-label fw-bold small mb-2">3. Foto Kartu Keluarga</label>
                                    <div class="mb-2 text-success"><i class="fas fa-users fa-2x"></i></div>
                                    <input type="file" name="foto_kk" class="form-control form-control-sm"
                                        accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card upload-card h-100 p-3 text-center">
                                    <label class="form-label fw-bold small mb-2">4. Foto Surat Pengantar</label>
                                    <div class="mb-2 text-warning"><i class="fas fa-envelope-open-text fa-2x"></i></div>
                                    <input type="file" name="foto_pengantar" class="form-control form-control-sm"
                                        accept="image/*" required>
                                    <small class="text-muted d-block mt-1" style="font-size: 10px">TTD RT/RW</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> KIRIM PERMOHONAN
                            </button>
                        </div>

                    </div>
                    <div class="card-footer text-center bg-light py-3">
                        <small class="text-muted">Pastikan seluruh data dan foto yang diunggah terlihat jelas.</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
