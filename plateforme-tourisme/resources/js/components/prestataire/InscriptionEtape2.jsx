import React, { useState } from 'react';
import axios from 'axios';
import Alerte from '../commun/Alerte';

const InscriptionEtape2 = ({ onPrevious, formData, onSubmitSuccess }) => {
    const [prestataireData, setPrestataireData] = useState({
        nom_entreprise: '',
        telephone: '',
        adresse: ''
    });
    
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState({});
    const [serverError, setServerError] = useState('');
    
    const handleChange = (e) => {
        const { name, value } = e.target;
        setPrestataireData(prev => ({ ...prev, [name]: value }));
        
        // Supprimer l'erreur quand l'utilisateur modifie le champ
        if (errors[name]) {
            setErrors(prev => {
                const newErrors = { ...prev };
                delete newErrors[name];
                return newErrors;
            });
        }
    };
    
    const validateForm = () => {
        const newErrors = {};
        
        if (!prestataireData.nom_entreprise.trim()) {
            newErrors.nom_entreprise = 'Le nom de l\'entreprise est requis';
        }
        
        if (!prestataireData.telephone.trim()) {
            newErrors.telephone = 'Le numéro de téléphone est requis';
        }
        
        if (!prestataireData.adresse.trim()) {
            newErrors.adresse = 'L\'adresse est requise';
        }
        
        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        
        if (validateForm()) {
            setLoading(true);
            setServerError('');
            
            try {
                // Combiner les données des deux étapes
                const completeData = {
                    ...formData,
                    ...prestataireData
                };
                
                // Envoyer les données au serveur
                const response = await axios.post('/inscription', completeData);
                
                // Si l'inscription est réussie, appeler la fonction de succès
                if (response.status === 201 || response.status === 200) {
                    onSubmitSuccess(response.data);
                }
            } catch (error) {
                console.error('Erreur lors de l\'inscription:', error);
                
                if (error.response && error.response.data.errors) {
                    setErrors(error.response.data.errors);
                } else {
                    setServerError(error.response?.data?.message || 'Une erreur est survenue lors de l\'inscription.');
                }
            } finally {
                setLoading(false);
            }
        }
    };
    
    return (
        <div className="inscription-etape2">
            <h4 className="mb-4">Étape 2: Informations du prestataire</h4>
            
            {serverError && (
                <Alerte 
                    type="danger" 
                    message={serverError}
                    duration={0}
                />
            )}
            
            {Object.keys(errors).length > 0 && (
                <Alerte 
                    type="danger" 
                    message="Veuillez corriger les erreurs ci-dessous."
                    duration={0}
                />
            )}
            
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="nom_entreprise" className="form-label">Nom de l'entreprise *</label>
                    <input 
                        type="text" 
                        className={`form-control ${errors.nom_entreprise ? 'is-invalid' : ''}`}
                        id="nom_entreprise"
                        name="nom_entreprise"
                        value={prestataireData.nom_entreprise}
                        onChange={handleChange}
                        placeholder="Nom de votre entreprise"
                    />
                    {errors.nom_entreprise && <div className="invalid-feedback">{errors.nom_entreprise}</div>}
                </div>
                
                <div className="mb-3">
                    <label htmlFor="telephone" className="form-label">Téléphone *</label>
                    <input 
                        type="tel" 
                        className={`form-control ${errors.telephone ? 'is-invalid' : ''}`}
                        id="telephone"
                        name="telephone"
                        value={prestataireData.telephone}
                        onChange={handleChange}
                        placeholder="Ex: +212 xxx xxx xxx"
                    />
                    {errors.telephone && <div className="invalid-feedback">{errors.telephone}</div>}
                </div>
                
                <div className="mb-4">
                    <label htmlFor="adresse" className="form-label">Adresse complète *</label>
                    <textarea 
                        className={`form-control ${errors.adresse ? 'is-invalid' : ''}`}
                        id="adresse"
                        name="adresse"
                        value={prestataireData.adresse}
                        onChange={handleChange}
                        rows="3"
                        placeholder="Adresse complète de votre entreprise"
                    ></textarea>
                    {errors.adresse && <div className="invalid-feedback">{errors.adresse}</div>}
                </div>
                
                <div className="d-flex gap-2">
                    <button 
                        type="button" 
                        className="btn btn-outline-secondary"
                        onClick={onPrevious}
                    >
                        <i className="bi bi-arrow-left me-2"></i> Précédent
                    </button>
                    <button 
                        type="submit" 
                        className="btn btn-primary flex-grow-1"
                        disabled={loading}
                    >
                        {loading ? (
                            <>
                                <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Traitement en cours...
                            </>
                        ) : (
                            <>
                                S'inscrire <i className="bi bi-check-circle ms-2"></i>
                            </>
                        )}
                    </button>
                </div>
                
                <div className="mt-3 text-center">
                    <small className="text-muted">
                        En vous inscrivant, vous acceptez nos conditions d'utilisation et notre politique de confidentialité.
                    </small>
                </div>
            </form>
        </div>
    );
};

export default InscriptionEtape2;