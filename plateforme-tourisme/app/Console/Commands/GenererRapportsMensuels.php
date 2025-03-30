<?php

namespace App\Console\Commands;

use App\Actions\Service\GenererRapportMensuel;
use App\Models\Prestataire;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenererRapportsMensuels extends Command
{
    protected $signature = 'app:generer-rapports-mensuels';
    protected $description = 'Génère les rapports mensuels pour tous les prestataires valides';

    public function handle()
    {
        $this->info('Début de la génération des rapports mensuels...');
        
        $genererRapport = new GenererRapportMensuel();
        $prestataires = Prestataire::where('statut', 'valide')->get();
        
        $this->info("Nombre de prestataires à traiter : {$prestataires->count()}");
        
        $rapportsGeneres = 0;
        
        foreach ($prestataires as $prestataire) {
            try {
                $rapport = $genererRapport->execute($prestataire);
                
                if ($rapport) {
                    $rapportsGeneres++;
                    $this->info("Rapport mensuel généré pour {$prestataire->nom_entreprise}");
                } else {
                    $this->warn("Impossible de générer un rapport pour {$prestataire->nom_entreprise} (pas de service)");
                }
            } catch (\Exception $e) {
                $this->error("Erreur lors de la génération du rapport pour {$prestataire->nom_entreprise}: {$e->getMessage()}");
                Log::error("Erreur rapport mensuel: {$e->getMessage()}", ['prestataire' => $prestataire->id, 'trace' => $e->getTraceAsString()]);
            }
        }
        
        $this->info("Fin de la génération des rapports. Rapports générés : {$rapportsGeneres}");
        
        return Command::SUCCESS;
    }
}