<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['prestataire', 'categorie', 'ville']);
        
        // Filtres
        if ($request->filled('categorie')) {
            $query->whereHas('categorie', function($q) use ($request) {
                $q->where('slug', $request->categorie);
            });
        }
        
        if ($request->filled('ville')) {
            $query->whereHas('ville', function($q) use ($request) {
                $q->where('slug', $request->ville);
            });
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        
        $services = $query->paginate(12);
        
        return response()->json($services);
    }

    public function show($slug)
    {
        $service = Service::with(['prestataire', 'categorie', 'ville', 'images'])
                    ->where('slug', $slug)
                    ->firstOrFail();
        
        return response()->json($service);
    }

    public function populaires()
    {
        $servicesPopulaires = Service::with(['prestataire', 'categorie', 'ville', 'images'])
                                ->withCount('visites')
                                ->orderBy('visites_count', 'desc')
                                ->take(6)
                                ->get();
        
        return response()->json($servicesPopulaires);
    }
}