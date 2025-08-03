@extends('layouts.app')

@section('mensaje-superior')
    Editar Sprint
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card p-4">
            <form action="{{ route('sprints.update', $sprint->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre del Sprint</label>
                    <input type="text" class="form-control" value="{{ $sprint->nombre }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ $sprint->fecha_inicio }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ $sprint->fecha_fin }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('sprints.index', $sprint->proyecto_id) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection
