<?php

namespace App\Actions\Service;

use App\Models\Service;
use Illuminate\Http\Request;

class EnregistrerVisite
{
    public function execute(Service $service, Request $request): void
    {
        // Enregistrer la visite avec l'IP, l'agent utilisateur et le référent
        $service->visites()->create([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->header('referer'),
        ]);
    }
}