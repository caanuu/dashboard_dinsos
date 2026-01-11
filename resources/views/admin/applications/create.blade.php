@extends('layouts.admin')

@section('title', 'Input Permohonan Baru')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="gh-box">
                <div class="gh-box-header">
                    Input Permohonan Baru (Loket Admin)
                </div>
                <div class="gh-box-body">
                    <form action="{{ route('admin.application.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- BAGIAN 1: DATA PENDUDUK --}}
                        <h6 class="pb-2 border-bottom mb-3 text-muted">Data Penduduk</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold small mb-1">NIK</label>
                                <input type="text" name="nik" class="form-control" placeholder="16-digit NIK"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold small mb-1">No KK</label>
                                <input type="text" name="no_kk" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="fw-bold small mb-1">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="fw-bold small mb-1">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>

                        {{-- BAGIAN 2: DATA KELAYAKAN --}}
                        <h6 class="pb-2 border-bottom mb-3 text-muted mt-4">Data Kelayakan</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold small mb-1">Penghasilan (Rp)</label>
                                <input type="number" name="penghasilan" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold small mb-1">Jumlah Tanggungan</label>
                                <input type="number" name="jumlah_tanggungan" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_dtks" id="dtksCheck">
                                    <label class="form-check-label small" for="dtksCheck">
                                        Warga ini terdaftar dalam DTKS (Data Terpadu Kesejahteraan Sosial)
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 3: LAYANAN & BERKAS (UPDATED) --}}
                        <h6 class="pb-2 border-bottom mb-3 text-muted mt-4">Layanan & Berkas</h6>

                        <div class="mb-4">
                            <label class="fw-bold small mb-1">Jenis Layanan</label>
                            <select name="service_type_id" class="form-select bg-light" required>
                                <option value="">Pilih Jenis Layanan...</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="alert alert-info small mb-3">
                            <i class="fas fa-info-circle me-1"></i> <strong>Instruksi Upload:</strong>
                            <ul class="mb-0 ps-3 mt-1">
                                <li>Proposal/Surat Permohonan wajib format <strong>PDF</strong>.</li>
                                <li>KTP, KK, dan Pengantar wajib format <strong>Gambar (JPG/PNG)</strong>.</li>
                            </ul>
                        </div>

                        {{-- 1. FILE PROPOSAL (PDF) --}}
                        <div class="mb-3">
                            <label class="fw-bold small mb-1">1. Dokumen Proposal / Surat Permohonan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-danger text-white"><i class="fas fa-file-pdf"></i></span>
                                <input type="file" name="file_proposal" class="form-control" accept="application/pdf"
                                    required>
                            </div>
                            <div class="form-text small text-muted">Format PDF. Maksimal 5MB.</div>
                        </div>

                        {{-- 2. FILE FOTO PERSYARATAN --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <label class="fw-bold small mb-2">2. Foto KTP (Asli)</label>
                                        <input type="file" name="foto_ktp" class="form-control form-control-sm mb-1"
                                            accept="image/*" required>
                                        <small class="text-muted" style="font-size: 11px;">Format JPG/PNG (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <label class="fw-bold small mb-2">3. Foto Kartu Keluarga</label>
                                        <input type="file" name="foto_kk" class="form-control form-control-sm mb-1"
                                            accept="image/*" required>
                                        <small class="text-muted" style="font-size: 11px;">Format JPG/PNG (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <label class="fw-bold small mb-2">4. Surat Pengantar</label>
                                        <input type="file" name="foto_pengantar"
                                            class="form-control form-control-sm mb-1" accept="image/*" required>
                                        <small class="text-muted" style="font-size: 11px;">TTD RT/RW (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <a href="{{ route('admin.application.index') }}"
                                class="btn btn-sm btn-outline-secondary px-3">Batal</a>
                            <button type="submit" class="btn btn-sm btn-primary px-3">Simpan Permohonan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
