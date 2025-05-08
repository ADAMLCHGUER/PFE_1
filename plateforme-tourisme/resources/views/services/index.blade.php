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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filtres</h5>
                        <form action="{{ route('services.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ville</label>
                                <select name="ville" class="form-select">
                                    <option value="">Toutes les villes</option>
                                    @foreach($villes as $ville)
                                        <option value="{{ $ville->id }}" {{ request('ville') == $ville->id ? 'selected' : '' }}>
                                            {{ $ville->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Liste des services -->
            <div class="col-md-9">
                @if($services->isEmpty())
                    <div class="alert alert-info">
                        Aucun service disponible pour le moment.
                    </div>
                @else
                    <div class="row">
                        @foreach($services as $service)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $service->nom }}"
                                             style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->nom }}</h5>
                                        <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-primary">{{ $service->categorie->nom }}</span>
                                            <span class="text-muted">{{ $service->ville->nom }}</span>
                                        </div>
                                        <hr>
                                        <a href="{{ route('services.show', $service) }}" 
                                           class="btn btn-outline-primary">
                                            Voir les détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>