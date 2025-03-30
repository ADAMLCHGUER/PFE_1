<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::orderBy('nom')->get();
        return response()->json($villes);
    }

    public function populaires()
    {
        $villesPopulaires = Ville::where('populaire', true)->get();
        return response()->json($villesPopulaires);
    }

    public function show($id)
    {
        $ville = Ville::findOrFail($id);
        return response()->json($ville);
    }
}