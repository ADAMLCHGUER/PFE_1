import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';

// Composants React
import SearchBar from './components/accueil/BarreRecherche';
import ServicesPopulaires from './components/accueil/ServicesPopulaires';
import ServicesList from './components/services/ListeServices';
import ServiceDetail from './components/services/DetailService';
import PrestataireStats from './components/prestataire/GraphiqueStatistiques';
import ServiceForm from './components/prestataire/FormulaireService';
import RapportList from './components/rapports/ListeRapports';

// Initialiser les composants React sur les éléments HTML correspondants
const initializeComponent = (elementId, Component) => {
    const element = document.getElementById(elementId);
    if (element) {
        const props = {...element.dataset};
        
        // Convertir les props JSON en objets JavaScript
        Object.keys(props).forEach(key => {
            try {
                props[key] = JSON.parse(props[key]);
            } catch (e) {
                // Si ce n'est pas du JSON valide, garder la valeur telle quelle
            }
        });
        
        const root = createRoot(element);
        root.render(React.createElement(Component, props));
    }
};

// Attendre que le DOM soit chargé avant d'initialiser les composants
document.addEventListener('DOMContentLoaded', () => {
    // Composants de la page d'accueil
    initializeComponent('searchBar', SearchBar);
    initializeComponent('servicesPopulaires', ServicesPopulaires);

    // Composants de la page de liste des services
    initializeComponent('servicesList', ServicesList);

    // Composant de la page de détail d'un service
    initializeComponent('serviceDetail', ServiceDetail);

    // Composants du tableau de bord prestataire
    initializeComponent('prestataireStats', PrestataireStats);
    initializeComponent('serviceForm', ServiceForm);

    // Composant de la liste des rapports
    initializeComponent('rapportList', RapportList);
});