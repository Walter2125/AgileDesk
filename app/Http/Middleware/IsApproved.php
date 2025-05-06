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

        // Si es colaborador y está rechazado
        if ($user->role === 'collaborator' && $user->is_rejected) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu solicitud fue rechazada.']);
        }

        // Si es colaborador y no está aprobado aún
        if ($user->role === 'collaborator' && ! $user->is_approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta aún no ha sido aprobada.']);
        }

        return $next($request);
    }
}
