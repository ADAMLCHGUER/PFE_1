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
        'statut',
        'date_validation',
    ];

    protected $casts = [
        'date_validation' => 'datetime',
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