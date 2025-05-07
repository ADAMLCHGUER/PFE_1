<x-layout>
    <x-slot:title>Tableau de bord - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="mb-3">Bienvenue, {{ session('prestataire_nom') }}</h1>
                <p class="lead">Gérez votre service et consultez vos statistiques.</p>
            </div>
            <div class="col-md-4 text-end">
                @if($service)
                    <a href="{{ route('prestataire.service.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-2"></i> Modifier mon service
                    </a>
                @else
                    <a href="{{ route('prestataire.service.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i> Créer mon service
                    </a>
                @endif
            </div>
        </div>
        
        @if(!$service)
            <div class="alert alert-info">
                <h4 class="alert-heading">Bienvenue sur votre espace prestataire !</h4>
                <p>Vous n'avez pas encore créé votre service touristique.</p>
                <hr>
                <p class="mb-0">Pour commencer, créez votre service en cliquant sur le bouton "Créer mon service".</p>
            </div>
        @else
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informations de votre service</h5>
                        </div>
                        <div class="card-body">
                            <h4>{{ $service->titre }}</h4>
                            <p>{{ Str::limit($service->description, 150) }}</p>
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Catégorie</dt>
                                <dd class="col-sm-8">{{ $service->categorie->nom }}</dd>
                                
                                <dt class="col-sm-4">Ville</dt>
                                <dd class="col-sm-8">{{ $service->ville->nom }}</dd>
                                
                                <dt class="col-sm-4">Adresse</dt>
                                <dd class="col-sm-8">{{ $service->adresse }}</dd>
                            </dl>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-eye me-1"></i> Voir la page publique
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Statistiques rapides</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-6 mb-3">
                                    <h2 class="mb-0">{{ $totalVisites }}</h2>
                                    <p class="text-muted">Visites totales</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h2 class="mb-0">{{ $visitesRecentes }}</h2>
                                    <p class="text-muted">7 derniers jours</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <canvas id="visites-chart" width="100%" height="200"></canvas>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('prestataire.statistiques') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-graph-up me-1"></i> Statistiques détaillées
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Derniers rapports</h5>
                        </div>
                        <div class="card-body">
                            @if($prestataire->rapports()->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Période</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prestataire->rapports()->latest()->take(3)->get() as $rapport)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-{{ $rapport->type == 'hebdomadaire' ? 'info' : 'primary' }}">
                                                            {{ ucfirst($rapport->type) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $rapport->periode_debut->format('d/m/Y') }} - {{ $rapport->periode_fin->format('d/m/Y') }}</td>
                                                    <td>{{ $rapport->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('prestataire.rapports.show', $rapport->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                            <i class="bi bi-file-earmark-pdf me-1"></i> Voir
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted mb-0">Aucun rapport n'est disponible pour le moment.</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('prestataire.rapports.index') }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-journals me-1"></i> Tous les rapports
                            </a>
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
                                borderColor: '#28a745',
                                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        @endpush
    @endif
</x-layout>