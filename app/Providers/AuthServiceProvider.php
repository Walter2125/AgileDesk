<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\SoftDeletePolicy;
use App\Policies\ProjectPolicy;
use App\Models\Project;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Registrar las políticas de Gate para SoftDelete
        Gate::define('soft-delete.viewAny', [SoftDeletePolicy::class, 'viewAny']);
        Gate::define('soft-delete.restore', [SoftDeletePolicy::class, 'restore']);
        Gate::define('soft-delete.forceDelete', [SoftDeletePolicy::class, 'forceDelete']);
    }
}
