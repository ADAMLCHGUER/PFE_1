import React, { useEffect, useState } from 'react';
import { Line, Bar, Pie } from 'react-chartjs-2';
import { Chart, registerables } from 'chart.js';
import axios from 'axios';

// Enregistrer tous les composants nécessaires pour Chart.js
Chart.register(...registerables);

const GraphiqueStatistiques = () => {
    const [statistiques, setStatistiques] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [periode, setPeriode] = useState('semaine'); // semaine, mois, annee

    useEffect(() => {
        const fetchStatistiques = async () => {
            setLoading(true);
            try {
                const response = await axios.get(`/api/prestataire/statistiques?periode=${periode}`);
                setStatistiques(response.data);
                setError(null);
            } catch (err) {
                setError('Erreur lors du chargement des statistiques');
                console.error(err);
            } finally {
                setLoading(false);
            }
        };

        fetchStatistiques();
    }, [periode]);

    if (loading) {
        return (
            <div className="text-center p-5">
                <div className="spinner-border text-primary" role="status">
                    <span className="visually-hidden">Chargement...</span>
                </div>
                <p className="mt-2">Chargement des statistiques...</p>
            </div>
        );
    }

    if (error) {
        return (
            <div className="alert alert-danger">
                {error}
            </div>
        );
    }

    // Données pour le graphique des visites
    const visitesData = {
        labels: statistiques?.visites_par_jour.map(item => item.date),
        datasets: [
            {
                label: 'Nombre de visites',
                data: statistiques?.visites_par_jour.map(item => item.count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.3
            }
        ]
    };

    // Données pour le graphique des référents
    const referentsData = {
        labels: statistiques?.visites_par_referent.map(item => item.referrer || 'Direct'),
        datasets: [
            {
                data: statistiques?.visites_par_referent.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderWidth: 1
            }
        ]
    };

    // Données pour le graphique des navigateurs
    const navigateursData = {
        labels: statistiques?.visites_par_navigateur.map(item => item.navigateur),
        datasets: [
            {
                label: 'Navigateurs utilisés',
                data: statistiques?.visites_par_navigateur.map(item => item.count),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderWidth: 1
            }
        ]
    };

    return (
        <div className="statistiques">
            {/* En-tête avec statistiques et sélecteur de période */}
            <div className="row mb-4">
                <div className="col-md-8">
                    <h2 className="mb-3">Statistiques de votre service</h2>
                    <div className="row">
                        <div className="col-md-4">
                            <div className="card bg-primary text-white mb-3">
                                <div className="card-body">
                                    <h5 className="card-title">Total des visites</h5>
                                    <p className="card-text display-6">{statistiques?.total_visites}</p>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="card bg-success text-white mb-3">
                                <div className="card-body">
                                    <h5 className="card-title">Visites récentes</h5>
                                    <p className="card-text display-6">{statistiques?.visites_recentes}</p>
                                    <p className="card-text small">7 derniers jours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card mb-3">
                        <div className="card-body">
                            <h5 className="card-title">Période</h5>
                            <select 
                                className="form-select" 
                                value={periode} 
                                onChange={(e) => setPeriode(e.target.value)}
                            >
                                <option value="semaine">7 derniers jours</option>
                                <option value="mois">30 derniers jours</option>
                                <option value="annee">Année en cours</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {/* Graphique des visites */}
            <div className="card mb-4">
                <div className="card-header">
                    <h5 className="mb-0">Évolution des visites</h5>
                </div>
                <div className="card-body">
                    <Line 
                        data={visitesData} 
                        options={{
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false,
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }} 
                    />
                </div>
            </div>

            {/* Graphiques secondaires (référents et navigateurs) */}
            <div className="row">
                <div className="col-md-6">
                    <div className="card mb-4">
                        <div className="card-header">
                            <h5 className="mb-0">Sources de trafic</h5>
                        </div>
                        <div className="card-body">
                            <Pie 
                                data={referentsData} 
                                options={{
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'right',
                                        }
                                    }
                                }} 
                            />
                        </div>
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="card mb-4">
                        <div className="card-header">
                            <h5 className="mb-0">Navigateurs utilisés</h5>
                        </div>
                        <div className="card-body">
                            <Bar 
                                data={navigateursData} 
                                options={{
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: false,
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
                                }} 
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default GraphiqueStatistiques;