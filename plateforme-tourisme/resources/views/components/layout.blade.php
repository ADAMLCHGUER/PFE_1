<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Plateforme Tourisme Maroc' }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap CSS et Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('accueil') }}">
            <i class="bi bi-globe me-2"></i> Tourisme Maroc
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                @if(Session::has('prestataire_id'))
                    <!-- Utilisateur connecté -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Session::get('prestataire_nom') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('prestataire.tableau') }}"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</a></li>
                            <li><a class="dropdown-item" href="{{ route('prestataire.service.edit') }}"><i class="bi bi-shop me-2"></i> Mon service</a></li>
                            <li><a class="dropdown-item" href="{{ route('prestataire.statistiques') }}"><i class="bi bi-graph-up me-2"></i> Statistiques</a></li>
                            <li><a class="dropdown-item" href="{{ route('prestataire.rapports.index') }}"><i class="bi bi-file-text me-2"></i> Rapports</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('prestataire.deconnexion') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Utilisateur non connecté -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prestataire.connexion') ? 'active' : '' }}" href="{{ route('prestataire.connexion') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prestataire.inscription') ? 'active' : '' }}" href="{{ route('prestataire.inscription') }}">Inscription</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
    </header>

    <main>
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{ $slot }}
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Plateforme Tourisme Maroc</h5>
                    <p>Découvrez les meilleurs services touristiques au Maroc</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens Utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('accueil') }}" class="text-white">Accueil</a></li>
                        <li><a href="{{ route('services.index') }}" class="text-white">Services</a></li>
                        <li><a href="{{ route('prestataire.inscription') }}" class="text-white">Devenir prestataire</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <address>
                        <i class="bi bi-geo-alt"></i> Maroc<br>
                        <i class="bi bi-envelope"></i> <a href="mailto:contact@tourisme-maroc.com" class="text-white">contact@tourisme-maroc.com</a><br>
                        <i class="bi bi-telephone"></i> +212 123 456 789
                    </address>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Plateforme Tourisme Maroc. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>