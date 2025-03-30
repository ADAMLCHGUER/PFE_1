import React from 'react';
import DetailService from '../components/services/DetailService';
import Footer from '../components/commun/Footer';

const PageDetailService = ({ service }) => {
    const serviceData = typeof service === 'string' ? JSON.parse(service) : service;
    
    return (
        <div className="page-detail-service">
            <div className="container py-5">
                <nav aria-label="breadcrumb" className="mb-4">
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item"><a href="/">Accueil</a></li>
                        <li className="breadcrumb-item"><a href="/services">Services</a></li>
                        <li className="breadcrumb-item active" aria-current="page">{serviceData.titre}</li>
                    </ol>
                </nav>
                
                <DetailService service={serviceData} />
                
                <div className="text-center mt-5">
                    <a href="/services" className="btn btn-outline-primary">
                        <i className="bi bi-arrow-left me-2"></i> Retour aux services
                    </a>
                </div>
            </div>
            
            <Footer />
        </div>
    );
};

export default PageDetailService;