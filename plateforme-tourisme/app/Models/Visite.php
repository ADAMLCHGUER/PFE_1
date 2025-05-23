<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'ip',
        'user_agent',
        'referrer',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}