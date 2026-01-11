<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model {
    protected $guarded = [];
    public function application() { return $this->belongsTo(Application::class); }
}
