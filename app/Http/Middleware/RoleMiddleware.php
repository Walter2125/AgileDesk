<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Si no está autenticado, redirigir al login con mensaje
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'error' => 'Por favor inicia sesión para acceder a esta página',
                'intended' => $request->url() // Guarda la URL a la que intentaba acceder
            ]);
        }
        
        // Verificar si el usuario tiene el rol requerido
        if (Auth::user()->usertype !== $role) {
            // Guardar el mensaje de error en la sesión con una clave diferente
            // que será persistente durante múltiples redirecciones
            Session::flash('persistent_error', 'Acceso restringido');
            Session::flash('persistent_message', 'No tienes los permisos necesarios para acceder a esta sección.');
            
            // Determinar la ruta de redirección según el rol del usuario
            $redirectRoute = $this->getRedirectRouteBasedOnUserType();
            
            return redirect()->route($redirectRoute);
        }
    
        return $next($request);
    }
    
    /**
     * Obtiene la ruta de redirección según el tipo de usuario
     * 
     * @return string
     */
    protected function getRedirectRouteBasedOnUserType()
    {
        $userType = Auth::user()->usertype ?? 'guest';
        
        return match($userType) {
            'admin' => 'homeadmin',
            'user' => 'HomeUser',
            default => 'dashboard', // Ruta por defecto para otros tipos de usuario
        };   
    }
}