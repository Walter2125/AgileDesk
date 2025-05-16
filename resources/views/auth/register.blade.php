<x-guest-layout>
    <div class="auth-header">
        <h2>REGISTRO</h2>
        <div class="auth-header-links">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="active">Inscribirse</a>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nombre de Usuario</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Introduce tu nombre" />
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">E-MAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Tu email va aqui" />
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="password-container">
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <div class="password-container">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password_confirmation')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms of Service -->
        <div class="checkbox-group flex-wrap">
            <input id="terms" type="checkbox" name="terms" required>
            <label for="terms" class="text-sm">Estoy de acuerdo con todas las afirmaciones en<a href="#" class="underline">términos de servicio</a></label>
            @error('terms')
                <p class="text-xs text-red-400 mt-1 w-full">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="auth-submit-btn bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                Registrarse
            </button>
        </div>

    </form>
</x-guest-layout>