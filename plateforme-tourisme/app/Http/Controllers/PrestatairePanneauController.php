<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrestatairePanneauController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le prestataire depuis la requête (ajouté par le middleware)
        $prestataire = $request->attributes->get('prestataire');
        $service = $prestataire->service;
        
        // Si le prestataire n'a pas encore de service, rediriger vers la création
        if (!$service) {
            return redirect()->route('prestataire.service.create');
        }
        
        // Statistiques de base
        $totalVisites = $service->visites()->count();
        $visitesRecentes = $service->visites()
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->count();
        
        // Visites par jour (7 derniers jours)
        $visitesParJour = Visite::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('service_id', $service->id)
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('prestataire.tableau', compact('prestataire', 'service', 'totalVisites', 'visitesRecentes', 'visitesParJour'));
    }
    
    public function attente(Request $request)
{
    if (Session::has('prestataire_id')) {
        $prestataire = \App\Models\Prestataire::find(Session::get('prestataire_id'));
        
        if ($prestataire) {
            // Si le prestataire est valide, le rediriger vers le tableau
            if ($prestataire->estValide()) {
                return redirect()->route('prestataire.tableau');
            }
            
            // Sinon, afficher la page d'attente
            return view('prestataire.attente', compact('prestataire'));
        }
    }
    
    // Si pas de prestataire en session, rediriger vers la connexion
    return redirect()->route('prestataire.connexion');
}
}