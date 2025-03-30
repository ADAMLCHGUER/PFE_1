<x-layout>
    <x-slot:title>Inscription - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Inscription prestataire</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <div class="progress" style="height: 5px;">
                                <div id="inscriptionProgress" class="progress-bar bg-success" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div id="inscription-form">
                            <div id="etape1">
                                <h4 class="mb-4">Étape 1: Créez votre compte</h4>
                                
                                <form method="POST" action="{{ route('prestataire.inscription') }}" id="inscriptionForm">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom complet *</label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            id="name" 
                                            name="name" 
                                            value="{{ old('name') }}" 
                                            required 
                                            autofocus
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input 
                                            type="email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            id="email" 
                                            name="email" 
                                            value="{{ old('email') }}" 
                                            required
                                        >
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mot de passe *</label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="password" 
                                            name="password" 
                                            required
                                        >
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Minimum 8 caractères</div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirmation du mot de passe *</label>
                                        <input 
                                            type="password" 
                                            class="form-control" 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            required
                                        >
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="nom_entreprise" class="form-label">Nom de l'entreprise *</label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('nom_entreprise') is-invalid @enderror" 
                                            id="nom_entreprise" 
                                            name="nom_entreprise" 
                                            value="{{ old('nom_entreprise') }}" 
                                            required
                                        >
                                        @error('nom_entreprise')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="telephone" class="form-label">Téléphone *</label>
                                        <input 
                                            type="tel" 
                                            class="form-control @error('telephone') is-invalid @enderror" 
                                            id="telephone" 
                                            name="telephone" 
                                            value="{{ old('telephone') }}" 
                                            required
                                        >
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="adresse" class="form-label">Adresse complète *</label>
                                        <textarea 
                                            class="form-control @error('adresse') is-invalid @enderror" 
                                            id="adresse" 
                                            name="adresse" 
                                            rows="3" 
                                            required
                                        >{{ old('adresse') }}</textarea>
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-check mb-4">
                                        <input 
                                            class="form-check-input @error('terms') is-invalid @enderror" 
                                            type="checkbox" 
                                            id="terms" 
                                            name="terms" 
                                            required
                                        >
                                        <label class="form-check-label" for="terms">
                                            J'accepte les <a href="#" target="_blank">conditions d'utilisation</a> et la <a href="#" target="_blank">politique de confidentialité</a>
                                        </label>
                                        @error('terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-person-plus me-2"></i> S'inscrire
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-center">
                                        <small class="text-muted">
                                            Vous avez déjà un compte ? <a href="{{ route('prestataire.connexion') }}">Connectez-vous</a>
                                        </small>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>