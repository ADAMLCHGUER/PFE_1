<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ServiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(Service::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/service');
        CRUD::setEntityNameStrings('service', 'services');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('titre');
        CRUD::column('prestataire.nom_entreprise');
        CRUD::column('categorie.nom');
        CRUD::column('ville.nom');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupShowOperation()
    {
        CRUD::column('id');
        CRUD::column('titre');
        CRUD::column('slug');
        CRUD::column('prestataire.nom_entreprise');
        CRUD::column('categorie.nom');
        CRUD::column('ville.nom');
        CRUD::column('description');
        CRUD::column('prestations');
        CRUD::column('coordonnees');
        CRUD::column('adresse');
        CRUD::column('telephone');
        CRUD::column('email');
        CRUD::column('site_web');
        CRUD::column('horaires');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(ServiceRequest::class);

        CRUD::field('titre');
        CRUD::field('categorie_id')->type('select')->entity('categorie')->attribute('nom');
        CRUD::field('ville_id')->type('select')->entity('ville')->attribute('nom');
        CRUD::field('description')->type('textarea');
        CRUD::field('prestations')->type('textarea');
        CRUD::field('coordonnees');
        CRUD::field('adresse');
        CRUD::field('telephone');
        CRUD::field('email');
        CRUD::field('site_web');
        CRUD::field('horaires')->type('repeatable')->fields([
            [
                'name' => 'jour',
                'type' => 'select_from_array',
                'options' => [
                    'lundi' => 'Lundi',
                    'mardi' => 'Mardi',
                    'mercredi' => 'Mercredi',
                    'jeudi' => 'Jeudi',
                    'vendredi' => 'Vendredi',
                    'samedi' => 'Samedi',
                    'dimanche' => 'Dimanche'
                ]
            ],
            [
                'name' => 'ouverture',
                'type' => 'time'
            ],
            [
                'name' => 'fermeture',
                'type' => 'time'
            ]
        ]);
    }
}