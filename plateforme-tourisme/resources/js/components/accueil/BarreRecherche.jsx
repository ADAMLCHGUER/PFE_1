import React, { useState, useEffect } from 'react';
import axios from 'axios';

const BarreRecherche = () => {
    const [categories, setCategories] = useState([]);
    const [villes, setVilles] = useState([]);
    const [formData, setFormData] = useState({
        ville: '',
        categorie: '',
        q: ''
    });

    useEffect(() => {
        // Charger les catégories et villes
        const fetchData = async () => {
            try {
                const [categoriesRes, villesRes] = await Promise.all([
                    axios.get('/Api/CategoriesConntroller'),
                    axios.get('/Api/villesController')
                ]);
                setCategories(categoriesRes.data);
                setVilles(villesRes.data);
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
            }
        };

        fetchData();
    }, []);

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    return (
        <div className="container">
            <form action="/services" method="GET" className="row g-3">
                <div className="col-md-3">
                    <select 
                        name="ville" 
                        className="form-select" 
                        onChange={handleChange}
                        value={formData.ville}
                    >
                        <option value="">Toutes les villes</option>
                        {villes.map(ville => (
                            <option key={ville.id} value={ville.slug}>
                                {ville.nom}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-md-3">
                    <select 
                        name="categorie" 
                        className="form-select" 
                        onChange={handleChange}
                        value={formData.categorie}
                    >
                        <option value="">Toutes les catégories</option>
                        {categories.map(categorie => (
                            <option key={categorie.id} value={categorie.slug}>
                                {categorie.nom}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-md-4">
                    <input 
                        type="text" 
                        name="q" 
                        className="form-control" 
                        placeholder="Rechercher un service..." 
                        onChange={handleChange}
                        value={formData.q}
                    />
                </div>
                <div className="col-md-2">
                    <button type="submit" className="btn btn-primary w-100">
                        <i className="bi bi-search me-2"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
    );
};

export default BarreRecherche;