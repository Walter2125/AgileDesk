<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\UnahEmailRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        // Convertir email a minúsculas antes de la validación
        $request->merge(['email' => strtolower($request->email)]);
        
        // 1. Validación de los datos de registro
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:'.User::class,
                new UnahEmailRule()
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'], // Agregamos validación de términos
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe proporcionar una dirección de correo electrónico válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'terms.required' => 'Debe aceptar los términos y condiciones.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Verificar si es el primer usuario (futuro superadministrador)
        $isFirstUser = User::count() === 0;
        
        // Determinar el tipo de usuario y estado de aprobación
        if ($isFirstUser) {
            $usertype = 'superadmin';
            $isApproved = true;  // El superadmin se aprueba automáticamente
        } else {
            $usertype = 'collaborator';
            $isApproved = false; // Los demás usuarios requieren aprobación
        }

        // 3. Creación del usuario con rol y flags por defecto
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => $request->password,
            'usertype'     => $usertype,
            'is_approved'  => $isApproved,
            'is_rejected'  => false,
        ]);

        // 4. Disparar evento de registro (email, logs, etc.)
        event(new Registered($user));

        // 5. Manejo del login según el tipo de usuario
        if ($isFirstUser) {
            // El superadmin se loguea automáticamente
            Auth::login($user);
            return redirect()->route('dashboard');
        } else {
            // Los demás usuarios no se loguean hasta ser aprobados
            return view('pendiente');
        }
    }
}