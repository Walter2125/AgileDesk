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
        color:rgb(7, 6, 6);
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

    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #ffffff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004b9a;
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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-2 shadow-md">
                {{ session('success') }}
                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        setTimeout(function () {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }, 3000);
                    }
                });
            </script>
            </div>
        @endif
        @if(session('deleted'))
            <div class="alert alert-info">{{ session('deleted') }}</div>
        @endif

<div class="container py-4" style="max-width: 1200px;">
    <div class="card p-5 mb-5">

        

        <div class="mb-4">
            <label class="fw-bold mb-2">Progreso de tareas completadas:</label>
            <div class="progress">
                <div id="progress-bar" class="progress-bar bg-primary" role="progressbar"
                     style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered text-dark">
            <thead>
                <tr class="text-center">
                    <th>✓</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo de Actividad</th>
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
                    <a href="{{ route('historias.show', ['historia' => $historia->id]) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Atrás
                    </a>
                    <a href="{{ route('tareas.index', $historia->id) }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Nueva Tarea
                    </a>
                </div>
    </div>
    {{-- Aquí van los modales, fuera de la tabla --}}
                    @foreach ($tareas as $tarea)
                        <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <div class="mb-4">
                                            <h5 class="modal-title text-danger" id="deleteModalLabel{{ $tarea->id }}">Confirmar Eliminación</h5>
                                            <h5 class="modal-title text-danger">¿Deseas eliminar esta tarea?</h5>

                                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>

                                            <div class="alert alert-danger d-flex align-items-center mt-3">
                                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                <div>
                                                    "<strong>{{ $tarea->nombre }}</strong>" será eliminada permanentemente.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

    // Escuchar los cambios en todo el documento (delegación de eventos)
    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('tarea-checkbox')) {
            const checkbox = e.target;
            const tareaId = checkbox.dataset.id;
            const estaMarcado = checkbox.checked;

            // Enviar al servidor
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

                    // Sincronizar todos los checkboxes con el mismo data-id
                    document.querySelectorAll(`.tarea-checkbox[data-id="${tareaId}"]`).forEach(cb => {
                        cb.checked = estaMarcado;
                    });
                } else {
                    alert('Error al guardar el progreso.');
                    checkbox.checked = !checkbox.checked;
                }
            });
        }
    });

    window.addEventListener('DOMContentLoaded', actualizarBarraProgreso);
</script>

<script>
    function guardarEstadoCheckbox(tareaId, estado) {
        let estados = JSON.parse(localStorage.getItem('tareasEstado')) || {};
        estados[tareaId] = estado;
        localStorage.setItem('tareasEstado', JSON.stringify(estados));
    }

    function cargarEstadoCheckboxes() {
        let estados = JSON.parse(localStorage.getItem('tareasEstado')) || {};
        document.querySelectorAll('.tarea-checkbox').forEach(cb => {
            const id = cb.dataset.id;
            if (estados.hasOwnProperty(id)) {
                cb.checked = estados[id];
            }
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('tarea-checkbox')) {
            const checkbox = e.target;
            const tareaId = checkbox.dataset.id;
            const estaMarcado = checkbox.checked;

            // Guardar en localStorage
            guardarEstadoCheckbox(tareaId, estaMarcado);

            // Sincronizar checkboxes con el mismo data-id en la misma página
            document.querySelectorAll(`.tarea-checkbox[data-id="${tareaId}"]`)
                    .forEach(cb => cb.checked = estaMarcado);
        }
    });

    // Cargar estado al abrir la página
    window.addEventListener('DOMContentLoaded', cargarEstadoCheckboxes);
</script>
@endsection
