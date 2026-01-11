<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Application extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
    public function logs()
    {
        return $this->hasMany(ApplicationLog::class)->orderBy('created_at', 'desc');
    }

    // TAMBAHKAN INI
    public function distribution()
    {
        return $this->hasOne(Distribution::class);
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'verified' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
