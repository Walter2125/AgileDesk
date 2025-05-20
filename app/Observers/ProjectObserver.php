<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\HistorialCambio;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    public function created(Project $project)
    {
        HistorialCambio::create([
            'fecha'    => now(),
            'usuario'  => Auth::user()->name,
            'accion'   => 'Creación',
            'detalles' => "Proyecto “{$project->name}” creado (ID: {$project->id})",
            'sprint'   => null,
        ]);
    }

    public function updated(Project $project)
    {
        // Aquí podrías comparar $project->getChanges() para detallarlo mejor
        HistorialCambio::create([
            'fecha'    => now(),
            'usuario'  => Auth::user()->name,
            'accion'   => 'Edición',
            'detalles' => "Proyecto “{$project->name}” modificado (ID: {$project->id})",
            'sprint'   => null,
        ]);
    }

    public function deleted(Project $project)
    {
        HistorialCambio::create([
            'fecha'    => now(),
            'usuario'  => Auth::user()->name,
            'accion'   => 'Eliminación',
            'detalles' => "Proyecto “{$project->name}” eliminado (ID: {$project->id})",
            'sprint'   => null,
        ]);
    }
}
