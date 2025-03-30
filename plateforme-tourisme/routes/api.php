<?php
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\PrestataireController;
use App\Http\Controllers\Api\RapportController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StatistiqueController;
use App\Http\Controllers\Api\VilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/categories/{id}', [CategorieController::class, 'show']);

Route::get('/villes', [VilleController::class, 'index']);
Route::get('/villes/populaires', [VilleController::class, 'populaires']);
Route::get('/villes/{id}', [VilleController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/populaires', [ServiceController::class, 'populaires']);
Route::get('/services/{slug}', [ServiceController::class, 'show']);

// Routes protégées (nécessitent authentification)
Route::middleware('auth:sanctum')->group(function () {
    // Route utilisateur
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Routes prestataire
    Route::prefix('prestataire')->group(function () {
        // Service
        Route::prefix('service')->group(function () {
            Route::get('/', [PrestataireController::class, 'getService']);
            Route::post('/', [PrestataireController::class, 'storeService']);
            Route::put('/', [PrestataireController::class, 'updateService']);
            
            // Images
            Route::prefix('images')->group(function () {
                Route::post('/', [PrestataireController::class, 'storeImage']);
                Route::delete('/{id}', [PrestataireController::class, 'destroyImage']);
                Route::post('/{id}/principale', [PrestataireController::class, 'setImagePrincipale']);
            });
        });

        // Statistiques
        Route::get('/statistiques', [StatistiqueController::class, 'index']);
        
        // Rapports
        Route::get('/rapports', [RapportController::class, 'index']);
    });
});
