import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Chargement from '../commun/Chargement';

const VisualisationRapport = ({ rapportId }) => {
    const [rapport, setRapport] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchRapport = async () => {
            try {
                const response = await axios.get(`/api/prestataire/rapports/${rapportId}`);
                setRapport(response.data);
                setError(null);
            } catch (err) {
                console.error('Erreur lors du chargement du rapport:', err);
                setError('Impossible de charger le rapport. Veuillez réessayer plus tard.');
            } finally {
                setLoading(false);
            }
        };

        if (rapportId) {
            fetchRapport();
        }
    }, [rapportId]);

    if (loading) {
        return <Chargement message="Chargement du rapport..." />;
    }

    if (error) {
        return (
            <div className="alert alert-danger">
                <h4 className="alert-heading">Erreur!</h4>
                <p>{error}</p>
                <hr />
                <p className="mb-0">
                    <a href="/prestataire/rapports" className="btn btn-outline-danger">
                        <i className="bi bi-arrow-left me-2"></i> Retour aux rapports
                    </a>
                </p>
            </div>
        );
    }

    // Note: Le rapport est normalement un fichier PDF que nous ouvrons via le contrôleur
    // Ce composant est plutôt destiné à afficher des informations supplémentaires ou un cadre
    return (
        <div className="rapport-visualisation">
            <div className="card">
                <div className="card-header bg-primary text-white">
                    <h5 className="mb-0">Rapport {rapport.type}</h5>
                </div>
                <div className="card-body text-center p-5">
                    <h4 className="mb-4">Visualisation du rapport</h4>
                    <p>Période: du {new Date(rapport.periode_debut).toLocaleDateString('fr-FR')} au {new Date(rapport.periode_fin).toLocaleDateString('fr-FR')}</p>
                    <p>Date de création: {new Date(rapport.created_at).toLocaleDateString('fr-FR')}</p>
                    
                    <div className="mt-4">
                        <p>Le rapport s'affiche dans un nouvel onglet ou peut être téléchargé.</p>
                        <a 
                            href={`/prestataire/rapports/${rapportId}?download=1`} 
                            className="btn btn-success"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i className="bi bi-download me-2"></i> Télécharger le rapport
                        </a>
                    </div>
                </div>
                <div className="card-footer bg-white">
                    <a href="/prestataire/rapports" className="btn btn-outline-primary">
                        <i className="bi bi-arrow-left me-2"></i> Retour à la liste des rapports
                    </a>
                </div>
            </div>
        </div>
    );
};

export default VisualisationRapport;