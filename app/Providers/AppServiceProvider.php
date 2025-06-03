<?php

namespace App\Providers;

use App\Models\Project;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      Paginator::useBootstrap();
      Project::observe(ProjectObserver::class);

        View::composer('*', function ($view) {
            $route = request()->route();

            if ($route && $route->hasParameter('project')) {
                $projectParam = $route->parameter('project');

                // Si ya es una instancia, úsala. Si es un ID, búscalo.
                $project = $projectParam instanceof Project
                    ? $projectParam
                    : Project::find($projectParam);

                $view->with('currentProject', $project);
            }
        });
    }
}
