<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Prestataire;

class VerifierPrestataireValide
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si prestataire_id existe en session
        if (!Session::has('prestataire_id')) {
            return redirect()->route('prestataire.connexion');
        }

        // Récupérer le prestataire depuis la session
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        // Vérifier si le prestataire existe et est valide
        if (!$prestataire || !$prestataire->estValide()) {
            return redirect()->route('prestataire.attente');
        }

        return $next($request);
    }
}