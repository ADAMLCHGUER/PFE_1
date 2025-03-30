<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {
        $servicesPopulaires = Service::with(['prestataire', 'categorie', 'ville', 'images'])
            ->withCount('visites')
            ->orderBy('visites_count', 'desc')
            ->take(6)
            ->get();
            
        $categories = Categorie::all();
        $villesPopulaires = Ville::where('populaire', true)->take(6)->get();
        
        return view('accueil', compact('servicesPopulaires', 'categories', 'villesPopulaires'));
    }
}