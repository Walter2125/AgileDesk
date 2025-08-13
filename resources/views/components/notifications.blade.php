{{-- Componente unificado de notificaciones --}}
@php
    // Determinar qué mensaje mostrar (el último que se haya establecido)
    $notification = null;
    $type = null;
    
    if (session('status')) {
        $notification = session('status');
        $type = 'info';
    }
    
    if (session('success')) {
        $notification = session('success');
        $type = 'success';
    }
    
    if (session('error')) {
        $notification = session('error');
        $type = 'error';
    }
    
    // Mapeo de mensajes específicos a español
    $translations = [
        'verification-link-sent' => 'Se ha enviado un nuevo enlace de verificación a tu correo electrónico.',
        'password.sent' => 'Te hemos enviado por correo electrónico el enlace para restablecer tu contraseña.',
        'passwords.sent' => 'Te hemos enviado por correo electrónico el enlace para restablecer tu contraseña.',
        'Your password has been reset.' => 'Tu contraseña ha sido restablecida.',
        'password.reset' => 'Tu contraseña ha sido restablecida.',
        'passwords.reset' => 'Tu contraseña ha sido restablecida.',
        'These credentials do not match our records.' => 'Estas credenciales no coinciden con nuestros registros.',
        'auth.failed' => 'Estas credenciales no coinciden con nuestros registros.',
    ];
    
    // Aplicar traducción si existe
    if ($notification && isset($translations[$notification])) {
        $notification = $translations[$notification];
    }
    
    // Clases CSS según el tipo
    $classes = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
    ];
    
    $iconClasses = [
        'success' => 'fas fa-check-circle text-green-500',
        'error' => 'fas fa-exclamation-triangle text-red-500',
        'info' => 'fas fa-info-circle text-blue-500',
        'warning' => 'fas fa-exclamation-circle text-yellow-500',
    ];

    // Generar ID único para esta notificación
    $notificationId = 'notification-' . Str::random(8);
@endphp

@if($notification)
    <div class="notification-container mb-4" id="{{ $notificationId }}">
        <div class="border-l-4 p-4 rounded-md {{ $classes[$type] ?? $classes['info'] }}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="{{ $iconClasses[$type] ?? $iconClasses['info'] }}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">
                        {{ $notification }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" 
                                class="inline-flex rounded-md p-1.5 text-{{ $type }}-500 hover:bg-{{ $type }}-100 focus:outline-none focus:ring-2 focus:ring-{{ $type }}-600 focus:ring-offset-2"
                                onclick="closeNotification('{{ $notificationId }}')">
                            <span class="sr-only">Cerrar</span>
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-cerrar notificación después de 5 segundos
        setTimeout(function() {
            const notification = document.getElementById('{{ $notificationId }}');
            if (notification) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);

        // Función para cerrar notificación manualmente
        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }
        }
    </script>

    <style>
        .notification-container {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
@endif
