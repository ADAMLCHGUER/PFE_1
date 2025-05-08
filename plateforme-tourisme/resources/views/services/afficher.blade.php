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
        
        <div id="detailServiceComponent" data-service="{{ json_encode($service->load(['prestataire', 'categorie', 'ville', 'images'])) }}">
            <h1 class="mb-4">{{ $service->titre }}</h1>
            <p><strong>Description:</strong> {{ $service->description }}</p>
            <p><strong>Prestataire:</strong> {{ $service->prestataire->nom }}</p>
            <p><strong>Catégorie:</strong> {{ $service->categorie->nom }}</p>
            <p><strong>Ville:</strong> {{ $service->ville->nom }}</p>
            <div class="mt-4">
            <h5>Images:</h5>
            <div class="row">
                @foreach ($service->images as $image)
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Image" class="img-fluid rounded">
                </div>
                @endforeach
            </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour aux services
            </a>
        </div>
    </div>
</x-layout>