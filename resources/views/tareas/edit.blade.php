@extends('layouts.app')
        @section('mensaje-superior')
        Editar Tarea: {{ $tarea->nombre }}
        @endsection
            

@section('content')


<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<div class="container" style="max-width: 1200px;">
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulario de Edición de Tarea -->
        <form action="{{ route('tareas.update', [$historia->id, $tarea->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $tarea->nombre }}" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ $tarea->descripcion }}</textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion" {{ $tarea->actividad == 'Configuracion' ? 'selected' : '' }}>Configuración</option>
                    <option value="Desarrollo" {{ $tarea->actividad == 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                    <option value="Prueba" {{ $tarea->actividad == 'Prueba' ? 'selected' : '' }}>Prueba</option>
                    <option value="Diseño" {{ $tarea->actividad == 'Diseño' ? 'selected' : '' }}>Diseño</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
<a href="{{ route('tareas.show', $historia->id) }}" 
   class="btn btn-secondary">
    Cancelar
</a>                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection