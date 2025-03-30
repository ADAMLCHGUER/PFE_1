import React, { useState, useEffect } from 'react';
import axios from 'axios';

const FiltresService = ({ onFilterChange, initialFilters = {} }) => {
    const [categories, setCategories] = useState([]);
    const [villes, setVilles] = useState([]);
    const [filters, setFilters] = useState({
        categorie: initialFilters.categorie || '',
        ville: initialFilters.ville || '',
        q: initialFilters.q || ''
    });

    useEffect(() => {
        // Charger les catégories et villes
        const fetchData = async () => {
            try {
                const [categoriesRes, villesRes] = await Promise.all([
                    axios.get('/api/categories'),
                    axios.get('/api/villes')
                ]);
                setCategories(categoriesRes.data);
                setVilles(villesRes.data);
            } catch (error) {
                console.error('Erreur lors du chargement des données de filtrage:', error);
            }
        };

        fetchData();
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFilters(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (onFilterChange) {
            onFilterChange(filters);
        }
    };

    const handleReset = () => {
        const resetFilters = {
            categorie: '',
            ville: '',
            q: ''
        };
        setFilters(resetFilters);
        if (onFilterChange) {
            onFilterChange(resetFilters);
        }
    };

    return (
        <div className="card mb-4 shadow-sm">
            <div className="card-header bg-primary text-white">
                <h5 className="mb-0">Filtrer les services</h5>
            </div>
            <div className="card-body">
                <form onSubmit={handleSubmit}>
                    <div className="mb-3">
                        <label htmlFor="categorie" className="form-label">Catégorie</label>
                        <select 
                            id="categorie"
                            name="categorie" 
                            className="form-select" 
                            value={filters.categorie}
                            onChange={handleChange}
                        >
                            <option value="">Toutes les catégories</option>
                            {categories.map(categorie => (
                                <option key={categorie.id} value={categorie.slug}>
                                    {categorie.nom}
                                </option>
                            ))}
                        </select>
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="ville" className="form-label">Ville</label>
                        <select 
                            id="ville"
                            name="ville" 
                            className="form-select" 
                            value={filters.ville}
                            onChange={handleChange}
                        >
                            <option value="">Toutes les villes</option>
                            {villes.map(ville => (
                                <option key={ville.id} value={ville.slug}>
                                    {ville.nom}
                                </option>
                            ))}
                        </select>
                    </div>
                    
                    <div className="mb-3">
                        <label htmlFor="q" className="form-label">Recherche</label>
                        <input 
                            type="text" 
                            id="q"
                            name="q" 
                            className="form-control" 
                            placeholder="Mots-clés..." 
                            value={filters.q}
                            onChange={handleChange}
                        />
                    </div>
                    
                    <div className="d-grid gap-2">
                        <button type="submit" className="btn btn-primary">
                            <i className="bi bi-search me-2"></i> Filtrer
                        </button>
                        <button type="button" className="btn btn-outline-secondary" onClick={handleReset}>
                            <i className="bi bi-x-circle me-2"></i> Réinitialiser
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default FiltresService;