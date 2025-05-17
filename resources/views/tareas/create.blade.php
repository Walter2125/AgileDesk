@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px;">
    <!-- Tarjeta de Crear Nueva Tarea -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <!-- Título con Icono -->
        <h3 class="text-center mb-4 fw-bold" style="font-size: 1.8em;">
            📝 Crear Nueva Tarea para la Historia: {{ $historia->nombre }}
        </h3>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Información del Usuario -->
        @if(Auth::check())
            <div class="mb-4">
                <strong>Bienvenido, {{ Auth::user()->name }}</strong>
            </div>
        @else
            <div class="mb-4">
                <strong>Usuario no autenticado</strong>
            </div>
        @endif

        <!-- Formulario de Nueva Tarea -->
        <form action="{{ route('tareas.store', $historia->id) }}" method="POST">
            @csrf
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion">Configuración</option>
                    <option value="Desarrollo">Desarrollo</option>
                    <option value="Prueba">Prueba</option>
                    <option value="Diseño">Diseño</option>
                </select>
            </div>

            <!-- Usuario Responsable -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-bold">Usuario Responsable</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Sin asignar</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear Tarea</button>
            </div>
        </form>
    </div>

    <!-- Lista de Tareas -->
    <div class="container" style="max-width: 1200px;">
    <!-- Lista de Tareas -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <h3 class="text-center mb-4 fw-bold" style="font-size: 1.8em;">
            📋 Lista de Tareas para la Historia: {{ $historia->nombre }}
        </h3>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Actividad</th>
                    <th>Usuario</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->id }}</td>
                        <td>{{ $tarea->nombre }}</td>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->actividad }}</td>
                        <td>{{ optional($tarea->user)->name ?? 'Sin asignar' }}</td>
                        <td>{{ $tarea->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">

                            <!-- Botón Editar (icono) -->
                            <a href="{{ route('tareas.edit', [$historia->id, $tarea->id]) }}" 
                               class="btn btn-outline-warning btn-sm" 
                               title="Editar Tarea">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Botón Eliminar que abre el modal -->
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $tarea->id }}"
                                    title="Eliminar Tarea">
                                <i class="bi bi-trash3"></i>
                            </button>

                            <!-- Modal de confirmación de eliminación -->
                            <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $tarea->id }}">
                                                Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">¿Estás seguro de que deseas eliminar la tarea <strong>{{ $tarea->nombre }}</strong>?</p>
                                            <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-info text-white">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay tareas registradas para esta historia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

@endsection