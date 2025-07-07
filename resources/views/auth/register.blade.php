<x-guest-layout>
    <!-- Estilos para el modal de términos y condiciones -->
    <style>
        /* Animaciones y transiciones para el modal */
        #termsModal {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }
        #termsModal.modal-visible {
            opacity: 1;
        }
        /* Estilos específicos para el encabezado del modal */
        #termsModalLabel {
            color: #2d3a4d !important;
            font-weight: 700 !important;
            font-size: 1.25rem !important;
        }
        /* Mejoras en los colores para asegurar visibilidad */
        #termsModal .bg-white {
            background-color: white !important;
        }
        #termsModal .border-gray-200 {
            border-color: #e5e7eb !important;
        }
        /* Ajustes para pantallas pequeñas */
        @media (max-width: 640px) {
            #termsModal .bg-white {
                max-width: 90%;
                margin: 0 auto;
            }
            #termsModal .p-5 {
                padding: 1rem;
            }
        }
    </style>
    
    <div class="auth-header">
        <h2>Register</h2>
        <div class="auth-header-links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}" class="active">Registro</a>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Ingresa tu nombre completo" maxlength="50" />
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Ingresa @unah.hn o @unah.edu.hn email" maxlength="50" />
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="password-container">
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" maxlength="50"/>
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <div class="password-container">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" maxlength="50"/>
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password_confirmation')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms of Service -->
        <div class="checkbox-group flex-wrap">
            <input id="terms" type="checkbox" name="terms" required>
            <label for="terms" class="text-sm">Estoy de acuerdo con todo en <a href="#" class="underline" onclick="openTermsModal(); return false;">términos de servicio</a></label>
            @error('terms')
                <p class="text-xs text-red-400 mt-1 w-full">{{ $message }}</p>
            @enderror
        </div>
        <!-- Modal de Términos y Condiciones - Versión mejorada -->
        <div class="fixed inset-0 z-50 overflow-auto hidden" id="termsModal" aria-labelledby="termsModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.5);">
            <div class="flex items-center justify-center min-h-screen p-4">
                <!-- Contenido del modal -->
                <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl w-full max-w-2xl mx-auto" style="max-height: 85vh;">
                    <!-- Encabezado del modal -->
                    <div class="flex justify-between items-center p-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                        <h3 class="text-xl font-bold text-gray-900" id="termsModalLabel" style="color: #2d3a4d !important;">
                            Términos y Condiciones
                        </h3>
                        <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Cuerpo del modal con scroll -->
                    <div class="p-5 overflow-y-auto" style="max-height: 60vh;">
                        <h2 class="font-semibold text-gray-800 mt-2">1. Introducción</h2>
                        <p class="text-gray-600 mb-4">Estos Términos y Condiciones rigen el uso de Agile Desk, una plataforma para la gestión de proyectos ágiles en la Universidad Nacional Autónoma de Honduras.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">2. Registro y Cuentas de Usuario</h2>
                        <p class="text-gray-600 mb-4">Para utilizar Agile Desk, los usuarios deben registrarse utilizando una dirección de correo electrónico válida con dominio @unah.hn o @unah.edu.hn.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">3. Uso de la Plataforma</h2>
                        <p class="text-gray-600 mb-4">Los usuarios se comprometen a utilizar la plataforma exclusivamente para fines académicos y profesionales dentro del ámbito universitario.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">4. Privacidad y Datos</h2>
                        <p class="text-gray-600 mb-4">La información personal y académica recopilada será tratada conforme a las políticas de privacidad de la UNAH y las leyes aplicables.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">5. Propiedad Intelectual</h2>
                        <p class="text-gray-600 mb-4">Todo el contenido generado en la plataforma pertenece a sus respectivos autores y a la UNAH según corresponda.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">6. Modificaciones a los Términos</h2>
                        <p class="text-gray-600 mb-4">Estos términos pueden ser modificados en cualquier momento. Los cambios serán notificados a los usuarios registrados.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">7. Limitación de Responsabilidad</h2>
                        <p class="text-gray-600 mb-4">La plataforma se ofrece "tal cual" y la UNAH no será responsable por daños indirectos, incidentales o consecuentes derivados del uso de la plataforma.</p>
                        
                        <h2 class="font-semibold text-gray-800 mt-4">8. Legislación Aplicable</h2>
                        <p class="text-gray-600 mb-4">Estos términos se rigen por las leyes de Honduras. Cualquier disputa relacionada con estos términos será resuelta por los tribunales competentes de Honduras.</p>
                    </div>
                    
                    <!-- Pie del modal -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end border-t border-gray-200 sticky bottom-0">
                        <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm" onclick="closeModal()">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="auth-submit-btn text-white font-semibold py-2">
                Registro
            </button>
        </div>
    </form>

            <!-- JavaScript para controlar el modal -->
            <script>
                // Función para abrir el modal
                function openTermsModal() {
                    const modalElement = document.getElementById('termsModal');
                    if (modalElement) {
                        modalElement.classList.remove('hidden');
                        // Añadir clase de fade-in
                        setTimeout(() => {
                            modalElement.classList.add('modal-visible');
                        }, 10);
                        document.body.style.overflow = 'hidden'; // Previene scroll en el body
                    }
                }
                
                // Función para cerrar el modal
                function closeModal() {
                    const modalElement = document.getElementById('termsModal');
                    if (modalElement) {
                        // Añadir transición de fade-out
                        modalElement.classList.remove('modal-visible');
                        setTimeout(() => {
                            modalElement.classList.add('hidden');
                            document.body.style.overflow = 'auto'; // Restaura el scroll del body
                        }, 200);
                    }
                }
                
                // Asegurarse de que el DOM esté cargado antes de añadir listeners
                document.addEventListener('DOMContentLoaded', function() {
                    // Cerrar al hacer clic fuera del modal
                    const modalElement = document.getElementById('termsModal');
                    if (modalElement) {
                        modalElement.addEventListener('click', function(e) {
                            // Solo cerrar si el clic fue directamente en el fondo del modal
                            if (e.target === this) {
                                closeModal();
                            }
                        });
                    }
                    
                    // Cerrar con la tecla Escape
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && modalElement && !modalElement.classList.contains('hidden')) {
                            closeModal();
                        }
                    });
                });
            </script>
</x-guest-layout>