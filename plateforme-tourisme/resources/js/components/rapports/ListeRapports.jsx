import React from 'react';

const ListeRapports = ({ rapports }) => {
    // Parse les données JSON si nécessaire
    const rapportsData = typeof rapports === 'string' ? JSON.parse(rapports) : rapports;

    if (!rapportsData || rapportsData.length === 0) {
        return (
            <div className="alert alert-info">
                Aucun rapport n'est disponible pour le moment.
            </div>
        );
    }

    return (
        <div className="table-responsive">
            <table className="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Période</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {rapportsData.map(rapport => {
                        // Formatage des dates
                        const debut = new Date(rapport.periode_debut).toLocaleDateString('fr-FR');
                        const fin = new Date(rapport.periode_fin).toLocaleDateString('fr-FR');
                        const creation = new Date(rapport.created_at).toLocaleDateString('fr-FR');
                        
                        return (
                            <tr key={rapport.id}>
                                <td>
                                    <span className={`badge ${rapport.type === 'hebdomadaire' ? 'bg-info' : 'bg-primary'}`}>
                                        {rapport.type === 'hebdomadaire' ? 'Hebdomadaire' : 'Mensuel'}
                                    </span>
                                </td>
                                <td>
                                    Du {debut} au {fin}
                                </td>
                                <td>{creation}</td>
                                <td>
                                    <a 
                                        href={`/prestataire/rapports/${rapport.id}`} 
                                        className="btn btn-sm btn-outline-primary"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <i className="bi bi-file-earmark-pdf me-1"></i>
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        );
                    })}
                </tbody>
            </table>
        </div>
    );
};

export default ListeRapports;