import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Line } from 'react-chartjs-2';
import { Chart, registerables } from 'chart.js';
import Chargement from '../commun/Chargement';

// Register Chart.js components
Chart.register(...registerables);

const Tableau = () => {
    const [dashboardData, setDashboardData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchDashboardData = async () => {
            try {
                const response = await axios.get('/api/prestataire/dashboard');
                setDashboardData(response.data);
                setError(null);
            } catch (err) {
                console.error('Erreur lors du chargement des données du tableau de bord:', err);
                setError('Impossible de charger les données du tableau de bord.');
            } finally {
                setLoading(false);
            }
        };

        fetchDashboardData();
    }, []);

    // Chart configuration
    const chartData = {
        labels: dashboardData?.visites_par_jour?.map(item => item.date) || [],
        datasets: [{
            label: 'Visites',
            data: dashboardData?.visites_par_jour?.map(item => item.count) || [],
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    };

    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    };

    if (loading) {
        return <Chargement message="Chargement du tableau de bord..." />;
    }

    if (error) {
        return (
            <div className="alert alert-danger" role="alert">
                <i className="bi bi-exclamation-triangle me-2"></i>
                {error}
            </div>
        );
    }

    if (!dashboardData?.service) {
        return (
            <div className="alert alert-info" role="alert">
                <h4 className="alert-heading">
                    <i className="bi bi-info-circle me-2"></i>
                    Bienvenue sur votre tableau de bord!
                </h4>
                <p>Vous n'avez pas encore créé votre service touristique.</p>
                <hr />
                <p className="mb-0">
                    <a href="/prestataire/service/creation" className="btn btn-primary">
                        <i className="bi bi-plus-circle me-2"></i>
                        Créer mon service
                    </a>
                </p>
            </div>
        );
    }

    return (
        <div className="tableau-prestataire">
            <div className="row mb-4">
                <div className="col-md-6">
                    <div className="card h-100">
                        <div className="card-header bg-primary text-white">
                            <h5 className="mb-0">Informations de votre service</h5>
                        </div>
                        <div className="card-body">
                            <h4>{dashboardData.service.titre}</h4>
                            <p className="text-muted mb-4">
                                {dashboardData.service.description.length > 150 
                                    ? `${dashboardData.service.description.substring(0, 150)}...`
                                    : dashboardData.service.description
                                }
                            </p>
                            <dl className="row mb-0">
                                <dt className="col-sm-4">Catégorie</dt>
                                <dd className="col-sm-8">{dashboardData.service.categorie.nom}</dd>
                                
                                <dt className="col-sm-4">Ville</dt>
                                <dd className="col-sm-8">{dashboardData.service.ville.nom}</dd>
                                
                                <dt className="col-sm-4">Adresse</dt>
                                <dd className="col-sm-8">{dashboardData.service.adresse}</dd>
                            </dl>
                        </div>
                        <div className="card-footer bg-white">
                            <div className="d-flex gap-2">
                                <a href={`/services/${dashboardData.service.slug}`} className="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                    <i className="bi bi-eye me-1"></i> Voir la page publique
                                </a>
                                <a href="/prestataire/service/modification" className="btn btn-sm btn-outline-secondary">
                                    <i className="bi bi-pencil me-1"></i> Modifier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div className="col-md-6">
                    <div className="card h-100">
                        <div className="card-header bg-success text-white">
                            <h5 className="mb-0">Statistiques rapides</h5>
                        </div>
                        <div className="card-body">
                            <div className="row text-center">
                                <div className="col-md-6 mb-3">
                                    <h2 className="mb-0">{dashboardData.total_visites}</h2>
                                    <p className="text-muted">Visites totales</p>
                                </div>
                                <div className="col-md-6 mb-3">
                                    <h2 className="mb-0">{dashboardData.visites_recentes}</h2>
                                    <p className="text-muted">7 derniers jours</p>
                                </div>
                            </div>
                            
                            <div className="mt-3">
                                <Line data={chartData} options={chartOptions} />
                            </div>
                        </div>
                        <div className="card-footer bg-white">
                            <a href="/prestataire/statistiques" className="btn btn-sm btn-outline-success">
                                <i className="bi bi-graph-up me-1"></i> Statistiques détaillées
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div className="row">
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-header bg-info text-white">
                            <h5 className="mb-0">Derniers rapports</h5>
                        </div>
                        <div className="card-body">
                            {dashboardData.rapports && dashboardData.rapports.length > 0 ? (
                                <div className="table-responsive">
                                    <table className="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Période</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {dashboardData.rapports.map(rapport => (
                                                <tr key={rapport.id}>
                                                    <td>
                                                        <span className={`badge bg-${rapport.type === 'hebdomadaire' ? 'info' : 'primary'}`}>
                                                            {rapport.type === 'hebdomadaire' ? 'Hebdomadaire' : 'Mensuel'}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {new Date(rapport.periode_debut).toLocaleDateString('fr-FR')} - {new Date(rapport.periode_fin).toLocaleDateString('fr-FR')}
                                                    </td>
                                                    <td>{new Date(rapport.created_at).toLocaleDateString('fr-FR')}</td>
                                                    <td>
                                                        <a href={`/prestataire/rapports/${rapport.id}`} className="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                                            <i className="bi bi-file-earmark-pdf me-1"></i> Voir
                                                        </a>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            ) : (
                                <p className="text-muted mb-0">Aucun rapport n'est disponible pour le moment.</p>
                            )}
                        </div>
                        <div className="card-footer bg-white">
                            <a href="/prestataire/rapports" className="btn btn-sm btn-outline-info">
                                <i className="bi bi-journals me-1"></i> Tous les rapports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Tableau;