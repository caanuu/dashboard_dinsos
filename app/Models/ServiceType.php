<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $guarded = [];

    // Casting JSON otomatis jadi Array
    protected $casts = [
        'syarat_dokumen' => 'array',
    ];
}
