import React, { useState, useEffect } from 'react';
import axios from 'axios';
import ListeServices from '../components/services/ListeServices';
import FiltresService from '../components/services/FiltresService';
import Pagination from '../components/commun/Pagination';
import Chargement from '../components/commun/Chargement';
import Footer from '../components/commun/Footer';

const PageListeServices = ({ initialServices, categories, villes }) => {
    const [services, setServices] = useState(initialServices);
    const [pagination, setPagination] = useState({
        currentPage: 1,
        lastPage: 1,
        total: 0
    });
    const [loading, setLoading] = useState(false);
    const [filters, setFilters] = useState({
        categorie: new URLSearchParams(window.location.search).get('categorie') || '',
        ville: new URLSearchParams(window.location.search).get('ville') || '',
        q: new URLSearchParams(window.location.search).get('q') || ''
    });

    const fetchServices = async (page = 1) => {
        setLoading(true);
        
        try {
            const params = new URLSearchParams();
            if (filters.categorie) params.append('categorie', filters.categorie);
            if (filters.ville) params.append('ville', filters.ville);
            if (filters.q) params.append('q', filters.q);
            params.append('page', page);
            
            const response = await axios.get(`/api/services?${params.toString()}`);
            
            setServices(response.data.data);
            setPagination({
                currentPage: response.data.current_page,
                lastPage: response.data.last_page,
                total: response.data.total
            });
            
            // Mettre à jour l'URL
            const url = new URL(window.location);
            url.search = params.toString();
            window.history.pushState({}, '', url);
        } catch (error) {
            console.error('Erreur lors du chargement des services:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleFilterChange = (newFilters) => {
        setFilters(newFilters);
        fetchServices(1);
    };

    const handlePageChange = (page) => {
        fetchServices(page);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    return (
        <div className="page-liste-services">
            <div className="container py-5">
                <div className="row mb-4">
                    <div className="col-md-8">
                        <h1 className="mb-3">Découvrez nos services touristiques</h1>
                        <p className="lead">Explorez une sélection de services de qualité pour rendre votre expérience au Maroc inoubliable.</p>
                    </div>
                </div>
                
                <div className="row">
                    <div className="col-md-3">
                        <FiltresService 
                            onFilterChange={handleFilterChange} 
                            initialFilters={filters}
                            categories={categories}
                            villes={villes}
                        />
                    </div>
                    
                    <div className="col-md-9">
                        {loading ? (
                            <Chargement message="Chargement des services..." />
                        ) : (
                            <>
                                <div className="d-flex justify-content-between align-items-center mb-4">
                                    <p className="mb-0">
                                        {pagination.total} résultat{pagination.total !== 1 ? 's' : ''} trouvé{pagination.total !== 1 ? 's' : ''}
                                    </p>
                                </div>
                                
                                {services.length === 0 ? (
                                    <div className="alert alert-info">
                                        Aucun service ne correspond à votre recherche.
                                    </div>
                                ) : (
                                    <>
                                        <ListeServices services={services} />
                                        
                                        {pagination.lastPage > 1 && (
                                            <div className="mt-4">
                                                <Pagination 
                                                    currentPage={pagination.currentPage}
                                                    lastPage={pagination.lastPage}
                                                    onPageChange={handlePageChange}
                                                />
                                            </div>
                                        )}
                                    </>
                                )}
                            </>
                        )}
                    </div>
                </div>
            </div>
            
            <Footer />
        </div>
    );
};

export default PageListeServices;