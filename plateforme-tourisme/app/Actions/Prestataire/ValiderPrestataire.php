<?php

namespace App\Actions\Prestataire;

use App\Models\Prestataire;
use App\Notifications\ComptePrestatairNonValide;
use App\Notifications\ComptePrestatairValide;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ValiderPrestataire
{
    public function execute(Prestataire $prestataire, string $statut): bool
    {
        if (!in_array($statut, ['valide', 'non_valide'])) {
            Log::error("Tentative de validation avec un statut invalide: {$statut}");
            return false;
        }
        
        $prestataire->statut = $statut;
        
        if ($statut === 'valide') {
            $prestataire->date_validation = now();
            $prestataire->save();
            
            // Notification au prestataire que son compte est validé
            // Utiliser l'email du prestataire directement
            Notification::route('mail', $prestataire->email)
                ->notify(new ComptePrestatairValide($prestataire));
        } else {
            $prestataire->save();
            
            // Notification au prestataire que son compte est refusé
            // Utiliser l'email du prestataire directement
            Notification::route('mail', $prestataire->email)
                ->notify(new ComptePrestatairNonValide($prestataire));
        }
        
        return true;
    }
}