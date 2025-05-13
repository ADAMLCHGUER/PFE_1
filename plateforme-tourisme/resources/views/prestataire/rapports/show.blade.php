<x-layout>
    <x-slot:title>Rapport #{{ $rapport->id }} - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Rapport #{{ $rapport->id }}</h1>
            <a href="{{ route('prestataire.rapports.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour aux rapports
            </a>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">{{ $rapport->titre }}</h2>
                <p class="text-muted">Généré le {{ $rapport->created_at->format('d/m/Y à H:i') }}</p>
                
                <hr>
                
                <div class="rapport-content">
                    {!! $rapport->contenu !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>