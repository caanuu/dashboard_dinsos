@extends('layouts.admin')
@section('title', 'Master Data: Services')

@section('content')
    <div class="row">
        {{-- KOLOM KIRI: FORM TAMBAH LAYANAN --}}
        <div class="col-md-4">
            <div class="gh-box mb-4">
                <div class="gh-box-header">Add New Service</div>
                <div class="gh-box-body">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf

                        {{-- 1. Nama Layanan --}}
                        <div class="mb-3">
                            <label class="fw-bold small mb-1">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control"
                                placeholder="Contoh: Bantuan Lansia" required>
                        </div>

                        {{-- 2. Info Kode Otomatis (Input manual dihapus) --}}
                        <div class="mb-3 p-2 rounded border border-secondary text-muted small">
                            <i class="fas fa-info-circle me-1"></i> Kode layanan akan digenerate otomatis oleh sistem
                            (Contoh: TUNAI-001).
                        </div>

                        {{-- 3. Jenis Bantuan (Input Teks Bebas) --}}
                        <div class="mb-3">
                            <label class="fw-bold small mb-1">Jenis Bantuan</label>
                            <input type="text" name="jenis_bantuan" class="form-control"
                                placeholder="Ketik jenis: Tunai, Sembako, Pelatihan..." required>
                            <div class="form-text small text-muted">Ketik jenis bantuan secara spesifik (Mandiri).</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-sm">Add service</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DAFTAR LAYANAN --}}
        <div class="col-md-8">
            <div class="gh-box">
                <div class="gh-box-header">
                    Available Services
                    <span class="badge bg-secondary rounded-pill">{{ count($services) }}</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($services as $s)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold text-dark">{{ $s->nama_layanan }}</div>
                                <div class="small text-muted font-monospace">{{ $s->kode_layanan }} &bull;
                                    {{ ucfirst($s->jenis_bantuan) }}</div>
                            </div>
                            <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm text-danger border-0 hover-bg-light" title="Hapus Layanan">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="p-3 text-muted text-center small">Belum ada layanan yang ditambahkan.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
