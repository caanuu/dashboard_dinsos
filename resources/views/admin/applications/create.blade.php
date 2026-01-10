@extends('layouts.admin')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 fw-bold">Input Permohonan Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.application.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No KK <span class="text-danger">*</span></label>
                        <input type="text" name="no_kk" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_dtks" id="dtksCheck">
                            <label class="form-check-label fw-bold text-success" for="dtksCheck">
                                <i class="fas fa-check-circle"></i> Warga Terdaftar di DTKS (Data Kemiskinan)
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <label class="form-label">Jenis Layanan</label>
                    <select name="service_type_id" class="form-select" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload Berkas Persyaratan (PDF/Foto) <span
                            class="text-danger">*</span></label>
                    <input type="file" name="berkas" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text">Gabungkan KTP, KK, dan Pengantar dalam satu file jika memungkinkan. Maks 2MB.
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Permohonan</button>
            </form>
        </div>
    </div>
@endsection
