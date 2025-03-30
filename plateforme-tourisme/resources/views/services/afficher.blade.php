<x-layout>
    <x-slot:title>{{ $service->titre }} - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->titre }}</li>
            </ol>
        </nav>
        
        <div id="detailServiceComponent" data-service="{{ json_encode($service->load(['prestataire', 'categorie', 'ville', 'images'])) }}"></div>
        
        <div class="text-center mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour aux services
            </a>
        </div>
    </div>
</x-layout>