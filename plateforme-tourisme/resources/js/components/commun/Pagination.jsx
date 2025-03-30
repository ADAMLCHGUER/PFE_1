import React from 'react';

const Pagination = ({ currentPage, lastPage, onPageChange }) => {
    const maxVisiblePages = 5;
    const pages = [];
    
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(lastPage, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
    }
    
    return (
        <nav aria-label="Pagination">
            <ul className="pagination justify-content-center">
                <li className={`page-item ${currentPage === 1 ? 'disabled' : ''}`}>
                    <button 
                        className="page-link" 
                        onClick={() => onPageChange(currentPage - 1)}
                        disabled={currentPage === 1}
                    >
                        &laquo; Précédent
                    </button>
                </li>
                
                {startPage > 1 && (
                    <>
                        <li className="page-item">
                            <button className="page-link" onClick={() => onPageChange(1)}>1</button>
                        </li>
                        {startPage > 2 && (
                            <li className="page-item disabled">
                                <span className="page-link">...</span>
                            </li>
                        )}
                    </>
                )}
                
                {pages.map(page => (
                    <li key={page} className={`page-item ${currentPage === page ? 'active' : ''}`}>
                        <button 
                            className="page-link" 
                            onClick={() => onPageChange(page)}
                        >
                            {page}
                        </button>
                    </li>
                ))}
                
                {endPage < lastPage && (
                    <>
                        {endPage < lastPage - 1 && (
                            <li className="page-item disabled">
                                <span className="page-link">...</span>
                            </li>
                        )}
                        <li className="page-item">
                            <button 
                                className="page-link" 
                                onClick={() => onPageChange(lastPage)}
                            >
                                {lastPage}
                            </button>
                        </li>
                    </>
                )}
                
                <li className={`page-item ${currentPage === lastPage ? 'disabled' : ''}`}>
                    <button 
                        className="page-link" 
                        onClick={() => onPageChange(currentPage + 1)}
                        disabled={currentPage === lastPage}
                    >
                        Suivant &raquo;
                    </button>
                </li>
            </ul>
        </nav>
    );
};

export default Pagination;