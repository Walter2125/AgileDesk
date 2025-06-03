@extends('layouts.app')

@section('mensaje-superior')
    <div class="mt-4 text-lg font-semibold">
        <h1 style="color: black; font-size: 24px; font-weight: bold;">
            🗂️ Tablero de {{ $project->name }}
        </h1>
    </div>
@endsection


@section('content')
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
    @php

$colCount = $tablero->columnas->count();
        $widthStyle = ($colCount <= 4)
            ? 'width: calc(100% / ' . $colCount . ' - 1rem); max-width: none;'
            : 'width: 300px; flex-shrink: 0;';
    @endphp

    <div class="container py-4">

            <!-- Contenedor para select y botones -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <!-- Select de sprints -->
                <select class="form-select"
                        id="sprintSelect"
                        aria-label="Seleccionar sprint"
                        style="min-width: 200px; max-width: 240px;">
                    <option value="" {{ request('sprint_id') ? '' : 'selected' }}>Ningún Sprint</option>
                    @foreach($tablero->sprints as $sprint)
                        <option value="{{ $sprint->id }}" {{ request('sprint_id') == $sprint->id ? 'selected' : '' }}>
                            {{ $sprint->nombre }}
                        </option>
                    @endforeach
                </select>



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
                    <div class="bg-white border rounded shadow-sm d-flex flex-column "
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


                   <div class="overflow-auto p-2" style="flex: 1;">
                        @foreach ($columna->historias as $historia)
                           <a href="{{ route('historias.show', $historia->id) }}"
                              class="card mb-2 p-2 text-decoration-none text-dark d-block"
                              style="
                              width: 100%;
                              word-break: break-word;
                              overflow: hidden;">
                               <strong class="d-block" title="{{ $historia->nombre }}">
                                   {{ $historia->nombre }}
                               </strong>
                           </a>

                       @endforeach
                    </div>

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

// que en funcion del sprint actual o sea de las fechas esas sean las historias que me salgan al entrar al tablero , que esas sean las que aparezcan
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
<script>
    document.getElementById('sprintSelect').addEventListener('change', function () {
        const sprintId = this.value;
        const url = new URL(window.location.href);

        if (sprintId) {
            // Si selecciona un sprint específico, actualiza el parámetro
            url.searchParams.set('sprint_id', sprintId);
        } else {
            // Si selecciona "Ningún Sprint", elimina el parámetro para mostrar todos
            url.searchParams.delete('sprint_id');
        }

        // Redirige a la nueva URL
        window.location.href = url.toString();
    });

</script>




@endsection
