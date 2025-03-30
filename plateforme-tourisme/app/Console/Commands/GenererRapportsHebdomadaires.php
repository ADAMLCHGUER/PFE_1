<?php

namespace App\Console\Commands;

use App\Actions\Service\GenererRapportHebdomadaire;
use App\Models\Prestataire;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenererRapportsHebdomadaires extends Command
{
    protected $signature = 'app:generer-rapports-hebdomadaires';
    protected $description = 'Génère les rapports hebdomadaires pour tous les prestataires valides';

    public function handle()
    {
        $this->info('Début de la génération des rapports hebdomadaires...');
        
        $genererRapport = new GenererRapportHebdomadaire();
        $prestataires = Prestataire::where('statut', 'valide')->get();
        
        $this->info("Nombre de prestataires à traiter : {$prestataires->count()}");
        
        $rapportsGeneres = 0;
        
        foreach ($prestataires as $prestataire) {
            try {
                $rapport = $genererRapport->execute($prestataire);
                
                if ($rapport) {
                    $rapportsGeneres++;
                    $this->info("Rapport hebdomadaire généré pour {$prestataire->nom_entreprise}");
                } else {
                    $this->warn("Impossible de générer un rapport pour {$prestataire->nom_entreprise} (pas de service)");
                }
            } catch (\Exception $e) {
                $this->error("Erreur lors de la génération du rapport pour {$prestataire->nom_entreprise}: {$e->getMessage()}");
                Log::error("Erreur rapport hebdomadaire: {$e->getMessage()}", ['prestataire' => $prestataire->id, 'trace' => $e->getTraceAsString()]);
            }
        }
        
        $this->info("Fin de la génération des rapports. Rapports générés : {$rapportsGeneres}");
        
        return Command::SUCCESS;
    }
}