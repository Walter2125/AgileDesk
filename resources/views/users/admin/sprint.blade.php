@extends('layouts.app')

@section('mensaje-superior')
    Sprints del Proyecto
@endsection

@section('content')
<div class="container-fluid mt-4 px-4">

    <!-- Lista de Sprints -->
    <div class="mx-n3 mx-md-n4">
        @forelse ($proyecto->sprints as $sprint)
            <div class="card mb-2 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $sprint->nombre }}</strong><br>
                        <small class="text-muted">Inicio: {{ $sprint->fecha_inicio }} | Fin: {{ $sprint->fecha_fin }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sprints.edit', $sprint->id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1">
                            <i class="bi bi-pencil" style="font-size: 0.9rem;"></i>
                        </a>

                        <!-- Botón para abrir modal -->
                        <button type="button"
                            class="btn btn-outline-danger btn-sm px-2 py-1"
                            title="Eliminar Sprint"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteSprintModal"
                            data-sprint-id="{{ $sprint->id }}"
                            data-sprint-nombre="{{ $sprint->nombre }}">
                            <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                No hay sprints registrados en este proyecto.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal para confirmar eliminación de sprint -->
<div class="modal fade" id="deleteSprintModal" tabindex="-1" aria-labelledby="deleteSprintModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center"> <!-- Centramos todo -->

            <div class="modal-header justify-content-center position-relative">
                <h5 class="modal-title" id="deleteProjectModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
                <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p id="deleteSprintText">¿Está seguro de que desea eliminar este sprint?</p>
            </div>

            <div class="modal-footer justify-content-center"> <!-- Botones centrados -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteSprintModal = document.getElementById('deleteSprintModal');
    const deleteSprintForm = document.getElementById('deleteSprintForm');
    const deleteSprintText = document.getElementById('deleteSprintText');

    deleteSprintModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const sprintId = button.getAttribute('data-sprint-id');
        const sprintNombre = button.getAttribute('data-sprint-nombre') || '';

        deleteSprintText.textContent = ¿Está seguro de que desea eliminar el sprint "${sprintNombre}"?;
        deleteSprintForm.action = /sprints/${sprintId};
    });
});
</script>
@endpush

@push('css')
<style>
.modal-content {
    border: none;
    border-radius: 12px;
}
.modal-header {
    border-bottom: 1px solid #e1e4e8;
    background-color: #f6f8fa;
}
.modal-body p {
    margin-top: 10px;
    font-size: 16px;
}

.modal-footer .btn {
    min-width: 180px; /* Botones del mismo ancho */
}

</style>
@endpush
@endsection