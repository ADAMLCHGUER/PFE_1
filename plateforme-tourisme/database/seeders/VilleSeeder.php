<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            [
                'nom' => 'Marrakech',
                'description' => 'La ville rouge, connue pour sa médina animée, ses jardins et ses palais historiques.',
                'populaire' => true,
            ],
            [
                'nom' => 'Casablanca',
                'description' => 'La capitale économique du Maroc, une ville moderne avec la magnifique mosquée Hassan II.',
                'populaire' => true,
            ],
            [
                'nom' => 'Fès',
                'description' => 'La plus ancienne des villes impériales avec sa médina classée au patrimoine mondial.',
                'populaire' => true,
            ],
            [
                'nom' => 'Rabat',
                'description' => 'La capitale administrative du pays, alliant patrimoine historique et modernité.',
                'populaire' => false,
            ],
            [
                'nom' => 'Tanger',
                'description' => 'Ville portuaire sur le détroit de Gibraltar, porte d\'entrée vers l\'Afrique.',
                'populaire' => true,
            ],
            [
                'nom' => 'Essaouira',
                'description' => 'Charmante ville côtière connue pour ses remparts, son port de pêche et ses plages.',
                'populaire' => true,
            ],
            [
                'nom' => 'Agadir',
                'description' => 'Station balnéaire moderne avec de magnifiques plages sur la côte atlantique.',
                'populaire' => true,
            ],
            [
                'nom' => 'Chefchaouen',
                'description' => 'La ville bleue nichée dans les montagnes du Rif, connue pour ses ruelles peintes en bleu.',
                'populaire' => true,
            ],
            [
                'nom' => 'Meknès',
                'description' => 'Ville impériale historique avec d\'impressionnantes portes et des monuments majestueux.',
                'populaire' => false,
            ],
            [
                'nom' => 'Ouarzazate',
                'description' => 'Porte du désert et centre cinématographique, connue pour ses kasbahs.',
                'populaire' => false,
            ],
        ];

        foreach ($villes as $ville) {
            Ville::create([
                'nom' => $ville['nom'],
                'slug' => Str::slug($ville['nom']),
                'description' => $ville['description'],
                'image' => 'villes/' . Str::slug($ville['nom']) . '.jpg', // À remplacer par vos propres images
                'populaire' => $ville['populaire'],
            ]);
        }
    }
}