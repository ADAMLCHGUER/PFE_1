<x-layout>
    <x-slot:title>{{ isset($service) ? 'Modifier mon service' : 'Créer mon service' }} - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ isset($service) ? 'Modifier mon service' : 'Créer mon service' }}</h1>
            <a href="{{ route('prestataire.tableau') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour au tableau de bord
            </a>
        </div>
        
        <div id="formulaireServiceComponent" 
            data-service="{{ isset($service) ? json_encode($service->load(['images'])) : '' }}"
            data-categories="{{ json_encode($categories) }}"
            data-villes="{{ json_encode($villes) }}">
        </div>
        
        @if(!isset($service))
            <div class="alert alert-info mt-4">
                <h5><i class="bi bi-info-circle me-2"></i> Information</h5>
                <p class="mb-0">
                    En tant que prestataire, vous pouvez créer un seul service touristique. Prenez le temps de bien remplir toutes les informations
                    pour mettre en valeur votre offre.
                </p>
            </div>
        @endif
    </div>
</x-layout>