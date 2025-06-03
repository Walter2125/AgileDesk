<x-guest-layout>
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
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Ingresa tu nombre completo" />
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Ingresa @unah.hn email" />
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
            <label for="password_confirmation">Confirmar Contraseña</label>
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
            <label for="terms" class="text-sm">Estoy de acuerdo con todo en <a href="#" class="underline">terms of service</a></label>
            @error('terms')
                <p class="text-xs text-red-400 mt-1 w-full">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-center">
            <button type="submit" class="auth-submit-btn text-white font-semibold py-2">
                Registro
            </button>
        </div>

    </form>
</x-guest-layout>