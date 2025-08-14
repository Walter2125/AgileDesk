@extends('layouts.app')
        @section('mensaje-superior')
           Editar Tarea: {{ $tarea->nombre }}
        @endsection

@section('styles')
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        border-radius: 8px;
        padding: 20px;
    }

    .form-label,
    .fw-bold {
        color: #000000;
    }

    .form-control {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #cccccc;
    }

    .form-control:focus {
        background-color: #ffffff;
        color: #000000;
        border-color: #999999;
    }

    .btn {
        transition: all 0.2s ease-in-out;
        text-decoration: none !important;
        display: inline-block;
        padding: 0.5rem 1rem;
        margin: 0.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-align: center;
        cursor: pointer;
    }

    .btn-outline-secondary {
        color: #6c757d !important;
        border: 1px solid #6c757d !important;
        background-color: transparent !important;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d !important;
        color: #ffffff !important;
        border-color: #6c757d !important;
    }

    .btn-primary {
        background-color: #007bff !important;
        border: 1px solid #007bff !important;
        color: #ffffff !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        border-color: #004b9a !important;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')


<div class="container" style="max-width: 1200px;">
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario de Edición de Tarea -->
        <form action="{{ route('tareas.update', [$historia->id, $tarea->id]) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" maxlength="100" value="{{ $tarea->nombre }}" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ $tarea->descripcion }}</textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion" {{ $tarea->actividad == 'Configuracion' ? 'selected' : '' }}>Configuración</option>
                    <option value="Desarrollo" {{ $tarea->actividad == 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                    <option value="Prueba" {{ $tarea->actividad == 'Prueba' ? 'selected' : '' }}>Prueba</option>
                    <option value="Diseño" {{ $tarea->actividad == 'Diseño' ? 'selected' : '' }}>Diseño</option>
                    <option value="OtroTipo" {{ $tarea->actividad == 'OtroTipo' ? 'selected' : '' }}>Otro Tipo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end mb-3 mt-4">
            <a href="{{ route('historias.show', $historia->id) }}" 
            class="btn btn-secondary btn-form-actions me-2">
            <i class="bi bi-x-lg me-2"></i> Cancelar
            </a>                
            <button type="submit" class="btn btn-primary btn-form-actions"><i class="bi bi-cloud-arrow-up-fill me-1"></i> Guardar Cambios</button>
            </div>

           
        </form>
    </div>
</div>
@endsection