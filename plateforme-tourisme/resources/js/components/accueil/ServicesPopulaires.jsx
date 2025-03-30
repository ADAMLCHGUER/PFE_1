import React from 'react';

const ServicesPopulaires = ({ services }) => {
    // Parse les données JSON si nécessaire
    const servicesData = typeof services === 'string' ? JSON.parse(services) : services;

    return (
        <div className="row">
            {servicesData.map(service => (
                <div key={service.id} className="col-md-4 mb-4">
                    <div className="card h-100">
                        <img 
                            src={service.image_principale ? `/storage/${service.image_principale.chemin}` : '/images/placeholder.jpg'} 
                            className="card-img-top" 
                            alt={service.titre}
                            style={{ height: '200px', objectFit: 'cover' }}
                        />
                        <div className="card-body">
                            <div className="d-flex justify-content-between align-items-start mb-2">
                                <span className="badge bg-primary">{service.categorie.nom}</span>
                                <span className="badge bg-secondary">{service.ville.nom}</span>
                            </div>
                            <h5 className="card-title">{service.titre}</h5>
                            <p className="card-text small text-muted">{service.description.substring(0, 100)}...</p>
                        </div>
                        <div className="card-footer bg-white border-top-0">
                            <div className="d-flex justify-content-between align-items-center">
                                <small className="text-muted">
                                    <i className="bi bi-building me-1"></i>
                                    {service.prestataire.nom_entreprise}
                                </small>
                                <a href={`/services/${service.slug}`} className="btn btn-sm btn-outline-primary">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default ServicesPopulaires;