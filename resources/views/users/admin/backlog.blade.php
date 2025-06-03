@extends('layouts.app')

@section('mensaje-superior')
    <div class="mt-4 text-lg font-semibold text-blue-600">

        <h1 class="titulo-historia">🗂️ Backlog de {{ $proyecto->name }}</h1>
    </div>
@endsection

@section('content')
    <div class="container mt-4">


        <!-- Filtro por sprint -->
        <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
            <select name="sprint_id" class="form-select" style="max-height: 38px; height: 38px; max-width: 250px;" onchange="this.form.submit()">

            <option value="">Todos los Sprints</option>
                @foreach ($proyecto->sprints as $sprint)
                    <option value="{{ $sprint->id }}" {{ $sprintId == $sprint->id ? 'selected' : '' }}>
                        {{ $sprint->nombre }}
                    </option>
                @endforeach
            </select>
            <!-- Botón Azul a la par -->
            <a href="{{ route('historias.create', ['proyecto' => $proyecto->id]) }}" class="btn btn-primary" style="height: 38px; display: flex; align-items: center;">
                Agregar Historia
            </a>


            </a>
        </form>

        @forelse ($historias as $historia)
            <div class="card mb-2 p-3">
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
        @empty
            <div class="alert alert-info">No hay historias en el backlog para este proyecto.</div>
        @endforelse
    </div>
@endsection
