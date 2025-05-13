<x-layout>
    <x-slot:title>Accueil - Plateforme Tourisme Maroc</x-slot>
    
    <!-- Bannière principale -->
    <div class="bg-primary text-white py-5 mb-5 rounded">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4">Découvrez les meilleurs services touristiques au Maroc</h1>
                    <p class="lead">Explorez une sélection de prestations de qualité pour rendre votre séjour inoubliable.</p>
                    <a href="{{ route('services.index') }}" class="btn btn-light btn-lg">Explorer les services</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/morocco-banner.jpg') }}" alt="Tourisme au Maroc" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Catégories populaires -->
    <div class="container mb-5">
        <h2 class="mb-4">Catégories populaires</h2>
        <div class="row">
            @foreach($categories as $categorie)
                <div class="col-md-4 col-lg-3 mb-4">
                    <a href="{{ route('services.index', ['categorie' => $categorie->slug]) }}" class="text-decoration-none">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-{{ $categorie->icone ?? 'tag' }} display-4 text-primary"></i>
                                <h5 class="card-title mt-3">{{ $categorie->nom }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($categorie->description, 60) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Villes populaires -->
    <div class="container mb-5">
        <h2 class="mb-4">Découvrez les destinations</h2>
        <div class="row">
            @foreach($villesPopulaires as $ville)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('services.index', ['ville' => $ville->slug]) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $ville->image) }}" class="card-img-top" alt="{{ $ville->nom }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ville->nom }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($ville->description, 100) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    

    <!-- Services populaires -->
    <div class="container mb-5">
        <h2 class="mb-4">Services populaires</h2>
        <div class="row">
            @foreach($servicesPopulaires as $service)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none">

                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->nom }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->nom }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($service->description, 100) }}</p>
                                <p class="card-text text-primary font-weight-bold">{{ $service->prix }} MAD</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Call to action pour les prestataires -->
    <div class="container mb-5">
        <div class="bg-secondary text-white p-5 rounded">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>Vous êtes prestataire de services touristiques ?</h2>
                    <p class="lead">Rejoignez notre plateforme pour mettre en valeur vos services et attirer plus de clients.</p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="{{ route('prestataire.inscription') }}" class="btn btn-light btn-lg">Devenir prestataire</a>
                </div>
            </div>
        </div>
    </div>
</x-layout>