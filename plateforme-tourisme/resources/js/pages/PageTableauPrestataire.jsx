import React from 'react';
import Tableau from '../components/prestataire/Tableau';
import Footer from '../components/commun/Footer';

const PageTableauPrestataire = ({ prestataire, service, totalVisites, visitesRecentes, visitesParJour }) => {
    const dashboardData = {
        prestataire: typeof prestataire === 'string' ? JSON.parse(prestataire) : prestataire,
        service: typeof service === 'string' ? JSON.parse(service) : service,
        totalVisites,
        visitesRecentes,
        visitesParJour: typeof visitesParJour === 'string' ? JSON.parse(visitesParJour) : visitesParJour,
    };
    
    return (
        <div className="page-tableau-prestataire">
            <div className="container py-5">
                <div className="row mb-4">
                    <div className="col-md-8">
                        <h1 className="mb-3">Bienvenue, {prestataire.user?.name || 'Prestataire'}</h1>
                        <p className="lead">Gérez votre service et consultez vos statistiques.</p>
                    </div>
                    <div className="col-md-4 text-end">
                        {service ? (
                            <a href="/prestataire/service/modification" className="btn btn-primary">
                                <i className="bi bi-pencil-square me-2"></i> Modifier mon service
                            </a>
                        ) : (
                            <a href="/prestataire/service/creation" className="btn btn-success">
                                <i className="bi bi-plus-circle me-2"></i> Créer mon service
                            </a>
                        )}
                    </div>
                </div>
                
                {service ? (
                    <Tableau dashboardData={dashboardData} />
                ) : (
                    <div className="alert alert-info">
                        <h4 className="alert-heading">Commencez à utiliser votre espace prestataire</h4>
                        <p>Vous n'avez pas encore créé votre service touristique.</p>
                        <hr />
                        <p className="mb-0">
                            Pour commencer, créez votre service en cliquant sur le bouton ci-dessus.
                            Une fois votre service créé, vous pourrez consulter vos statistiques et recevoir
                            des rapports hebdomadaires sur les performances de votre annonce.
                        </p>
                    </div>
                )}
            </div>
            
            <Footer />
        </div>
    );
};

export default PageTableauPrestataire;