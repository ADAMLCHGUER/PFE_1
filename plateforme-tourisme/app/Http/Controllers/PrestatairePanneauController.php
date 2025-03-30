<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrestatairePanneauController extends Controller
{
    public function index()
    {
        $prestataire = Auth::user()->prestataire;
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
    
    public function attente()
    {
        $prestataire = Auth::user()->prestataire;
        
        if ($prestataire && $prestataire->estValide()) {
            return redirect()->route('prestataire.tableau');
        }
        
        return view('prestataire.attente', compact('prestataire'));
    }
}