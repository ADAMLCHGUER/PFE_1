<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'chemin',
        'principale',
        'ordre',
    ];

    protected $casts = [
        'principale' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}