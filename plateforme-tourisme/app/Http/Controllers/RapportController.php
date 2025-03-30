<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index()
    {
        $prestataire = Auth::user()->prestataire;
        $rapports = $prestataire->rapports()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('prestataire.rapports.index', compact('rapports'));
    }
    
    public function show(Rapport $rapport)
    {
        $prestataire = Auth::user()->prestataire;
        
        // Vérifier que le rapport appartient bien au prestataire
        if ($rapport->prestataire_id !== $prestataire->id) {
            abort(403);
        }
        
        // Vérifier que le fichier existe
        if (!Storage::disk('public')->exists($rapport->chemin_fichier)) {
            abort(404, 'Le rapport n\'est plus disponible.');
        }
        
        return response()->file(Storage::disk('public')->path($rapport->chemin_fichier));
    }
}