@extends('layouts.app')

 @section('mensaje-superior')
            <div class="mt-4 text-lg font-semibold text-blue-600">

            <h1 class="titulo-historia">🗂️ Tablero de {{ $project->name }}</h1>
            </div>
        @endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @php

$colCount = $tablero->columnas->count();
        $widthStyle = ($colCount <= 4)
            ? 'width: calc(100% / ' . $colCount . ' - 1rem); max-width: none;'
            : 'width: 300px; flex-shrink: 0;';
    @endphp

    <div class="container py-4">
                
            <!-- No borren esta nofificacion -->
                @if (session('success'))
                            <div class="alert alert-success mt-2" id="success-alert">
                                {{ session('success') }}
                            </div>

                            <script>
                                setTimeout(function() {
                                    const alert = document.getElementById('success-alert');
                                    if (alert) {
                                        alert.style.transition = "opacity 0.5s ease";
                                        alert.style.opacity = 0;
                                        setTimeout(() => alert.remove(), 500);
                                    }
                                }, 3000);
                            </script>
                        @endif

            <!-- Contenedor para select y botones -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <!-- Select de sprints -->
                @if($tablero->sprints && $tablero->sprints->count())
                    <select class="form-select"
                            id="sprintSelect"
                            aria-label="Seleccionar sprint"
                            style="min-width: 200px; max-width: 240px;">
                        <option selected disabled>Selecciona un sprint</option>
                        @foreach($tablero->sprints as $sprint)
                            <option value="{{ $sprint->id }}">{{ $sprint->nombre }}</option>
                        @endforeach
                    </select>
                @endif

                <!-- Botón para agregar columna -->
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAgregarColumna">
                    Agregar columna
                </button>

                <!-- Botón para crear sprint -->
                <button class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalCrearSprint"
                        id="btnAbrirCrearSprint">
                    Crear sprint
                </button>
            </div>
        </div>

        <!-- Contenedor de columnas scrollable horizontal -->
        <div class="overflow-auto pb-3" style="width: 100%;">
            <div id="kanban-board" class="d-flex" style="min-width: max-content; gap: 1rem; min-height: 500px;">
                @foreach($tablero->columnas as $columna)
                    <div class="bg-white border rounded shadow-sm d-flex flex-column mx-2"
                         style="{{ $widthStyle }} min-height: 500px;">
                        <div class="d-flex justify-content-between align-items-start bg-light p-2 border-bottom">
                            @if($columna->es_backlog)
                                <strong>{{ $columna->nombre }}</strong>
                            @else
                                <input type="text"
                                       value="{{ $columna->nombre }}"
                                       class="form-control form-control-sm me-2 editable-title"
                                       data-column-id="{{ $columna->id }}">
                            @endif

                            @if(!$columna->es_backlog)
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item delete-column" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                    <div class="p-2 border-bottom">
                        <a href="{{ route('historias.create.fromColumna', ['columna' => $columna->id]) }}"
                        class="btn btn-sm btn-primary w-100">
                            Agregar historias
                        </a>
                    </div>

                     <!--inicio-->

                        <div class="overflow-auto p-2" style="flex: 4;">
                            @foreach ($columna->historias as $historia)
                                <div class="card mb-4 p-2 text-dark position-relative" style="width: 100%; word-break: break-word;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        {{-- Columna 1: Contenido --}}
                                        <div style="flex: 1;">
                                            <a href="{{ route('historias.show', $historia->id) }}" class="text-decoration-none text-dark d-block">
                                                <strong class="d-block text-truncate"
                                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                        title="{{ $historia->nombre }}">
                                                     H{{ $historia->numero }} {{ $historia->nombre }}
                                                </strong>
                                                @if ($historia->descripcion)
                                                    <div style="max-height: 4.5em; overflow: hidden; line-height: 1.5em; word-wrap: break-word; overflow-wrap: break-word;">
                                                        Descripcion: {{ $historia->descripcion }}
                                                    </div>
                                                @endif
                                            </a>
                                        </div>

                                        {{-- Columna 2: Menú --}}
                                        <div class="ms-2">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    &#x22EE; {{-- ⋮ --}}
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('historias.edit', $historia->id) }}">Editar</a>
                                                    </li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#confirmDeleteModal{{ $historia->id }}">
                                                            Eliminar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal de confirmación --}}
                                    <div class="modal fade" id="confirmDeleteModal{{ $historia->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $historia->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteLabel{{ $historia->id }}">¿Desea eliminar esta historia?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Se eliminará la historia:
                                                    <strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 300px;"
                                                        title="{{ $historia->nombre }}">
                                                        {{ $historia->nombre }}
                                                    </strong><br>
                                                    Esta acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- fin-->

                </div>
            @endforeach
        </div>
    </div>


        <!-- Modal Bootstrap para agregar columna -->
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

            <!-- Modal para crear sprint -->
            <div class="modal fade" id="modalCrearSprint" tabindex="-1" aria-labelledby="modalCrearSprintLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form id="formCrearSprint" method="POST" action="{{ route('sprints.store', $project->id) }}" class="modal-content">
                    @csrf
                        <input type="hidden" name="tablero_id" value="{{ $tablero->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCrearSprintLabel">Crear Sprint <span id="numeroSprint"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Crear sprint</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- AJAX para actualizar nombre -->
    <script>


            //ocultar la alerta
            setTimeout(function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500); // quitarlo del DOM
                }
            }, 3000); // 3000ms = 3 segundos



        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editable-title").forEach(input => {
                input.addEventListener("blur", function () {
                    const columnId = this.dataset.columnId;
                    const newName = this.value.trim();

                    if (!newName) {
                        alert("El nombre no puede estar vacío.");
                        return;
                    }

                    fetch(`/columnas/${columnId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ nombre: newName })
                    })
                        .then(response => {
                            if (!response.ok) throw new Error("Error HTTP " + response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Columna actualizada:', data);
                            // Aquí podrías mostrar un mensaje visual
                        })
                        .catch(error => {
                            alert("No se pudo actualizar el nombre de la columna.");
                            console.error(error);
                        });
                });
            });
        });
    </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const btnAbrirCrearSprint = document.getElementById('btnAbrirCrearSprint');
                    const numeroSprintSpan = document.getElementById('numeroSprint');

                    // Obtén el último número de sprint del backend, o 0 si no hay
                    let ultimoNumeroSprint = @json($tablero->sprints->max('numero_sprint') ?? 0);

                    btnAbrirCrearSprint.addEventListener('click', () => {
                        const nuevoNumero = ultimoNumeroSprint + 1;
                        numeroSprintSpan.textContent = nuevoNumero;

                        // Limpiar inputs de fecha al abrir
                        document.getElementById('fecha_inicio').value = '';
                        document.getElementById('fecha_fin').value = '';
                    });

                    // Opcional: validar que fecha_fin sea mayor que fecha_inicio antes de enviar
                    document.getElementById('formCrearSprint').addEventListener('submit', function(e) {
                        const inicio = document.getElementById('fecha_inicio').value;
                        const fin = document.getElementById('fecha_fin').value;

                        if (inicio === '' || fin === '') {
                            alert('Por favor selecciona ambas fechas.');
                            e.preventDefault();
                            return;
                        }

                        if (fin <= inicio) {
                            alert('La fecha de fin debe ser mayor que la fecha de inicio.');
                            e.preventDefault();
                        }
                    });
                });
            </script>

@endsection
