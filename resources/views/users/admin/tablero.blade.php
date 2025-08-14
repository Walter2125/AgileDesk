@extends('layouts.app')

@section('mensaje-superior')
    {{ $project->name }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons-fixed.css') }}">
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <div id="notification-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1055; width: auto; max-width: 350px;"></div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @php
        $colCount = $tablero->columnas->count();
                $widthStyle = ($colCount <= 4)
            ? 'flex: 1 1 0; max-width: none;'
            : 'width: 300px; flex-shrink: 0;';

    @endphp

    <div class="container-fluid px-3 py-0 tablero-wrapper">
        @if (session('success'))
            <div id="success-alert"
                 class="alert alert-success alert-dismissible fade show mt-2"
                 style="background-color: #d1e7dd; color: #0f5132; display: flex; align-items: center; justify-content: space-between;">

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center;">
                        <i class="bi bi-check-circle me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>

            </div>
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
        @endif
        <div class="overflow-auto pb-3" style="width: 100%; white-space: nowrap;">
            <div id="kanban-board" class="d-flex flex-nowrap w-100" style="gap: 1rem;">

            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 w-100 flex-nowrap kanban-toolbar" style="padding-bottom: 1rem; overflow-x: auto;">

        <div class="input-group w-100">
    <span class="input-group-text" style="height: 40px">
        <i class="bi bi-search"></i>
    </span>
            <input type="text" id="buscadorHistorias" class="form-control" placeholder="Buscar historia por nombre..." style="height: 40px">
            <button class="btn btn-outline-secondary limpiar-busqueda" type="button" id="limpiarBusqueda" style="height: 40px">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Mostrar solo si hay sprints --}}
        @if ($tablero->sprints->count() > 0)
            <form method="GET" class="d-flex">
                <select name="sprint_id" id="sprintSelect" class="form-select"
                        style="max-height: 38px; height: 38px; width: 250px; border-radius: 0.375rem;"
                        onchange="this.form.submit()">
                    <option value="" {{ request('sprint_id') == '' ? 'selected' : '' }}>
                        Todas las Historias
                    </option>
                    @foreach ($tablero->sprints as $sprint)
                        <option value="{{ $sprint->id }}" {{ request('sprint_id') == $sprint->id ? 'selected' : '' }}>
                            {{ $sprint->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif

        <div class="d-flex gap-2 ms-auto">
            <button class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCrearSprint"
                    id="btnAbrirCrearSprint"
                    style="height: 40px">
                Crear sprint
            </button>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAgregarColumna"
                    style="height: 40px">
                Agregar columna
            </button>
        </div>

    </div>

            <div class="w-100 mt-3">

                <div class="overflow-auto pb-3" style="width: 100%; white-space: nowrap;">

                    <div id="kanban-board" class="d-flex flex-nowrap w-100" style="gap: 1rem;">

                    @foreach($tablero->columnas as $columna)
                            <div class="bg-white border rounded shadow-sm kanban-columna d-flex flex-column"
                                 style="{{ $widthStyle }} min-height: 500px; max-height: 500px;">

                                <div class="d-flex justify-content-between align-items-start bg-light p-2 border-bottom flex-shrink-0">
                                    <strong>{{ $columna->nombre }}</strong>

                                    {{-- Menú de tres puntitos con Bootstrap --}}
                                    <div class="dropdown ms-2">
                                        <button class="btn btn-link text-dark p-0" type="button" id="menuOpciones{{ $columna->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-5"></i> {{-- Icono Bootstrap --}}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuOpciones{{ $columna->id }}">
                                            <li class="dropdown-header">Acciones</li>
                                            <li>
                                                <a href="#"
                                                   class="dropdown-item"
                                                   onclick="abrirModalEditarColumna({{ $columna->id }}, '{{ addslashes($columna->nombre) }}')">
                                                    Editar nombre
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                   class="dropdown-item text-danger"
                                                   onclick="abrirModalEliminarColumna({{ $columna->id }})">
                                                    Eliminar columna
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>



                                <div class="p-2 border-bottom flex-shrink-0">
                                    <a href="{{ route('historias.create.fromColumna', ['columna' => $columna->id]) }}"
                                       class="btn btn-sm btn-primary w-100">
                                        Agregar historias
                                    </a>
                                </div>


                                <div class="overflow-auto p-2" style="flex: 4;" data-columna-id="{{ $columna->id }}">
                                    @foreach ($columna->historias as $historia)
                                        <div class="card mb-4 p-2 text-dark position-relative"
                                             style="width: 100%; word-break: break-word; overflow-wrap: break-word; max-width: 100%;"
                                             data-historia-id="{{ $historia->id }}">

                                            <div class="d-flex justify-content-between align-items-start">
                                                {{-- Columna 1: Contenido --}}
                                                <div style="flex: 1; min-width: 0;">
                                                    <a href="{{ route('historias.show', $historia->id) }}" class="text-decoration-none text-dark d-block">

                                                        <strong class="ellipsis-nombre" title="{{ $historia->nombre }}">
                                                            {{ $historia->proyecto->codigo ?? 'SIN-CÓDIGO' }}-{{ $historia->numero }} : {{ $historia->nombre }}
                                                        </strong>

                                                    @if ($historia->descripcion)
                                                            <div class="descripcion-limitada"
                                                                style="word-break: break-word; overflow-wrap: break-word; white-space: normal; max-width: 100%; overflow: hidden; text-overflow: ellipsis;">
                                                                Descripción: {{ $historia->descripcion }}
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
                                                            <li><a class="dropdown-item" href="{{ route('historias.show', $historia->id) }}">Editar</a></li>
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

                                            {{-- Modal Confirmación --}}
                                            <div class="modal fade" id="confirmDeleteModal{{ $historia->id }}" tabindex="-1"
                                                 aria-labelledby="confirmDeleteLabel{{ $historia->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content rounded-4 shadow">
                                                        <div class="modal-header border-bottom-0">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="mb-4">
                                                                <h5 class="modal-title text-danger" id="confirmDeleteLabel{{ $historia->id }}">Confirmar Eliminación</h5>
                                                                <h5 class="modal-title text-danger">¿Deseas eliminar esta historia?</h5>
                                                                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                                                <div class="alert alert-danger d-flex align-items-center mt-3">
                                                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                                    <div>"<strong>{{ $historia->nombre }}</strong>" será eliminada permanentemente.</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                                <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                </form>
                                                            </div>
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

                    <div class="kanban-accordion">
                        <div class="accordion" id="accordionKanban">
                            @foreach($tablero->columnas as $columna)
                                <div class="accordion-item">

                                    {{-- HEADER --}}
                                    <div class="accordion-header d-flex align-items-center w-100 px-3 py-2 gap-2" id="heading{{ $columna->id }}">

                                        {{-- Menú contextual columna (reemplaza los 3 puntos) --}}
                                        <div class="position-relative">
                                            <button type="button" class="btn btn-sm btn-light dropdown-toggle-menu" aria-expanded="false">
                                                &#x22EE; {{-- ⋮ --}}
                                            </button>

                                            <div class="menu-contextual-columna position-absolute shadow rounded bg-white p-2">
                                                <a href="#" class="dropdown-item"
                                                   onclick="abrirModalEditarColumna({{ $columna->id }}, '{{ addslashes($columna->nombre) }}')">
                                                    Editar nombre
                                                </a>
                                                <a href="#" class="dropdown-item text-danger"
                                                   onclick="abrirModalEliminarColumna({{ $columna->id }})">
                                                    Eliminar columna
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Título --}}
                                        <span class="flex-grow-1 text-truncate fw-semibold ms-2">
                        {{ $columna->nombre }}
                    </span>

                                        {{-- Botón collapse --}}
                                        <button class="btn btn-link p-0 ms-auto collapse-toggle-btn"
                                                type="button"
                                                data-bs-target="#collapse{{ $columna->id }}">
                                            <i class="bi bi-chevron-down fs-5"></i>
                                        </button>

                                    </div>

                                    {{-- CUERPO DEL COLLAPSE --}}
                                    <div id="collapse{{ $columna->id }}"
                                         class="accordion-collapse collapse"
                                         aria-labelledby="heading{{ $columna->id }}">
                                        <div class="accordion-body">
                                            <a href="{{ route('historias.create.fromColumna', ['columna' => $columna->id]) }}"
                                               class="btn btn-sm btn-primary mb-3 w-100">
                                                Agregar historias
                                            </a>

                                            @forelse ($columna->historias as $historia)
                                                {{-- Tarjeta de historia --}}
                                                <div class="card mb-2 p-2 text-dark position-relative card-historia"
                                                     data-href="{{ route('historias.show', $historia->id) }}"
                                                     style="cursor:pointer; z-index: 0;">
                                                    <strong class="ellipsis-nombre" title="{{ $historia->nombre }}">
                                                        {{ $historia->proyecto->codigo ?? 'SIN-CÓDIGO' }}-{{ $historia->numero }} : {{ $historia->nombre }}
                                                    </strong>
                                                    @if ($historia->descripcion)
                                                        <div class="descripcion-limitada" style="
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        white-space: nowrap;
                                        max-width: 100%;
                                    ">
                                                            Descripción: {{ $historia->descripcion }}
                                                        </div>
                                                    @endif

                                                    <div class="d-flex justify-content-end gap-2 mt-2">
                                                        <a href="{{ route('historias.show', $historia->id) }}" class="btn btn-sm btn-outline-secondary">
                                                            Editar
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $historia->id }}">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-muted">No hay historias en esta columna.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Menú contextual columnas
                            document.querySelectorAll('.dropdown-toggle-menu').forEach(button => {
                                button.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    const menu = this.nextElementSibling;
                                    document.querySelectorAll('.menu-contextual-columna').forEach(m => {
                                        if (m !== menu) m.classList.remove('show');
                                    });
                                    menu.classList.toggle('show');
                                });
                            });

                            document.addEventListener('click', function () {
                                document.querySelectorAll('.menu-contextual-columna').forEach(menu => menu.classList.remove('show'));
                            });

                            // Click en la tarjeta abre show
                            document.querySelectorAll('.card-historia').forEach(card => {
                                card.addEventListener('click', function(e) {
                                    if(e.target.closest('button, a')) return;
                                    const href = this.dataset.href;
                                    if(href) window.location.href = href;
                                });
                            });
                        });
                    </script>

                    <style>
                        /* Menú contextual columna */
                        .menu-contextual-columna {
                            display: none;
                            position: absolute;
                            top: 100%; /* justo debajo del botón */
                            right: 0; /* alineado a la derecha por defecto */
                            min-width: 160px; /* ancho mínimo */
                            background-color: #fff;
                            border-radius: 6px;
                            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                            padding: 8px 0; /* espacio arriba y abajo */
                            z-index: 2000;
                        }

                        /* Cada opción del menú */
                        .menu-contextual-columna li {
                            list-style: none;
                            margin: 0;
                            padding: 6px 16px; /* espacio interno de cada opción */
                            cursor: pointer;
                            transition: background 0.2s;
                        }

                        .menu-contextual-columna li:hover {
                            background-color: #f0f0f0;
                        }

                        /* Mostrar el menú */
                        .menu-contextual-columna.show {
                            display: block;
                        }

                        /* Móvil: abrir hacia la izquierda si hay poco espacio */
                        @media (max-width: 767.98px) {
                            .menu-contextual-columna {
                                right: auto;
                                left: 0;
                            }
                        }

                        /* Ellipsis para títulos */
                        .ellipsis-nombre {
                            display: block;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            width: 100%;
                        }
                    </style>

                    {{-- Scripts existentes --}}
                <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.overflow-auto.p-2').forEach(function (el) {
                            new Sortable(el, {
                                group: 'historias',
                                animation: 150,
                                draggable: '.card',
                                onEnd: function (evt) {
                                    const historiaElement = evt.item;
                                    const historiaId = historiaElement.dataset.historiaId;
                                    const columnaElement = evt.to.closest('[data-columna-id]');
                                    const nuevaColumnaId = columnaElement.dataset.columnaId;

                                    if (!historiaId || !nuevaColumnaId) {
                                        console.error('Faltan IDs requeridos');
                                        return;
                                    }

                                   fetch(`/historias/${historiaId}/mover`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ columna_id: nuevaColumnaId })
                })
                                        .then(response => {
                                            if (!response.ok) {
                                                return response.json().then(err => { throw err; });
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (!data.success) {
                                                throw new Error(data.message || 'Error al mover la historia');
                                            }
                                            console.log('Movimiento exitoso:', data);
                                            // Opcional: Mostrar notificación
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            showNotification('error', error.message);
                                            // Revertir visualmente el movimiento
                                            evt.from.insertBefore(evt.item, evt.oldIndex >= evt.from.children.length ?
                                                null : evt.from.children[evt.oldIndex]);
                                        });
                                }
                            });
                        });

                        function showNotification(type, message) {
                            // Implementa tu sistema de notificaciones o usa alertas simples
                            const alertType = type === 'error' ? 'danger' : type;
                            const alertHtml = `
            <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

                            // Agrega la notificación donde sea apropiado en tu UI
                            const notificationContainer = document.getElementById('notification-container') || document.body;
                            notificationContainer.insertAdjacentHTML('afterbegin', alertHtml);

                            // Elimina la notificación después de 5 segundos
                            setTimeout(() => {
                                const alert = notificationContainer.querySelector('.alert');
                                if (alert) alert.remove();
                            }, 5000);
                        }
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
                                        // Column updated successfully
                                    })
                                    .catch(error => {
                                        alert("No se pudo actualizar el nombre de la columna.");
                                        console.error(error);
                                    });
                            });
                        });
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        // Evitar que el clic en el menú cierre el acordeón
                        document.querySelectorAll('.dropdown').forEach(function (dropdown) {
                            dropdown.addEventListener('click', function (e) {
                                e.stopPropagation(); // Detiene la propagación del evento
                            });
                        });

                        // Asegurar que los menús se abran correctamente
                        document.querySelectorAll('.dropdown-toggle').forEach(function (toggle) {
                            toggle.addEventListener('click', function (e) {
                                const dropdownMenu = this.nextElementSibling;
                                if (dropdownMenu) {
                                    dropdownMenu.classList.toggle('show');
                                }
                            });
                        });
                    });


                </script>

                <!-- Modal Bootstrap para agregar columna -->
                    <!-- Modal Agregar Columna -->
                    <div class="modal fade" id="modalAgregarColumna" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form method="POST" action="{{ route('columnas.store', $tablero->id) }}" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Agregar nueva columna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($errors->crearColumna->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->crearColumna->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre de la columna</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control"
                                               value="{{ old('nombre') }}" required maxlength="30">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Crear</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Crear Sprint -->
                    <div class="modal fade" id="modalCrearSprint" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form method="POST" action="{{ route('sprints.store', $project->id) }}" class="modal-content">
                                @csrf
                                <input type="hidden" name="tablero_id" value="{{ $tablero->id }}">
                                <div class="modal-header">
                                    <h5 class="modal-title">Crear Sprint</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($errors->crearSprint->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->crearSprint->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                                        <input type="date" name="fecha_inicio" id="fecha_inicio"
                                               class="form-control" value="{{ old('fecha_inicio') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                                        <input type="date" name="fecha_fin" id="fecha_fin"
                                               class="form-control" value="{{ old('fecha_fin') }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Crear sprint</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Script para reabrir modal según errores -->
                    @if ($errors->crearColumna->any())
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                new bootstrap.Modal(document.getElementById('modalAgregarColumna')).show();
                            });
                        </script>
                    @endif

                    @if ($errors->crearSprint->any())
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                new bootstrap.Modal(document.getElementById('modalCrearSprint')).show();
                            });
                        </script>
                    @endif



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
                                <div class="modal-footer d-flex flex-column flex-sm-row justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-danger w-100 w-sm-auto" onclick="enviarFormularioEliminar('eliminar_todo')">
                                        Borrar columna y sus historias
                                    </button>
                                    <button type="button" class="btn btn-outline-warning w-100 w-sm-auto" onclick="enviarFormularioEliminar('solo_columna')">
                                        Borrar columna, conservar historias
                                    </button>
                                    <button type="button" class="btn btn-secondary w-100 w-sm-auto" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>

                    <!-- Modal para editar nombre de columna -->
                    <div class="modal fade" id="modalEditarColumna" tabindex="-1" aria-labelledby="modalEditarColumnaLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="formEditarColumna" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarColumnaLabel">Editar columna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="inputNombreColumna" class="form-label">Nombre</label>
                                            <input type="text"
                                                   name="nombre"
                                                   id="inputNombreColumna"
                                                   class="form-control"
                                                   placeholder="Nombre de la columna"
                                                   maxlength="50"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        function abrirModalEditarColumna(id, nombre) {
                            const form = document.getElementById('formEditarColumna');
                            form.action = `/columnas/${id}`; // Ruta a update
                            document.getElementById('inputNombreColumna').value = nombre;
                            new bootstrap.Modal(document.getElementById('modalEditarColumna')).show();
                        }
                    </script>

                    <script>

                    document.addEventListener('DOMContentLoaded', function () {
                        // Evitar que el clic en el menú cierre el acordeón
                        document.querySelectorAll('.dropdown').forEach(function (dropdown) {
                            dropdown.addEventListener('click', function (e) {
                                e.stopPropagation(); // Detiene la propagación del evento
                            });
                        });

                        // Asegurar que los menús se abran correctamente
                        document.querySelectorAll('.dropdown-toggle').forEach(function (toggle) {
                            toggle.addEventListener('click', function (e) {
                                const dropdownMenu = this.nextElementSibling;
                                if (dropdownMenu) {
                                    dropdownMenu.classList.toggle('show');
                                }
                            });
                        });
                    });


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

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Al hacer click en cualquier botón de colapsar
                            document.querySelectorAll('.collapse-toggle-btn').forEach(btn => {
                                btn.addEventListener('click', function (e) {
                                    const targetSelector = this.getAttribute('data-bs-target');
                                    const collapseEl = document.querySelector(targetSelector);

                                    if (!collapseEl) return;

                                    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false });

                                    // Si está abierto, ciérralo. Si está cerrado, ábrelo.
                                    if (collapseEl.classList.contains('show')) {
                                        bsCollapse.hide();
                                        this.setAttribute('aria-expanded', 'false');
                                    } else {
                                        bsCollapse.show();
                                        this.setAttribute('aria-expanded', 'true');
                                    }
                                });
                            });

                            // Evitar que los clicks en dropdowns cierren o interfieran
                            document.querySelectorAll('.dropdown').forEach(dropdown => {
                                dropdown.addEventListener('click', function (e) {
                                    e.stopPropagation();
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
                    document.addEventListener('DOMContentLoaded', function () {
                        const inputNombre = document.getElementById('inputNombreColumna');
                        inputNombre.addEventListener('input', function () {
                            this.value = this.value.replace(/[0-9]/g, '');
                        });
                    });

                    let columnaIdParaEliminar = null;

                    // Función para abrir el modal y asignar el action del formulario
                    function abrirModalEliminarColumna(columnaId) {
                        columnaIdParaEliminar = columnaId;
                        const form = document.getElementById('formEliminarColumna');

                        // Asignar la ruta al action del formulario con template literal
                        form.action = `/admin/columnas/${columnaId}`;

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

                            // Seleccionar todas las tarjetas de historias
                            const historias = document.querySelectorAll(".card.mb-4.p-2");

                            historias.forEach(historia => {
                                // Buscar en el texto de la historia (nombre + descripción)
                                const textoHistoria = historia.textContent.toLowerCase();
                                if (textoHistoria.includes(textoBusqueda)) {
                                    historia.style.display = "block";
                                } else {
                                    historia.style.display = "none";
                                }
                            });
                        }

                        // Buscar mientras se escribe (con retardo de 300ms para mejor performance)
                        let timeoutBusqueda;
                        buscador.addEventListener("input", () => {
                            clearTimeout(timeoutBusqueda);
                            timeoutBusqueda = setTimeout(realizarBusqueda, 300);
                        });

                        // Botón para limpiar la búsqueda
                        limpiarBtn.addEventListener("click", function () {
                            buscador.value = "";
                            const historias = document.querySelectorAll(".card.mb-4.p-2");
                            historias.forEach(h => h.style.display = "block");
                        });
                    });



                </script>

                <script>
                    document.addEventListener('click', function (e) {
                        document.querySelectorAll('.toggler').forEach(function (checkbox) {
                            const menuWrapper = checkbox.closest('.menu-wrapper');
                            if (menuWrapper && !menuWrapper.contains(e.target)) {
                                checkbox.checked = false;
                            }
                        });
                    });
                </script>

                <script>
                    function abrirModalEditarColumna(id, nombre) {
                        const form = document.getElementById('formEditarColumna');
                        const input = document.getElementById('inputNombreColumna');

                        // Usar template literal correcto
                        form.action = `/columnas/${id}`;
                        input.value = nombre;

                        const modal = new bootstrap.Modal(document.getElementById('modalEditarColumna'));
                        modal.show();
                    }

                </script>
                    <script>
                        document.querySelectorAll('.card-historia').forEach(card => {
                            card.addEventListener('click', function(e) {
                                // Evitar que los botones o enlaces internos disparen el redireccionamiento
                                if (!e.target.closest('a') && !e.target.closest('button')) {
                                    window.location.href = this.dataset.href;
                                }
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Evita que el click del collapse afecte al dropdown
                            document.querySelectorAll('.collapse-toggle-btn').forEach(btn => {
                                btn.addEventListener('click', function(e){
                                    e.stopPropagation(); // el click del collapse no afectará al dropdown
                                });
                            });
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Detecta clicks o toques en todo el documento
                            ['click', 'touchstart'].forEach(eventType => {
                                document.addEventListener(eventType, function (e) {
                                    // Evitar que botones, enlaces o inputs disparen la navegación
                                    if (
                                        e.target.closest('a, button, input, textarea, select, [data-bs-toggle], [data-bs-target], .menu-wrapper, .dropdown-menu')
                                    ) {
                                        return;
                                    }

                                    // Buscar si se hizo click/toque dentro de una tarjeta historia
                                    const card = e.target.closest('.card-historia');
                                    if (card) {
                                        const href = card.dataset.href;
                                        if (href) {
                                            window.location.href = href;
                                        }
                                    }
                                }, { passive: true });
                            });
                        });
                    </script>









                    <style>
                        /* Estilos del menú contextual */
                        .menu-contextual {
                            position: absolute;
                            background: #fff;
                            border: 1px solid #ccc;
                            border-radius: 6px;
                            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                            z-index: 1055;
                            padding: 10px;
                            display: none;
                        }

                        .menu-contextual ul {
                            list-style: none;
                            margin: 0;
                            padding: 0;
                        }

                        .menu-contextual ul li {
                            padding: 8px 12px;
                            cursor: pointer;
                        }

                        .menu-contextual ul li:hover {
                            background: #f0f0f0;
                        }

                    .kanban-columna {
                        min-width: 0 !important;
                        overflow: hidden;
                    }

                    .kanban-columna strong.ellipsis {
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        display: block;
                        max-width: 250px;
                    }

                    .menu-wrapper {
                        position: relative;
                        display: inline-block;
                        z-index: 1000;
                    }


                    /* Checkbox invisible */
                    .toggler {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 30px;
                        height: 30px;
                        opacity: 0;
                        cursor: pointer;
                        z-index: 2;
                    }

                    /* Puntos visuales */
                    .dots {
                        width: 24px;
                        height: 24px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        cursor: pointer;
                    }

                    .dots div {
                        position: relative;
                        width: 4px;   /* más pequeño */
                        height: 4px;
                        background: #777;
                        border-radius: 50%;
                        transition: 0.4s ease;
                    }

                    .dots div::before,
                    .dots div::after {
                        content: '';
                        position: absolute;
                        width: 4px;
                        height: 4px;
                        background: #777;
                        border-radius: 50%;
                        transition: 0.4s ease;
                    }

                    .dropdown-menu {
                        z-index: 1055; /* Asegúrate de que sea mayor que otros elementos */
                        position: absolute; /* Asegura que el menú se posicione correctamente */
                        transform: translateY(0); /* Evita que se corte por transformaciones */
                    }

                    .kanban-columna {
                        overflow: visible !important; /* Permite que el menú sea visible fuera del contenedor */
                    }

                    /* Posición vertical inicial (alineados) */
                    .dots div::before {
                        top: -6px;
                        left: 0;
                    }

                    .dots div::after {
                        top: 6px;
                        left: 0;
                    }

                    /* Cuando se activa: formar diagonal ↘ */
                    .toggler:checked + .dots div::before {
                        top: -6px;
                        left: -6px;
                    }

                    .toggler:checked + .dots div::after {
                        top: 6px;
                        left: 6px;
                    }

                    /* Opcional: una leve rotación del punto central */
                    .toggler:checked + .dots div {
                        transform: rotate(0deg); /* podés poner 0 o algo leve si querés */
                    }

                    /* Menú */
                    .menu {
                        position: absolute;
                        top: 30px;
                        right: 0;
                        background: white;
                        padding: 10px;
                        border-radius: 6px;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                        display: none;
                        opacity: 0;
                        transform: translateY(-10px);
                        transition: all 0.3s ease;
                        min-width: 160px;
                    }

                    .menu ul {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .menu ul li {
                        margin-bottom: 8px;
                    }

                    .menu ul li:last-child {
                        margin-bottom: 0;
                    }

                    .toggler:checked ~ .menu {
                        display: block;
                        opacity: 1;
                        transform: translateY(0);
                    }
                    .container.py-2 {
                        margin-top: -40px !important;
                    }
                    .ellipsis-nombre {
                        display: block;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        width: 100%;
                    }
                    .nombre-contenedor {
                        flex: 1;
                        min-width: 0;
                    }

                    /* CORREGIR PROBLEMA DE Z-INDEX DE LOS MODALES */
                    .modal {
                        z-index: 1600 !important; /* Mayor que el navbar (z-index: 1400) */
                    }

                    .modal-backdrop {
                        z-index: 1599 !important; /* Justo debajo del modal */
                    }

                    /* Igualar el margen del tablero al de las migas */
                    .tablero-wrapper {
                        padding-left: var(--navbar-padding-x, 1rem) !important;
                        padding-right: var(--navbar-padding-x, 1rem) !important;
                    }

                    /* Por defecto, oculta el accordion */

                </style>
                <style>
                    .kanban-accordion {
                        display: none;
                    }

                    @media (max-width: 767.98px) {

                        #kanban-board {
                            display: none !important;
                        }

                        .kanban-accordion {
                            display: block !important;
                        }

                        .kanban-accordion .accordion-item,
                        .kanban-accordion .accordion-button,
                        .kanban-accordion .accordion-body {
                            background-color: #fff !important;
                            color: #000 !important;
                        }

                        /* Toolbar en columna */
                        .kanban-toolbar {
                            flex-direction: column !important;
                            align-items: stretch !important;
                            gap: 0.75rem !important;
                        }

                        .kanban-toolbar .input-group,
                        .kanban-toolbar select,
                        .kanban-toolbar .btn {
                            width: 100% !important;
                            min-width: 100% !important;
                        }

                        .kanban-toolbar .ms-auto {
                            margin-left: 0 !important;
                        }

                        .kanban-toolbar .d-flex.gap-2 {
                            flex-direction: column !important;
                            align-items: stretch !important;
                        }

                        #sprintSelect {
                            height: 38px !important;
                        }

                        .kanban-toolbar .input-group {
                            display: flex !important;
                            flex-wrap: nowrap !important;
                            align-items: center !important;
                            width: 100% !important;
                        }

                        .kanban-toolbar .input-group-text {
                            flex: 0 0 auto !important;
                            width: 42px !important;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        #buscadorHistorias {
                            flex: 1 1 auto !important;
                            min-width: 0 !important;
                        }



                    }
                    @media (max-width: 767.98px) {
                        .kanban-toolbar {
                            background: #fff;
                            padding: 1rem;
                            border-radius: 8px;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
                        }

                        .kanban-toolbar select,
                        .kanban-toolbar button {
                            border-radius: 6px;
                            border: 1px solid #ccc;
                        }

                        .kanban-toolbar .btn-primary {
                            background-color: #007bff;
                            color: #fff;
                        }

                        .kanban-toolbar .btn-outline-primary {
                            color: #007bff;
                            border-color: #007bff;
                        }

                        .kanban-toolbar .btn-outline-primary:hover {
                            background-color: #007bff;
                            color: #fff;
                        }
                        .limpiar-busqueda {
                            flex: 0 0 auto !important;
                            width: 42px !important;
                            padding: 0 !important;
                            display: flex !important;
                            align-items: center;
                            justify-content: center;
                        }

                        .kanban-toolbar .btn:not(.limpiar-busqueda) {
                            width: 100% !important;
                        }


                    }

                    @media (max-width: 767.98px) {
                        .kanban-toolbar {
                            background: #fff;
                            padding: 1rem;
                            border-radius: 8px;
                            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
                            flex-direction: column !important;
                            align-items: stretch !important;
                            gap: 0.75rem !important;
                        }

                        .kanban-toolbar .input-group {
                            display: flex !important;
                            flex-wrap: nowrap !important;
                            align-items: center !important;
                            width: 100% !important;
                        }

                        .kanban-toolbar .input-group-text {
                            flex: 0 0 auto !important;
                            width: 42px !important;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            padding: 0.375rem 0.75rem;
                        }

                        .kanban-toolbar #buscadorHistorias {
                            flex: 1 1 auto !important;
                            min-width: 0 !important;
                            width: 100% !important;
                        }

                        .kanban-toolbar .limpiar-busqueda {
                            flex: 0 0 auto !important;
                            width: auto !important;
                            padding: 0.375rem 0.75rem !important;
                            display: flex !important;
                            align-items: center;
                            justify-content: center;
                        }

                        .kanban-toolbar select,
                        .kanban-toolbar .btn:not(.limpiar-busqueda) {
                            width: 100% !important;
                            min-width: 100% !important;
                            border-radius: 6px;
                            border: 1px solid #ccc;
                        }

                        .kanban-toolbar .btn-primary {
                            background-color: #007bff;
                            color: #fff;
                        }

                        .kanban-toolbar .btn-outline-primary {
                            color: #007bff;
                            border-color: #007bff;
                        }

                        .kanban-toolbar .btn-outline-primary:hover {
                            background-color: #007bff;
                            color: #fff;
                        }

                        #sprintSelect {
                            height: 38px !important;
                        }
                    }
                    @media (max-width: 576px) {
                        #buscadorHistorias {
                            flex: 1 1 auto; /* Que el input crezca y ocupe todo el espacio disponible */
                        }
                        .limpiar-busqueda {
                            padding: 0 8px; /* Botón más compacto */
                            flex: 0 0 auto; /* No crecer más de lo necesario */
                        }
                        .input-group-text {
                            flex: 0 0 auto; /* Mantiene el ícono de lupa del mismo tamaño */
                        }
                    }

                    @media (max-width: 576px) {
                        .input-group.w-100 {
                            display: flex !important;
                            width: 100% !important;
                        }

                        .input-group.w-100 > .input-group-text {
                            flex: 0 0 40px !important;
                            width: 40px !important;
                            min-width: 40px !important;
                            display: flex !important;
                            justify-content: center;
                            align-items: center;
                        }

                        .input-group.w-100 > #buscadorHistorias,
                        .input-group.w-100 > .form-control {
                            flex: 1 1 auto !important;
                            min-width: 0 !important;
                            width: auto !important;
                        }

                        .input-group.w-100 > .limpiar-busqueda {
                            flex: 0 0 40px !important;
                            width: 40px !important;
                            min-width: 40px !important;
                            padding: 0 !important;
                            display: flex !important;
                            justify-content: center;
                            align-items: center;
                        }
                    }
                    .accordion-button:focus,
                    .accordion-button:active {
                        box-shadow: none !important;
                        outline: none !important;
                    }
                    /* Ajustar menú en móvil */
                    @media (max-width: 767.98px) {
                        .menu-wrapper {
                            transform: scale(0.9);
                        }
                    }

                    /* Evitar modales cortados en móvil */
                    @media (max-width: 767.98px) {
                        .modal-dialog {
                            margin: 0.5rem auto;
                            max-width: 95% !important;
                        }
                        .modal-content {
                            border-radius: 8px;
                        }

                        /* Móvil: abrir menú hacia la derecha */
                        @media (max-width: 767.98px) {
                            .kanban-accordion .menu {
                                left: 0 !important;
                                right: auto !important;
                                transform: translateY(0) translateX(0) !important;
                            }
                        }

                        /* PC: mantener hacia la izquierda (como está ahora) */
                        @media (min-width: 768px) {
                            .menu {
                                right: 0 !important;
                                left: auto !important;
                            }
                        }

                    }
                    /* Forzar color negro en el título del acordeón móvil */
                    .kanban-accordion .accordion-header span {
                        color: #000 !important;
                    }
                    .kanban-accordion .accordion-header span {
                        color: #000 !important;
                        font-weight: 600; /* seminegrita */
                    }




                </style>









@endsection
