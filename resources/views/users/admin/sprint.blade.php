@extends('layouts.app')

@section('mensaje-superior')
    Sprints del Proyecto
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">
        <div class="mb-3 d-flex justify-content-between">
        </div>

        @forelse ($proyecto->sprints as $sprint)
            <!-- CARD DEL SPRINT -->
            <div class="card mb-2 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $sprint->nombre }}</strong><br>
                        <small class="text-muted">Inicio: {{ $sprint->fecha_inicio }} | Fin: {{ $sprint->fecha_fin }}</small>
                    </div>
                    <!-- <div class="d-flex gap-2">
                        <a href="{{ route('sprints.edit', $sprint->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        -->

                        <!-- Botón para abrir el modal -->
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarSprint{{ $sprint->id }}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL DE CONFIRMACIÓN (dentro del foreach) -->
            <div class="modal fade" id="modalEliminarSprint{{ $sprint->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $sprint->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-body text-center">
                            <div class="mb-4">
                                <h5 class="modal-title text-danger" id="confirmDeleteLabel{{ $sprint->id }}">Confirmar Eliminación</h5>
                                <h5 class="modal-title text-danger">¿Deseas eliminar este sprint?</h5>
                                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                <div class="alert alert-danger d-flex align-items-center mt-3">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <div>"<strong>{{ $sprint->nombre }}</strong>" será eliminado permanentemente.</div>
                                </div>
                            </div>

                            <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- MENSAJE CUANDO NO HAY SPRINTS -->
            <div class="alert alert-info">
                No hay sprints registrados en este proyecto.
            </div>
    @endforelse



@endsection

