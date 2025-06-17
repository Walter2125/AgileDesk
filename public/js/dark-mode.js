// dark-mode.js - Optimizado
(function() {
    const DARK_MODE_KEY = 'agiledesk_dark_mode';
    const body = document.body;
    const toggleBtnId = 'dark-mode-toggle-btn';
    const TRANSITION_DURATION = 300; // ms

    function setDarkMode(enabled) {
        // Añadir clase de transición
        body.classList.add('theme-transition');
        
        if (enabled) {
            body.classList.add('dark-mode');
            localStorage.setItem(DARK_MODE_KEY, '1');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem(DARK_MODE_KEY, '0');
        }
        
        updateButtonIcon();
        
        // Eliminar clase de transición después de la animación
        setTimeout(() => {
            body.classList.remove('theme-transition');
        }, TRANSITION_DURATION);
    }

    function updateButtonIcon() {
        const btn = document.getElementById(toggleBtnId);
        if (!btn) return;
        
        const modeText = btn.querySelector('.mode-text');
        const icon = btn.querySelector('i');
        
        if (body.classList.contains('dark-mode')) {
            if (icon) icon.className = 'bi bi-sun';
            if (modeText) modeText.textContent = 'Modo Claro';
            else btn.innerHTML = '<i class="bi bi-sun"></i> <span class="mode-text">Modo Claro</span>';
        } else {
            if (icon) icon.className = 'bi bi-moon';
            if (modeText) modeText.textContent = 'Modo Oscuro';
            else btn.innerHTML = '<i class="bi bi-moon"></i> <span class="mode-text">Modo Oscuro</span>';
        }
    }

    function toggleDarkMode() {
        setDarkMode(!body.classList.contains('dark-mode'));
    }

    // Detectar preferencia del sistema
    function getSystemPreference() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    // Expose for global use
    window.toggleDarkMode = toggleDarkMode;
    window.setDarkMode = setDarkMode;

    // On load, set mode from localStorage or system preference
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar inmediatamente para evitar flash de tema incorrecto
        const saved = localStorage.getItem(DARK_MODE_KEY);
        
        if (saved === null) {
            // Si no hay preferencia guardada, usar la del sistema
            setDarkMode(getSystemPreference());
        } else {
            setDarkMode(saved === '1');
        }
        
        // Attach event if button exists
        const btn = document.getElementById(toggleBtnId);
        if (btn) {
            btn.addEventListener('click', toggleDarkMode);
        }
        
        // Escuchar cambios en la preferencia del sistema
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)')
                .addEventListener('change', e => {
                    // Solo cambiar si no hay preferencia guardada por el usuario
                    if (localStorage.getItem(DARK_MODE_KEY) === null) {
                        setDarkMode(e.matches);
                    }
                });
        }
    });
})();
