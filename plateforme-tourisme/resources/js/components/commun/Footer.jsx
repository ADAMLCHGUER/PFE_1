import React from 'react';

const Footer = () => {
    return (
        <footer className="bg-dark text-white py-4 mt-5">
            <div className="container">
                <div className="row">
                    <div className="col-md-4 mb-4 mb-md-0">
                        <h5>Plateforme Tourisme Maroc</h5>
                        <p className="text-muted mt-3">
                            Découvrez les meilleurs services touristiques au Maroc grâce à notre plateforme qui connecte les visiteurs avec des prestataires locaux de qualité.
                        </p>
                    </div>
                    <div className="col-md-2 mb-4 mb-md-0">
                        <h5>Liens rapides</h5>
                        <ul className="list-unstyled mt-3">
                            <li className="mb-2">
                                <a href="/" className="text-decoration-none text-muted">
                                    <i className="bi bi-house-door me-2"></i>Accueil
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/services" className="text-decoration-none text-muted">
                                    <i className="bi bi-grid me-2"></i>Services
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/inscription" className="text-decoration-none text-muted">
                                    <i className="bi bi-person-plus me-2"></i>Inscription
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/connexion" className="text-decoration-none text-muted">
                                    <i className="bi bi-box-arrow-in-right me-2"></i>Connexion
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="col-md-3 mb-4 mb-md-0">
                        <h5>Catégories populaires</h5>
                        <ul className="list-unstyled mt-3">
                            <li className="mb-2">
                                <a href="/services?categorie=hebergement" className="text-decoration-none text-muted">
                                    <i className="bi bi-house me-2"></i>Hébergement
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/services?categorie=restauration" className="text-decoration-none text-muted">
                                    <i className="bi bi-cup-hot me-2"></i>Restauration
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/services?categorie=activites" className="text-decoration-none text-muted">
                                    <i className="bi bi-bicycle me-2"></i>Activités
                                </a>
                            </li>
                            <li className="mb-2">
                                <a href="/services?categorie=transport" className="text-decoration-none text-muted">
                                    <i className="bi bi-car-front me-2"></i>Transport
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="col-md-3">
                        <h5>Contact</h5>
                        <ul className="list-unstyled mt-3">
                            <li className="mb-2">
                                <i className="bi bi-geo-alt me-2"></i>
                                Casablanca, Maroc
                            </li>
                            <li className="mb-2">
                                <i className="bi bi-envelope me-2"></i>
                                <a href="mailto:contact@tourisme-maroc.com" className="text-decoration-none text-muted">
                                    contact@tourisme-maroc.com
                                </a>
                            </li>
                            <li className="mb-2">
                                <i className="bi bi-telephone me-2"></i>
                                <a href="tel:+212522123456" className="text-decoration-none text-muted">
                                    +212 522 123 456
                                </a>
                            </li>
                        </ul>
                        <div className="mt-3">
                            <a href="#" className="text-muted me-3">
                                <i className="bi bi-facebook fs-5"></i>
                            </a>
                            <a href="#" className="text-muted me-3">
                                <i className="bi bi-instagram fs-5"></i>
                            </a>
                            <a href="#" className="text-muted me-3">
                                <i className="bi bi-twitter fs-5"></i>
                            </a>
                            <a href="#" className="text-muted">
                                <i className="bi bi-linkedin fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <hr className="mt-4 bg-secondary" />
                <div className="row">
                    <div className="col-md-6 text-center text-md-start">
                        <p className="mb-0 text-muted">&copy; {new Date().getFullYear()} Plateforme Tourisme Maroc. Tous droits réservés.</p>
                    </div>
                    <div className="col-md-6 text-center text-md-end">
                        <a href="#" className="text-decoration-none text-muted me-3">Mentions légales</a>
                        <a href="#" className="text-decoration-none text-muted me-3">Confidentialité</a>
                        <a href="#" className="text-decoration-none text-muted">CGU</a>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;