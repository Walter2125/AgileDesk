@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>🗂️ Backlog de {{ $proyecto->name }}</h2>

        <!-- Filtro por sprint -->


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
