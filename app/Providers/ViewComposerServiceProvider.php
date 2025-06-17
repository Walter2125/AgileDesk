<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use App\Models\Project;
use App\Models\Historia;
use App\Models\Columna;
use App\Models\Tablero;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('*', function ($view) {
            $data = $view->getData();

            if (isset($data['currentProject']) && $data['currentProject'] instanceof \App\Models\Project) {
                $currentProject = $data['currentProject'];
            } elseif (isset($data['historia']) && $data['historia']->columna?->tablero?->project) {
                $currentProject = $data['historia']->columna->tablero->project;
            } elseif (isset($data['tablero']) && $data['tablero']->project) {
                $currentProject = $data['tablero']->project;
            }elseif (isset($data['proyecto']) && $data['proyecto'] instanceof \App\Models\Project) {
                $currentProject = $data['proyecto'];
            } elseif (isset($data['columna']) && $data['columna']->tablero?->project) {
                $currentProject = $data['columna']->tablero->project;
            } else {
                $currentProject = null;
            }

            View::share('currentProject', $currentProject);
        });

    }


    public function register()
    {
        //
    }
}
