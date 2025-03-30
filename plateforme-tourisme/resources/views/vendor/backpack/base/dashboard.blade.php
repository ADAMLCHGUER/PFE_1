@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Statistiques Globales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="card mb-4 bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="la la-users"></i> Prestataires</h5>
                                <p class="card-text display-4">{{ $stats['prestataires_total'] }}</p>
                                <div class="text-small">
                                    <span>{{ $stats['prestataires_valides'] }} validés</span> |
                                    <span>{{ $stats['prestataires_en_attente'] }} en attente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="card mb-4 bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="la la-concierge-bell"></i> Services</h5>
                                <p class="card-text display-4">{{ $stats['services_total'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="card mb-4 bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="la la-eye"></i> Visites</h5>
                                <p class="card-text display-4">{{ $stats['visites_total'] }}</p>
                                <div class="text-small">
                                    <span>{{ $stats['visites_mois'] }} ce mois-ci</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Prestataires Récents</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Nom Entreprise</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prestatairesRecents as $prestataire)
                            <tr>
                                <td>{{ $prestataire->nom_entreprise }}</td>
                                <td>
                                    @if($prestataire->statut == 'valide')
                                        <span class="badge bg-success">Validé</span>
                                    @elseif($prestataire->statut == 'en_revision')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">Refusé</span>
                                    @endif
                                </td>
                                <td>{{ $prestataire->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ backpack_url('prestataire/'.$prestataire->id.'/show') }}" class="btn btn-sm btn-link">
                                        <i class="la la-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Services les Plus Visités</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
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
                                <td>{{ $service->titre }}</td>
                                <td>{{ $service->prestataire->nom_entreprise }}</td>
                                <td>{{ $service->ville->nom }}</td>
                                <td><span class="badge bg-info">{{ $service->visites_count }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Visites des 15 Derniers Jours</h5>
            </div>
            <div class="card-body">
                <canvas id="visites-chart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Préparer les données pour le graphique
    const visitesData = @json($visitesParJour);
    const dates = visitesData.map(item => item.date);
    const counts = visitesData.map(item => item.count);
    
    // Créer le graphique
    const ctx = document.getElementById('visites-chart').getContext('2d');
    const visitesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Nombre de visites',
                data: counts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
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
</script>
@endpush