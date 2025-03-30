<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

class CategorieCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Categorie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/categorie');
        CRUD::setEntityNameStrings('catégorie', 'catégories');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('nom');
        CRUD::column('slug');
        CRUD::column('icone');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategorieRequest::class);

        CRUD::field('nom');
        CRUD::field('slug')->hint('Laissez vide pour générer automatiquement à partir du nom.');
        CRUD::field('icone')->hint('Nom de l\'icône Bootstrap, ex: geo-alt');
        CRUD::field('description')->type('textarea');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    // Méthode pour générer automatiquement le slug
    public function store()
    {
        $this->handleSlugCreation($this->crud->getRequest());
        return $this->traitStore();
    }

    public function update()
    {
        $this->handleSlugCreation($this->crud->getRequest());
        return $this->traitUpdate();
    }

    private function handleSlugCreation($request)
    {
        $input = $request->all();
        if (empty($input['slug'])) {
            $input['slug'] = Str::slug($input['nom']);
            $request->replace($input);
        }
    }
}