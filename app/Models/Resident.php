<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Satu penduduk bisa punya banyak permohonan
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
