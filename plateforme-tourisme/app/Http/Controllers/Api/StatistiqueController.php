<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire || !$prestataire->service) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
        
        $service = $prestataire->service;
        $periode = $request->get('periode', 'semaine');
        
        switch ($periode) {
            case 'mois':
                $debutPeriode = now()->subMonth();
                break;
            case 'annee':
                $debutPeriode = now()->subYear();
                break;
            case 'semaine':
            default:
                $debutPeriode = now()->subWeek();
                break;
        }
        
        $totalVisites = $service->visites()->count();
        $visitesRecentes = $service->visites()
                            ->where('created_at', '>=', $debutPeriode)
                            ->count();
        
        $visitesParJour = Visite::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                            ->where('service_id', $service->id)
                            ->where('created_at', '>=', $debutPeriode)
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();
        
        $visitesParReferent = Visite::select('referrer', DB::raw('COUNT(*) as count'))
                                ->where('service_id', $service->id)
                                ->where('created_at', '>=', $debutPeriode)
                                ->whereNotNull('referrer')
                                ->groupBy('referrer')
                                ->orderBy('count', 'desc')
                                ->take(10)
                                ->get();
        
        $visitesParNavigateur = Visite::select(
                DB::raw('SUBSTRING_INDEX(user_agent, " ", 1) as navigateur'),
                DB::raw('COUNT(*) as count')
            )
            ->where('service_id', $service->id)
            ->where('created_at', '>=', $debutPeriode)
            ->groupBy('navigateur')
            ->orderBy('count', 'desc')
            ->get();
        
        return response()->json([
            'total_visites' => $totalVisites,
            'visites_recentes' => $visitesRecentes,
            'visites_par_jour' => $visitesParJour,
            'visites_par_referent' => $visitesParReferent,
            'visites_par_navigateur' => $visitesParNavigateur,
        ]);
    }
}