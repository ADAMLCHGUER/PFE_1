import React from 'react';
import FormulaireService from '../components/prestataire/FormulaireService';
import Footer from '../components/commun/Footer';

const PageModificationService = ({ service, categories, villes }) => {
    const serviceData = typeof service === 'string' ? JSON.parse(service) : service;
    const categoriesData = typeof categories === 'string' ? JSON.parse(categories) : categories;
    const villesData = typeof villes === 'string' ? JSON.parse(villes) : villes;
    
    const isCreation = !serviceData;
    
    return (
        <div className="page-modification-service">
            <div className="container py-5">
                <div className="d-flex justify-content-between align-items-center mb-4">
                    <h1>{isCreation ? 'Créer mon service' : 'Modifier mon service'}</h1>
                    <a href="/prestataire/tableau-de-bord" className="btn btn-outline-primary">
                        <i className="bi bi-arrow-left me-2"></i> Retour au tableau de bord
                    </a>
                </div>
                
                <FormulaireService 
                    service={serviceData}
                    categories={categoriesData}
                    villes={villesData}
                />
            </div>
            
            <Footer />
        </div>
    );
};

export default PageModificationService;