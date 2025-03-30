<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('prestataire', 'PrestataireCrudController');
    Route::crud('categorie', 'CategorieCrudController');
    Route::crud('ville', 'VilleCrudController');
    Route::crud('service', 'ServiceCrudController');
    Route::crud('rapport', 'RapportCrudController');
     // Validation et refus de prestataires
     Route::get('prestataire/{id}/valider', 'PrestataireCrudController@valider');
     Route::get('prestataire/{id}/refuser', [PrestataireCrudController::class, 'refuser']);
     
     // Téléchargement de rapports
     Route::get('rapport/{id}/telecharger', [RapportCrudController::class, 'telecharger']);
     // Tableau de bord personnalisé
Route::get('dashboard', 'DashboardController@dashboard')->name('backpack.dashboard');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
