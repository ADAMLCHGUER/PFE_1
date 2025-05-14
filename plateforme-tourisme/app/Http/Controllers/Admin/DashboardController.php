<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use App\Models\Service;
use App\Models\Visite;
use App\Models\Categorie;
use App\Models\Ville;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Statistiques globales avec calculs de pourcentages et comparaisons
        $totalPrestataires = Prestataire::count();
        $prestatairesMoisDernier = Prestataire::where('created_at', '>=', Carbon::now()->subMonth())->count();
        
        $stats = [
            'prestataires_total' => $totalPrestataires,
            'prestataires_en_attente' => Prestataire::where('statut', 'en_revision')->count(),
            'prestataires_valides' => Prestataire::where('statut', 'valide')->count(),
            'prestataires_nouveaux' => $prestatairesMoisDernier,
            'prestataires_croissance' => $this->calculateGrowthPercentage(
                $totalPrestataires - $prestatairesMoisDernier, 
                $totalPrestataires
            ),
            'services_total' => Service::count(),
            'visites_total' => Visite::count(),
            'visites_mois' => Visite::whereMonth('created_at', now()->month)->count(),
            'visites_mois_dernier' => Visite::whereMonth('created_at', now()->subMonth()->month)->count(),
            'visites_croissance' => $this->calculateGrowthPercentage(
                Visite::whereMonth('created_at', now()->month)->count(),
                Visite::whereMonth('created_at', now()->subMonth()->month)->count()
            ),
            'categories_total' => Categorie::count(),
            'villes_total' => Ville::count(),
        ];
        
        // Prestataires récents avec plus de contexte
        $prestatairesRecents = Prestataire::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Services les plus visités
        $servicesPopulaires = Service::withCount('visites')
            ->orderBy('visites_count', 'desc')
            ->take(5)
            ->with(['prestataire', 'categorie', 'ville'])
            ->get();
        
        // Visites par jour (15 derniers jours)
        $visitesParJour = Visite::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [now()->subDays(15), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Répartition des prestataires par statut
        $prestatairesParStatut = [
            'valide' => $stats['prestataires_valides'],
            'en_revision' => $stats['prestataires_en_attente'],
            'non_valide' => $totalPrestataires - $stats['prestataires_valides'] - $stats['prestataires_en_attente'],
        ];
        
        // Services par catégorie
        $servicesParCategorie = Service::select('categorie_id', DB::raw('count(*) as total'))
            ->groupBy('categorie_id')
            ->with('categorie')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
            
        // Services par ville
        $servicesParVille = Service::select('ville_id', DB::raw('count(*) as total'))
            ->groupBy('ville_id')
            ->with('ville')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        
        return view('vendor.backpack.base.dashboard', compact(
            'stats',
            'prestatairesRecents',
            'servicesPopulaires',
            'visitesParJour',
            'prestatairesParStatut',
            'servicesParCategorie',
            'servicesParVille'
        ));
    }
    
    /**
     * Calculate growth percentage between new and old values
     * 
     * @param int $new
     * @param int $old
     * @return float|null
     */
    private function calculateGrowthPercentage($new, $old)
    {
        if ($old == 0) {
            return $new > 0 ? 100 : 0;
        }
        
        return round((($new - $old) / $old) * 100, 1);
    }
}