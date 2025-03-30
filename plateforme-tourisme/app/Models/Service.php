<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'prestataire_id',
        'categorie_id',
        'ville_id',
        'titre',
        'slug',
        'description',
        'prestations',
        'coordonnees',
        'adresse',
        'telephone',
        'email',
        'site_web',
        'horaires',
    ];

    protected $casts = [
        'horaires' => 'array',
    ];

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function visites()
    {
        return $this->hasMany(Visite::class);
    }

    public function imagePrincipale()
    {
        return $this->images()->where('principale', true)->first();
    }
}