<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Barra principal -->
        <div class="flex items-center justify-between h-16">
            <!-- Izquierda: Sidebar y mensaje -->
            <div class="flex items-center space-x-4">
                <!-- Botón Sidebar -->
                <button class="btn btn-sm btn-light border" onclick="toggleSidebar()">
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
                            data-bs-toggle="dropdown" 
                            aria-expanded="false"
                            title="Ajustar tamaño de fuente">
                        <i class="bi bi-zoom-in me-1"></i>
                        <span class="d-none d-md-inline">Escalado</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="fontScaleDropdown">
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

                <!-- Botón Hamburguesa (responsive) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
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

            <div class="mt-3 space-y-1">
                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                    <?php echo e(__('Profile')); ?>

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

                <!-- Logout -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                        <?php echo e(__('Log Out')); ?>

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
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Script para el sistema de escalado de fuentes -->
<script>
    // Constantes para el sistema de escalado
    const FONT_SCALE_KEY = 'agiledesk_font_scale';
    
    // Configuraciones de escalado
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
    
    // Función para obtener la escala guardada
    function getSavedFontScale() {
        return localStorage.getItem(FONT_SCALE_KEY) || 'normal';
    }
    
    // Función para guardar la escala
    function saveFontScale(scale) {
        localStorage.setItem(FONT_SCALE_KEY, scale);
    }
    
    // Función para aplicar la escala
    function applyFontScale(scale) {
        if (!SCALE_CONFIGS[scale]) {
            console.warn('Escala no válida:', scale);
            scale = 'normal';
        }
        
        const config = SCALE_CONFIGS[scale];
        
        // Remover estilos previos si existen
        const existingStyle = document.getElementById('dynamic-font-scale');
        if (existingStyle) {
            existingStyle.remove();
        }
        
        // Crear nuevo estilo dinámico
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
        
        // Actualizar indicador visual en el dropdown
        updateScaleIndicator(scale);
        
        console.log('✅ Escalado aplicado:', config.name, config.fontSize);
    }
    
    // Función para actualizar el indicador visual
    function updateScaleIndicator(currentScale) {
        // Remover indicadores previos
        document.querySelectorAll('[data-scale]').forEach(item => {
            item.classList.remove('active', 'fw-bold');
            const icon = item.querySelector('i.bi-type');
            if (icon) {
                icon.classList.remove('bi-check-lg');
                icon.classList.add('bi-type');
            }
        });
        
        // Agregar indicador al item actual
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
    
    // Función pública para establecer escala
    function setFontScale(scale) {
        applyFontScale(scale);
        saveFontScale(scale);
        
        // Mostrar notificación temporal
        showScaleNotification(SCALE_CONFIGS[scale].name);
    }
    
    // Función para restablecer escala
    function resetFontScale() {
        setFontScale('normal');
        showScaleNotification('Escalado restablecido a Normal');
    }
    
    // Función para mostrar notificaciones
    function showScaleNotification(message, subtitle = '') {
        // Crear notificación temporal
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
        
        // Auto-remover después de 3 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
    
    // Inicializar sistema de escalado
    document.addEventListener('DOMContentLoaded', function() {
        // Aplicar escala guardada
        const savedScale = getSavedFontScale();
        applyFontScale(savedScale);
        
        console.log('🎨 Sistema de escalado inicializado con:', SCALE_CONFIGS[savedScale].name);
    });
    
    // Exponer funciones globalmente para uso en onclick
    window.setFontScale = setFontScale;
    window.resetFontScale = resetFontScale;
</script>
<?php /**PATH C:\Users\Wally\Herd\AgileDesk\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>