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
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filtres</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('services.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->slug }}" {{ request('categorie') == $categorie->slug ? 'selected' : '' }}>
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
                                        <option value="{{ $ville->slug }}" {{ request('ville') == $ville->slug ? 'selected' : '' }}>
                                            {{ $ville->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Recherche</label>
                                <input type="text" name="q" class="form-control" placeholder="Mots-clés..." value="{{ request('q') }}">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i> Filtrer
                                </button>
                                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i> Réinitialiser
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Liste des services -->
            <div class="col-md-9">
                @if($services->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Aucun service ne correspond à votre recherche.
                    </div>
                @else
                    <div class="mb-3">
                        <p class="text-muted">{{ $services->total() }} résultat(s) trouvé(s)</p>
                    </div>
                    
                    <div class="row">
                        @foreach($services as $service)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm hover-shadow border-0">
                                    <div class="position-relative">
                                        @if($service->images && $service->images->isNotEmpty())
                                            @php 
                                                $imagePrincipale = $service->images->where('principale', true)->first();
                                                if (!$imagePrincipale) {
                                                    $imagePrincipale = $service->images->first();
                                                }
                                            @endphp
                                            <img src="{{ asset('storage/' . $imagePrincipale->chemin) }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $service->titre }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="bg-light text-center py-5">
                                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                                {{ $service->categorie->nom }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $service->titre }}</h5>
                                        <p class="card-text text-muted mb-3">{{ Str::limit($service->description, 100) }}</p>
                                        
                                        <div class="d-flex justify-content-between mt-auto">
                                            <div>
                                                <i class="bi bi-geo-alt text-secondary me-1"></i>
                                                <span class="text-muted small">{{ $service->ville->nom }}</span>
                                            </div>
                                            <div>
                                                <i class="bi bi-building text-secondary me-1"></i>
                                                <span class="text-muted small">{{ $service->prestataire->nom_entreprise }}</span>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-grid">
                                            <a href="{{ route('services.show', $service->slug) }}"
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-eye me-2"></i> Voir les détails
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $services->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            transition: all 0.3s ease;
        }
        
        .badge {
            transition: all 0.3s ease;
        }
        
        .card:hover .badge {
            transform: scale(1.05);
        }
    </style>
</x-layout>