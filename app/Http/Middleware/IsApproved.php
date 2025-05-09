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

        // Cambiado de $user->role a $user->usertype
        if ($user->usertype === 'collaborator' && $user->is_rejected) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu solicitud fue rechazada.']);
        }

        if ($user->usertype === 'collaborator' && ! $user->is_approved) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta aún no ha sido aprobada.']);
        }

        return $next($request);
    }
}

