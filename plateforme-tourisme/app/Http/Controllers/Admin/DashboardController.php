<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use App\Models\Service;
use App\Models\Visite;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Statistiques globales
        $stats = [
            'prestataires_total' => Prestataire::count(),
            'prestataires_en_attente' => Prestataire::where('statut', 'en_revision')->count(),
            'prestataires_valides' => Prestataire::where('statut', 'valide')->count(),
            'services_total' => Service::count(),
            'visites_total' => Visite::count(),
            'visites_mois' => Visite::whereMonth('created_at', now()->month)->count(),
        ];
        
        // Prestataires récents
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
        
        return view('vendor.backpack.base.dashboard', compact(
            'stats',
            'prestatairesRecents',
            'servicesPopulaires',
            'visitesParJour'
        ));
    }
}