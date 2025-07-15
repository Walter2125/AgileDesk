<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Escalado de fuentes SOLO para la navbar, no global */
        .navbar-optimized.font-scale-sm { font-size: 14px !important; }
        .navbar-optimized.font-scale-md { font-size: 16px !important; }
        .navbar-optimized.font-scale-lg { font-size: 18px !important; }
        .navbar-optimized.font-scale-xl { font-size: 20px !important; }

        /* Navbar optimizada */
        .navbar-optimized {
            background: white;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            transition: var(--transition);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 900;
            padding: 0.5rem 0;
            font-size: 1rem;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .navbar-optimized .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            padding: 0 1rem;
            width: 100%;
            margin: 0 auto;
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

        /* Botón escalado - Mejorado */
        .navbar-optimized .btn-scale-toggle {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--dark-color);
            position: relative;
            height: 100%;
            overflow: visible; /* Asegura que el badge nunca se corte */
        }

        .navbar-optimized .btn-scale-toggle:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .navbar-optimized .btn-scale-toggle:active {
            transform: translateY(0);
        }

        .navbar-optimized .btn-scale-toggle.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .navbar-optimized .btn-scale-toggle .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
            border-radius: 50px;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            pointer-events: none;
        }

        @media (max-width: 575.98px) {
          .navbar-optimized .btn-scale-toggle .badge {
            right: -4px;
            top: -4px;
            font-size: 0.7rem;
            padding: 0.18rem 0.32rem;
          }
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

        /* Dropdown mejorado */
        .navbar-optimized .dropdown-optimized {
            position: relative;
            display: inline-block;
        }

        .navbar-optimized .dropdown-menu-optimized {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 1040;
            min-width: 280px;
            padding: 0.5rem;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease-out;
        }

        .navbar-optimized .dropdown-menu-optimized.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-optimized .dropdown-header-optimized {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-optimized .dropdown-item-optimized {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.25rem;
            background: transparent;
            border: none;
            border-radius: calc(var(--border-radius) - 2px);
            color: var(--dark-color);
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .navbar-optimized .dropdown-item-optimized:hover {
            background: var(--hover-bg);
            transform: translateX(4px);
        }

        .navbar-optimized .dropdown-item-optimized.active {
            background: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        .navbar-optimized .dropdown-item-optimized.reset {
            color: var(--danger-color);
            border-top: 1px solid var(--border-color);
            margin-top: 0.5rem;
            padding-top: 0.75rem;
        }

        .navbar-optimized .dropdown-item-optimized.reset:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* Indicadores visuales */
        .navbar-optimized .scale-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: var(--secondary-color);
            padding: 0.125rem 0.375rem;
            background: var(--light-color);
            border-radius: 12px;
        }

        .navbar-optimized .scale-size {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--secondary-color);
        }

        /* Notificaciones */
        .navbar-optimized .notification-optimized {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            max-width: 400px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 1rem;
            animation: slideInRight 0.3s ease-out;
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
        .navbar-optimized .btn-scale-toggle {
            overflow: visible;
            padding-top: 1rem; /* Mayor espacio para que el badge no se corte */
            position: relative; /* Asegura el posicionamiento del badge */
        }

        .navbar-optimized .btn-scale-toggle .badge {
            top: -2px;
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
                        @yield('mensaje-superior')
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-grow-1 justify-content-end h-100" style="min-height:0;">
                
        <div class="dropdown-optimized">
            <button class="btn-optimized btn-scale-toggle" 
                    type="button" 
                    id="fontScaleDropdown" 
                    onclick="toggleFontScaleDropdown(event)"
                    aria-expanded="false"
                    aria-haspopup="true"
                    title="Ajustar tamaño de interfaz">
                <i class="bi bi-zoom-in"></i>
                <span class="d-none d-md-inline">Tamaño</span>
                <span class="badge" id="scale-badge">M</span>
            </button>
        </div>
                <!-- Botón tema optimizado -->
                <button id="dark-mode-toggle-btn" 
                        class="btn-optimized btn-theme-toggle"
                        onclick="toggleTheme()"
                        title="Cambiar tema">
                    <i class="bi bi-moon-fill" id="theme-icon"></i>
                    <span class="d-none d-lg-inline" id="theme-text">Oscuro</span>
                </button>
            </div>
            <!-- Menú de escalado flotante -->
            <div class="dropdown-menu-optimized" id="fontScaleDropdownMenu">
                <div class="scale-menu-wrapper">
                    <div class="scale-menu">
                        <div class="scale-menu-header d-flex align-items-center gap-2 mb-2 fw-semibold text-muted">
                            <i class="bi bi-display"></i>
                            <span>Tamaño de Interfaz</span>
                        </div>

                        <button class="dropdown-item-optimized" data-scale="small" onclick="setFontScale('small')">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-circle-fill" style="font-size: 8px; color: var(--primary-color);"></i>
                                <span>Pequeño</span>
                            </div>
                            <div class="scale-indicator">
                                <div class="scale-size" style="width: 6px; height: 6px;"></div>
                                <span>14px</span>
                            </div>
                        </button>

                        <button class="dropdown-item-optimized active" data-scale="normal" onclick="setFontScale('normal')">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-circle-fill" style="font-size: 10px; color: var(--primary-color);"></i>
                                <span>Normal</span>
                            </div>
                            <div class="scale-indicator">
                                <div class="scale-size" style="width: 8px; height: 8px;"></div>
                                <span>16px</span>
                            </div>
                        </button>

                        <button class="dropdown-item-optimized" data-scale="large" onclick="setFontScale('large')">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-circle-fill" style="font-size: 12px; color: var(--primary-color);"></i>
                                <span>Grande</span>
                            </div>
                            <div class="scale-indicator">
                                <div class="scale-size" style="width: 10px; height: 10px;"></div>
                                <span>18px</span>
                            </div>
                        </button>

                        <button class="dropdown-item-optimized" data-scale="extra-large" onclick="setFontScale('extra-large')">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-circle-fill" style="font-size: 14px; color: var(--primary-color);"></i>
                                <span>Extra Grande</span>
                            </div>
                            <div class="scale-indicator">
                                <div class="scale-size" style="width: 12px; height: 12px;"></div>
                                <span>20px</span>
                            </div>
                        </button>

                        <button class="dropdown-item-optimized reset" onclick="resetFontScale()">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Restablecer</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
        // Configuración unificada de escalado
        const FONT_SCALE_KEY = 'agiledesk_font_scale';
        const THEME_KEY = 'agiledesk_theme';
        
        const SCALE_CONFIGS = {
            small: { 
                name: 'Pequeño', 
                fontSize: '14px', 
                class: 'font-scale-sm',
                badge: 'S' 
            },
            normal: { 
                name: 'Normal', 
                fontSize: '16px', 
                class: 'font-scale-md',
                badge: 'M' 
            },
            large: { 
                name: 'Grande', 
                fontSize: '18px', 
                class: 'font-scale-lg',
                badge: 'L' 
            },
            'extra-large': { 
                name: 'Extra Grande', 
                fontSize: '20px', 
                class: 'font-scale-xl',
                badge: 'XL' 
            }
        };

        // Variable para controlar el estado del dropdown
        let currentDropdown = null;

        // Obtener la escala guardada
        function getSavedFontScale() {
            return localStorage.getItem(FONT_SCALE_KEY) || 'normal';
        }

        // Guardar la escala seleccionada
        function saveFontScale(scale) {
            localStorage.setItem(FONT_SCALE_KEY, scale);
        }

        // Aplicar la escala al documento
        function applyFontScale(scale) {
            const config = SCALE_CONFIGS[scale] || SCALE_CONFIGS.normal;
            
            // Limpiar clases anteriores del body
            document.body.className = document.body.className
                .replace(/font-scale-\w+/g, '');
            
            // Aplicar nueva clase al body
            document.body.classList.add(config.class);
            
            // Aplicar tamaño de fuente al html (afecta a todas las unidades rem)
            document.documentElement.style.fontSize = config.fontSize;
            
            // Actualizar badge visual
            updateScaleIndicator(scale);
            
            // Guardar configuración
            saveFontScale(scale);
            
            console.log(`Escalado aplicado: ${scale} (${config.fontSize})`);
        }

        // Actualizar indicadores visuales
        function updateScaleIndicator(currentScale) {
            // Actualizar badge en el botón
            const badge = document.getElementById('scale-badge');
            if (badge) {
                badge.textContent = SCALE_CONFIGS[currentScale]?.badge || 'M';
            }
            
            // Actualizar estado activo en el dropdown
            document.querySelectorAll('[data-scale]').forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-scale') === currentScale) {
                    item.classList.add('active');
                }
            });
        }

        // Establecer nueva escala
        function setFontScale(scale) {
            const button = document.getElementById('fontScaleDropdown');
            if (button) button.classList.add('loading');
            
            setTimeout(() => {
                applyFontScale(scale);
                closeAllDropdowns();
                showOptimizedNotification(`Tamaño cambiado a ${SCALE_CONFIGS[scale].name}`, 'success');
                if (button) button.classList.remove('loading');
            }, 100);
        }

        // Restablecer escala predeterminada
        function resetFontScale() {
            setFontScale('normal');
            showOptimizedNotification('Tamaño restablecido', 'info');
        }

        // Función corregida para toggle del dropdown
        function toggleFontScaleDropdown(event) {
            event.stopPropagation(); // Evitar que el evento llegue al document.click
            const dropdownMenu = document.getElementById('fontScaleDropdownMenu');
            const button = document.getElementById('fontScaleDropdown');
            
            if (!dropdownMenu || !button) {
                console.error('Elementos del dropdown no encontrados');
                return;
            }

            // Si ya está abierto, cerrarlo
            if (currentDropdown === 'fontScale') {
                closeAllDropdowns();
                return;
            }
            
            // Cerrar otros dropdowns primero
            closeAllDropdowns();
            
            // Abrir este dropdown
            dropdownMenu.classList.add('show');
            button.setAttribute('aria-expanded', 'true');
            button.classList.add('active');
            currentDropdown = 'fontScale';
            
            // Focus en el primer elemento para accesibilidad
            const firstItem = dropdownMenu.querySelector('.dropdown-item-optimized');
            if (firstItem) {
                setTimeout(() => firstItem.focus(), 100);
            }
        }

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

        // Cerrar todos los dropdowns
        function closeAllDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown-menu-optimized');
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            
            const buttons = document.querySelectorAll('[aria-expanded="true"]');
            buttons.forEach(button => {
                button.setAttribute('aria-expanded', 'false');
                button.classList.remove('active');
            });
            
            currentDropdown = null;
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

        // Notificaciones optimizadas
        function showOptimizedNotification(message, type = 'info') {
            // Remover notificaciones existentes
            const existingNotifications = document.querySelectorAll('.notification-optimized');
            existingNotifications.forEach(notif => notif.remove());
            
            const notification = document.createElement('div');
            notification.className = 'notification-optimized';
            
            const icons = {
                success: 'bi-check-circle-fill text-success',
                error: 'bi-x-circle-fill text-danger',
                warning: 'bi-exclamation-triangle-fill text-warning',
                info: 'bi-info-circle-fill text-info'
            };
            
            notification.innerHTML = `
                <div class="d-flex align-items-center gap-3">
                    <i class="bi ${icons[type]} fs-4"></i>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">${message}</div>
                        <small class="text-muted">Configuración actualizada</small>
                    </div>
                    <button type="button" class="btn-close" onclick="this.closest('.notification-optimized').remove()">×</button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove después de 4 segundos
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 4000);
        }

        // Inicialización al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando navbar...');
            
            // Cargar configuraciones guardadas
            const savedScale = getSavedFontScale();
            applyFontScale(savedScale);
            
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
            
            // Configurar evento para cerrar dropdowns al hacer clic fuera
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-optimized')) {
                    closeAllDropdowns();
                }
            });
            
            // Eventos de teclado para cerrar dropdown con Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeAllDropdowns();
                }
                
                // Shortcuts de teclado
                if (event.ctrlKey && event.key === 'k') {
                    event.preventDefault();
                    document.getElementById('fontScaleDropdown').click();
                }
                if (event.ctrlKey && event.key === 't') {
                    event.preventDefault();
                    toggleTheme();
                }
            });
            
            console.log('Navbar inicializada correctamente');
        });

        // Verificar que las funciones estén disponibles globalmente
        window.toggleFontScaleDropdown = toggleFontScaleDropdown;
        window.setFontScale = setFontScale;
        window.resetFontScale = resetFontScale;
        window.toggleSidebar = toggleSidebar;
        window.toggleTheme = toggleTheme;
    </script>
</body>
</html>