<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nom' => 'Hébergement',
                'icone' => 'house',
                'description' => 'Hôtels, riads, auberges et autres types d\'hébergements au Maroc.',
            ],
            [
                'nom' => 'Restauration',
                'icone' => 'cup-hot',
                'description' => 'Restaurants, cafés et services de traiteur proposant des spécialités locales et internationales.',
            ],
            [
                'nom' => 'Excursions',
                'icone' => 'compass',
                'description' => 'Circuits guidés, visites de sites historiques et excursions dans la nature.',
            ],
            [
                'nom' => 'Transport',
                'icone' => 'car-front',
                'description' => 'Services de transport, location de voitures et transferts aéroport.',
            ],
            [
                'nom' => 'Activités',
                'icone' => 'bicycle',
                'description' => 'Sports, activités culturelles et loisirs variés pour tous les âges.',
            ],
            [
                'nom' => 'Artisanat',
                'icone' => 'brush',
                'description' => 'Boutiques d\'artisanat traditionnel marocain et ateliers.',
            ],
            [
                'nom' => 'Bien-être',
                'icone' => 'heart-pulse',
                'description' => 'Hammams, spas et centres de bien-être proposant des soins traditionnels.',
            ],
            [
                'nom' => 'Guide',
                'icone' => 'person',
                'description' => 'Services de guides professionnels multilingues pour découvrir le Maroc.',
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::create([
                'nom' => $categorie['nom'],
                'slug' => Str::slug($categorie['nom']),
                'icone' => $categorie['icone'],
                'description' => $categorie['description'],
            ]);
        }
    }
}