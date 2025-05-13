<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer le prestataire depuis la session
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour accéder aux rapports.');
        }
        
        $rapports = $prestataire->rapports()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('prestataire.rapports.index', compact('prestataire', 'rapports'));
    }
    
    public function show(Request $request, Rapport $rapport)
    {
        // Récupérer le prestataire depuis la session
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour accéder aux rapports.');
        }
        
        // Vérifier que le rapport appartient bien au prestataire
        if ($rapport->prestataire_id !== $prestataire->id) {
            abort(403);
        }
        
        return view('prestataire.rapports.show', compact('prestataire', 'rapport'));
    }
}