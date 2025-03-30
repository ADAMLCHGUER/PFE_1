<x-layout>
    <x-slot:title>Accès refusé - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Accès refusé</h4>
                    </div>
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-x-circle text-danger" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h2 class="mb-4">Votre compte n'a pas été approuvé</h2>
                        
                        <p class="lead mb-4">
                            Nous sommes désolés, mais votre demande d'inscription en tant que prestataire n'a pas été approuvée.
                        </p>
                        
                        <div class="alert alert-secondary mb-4">
                            <h5><i class="bi bi-question-circle me-2"></i> Que faire maintenant ?</h5>
                            <p class="mb-0">
                                Si vous pensez qu'il s'agit d'une erreur ou si vous souhaitez obtenir plus d'informations,
                                veuillez nous contacter à <a href="mailto:contact@tourisme-maroc.com">contact@tourisme-maroc.com</a>.
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-white p-3">
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('accueil') }}" class="btn btn-outline-primary">
                                <i class="bi bi-house me-2"></i> Retour à l'accueil
                            </a>
                            <form action="{{ route('prestataire.deconnexion') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="bi bi-box-arrow-right me-2"></i> Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>