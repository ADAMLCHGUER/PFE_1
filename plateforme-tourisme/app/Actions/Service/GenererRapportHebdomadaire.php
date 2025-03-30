<?php

namespace App\Actions\Service;

use App\Models\Prestataire;
use App\Models\Rapport;
use App\Models\Service;
use App\Models\Visite;
use App\Notifications\RapportHebdomadaireDisponible;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class GenererRapportHebdomadaire
{
    public function execute(Prestataire $prestataire): ?Rapport
    {
        $service = $prestataire->service;
        
        if (!$service) {
            return null;
        }
        
        // Définir la période du rapport
        $finPeriode = Carbon::now()->endOfDay();
        $debutPeriode = Carbon::now()->subDays(7)->startOfDay();
        
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
        
        // Générer le PDF
        $pdf = PDF::loadView('rapports.hebdomadaire', [
            'prestataire' => $prestataire,
            'service' => $service,
            'debutPeriode' => $debutPeriode,
            'finPeriode' => $finPeriode,
            'visitesTotal' => $visitesTotal,
            'visitesParJour' => $visitesParJour,
        ]);
        
        // Sauvegarder le PDF
        $nomFichier = 'rapports/' . uniqid() . '.pdf';
        Storage::disk('public')->put($nomFichier, $pdf->output());
        
        // Créer l'enregistrement du rapport
        $rapport = Rapport::create([
            'type' => 'hebdomadaire',
            'periode_debut' => $debutPeriode,
            'periode_fin' => $finPeriode,
            'chemin_fichier' => $nomFichier,
            'prestataire_id' => $prestataire->id,
        ]);
        
        // Notifier le prestataire
        $prestataire->user->notify(new RapportHebdomadaireDisponible($rapport));
        
        return $rapport;
    }
}