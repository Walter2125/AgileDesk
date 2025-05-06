<?php

namespace App\Providers;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * La ruta a la que se redirige tras el login.
     */
    public const HOME = '/dashboard';

    /**
     * Registra bindings de modelo, filtros de rutas, alias de middleware, etc.
     */
    public function boot(): void
    {
        // Registra el alias 'role' para tu RoleMiddleware
        // Usamos el router directamente para asegurar que se registre antes de cargar rutas
        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);

        $this->configureRateLimiting();

        $this->routes(function () {
            // Rutas API
           // Route::middleware('api')
             //   ->prefix('api')
               // ->group(base_path('routes/api.php'));

            // Rutas Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configura los rate limiters de la aplicación.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->user()?->id ?: $request->ip());
        });
    }
}
