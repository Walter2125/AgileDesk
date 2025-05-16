// Este archivo debe ser colocado en resources/js/auth-tabs.js
// Luego, importarlo en tu archivo resources/js/app.js

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en una página de autenticación
    const authHeaderLinks = document.querySelector('.auth-header-links');
    if (!authHeaderLinks) return;

    // Obtener todos los enlaces de la cabecera de autenticación
    const links = authHeaderLinks.querySelectorAll('a');
    
    // Agregar evento click a cada enlace
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Prevenir la navegación por defecto
            e.preventDefault();
            
            // Eliminar la clase 'active' de todos los enlaces
            links.forEach(l => l.classList.remove('active'));
            
            // Agregar la clase 'active' al enlace clickeado
            this.classList.add('active');
            
            // Redirigir a la ruta correspondiente después de un breve retraso para ver el efecto
            setTimeout(() => {
                window.location.href = this.getAttribute('href');
            }, 300);
        });
    });

    // Función para ajustar el alto en dispositivos móviles
    function adjustHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);

        // Ajustar altura en móviles para evitar problemas con la barra de navegación
        const authCard = document.querySelector('.auth-card');
        if (authCard) {
            if (window.innerWidth < 768) {
                authCard.style.minHeight = `calc(var(--vh, 1vh) * 100)`;
            } else {
                authCard.style.minHeight = '550px';
            }
        }
    }

    // Llamar al ajuste inicial
    adjustHeight();
    
    // Volver a calcular cuando cambie el tamaño de la ventana
    window.addEventListener('resize', adjustHeight);
    
    // Volver a calcular cuando cambie la orientación del dispositivo
    window.addEventListener('orientationchange', adjustHeight);

    // Añadir clase para controlar mejor la animación de transición
    document.body.classList.add('auth-loaded');
});