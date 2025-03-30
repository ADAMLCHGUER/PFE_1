<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'icone',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}