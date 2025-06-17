// Prevenir flash de modo claro a oscuro durante la carga de la página
(function() {
    // Verifica si el modo oscuro está activado (desde localStorage o cualquier otra fuente)
    const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
    
    if (isDarkMode) {
        // Añade la clase preload al html para deshabilitar todas las transiciones
        document.documentElement.classList.add('dark-mode-preload');
        
        // Aplica inmediatamente la clase dark-mode al body para evitar el flash
        document.body.classList.add('dark-mode');
    }
    
    // Elimina la clase preload después de que la página se haya cargado
    window.addEventListener('load', function() {
        // Pequeño retraso para asegurar que todos los estilos se han aplicado
        setTimeout(function() {
            document.documentElement.classList.remove('dark-mode-preload');
        }, 10);
    });
})();
