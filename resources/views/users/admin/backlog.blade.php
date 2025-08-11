@extends('layouts.app')

@section('mensaje-superior')
    Backlog
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">
        <!-- Contenedor alineado con las tarjetas -->
        <div class="mb-3 d-flex justify-content-end gap-2" style="margin-left: -22px; margin-right: -22px;">

            <!-- Select Sprint -->
            <form method="GET" class="d-flex gap-2">
                <select name="sprint_id" class="form-select"
                        style="max-height: 38px; height: 38px; width: 250px; border-radius: 0.375rem;"
                        onchange="this.form.submit()">
                    <option value="">Todas las Historias</option>
                    @foreach ($proyecto->sprints as $sprint)
                        <option value="{{ $sprint->id }}" {{ $sprintId == $sprint->id ? 'selected' : '' }}>
                            {{ $sprint->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Botones -->
            <a href="{{ route('historias.create', ['proyecto' => $proyecto->id]) }}"
               class="btn btn-primary"
               style="height: 38px; display: flex; align-items: center;">
                Agregar Historia
            </a>

            @if(auth()->user()->usertype === 'admin')
                <a href="{{ route('backlog.export-pdf', ['project' => $proyecto->id, 'sprint_id' => $sprintId]) }}"
                   class="btn btn-secondary"
                   style="height: 38px; display: flex; align-items: center;"
                   title="Exportar a PDF">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Exportar a PDF
                </a>
            @endif
        </div>

        <!-- Lista de historias -->
        <div class="mt-4" style="margin-left: -22px; margin-right: -22px;">
            @forelse ($historias as $historia)
                <a href="{{ route('historias.show', $historia->id) }}" class="text-decoration-none text-dark">
                    <div class="card mb-2 p-3" style="transition: box-shadow 0.2s; cursor: pointer; width: 100%;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $historia->nombre }}</strong><br>
                                <small class="text-muted">Prioridad: {{ $historia->prioridad }}</small><br>
                                <small class="text-muted">
                                    Estado:
                                    @if ($historia->columna)
                                        {{ $historia->columna->nombre }}
                                    @else
                                        <span class="text-danger">No asignada</span>
                                    @endif
                                </small>
                            </div>
                            @if (is_null($historia->columna_id))
                                <i class="bi bi-exclamation-circle-fill text-danger fs-4" title="No asignada a ninguna columna"></i>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="alert alert-info">No hay historias en el backlog para este proyecto.</div>
            @endforelse
        </div>
    </div>
@endsection
