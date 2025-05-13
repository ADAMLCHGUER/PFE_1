<x-layout>
    <x-slot:title>Rapports - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Rapports</h1>
            <a href="{{ route('prestataire.tableau') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour au tableau de bord
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                @if($rapports->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rapports as $rapport)
                                    <tr>
                                        <td>{{ $rapport->id }}</td>
                                        <td>{{ $rapport->titre }}</td>
                                        <td>{{ $rapport->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('prestataire.rapports.show', $rapport->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $rapports->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> Aucun rapport n'est disponible pour le moment.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>