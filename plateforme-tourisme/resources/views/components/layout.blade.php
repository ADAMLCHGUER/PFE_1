<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Plateforme Tourisme Maroc' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Bootstrap CSS et Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--dark-color);
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            font-size: 1.8rem;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-color);
            padding-left: 1.25rem;
        }
        
        main {
            flex: 1;
        }
        
        footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 3rem 0 1.5rem;
        }
        
        footer a {
            color: var(--light-color);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        footer a:hover {
            color: var(--secondary-color);
        }
        
        footer h5 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 1.25rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        .alert {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .btn-outline-primary {
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .hero-section {
            background: url('/images/morocco-hero.jpg') no-repeat center center;
            background-size: cover;
            padding: 5rem 0;
            position: relative;
            color: white;
            margin-bottom: 3rem;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('accueil') }}">
                    <i class="bi bi-globe-europe-africa me-2"></i> Tourisme Maroc
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('accueil') ? 'active' : '' }}" href="{{ route('accueil') }}">
                                <i class="bi bi-house-door me-1"></i> Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                                <i class="bi bi-gear me-1"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#destinations">
                                <i class="bi bi-map me-1"></i> Destinations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#experiences">
                                <i class="bi bi-star me-1"></i> Expériences
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav ms-auto">
                        @if(Session::has('prestataire_id'))
                            <!-- Utilisateur connecté -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>
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
                                <a class="nav-link btn btn-outline-light me-2 {{ request()->routeIs('prestataire.connexion') ? 'active' : '' }}" href="{{ route('prestataire.connexion') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary {{ request()->routeIs('prestataire.inscription') ? 'active' : '' }}" href="{{ route('prestataire.inscription') }}">
                                    <i class="bi bi-person-plus me-1"></i> Inscription
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="container mt-4 animate__animated animate__fadeInDown">
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4 animate__animated animate__fadeInDown">
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container mt-4 animate__animated animate__fadeInDown">
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5>Plateforme Tourisme Maroc</h5>
                    <p class="mt-3">Découvrez les merveilles du Maroc à travers nos services touristiques exceptionnels et nos expériences authentiques.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Liens Rapides</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><a href="{{ route('accueil') }}">Accueil</a></li>
                        <li class="mb-2"><a href="{{ route('services.index') }}">Services</a></li>
                        <li class="mb-2"><a href="#destinations">Destinations</a></li>
                        <li class="mb-2"><a href="#experiences">Expériences</a></li>
                        <li><a href="{{ route('prestataire.inscription') }}">Devenir prestataire</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Contactez-nous</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3"><i class="bi bi-geo-alt-fill me-2"></i> 123 Avenue Mohammed V, Rabat, Maroc</li>
                        <li class="mb-3"><i class="bi bi-envelope-fill me-2"></i> <a href="mailto:contact@tourisme-maroc.com">contact@tourisme-maroc.com</a></li>
                        <li><i class="bi bi-telephone-fill me-2"></i> +212 123 456 789</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Newsletter</h5>
                    <p class="mt-3">Abonnez-vous pour recevoir nos offres spéciales et actualités.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Votre email" aria-label="Votre email">
                            <button class="btn btn-primary" type="button"><i class="bi bi-send"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} Plateforme Tourisme Maroc. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#">Politique de confidentialité</a></li>
                        <li class="list-inline-item"><span class="mx-2">•</span></li>
                        <li class="list-inline-item"><a href="#">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary btn-lg back-to-top position-fixed bottom-0 end-0 m-4 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; display: none;">
        <i class="bi bi-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Back to top button
        window.addEventListener('scroll', function() {
            var backToTopButton = document.querySelector('.back-to-top');
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        
        document.querySelector('.back-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
        
        // Animation for alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('animate__fadeOut');
                    setTimeout(() => {
                        alert.remove();
                    }, 1000);
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>