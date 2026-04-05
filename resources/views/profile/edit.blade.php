@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Card Container ala GitHub --}}
            <div class="gh-box">
                <div class="gh-box-header">
                    Public Profile & Security
                </div>
                <div class="gh-box-body">

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Kolom Kiri: Form Input --}}
                            <div class="col-md-8">

                                {{-- Nama --}}
                                <div class="mb-3">
                                    <label class="fw-bold small mb-1">Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="fw-bold small mb-1">Public Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $user->email) }}" required>
                                    <div class="form-text small text-muted">Email digunakan untuk login dan notifikasi
                                        sistem.</div>
                                </div>

                                <hr class="my-4 border-secondary opacity-25">

                                {{-- Ganti Password --}}
                                <h6 class="fw-bold small mb-3 text-danger">Change Password</h6>
                                <div class="alert alert-secondary py-2 small mb-3 border-0 bg-light">
                                    <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengganti
                                    password.
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold small mb-1">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="New password">
                                </div>

                                <div class="mb-4">
                                    <label class="fw-bold small mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm new password">
                                </div>

                                {{-- Tombol Action --}}
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm px-3">Update profile</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">Cancel</a>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Avatar Preview --}}
                            <div class="col-md-4 text-center border-start ps-4">
                                <label class="fw-bold small mb-2 d-block text-start">Profile picture</label>

                                {{-- Avatar Tetap Ada --}}
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&size=200"
                                    class="rounded-circle border mb-3 shadow-sm" width="180" height="180"
                                    alt="Avatar">

                                {{-- TOMBOL EDIT/UPLOAD GAMBAR DIHAPUS DI SINI SESUAI PERMINTAAN --}}
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
