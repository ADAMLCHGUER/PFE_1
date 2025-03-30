import React from 'react';
import Banniere from '../components/accueil/Banniere';
import BarreRecherche from '../components/accueil/BarreRecherche';
import ServicesPopulaires from '../components/accueil/ServicesPopulaires';
import Footer from '../components/commun/Footer';

const PageAccueil = ({ categories, villesPopulaires, servicesPopulaires }) => {
    return (
        <div className="page-accueil">
            <Banniere />
            
            <div className="container mt-4 mb-5">
                <div className="bg-light p-4 rounded">
                    <BarreRecherche />
                </div>
            </div>
            
            <div className="container mb-5">
                <h2 className="section-title mb-4">Catégories populaires</h2>
                <div className="row">
                    {categories.map(categorie => (
                        <div key={categorie.id} className="col-md-3 mb-4">
                            <a href={`/services?categorie=${categorie.slug}`} className="text-decoration-none">
                                <div className="card h-100">
                                    <div className="card-body text-center">
                                        <i className={`bi bi-${categorie.icone || 'tag'} display-4 text-primary`}></i>
                                        <h5 className="card-title mt-3">{categorie.nom}</h5>
                                        <p className="card-text text-muted small">
                                            {categorie.description && categorie.description.length > 60 
                                                ? `${categorie.description.substring(0, 60)}...` 
                                                : categorie.description}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ))}
                </div>
            </div>
            
            <div className="container mb-5">
                <h2 className="section-title mb-4">Découvrez les destinations</h2>
                <div className="row">
                    {villesPopulaires.map(ville => (
                        <div key={ville.id} className="col-md-4 mb-4">
                            <a href={`/services?ville=${ville.slug}`} className="text-decoration-none">
                                <div className="card">
                                    <img src={`/storage/${ville.image}`} className="card-img-top" alt={ville.nom} 
                                         style={{ height: '200px', objectFit: 'cover' }} />
                                    <div className="card-body">
                                        <h5 className="card-title">{ville.nom}</h5>
                                        <p className="card-text text-muted">
                                            {ville.description && ville.description.length > 100 
                                                ? `${ville.description.substring(0, 100)}...` 
                                                : ville.description}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ))}
                </div>
            </div>
            
            <div className="container mb-5">
                <h2 className="section-title mb-4">Services populaires</h2>
                <ServicesPopulaires services={servicesPopulaires} />
            </div>
            
            <div className="container mb-5">
                <div className="bg-secondary text-white p-5 rounded">
                    <div className="row align-items-center">
                        <div className="col-md-8">
                            <h2>Vous êtes prestataire de services touristiques ?</h2>
                            <p className="lead">Rejoignez notre plateforme pour mettre en valeur vos services et attirer plus de clients.</p>
                        </div>
                        <div className="col-md-4 text-center">
                            <a href="/inscription" className="btn btn-light btn-lg">Devenir prestataire</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <Footer />
        </div>
    );
};

export default PageAccueil;