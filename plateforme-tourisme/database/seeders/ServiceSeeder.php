<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Image;
use App\Models\Prestataire;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les prestataires validés
        $prestataires = Prestataire::where('statut', 'valide')->get();
        $categories = Categorie::all();
        $villes = Ville::all();
        
        // Descriptions de services par catégorie
        $descriptions = [
            'Hébergement' => 'Notre établissement vous offre un séjour inoubliable dans un cadre authentique et raffiné. Vous profiterez d\'un confort optimal avec des chambres élégamment décorées, un service attentionné et une situation idéale pour découvrir les richesses du Maroc.',
            'Restauration' => 'Notre restaurant vous invite à un voyage culinaire à travers les saveurs du Maroc. Nos plats, préparés avec des produits locaux frais et des épices soigneusement sélectionnées, vous feront découvrir l\'authenticité de la cuisine marocaine traditionnelle revisitée.',
            'Excursions' => 'Partez à la découverte des trésors cachés du Maroc avec nos excursions guidées. Nos circuits vous emmènent hors des sentiers battus pour vous faire vivre des expériences authentiques, riches en découvertes culturelles et paysages à couper le souffle.',
            'Transport' => 'Notre service de transport vous garantit des déplacements confortables et sécurisés à travers le Maroc. Avec des véhicules modernes et des chauffeurs expérimentés parlant plusieurs langues, vos trajets seront une partie agréable de votre voyage.',
            'Activités' => 'Vivez des expériences uniques avec nos activités adaptées à tous les âges et tous les goûts. De l\'aventure en plein air aux ateliers culturels, nous vous proposons des moments mémorables qui enrichiront votre séjour au Maroc.',
            'Artisanat' => 'Notre boutique vous propose une sélection des plus beaux objets d\'artisanat marocain. Chaque pièce, créée par des artisans locaux talentueux selon des techniques ancestrales, raconte une histoire et représente un art de vivre unique.',
            'Bien-être' => 'Accordez-vous une pause bien-être dans notre établissement où traditions ancestrales et techniques modernes se rencontrent. Nos soins, inspirés des rituels marocains, vous offrent une expérience relaxante et revitalisante dans un cadre somptueux.',
            'Guide' => 'Nos services de guide vous permettent de découvrir le Maroc à travers les yeux d\'un local. Passionnés et expérimentés, nos guides multilingues partagent avec vous leur connaissance approfondie de l\'histoire, de la culture et des traditions marocaines.',
        ];

        foreach ($prestataires as $prestataire) {
            // Sélectionner aléatoirement une catégorie et une ville
            $categorie = $categories->random();
            $ville = $villes->random();
            
            // Créer un service pour chaque prestataire
            $service = Service::create([
                'prestataire_id' => $prestataire->id,
                'categorie_id' => $categorie->id,
                'ville_id' => $ville->id,
                'titre' => $prestataire->nom_entreprise,
                'slug' => Str::slug($prestataire->nom_entreprise) . '-' . uniqid(),
                'description' => $descriptions[$categorie->nom] ?? 'Description du service...',
                'prestations' => "Nos prestations incluent :\n- Service personnalisé\n- Équipement de qualité\n- Personnel multilingue\n- Réservation en ligne\n- Annulation gratuite jusqu'à 48h avant",
                'coordonnees' => rand(31, 35) . '.' . rand(100000, 999999) . ', -' . rand(5, 9) . '.' . rand(100000, 999999),
                'adresse' => $prestataire->adresse,
                'telephone' => $prestataire->telephone,
                'email' => $prestataire->email,
                'site_web' => 'https://www.' . Str::slug($prestataire->nom_entreprise) . '.com',
                'horaires' => [
                    ['jour' => 'lundi', 'ouverture' => '09:00', 'fermeture' => '18:00'],
                    ['jour' => 'mardi', 'ouverture' => '09:00', 'fermeture' => '18:00'],
                    ['jour' => 'mercredi', 'ouverture' => '09:00', 'fermeture' => '18:00'],
                    ['jour' => 'jeudi', 'ouverture' => '09:00', 'fermeture' => '18:00'],
                    ['jour' => 'vendredi', 'ouverture' => '09:00', 'fermeture' => '18:00'],
                    ['jour' => 'samedi', 'ouverture' => '10:00', 'fermeture' => '17:00'],
                    ['jour' => 'dimanche', 'ouverture' => '', 'fermeture' => ''],
                ],
            ]);
            
            // Ajouter des images factices pour chaque service
            for ($i = 1; $i <= 3; $i++) {
                $principale = ($i === 1); // La première image est principale
                Image::create([
                    'service_id' => $service->id,
                    'chemin' => 'services/service_' . $service->id . '_' . $i . '.jpg', // À remplacer par vos propres images
                    'principale' => $principale,
                    'ordre' => $i,
                ]);
            }
            
            // Créer des visites fictives pour simuler des statistiques
            $this->createFakeVisits($service);
        }
    }
    
    /**
     * Crée des visites fictives pour un service
     */
    private function createFakeVisits($service)
    {
        // Date de début pour les visites (30 jours en arrière)
        $startDate = now()->subDays(30);
        
        // Nombre total de visites à créer (entre 50 et 200)
        $totalVisits = rand(50, 200);
        
        // Sources de référence possibles
        $referrers = [
            'https://www.google.com',
            'https://www.facebook.com',
            'https://www.instagram.com',
            'https://www.tripadvisor.com',
            'https://www.booking.com',
            null, // Direct
        ];
        
        // User agents possibles
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (iPad; CPU OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
        ];
        
        // Créer des visites réparties sur les 30 derniers jours
        for ($i = 0; $i < $totalVisits; $i++) {
            $daysAgo = rand(0, 29); // Entre aujourd'hui et il y a 29 jours
            $visitDate = clone $startDate;
            $visitDate->addDays(30 - $daysAgo)->addHours(rand(8, 22))->addMinutes(rand(0, 59));
            
            $service->visites()->create([
                'ip' => rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255),
                'user_agent' => $userAgents[array_rand($userAgents)],
                'referrer' => $referrers[array_rand($referrers)],
                'created_at' => $visitDate,
                'updated_at' => $visitDate,
            ]);
        }
    }
}