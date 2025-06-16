@extends('layouts.app')
        @section('mensaje-superior')
           Lista de Tareas: {{ $historia->nombre }}
        @endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<div class="container" style="max-width: 1200px;">
    <!-- Lista de Tareas -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
       

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        
        @if(session('deleted'))
            <div class="alert alert-info">
                {{ session('deleted') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo de Actividad</th>
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

         <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tareas->links() }}
        </div>

        <!-- Botones -->
<div class="d-flex justify-content-between mt-4">
    <!-- Botón de Cancelar -->
    <a href="{{ route('historias.show', ['historia' => $historia->id]) }}" 
   class="btn btn-light text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
   style="background-color: #e6f2ff;">
   ⬅️ Cancelar
</a>

    <!-- Botón de Crear Tarea -->
    <a href="{{ route('tareas.index', $historia->id) }}" 
   class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm" 
   style="background-color: #e6f2ff;">
     Crear Nueva Tarea
</a>

@endsection