<x-layout>
    <x-slot:title>{{ isset($service) ? 'Modifier mon service' : 'Créer mon service' }} - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ isset($service) ? 'Modifier mon service' : 'Créer mon service' }}</h1>
            <a href="{{ route('prestataire.tableau') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left me-2"></i> Retour au tableau de bord
            </a>
        </div>
        
        <div class="alert alert-info mb-4">
            <h5><i class="bi bi-info-circle me-2"></i> Information</h5>
            <p class="mb-0">
                En tant que prestataire, vous pouvez créer un seul service touristique. Prenez le temps de bien remplir toutes les informations
                pour mettre en valeur votre offre.
            </p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ isset($service) ? route('prestataire.service.update') : route('prestataire.service.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($service))
                        @method('PUT')
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Informations générales</h4>
                            <hr>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre du service *</label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', isset($service) ? $service->titre : '') }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categorie_id" class="form-label">Catégorie *</label>
                                <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id', isset($service) ? $service->categorie_id : '') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ville_id" class="form-label">Ville *</label>
                                <select class="form-select @error('ville_id') is-invalid @enderror" id="ville_id" name="ville_id" required>
                                    <option value="">Sélectionner une ville</option>
                                    @foreach($villes as $ville)
                                        <option value="{{ $ville->id }}" {{ old('ville_id', isset($service) ? $service->ville_id : '') == $ville->id ? 'selected' : '' }}>
                                            {{ $ville->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ville_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse complète *</label>
                                <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse', isset($service) ? $service->adresse : '') }}" required>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description détaillée *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', isset($service) ? $service->description : '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="prestations" class="form-label">Services et prestations offerts *</label>
                                <textarea class="form-control @error('prestations') is-invalid @enderror" id="prestations" name="prestations" rows="3" required>{{ old('prestations', isset($service) ? $service->prestations : '') }}</textarea>
                                <small class="text-muted">Listez ici les différents services que vous proposez.</small>
                                @error('prestations')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Coordonnées de contact</h4>
                            <hr>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone *</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', isset($service) ? $service->telephone : '') }}" required>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', isset($service) ? $service->email : '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_web" class="form-label">Site web (optionnel)</label>
                                <input type="url" class="form-control @error('site_web') is-invalid @enderror" id="site_web" name="site_web" value="{{ old('site_web', isset($service) ? $service->site_web : '') }}">
                                @error('site_web')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="coordonnees" class="form-label">Coordonnées GPS (optionnel)</label>
                                <input type="text" class="form-control @error('coordonnees') is-invalid @enderror" id="coordonnees" name="coordonnees" value="{{ old('coordonnees', isset($service) ? $service->coordonnees : '') }}" placeholder="Ex: 34.0522, -118.2437">
                                <small class="text-muted">Format: latitude, longitude</small>
                                @error('coordonnees')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Horaires d'ouverture</h4>
                            <hr>
                        </div>
                    </div>
                    
                    @php
                        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
                        $horaires = isset($service) && $service->horaires ? $service->horaires : [];
                    @endphp
                    
                    @foreach($jours as $jour)
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-2">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input jour-check" name="horaires[{{ $jour }}][ouvert]" value="1" {{ isset($horaires[$jour]['ouvert']) && $horaires[$jour]['ouvert'] ? 'checked' : '' }}>
                                    <strong>{{ ucfirst($jour) }}</strong>
                                </label>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text">De</span>
                                    <input type="time" class="form-control" name="horaires[{{ $jour }}][ouverture]" value="{{ $horaires[$jour]['ouverture'] ?? '09:00' }}" {{ isset($horaires[$jour]['ouvert']) && $horaires[$jour]['ouvert'] ? '' : 'disabled' }}>
                                </div>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text">À</span>
                                    <input type="time" class="form-control" name="horaires[{{ $jour }}][fermeture]" value="{{ $horaires[$jour]['fermeture'] ?? '18:00' }}" {{ isset($horaires[$jour]['ouvert']) && $horaires[$jour]['ouvert'] ? '' : 'disabled' }}>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>
                            {{ isset($service) ? 'Mettre à jour le service' : 'Créer le service' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        @if(isset($service))
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Images du service</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('prestataire.service.image.store') }}" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Ajouter une nouvelle image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-2"></i> Télécharger l'image
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row">
                        @forelse($service->images as $image)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $image->chemin) }}" class="card-img-top" alt="Image du service">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            @if($image->principale)
                                                <span class="badge bg-success">Image principale</span>
                                            @else
                                                <form method="POST" action="{{ route('prestataire.service.image.principale', $image->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Définir comme principale</button>
                                                </form>
                                            @endif
                                            
                                            <form method="POST" action="{{ route('prestataire.service.image.destroy', $image->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i> Aucune image n'a été ajoutée pour ce service. Veuillez ajouter au moins une image.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script pour activer/désactiver les champs horaires
            document.querySelectorAll('.jour-check').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const row = this.closest('.row');
                    const timeInputs = row.querySelectorAll('input[type="time"]');
                    
                    timeInputs.forEach(function(input) {
                        input.disabled = !checkbox.checked;
                    });
                });
            });
        });
    </script>
    @endpush
</x-layout>