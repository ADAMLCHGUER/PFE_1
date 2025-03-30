import React from 'react';

const Banniere = () => {
    return (
        <div className="hero-banner mb-5">
            <div className="container">
                <div className="row align-items-center">
                    <div className="col-md-6">
                        <h1 className="display-4 fw-bold">Découvrez le Maroc</h1>
                        <p className="lead my-4">
                            Explorer les meilleurs services touristiques à travers le royaume. Des expériences uniques vous attendent.
                        </p>
                        <div className="d-flex gap-3">
                            <a href="/services" className="btn btn-light btn-lg px-4">
                                Explorer les services
                            </a>
                            <a href="/inscription" className="btn btn-outline-light btn-lg px-4">
                                Devenir prestataire
                            </a>
                        </div>
                    </div>
                    <div className="col-md-6 d-none d-md-block">
                        <img 
                            src="/images/morocco-banner.jpg" 
                            alt="Tourisme au Maroc" 
                            className="img-fluid rounded shadow" 
                            style={{ maxHeight: '400px', objectFit: 'cover' }}
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Banniere;