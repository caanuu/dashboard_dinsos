<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',    // Baru
        'no_hp',  // Baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper cek role
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

<<<<<<< HEAD
    // Relasi ke Data Penduduk (jika user adalah warga)
    public function resident()
    {
        return $this->hasOne(Resident::class, 'nik', 'nik');
=======
    // Helper untuk cek apakah user adalah admin/petugas
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper untuk cek apakah user adalah masyarakat
    public function isMasyarakat()
    {
        return $this->role === 'masyarakat';
    }

    // Relasi ke applications (untuk masyarakat)
    public function applications()
    {
        return $this->hasMany(Application::class);
>>>>>>> f1cc7d539ac5d4c060d6b0c9d84d7f1eade675ea
    }
}
