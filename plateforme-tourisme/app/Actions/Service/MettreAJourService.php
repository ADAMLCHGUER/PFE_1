<?php

namespace App\Actions\Service;

use App\Models\Service;
use Illuminate\Support\Str;

class MettreAJourService
{
    public function execute(Service $service, array $data): Service
    {
        // Si le titre a changé, mettre à jour le slug
        if ($service->titre !== $data['titre']) {
            $data['slug'] = Str::slug($data['titre']) . '-' . uniqid();
        }
        
        $service->update($data);
        
        return $service;
    }
}