<?php

namespace App\Actions\Service;

use App\Models\Service;
use Illuminate\Support\Collection;

class RecupererServicesPopulaires
{
    public function execute(int $limit = 6): Collection
    {
        return Service::with(['prestataire', 'categorie', 'ville', 'images'])
            ->withCount('visites')
            ->orderBy('visites_count', 'desc')
            ->take($limit)
            ->get();
    }
}