<?php

namespace App\Actions\Service;

use App\Models\Prestataire;
use App\Models\Rapport;
use App\Models\Service;
use App\Models\Visite;
use App\Notifications\RapportMensuelDisponible;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GenererRapportMensuel
{
    public function execute(Prestataire $prestataire): ?Rapport
    {
        $service = $prestataire->service;
        
        if (!$service) {
            return null;
        }
        
        // Définir la période du rapport
        $finPeriode = Carbon::now()->endOfDay();
        $debutPeriode = Carbon::now()->subMonth()->startOfDay();
        
        // Récupérer les données
        $visitesTotal = $service->visites()
            ->whereBetween('created_at', [$debutPeriode, $finPeriode])
            ->count();
        
        $visitesParJour = Visite::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('service_id', $service->id)
            ->whereBetween('created_at', [$debutPeriode, $finPeriode])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Calculer les données pour le mois précédent pour comparaison
        $debutMoisPrecedent = Carbon::now()->subMonths(2)->startOfDay();
        $finMoisPrecedent = Carbon::now()->subMonth()->startOfDay();
        
        $visitesTotalMoisPrecedent = $service->visites()
            ->whereBetween('created_at', [$debutMoisPrecedent, $finMoisPrecedent])
            ->count();
        
        // Calculer la tendance (pourcentage d'évolution)
        $tendance = 0;
        if ($visitesTotalMoisPrecedent > 0) {
            $tendance = round((($visitesTotal - $visitesTotalMoisPrecedent) / $visitesTotalMoisPrecedent) * 100, 1);
        }
        
        // Récupérer les sources de trafic
        $sourcesTrafic = Visite::select('referrer', DB::raw('COUNT(*) as count'))
            ->where('service_id', $service->id)
            ->whereBetween('created_at', [$debutPeriode, $finPeriode])
            ->groupBy('referrer')
            ->orderBy('count', 'desc')
            ->get();
        
        // Calculer les visites par semaine
        $visitesParSemaine = [];
        $debutSemaine = clone $debutPeriode;
        $numeroSemaine = 1;
        $semaineActive = 1;
        $maxVisitesSemaine = 0;
        
        while ($debutSemaine < $finPeriode) {
            $finSemaine = (clone $debutSemaine)->addDays(6);
            
            if ($finSemaine > $finPeriode) {
                $finSemaine = clone $finPeriode;
            }
            
            $visitesSemaine = $service->visites()
                ->whereBetween('created_at', [$debutSemaine, $finSemaine])
                ->count();
            
            // Calculer l'évolution par rapport à la semaine précédente
            $evolution = 0;
            if (isset($visitesParSemaine[$numeroSemaine - 1]) && $visitesParSemaine[$numeroSemaine - 1]['visites'] > 0) {
                $evolution = round((($visitesSemaine - $visitesParSemaine[$numeroSemaine - 1]['visites']) / $visitesParSemaine[$numeroSemaine - 1]['visites']) * 100, 1);
            }
            
            $visitesParSemaine[] = [
                'debut' => $debutSemaine->format('d/m/Y'),
                'fin' => $finSemaine->format('d/m/Y'),
                'visites' => $visitesSemaine,
                'evolution' => $evolution
            ];
            
            // Déterminer la semaine la plus active
            if ($visitesSemaine > $maxVisitesSemaine) {
                $maxVisitesSemaine = $visitesSemaine;
                $semaineActive = $numeroSemaine;
            }
            
            $debutSemaine->addDays(7);
            $numeroSemaine++;
        }
        
        // Déterminer les sources principales
        $sourcesPrincipales = "Direct";
        if ($sourcesTrafic->count() > 0) {
            $sourcesPrincipales = $sourcesTrafic->first()->referrer ?: "Direct";
        }
        
        // Générer des recommandations basées sur les données
        $recommandations = [];
        
        if ($visitesTotal < 10) {
            $recommandations[] = "Votre service reçoit peu de visites. Envisagez d'améliorer votre visibilité en ligne.";
        }
        
        if ($tendance < 0) {
            $recommandations[] = "La tendance est à la baisse. Pensez à mettre à jour votre description et vos images.";
        }
        
        if (count($sourcesTrafic) < 2) {
            $recommandations[] = "Vos visiteurs proviennent principalement d'une seule source. Diversifiez vos canaux de promotion.";
        }
        
        if (empty($recommandations)) {
            $recommandations[] = "Continuez votre bon travail ! Votre service attire régulièrement des visiteurs.";
        }
        
        // Générer le PDF
        $pdf = PDF::loadView('rapports.mensuel', [
            'prestataire' => $prestataire,
            'service' => $service,
            'debutPeriode' => $debutPeriode,
            'finPeriode' => $finPeriode,
            'visitesTotal' => $visitesTotal,
            'visitesParJour' => $visitesParJour,
            'tendance' => $tendance,
            'sourcesTrafic' => $sourcesTrafic,
            'visitesParSemaine' => $visitesParSemaine,
            'semaineActive' => $semaineActive,
            'sourcesPrincipales' => $sourcesPrincipales,
            'recommandations' => $recommandations
        ]);
        
        // Sauvegarder le PDF
        $nomFichier = 'rapports/mensuel_' . $prestataire->id . '_' . uniqid() . '.pdf';
        Storage::disk('public')->put($nomFichier, $pdf->output());
        
        // Créer l'enregistrement du rapport
        $rapport = Rapport::create([
            'type' => 'mensuel',
            'periode_debut' => $debutPeriode,
            'periode_fin' => $finPeriode,
            'chemin_fichier' => $nomFichier,
            'prestataire_id' => $prestataire->id,
        ]);
        
        // Notifier le prestataire
        $prestataire->user->notify(new RapportMensuelDisponible($rapport));
        
        return $rapport;
    }
}