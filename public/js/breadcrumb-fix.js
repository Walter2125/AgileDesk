/**
 * Script para forzar la visibilidad de los breadcrumbs
 * Este script asegura que las migas de pan sean visibles en todas las condiciones
 */

document.addEventListener('DOMContentLoaded', function() {
    // Función para forzar la visibilidad de los breadcrumbs
    function fixBreadcrumbs() {
        // Seleccionar el contenedor de breadcrumbs
        const breadcrumbContainer = document.querySelector('.breadcrumb-container');
        const breadcrumb = document.querySelector('.breadcrumb');
        const breadcrumbItems = document.querySelectorAll('.breadcrumb-item');
        
        // Si existe el contenedor, aplicar estilos forzados
        if (breadcrumbContainer) {
            // Aplicar estilos con la máxima prioridad
            Object.assign(breadcrumbContainer.style, {
                display: 'block !important',
                visibility: 'visible !important',
                opacity: '1 !important',
                marginTop: '60px !important',
                marginBottom: '15px !important',
                padding: '8px !important',
                position: 'relative !important',
                zIndex: '1200 !important',
                backgroundColor: '#f8f9fa !important',
                borderRadius: '4px !important',
                boxShadow: '0 2px 5px rgba(0,0,0,0.08) !important',
                border: '1px solid #dee2e6 !important',
                minHeight: '40px !important'
            });
            
            // Forzar visibilidad con setAttribute
            breadcrumbContainer.setAttribute('style', breadcrumbContainer.getAttribute('style') + '; display: block !important; visibility: visible !important; opacity: 1 !important;');
            
        } else {
        }
        
        // Si existe el breadcrumb, aplicar estilos
        if (breadcrumb) {
            Object.assign(breadcrumb.style, {
                display: 'flex !important',
                visibility: 'visible !important',
                opacity: '1 !important',
                margin: '0 !important',
                padding: '8px !important',
                backgroundColor: '#fff !important',
                borderRadius: '4px !important'
            });
            
        }
        
        // Aplicar estilos a cada item
        if (breadcrumbItems.length > 0) {
            breadcrumbItems.forEach(item => {
                Object.assign(item.style, {
                    display: 'inline-flex !important',
                    alignItems: 'center !important'
                });
            });
            
        }
        
        // Ajustar el espacio para el navbar
        const pageContentWrapper = document.getElementById('page-content-wrapper');
        if (pageContentWrapper) {
            pageContentWrapper.style.paddingTop = '60px !important';
        }
    }
    
    // Ejecutar la función inicialmente
    fixBreadcrumbs();
    
    // Y también después de un breve retraso para asegurar que todos los elementos estén cargados
    setTimeout(fixBreadcrumbs, 500);
    
    // Observar cambios en el DOM que podrían afectar la visibilidad
    const observer = new MutationObserver(function(mutations) {
        fixBreadcrumbs();
    });
    
    // Observar cambios en el body
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // También corregir después de eventos de carga y resize
    window.addEventListener('load', fixBreadcrumbs);
    window.addEventListener('resize', fixBreadcrumbs);
});
