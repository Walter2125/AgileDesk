<x-guest-layout>
    <div class="auth-header">
        <h2>LOGIN</h2>
        <div class="auth-header-links">
            <a href="{{ route('login') }}" class="active">Iniciar sesión</a>
            <a href="{{ route('register') }}">Inscribirse</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm text-white">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">E-MAIL</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Tu email va aqui" />
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <div class="password-container" style="position: relative;">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <i class="fa-regular fa-eye toggle-password"></i>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Recuerdame</label>
        </div>

        <div class="flex justify-center">
            <button type="submit" class="auth-submit-btn bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                Iniciar sesión
            </button>
        </div>


        <div class="auth-links mt-4 text-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>