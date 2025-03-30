<?php

namespace App\Http\Controllers;

use App\Actions\Service\MettreAJourService;
use App\Models\Categorie;
use App\Models\Image;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PrestataireServiceController extends Controller
{
    public function create()
    {
        $prestataire = Auth::user()->prestataire;
        
        // Vérifier si le prestataire a déjà un service
        if ($prestataire->service) {
            return redirect()->route('prestataire.service.edit');
        }
        
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('prestataire.formulaire_service', compact('categories', 'villes'));
    }
    
    public function store(Request $request)
    {
        $prestataire = Auth::user()->prestataire;
        
        // Vérifier si le prestataire a déjà un service
        if ($prestataire->service) {
            return redirect()->route('prestataire.service.edit');
        }
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'description' => 'required|string',
            'prestations' => 'required|string',
            'coordonnees' => 'nullable|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'site_web' => 'nullable|url',
            'horaires' => 'nullable|array',
        ]);
        
        $validated['prestataire_id'] = $prestataire->id;
        $validated['slug'] = Str::slug($validated['titre']) . '-' . uniqid();
        
        $service = Service::create($validated);
        
        return redirect()->route('prestataire.service.edit')
            ->with('success', 'Service créé avec succès. Vous pouvez maintenant ajouter des images.');
    }
    
    public function edit()
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        // Si le prestataire n'a pas encore de service, rediriger vers la création
        if (!$service) {
            return redirect()->route('prestataire.service.create');
        }
        
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('prestataire.formulaire_service', compact('service', 'categories', 'villes'));
    }
    
    public function update(Request $request, MettreAJourService $mettreAJourService)
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        // Si le prestataire n'a pas encore de service, rediriger vers la création
        if (!$service) {
            return redirect()->route('prestataire.service.create');
        }
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'description' => 'required|string',
            'prestations' => 'required|string',
            'coordonnees' => 'nullable|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'site_web' => 'nullable|url',
            'horaires' => 'nullable|array',
        ]);
        
        $mettreAJourService->execute($service, $validated);
        
        return redirect()->route('prestataire.service.edit')
            ->with('success', 'Service mis à jour avec succès.');
    }
    
    public function storeImage(Request $request)
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        $request->validate([
            'image' => 'required|image|max:2048', // 2MB max
        ]);
        
        $path = $request->file('image')->store('services', 'public');
        
        // Vérifier si c'est la première image pour définir comme principale
        $isPrincipale = $service->images()->count() === 0;
        
        $image = $service->images()->create([
            'chemin' => $path,
            'principale' => $isPrincipale,
            'ordre' => $service->images()->max('ordre') + 1,
        ]);
        
        return redirect()->route('prestataire.service.edit')
            ->with('success', 'Image ajoutée avec succès.');
    }
    
    public function destroyImage(Image $image)
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        // Vérifier que l'image appartient bien au service du prestataire
        if ($image->service_id !== $service->id) {
            abort(403);
        }
        
        // Si l'image est principale, définir une autre image comme principale
        if ($image->principale && $service->images()->count() > 1) {
            $newPrincipal = $service->images()->where('id', '!=', $image->id)->first();
            $newPrincipal->update(['principale' => true]);
        }
        
        // Supprimer le fichier
        Storage::disk('public')->delete($image->chemin);
        
        // Supprimer l'enregistrement
        $image->delete();
        
        return redirect()->route('prestataire.service.edit')
            ->with('success', 'Image supprimée avec succès.');
    }
    
    public function setImagePrincipale(Image $image)
    {
        $prestataire = Auth::user()->prestataire;
        $service = $prestataire->service;
        
        // Vérifier que l'image appartient bien au service du prestataire
        if ($image->service_id !== $service->id) {
            abort(403);
        }
        
        // Mettre à jour toutes les images du service
        $service->images()->update(['principale' => false]);
        
        // Définir cette image comme principale
        $image->update(['principale' => true]);
        
        return redirect()->route('prestataire.service.edit')
            ->with('success', 'Image principale définie avec succès.');
    }
}