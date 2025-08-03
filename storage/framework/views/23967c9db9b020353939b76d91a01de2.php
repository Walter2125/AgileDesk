<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Navbar</title>
    <!-- Incluir Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #0dcaf0;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --border-color: #dee2e6;
            --hover-bg: #f8f9fa;
            --active-bg: #e9ecef;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-lg: 0 4px 12px rgba(0,0,0,0.15);
            --border-radius: 8px;
            --transition: all 0.2s ease-in-out;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 56px;
            --navbar-padding-x: 1rem;
        }

        /* Navbar optimizada */
        .navbar-optimized {
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            transition: var(--transition);        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        padding: 0.5rem 0;
        font-size: 1rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        box-sizing: border-box;
        max-width: 100vw;
        overflow: hidden;
        }

        .navbar-optimized .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            padding: 0 1rem;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
            max-width: 100%;
            overflow: hidden;
        }

        /* Botones optimizados - Base */
        .navbar-optimized .btn-optimized {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: var(--border-radius);
            border: 1px solid transparent;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.4;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            user-select: none;
            white-space: nowrap;
            min-height: 38px;
            height: 100%;
        }

        .navbar-optimized .btn-optimized:focus {
            outline-offset: 2px;
        }

        .navbar-optimized .btn-optimized:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Botón sidebar toggle - Mejorado */
        .navbar-optimized .btn-sidebar-toggle {
            background: var(--light-color);
            border: 1px solid var(--border-color);
            color: var(--dark-color);
            min-width: 40px;
            padding: 0.5rem;
        }

        .navbar-optimized .btn-sidebar-toggle:hover {
            background: var(--hover-bg);
            border-color: var(--secondary-color);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .navbar-optimized .btn-sidebar-toggle:active {
            transform: translateY(0);
            background: var(--active-bg);
        }

        .navbar-optimized .btn-sidebar-toggle i {
            font-size: 1.1rem;
            transition: transform 0.2s ease;
        }

        .navbar-optimized .btn-sidebar-toggle:hover i {
            transform: scale(1.1);
        }

        /* Botón dark mode - Mejorado */
        .navbar-optimized .btn-theme-toggle {
            background: linear-gradient(135deg, #667eea 0%, #57b0eb 100%);
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .navbar-optimized .btn-theme-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .navbar-optimized .btn-theme-toggle:hover::before {
            left: 100%;
        }

        .navbar-optimized .btn-theme-toggle:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .navbar-optimized .btn-theme-toggle i {
            transition: transform 0.3s ease;
        }

        .navbar-optimized .btn-theme-toggle:hover i {
            transform: rotate(180deg);
        }

        /* Responsive mejorado */
        @media (max-width: 991.98px) {
            .navbar-optimized .btn-optimized .d-none.d-md-inline {
                display: none !important;
            }
            
            .navbar-optimized .btn-optimized {
                min-width: 40px;
                padding: 0.5rem;
            }
            
            .navbar-optimized .d-lg-flex {
                display: none !important;
            }
            
            .navbar-optimized .d-lg-none {
                display: flex !important;
            }
            
            .navbar-sidebar-header {
                margin-left: 0 !important;
            }
        }

        @media (min-width: 992px) {
            .navbar-optimized .d-lg-flex {
                display: flex !important;
            }
            
            .navbar-optimized .d-lg-none {
                display: none !important;
            }
        }


        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .navbar-optimized .btn-optimized .d-none.d-md-inline {
                display: none !important;
            }
            
            .navbar-optimized .btn-optimized {
                min-width: 40px;
                padding: 0.5rem;
            }
        }

        @media (max-width: 991.98px) {
            body.sidebar-collapsed #sidebar-wrapper {
                transform: translateX(-100%) !important; /* Oculta completamente */
                width: 0 !important;
            }

            /* Asegura que el contenido principal ocupe todo el espacio */
            body.sidebar-collapsed #page-content-wrapper {
                margin-left: 0 !important;
            }
        }
        /* Clases de utilidad SOLO dentro de navbar-optimized */
        .navbar-optimized .d-flex {
            display: flex !important;
        }
        
        .navbar-optimized .align-items-center {
            align-items: center !important;
        }
        
        .navbar-optimized .gap-2 {
            gap: 0.5rem !important;
        }
        
        .navbar-optimized .gap-3 {
            gap: 1rem !important;
        }
        
        .navbar-optimized .d-none {
            display: none !important;
        }
        
        .navbar-optimized .d-sm-block {
            display: block !important;
        }
        
        .navbar-optimized .d-lg-none {
            display: none !important;
        }
        
        .navbar-optimized .d-lg-flex {
            display: flex !important;
        }
        
        .navbar-optimized .d-xl-inline {
            display: inline !important;
        }
        
        @media (min-width: 992px) {
            .navbar-optimized .d-lg-none {
                display: none !important;
            }
        }

        /* Animaciones adicionales */
        .navbar-optimized .loading {
            position: relative;
            pointer-events: none;
        }

        .navbar-optimized .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 16px;
            height: 16px;
            margin: -8px 0 0 -8px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .navbar-optimized .flex-grow-1 {
            flex-grow: 1;
        }

        .navbar-optimized .fw-semibold {
            font-weight: 600;
        }

        .navbar-optimized .text-muted {
            color: var(--secondary-color);
        }

        .navbar-optimized .btn-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 50%;
        }

        .navbar-optimized .btn-close:hover {
            background: var(--hover-bg);
        }

        .navbar-optimized .fs-4 {
            font-size: 1.25rem;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-optimized">
        <div class="container-fluid">
            <!-- Botón sidebar y mensaje personalizado pegados al sidebar -->
            <div class="d-flex align-items-center gap-3 navbar-sidebar-header" style="min-width: 0;">
        <style>
        /* Ajuste dinámico del header según el estado del sidebar */
        .navbar-sidebar-header {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s;
        }
        body.sidebar-collapsed .navbar-sidebar-header {
            margin-left: var(--sidebar-collapsed-width);
        }
        @media (max-width: 991.98px) {
            .navbar-sidebar-header {
                margin-left: 0 !important;
            }
        }
        </style>
                <!-- Botón sidebar móvil -->
                <button id="mobile-sidebar-toggle" 
                        class="btn-optimized btn-sidebar-toggle d-lg-none"
                        onclick="toggleSidebar()"
                        aria-label="Toggle sidebar"
                        title="Abrir/cerrar menú">
                    <i class="bi bi-list" id="mobile-sidebar-icon"></i>
                </button>
                <!-- Botón sidebar desktop -->
                <button class="btn-optimized btn-sidebar-toggle d-none d-lg-flex" 
                        onclick="toggleSidebar()"
                        aria-label="Toggle sidebar"
                        title="Contraer/expandir sidebar">
                    <i class="bi bi-layout-sidebar"></i>
                    <span class="d-none d-xl-inline">Menú</span>
                </button>
                <!-- Mensaje personalizado -->
                <div class="d-none d-sm-block" style="min-width: 0;">
                    <div class="text-dark fw-bold text-truncate" style="max-width: 250px;">
                        <?php echo $__env->yieldContent('mensaje-superior'); ?>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end h-100" style="min-height:0;">
                <!-- Botón tema optimizado -->
                <button id="dark-mode-toggle-btn" 
                        class="btn-optimized btn-theme-toggle"
                        onclick="toggleTheme()"
                        title="Cambiar tema">
                    <i class="bi bi-moon-fill" id="theme-icon"></i>
                    <span class="d-none d-lg-inline" id="theme-text">Oscuro</span>
                </button>
            </div>
        </div>
    </div>
    </nav>
    <script>
        // Configuración unificada
        const THEME_KEY = 'agiledesk_theme';

        // Función para alternar tema oscuro/claro
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem(THEME_KEY, newTheme);
            
            // Actualizar icono y texto
            const icon = document.getElementById('theme-icon');
            const text = document.getElementById('theme-text');
            if (icon) {
                icon.className = newTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }
            if (text) {
                text.textContent = newTheme === 'dark' ? 'Claro' : 'Oscuro';
            }
            
        }

        // Función de sidebar mejorada
        function toggleSidebar() {
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            document.body.classList.toggle('sidebar-collapsed');
            
            // Actualizar ícono móvil
            const mobileIcon = document.getElementById('mobile-sidebar-icon');
            if (mobileIcon) {
                mobileIcon.className = isCollapsed ? 'bi bi-x' : 'bi bi-list';
            }
            
            // Guardar estado
            localStorage.setItem('agiledesk_sidebar_collapsed', (!isCollapsed).toString());
        }

        // Función de debugging mejorada
        function debugLayout() {
            const problems = [];
            
            console.log('🔍 Iniciando diagnóstico...');
            
            try {
                // Verificar navbar
                const navbar = document.querySelector('.navbar-optimized');
                if (navbar) {
                    const rect = navbar.getBoundingClientRect();
                    console.log('📏 Navbar:', { width: rect.width, height: rect.height });
                    if (rect.width > window.innerWidth) {
                        problems.push(`Navbar desborda: ${rect.width}px > ${window.innerWidth}px`);
                    }
                } else {
                    problems.push('Navbar no encontrado');
                }
                
                // Verificar errores JavaScript
                const errors = window.console.error || [];
                console.log('🐛 Errores JS detectados:', errors.length);
                
                // Verificar viewport
                console.log('📱 Viewport:', {
                    width: window.innerWidth,
                    height: window.innerHeight,
                    devicePixelRatio: window.devicePixelRatio
                });
                
                if (problems.length === 0) {
                    console.log('✅ Layout OK');
                    showOptimizedNotification('Layout verificado - Sin problemas', 'success');
                } else {
                    console.warn('⚠️ Problemas encontrados:', problems);
                    showOptimizedNotification(`${problems.length} problema(s) encontrado(s)`, 'warning');
                }
            } catch (error) {
                problems.push('Error en función de debugging');
            }
            
            return problems;
        }
        
        // Función debounce para optimizar eventos de resize
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Función para ajustar layout según tamaño de pantalla
        function adjustLayoutForScreen() {
            const width = window.innerWidth;
            const navbar = document.querySelector('.navbar-optimized');
            
            try {
                // Ajustar navbar para pantallas pequeñas
                if (navbar && width < 576) {
                    navbar.style.flexWrap = 'wrap';
                } else if (navbar) {
                    navbar.style.flexWrap = 'nowrap';
                }
                
                console.log(`📐 Layout ajustado para: ${width}px`);
            } catch (error) {
                console.error('Error ajustando layout:', error);
            }
        }

        // Función para detectar errores de Alpine.js (arreglada)
        // Función para corregir errores comunes de Alpine.js
        function fixAlpineErrors() {
            try {
                // Si Alpine aún no está definido, crear un objeto temporal
                if (typeof Alpine === 'undefined') {
                    console.warn('🚨 Alpine.js no está disponible - creando polyfill temporal');
                    window.Alpine = { 
                        version: 'polyfill',
                        start: function() { console.warn('Alpine polyfill activado'); }
                    };
                }
                
                // Definir variables globales comunes usadas por Alpine para prevenir errores
                if (typeof window.color === 'undefined') {
                    window.color = '#ffffff';
                    console.log('🔧 Definida variable global color para Alpine.js');
                }
                
                return true;
            } catch (error) {
                console.error('Error en fixAlpineErrors:', error);
                return false;
            }
        }
        
        function detectAlpineErrors() {
            // Intentar corregir errores primero
            fixAlpineErrors();
            
            // Detectar si Alpine está cargado
            if (typeof Alpine === 'undefined' || Alpine.version === 'polyfill') {
                console.warn('🚨 Alpine.js no está completamente disponible');
                return false;
            }
            
            // Interceptar errores de Alpine
            const originalError = console.error;
            let alpineErrors = [];
            
            console.error = function(...args) {
                const message = args.join(' ');
                if (message.includes('Alpine') || message.includes('x-data') || message.includes('color')) {
                    alpineErrors.push(message);
                    console.warn('🔥 Error Alpine detectado:', message);
                }
                originalError.apply(console, args);
            };
            
            // Verificar directivas Alpine en el DOM (selector corregido)
            try {
                const alpineElements = document.querySelectorAll('[x-data], [x-show], [x-if]');
                console.log(`🔍 Elementos Alpine encontrados: ${alpineElements.length}`);
                
                // Verificar que los elementos tengan todas las variables definidas
                alpineElements.forEach((el, index) => {
                    const xData = el.getAttribute('x-data');
                    if (xData && xData.includes('color')) {
                        console.log(`ℹ️ Elemento Alpine con color en índice ${index + 1}`);
                    }
                });
                
                if (alpineErrors.length > 0) {
                    showOptimizedNotification(`${alpineErrors.length} error(es) de Alpine.js detectado(s)`, 'danger');
                    console.warn('🚨 Resumen errores Alpine:', alpineErrors);
                }
                
                return alpineErrors.length === 0;
            } catch (error) {
                console.error('Error en detectAlpineErrors:', error);
                return false;
            }
        }

        // Inicialización al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando navbar...');
            
            // Corregir errores de Alpine.js lo antes posible
            fixAlpineErrors();
            
            // Cargar tema guardado o detectar preferencia del sistema
            const savedTheme = localStorage.getItem(THEME_KEY);
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialTheme = savedTheme || (systemPrefersDark ? 'dark' : 'light');
            
            document.documentElement.setAttribute('data-bs-theme', initialTheme);
            
            // Configurar tema inicial
            const icon = document.getElementById('theme-icon');
            const text = document.getElementById('theme-text');
            if (icon) {
                icon.className = initialTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            }
            if (text) {
                text.textContent = initialTheme === 'dark' ? 'Claro' : 'Oscuro';
            }
            
            // Eventos de teclado para shortcuts
            document.addEventListener('keydown', function(event) {
                // Shortcuts de teclado
                if (event.ctrlKey && event.key === 't') {
                    event.preventDefault();
                    toggleTheme();
                }
                if (event.ctrlKey && event.key === 'd') {
                    event.preventDefault();
                    debugLayout();
                }
            });
            
            // Resizing responsivo
            window.addEventListener('resize', function() {
                debounce(() => {
                    adjustLayoutForScreen();
                    debugLayout();
                }, 250)();
            });
            
            // Ejecutar verificaciones iniciales
            setTimeout(() => {
                debugLayout();
                fixAlpineErrors();
                detectAlpineErrors();
                console.log('🔧 Verificaciones completadas');
            }, 1000);
            
            console.log('✅ Navbar inicializada correctamente');
            console.log('💡 Comandos disponibles:');
            console.log('  - debugLayout() - Diagnosticar layout');
            console.log('  - detectAlpineErrors() - Verificar Alpine.js');
            console.log('  - Ctrl+D - Debug rápido');
            console.log('  - Ctrl+T - Toggle tema');
        });

        // Verificar que las funciones estén disponibles globalmente
        window.toggleSidebar = toggleSidebar;
        window.toggleTheme = toggleTheme;
        window.debugLayout = debugLayout;
        window.detectAlpineErrors = detectAlpineErrors;
        window.fixAlpineErrors = fixAlpineErrors;
        window.adjustLayoutForScreen = adjustLayoutForScreen;
        
        // Definir color globalmente para evitar errores de Alpine
        window.color = '#ffffff';
    </script>
</body>
</html><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>