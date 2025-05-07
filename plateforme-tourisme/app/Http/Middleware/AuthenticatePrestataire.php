<?php

namespace App\Http\Middleware;

use App\Models\Prestataire;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatePrestataire
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si prestataire_id existe en session
        if (!Session::has('prestataire_id')) {
            return redirect()->route('prestataire.connexion');
        }

        // Récupérer le prestataire
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        // Vérifier si le prestataire existe
        if (!$prestataire) {
            Session::forget(['prestataire_id', 'prestataire_email', 'prestataire_nom']);
            return redirect()->route('prestataire.connexion');
        }
        
        // Stocker le prestataire dans la requête pour y accéder facilement
        $request->attributes->add(['prestataire' => $prestataire]);
        
        return $next($request);
    }
}