@extends('layouts.sikasos')

@section('content')
    <!-- Page Header -->
    <div class="glass-card p-4 mb-4">
        <h2 class="text-white fw-bold mb-2">
            <i class="fas fa-user me-2"></i>Profil Saya
        </h2>
        <p class="text-white mb-0" style="opacity: 0.9;">
            Kelola informasi akun Anda
        </p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Form Profile -->
            <div class="content-card">
                <h5 class="fw-bold mb-4" style="color: #1e293b;">
                    <i class="fas fa-user-edit me-2" style="color: #667eea;"></i>Informasi Akun
                </h5>
                
                <form action="{{ route('masyarakat.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    @if($resident)
                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                            <input type="text" class="form-control form-control-lg" id="no_hp" name="no_hp" value="{{ old('no_hp', $resident->no_hp) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $resident->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan</label>
                            <input type="text" class="form-control form-control-lg" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $resident->pekerjaan) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="penghasilan" class="form-label fw-semibold">Penghasilan (Rp)</label>
                                <input type="number" class="form-control form-control-lg" id="penghasilan" name="penghasilan" value="{{ old('penghasilan', $resident->penghasilan) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jumlah_tanggungan" class="form-label fw-semibold">Jumlah Tanggungan</label>
                                <input type="number" class="form-control form-control-lg" id="jumlah_tanggungan" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $resident->jumlah_tanggungan) }}">
                            </div>
                        </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Data Identitas -->
            <div class="glass-card p-4">
                <h5 class="text-white fw-bold mb-4">
                    <i class="fas fa-id-card me-2"></i>Data Identitas
                </h5>
                
                @if($resident)
                    <div class="mb-3">
                        <div class="text-white small mb-1" style="opacity: 0.8;">NIK</div>
                        <div class="text-white fw-bold">{{ $resident->nik }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="text-white small mb-1" style="opacity: 0.8;">No. KK</div>
                        <div class="text-white fw-bold">{{ $resident->no_kk }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="text-white small mb-1" style="opacity: 0.8;">Status DTKS</div>
                        <div>
                            @if($resident->is_dtks)
                                <span class="badge-glass" style="background: rgba(16, 185, 129, 0.3); color: white;">
                                    <i class="fas fa-check-circle me-1"></i>Terdaftar
                                </span>
                            @else
                                <span class="badge-glass" style="background: rgba(100, 116, 139, 0.3); color: white;">
                                    <i class="fas fa-times-circle me-1"></i>Tidak Terdaftar
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                
                <hr style="border-color: rgba(255,255,255,0.2);">
                
                <small class="text-white" style="opacity: 0.8;">
                    <i class="fas fa-info-circle me-1"></i>
                    Data NIK dan No. KK tidak dapat diubah. Hubungi admin jika ada kesalahan.
                </small>
            </div>
        </div>
    </div>
@endsection
