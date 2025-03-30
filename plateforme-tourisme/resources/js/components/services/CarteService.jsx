import React from 'react';

const CarteService = ({ service }) => {
    return (
        <div className="card h-100 shadow-sm">
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
                <p className="card-text small text-muted">
                    {service.description.length > 100 
                        ? `${service.description.substring(0, 100)}...` 
                        : service.description
                    }
                </p>
            </div>
            <div className="card-footer bg-white border-top-0">
                <div className="d-flex justify-content-between align-items-center">
                    <small className="text-muted">
                        <i className="bi bi-building me-1"></i>
                        {service.prestataire.nom_entreprise}
                    </small>
                    <a href={`/services/${service.slug}`} className="btn btn-sm btn-outline-primary">
                        <i className="bi bi-eye me-1"></i> Détails
                    </a>
                </div>
            </div>
        </div>
    );
};

export default CarteService;