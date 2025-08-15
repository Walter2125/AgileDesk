@extends('layouts.app')

@section('mensaje-superior')
    Sprints del Proyecto
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">
        <div class="mb-3 d-flex justify-content-end boton-wrapper">
            {{-- Aquí podrías poner un botón de crear sprint si lo necesitas --}}
        </div>

        <div class="mx-n3 mx-md-n4">
            @forelse ($proyecto->sprints as $sprint)
                <div class="card mb-2 p-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center">
                        <div>
                            <strong>{{ $sprint->nombre }}</strong><br>
                            <small class="text-muted">Inicio: {{ $sprint->fecha_inicio }} | Fin: {{ $sprint->fecha_fin }}</small>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-sm-0">
                            <a href="{{ route('sprints.edit', $sprint->id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1">
                                <i class="bi bi-pencil" style="font-size: 0.9rem;"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm px-2 py-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteSprintModal{{ $sprint->id }}">
                                <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal de confirmación de eliminación --}}
                <div class="modal fade" id="deleteSprintModal{{ $sprint->id }}" tabindex="-1" aria-labelledby="deleteSprintModalLabel{{ $sprint->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center">
                            <div class="modal-header justify-content-center position-relative">
                                <h5 class="modal-title" id="deleteSprintModalLabel{{ $sprint->id }}">
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
                                <p>¿Está seguro de que desea eliminar el sprint <strong>{{ $sprint->nombre }}</strong>?</p>
                            </div>
                            <div class="modal-footer justify-content-center">
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
            @empty
                <div class="card mb-2 p-3">
                    <div class="text-muted">
                        No hay sprints registrados en este proyecto.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @push('css')
        <style>
            @media (max-width: 576px) {
                .card .d-flex.gap-2 {
                    flex-direction: column; /* Botones uno debajo del otro */
                }
                .card .btn {
                    width: 100%; /* Botones ocupan todo el ancho */
                }
            }
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
                min-width: 180px; /* Botones del mismo ancho en escritorio */
            }
            @media (max-width: 576px) {
                .modal-footer .btn {
                    min-width: auto;
                    width: 100%; /* Botones ocupan todo el ancho en móvil */
                }
            }
        </style>








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
            @media (max-width: 767.98px) {
                .modal[id^="deleteHistoriaModal"] {
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    z-index: 2000 !important;
                    display: block;
                }
                .modal[id^="deleteHistoriaModal"] .modal-dialog {
                    margin: 1rem auto !important;
                    max-width: 95% !important;
                }
            }
            @media (max-width: 767.98px) {
                .modal[id^="deleteHistoriaModal"] {
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    z-index: 2000 !important;
                    display: block; /* asegura que no dependa del flujo del accordion */
                }
                .modal[id^="deleteHistoriaModal"] .modal-dialog {
                    margin: 1rem auto !important;
                    max-width: 95% !important;
                }
            }







        </style>
    @endpush
@endsection
