<?php

namespace Database\Seeders;

use App\Models\Prestataire;
use Illuminate\Database\Seeder;

class PrestataireSeeder extends Seeder
{
    public function run(): void
    {
        // Créer quelques prestataires
        $prestataires = [
            [
                'nom_entreprise' => 'Riad Marrakech Luxe',
                'telephone' => '+212 661 234 567',
                'adresse' => '12 Derb Jdid, Médina, Marrakech',
                'email' => 'contact@riadmarrakechluxe.com',
                'statut' => 'valide',
            ],
            [
                'nom_entreprise' => 'Excursions Désert Sahara',
                'telephone' => '+212 662 345 678',
                'adresse' => '45 Avenue Mohammed V, Merzouga',
                'email' => 'reservations@excursions-desert.com',
                'statut' => 'valide',
            ],
            [
                'nom_entreprise' => 'Restaurant Saveurs du Maroc',
                'telephone' => '+212 663 456 789',
                'adresse' => '78 Rue des Consuls, Rabat',
                'email' => 'info@saveursdumaroc.com',
                'statut' => 'valide',
            ],
            [
                'nom_entreprise' => 'Hammam Traditions',
                'telephone' => '+212 664 567 890',
                'adresse' => '23 Rue Bab Agnaou, Marrakech',
                'email' => 'spa@hammam-traditions.com',
                'statut' => 'en_revision',
            ],
            [
                'nom_entreprise' => 'Surf & Kite Essaouira',
                'telephone' => '+212 665 678 901',
                'adresse' => '56 Boulevard Mohammed V, Essaouira',
                'email' => 'booking@surf-essaouira.com',
                'statut' => 'non_valide',
            ],
        ];

        foreach ($prestataires as $prestataireData) {
            // Créer le prestataire
            Prestataire::create([
                'nom_entreprise' => $prestataireData['nom_entreprise'],
                'telephone' => $prestataireData['telephone'],
                'adresse' => $prestataireData['adresse'],
                'email' => $prestataireData['email'],
                'statut' => $prestataireData['statut'],
                'date_validation' => $prestataireData['statut'] === 'valide' ? now()->subDays(rand(1, 30)) : null,
            ]);
        }
    }
}