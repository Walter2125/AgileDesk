@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">{{ $project->name }}</h1>
            <div class="btn-group">
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAgregarColumna"
                >Agregar columna</button>

                <button class="btn btn-outline-primary">Crear sprint</button>
            </div>
        </div>

        <!-- Tablero -->
        <div id="kanban-board" class="d-flex gap-3 overflow-auto pb-3" style="min-height: 500px;">
            @foreach($tablero->columnas as $columna)
                <div class="flex-shrink-0 bg-white border rounded shadow-sm d-flex flex-column" style="width: 300px; max-height: 500px;">
                    <div class="d-flex justify-content-between align-items-start bg-light p-2 border-bottom">
                        @if($columna->es_backlog)
                            <strong>{{ $columna->nombre }}</strong>
                        @else
                            <input
                                type="text"
                                value="{{ $columna->nombre }}"
                                class="form-control form-control-sm me-2 editable-title"
                                data-column-id="{{ $columna->id }}"
                            >
                        @endif

                        @if(!$columna->es_backlog)
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item edit-column" href="#">Editar nombre</a></li>
                                    <li><a class="dropdown-item delete-column" href="#">Eliminar</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="overflow-auto p-2" style="flex: 1;">
                        <!-- Aquí irían las historias -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalAgregarColumna" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('columnas.store', $tablero->id) }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar nueva columna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la columna</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <!-- AJAX para actualizar nombre -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editable-title").forEach(input => {
                input.addEventListener("blur", function () {
                    const columnId = this.dataset.columnId;
                    const newName = this.value;

                    fetch(`/columnas/${columnId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ nombre: newName })
                    })
                        .then(response => {
                            if (!response.ok) throw new Error("Error al actualizar");
                            return response.json();
                        })
                        .then(data => {
                            console.log('Nombre actualizado:', data);
                        })
                        .catch(error => {
                            alert("No se pudo actualizar el nombre de la columna.");
                            console.error(error);
                        });
                });
            });
        });
    </script>
@endsection
