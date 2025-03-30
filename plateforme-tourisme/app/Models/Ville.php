<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'image',
        'description',
        'populaire',
    ];

    protected $casts = [
        'populaire' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}