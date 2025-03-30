<?php

namespace App\Http\Controllers;

use App\Actions\Service\EnregistrerVisite;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['prestataire', 'categorie', 'ville', 'images']);
        
        // Filtres
        if ($request->filled('categorie')) {
            $query->whereHas('categorie', function ($q) use ($request) {
                $q->where('slug', $request->categorie);
            });
        }
        
        if ($request->filled('ville')) {
            $query->whereHas('ville', function ($q) use ($request) {
                $q->where('slug', $request->ville);
            });
        }
        
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        
        $services = $query->paginate(12);
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('services.index', compact('services', 'categories', 'villes'));
    }
    
    public function show($slug, EnregistrerVisite $enregistrerVisite)
    {
        $service = Service::with(['prestataire', 'categorie', 'ville', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Enregistrer la visite
        $enregistrerVisite->execute($service, request());
        
        return view('services.afficher', compact('service'));
    }
}