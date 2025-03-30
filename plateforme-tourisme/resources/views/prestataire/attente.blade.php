<x-layout>
    <x-slot:title>Compte en attente - Plateforme Tourisme Maroc</x-slot>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Compte en attente de validation</h4>
                    </div>
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-hourglass-split text-warning" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h2 class="mb-4">Merci pour votre inscription !</h2>
                        
                        <p class="lead mb-4">
                            Votre compte prestataire est actuellement en cours d'examen par notre équipe.
                        </p>
                        
                        <div class="alert alert-info mb-4">
                            <h5><i class="bi bi-info-circle me-2"></i> Statut actuel : <strong>En révision</strong></h5>
                            <p class="mb-0">
                                Vous recevrez un email dès que votre compte sera validé pour pouvoir commencer à gérer votre service.
                            </p>
                        </div>
                        
                        <p>
                            Si vous avez des questions, n'hésitez pas à nous contacter à
                            <a href="mailto:contact@tourisme-maroc.com">contact@tourisme-maroc.com</a>.
                        </p>
                    </div>
                    <div class="card-footer bg-white p-3">
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
</x-layout>