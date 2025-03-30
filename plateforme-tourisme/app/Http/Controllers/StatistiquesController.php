<?php

namespace App\Http\Controllers;

use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    public function index()
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        if (!$service) {
            return redirect()->route('prestataire.service.create')
                ->with('info', 'Vous devez d\'abord créer votre service.');
        }
        
        // Statistiques générales
        $totalVisites = $service->visites()->count();
        
        // Visites par jour (30 derniers jours)
        $visitesParJour = Visite::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('service_id', $service->id)
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Visites par référent
        $visitesParReferent = Visite::select('referrer', DB::raw('COUNT(*) as count'))
            ->where('service_id', $service->id)
            ->whereNotNull('referrer')
            ->groupBy('referrer')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();
        
        // Visites par navigateur
        $visitesParNavigateur = Visite::select(
                DB::raw('CASE 
                    WHEN user_agent LIKE "%Chrome%" THEN "Chrome"
                    WHEN user_agent LIKE "%Firefox%" THEN "Firefox"
                    WHEN user_agent LIKE "%Safari%" THEN "Safari"
                    WHEN user_agent LIKE "%Edge%" THEN "Edge"
                    WHEN user_agent LIKE "%MSIE%" OR user_agent LIKE "%Trident%" THEN "Internet Explorer"
                    ELSE "Autre"
                END as navigateur'),
                DB::raw('COUNT(*) as count')
            )
            ->where('service_id', $service->id)
            ->groupBy('navigateur')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('prestataire.statistiques', compact(
            'service',
            'totalVisites',
            'visitesParJour',
            'visitesParReferent',
            'visitesParNavigateur'
        ));
    }
}