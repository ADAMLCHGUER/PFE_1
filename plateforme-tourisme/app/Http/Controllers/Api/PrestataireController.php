<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PrestataireController extends Controller
{
    public function getService(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire) {
            return response()->json(['error' => 'Prestataire non trouvé'], 404);
        }
        
        $service = $prestataire->service()->with(['categorie', 'ville', 'images'])->first();
        
        return response()->json($service);
    }
    
    public function storeService(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire) {
            return response()->json(['error' => 'Prestataire non trouvé'], 404);
        }
        
        if ($prestataire->service()->exists()) {
            return response()->json(['error' => 'Vous avez déjà un service'], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'description' => 'required|string',
            'prestations' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'site_web' => 'nullable|url',
            'coordonnees' => 'nullable|string',
            'horaires' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $request->all();
        $data['prestataire_id'] = $prestataire->id;
        $data['slug'] = Str::slug($data['titre']) . '-' . uniqid();
        
        $service = Service::create($data);
        
        return response()->json($service, 201);
    }
    
    public function updateService(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire) {
            return response()->json(['error' => 'Prestataire non trouvé'], 404);
        }
        
        $service = $prestataire->service;
        
        if (!$service) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'ville_id' => 'required|exists:villes,id',
            'description' => 'required|string',
            'prestations' => 'required|string',
            'adresse' => 'required|string',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'site_web' => 'nullable|url',
            'coordonnees' => 'nullable|string',
            'horaires' => 'nullable|array',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $request->all();
        
        // Si le titre a changé, mettre à jour le slug
        if ($service->titre !== $data['titre']) {
            $data['slug'] = Str::slug($data['titre']) . '-' . uniqid();
        }
        
        $service->update($data);
        
        return response()->json($service);
    }
    
    public function storeImage(Request $request)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire || !$prestataire->service) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048', // 2MB max
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('services', $fileName, 'public');
        
        $isPrincipale = $prestataire->service->images()->count() === 0;
        
        $image = $prestataire->service->images()->create([
            'chemin' => $path,
            'principale' => $isPrincipale,
            'ordre' => $prestataire->service->images()->max('ordre') + 1,
        ]);
        
        return response()->json(['message' => 'Image ajoutée avec succès', 'image' => $image], 201);
    }
    
    public function destroyImage(Request $request, $id)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire || !$prestataire->service) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
        
        $image = Image::find($id);
        
        if (!$image || $image->service_id !== $prestataire->service->id) {
            return response()->json(['error' => 'Image non trouvée'], 404);
        }
        
        // Si l'image est principale, définir une autre image comme principale
        if ($image->principale && $prestataire->service->images()->count() > 1) {
            $newPrincipal = $prestataire->service->images()
                                ->where('id', '!=', $image->id)
                                ->first();
            $newPrincipal->update(['principale' => true]);
        }
        
        // Supprimer le fichier
        if (Storage::disk('public')->exists($image->chemin)) {
            Storage::disk('public')->delete($image->chemin);
        }
        
        $image->delete();
        
        return response()->json(['message' => 'Image supprimée avec succès']);
    }
    
    public function setImagePrincipale(Request $request, $id)
    {
        $prestataire = $request->user()->prestataire;
        
        if (!$prestataire || !$prestataire->service) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
        
        $image = Image::find($id);
        
        if (!$image || $image->service_id !== $prestataire->service->id) {
            return response()->json(['error' => 'Image non trouvée'], 404);
        }
        
        // Mettre à jour toutes les images du service
        $prestataire->service->images()->update(['principale' => false]);
        
        // Définir cette image comme principale
        $image->update(['principale' => true]);
        
        return response()->json(['message' => 'Image principale définie avec succès']);
    }
}