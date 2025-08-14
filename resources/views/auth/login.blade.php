<x-guest-layout>
    <div class="auth-header">
        <label for="name">Iniciar Sesión</label>
        <div class="auth-header-links">
            <a href="{{ route('login') }}" class="active">Login</a>
            <a href="{{ route('register') }}">Registro</a>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Sólo correos electrónicos @unah.hn" maxlength="50"/>
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="password-container" style="position: relative;">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" maxlength="50" />
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Recuérdame</label>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="auth-submit-btn text-white font-semibold py-2">
                Iniciar Sesión
            </button>
        </div>


        <div class="auth-links mt-4 text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>