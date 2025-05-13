<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VilleRequest;
use App\Models\Ville;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

class VilleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Ville::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/ville');
        CRUD::setEntityNameStrings('ville', 'villes');
    }

    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('nom');
        CRUD::column('slug');
        // Add image column
        CRUD::column('image')->type('image')->prefix('storage/');
        CRUD::column('populaire')->type('boolean');
        CRUD::column('created_at');
        CRUD::column('updated_at');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(VilleRequest::class);

        CRUD::field('nom');
        CRUD::field('slug')->hint('Laissez vide pour générer automatiquement à partir du nom.');
        CRUD::field('description')->type('textarea');
        
        // Update upload field to use simply 'upload' instead of detailed configuration
        CRUD::field('image')
            ->type('upload')
            ->label('Image')
            ->hint('Sélectionnez une image pour cette ville')
            ->upload(true);
            
        CRUD::field('populaire')->type('checkbox')->label('Ville populaire');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
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