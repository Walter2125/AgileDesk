// dark-mode.js - Versión corregida con almacenamiento persistente
(function() {
    const DARK_MODE_KEY = 'agiledesk-darkMode'; // Misma clave única
    const html = document.documentElement;
    const body = document.body;
    const toggleBtnId = 'dark-mode-toggle-btn';
    
    function setDarkMode(enabled) {
        if (enabled) {
            // Aplicar a ambos elementos
            html.classList.add('dark-mode');
            body.classList.add('dark-mode');
            html.style.backgroundColor = '#121218';
            localStorage.setItem(DARK_MODE_KEY, 'enabled');
        } else {
            // Remover de ambos elementos
            html.classList.remove('dark-mode');
            body.classList.remove('dark-mode');
            html.style.backgroundColor = '';
            localStorage.setItem(DARK_MODE_KEY, 'disabled');
        }
        
        updateButtonIcon();
    }

    function updateButtonIcon() {
        const btn = document.getElementById(toggleBtnId);
        if (!btn) return;
        
        const modeText = btn.querySelector('.mode-text');
        const icon = btn.querySelector('i');
        
        // Verificar si el modo oscuro está activo
        if (body.classList.contains('dark-mode')) {
            if (icon) icon.className = 'bi bi-sun';
            if (modeText) modeText.textContent = 'Modo Claro';
        } else {
            if (icon) icon.className = 'bi bi-moon';
            if (modeText) modeText.textContent = 'Modo Oscuro';
        }
    }

    function toggleDarkMode() {
        setDarkMode(!body.classList.contains('dark-mode'));
    }

    window.toggleDarkMode = toggleDarkMode;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Sincronizar con el estado inicial
        if (typeof window.initialDarkModeState !== 'undefined') {
            setDarkMode(window.initialDarkModeState);
        } else {
            // Si no hay estado inicial, verificar localStorage
            const saved = localStorage.getItem(DARK_MODE_KEY);
            if (saved === 'enabled') {
                setDarkMode(true);
            } else if (saved === 'disabled') {
                setDarkMode(false);
            }
        }
        
        // Remover clase preload después de la carga
        setTimeout(() => {
            html.classList.remove('dark-mode-preload');
        }, 100);
        
        // Configurar botón toggle si existe
        const btn = document.getElementById(toggleBtnId);
        if (btn) {
            btn.addEventListener('click', toggleDarkMode);
            updateButtonIcon();
        }
        
        // Escuchar cambios en la preferencia del sistema
        if (window.matchMedia) {
            const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            const handleSystemPreferenceChange = (e) => {
                if (!localStorage.getItem(DARK_MODE_KEY)) {
                    setDarkMode(e.matches);
                }
            };
            
            darkModeMediaQuery.addEventListener('change', handleSystemPreferenceChange);
        }
    });
})();