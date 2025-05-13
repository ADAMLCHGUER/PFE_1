<?php

namespace App\Http\Controllers;

use App\Actions\Service\MettreAJourService;
use App\Models\Categorie;
use App\Models\Image;
use App\Models\Prestataire;
use App\Models\Service;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PrestataireServiceController extends Controller
{
    public function create(Request $request)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour créer un service.');
        }
        
        // Vérifier si le prestataire a déjà un service
        if ($prestataire->service) {
            return redirect()->route('prestataire.service.edit');
        }
        
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('prestataire.formulaire_service', compact('prestataire', 'categories', 'villes'));
    }
    
    public function store(Request $request)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour créer un service.');
        }
        
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
    
    public function edit(Request $request)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour modifier un service.');
        }
        
        $service = $prestataire->service;
        
        // Si le prestataire n'a pas encore de service, rediriger vers la création
        if (!$service) {
            return redirect()->route('prestataire.service.create');
        }
        
        $categories = Categorie::all();
        $villes = Ville::all();
        
        return view('prestataire.formulaire_service', compact('prestataire', 'service', 'categories', 'villes'));
    }
    
    public function update(Request $request, MettreAJourService $mettreAJourService)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour modifier un service.');
        }
        
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
    $prestataire = Prestataire::find(Session::get('prestataire_id'));
    $service = $prestataire->service;
    
    $request->validate([
        'image' => 'required|image|max:2048', // 2MB max
    ]);
    
    // Utiliser la méthode store pour sauvegarder l'image dans le dossier public/storage/services
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
    
    public function destroyImage(Request $request, Image $image)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour supprimer une image.');
        }
        
        $service = $prestataire->service;
        
        // Vérifier que l'image appartient bien au service du prestataire
        if (!$service || $image->service_id !== $service->id) {
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
    
    public function setImagePrincipale(Request $request, Image $image)
    {
        // Récupérer le prestataire depuis la session au lieu de Auth::user()
        $prestataire = Prestataire::find(Session::get('prestataire_id'));
        
        if (!$prestataire) {
            return redirect()->route('prestataire.connexion')
                ->with('error', 'Vous devez être connecté pour modifier une image.');
        }
        
        $service = $prestataire->service;
        
        // Vérifier que l'image appartient bien au service du prestataire
        if (!$service || $image->service_id !== $service->id) {
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