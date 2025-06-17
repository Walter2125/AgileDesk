<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Izquierda: Sidebar y mensaje -->
            <div class="flex items-center space-x-4">
                <!-- Botón Hamburguesa para Móvil/Tablet - CORREGIDO -->
                <button id="mobile-sidebar-toggle" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out lg:hidden"
                        onclick="toggleSidebar()"
                        aria-label="Toggle sidebar">
                    <i class="bi bi-list text-2xl" id="mobile-sidebar-icon"></i>
                </button>
                <!-- Botón Sidebar para Desktop - CORREGIDO -->
                <button class="btn btn-sm btn-light border d-none d-lg-block sidebar-toggle-desktop" 
                        onclick="toggleSidebar()"
                        aria-label="Toggle sidebar">
                    <i class="bi bi-layout-sidebar"></i>
                </button>
                
                <!-- Mensaje personalizado -->
                <div class="d-none d-sm-block">
                    <div class="text-dark text-truncate fw-bold" style="max-width: 250px; font-size: 1rem;">
                        <?php echo $__env->yieldContent('mensaje-superior'); ?>
                    </div>
                </div>
            </div>

            <!-- Derecha: Enlaces + Dropdown -->
            <div class="flex items-center space-x-6">

                <!-- Selector de Escalado -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center" 
                            type="button" 
                            id="fontScaleDropdown" 
                            onclick="toggleFontScaleDropdown(event)"
                            aria-expanded="false"
                            title="Ajustar tamaño de fuente">
                        <i class="bi bi-zoom-in me-1"></i>
                        <span class="d-none d-md-inline">Escalado</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" 
                        id="fontScaleDropdownMenu" 
                        aria-labelledby="fontScaleDropdown"
                        style="display: none;">
                        <li><h6 class="dropdown-header"><i class="bi bi-display me-1"></i>Tamaño de Interfaz</h6></li>
                        <li>
                            <button class="dropdown-item d-flex justify-content-between align-items-center" 
                                    onclick="setFontScale('small')" 
                                    data-scale="small">
                                <span><i class="bi bi-type me-2"></i>Pequeño</span>
                                <small class="text-muted">14px</small>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex justify-content-between align-items-center" 
                                    onclick="setFontScale('normal')" 
                                    data-scale="normal">
                                <span><i class="bi bi-type me-2"></i>Normal</span>
                                <small class="text-muted">16px</small>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex justify-content-between align-items-center" 
                                    onclick="setFontScale('large')" 
                                    data-scale="large">
                                <span><i class="bi bi-type me-2"></i>Grande</span>
                                <small class="text-muted">18px</small>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex justify-content-between align-items-center" 
                                    onclick="setFontScale('extra-large')" 
                                    data-scale="extra-large">
                                <span><i class="bi bi-type me-2"></i>Extra Grande</span>
                                <small class="text-muted">20px</small>
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger d-flex align-items-center" 
                                    onclick="resetFontScale()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Restablecer
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Información del usuario (opciones en sidebar) -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="text-sm text-gray-600">
                        <?php echo e(Auth::user()->name); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard'))]); ?>
                Dashboard
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800"><?php echo e(Auth::user()->name); ?></div>
                <div class="font-medium text-sm text-gray-500"><?php echo e(Auth::user()->email); ?></div>
            </div>
        </div>
    </div>
</nav>

<style>
/* Estilos para el dropdown personalizado */
.dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    min-width: 200px;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 0.875rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.375rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.dropdown-item:hover,
.dropdown-item:focus {
    color: #1e2125;
    background-color: #e9ecef;
}

.dropdown-header {
    display: block;
    padding: 0.5rem 1rem;
    margin-bottom: 0;
    font-size: 0.75rem;
    color: #6c757d;
    white-space: nowrap;
}

.dropdown-item.active {
    background-color: #0d6efd !important;
    color: white !important;
}
/* Estilos para el botón de hamburguesa móvil */
#mobile-sidebar-toggle {
    display: inline-flex !important; /* Forzar visibilidad */
    background: transparent;
    border: none;
    font-size: 1.5rem;
    padding: 0.5rem;
    cursor: pointer;
    color: #212529;
    z-index: 1001;
    position: relative;
    margin-right: 0.5rem;
    transition: all 0.3s ease;
}

/* Ocultar en desktop */
@media (min-width: 1024px) {
    #mobile-sidebar-toggle {
        display: none !important;
    }
}

/* Mostrar solo en móviles/tablets */
@media (max-width: 1023.98px) {
    #mobile-sidebar-toggle {
        display: inline-flex !important;
    }
    
    .sidebar-toggle-desktop {
        display: none !important;
    }
}
/* Estilos para corregir el desplazamiento del botón toggleSidebar */
.navbar {
    transition: all var(--transition-speed, 0.3s) ease !important;
}

/* Botón sidebar toggle - transición suave */
.btn[onclick*="toggleSidebar"] {
    transition: transform var(--transition-speed, 0.3s) ease !important;
}

/* Compensación para diferentes escalados cuando sidebar está colapsado */
body.sidebar-collapsed .btn[onclick*="toggleSidebar"] {
    transform: translateX(calc((var(--sidebar-width, 280px) - var(--sidebar-collapsed-width, 56px)) * -0.7)) !important;
}

/* Compensación específica para escalado pequeño */
body.font-scale-small.sidebar-collapsed .btn[onclick*="toggleSidebar"],
body.sidebar-collapsed .btn[onclick*="toggleSidebar"][data-font-scale="small"] {
    transform: translateX(calc((var(--sidebar-width, 280px) - var(--sidebar-collapsed-width, 56px)) * -0.8)) !important;
}

/* Compensación para escalado extra grande */
body.font-scale-extra-large.sidebar-collapsed .btn[onclick*="toggleSidebar"],
body.sidebar-collapsed .btn[onclick*="toggleSidebar"][data-font-scale="extra-large"] {
    transform: translateX(calc((var(--sidebar-width, 280px) - var(--sidebar-collapsed-width, 56px)) * -0.6)) !important;
}
</style>

<script>
// Sistema de Escalado (se mantiene igual)
const FONT_SCALE_KEY = 'agiledesk_font_scale';
    
const SCALE_CONFIGS = {
    'small': {
        name: 'Pequeño',
        fontSize: '14px',
        sidebarHeading: '1.4rem',
        listItem: '0.875rem',
        userAvatar: '36px'
    },
    'normal': {
        name: 'Normal',
        fontSize: '16px',
        sidebarHeading: '1.5rem',
        listItem: '1rem',
        userAvatar: '40px'
    },
    'large': {
        name: 'Grande',
        fontSize: '18px',
        sidebarHeading: '1.6rem',
        listItem: '1.1rem',
        userAvatar: '44px'
    },
    'extra-large': {
        name: 'Extra Grande',
        fontSize: '20px',
        sidebarHeading: '1.75rem',
        listItem: '1.2rem',
        userAvatar: '48px'
    }
};

function getSavedFontScale() {
    return localStorage.getItem(FONT_SCALE_KEY) || 'normal';
}

function saveFontScale(scale) {
    localStorage.setItem(FONT_SCALE_KEY, scale);
}

function applyFontScale(scale) {
    if (!SCALE_CONFIGS[scale]) {
        console.warn('Escala no válida:', scale);
        scale = 'normal';
    }
    
    const config = SCALE_CONFIGS[scale];
    
    const existingStyle = document.getElementById('dynamic-font-scale');
    if (existingStyle) {
        existingStyle.remove();
    }
    
    const style = document.createElement('style');
    style.id = 'dynamic-font-scale';
    style.textContent = `
        /* Escalado dinámico - ${config.name} */
        html {
            font-size: ${config.fontSize} !important;
        }
        
        .sidebar-heading {
            font-size: ${config.sidebarHeading} !important;
        }
        
        .list-group-item {
            font-size: ${config.listItem} !important;
        }
        
        .user-avatar {
            width: ${config.userAvatar} !important;
            height: ${config.userAvatar} !important;
            min-width: ${config.userAvatar} !important;
        }
        
        /* Ajustes adicionales para el escalado */
        .navbar {
            min-height: calc(3.5rem * (${config.fontSize.replace('px', '')} / 16)) !important;
        }
        
        .sidebar-toggle-btn {
            min-width: calc(32px * (${config.fontSize.replace('px', '')} / 16)) !important;
            min-height: calc(32px * (${config.fontSize.replace('px', '')} / 16)) !important;
        }
    `;
    
    document.head.appendChild(style);
    updateScaleIndicator(scale);
    
    document.body.setAttribute('data-font-scale', scale);
    document.body.className = document.body.className.replace(/font-scale-\w+/g, '');
    document.body.classList.add(`font-scale-${scale}`);
    
    const sidebarToggleBtn = document.querySelector('.btn[onclick*="toggleSidebar"]');
    if (sidebarToggleBtn) {
        sidebarToggleBtn.setAttribute('data-font-scale', scale);
        sidebarToggleBtn.className = sidebarToggleBtn.className.replace(/font-scale-\w+/g, '');
        sidebarToggleBtn.classList.add(`font-scale-${scale}`);
    }
}

function updateScaleIndicator(currentScale) {
    document.querySelectorAll('[data-scale]').forEach(item => {
        item.classList.remove('active', 'fw-bold');
        const icon = item.querySelector('i.bi-type');
        if (icon) {
            icon.classList.remove('bi-check-lg');
            icon.classList.add('bi-type');
        }
    });
    
    const currentItem = document.querySelector(`[data-scale="${currentScale}"]`);
    if (currentItem) {
        currentItem.classList.add('active', 'fw-bold');
        const icon = currentItem.querySelector('i.bi-type');
        if (icon) {
            icon.classList.remove('bi-type');
            icon.classList.add('bi-check-lg');
        }
    }
}

function toggleFontScaleDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    
    const dropdownMenu = document.getElementById('fontScaleDropdownMenu');
    const button = document.getElementById('fontScaleDropdown');
    
    if (dropdownMenu && button) {
        const isVisible = dropdownMenu.style.display === 'block';
        
        closeAllDropdowns();
        
        if (!isVisible) {
            dropdownMenu.style.display = 'block';
            button.setAttribute('aria-expanded', 'true');
            
            const buttonRect = button.getBoundingClientRect();
            dropdownMenu.style.position = 'fixed';
            dropdownMenu.style.top = (buttonRect.bottom + 5) + 'px';
            dropdownMenu.style.right = (window.innerWidth - buttonRect.right) + 'px';
            dropdownMenu.style.zIndex = '9999';
        } else {
            dropdownMenu.style.display = 'none';
            button.setAttribute('aria-expanded', 'false');
        }
    }
}

function closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        dropdown.style.display = 'none';
    });
    
    const buttons = document.querySelectorAll('[aria-expanded]');
    buttons.forEach(button => {
        button.setAttribute('aria-expanded', 'false');
    });
}

function setFontScale(scale) {
    applyFontScale(scale);
    saveFontScale(scale);
    closeAllDropdowns();
    showScaleNotification(SCALE_CONFIGS[scale].name);
}

function resetFontScale() {
    setFontScale('normal');
    showScaleNotification('Escalado restablecido a Normal');
    closeAllDropdowns();
}

function showScaleNotification(message, subtitle = '') {
    const notification = document.createElement('div');
    notification.className = 'alert alert-info alert-dismissible fade show position-fixed';
    notification.style.cssText = `
        top: 70px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    `;
    
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-zoom-in me-2"></i>
            <div>
                <strong>${message}</strong>
                ${subtitle ? `<br><small class="text-muted">${subtitle}</small>` : ''}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Funciones para el sidebar (NUEVAS)
function toggleSidebar() {
    const isCurrentlyCollapsed = document.body.classList.contains('sidebar-collapsed');
    const newState = !isCurrentlyCollapsed;
    const overlay = document.querySelector('.overlay');
    const mobileIcon = document.getElementById('mobile-sidebar-icon');

    document.body.classList.toggle('sidebar-collapsed', newState);
    localStorage.setItem('agiledesk_sidebar_collapsed', newState.toString());

    if (mobileIcon) {
        if (newState) {
            mobileIcon.classList.remove('bi-x');
            mobileIcon.classList.add('bi-list');
        } else {
            mobileIcon.classList.remove('bi-list');
            mobileIcon.classList.add('bi-x');
        }
    }

    if (window.innerWidth < 992 && overlay) {
        overlay.style.display = newState ? 'none' : 'block';
    }
}

function initializeSidebar() {
    const savedState = localStorage.getItem('agiledesk_sidebar_collapsed') === 'true';
    const mobileIcon = document.getElementById('mobile-sidebar-icon');

    document.body.classList.toggle('sidebar-collapsed', savedState);
    
    if (mobileIcon) {
        mobileIcon.className = savedState ? 'bi bi-list' : 'bi bi-x';
    }

    if (window.innerWidth < 992) {
        const overlay = document.querySelector('.overlay');
        if (overlay) {
            overlay.style.display = savedState ? 'none' : 'block';
        }
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeSidebar();
    
    // Aplicar escala guardada
    const savedScale = getSavedFontScale();
    applyFontScale(savedScale);
    
    window.addEventListener('resize', function() {
        initializeSidebar();
    });
});

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    const fontScaleDropdown = document.getElementById('fontScaleDropdown');
    const fontScaleDropdownMenu = document.getElementById('fontScaleDropdownMenu');
    
    if (fontScaleDropdown && fontScaleDropdownMenu) {
        if (!fontScaleDropdown.contains(event.target) && !fontScaleDropdownMenu.contains(event.target)) {
            fontScaleDropdownMenu.style.display = 'none';
            fontScaleDropdown.setAttribute('aria-expanded', 'false');
        }
    }
});

// Exponer funciones globales
window.setFontScale = setFontScale;
window.resetFontScale = resetFontScale;
window.toggleFontScaleDropdown = toggleFontScaleDropdown;
window.toggleSidebar = toggleSidebar;
</script><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>