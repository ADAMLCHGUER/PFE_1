<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire) {
            return response()->json(['error' => 'Prestataire non trouvé'], 404);
        }
        
        $rapports = $prestataire->rapports()
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return response()->json($rapports);
    }
    
    public function show(Request $request, $id)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire) {
            return response()->json(['error' => 'Prestataire non trouvé'], 404);
        }
        
        $rapport = $prestataire->rapports()->findOrFail($id);
        
        if (!Storage::disk('public')->exists($rapport->chemin_fichier)) {
            return response()->json(['error' => 'Fichier non trouvé'], 404);
        }
        
        if ($request->has('download')) {
            return response()->download(
                Storage::disk('public')->path($rapport->chemin_fichier),
                'rapport_' . $rapport->type . '_' . $rapport->periode_debut->format('Y-m-d') . '.pdf'
            );
        }
        
        return response()->file(Storage::disk('public')->path($rapport->chemin_fichier));
    }
}