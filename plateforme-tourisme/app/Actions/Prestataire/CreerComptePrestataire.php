<?php

namespace App\Actions\Prestataire;

use App\Models\Prestataire;
use App\Models\User;
use App\Notifications\ComptePrestatairEnRevision;
use Illuminate\Support\Facades\Hash;

class CreerComptePrestataire
{
    public function execute(array $data): Prestataire
    {
        // Créer un utilisateur
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        // Créer le prestataire associé
        $prestataire = Prestataire::create([
            'user_id' => $user->id,
            'nom_entreprise' => $data['nom_entreprise'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'],
            'statut' => 'en_revision',
        ]);
        
        // Envoyer une notification de confirmation
        $user->notify(new ComptePrestatairEnRevision($prestataire));
        
        return $prestataire;
    }
}