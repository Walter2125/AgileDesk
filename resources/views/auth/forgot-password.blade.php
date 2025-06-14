<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter your @unah.hn email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="text-xs text-blue-400 mt-1">Only @unah.hn emails are allowed</p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Email Password Reset Link
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
