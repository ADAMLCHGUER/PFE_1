<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'type',
        'periode_debut',
        'periode_fin',
        'chemin_fichier',
        'prestataire_id',
    ];

    protected $casts = [
        'periode_debut' => 'date',
        'periode_fin' => 'date',
    ];

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }
}