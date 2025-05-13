<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\Prestataire;
use App\Models\Visite;

class AccueilController extends Controller
{
    public function index()
    {
        $servicesPopulaires = Service::with(['images', 'categorie', 'ville'])
    ->whereHas('prestataire', function($q) {
        $q->where('statut', 'valide');
    })
    ->take(6)
    ->get();
            
        $categories = Categorie::all();
        $villesPopulaires = Ville::where('populaire', true)->take(6)->get();
        
        return view('accueil', compact('servicesPopulaires', 'categories', 'villesPopulaires'));
    }
}