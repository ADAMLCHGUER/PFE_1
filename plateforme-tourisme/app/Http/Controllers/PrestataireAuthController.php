<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Notifications\NouveauPrestataireInscrit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class PrestataireAuthController extends Controller
{
    public function inscriptionForm()
    {
        return view('auth.inscription');
    }
    
    public function inscription(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:prestataires,email',
            'password' => 'required|min:8|confirmed',
            'nom_entreprise' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
        ]);
        
        // Créer directement le prestataire
        $prestataire = Prestataire::create([
            'nom_entreprise' => $validated['nom_entreprise'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'statut' => 'en_revision',
        ]);
        
        // Envoyer notification aux administrateurs
        Notification::route('mail', config('mail.admin_address'))
            ->notify(new NouveauPrestataireInscrit($prestataire));
        
        // Rediriger vers la page d'attente
        return redirect()->route('prestataire.attente');
    }
    
    public function connexionForm()
    {
        return view('auth.connexion');
    }
    
    public function connexion(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Rechercher le prestataire par email
        $prestataire = Prestataire::where('email', $credentials['email'])->first();
        
        // Vérifier le mot de passe
        if ($prestataire && Hash::check($credentials['password'], $prestataire->password)) {
    // Stockez l'ID du prestataire en session de manière uniforme
    Session::put('prestataire_id', $prestataire->id);
    Session::put('prestataire_email', $prestataire->email);
    Session::put('prestataire_nom', $prestataire->nom_entreprise);
    
    $request->session()->regenerate();
    
    // Rediriger en fonction du statut
    if ($prestataire->estValide()) {
        return redirect()->route('prestataire.tableau');
    } else {
        return redirect()->route('prestataire.attente');
    }
}
        
        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }
    
    public function deconnexion(Request $request)
    {
        // Supprimer les données du prestataire de la session
        Session::forget(['prestataire_id', 'prestataire_email', 'prestataire_nom']);
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('accueil');
    }
}