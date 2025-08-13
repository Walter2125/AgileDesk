<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Superadmin y admin tienen acceso completo sin verificaciones adicionales
        if (in_array($user->usertype, ['superadmin', 'admin'])) {
            return $next($request);
        }

        // Solo aplicar verificaciones de aprobación a colaboradores
        if ($user->usertype === 'collaborator') {
            if ($user->is_rejected) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Tu solicitud fue rechazada.']);
            }

            if (!$user->is_approved) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Tu cuenta aún no ha sido aprobada.']);
            }
        }

        return $next($request);
    }
}

