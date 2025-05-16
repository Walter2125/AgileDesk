<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 1. Validación de los datos de registro
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'], // Agregamos validación de términos
        ]);

        // 2. Creación del usuario con rol y flags por defecto
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password,
            'usertype'     => 'collaborator',
            'is_approved'  => false,
            'is_rejected'  => false,
        ]);

        // 3. Disparar evento de registro (email, logs, etc.)
        event(new Registered($user));

        // 4. NO loguear al usuario hasta que sea aprobado

        // 5. Mostrar página de "pendiente de aprobación"
        return view('pendiente');
    }
}