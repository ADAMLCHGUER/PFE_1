<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\Service;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StatistiquesController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le prestataire depuis la session
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour accéder aux statistiques.');
        }
        
        $service = $prestataire->service;
        
        if (!$service) {
            return redirect()->route('prestataire.service.create')
                ->with('error', 'Vous devez d\'abord créer un service pour voir les statistiques.');
        }
        
        // Statistiques générales
        $totalVisites = $service->visites()->count();
        $visitesUniques = $service->visites()->distinct('ip')->count('ip');
        
        // Visites par mois (12 derniers mois)
        $visitesParMois = Visite::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('service_id', $service->id)
            ->whereBetween('created_at', [now()->subMonths(11), now()])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Formater les données pour le graphique
        $mois = [];
        $compteurs = [];
        
        foreach ($visitesParMois as $visite) {
            $date = \Carbon\Carbon::createFromDate($visite->year, $visite->month, 1);
            $mois[] = $date->format('M Y');
            $compteurs[] = $visite->count;
        }
        
        // Sources de trafic
        $sources = Visite::selectRaw('source, COUNT(*) as count')
            ->where('service_id', $service->id)
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('prestataire.statistiques', compact(
            'prestataire',
            'service',
            'totalVisites',
            'visitesUniques',
            'mois',
            'compteurs',
            'sources'
        ));
    }
}