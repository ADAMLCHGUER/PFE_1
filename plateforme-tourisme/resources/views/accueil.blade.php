<x-layout>
    <x-slot:title>Accueil - Plateforme Tourisme Maroc</x-slot>
    
    <!-- Bannière principale améliorée -->
<section class="hero-banner overflow-hidden position-relative mb-5">
    <div class="container position-relative z-index-1">
        <div class="row align-items-center min-vh-60 py-5">
            <div class="col-lg-6 pe-lg-5 wow fadeInLeft" data-wow-delay="0.3s">
                <h1 class="display-4 fw-bold text-white mb-4">Découvrez l'excellence touristique au Maroc</h1>
                <p class="lead text-white mb-4 opacity-75">Des expériences authentiques et des services premium pour un séjour mémorable.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('services.index') }}" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-bold shadow">
                        <i class="bi bi-search me-2"></i> Explorer les services
                    </a>
                    <a href="#destinations" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-bold">
                        <i class="bi bi-geo-alt me-2"></i> Nos destinations
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 wow fadeInRight" data-wow-delay="0.5s">
                <div class="position-relative">
                    <img src="{{ asset('storage/images/morocco-luxury.jpg') }}" alt="Tourisme de luxe au Maroc" class="img-fluid rounded-4 shadow-lg" style="transform: perspective(1000px) rotateY(-10deg);">
                    <div class="position-absolute bottom-0 start-0 translate-middle-y ms-4">
                        <div class="bg-white p-3 rounded-3 shadow-sm d-inline-block">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-2 me-2">
                                    <i class="bi bi-star-fill text-white fs-5"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold text-dark">4.9/5</p>
                                    <small class="text-muted">+500 avis clients</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Overlay et effet de dégradé -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div class="position-absolute bottom-0 start-0 w-100 h-50" style="background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, transparent 100%);"></div>
    
    <!-- Formes décoratives -->
    <div class="position-absolute top-0 end-0 w-50 h-100" style="background: radial-gradient(circle at 70% 30%, rgba(255,255,255,0.1) 0%, transparent 70%);"></div>
</section>

<style>
    .hero-banner {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        border-radius: 1rem;
        overflow: hidden;
        position: relative;
    }
    
    .min-vh-60 {
        min-height: 60vh;
    }
    
    .z-index-1 {
        z-index: 1;
    }
    
    .wow {
        visibility: hidden;
    }
    
    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.03)" d="M0,0 L100,0 L100,100 Q50,80 0,100 Z"></path></svg>');
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-position: bottom;
        opacity: 0.5;
    }
</style>

<!-- Script pour les animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    new WOW().init();
</script>
    
    
    
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
                        @if($service->images && $service->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $service->images->first()->chemin) }}" class="card-img-top" alt="{{ $service->titre }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->titre }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($service->description, 100) }}</p>
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