<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RapportRequest;
use App\Models\Rapport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;

class RapportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(Rapport::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rapport');
        CRUD::setEntityNameStrings('rapport', 'rapports');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('type');
        CRUD::column('periode_debut');
        CRUD::column('periode_fin');
        CRUD::column('prestataire.nom_entreprise');
        CRUD::column('created_at');
        
        // Ajouter un bouton pour télécharger le rapport
        $this->crud->addButtonFromView('line', 'telecharger', 'telecharger_rapport', 'beginning');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    // Méthode pour télécharger un rapport
    public function telecharger($id)
    {
        $rapport = Rapport::findOrFail($id);
        
        if (!Storage::disk('public')->exists($rapport->chemin_fichier)) {
            \Alert::error('Le fichier du rapport n\'est pas disponible.')->flash();
            return redirect()->back();
        }
        
        return response()->download(
            Storage::disk('public')->path($rapport->chemin_fichier),
            'rapport_' . $rapport->type . '_' . $rapport->periode_debut->format('Y-m-d') . '.pdf'
        );
    }
}