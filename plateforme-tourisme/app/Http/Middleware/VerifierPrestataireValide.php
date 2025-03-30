<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifierPrestataireValide
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->prestataire || !$request->user()->prestataire->estValide()) {
            return redirect()->route('prestataire.attente');
        }

        return $next($request);
    }
}