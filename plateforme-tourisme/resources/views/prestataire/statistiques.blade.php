<x-layout>
    <x-slot:title>Statistiques - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Statistiques de votre service</h1>
            <a href="{{ route('prestataire.tableau') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour au tableau de bord
            </a>
        </div>
        
        <!-- Cartes de résumé -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Visites totales</h5>
                        <p class="display-4">{{ $totalVisites }}</p>
                        <p class="text-muted mb-0">Nombre total de visites sur votre page</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Visiteurs uniques</h5>
                        <p class="display-4">{{ $visitesUniques }}</p>
                        <p class="text-muted mb-0">Basé sur les adresses IP uniques</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Graphique des visites mensuelles -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Visites par mois (12 derniers mois)</h5>
            </div>
            <div class="card-body">
                @if(count($mois) > 0)
                    <canvas id="visitesChart" height="300"></canvas>
                @else
                    <div class="alert alert-info mb-0">
                        Pas assez de données pour afficher le graphique. Les statistiques seront disponibles dès que vous aurez reçu des visites.
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sources de trafic -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sources de trafic</h5>
            </div>
            <div class="card-body">
                @if($sources->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Visites</th>
                                    <th>Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sources as $source)
                                    <tr>
                                        <td>{{ $source['source'] }}</td>
                                        <td>{{ $source['count'] }}</td>
                                        <td>
                                            @php
                                                $percentage = $totalVisites > 0 ? round(($source['count'] / $totalVisites) * 100, 1) : 0;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $percentage }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        Aucune donnée sur les sources de trafic n'est disponible pour le moment.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(count($mois) > 0)
                const ctx = document.getElementById('visitesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($mois),
                        datasets: [{
                            label: 'Nombre de visites',
                            data: @json($compteurs),
                            backgroundColor: 'rgba(13, 110, 253, 0.2)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 2,
                            tension: 0.2,
                            pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            },
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            @endif
        });
    </script>
    @endpush
</x-layout>