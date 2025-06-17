@extends('layouts.app')

@section('mensaje-superior')
    Lista de Tareas: {{ $historia->nombre }}
@endsection

@section('styles')
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .table {
        color: #000000;
    }

    .table th,
    .table td {
        vertical-align: middle;
        background-color: #ffffff;
        border: 1px solid #ccc;
        font-weight: normal;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .progress {
        height: 25px;
        background-color: #e0e0e0;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #198754;
        color: #ffffff;
        font-weight: bold;
        line-height: 25px;
        transition: width 0.4s ease-in-out;
    }

    .btn {
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    .form-check-input {
        border-radius: 50% !important;
        width: 20px;
        height: 20px;
    }

    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: #0bb2d6;
        border-color: #0bb2d6;
    }

    .alert {
        font-weight: bold;
    }
</style>
@endsection


@section('content')
<div class="container py-4" style="max-width: 1200px;">
    <div class="card p-5 mb-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('deleted'))
            <div class="alert alert-info">{{ session('deleted') }}</div>
        @endif

        <div class="mb-4">
            <label class="fw-bold mb-2">Progreso de tareas completadas:</label>
            <div class="progress">
                <div id="progress-bar" class="progress-bar bg-success" role="progressbar"
                     style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered text-white">
            <thead>
                <tr class="text-center">
                    <th>✓</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox"
                                   class="form-check-input tarea-checkbox"
                                   data-id="{{ $tarea->id }}"
                                   {{ $tarea->completada ? 'checked' : '' }}>
                        </td>
                        <td>{{ $tarea->id }}</td>
                        <td>{{ $tarea->nombre }}</td>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->actividad }}</td>
                        <td>{{ $tarea->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ route('tareas.edit', [$historia->id, $tarea->id]) }}"
                               class="btn btn-outline-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $tarea->id }}" title="Eliminar">
                                <i class="bi bi-trash3"></i>
                            </button>

                            <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1"
                                 aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">¿Eliminar tarea?</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que deseas eliminar <strong>{{ $tarea->nombre }}</strong>?
                                            <p class="text-muted small">Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-info text-white">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay tareas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $tareas->links() }}
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('historias.show', ['historia' => $historia->id]) }}"
               class="btn btn-light text-primary border border-primary rounded-pill px-4 py-2 shadow-sm">
                ⬅️ Cancelar
            </a>
            <a href="{{ route('tareas.index', $historia->id) }}"
               class="btn btn-light text-primary border border-primary rounded-pill px-4 py-2 shadow-sm">
                ➕ Nueva Tarea
            </a>
        </div>
    </div>
</div>

<script>
    function actualizarBarraProgreso() {
        const checkboxes = document.querySelectorAll('.tarea-checkbox');
        const total = checkboxes.length;
        const completadas = [...checkboxes].filter(cb => cb.checked).length;
        const porcentaje = total > 0 ? Math.round((completadas / total) * 100) : 0;

        const progressBar = document.getElementById('progress-bar');
        progressBar.style.width = porcentaje + '%';
        progressBar.setAttribute('aria-valuenow', porcentaje);
        progressBar.textContent = porcentaje + '%';
    }

    document.querySelectorAll('.tarea-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const tareaId = this.dataset.id;

            fetch(`/tareas/${tareaId}/completar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(response => {
                if (response.ok) {
                    actualizarBarraProgreso();
                } else {
                    alert('Error al guardar el progreso.');
                    this.checked = !this.checked;
                }
            });
        });
    });

    window.addEventListener('DOMContentLoaded', actualizarBarraProgreso);
</script>
@endsection
