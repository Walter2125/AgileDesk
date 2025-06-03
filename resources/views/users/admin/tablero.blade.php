@extends('layouts.app')



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


@section('mensaje-superior')
    <div class="mt-4 text-lg font-semibold">
        <h1 style="color: black; font-size: 24px; font-weight: bold;">
            🗂️ Tablero de {{ $project->name }}
        </h1>
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
<div class="d-flex justify-content-between align-items-center mb-4">

    <!-- Lado izquierdo: select y botones -->
    <div class="d-flex align-items-center gap-2">
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

    <!-- Lado derecho: código del proyecto -->
    <div class="text-muted fw-bold">
        Código: {{ $tablero->project->codigo }}
    </div>
</div>
=======
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">{{ $project->name }}</h1>
            
            <div class="btn-group">
                @if($project->sprints && $project->sprints->count())
                    <select class="form-select mt-2" id="sprintSelect" aria-label="Seleccionar sprint">
                        <option selected disabled>Selecciona un sprint</option>
                        @foreach($tablero->sprints as $sprint)
                            <option value="{{ $sprint->id }}">{{ $sprint->nombre }}</option>
                        @endforeach
                    </select>
                @endif

                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAgregarColumna">
                    Agregar columna
                </button>


                <button class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalCrearSprint"
                        id="btnAbrirCrearSprint">
                    Crear sprint
                </button>
            </div>

            <!-- Botón derecho: Agregar columna -->
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAgregarColumna">
                Agregar columna
            </button>
        </div>
>>>>>>> 4513421c3958db7f987e067f579ba9c7fe2efe76



        <!-- Contenedor de columnas scrollable horizontal -->
        <div class="overflow-auto pb-3 mt-3" style="width: 100%;">

       <div class="input-group mb-3" style="width: 55%;">
    <input type="text" id="buscadorHistorias" class="form-control" placeholder="🔍 Buscar historia por nombre...">
    <button class="btn btn-outline-secondary" type="button" id="limpiarBusqueda">
        ✖️
    </button>
</div>

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

                                <div class="dropdown ms-2">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton{{ $columna->id }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $columna->id }}">
                                        <li>
                                            <button class="dropdown-item" disabled>
                                                <strong>Acciones</strong>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item"
                                                    onclick="abrirModalEliminarColumna({{ $columna->id }}, '{{ $columna->nombre }}')">
                                                Eliminar columna
                                            </button>
                                        </li>
                                    </ul>
                                </div>


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

    {{-- Scripts existentes --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll(".historia-lista").forEach(function (el) {
                new Sortable(el, {
                    group: 'historias',
                    animation: 150,
                    onEnd: function (evt) {
                        const historiaId = evt.item.dataset.historiaId;
                        const nuevaColumnaId = evt.to.dataset.columnaId;

                        fetch(`/historias/${historiaId}/mover`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                columna_id: nuevaColumnaId
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error("Error al mover la historia.");
                            return response.json();
                        })
                        .then(data => {
                            console.log("Historia movida correctamente", data);
                        })
                        .catch(error => {
                            console.error(error);
                            alert("No se pudo mover la historia.");
                        });
                    }
                });
            });
        });
    </script>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editable-title").forEach(input => {
                input.addEventListener("blur", function () {
                    const columnId = this.dataset.columnId;
                    const newName = this.value.trim();

                    if (!newName) {
                        alert("El nombre no puede estar vacío.");
                        return;
                    }

                    fetch(/columnas/${columnId}, {
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
                        })
                        .catch(error => {
                            alert("No se pudo actualizar el nombre de la columna.");
                            console.error(error);
                        });
                });
            });
        });
    </script>

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


<!-- Modal de confirmación para eliminar columna -->
<!-- Modal de confirmación para eliminar columna -->
<div class="modal fade" id="modalConfirmarEliminarColumna" tabindex="-1" aria-labelledby="eliminarColumnaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEliminarColumna" method="POST" action="">
            @csrf
            @method('DELETE')
            <input type="hidden" name="modo" id="modoEliminar">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarColumnaLabel">Eliminar columna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p id="mensajeEliminarColumna">¿Qué deseas hacer con las historias de esta columna?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger" onclick="enviarFormularioEliminar('eliminar_todo')">
                        Borrar columna y sus historias
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="enviarFormularioEliminar('solo_columna')">
                        Borrar columna, conservar historias
                    </button>
                </div>
            </div>
        </form>
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
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

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
                // que en funcion del sprint actual o sea de las fechas esas sean las historias que me salgan al entrar al tablero , que esas sean las que aparezcan
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
<script>
    let columnaIdParaEliminar = null;

    // Función para abrir el modal y asignar el action del formulario
    function abrirModalEliminarColumna(columnaId) {
        columnaIdParaEliminar = columnaId;
        const form = document.getElementById('formEliminarColumna');
        form.action = `/columnas/${columnaId}`; // URL para eliminar columna (ajusta si usas prefijo)

        // Resetea el input modo por si acaso
        document.getElementById('modoEliminar').value = '';

        // Mostrar modal con Bootstrap 5
        var modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminarColumna'));
        modal.show();
    }

    // Función para enviar el formulario con el modo seleccionado
    function enviarFormularioEliminar(modo) {
        document.getElementById('modoEliminar').value = modo;
        document.getElementById('formEliminarColumna').submit();
    }
</script>






    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnAbrirCrearSprint = document.getElementById('btnAbrirCrearSprint');
            const numeroSprintSpan = document.getElementById('numeroSprint');
            let ultimoNumeroSprint = @json($tablero->sprints->max('numero_sprint') ?? 0);

            btnAbrirCrearSprint.addEventListener('click', () => {
                const nuevoNumero = ultimoNumeroSprint + 1;
                numeroSprintSpan.textContent = nuevoNumero;

                document.getElementById('fecha_inicio').value = '';
                document.getElementById('fecha_fin').value = '';
            });

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
 document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscadorHistorias");
    const limpiarBtn = document.getElementById("limpiarBusqueda");
    const columnas = document.querySelectorAll(".historia-lista");

    function realizarBusqueda() {
        const textoBusqueda = buscador.value.toLowerCase().trim();
        
        columnas.forEach(columna => {
            const historias = columna.querySelectorAll(".historia-item");
            let historiasVisibles = 0;
            
            historias.forEach(historia => {
                const nombre = historia.textContent.toLowerCase();
                if (nombre.includes(textoBusqueda)) {
                    historia.style.display = "block";
                    historiasVisibles++;
                } else {
                    historia.style.display = "none";
                }
            });
            
            // Opcional: ocultar columnas vacías
            columna.style.display = historiasVisibles > 0 ? "block" : "none";
        });
    }

    buscador.addEventListener("input", realizarBusqueda);
    limpiarBtn.addEventListener("click", function () {
        buscador.value = "";
        columnas.forEach(columna => {
            columna.style.display = "block";
            columna.querySelectorAll(".historia-item").forEach(h => h.style.display = "block");
        });
    });
});

</script>
</div>
@endsection