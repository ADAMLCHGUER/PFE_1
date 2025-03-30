import React, { useState, useEffect } from 'react';
import axios from 'axios';

const FormulaireService = ({ service, categories, villes }) => {
    // Safely parse data with error handling
    const safeJSONParse = (data, fallback) => {
        if (!data) return fallback;
        try {
            return typeof data === 'string' ? JSON.parse(data) : data;
        } catch (error) {
            console.error('JSON Parse error:', error);
            return fallback;
        }
    };

    const parsedService = safeJSONParse(service, null);
    const parsedCategories = safeJSONParse(categories, []);
    const parsedVilles = safeJSONParse(villes, []);

    // État pour le formulaire
    const [formData, setFormData] = useState({
        titre: parsedService?.titre || '',
        categorie_id: parsedService?.categorie_id || '',
        ville_id: parsedService?.ville_id || '',
        description: parsedService?.description || '',
        prestations: parsedService?.prestations || '',
        coordonnees: parsedService?.coordonnees || '',
        adresse: parsedService?.adresse || '',
        telephone: parsedService?.telephone || '',
        email: parsedService?.email || '',
        site_web: parsedService?.site_web || '',
        horaires: parsedService?.horaires || []
    });

    // État pour les images téléchargées
    const [images, setImages] = useState(parsedService?.images || []);
    const [selectedImage, setSelectedImage] = useState(null);
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});
    const [successMessage, setSuccessMessage] = useState('');

    // Gestion des horaires
    const defaultJours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
    const [horaires, setHoraires] = useState(parsedService?.horaires || defaultJours.map(jour => ({ jour, ouverture: '', fermeture: '' })));

    // Gérer le changement des champs du formulaire
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    // Gérer le changement des horaires
    const handleHoraireChange = (index, field, value) => {
        const newHoraires = [...horaires];
        newHoraires[index][field] = value;
        setHoraires(newHoraires);
        setFormData(prev => ({ ...prev, horaires: newHoraires }));
    };

    // Validate GPS coordinates
    const validateCoordinates = (coords) => {
        if (!coords) return true;
        const pattern = /^-?\d+\.?\d*,\s*-?\d+\.?\d*$/;
        if (!pattern.test(coords)) return false;
        
        const [lat, lng] = coords.split(',').map(Number);
        return lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180;
    };

    // Enhanced form validation
    const validateForm = () => {
        const newErrors = {};
        
        if (!formData.titre.trim()) newErrors.titre = 'Le titre est requis';
        if (!formData.description.trim()) newErrors.description = 'La description est requise';
        if (!formData.adresse.trim()) newErrors.adresse = 'L\'adresse est requise';
        if (!formData.email.trim()) newErrors.email = 'L\'email est requis';
        if (!validateCoordinates(formData.coordonnees)) {
            newErrors.coordonnees = 'Format de coordonnées GPS invalide';
        }

        return newErrors;
    };

    // Modified handleSubmit with enhanced validation
    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setErrors({});
        setSuccessMessage('');

        const validationErrors = validateForm();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            setLoading(false);
            window.scrollTo(0, 0);
            return;
        }

        try {
            const method = parsedService ? 'put' : 'post';
            const url = '/api/prestataire/service';
            
            const response = await axios[method](url, {
                ...formData,
                _method: parsedService ? 'PUT' : 'POST',
            });

            setSuccessMessage(parsedService ? 'Service mis à jour avec succès' : 'Service créé avec succès');
            
            if (!parsedService) {
                window.location.href = '/prestataire/service/modification';
            }
        } catch (error) {
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ general: 'Une erreur est survenue. Veuillez réessayer.' });
            }
        } finally {
            setLoading(false);
            window.scrollTo(0, 0);
        }
    };

    // Gérer le téléchargement d'image
    const handleImageUpload = async (e) => {
        e.preventDefault();
        if (!selectedImage) return;

        const formData = new FormData();
        formData.append('image', selectedImage);

        setLoading(true);
        try {
            const response = await axios.post('/api/prestataire/service/images', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            
            // Ajouter la nouvelle image à la liste
            setImages(prev => [...prev, response.data.image]);
            setSelectedImage(null);
            setSuccessMessage('Image téléchargée avec succès');
        } catch (error) {
            if (error.response && error.response.data.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({ image: 'Une erreur est survenue lors du téléchargement de l\'image.' });
            }
        } finally {
            setLoading(false);
        }
    };

    // Gérer la suppression d'image
    const handleDeleteImage = async (imageId) => {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) return;
        
        setLoading(true);
        try {
            await axios.delete(`/api/prestataire/service/images/${imageId}`);
            setImages(prev => prev.filter(img => img.id !== imageId));
            setSuccessMessage('Image supprimée avec succès');
        } catch (error) {
            setErrors({ image: 'Une erreur est survenue lors de la suppression de l\'image.' });
        } finally {
            setLoading(false);
        }
    };

    // Gérer la définition d'image principale
    const handleSetMainImage = async (imageId) => {
        setLoading(true);
        try {
            await axios.post(`/api/prestataire/service/images/${imageId}/principale`);
            // Mettre à jour le statut "principale" dans la liste d'images
            setImages(prev => prev.map(img => ({
                ...img,
                principale: img.id === imageId
            })));
            setSuccessMessage('Image principale définie avec succès');
        } catch (error) {
            setErrors({ image: 'Une erreur est survenue lors de la définition de l\'image principale.' });
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="service-form">
            {/* Messages d'erreur et de succès */}
            {errors.general && <div className="alert alert-danger">{errors.general}</div>}
            {successMessage && <div className="alert alert-success">{successMessage}</div>}
            
            <form onSubmit={handleSubmit}>
                <div className="card mb-4">
                    <div className="card-header">
                        <h5 className="mb-0">Informations générales</h5>
                    </div>
                    <div className="card-body">
                        <div className="mb-3">
                            <label htmlFor="titre" className="form-label">Titre du service *</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.titre ? 'is-invalid' : ''}`}
                                id="titre"
                                name="titre"
                                value={formData.titre}
                                onChange={handleChange}
                                required
                            />
                            {errors.titre && <div className="invalid-feedback">{errors.titre}</div>}
                        </div>
                        
                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label htmlFor="categorie_id" className="form-label">Catégorie *</label>
                                <select 
                                    className={`form-select ${errors.categorie_id ? 'is-invalid' : ''}`}
                                    id="categorie_id"
                                    name="categorie_id"
                                    value={formData.categorie_id}
                                    onChange={handleChange}
                                    required
                                >
                                    <option value="">Sélectionnez une catégorie</option>
                                    {parsedCategories.map(categorie => (
                                        <option key={categorie.id} value={categorie.id}>
                                            {categorie.nom}
                                        </option>
                                    ))}
                                </select>
                                {errors.categorie_id && <div className="invalid-feedback">{errors.categorie_id}</div>}
                            </div>
                            
                            <div className="col-md-6 mb-3">
                                <label htmlFor="ville_id" className="form-label">Ville *</label>
                                <select 
                                    className={`form-select ${errors.ville_id ? 'is-invalid' : ''}`}
                                    id="ville_id"
                                    name="ville_id"
                                    value={formData.ville_id}
                                    onChange={handleChange}
                                    required
                                >
                                    <option value="">Sélectionnez une ville</option>
                                    {parsedVilles.map(ville => (
                                        <option key={ville.id} value={ville.id}>
                                            {ville.nom}
                                        </option>
                                    ))}
                                </select>
                                {errors.ville_id && <div className="invalid-feedback">{errors.ville_id}</div>}
                            </div>
                        </div>
                        
                        <div className="mb-3">
                            <label htmlFor="description" className="form-label">Description détaillée *</label>
                            <textarea 
                                className={`form-control ${errors.description ? 'is-invalid' : ''}`}
                                id="description"
                                name="description"
                                value={formData.description}
                                onChange={handleChange}
                                rows="5"
                                required
                            ></textarea>
                            {errors.description && <div className="invalid-feedback">{errors.description}</div>}
                        </div>
                        
                        <div className="mb-3">
                            <label htmlFor="prestations" className="form-label">Prestations offertes *</label>
                            <textarea 
                                className={`form-control ${errors.prestations ? 'is-invalid' : ''}`}
                                id="prestations"
                                name="prestations"
                                value={formData.prestations}
                                onChange={handleChange}
                                rows="5"
                                required
                            ></textarea>
                            {errors.prestations && <div className="invalid-feedback">{errors.prestations}</div>}
                            <div className="form-text">Détaillez les services que vous proposez, tarifs, etc.</div>
                        </div>
                    </div>
                </div>
                
                <div className="card mb-4">
                    <div className="card-header">
                        <h5 className="mb-0">Coordonnées et contact</h5>
                    </div>
                    <div className="card-body">
                        <div className="mb-3">
                            <label htmlFor="adresse" className="form-label">Adresse complète *</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.adresse ? 'is-invalid' : ''}`}
                                id="adresse"
                                name="adresse"
                                value={formData.adresse}
                                onChange={handleChange}
                                required
                            />
                            {errors.adresse && <div className="invalid-feedback">{errors.adresse}</div>}
                        </div>
                        
                        <div className="mb-3">
                            <label htmlFor="coordonnees" className="form-label">Coordonnées GPS</label>
                            <input 
                                type="text" 
                                className={`form-control ${errors.coordonnees ? 'is-invalid' : ''}`}
                                id="coordonnees"
                                name="coordonnees"
                                value={formData.coordonnees}
                                onChange={handleChange}
                                placeholder="Ex: 34.0522, -118.2437"
                            />
                            {errors.coordonnees && <div className="invalid-feedback">{errors.coordonnees}</div>}
                            <div className="form-text">Format: latitude, longitude (ex: 34.0522, -118.2437)</div>
                        </div>
                        
                        <div className="row">
                            <div className="col-md-6 mb-3">
                                <label htmlFor="telephone" className="form-label">Téléphone *</label>
                                <input 
                                    type="text" 
                                    className={`form-control ${errors.telephone ? 'is-invalid' : ''}`}
                                    id="telephone"
                                    name="telephone"
                                    value={formData.telephone}
                                    onChange={handleChange}
                                    required
                                />
                                {errors.telephone && <div className="invalid-feedback">{errors.telephone}</div>}
                            </div>
                            
                            <div className="col-md-6 mb-3">
                                <label htmlFor="email" className="form-label">Email *</label>
                                <input 
                                    type="email" 
                                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                    id="email"
                                    name="email"
                                    value={formData.email}
                                    onChange={handleChange}
                                    required
                                />
                                {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                            </div>
                        </div>
                        
                        <div className="mb-3">
                            <label htmlFor="site_web" className="form-label">Site Web</label>
                            <input 
                                type="url" 
                                className={`form-control ${errors.site_web ? 'is-invalid' : ''}`}
                                id="site_web"
                                name="site_web"
                                value={formData.site_web}
                                onChange={handleChange}
                                placeholder="https://www.exemple.com"
                            />
                            {errors.site_web && <div className="invalid-feedback">{errors.site_web}</div>}
                        </div>
                    </div>
                </div>
                
                <div className="card mb-4">
                    <div className="card-header">
                        <h5 className="mb-0">Horaires d'ouverture</h5>
                    </div>
                    <div className="card-body">
                        {horaires.map((horaire, index) => (
                            <div key={index} className="row mb-3">
                                <div className="col-md-4">
                                    <label className="form-label">{horaire.jour.charAt(0).toUpperCase() + horaire.jour.slice(1)}</label>
                                </div>
                                <div className="col-md-4">
                                    <input 
                                        type="time" 
                                        className="form-control"
                                        value={horaire.ouverture}
                                        onChange={(e) => handleHoraireChange(index, 'ouverture', e.target.value)}
                                        placeholder="Ouverture"
                                    />
                                </div>
                                <div className="col-md-4">
                                    <input 
                                        type="time" 
                                        className="form-control"
                                        value={horaire.fermeture}
                                        onChange={(e) => handleHoraireChange(index, 'fermeture', e.target.value)}
                                        placeholder="Fermeture"
                                    />
                                </div>
                            </div>
                        ))}
                        <div className="form-text">Laissez les horaires vides pour les jours de fermeture.</div>
                    </div>
                </div>
                
                <div className="d-grid">
                    <button 
                        type="submit" 
                        className="btn btn-primary btn-lg"
                        disabled={loading}
                    >
                        {loading ? (
                            <>
                                <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Traitement en cours...
                            </>
                        ) : (
                            parsedService ? 'Mettre à jour le service' : 'Créer le service'
                        )}
                    </button>
                </div>
            </form>
            
            {/* Section de gestion des images (visible uniquement en mode modification) */}
            {parsedService && (
                <div className="card mt-4">
                    <div className="card-header">
                        <h5 className="mb-0">Gestion des images</h5>
                    </div>
                    <div className="card-body">
                        {/* Affichage des images existantes */}
                        {images.length > 0 ? (
                            <div className="row mb-4">
                                {images.map(image => (
                                    <div key={image.id} className="col-md-3 mb-3">
                                        <div className={`card ${image.principale ? 'border-primary' : ''}`}>
                                            <img 
                                                src={`/storage/${image.chemin}`} 
                                                className="card-img-top" 
                                                alt="Image du service"
                                                style={{ height: '150px', objectFit: 'cover' }}
                                            />
                                            <div className="card-body p-2">
                                                <div className="btn-group btn-group-sm w-100">
                                                    {!image.principale && (
                                                        <button 
                                                            type="button" 
                                                            className="btn btn-outline-primary"
                                                            onClick={() => handleSetMainImage(image.id)}
                                                            disabled={loading}
                                                        >
                                                            <i className="bi bi-star-fill"></i>
                                                        </button>
                                                    )}
                                                    <button 
                                                        type="button" 
                                                        className="btn btn-outline-danger"
                                                        onClick={() => handleDeleteImage(image.id)}
                                                        disabled={loading}
                                                    >
                                                        <i className="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                                {image.principale && (
                                                    <div className="text-center mt-2">
                                                        <span className="badge bg-primary">Image principale</span>
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="alert alert-info mb-4">
                                Aucune image n'a été ajoutée pour ce service.
                            </div>
                        )}
                        
                        {/* Formulaire d'ajout d'image */}
                        <form onSubmit={handleImageUpload}>
                            <div className="mb-3">
                                <label htmlFor="image" className="form-label">Ajouter une nouvelle image</label>
                                <input 
                                    type="file" 
                                    className={`form-control ${errors.image ? 'is-invalid' : ''}`}
                                    id="image"
                                    accept="image/*"
                                    onChange={(e) => setSelectedImage(e.target.files[0])}
                                    required
                                />
                                {errors.image && <div className="invalid-feedback">{errors.image}</div>}
                                <div className="form-text">Format: JPG, PNG, GIF - Taille max: 2MB</div>
                            </div>
                            <button 
                                type="submit" 
                                className="btn btn-success"
                                disabled={!selectedImage || loading}
                            >
                                {loading ? (
                                    <>
                                        <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Téléchargement...
                                    </>
                                ) : (
                                    <>
                                        <i className="bi bi-upload me-2"></i>
                                        Télécharger l'image
                                    </>
                                )}
                            </button>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
 };
 
 export default FormulaireService;