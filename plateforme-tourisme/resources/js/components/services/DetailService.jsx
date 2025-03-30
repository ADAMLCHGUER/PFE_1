import React, { useState } from 'react';

const DetailService = ({ service }) => {
    const serviceData = typeof service === 'string' ? JSON.parse(service) : service;
    const [activeImage, setActiveImage] = useState(serviceData.images[0]?.chemin || '');

    return (
        <div className="service-detail">
            <div className="row mb-4">
                {/* Galerie d'images */}
                <div className="col-lg-7 mb-4 mb-lg-0">
                    <div className="main-image mb-3">
                        <img 
                            src={activeImage ? `/storage/${activeImage}` : '/images/placeholder.jpg'} 
                            alt={serviceData.titre} 
                            className="img-fluid rounded"
                            style={{ width: '100%', height: '400px', objectFit: 'cover' }}
                        />
                    </div>
                    <div className="thumbnails d-flex flex-wrap gap-2">
                        {serviceData.images.map((image, index) => (
                            <img 
                                key={index}
                                src={`/storage/${image.chemin}`}
                                alt={`${serviceData.titre} - image ${index + 1}`}
                                className={`img-thumbnail cursor-pointer ${activeImage === image.chemin ? 'border-primary' : ''}`}
                                style={{ width: '80px', height: '60px', objectFit: 'cover', cursor: 'pointer' }}
                                onClick={() => setActiveImage(image.chemin)}
                            />
                        ))}
                    </div>
                </div>
                
                {/* Informations du service */}
                <div className="col-lg-5">
                    <div className="d-flex justify-content-between align-items-start mb-3">
                        <span className="badge bg-primary px-3 py-2">{serviceData.categorie.nom}</span>
                        <span className="badge bg-secondary px-3 py-2">{serviceData.ville.nom}</span>
                    </div>
                    
                    <h1 className="mb-3">{serviceData.titre}</h1>
                    
                    <div className="d-flex align-items-center mb-3">
                        <i className="bi bi-building me-2 text-primary"></i>
                        <span>{serviceData.prestataire.nom_entreprise}</span>
                    </div>
                    
                    <div className="info-box bg-light p-3 rounded mb-3">
                        <h5 className="border-bottom pb-2 mb-3">Coordonnées</h5>
                        
                        <div className="d-flex align-items-center mb-2">
                            <i className="bi bi-geo-alt me-2 text-primary"></i>
                            <span>{serviceData.adresse}</span>
                        </div>
                        
                        <div className="d-flex align-items-center mb-2">
                            <i className="bi bi-telephone me-2 text-primary"></i>
                            <a href={`tel:${serviceData.telephone}`} className="text-decoration-none">{serviceData.telephone}</a>
                        </div>
                        
                        <div className="d-flex align-items-center mb-2">
                            <i className="bi bi-envelope me-2 text-primary"></i>
                            <a href={`mailto:${serviceData.email}`} className="text-decoration-none">{serviceData.email}</a>
                        </div>
                        
                        {serviceData.site_web && (
                            <div className="d-flex align-items-center">
                                <i className="bi bi-globe me-2 text-primary"></i>
                                <a href={serviceData.site_web} target="_blank" rel="noopener noreferrer" className="text-decoration-none">
                                    {serviceData.site_web}
                                </a>
                            </div>
                        )}
                    </div>
                    
                    {serviceData.horaires && serviceData.horaires.length > 0 && (
                        <div className="info-box bg-light p-3 rounded mb-3">
                            <h5 className="border-bottom pb-2 mb-3">Horaires</h5>
                            <ul className="list-unstyled mb-0">
                                {serviceData.horaires.map((horaire, index) => (
                                    <li key={index} className="mb-1">
                                        <span className="fw-bold">{horaire.jour}: </span>
                                        {horaire.ouverture} - {horaire.fermeture}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            </div>
            
            {/* Description et prestations */}
            <div className="row mb-4">
                <div className="col-md-12">
                    <ul className="nav nav-tabs" id="serviceTab" role="tablist">
                        <li className="nav-item" role="presentation">
                            <button className="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                                Description
                            </button>
                        </li>
                        <li className="nav-item" role="presentation">
                            <button className="nav-link" id="prestations-tab" data-bs-toggle="tab" data-bs-target="#prestations" type="button" role="tab" aria-controls="prestations" aria-selected="false">
                                Prestations
                            </button>
                        </li>
                    </ul>
                    <div className="tab-content p-4 bg-light rounded-bottom" id="serviceTabContent">
                        <div className="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p className="text-muted">{serviceData.description}</p>
                        </div>
                        <div className="tab-pane fade" id="prestations" role="tabpanel" aria-labelledby="prestations-tab">
                            <p className="text-muted">{serviceData.prestations}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {/* Carte si coordonnées disponibles */}
            {serviceData.coordonnees && (
                <div className="row mb-4">
                    <div className="col-md-12">
                        <h4 className="mb-3">Localisation</h4>
                        <div className="ratio ratio-16x9">
                            <iframe 
                                src={`https://maps.google.com/maps?q=${serviceData.coordonnees}&z=15&output=embed`} 
                                title="Localisation"
                                className="rounded"
                                allowFullScreen
                            />
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default DetailService;