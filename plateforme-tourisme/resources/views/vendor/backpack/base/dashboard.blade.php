@extends(backpack_view('blank'))

@push('after_styles')
<style>
    /* Design moderne avec des ombres et des transitions */
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        height: 100%;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
    
    .card-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 3.5rem;
        opacity: 0.2;
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover .card-icon {
        opacity: 0.35;
        transform: scale(1.1);
    }
    
    .stat-value {
        font-weight: 800;
        color: #fff;
        font-size: 3.2rem;
        line-height: 1.1;
    }
    
    .chart-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    
    .dashboard-header {
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 100%);
        pointer-events: none;
    }
    
    .metric-card {
        display: flex;
        align-items: center;
        padding: 8px 0;
    }
    
    .metric-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 12px;
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .kpi-title {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 2px;
        opacity: 0.9;
    }
    
    .kpi-value {
        font-size: 1.1rem;
        font-weight: 700;
    }
    
    .card-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .card-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    
    .card-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    }
    
    .data-table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .progress-sm {
        height: 6px;
        border-radius: 3px;
    }
    
    .badge-outline-primary {
        color: #4e73df;
        border: 1px solid #4e73df;
        background-color: rgba(78, 115, 223, 0.1);
    }
    
    .badge-outline-success {
        color: #1cc88a;
        border: 1px solid #1cc88a;
        background-color: rgba(28, 200, 138, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    {{-- Dashboard Header --}}
    

    {{-- Global Statistics Row --}}
    <div class="row">
        {{-- Providers Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card dashboard-card card-gradient-primary text-white position-relative h-100">
                <div class="card-body pb-0">
                    <h5 class="card-title text-uppercase font-weight-bold mb-3">
                        <i class="la la-users mr-2"></i>Prestataires
                    </h5>
                    <div class="card-icon">
                        <i class="la la-users"></i>
                    </div>
                    <p class="card-text stat-value mb-2">
                        {{ $stats['prestataires_total'] }}
                    </p>
                    
                    <div class="mb-4 small d-flex align-items-center">
                        @if($stats['prestataires_croissance'] > 0)
                            <i class="la la-arrow-up mr-1"></i>
                        @elseif($stats['prestataires_croissance'] < 0)
                            <i class="la la-arrow-down mr-1"></i>
                        @else
                            <i class="la la-equals mr-1"></i>
                        @endif
                        <span>{{ abs($stats['prestataires_croissance']) }}% par rapport au mois dernier</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-check-circle"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">Validés</div>
                                    <div class="kpi-value">{{ $stats['prestataires_valides'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-clock"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">En attente</div>
                                    <div class="kpi-value">{{ $stats['prestataires_en_attente'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Services Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card dashboard-card card-gradient-success text-white position-relative h-100">
                <div class="card-body pb-0">
                    <h5 class="card-title text-uppercase font-weight-bold mb-3">
                        <i class="la la-concierge-bell mr-2"></i>Services
                    </h5>
                    <div class="card-icon">
                        <i class="la la-concierge-bell"></i>
                    </div>
                    <p class="card-text stat-value mb-2">
                        {{ $stats['services_total'] }}
                    </p>
                    
                    <div class="progress progress-sm mb-3 bg-white bg-opacity-25">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-map-marker"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">Villes</div>
                                    <div class="kpi-value">{{ $stats['villes_total'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-tags"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">Catégories</div>
                                    <div class="kpi-value">{{ $stats['categories_total'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visits Card --}}
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card dashboard-card card-gradient-info text-white position-relative h-100">
                <div class="card-body pb-0">
                    <h5 class="card-title text-uppercase font-weight-bold mb-3">
                        <i class="la la-eye mr-2"></i>Visites
                    </h5>
                    <div class="card-icon">
                        <i class="la la-eye"></i>
                    </div>
                    <p class="card-text stat-value mb-2">
                        {{ $stats['visites_total'] }}
                    </p>
                    
                    <div class="mb-4 small d-flex align-items-center">
                        @if($stats['visites_croissance'] > 0)
                            <i class="la la-arrow-up mr-1"></i>
                        @elseif($stats['visites_croissance'] < 0)
                            <i class="la la-arrow-down mr-1"></i>
                        @else
                            <i class="la la-equals mr-1"></i>
                        @endif
                        <span>{{ abs($stats['visites_croissance']) }}% par rapport au mois dernier</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">Ce mois</div>
                                    <div class="kpi-value">{{ $stats['visites_mois'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="metric-card">
                                <div class="metric-icon">
                                    <i class="la la-chart-line"></i>
                                </div>
                                <div>
                                    <div class="kpi-title">Croissance</div>
                                    <div class="kpi-value">{{ $stats['visites_croissance'] }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Visits & Status Charts Row --}}
    <div class="row mb-4">
        {{-- Visits Chart --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-chart-area mr-2"></i>Évolution des Visites
                    </h5>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Période">
                        <button type="button" class="btn btn-outline-primary active">Semaine</button>
                        <button type="button" class="btn btn-outline-primary">Mois</button>
                        <button type="button" class="btn btn-outline-primary">Trimestre</button>
                    </div>
                </div>
                <div class="card-body chart-container">
                    <canvas id="visites-chart" height="280"></canvas>
                </div>
            </div>
        </div>
        
        {{-- Status Distribution Chart --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-chart-pie mr-2"></i>Statut des Prestataires
                    </h5>
                </div>
                <div class="card-body chart-container">
                    <canvas id="status-chart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Geographic & Category Distribution Row --}}
    <div class="row mb-4">
        {{-- Service by City --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-map-marker-alt mr-2"></i>Services par Ville
                    </h5>
                    <a href="{{ backpack_url('ville') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 data-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Ville</th>
                                    <th>Services</th>
                                    <th>%</th>
                                    <th>Répartition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalServices = $stats['services_total'];
                                @endphp
                                
                                @foreach($servicesParVille as $serviceVille)
                                <tr>
                                    <td class="font-weight-bold">{{ $serviceVille->ville->nom }}</td>
                                    <td>{{ $serviceVille->total }}</td>
                                    <td>{{ $totalServices > 0 ? round(($serviceVille->total / $totalServices) * 100, 1) : 0 }}%</td>
                                    <td>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width: {{ $totalServices > 0 ? ($serviceVille->total / $totalServices) * 100 : 0 }}%" 
                                                aria-valuenow="{{ $serviceVille->total }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="{{ $totalServices }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Services by Category --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-tag mr-2"></i>Services par Catégorie
                    </h5>
                    <a href="{{ backpack_url('categorie') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
                <div class="card-body">
                    <canvas id="categorie-chart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed Tables Row --}}
    <div class="row">
        {{-- Recent Providers Table --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-users mr-2"></i>Prestataires Récents
                    </h5>
                    <a href="{{ backpack_url('prestataire') }}" class="btn btn-sm btn-outline-primary">
                        Voir tous
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 data-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Entreprise</th>
                                    <th>Statut</th>
                                    <th>Services</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestatairesRecents as $prestataire)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light rounded-circle text-primary mr-3 d-flex align-items-center justify-content-center">
                                                <i class="la la-building"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $prestataire->nom_entreprise }}</strong>
                                                <small class="d-block text-muted">
                                                    Ajouté le {{ $prestataire->created_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($prestataire->statut)
                                            @case('valide')
                                                <span class="badge badge-success">Validé</span>
                                                @break
                                            @case('en_revision')
                                                <span class="badge badge-warning text-dark">En attente</span>
                                                @break
                                            @default
                                                <span class="badge badge-danger">Refusé</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $prestataire->services_count ?? 0 }} services
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ backpack_url('prestataire/'.$prestataire->id.'/show') }}" 
                                            class="btn btn-sm btn-outline-primary">
                                                <i class="la la-eye"></i>
                                            </a>
                                            <a href="{{ backpack_url('prestataire/'.$prestataire->id.'/edit') }}" 
                                            class="btn btn-sm btn-outline-info">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Most Popular Services Table --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="la la-star mr-2"></i>Services Populaires
                    </h5>
                    <a href="{{ backpack_url('service') }}" class="btn btn-sm btn-outline-primary">
                        Voir tous
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 data-table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Service</th>
                                    <th>Prestataire</th>
                                    <th>Ville</th>
                                    <th>Visites</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicesPopulaires as $service)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light rounded-circle text-info mr-3 d-flex align-items-center justify-content-center">
                                                <i class="la {{ $service->categorie->icon ?? 'la-concierge-bell' }}"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $service->titre }}</strong>
                                                <small class="d-block text-muted">
                                                    {{ $service->categorie->nom }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $service->prestataire->nom_entreprise }}</td>
                                    <td>
                                        <span class="badge badge-outline-primary">
                                            {{ $service->ville->nom }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-success">
                                            {{ $service->visites_count }} visites
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Évolution des visites
        const visitesCtx = document.getElementById('visites-chart').getContext('2d');
        const visitesData = @json($visitesParJour);
        const visitesGradient = visitesCtx.createLinearGradient(0, 0, 0, 400);
        visitesGradient.addColorStop(0, 'rgba(78, 115, 223, 0.4)');
        visitesGradient.addColorStop(1, 'rgba(78, 115, 223, 0.0)');
        
        new Chart(visitesCtx, {
            type: 'line',
            data: {
                labels: visitesData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('fr-FR', {day: '2-digit', month: 'short'});
                }),
                datasets: [{
                    label: 'Nombre de Visites',
                    data: visitesData.map(item => item.count),
                    backgroundColor: visitesGradient,
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                    tension: 0.4,
                    fill: true
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
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 16,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        callbacks: {
                            title: function(tooltipItems) {
                                return 'Le ' + tooltipItems[0].label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Répartition des prestataires par statut
        const statusCtx = document.getElementById('status-chart').getContext('2d');
        const statusData = @json($prestatairesParStatut);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Validés', 'En attente', 'Non validés'],
                datasets: [{
                    data: [statusData.valide, statusData.en_revision, statusData.non_valide],
                    backgroundColor: [
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(246, 194, 62, 0.8)',
                        'rgba(231, 74, 59, 0.8)'
                    ],
                    borderColor: [
                        'rgba(28, 200, 138, 1)',
                        'rgba(246, 194, 62, 1)',
                        'rgba(231, 74, 59, 1)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Services par catégorie
        const categorieCtx = document.getElementById('categorie-chart').getContext('2d');
        const categorieData = @json($servicesParCategorie);
        
        new Chart(categorieCtx, {
            type: 'bar',
            data: {
                labels: categorieData.map(item => item.categorie.nom),
                datasets: [{
                    label: 'Nombre de services',
                    data: categorieData.map(item => item.total),
                    backgroundColor: [
                        'rgba(78, 115, 223, 0.8)',
                        'rgba(28, 200, 138, 0.8)',
                        'rgba(54, 185, 204, 0.8)',
                        'rgba(246, 194, 62, 0.8)',
                        'rgba(231, 74, 59, 0.8)'
                    ],
                    borderColor: [
                        'rgba(78, 115, 223, 1)',
                        'rgba(28, 200, 138, 1)',
                        'rgba(54, 185, 204, 1)',
                        'rgba(246, 194, 62, 1)',
                        'rgba(231, 74, 59, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value / total) * 100);
                                return `${value} services (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
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