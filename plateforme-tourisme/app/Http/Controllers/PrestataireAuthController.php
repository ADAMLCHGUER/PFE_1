<?php

namespace App\Http\Controllers;

use App\Models\Prestataire;
use App\Models\User;
use App\Notifications\ComptePrestatairEnRevision;
use App\Notifications\NouveauPrestataireInscrit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nom_entreprise' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
        ]);
        
        // Créer le prestataire directement (sans l'action)
        $prestataire = Prestataire::create([
            'nom_entreprise' => $validated['nom_entreprise'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'email' => $validated['email'], // Ajout de l'email ici
            'statut' => 'en_revision',
        ]);
        
        // Envoyer notification aux administrateurs
        // Vérifiez cette ligne
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
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Vérifier si l'utilisateur est associé à un prestataire
            $prestataire = Prestataire::where('email', $credentials['email'])->first();
            if ($prestataire && $prestataire->statut === 'valide') {
                return redirect()->route('prestataire.tableau');
            }
            
            return redirect()->route('prestataire.attente');
        }
        
        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }
    
    public function deconnexion(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('accueil');
    }
}