<?php

namespace App\Models;

// app/Models/Application.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Application extends Model
{
    use HasUuids; // Auto generate UUID

    protected $guarded = [];

    // Relasi ke Penduduk
    public function resident() {
        return $this->belongsTo(Resident::class);
    }

    // Relasi ke Jenis Layanan
    public function serviceType() {
        return $this->belongsTo(ServiceType::class);
    }

    // Relasi ke Log (History)
    public function logs() {
        return $this->hasMany(ApplicationLog::class)->orderBy('created_at', 'desc');
    }

    // Helper untuk Warna Badge Status (Buat di View nanti)
    public function getStatusColorAttribute() {
        return match($this->status) {
            'pending' => 'warning',
            'verified' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
