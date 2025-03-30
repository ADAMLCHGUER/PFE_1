<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\PrestataireAuthController;
use App\Http\Controllers\PrestatairePanneauController;
use App\Http\Controllers\PrestataireServiceController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatistiquesController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Routes d'authentification prestataire
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [PrestataireAuthController::class, 'inscriptionForm'])->name('prestataire.inscription');
    Route::post('/inscription', [PrestataireAuthController::class, 'inscription']);
    Route::get('/connexion', [PrestataireAuthController::class, 'connexionForm'])->name('prestataire.connexion');
    Route::post('/connexion', [PrestataireAuthController::class, 'connexion']);
});

// Routes prestataire authentifié
Route::middleware('auth')->prefix('prestataire')->name('prestataire.')->group(function () {
    Route::get('/attente', [PrestatairePanneauController::class, 'attente'])->name('attente');
    Route::post('/deconnexion', [PrestataireAuthController::class, 'deconnexion'])->name('deconnexion');
    
    // Routes pour prestataires validés uniquement
    Route::middleware('prestataire.valide')->group(function () {
        Route::get('/tableau-de-bord', [PrestatairePanneauController::class, 'index'])->name('tableau');
        Route::get('/statistiques', [StatistiquesController::class, 'index'])->name('statistiques');
        
        // Gestion du service
        Route::get('/service/creation', [PrestataireServiceController::class, 'create'])->name('service.create');
        Route::post('/service', [PrestataireServiceController::class, 'store'])->name('service.store');
        Route::get('/service/modification', [PrestataireServiceController::class, 'edit'])->name('service.edit');
        Route::put('/service', [PrestataireServiceController::class, 'update'])->name('service.update');
        
        // Images du service
        Route::post('/service/images', [PrestataireServiceController::class, 'storeImage'])->name('service.image.store');
        Route::delete('/service/images/{image}', [PrestataireServiceController::class, 'destroyImage'])->name('service.image.destroy');
        Route::post('/service/images/{image}/principale', [PrestataireServiceController::class, 'setImagePrincipale'])->name('service.image.principale');
        
        // Rapports
        Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
        Route::get('/rapports/{rapport}', [RapportController::class, 'show'])->name('rapports.show');
        Route::get('/login', function () {
            return redirect()->route('prestataire.connexion');
        })->name('login');
    });
});

// Routes d'administration (gérées par Backpack)