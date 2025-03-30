<x-layout>
    <x-slot:title>Services touristiques - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="mb-3">Découvrez nos services touristiques</h1>
                <p class="lead">Explorez une sélection de services de qualité pour rendre votre expérience au Maroc inoubliable.</p>
            </div>
        </div>
        
        <div class="row">
            <!-- Filtres -->
            <div class="col-md-3 mb-4">
                <div id="filtresServiceComponent" 
                    data-categories="{{ json_encode($categories) }}" 
                    data-villes="{{ json_encode($villes) }}"
                    data-initial-filters="{{ json_encode([
                        'categorie' => request('categorie'),
                        'ville' => request('ville'),
                        'q' => request('q')
                    ]) }}">
                </div>
            </div>
            
            <!-- Liste des services -->
            <div class="col-md-9">
                <div id="listeServicesComponent" 
                    data-initial-services="{{ json_encode($services->items()) }}" 
                    data-current-page="{{ $services->currentPage() }}" 
                    data-last-page="{{ $services->lastPage() }}">
                </div>
            </div>
        </div>
    </div>
</x-layout>