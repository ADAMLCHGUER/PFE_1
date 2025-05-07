<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nom_entreprise',
        'telephone',
        'adresse',
        'email',
        'password', // Champ password pour l'authentification
        'statut',
        'date_validation',
    ];

    protected $hidden = [
        'password', // Masquer le mot de passe dans les réponses JSON
    ];

    protected $casts = [
        'date_validation' => 'datetime',
        'password' => 'hashed', // Assurer que le mot de passe est haché
    ];

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }

    public function estValide()
    {
        return $this->statut === 'valide';
    }
}