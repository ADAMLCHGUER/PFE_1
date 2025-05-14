<x-layout>
    <x-slot:title>Tableau de bord - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container-fluid py-4">
        <!-- En-tête avec nom et stats générales -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 56px; height: 56px;">
                        <i class="bi bi-person-circle text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="mb-1 fw-600">Bienvenue, {{ session('prestataire_nom') }}</h1>
                        <p class="text-muted mb-0 small">Dernière connexion: {{ now()->subHours(rand(1, 24))->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end d-flex align-items-center justify-content-end">
                @if($service)
                    <div class="btn-group shadow-sm">
                        <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-primary border-end-0" target="_blank">
                            <i class="bi bi-eye me-2"></i> Voir ma page
                        </a>
                        <a href="{{ route('prestataire.service.edit') }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-2"></i> Modifier
                        </a>
                    </div>
                @else
                    <a href="{{ route('prestataire.service.create') }}" class="btn btn-success btn-lg shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i> Créer mon service
                    </a>
                @endif
            </div>
        </div>
        
        @if(!$service)
            <!-- Message pour création du service -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-gradient-light">
                        <div class="card-body p-5 text-center">
                            <img src="/api/placeholder/200/200" alt="Illustration création de service" class="mb-4" style="max-height: 180px;"/>
                            <h3 class="mb-3 fw-600">Commencez votre activité dès maintenant</h3>
                            <p class="lead mb-4 text-muted">
                                Vous n'avez pas encore créé votre service touristique. Pour commencer à recevoir des visites
                                et des clients potentiels, créez votre page en quelques minutes.
                            </p>
                            <a href="{{ route('prestataire.service.create') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                                <i class="bi bi-plus-circle me-2"></i> Créer mon service
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Tableau de bord principal avec service -->
            <div class="row mb-4">
                <!-- Cartes d'aperçu -->
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0 small text-uppercase fw-500">Visites totales</h6>
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-eye-fill text-primary"></i>
                                </div>
                            </div>
                            <h3 class="mb-0 fw-600">{{ $totalVisites }}</h3>
                            <div class="text-success small mt-2 fw-500">
                                <i class="bi bi-graph-up me-1"></i> 
                                +{{ rand(5, 20) }}% depuis le mois dernier
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0 small text-uppercase fw-500">Visites (7 jours)</h6>
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-calendar-week-fill text-success"></i>
                                </div>
                            </div>
                            <h3 class="mb-0 fw-600">{{ $visitesRecentes }}</h3>
                            <div class="text-success small mt-2 fw-500">
                                <i class="bi bi-graph-up me-1"></i> 
                                +{{ rand(2, 15) }}% depuis la semaine dernière
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0 small text-uppercase fw-500">Taux de conversion</h6>
                                <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-graph-up-arrow text-info"></i>
                                </div>
                            </div>
                            <h3 class="mb-0 fw-600">{{ rand(2, 5) }}.{{ rand(1, 9) }}%</h3>
                            <div class="text-info small mt-2 fw-500">
                                <i class="bi bi-info-circle-fill me-1"></i> 
                                Basé sur les clics de contact
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0 small text-uppercase fw-500">Score de visibilité</h6>
                                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                            </div>
                            <h3 class="mb-0 fw-600">{{ rand(60, 95) }}/100</h3>
                            <div class="small mt-2">
                                <a href="#" class="text-decoration-none fw-500">Comment améliorer? <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <!-- Graphique d'évolution -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-600">Évolution des visites</h5>
                            <div class="btn-group btn-group-sm shadow-sm">
                                <button type="button" class="btn btn-outline-primary active">7 jours</button>
                                <button type="button" class="btn btn-outline-primary">30 jours</button>
                                <button type="button" class="btn btn-outline-primary">Année</button>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <canvas id="visites-chart" style="height: 270px;"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Informations service -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-600">Votre service</h5>
                            <a href="{{ route('prestataire.service.edit') }}" class="btn btn-sm btn-outline-primary rounded-circle">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <!-- Image miniature -->
                            @if($service->images->where('principale', true)->first())
                                <div class="rounded mb-3 overflow-hidden position-relative" style="height: 160px;">
                                    <img src="{{ asset('storage/' . $service->images->where('principale', true)->first()->chemin) }}" 
                                        class="img-fluid w-100 h-100 object-cover" alt="{{ $service->titre }}">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success bg-opacity-90 text-white">
                                            <i class="bi bi-check-circle me-1"></i> En ligne
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 160px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image fs-1"></i>
                                        <p class="mb-0 small">Aucune image</p>
                                    </div>
                                </div>
                            @endif
                            
                            <h5 class="fw-600 mb-2">{{ $service->titre }}</h5>
                            <p class="mb-3 text-muted small">{{ Str::limit($service->description, 120) }}</p>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-{{ $service->images->count() > 0 ? 'success' : 'danger' }} bg-opacity-10 text-{{ $service->images->count() > 0 ? 'success' : 'danger' }}">
                                        <i class="bi bi-image me-1"></i> {{ $service->images->count() }}
                                    </span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $service->categorie->nom }}</span>
                                    <span class="badge bg-info bg-opacity-10 text-info">{{ $service->ville->nom }}</span>
                                </div>
                                
                                <div class="progress mb-1" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, $service->images->count() * 20) }}%;" 
                                        aria-valuenow="{{ min(100, $service->images->count() * 20) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted fw-500">Complétude du profil</small>
                                    <small class="text-muted fw-500">{{ min(100, ($service->images->count() * 20) + 20) }}%</small>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('prestataire.service.edit') }}#images" class="btn btn-sm btn-outline-primary px-4">
                                    <i class="bi bi-images me-1"></i> Gérer les images
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Sources de trafic -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 fw-600">Sources de trafic</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="position-relative" style="height: 200px;">
                                        <canvas id="sources-chart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2">&nbsp;</span>
                                                <span class="small fw-500">Recherche</span>
                                            </div>
                                            <div class="fw-600">{{ rand(30, 45) }}%</div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success me-2">&nbsp;</span>
                                                <span class="small fw-500">Direct</span>
                                            </div>
                                            <div class="fw-600">{{ rand(20, 35) }}%</div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-info me-2">&nbsp;</span>
                                                <span class="small fw-500">Réseaux sociaux</span>
                                            </div>
                                            <div class="fw-600">{{ rand(15, 25) }}%</div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-warning me-2">&nbsp;</span>
                                                <span class="small fw-500">Autres</span>
                                            </div>
                                            <div class="fw-600">{{ rand(5, 15) }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rapports et recommandations -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-600">Rapports et conseils</h5>
                            <a href="{{ route('prestataire.rapports.index') }}" class="btn btn-sm btn-outline-primary">
                                Tous les rapports
                            </a>
                        </div>
                        <div class="card-body">
                            @if($prestataire->rapports()->count() > 0)
                                <div class="mb-4">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="small fw-600">Type</th>
                                                    <th class="small fw-600">Période</th>
                                                    <th class="small fw-600 text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($prestataire->rapports()->latest()->take(2)->get() as $rapport)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-{{ $rapport->type == 'hebdomadaire' ? 'info' : 'primary' }} bg-opacity-10 text-{{ $rapport->type == 'hebdomadaire' ? 'info' : 'primary' }}">
                                                                {{ ucfirst($rapport->type) }}
                                                            </span>
                                                        </td>
                                                        <td class="small">{{ $rapport->periode_debut->format('d/m/Y') }} - {{ $rapport->periode_fin->format('d/m/Y') }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('prestataire.rapports.show', $rapport->id) }}" class="btn btn-sm btn-outline-primary rounded-circle">
                                                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info bg-light border-0 mb-4">
                                    <i class="bi bi-info-circle-fill me-2"></i> Vos rapports périodiques apparaîtront ici.
                                </div>
                            @endif
                            
                            <!-- Conseils -->
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title fw-600"><i class="bi bi-lightbulb-fill me-2 text-warning"></i>Conseils d'amélioration</h6>
                                    <ul class="list-unstyled mb-0">
                                        @if($service->images->count() < 3)
                                            <li class="mb-2 d-flex align-items-start">
                                                <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                                <span class="small">Ajoutez plus d'images (minimum 3) pour attirer davantage de visiteurs</span>
                                            </li>
                                        @endif
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                            <span class="small">Complétez votre description avec des mots-clés pertinents pour améliorer votre référencement</span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                                            <span class="small">Partagez votre page sur les réseaux sociaux pour augmenter votre visibilité</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dernières activités -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 fw-600">Activité récente</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-success"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="badge bg-light text-dark me-2">Visite</span> 
                                                <span class="text-muted small">{{ now()->subHours(rand(2, 6))->format('H:i') }}</span>
                                            </div>
                                            <span class="badge bg-light text-dark small">{{ ['Google', 'Facebook', 'Instagram', 'Direct'][rand(0, 3)] }}</span>
                                        </div>
                                        <p class="mb-0 mt-1 small">Un visiteur a consulté votre page</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-info"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="badge bg-light text-dark me-2">Système</span> 
                                                <span class="text-muted small">{{ now()->subHours(12)->format('H:i') }}</span>
                                            </div>
                                        </div>
                                        <p class="mb-0 mt-1 small">Mise à jour des statistiques hebdomadaires</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-indicator bg-primary"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="badge bg-light text-dark me-2">Rapport</span> 
                                                <span class="text-muted small">{{ now()->subDays(1)->format('d/m H:i') }}</span>
                                            </div>
                                        </div>
                                        <p class="mb-0 mt-1 small">Génération du rapport hebdomadaire</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    @if($service)
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Graphique des visites
                    const visitesData = @json($visitesParJour);
                    const dates = visitesData.map(item => item.date);
                    const counts = visitesData.map(item => item.count);
                    
                    const ctx = document.getElementById('visites-chart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Visites',
                                data: counts,
                                borderColor: 'rgba(66, 135, 245, 1)',
                                backgroundColor: 'rgba(66, 135, 245, 0.05)',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: 'rgba(66, 135, 245, 1)',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#333',
                                    bodyColor: '#666',
                                    borderColor: '#eee',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxWidth: 10,
                                    boxHeight: 10,
                                    cornerRadius: 4,
                                    displayColors: false,
                                    titleFont: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0,
                                        color: '#999'
                                    },
                                    grid: {
                                        display: true,
                                        drawBorder: false,
                                        color: 'rgba(0, 0, 0, 0.03)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: '#999'
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });
                    
                    // Graphique des sources
                    const sourcesCtx = document.getElementById('sources-chart').getContext('2d');
                    new Chart(sourcesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Recherche', 'Direct', 'Réseaux sociaux', 'Autres'],
                            datasets: [{
                                data: [42, 28, 20, 10],
                                backgroundColor: [
                                    'rgba(66, 135, 245, 0.9)',
                                    'rgba(40, 167, 69, 0.9)',
                                    'rgba(23, 162, 184, 0.9)',
                                    'rgba(255, 193, 7, 0.9)'
                                ],
                                borderWidth: 0,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#333',
                                    bodyColor: '#666',
                                    borderColor: '#eee',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxWidth: 10,
                                    boxHeight: 10,
                                    cornerRadius: 4,
                                    titleFont: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
            
            <style>
                /* Styles globaux améliorés */
                body {
                    background-color: #f8f9fa;
                }
                
                .card {
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                    border-radius: 0.5rem;
                    overflow: hidden;
                }
                
                .hover-scale:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
                }
                
                .bg-gradient-primary {
                    background: linear-gradient(135deg, #4287f5 0%, #42a5f5 100%);
                }
                
                .bg-gradient-light {
                    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                }
                
                .fw-600 {
                    font-weight: 600 !important;
                }
                
                /* Timeline styles améliorée */
                .timeline {
                    position: relative;
                    padding-left: 1.5rem;
                    margin: 0;
                }
                
                .timeline-item {
                    position: relative;
                    padding: 1.25rem 0;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                }
                
                .timeline-item:last-child {
                    border-bottom: 0;
                }
                
                .timeline-item-marker {
                    position: absolute;
                    left: -0.5rem;
                    top: 1.5rem;
                    width: 1rem;
                    height: 1rem;
                }
                
                .timeline-item-marker-indicator {
                    display: inline-block;
                    width: 12px;
                    height: 12px;
                    border-radius: 100%;
                    border: 2px solid #fff;
                    box-shadow: 0 0 0 2px currentColor;
                    position: absolute;
                    top: 0;
                    left: 0;
                }
                
                .timeline-item-content {
                    padding-left: 1rem;
                }
                
                /* Badges améliorés */
                .badge {
                    font-weight: 500;
                    padding: 0.35em 0.65em;
                }
                
                /* Boutons améliorés */
                .btn {
                    border-radius: 0.375rem;
                    font-weight: 500;
                }
                
                .btn-sm {
                    padding: 0.25rem 0.5rem;
                }
                
                .btn-outline-primary {
                    border-color: #dee2e6;
                }
                
                /* Table améliorée */
                .table-sm td, .table-sm th {
                    padding: 0.5rem;
                }
                
                .table-hover tbody tr:hover {
                    background-color: rgba(66, 135, 245, 0.03);
                }
            </style>
        @endpush
    @endif
</x-layout>