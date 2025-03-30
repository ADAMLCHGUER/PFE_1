import React, { useState, useEffect } from 'react';

const Alerte = ({ message, type = 'info', duration = 5000, onClose }) => {
    const [visible, setVisible] = useState(true);

    useEffect(() => {
        if (duration) {
            const timer = setTimeout(() => {
                setVisible(false);
                if (onClose) onClose();
            }, duration);
            
            return () => clearTimeout(timer);
        }
    }, [duration, onClose]);

    if (!visible) return null;

    const alertClass = `alert alert-${type} alert-dismissible fade show`;

    return (
        <div className={alertClass} role="alert">
            {message}
            <button 
                type="button" 
                className="btn-close" 
                onClick={() => {
                    setVisible(false);
                    if (onClose) onClose();
                }}
                aria-label="Fermer"
            ></button>
        </div>
    );
};

export default Alerte;