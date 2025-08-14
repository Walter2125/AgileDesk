<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        ¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña y podrás elegir una nueva.
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Ingresa tu correo @unah.hn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="text-xs text-blue-400 mt-1">Sólo se permiten correos electrónicos @unah.hn o @unah.edu.hn</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Enviar Enlace de Restablecimiento
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
