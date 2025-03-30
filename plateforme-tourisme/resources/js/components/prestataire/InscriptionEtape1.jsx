import React, { useState } from 'react';
import Alerte from '../commun/Alerte';

const InscriptionEtape1 = ({ onNext, onFormDataChange, initialData = {} }) => {
    const [formData, setFormData] = useState({
        name: initialData.name || '',
        email: initialData.email || '',
        password: initialData.password || '',
        password_confirmation: initialData.password_confirmation || ''
    });
    
    const [errors, setErrors] = useState({});
    
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        
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
        
        if (!formData.name.trim()) {
            newErrors.name = 'Le nom est requis';
        }
        
        if (!formData.email.trim()) {
            newErrors.email = 'L\'email est requis';
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            newErrors.email = 'Format d\'email invalide';
        }
        
        if (!formData.password) {
            newErrors.password = 'Le mot de passe est requis';
        } else if (formData.password.length < 8) {
            newErrors.password = 'Le mot de passe doit contenir au moins 8 caractères';
        }
        
        if (formData.password !== formData.password_confirmation) {
            newErrors.password_confirmation = 'Les mots de passe ne correspondent pas';
        }
        
        setErrors(newErrors);
        return Object.keys(newErrors).length === 0;
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        
        if (validateForm()) {
            // Mettre à jour les données du formulaire parent
            onFormDataChange(formData);
            
            // Passer à l'étape suivante
            onNext();
        }
    };
    
    return (
        <div className="inscription-etape1">
            <h4 className="mb-4">Étape 1: Créez votre compte</h4>
            
            {Object.keys(errors).length > 0 && (
                <Alerte 
                    type="danger" 
                    message="Veuillez corriger les erreurs ci-dessous."
                    duration={0}
                />
            )}
            
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="name" className="form-label">Nom complet *</label>
                    <input 
                        type="text" 
                        className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                        id="name"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        placeholder="Votre nom complet"
                    />
                    {errors.name && <div className="invalid-feedback">{errors.name}</div>}
                </div>
                
                <div className="mb-3">
                    <label htmlFor="email" className="form-label">Email *</label>
                    <input 
                        type="email" 
                        className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                        id="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        placeholder="votre@email.com"
                    />
                    {errors.email && <div className="invalid-feedback">{errors.email}</div>}
                </div>
                
                <div className="mb-3">
                    <label htmlFor="password" className="form-label">Mot de passe *</label>
                    <input 
                        type="password" 
                        className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                        id="password"
                        name="password"
                        value={formData.password}
                        onChange={handleChange}
                        placeholder="Minimum 8 caractères"
                    />
                    {errors.password && <div className="invalid-feedback">{errors.password}</div>}
                </div>
                
                <div className="mb-4">
                    <label htmlFor="password_confirmation" className="form-label">Confirmation du mot de passe *</label>
                    <input 
                        type="password" 
                        className={`form-control ${errors.password_confirmation ? 'is-invalid' : ''}`}
                        id="password_confirmation"
                        name="password_confirmation"
                        value={formData.password_confirmation}
                        onChange={handleChange}
                        placeholder="Confirmez votre mot de passe"
                    />
                    {errors.password_confirmation && <div className="invalid-feedback">{errors.password_confirmation}</div>}
                </div>
                
                <div className="d-grid">
                    <button type="submit" className="btn btn-primary">
                        Suivant <i className="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    );
};

export default InscriptionEtape1;