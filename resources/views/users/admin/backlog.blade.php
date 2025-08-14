@extends('layouts.app')

@section('mensaje-superior')
    Backlog
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">

        <!-- Contenedor de filtros y botones -->
        <div class="mb-3 d-flex flex-column flex-md-row justify-content-end gap-2 mx-n3 mx-md-n4">

            <!-- Select Sprint -->
            @if($proyecto->sprints->count() > 0)
                <form method="GET" class="d-flex">
                    <select name="sprint_id" class="form-select"
                            style="max-height: 38px; height: 38px; width: 250px;border-radius: 0.375rem"
                            onchange="this.form.submit()">
                        <option value="">Todas las Historias</option>
                        @foreach ($proyecto->sprints as $sprint)
                            <option value="{{ $sprint->id }}" {{ $sprintId == $sprint->id ? 'selected' : '' }}>
                                {{ $sprint->nombre }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            <!-- Botón Agregar Historia -->
            <a href="{{ route('historias.create', ['proyecto' => $proyecto->id]) }}"
               class="btn btn-primary d-flex align-items-center"
               style="height: 38px;">
                Agregar Historia
            </a>

            <!-- Botón Exportar PDF -->
            @if(auth()->user()->usertype === 'admin')
                <a href="{{ route('backlog.export-pdf', ['project' => $proyecto->id, 'sprint_id' => $sprintId]) }}"
                   class="btn btn-secondary d-flex align-items-center"
                   style="height: 38px;"
                   title="Exportar a PDF">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Exportar a PDF
                </a>
            @endif
        </div>

        <!-- Lista de historias -->
        <div class="mt-4 mx-n3 mx-md-n4">
            @forelse ($historias as $historia)
                <a href="{{ route('historias.show', $historia->id) }}" class="text-decoration-none text-dark">
                    <div class="card mb-2 p-3" style="transition: box-shadow 0.2s; cursor: pointer; width: 100%;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong> {{ $historia->proyecto->codigo ?? 'SIN-CÓDIGO' }}-{{ $historia->numero }} : {{ $historia->nombre }}</strong><br>
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
    <style>
        @media (max-width: 576px) {
            .form-select,
            .btn {
                width: 100% !important;
            }

            /* Esto asegura que no quede más pequeño por padding interno del form */
            form.d-flex {
                width: 100%;
            }
        }
    </style>

@endsection
