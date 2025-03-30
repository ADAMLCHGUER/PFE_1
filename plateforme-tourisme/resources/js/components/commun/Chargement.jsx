import React from 'react';

const Chargement = ({ message = 'Chargement en cours...' }) => {
    return (
        <div className="text-center py-5">
            <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Chargement...</span>
            </div>
            <p className="mt-3">{message}</p>
        </div>
    );
};

export default Chargement;