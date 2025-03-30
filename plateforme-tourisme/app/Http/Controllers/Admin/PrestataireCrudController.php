<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Prestataire\ValiderPrestataire;
use App\Http\Requests\PrestaireRequest;
use App\Models\Prestataire;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class PrestataireCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(Prestataire::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/prestataire');
        CRUD::setEntityNameStrings('prestataire', 'prestataires');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('nom_entreprise');
        CRUD::column('email');
        CRUD::column('telephone');
        CRUD::column('statut')->type('enum');
        CRUD::column('date_validation');
        CRUD::column('created_at');

        // Ajouter des boutons personnalisés
        $this->crud->addButtonFromView('line', 'valider', 'valider_prestataire', 'beginning');
        $this->crud->addButtonFromView('line', 'refuser', 'refuser_prestataire', 'beginning');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('adresse');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(PrestaireRequest::class);

        CRUD::field('nom_entreprise');
        CRUD::field('email');
        CRUD::field('telephone');
        CRUD::field('adresse');
        CRUD::field('statut')->type('enum')->options([
            'en_revision' => 'En révision',
            'valide' => 'Validé',
            'non_valide' => 'Non validé',
        ]);
    }

    // Méthode pour valider un prestataire
    public function valider(Request $request, $id)
    {
        $prestataire = Prestataire::findOrFail($id);
        $validerPrestataire = new ValiderPrestataire();
        $validerPrestataire->execute($prestataire, 'valide');

        \Alert::success('Le prestataire a été validé avec succès.')->flash();
        return redirect()->back();
    }

    // Méthode pour refuser un prestataire
    public function refuser(Request $request, $id)
    {
        $prestataire = Prestataire::findOrFail($id);
        $validerPrestataire = new ValiderPrestataire();
        $validerPrestataire->execute($prestataire, 'non_valide');

        \Alert::success('Le prestataire a été refusé.')->flash();
        return redirect()->back();
    }
}