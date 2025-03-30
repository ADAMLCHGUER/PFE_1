<?php

namespace App\Providers;

use App\Console\Commands\RapportStatistiques;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            
            // Exécuter la commande de génération de rapports tous les lundis à 8h00
            $schedule->command(RapportStatistiques::class)->weekly()->mondays()->at('08:00');
        });
    }
}