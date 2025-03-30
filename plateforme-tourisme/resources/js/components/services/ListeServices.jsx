import React, { useState, useEffect } from 'react';
import axios from 'axios';

const ListeServices = ({ initialServices, currentPage, lastPage }) => {
    const [services, setServices] = useState(
        typeof initialServices === 'string' ? JSON.parse(initialServices) : initialServices
    );
    const [pagination, setPagination] = useState({
        currentPage: parseInt(currentPage) || 1,
        lastPage: parseInt(lastPage) || 1
    });
    const [loading, setLoading] = useState(false);
    const [filters, setFilters] = useState({
        ville: new URLSearchParams(window.location.search).get('ville') || '',
        categorie: new URLSearchParams(window.location.search).get('categorie') || '',
        q: new URLSearchParams(window.location.search).get('q') || ''
    });

    const fetchServices = async (page = 1) => {
        setLoading(true);
        try {
            // Construire les paramètres de la requête
            const params = new URLSearchParams();
            if (filters.ville) params.append('ville', filters.ville);
            if (filters.categorie) params.append('categorie', filters.categorie);
            if (filters.q) params.append('q', filters.q);
            params.append('page', page);

            const response = await axios.get(`/api/services?${params.toString()}`);
            setServices(response.data.data);
            setPagination({
                currentPage: response.data.current_page,
                lastPage: response.data.last_page
            });

            // Mettre à jour l'URL sans recharger la page
            const url = new URL(window.location);
            url.search = params.toString();
            window.history.pushState({}, '', url);
        } catch (error) {
            console.error('Erreur lors du chargement des services:', error);
        } finally {
            setLoading(false);
        }
    };

    const handlePageChange = (page) => {
        if (page >= 1 && page <= pagination.lastPage) {
            fetchServices(page);
        }
    };

    const handleFilterChange = (e) => {
        const { name, value } = e.target;
        setFilters(prev => ({ ...prev, [name]: value }));
    };

    const applyFilters = (e) => {
        e.preventDefault();
        fetchServices(1);
    };

    // Générer les boutons de pagination
    const renderPagination = () => {
        const pages = [];
        const maxVisiblePages = 5;
        
        let startPage = Math.max(1, pagination.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(pagination.lastPage, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            pages.push(
                <li key={i} className={`page-item ${pagination.currentPage === i ? 'active' : ''}`}>
                    <button className="page-link" onClick={() => handlePageChange(i)}>{i}</button>
                </li>
            );
        }
        
        return (
            <nav aria-label="Pagination des services">
                <ul className="pagination justify-content-center">
                    <li className={`page-item ${pagination.currentPage === 1 ? 'disabled' : ''}`}>
                        <button className="page-link" onClick={() => handlePageChange(pagination.currentPage - 1)}>
                            &laquo; Précédent
                        </button>
                    </li>
                    {pages}
                    <li className={`page-item ${pagination.currentPage === pagination.lastPage ? 'disabled' : ''}`}>
                        <button className="page-link" onClick={() => handlePageChange(pagination.currentPage + 1)}>
                            Suivant &raquo;
                        </button>
                    </li>
                </ul>
            </nav>
        );
    };

    return (
        <div className="services-list">
            <div className="filters mb-4">
                <form onSubmit={applyFilters} className="row g-3">
                    <div className="col-md-3">
                        <select 
                            name="ville" 
                            className="form-select" 
                            value={filters.ville}
                            onChange={handleFilterChange}
                        >
                            <option value="">Toutes les villes</option>
                            {/* Options générées dynamiquement */}
                        </select>
                    </div>
                    <div className="col-md-3">
                        <select 
                            name="categorie" 
                            className="form-select" 
                            value={filters.categorie}
                            onChange={handleFilterChange}
                        >
                            <option value="">Toutes les catégories</option>
                            {/* Options générées dynamiquement */}
                        </select>
                    </div>
                    <div className="col-md-4">
                        <input 
                            type="text" 
                            name="q" 
                            className="form-control" 
                            placeholder="Rechercher un service..." 
                            value={filters.q}
                            onChange={handleFilterChange}
                        />
                    </div>
                    <div className="col-md-2">
                        <button type="submit" className="btn btn-primary w-100">
                            <i className="bi bi-search me-2"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>
            
            {loading ? (
                <div className="text-center py-5">
                    <div className="spinner-border text-primary" role="status">
                        <span className="visually-hidden">Chargement...</span>
                    </div>
                    <p className="mt-2">Chargement des services...</p>
                </div>
            ) : (
                <>
                    {services.length === 0 ? (
                        <div className="alert alert-info">
                            Aucun service ne correspond à votre recherche.
                        </div>
                    ) : (
                        <div className="row">
                            {services.map(service => (
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
                    )}
                    
                    {services.length > 0 && pagination.lastPage > 1 && renderPagination()}
                </>
            )}
        </div>
    );
};

export default ListeServices;