@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px;">
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <!-- Título con Icono -->
        <h3 class="text-center mb-4 fw-bold" style="font-size: 1.8em;">
            ✏️ Editar Tarea: {{ $tarea->nombre }}
        </h3>

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

            <!-- Usuario Responsable -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-bold">Usuario Responsable</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Sin asignar</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $tarea->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
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