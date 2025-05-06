<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de los datos de registro
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Creación del usuario con rol y aprobación por defecto
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'usertype'     => 'collaborator',  // rol por defecto
            'is_approved'  => false,           // no aprobado aún
        ]);

        // 3. Disparar evento de registro (puede usarse para enviar email u otras acciones)
        event(new Registered($user));

        // 4. Loguear al usuario (el middleware IsApproved lo redirigirá si no está aprobado)
        Auth::login($user);

        // 5. Redirigir al dashboard (o a la ruta que prefieras)
        return redirect(route('dashboard', absolute: false));
    }
}
