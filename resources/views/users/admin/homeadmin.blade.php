@extends('layouts.app')

@section('title', 'Administration - Agile Desk')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/estadisticas-proy.css') }}">
    <!-- DataTables Bootstrap 5 CSS - Local -->
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <style>
        /* Estilos para el panel de administración */
        .admin-header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a90e2;
        }

        .admin-card {
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .admin-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .button-container {
                justify-content: flex-end;
                padding-right: 20px;
            }
        }

        .button-container .btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
            border: none;
            color: white;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 5px;
        }

        .button-container .btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd);
            transform: scale(1.05);
        }

        .quick-stats {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .quick-stats .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a90e2;
        }

        .quick-stats .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .card-body {
            background-color: #ffffff;
            color: #333333;
        }
        .admin-table th {
            background-color: #f8f9fa;
        }

        /* Estilos para paginación */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

         /* Estilos para el buscador en modo claro */
         .input-group .form-control {
            border-radius: 0.25rem 0 0 0.25rem;
        }

        .input-group-append .btn {
            border-radius: 0 0.25rem 0.25rem 0;
        }

        /* Estilos para buscadores mejorados */
        .search-container {
            margin-bottom: 1rem;
        }

        .search-container .input-group {
            max-width: 400px;
        }

        .search-container .form-control {
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .search-container .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .search-container .btn-outline-secondary {
            border-color: #ced4da;
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .search-container .btn-outline-secondary:hover {
            background-color: #4a90e2;
            border-color: #4a90e2;
            color: white;
        }

        /* Estilos para buscadores en headers */
        .card-header .input-group {
            min-width: 250px;
        }

        .card-header .form-control-sm {
            font-size: 0.875rem;
            border: 1px solid #ced4da;
            transition: all 0.15s ease-in-out;
        }

        .card-header .form-control-sm:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.1rem rgba(74, 144, 226, 0.25);
            outline: none;
        }

        .card-header .btn-outline-secondary {
            border-color: #ced4da;
            color: #6c757d;
            background-color: #fff;
            transition: all 0.15s ease-in-out;
        }

        .card-header .btn-outline-secondary:hover,
        .card-header .btn-outline-secondary:focus {
            background-color: #4a90e2;
            border-color: #4a90e2;
            color: white;
        }

        /* Responsive para headers con buscadores */
        @media (max-width: 768px) {
            .card-header.flex-wrap {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem !important;
            }
            
            .card-header .d-flex.align-items-center {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.5rem !important;
            }
            
            .card-header .input-group {
                width: 100% !important;
                min-width: auto;
            }
            
            .card-header .d-flex.gap-2 {
                justify-content: center;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .card-header .d-flex.align-items-center {
                gap: 0.75rem !important;
            }
            
            .card-header span {
                font-size: 1rem;
                font-weight: bold;
            }
        }

        /* Resaltar filas filtradas */
        .highlighted-row {
            background-color: rgba(74, 144, 226, 0.1) !important;
        }

        /* Indicador de sin resultados */
        .no-results-row {
            text-align: center;
            font-style: italic;
            color: #6c757d;
        }

        /* Integración con la plantilla Tabler/Bootstrap */
        .page-header {
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .page-title {
            margin-bottom: 0;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .row{
            padding-block-start: 1rem;
        }

        /* Estilos para truncar texto largo en las tablas */
        .admin-table td {
            max-width: 200px; /* Ancho máximo para las celdas */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Columnas específicas con anchos personalizados */
        .admin-table td:nth-child(1) { /* Columna Nombre */
            max-width: 150px;
        }

        .admin-table td:nth-child(2) { /* Columna Email */
            max-width: 180px;
        }

        .admin-table td:nth-child(3) { /* Columna Rol */
            max-width: 100px;
        }

        .admin-table td:nth-child(4) { /* Columna Estado */
            max-width: 120px;
        }

        .admin-table td:nth-child(5) { /* Columna Acciones */
            max-width: 120px;
            white-space: nowrap; /* Evitar que los botones se envuelvan */
        }

        /* Estilos específicos para nombres de usuario con badges */
        .user-name-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: 150px;
        }

        .user-name-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        /* Responsive: ajustar anchos en pantallas pequeñas */
        @media (max-width: 768px) {
            .admin-table td:nth-child(1) {
                max-width: 120px;
            }
            
            .admin-table td:nth-child(2) {
                max-width: 140px;
            }
            
            .admin-table td:nth-child(3) {
                max-width: 80px;
            }
        }

        /* Configuración específica para cada tabla */
        .table-responsive {
            overflow-x: auto;
        }

        /* Tabla de historial con columnas específicas */
        .admin-table.historial-table td:nth-child(1) { /* Usuario */
            max-width: 130px;
        }

        .admin-table.historial-table td:nth-child(2) { /* Acción */
            max-width: 140px;
        }

        .admin-table.historial-table td:nth-child(3) { /* Detalles */
            max-width: 200px;
        }

        .admin-table.historial-table td:nth-child(4) { /* Fecha */
            max-width: 120px;
        }

        /* Tabla de proyectos */
        .admin-table.proyectos-table td:nth-child(1) { /* Nombre */
            max-width: 180px;
        }

        .admin-table.proyectos-table td:nth-child(2) { /* Responsable */
            max-width: 150px;
        }

        /* Tabla de sprints */
        .admin-table.sprints-table td:nth-child(1) { /* Nombre */
            max-width: 160px;
        }

        .admin-table.sprints-table td:nth-child(2) { /* Proyecto */
            max-width: 150px;
        }

        /* CORREGIR PROBLEMA DE Z-INDEX DE LOS MODALES */
        .modal {
            z-index: 1600 !important; /* Mayor que el navbar (z-index: 1400) */
        }

        .modal-backdrop {
            z-index: 1599 !important; /* Justo debajo del modal */
        }

        /* Mejorar centrado de modales */
        .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 3rem);
            margin: 1.5rem auto;
        }

        .modal-content {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            max-width: 90vw;
            width: 100%;
        }

        /* Responsive para modales */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
                min-height: calc(100vh - 2rem);
            }
            
            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 1.5rem;
            }
        }
        
        /* Estilos mejorados para modales - Simétricos y consistentes */
        .modal-content {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 1.5rem 1.5rem 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
            text-align: center;
        }
        
        .modal-footer {
            border-radius: 0 0 0.75rem 0.75rem;
            padding: 1rem 1.5rem 1.5rem 1.5rem;
            border-top: 1px solid #dee2e6;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .modal-body {
            padding: 1.5rem;
            text-align: center;
        }
        
        .modal-title {
            font-weight: 600;
            margin: 0 auto;
            text-align: center;
        }
        
        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
        
        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
        
        /* Tamaño estándar para todos los modales */
        .modal-dialog {
            max-width: 500px;
            width: 100%;
        }
        
        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 95%;
                margin: 1rem auto;
            }
            
            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 1.25rem;
            }
        }

        /* Estilos para separar las secciones */
        .estadisticas-section {
            margin-top: 3rem;
            padding-top: 2rem;
            padding-left: 1rem; /* Igual que .main-container en móviles */
            padding-right: 1rem; /* Igual que .main-container en móviles */
            border-top: 2px solid #e9ecef;
            position: relative;
        }

        .estadisticas-section::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
        }

        /* Asegurar que main-container tenga el padding correcto */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 768px) {
            .main-container {
                padding: 0 0rem;
            }
            .estadisticas-section {
                padding-left: 0; /* Igual que .main-container en >=768px */
                padding-right: 0; /* Igual que .main-container en >=768px */
            }
        }

        /* Estilos para selector con icono de dropdown */
        .select-with-icon {
            position: relative;
            display: inline-block;
        }
        
        .select-with-icon::after {
            content: '\F282';
            font-family: 'bootstrap-icons';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.875rem;
            z-index: 1;
            pointer-events: none;
        }
        
        .select-with-icon .form-select {
            padding-right: 2.5rem;
            background-image: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        
        .select-with-icon .form-select:focus + ::after {
            color: #4a90e2;
        }

        /* Ajustes del selector de paginación (DataTables) en card-header */
        .card-header .dataTables_length,
        .card-header .dataTables_length label,
        .card-header .dataTables_length select {
            font-weight: 400 !important; /* quitar negrita */
        }
        .card-header .dataTables_length label {
            margin-bottom: 0; /* alineación limpia */
        }

        /* Centrar controles de longitud cuando estén en el body */
        .dt-length-center .dataTables_length {
            display: inline-block;
            text-align: center;
        }
        .dt-length-center .dataTables_length label,
        .dt-length-center .dataTables_length select {
            font-weight: 400 !important;
        }

        /* Centrar paginación de DataTables */
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: center;
            float: none !important;
            width: 100%;
            text-align: center;
            margin-top: 0.5rem;
        }

        /* Estilo de los items para parecer « ‹ 1 2 3 › » */
        .dataTables_wrapper .dataTables_paginate .pagination {
            gap: 14px; /* separación uniforme entre items */
        }

        .dataTables_wrapper .dataTables_paginate .page-item {
            margin: 0; /* usar gap del contenedor */
        }

        .dataTables_wrapper .dataTables_paginate .page-link {
            background: transparent;
            color: #e0e6eb; /* texto claro para tema oscuro */
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 4px 10px;
            line-height: 1.25;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background: transparent;
            color: #ffffff;
            border-color: #ffffff;
            border-width: 2px;
            box-shadow: none;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
            color: #a3aab2;
            opacity: 0.6;
            border-color: transparent;
        }

        .dataTables_wrapper .dataTables_paginate .page-link:hover {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.35);
        }

        /* Altura del selector de longitud de Usuarios igual al buscador (35px) */
        #usuariosTable_length .form-select,
        #usuariosTable_length select {
            height: 35px !important;
            padding-top: 4px;
            padding-bottom: 4px;
            line-height: 1.25;
            border-radius: 8px !important;
        }
        #usuariosTable_length label { margin-bottom: 0; }

        /* Altura del selector de longitud de Proyectos igual al buscador (35px) */
        #proyectosTable_length .form-select,
        #proyectosTable_length select {
            height: 35px !important;
            padding-top: 4px;
            padding-bottom: 4px;
            line-height: 1.25;
            border-radius: 8px !important;
        }
        #proyectosTable_length label { margin-bottom: 0; }

        /* Altura del selector de longitud de Historial igual al buscador (35px) */
        #historialTable_length .form-select,
        #historialTable_length select {
            height: 35px !important;
            padding-top: 4px;
            padding-bottom: 4px;
            line-height: 1.25;
            border-radius: 8px !important;
        }
        #historialTable_length label { margin-bottom: 0; }

        /* Altura del selector de longitud de Sprints igual al buscador (35px) */
        #sprintsTable_length .form-select,
        #sprintsTable_length select {
            height: 35px !important;
            padding-top: 4px;
            padding-bottom: 4px;
            line-height: 1.25;
            border-radius: 8px !important;
        }
        #sprintsTable_length label { margin-bottom: 0; }
    </style>
@stop
@section('content')
<!-- Contenedor de notificaciones flotantes -->
<div id="notification-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1600; width: auto; max-width: 350px;"></div>

<div class="main-container">
    {{-- Alertas para operaciones CRUD --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function () {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        </script>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function () {
                const alert = document.getElementById('error-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="warning-alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('warning') }}
        </div>
        <script>
            setTimeout(function () {
                const alert = document.getElementById('warning-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4500);
        </script>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert" id="info-alert">
            <i class="bi bi-info-circle me-1"></i>
            {{ session('info') }}
        </div>
        <script>
            setTimeout(function () {
                const alert = document.getElementById('info-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <!-- Sección administrativa -->
    <div class="row">
        <!-- Usuarios -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Usuarios</span>
                        <div id="usuariosLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para usuarios -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchUsuarios" placeholder="Buscar usuarios..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchUsuarios">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap" role="group">
                        @if(Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary px-2 py-2">
                                <i class="bi bi-people me-1"></i> Ver Todos
                            </a>
                        @else
                            <a href="{{ route('admin.users.manage') }}" class="btn btn-outline-secondary px-2 py-2">
                                <i class="bi bi-people me-1"></i> Ver Todos
                            </a>
                        @endif
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-warning px-2 py-2">
                            <i class="bi bi-archive me-1"></i> Todos los Eliminados
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table" id="usuariosTable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="usuariosTableBody">
                                @forelse($usuarios as $index => $usuario)
                                <tr class="usuario-row {{ $usuario->trashed() ? 'table-secondary' : '' }}">
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td title="{{ $usuario->name }}">
                                        <div class="user-name-cell">
                                            <span class="user-name-text">{{ $usuario->name }}</span>
                                            @if($usuario->trashed())
                                                <span class="text-dark ms-1">(Eliminado)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td title="{{ $usuario->email }}">{{ $usuario->email }}</td>
                                    @php
                                        $__roleLabel = $usuario->usertype === 'admin' ? 'Administrador' : 'Colaborador';
                                    @endphp
                                    <td class="text-center" title="{{ $__roleLabel }}">{{ $__roleLabel }}</td>
                                    <td class="text-center">
                                        @if($usuario->trashed())
                                            <span class="text-dark">Eliminado</span>
                                        @else
                                            <span class="text-dark">
                                                {{ $usuario->is_approved ? 'Aprobado' : 'Pendiente' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center" role="group">
                                            @if(Auth::user()->isSuperAdmin())
                                                <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary px-2 py-1">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.users.manage') }}" class="btn btn-outline-secondary px-2 py-1">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                            @if($usuario->usertype !== 'admin' || Auth::user()->isSuperAdmin())
                                                @if($usuario->trashed())
                                                    <!-- Botón para restaurar usuario -->
                                                    <button type="button" class="btn btn-outline-success px-2 py-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreUserModal"
                                                            data-user-id="{{ $usuario->id }}"
                                                            data-user-name="{{ $usuario->name }}">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                @else
                                                    <!-- Botón para eliminar usuario -->
                                                    <!-- Botón unificado para eliminar usuarios (admin o colaborador) -->
                                                    <button type="button" class="btn btn-outline-danger px-2 py-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteUserModal"
                                                            data-user-id="{{ $usuario->id }}"
                                                            data-user-name="{{ $usuario->name }}"
                                                            data-user-role="{{ $usuario->usertype === 'admin' ? 'admin' : 'user' }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {{-- Sin fila de vacíos para DataTables --}}
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Paginación manejada por DataTables --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Proyectos -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Proyectos</span>
                        <div id="proyectosLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para proyectos -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchProyectos" placeholder="Buscar proyectos..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchProyectos">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                    <a href="{{ route('projects.my') }}" class="btn btn-outline-secondary px-2 py-2">
                        <i class="bi bi-folder me-1"></i> Ver Todos
                    </a>
                </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table proyectos-table" id="proyectosTable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nombre</th>
                                    <th class="text-center">Responsable</th>
                                    <th class="text-center">Miembros</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="proyectosTableBody">
                                @forelse($proyectos as $proyecto)
                                <tr class="proyecto-row">
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td title="{{ $proyecto->name }}">{{ $proyecto->name }}</td>
                                    <td class="text-center" title="{{ $proyecto->creator->name ?? 'Sin responsable' }}">{{ $proyecto->creator->name ?? 'Sin responsable' }}</td>
                                    <td class="text-center">{{ $proyecto->users->count() }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center" role="group" aria-label="Acciones de proyecto">
                                            <!-- Botón Ver Proyecto -->
                                            <a href="{{ route('tableros.show', $proyecto->id) }}" class="btn btn-outline-secondary px-2 py-1" title="Ver Proyecto">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <!-- Botón Editar -->
                                            <a href="{{ route('projects.edit', $proyecto->id) }}" 
                                               class="btn btn-outline-warning px-2 py-1" 
                                               title="Editar Proyecto">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            <!-- Botón Eliminar -->
                                            <button type="button" 
                                                    class="btn btn-outline-danger px-2 py-1" 
                                                    title="Eliminar Proyecto"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteProjectModal"
                                                    data-project-id="{{ $proyecto->id }}"
                                                    data-project-name="{{ $proyecto->name }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                {{-- Sin fila de vacíos para DataTables --}}
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Paginación manejada por DataTables --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Historial de Cambios</span>
                        <div id="historialLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para historial -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchHistorial" placeholder="Buscar historial..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchHistorial">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    @if(Auth::user()->isSuperAdmin())
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="{{ route('historial.sistema') }}" class="btn btn-outline-secondary px-2 py-2">
                                <i class="bi bi-clock-history me-1"></i> Ver Todo
                            </a>
                        </div>
                    @elseif(Auth::user()->usertype === 'admin')
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="{{ route('users.admin.historial', $proyecto_actual->id ?? 0) }}" class="btn btn-outline-secondary px-2 py-2">
                                <i class="bi bi-clock-history me-1"></i> Ver Todo
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table historial-table align-middle" id="historialTable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Usuario</th>
                                    <th>Detalles</th>
                                    <th>Acción</th>
                                    <!-- <th>Sprint</th> -->
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="historialTableBody">
                                @forelse($historial as $item)
                                <tr class="historial-row">
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td title="{{ $item->usuario }}">
                                        <span class="fw-semibold">{{ $item->usuario }}</span>
                                    </td>
                                    <td title="{{ preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles) }}">
                                        <span>{{ \Illuminate\Support\Str::limit(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles), 40) }}</span>
                                    </td>
                                    <td title="{{ $item->accion }}">
                                        {{ $item->accion }}
                                    </td>
                                    <td>
                                        <span title="{{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i:s') : $item->created_at->format('d/m/Y H:i:s') }}">
                                            {{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->diffForHumans() : $item->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                {{-- Sin fila de vacíos para DataTables --}}
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Paginación manejada por DataTables --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sprints -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Sprints</span>
                        <div id="sprintsLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para sprints -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchSprints" placeholder="Buscar sprints..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchSprints">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table sprints-table" id="sprintsTable">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nombre</th>
                                    <th class="text-center">Proyecto</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="sprintsTableBody">
                                @forelse($sprints as $sprint)
                                <tr class="sprint-row">
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td title="{{ $sprint->nombre }}">{{ $sprint->nombre }}</td>
                                    <td title="{{ $sprint->proyecto->name ?? 'N/A' }}">{{ $sprint->proyecto->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ $sprint->proyecto 
                                            ? route('sprints.index', ['project' => $sprint->proyecto->id]) 
                                            : '#' }}" 
                                            class="btn btn-outline-secondary px-2 py-1">
                                        <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                {{-- Sin fila de vacíos para DataTables --}}
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Paginación manejada por DataTables --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sección de estadísticas del proyecto -->
    <div class="row">
        <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:0.7rem;letter-spacing:0.5px;">Estadisticas del Proyecto</h1>
        
        @auth
            @if(isset($proyecto_actual))
                <!-- Selector de proyecto -->
                <div class="project-selector d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <label for="projectSelectCurrent" class="form-label mb-0 fw-medium">
                            Proyecto:
                        </label>
                        <div class="select-with-icon">
                            <select id="projectSelectCurrent" class="form-select" style="min-width: 240px; max-width: 320px; height: 38px;" 
                                    onchange="window.location.href = '/admin/homeadmin/project/' + this.value">
                                @foreach($proyectos_usuario as $project)
                                    <option value="{{ $project->id }}" {{ $project->id == $proyecto_actual->id ? 'selected' : '' }}>
                                        {{ $project->name }} ({{ $project->codigo }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Botón de historial -->
                     @if(Auth::user()->isSuperAdmin())
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="{{ route('historial.sistema') }}" class="btn btn-outline-primary d-flex align-items-center" style="height: 38px; padding: 0 16px;">
                                <i class="bi bi-clock-history me-1"></i> Historial
                            </a>
                        </div>
                    @elseif(Auth::user()->usertype === 'admin')
                        <div class="d-flex gap-2 align-items-center flex-wrap">
                            <a href="{{ route('users.admin.historial', $proyecto_actual->id ?? 0) }}" class="btn btn-outline-primary d-flex align-items-center" style="height: 38px; padding: 0 16px;">
                                <i class="bi bi-clock-history me-1"></i> Historial
                            </a>
                        </div>
                    @endif

                </div>
                
                <h2 class="current-project-title">
                    <svg viewBox="0 0 16 16" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 2.5A2.5 2.5 0 014.5 0h8.75a.75.75 0 01.75.75v12.5a.75.75 0 01-.75.75h-2.5a.75.75 0 110-1.5h1.75v-2h-8a1 1 0 00-.714 1.7.75.75 0 01-1.072 1.05A2.495 2.495 0 012 11.5v-9zm10.5-1V9h-8c-.356 0-.694.074-1 .208V2.5a1 1 0 011-1h8zM5 12.25v3.25a.25.25 0 00.4.2l1.45-1.087a.25.25 0 01.3 0L8.6 15.7a.25.25 0 00.4-.2v-3.25a.25.25 0 00-.25-.25h-3.5a.25.25 0 00-.25.25z"/>
                    </svg>
                    {{ $proyecto_actual->name }}
                </h2>
                
                <div class="">

                    <!-- Resumen general del proyecto -->
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_historias_proyecto }}</span>
                            <span class="summary-label">Total Historias</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_tareas_proyecto }}</span>
                            <span class="summary-label">Total Tareas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_en_proceso }}</span>
                            <span class="summary-label">En Proceso</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_terminadas }}</span>
                            <span class="summary-label">Terminadas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_contribuciones_proyecto }}</span>
                            <span class="summary-label">Total Contribuciones</span>
                        </div>
                    </div>

                    <!-- Ranking de contribuidores -->
                    @if($estadisticas->count())
                    <div class="contributors-ranking">
                        <div class="ranking-header">
                            <h4 class="ranking-title">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.5 3.75a.75.75 0 0 1 1.5 0v.5h.5a.75.75 0 0 1 0 1.5h-.5v.5a.75.75 0 0 1-1.5 0v-.5h-.5a.75.75 0 0 1 0-1.5h.5v-.5zM2 7.5a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 7.5zm0 3a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 10.5zm8.25-3.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5zm0 3a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5z"/>
                                </svg>
                                Ranking de Contribuidores
                            </h4>
                            <small style="color: var(--github-text-secondary);">En este proyecto</small>
                        </div>
                        
                        @foreach($estadisticas->sortByDesc(fn($stat) => $stat['total_contribuciones']) as $index => $stat)
                            @php
                                $totalContributions = $stat['total_contribuciones'];
                                $rank = $index + 1;
                                $rankClass = $rank <= 3 ? 'top-' . $rank : '';
                                $badgeClass = match(true) {
                                    $totalContributions >= 20 => 'badge-active',
                                    $totalContributions >= 10 => 'badge-moderate',
                                    $totalContributions === 0 => 'badge-inactive',
                                    default => 'badge-new'
                                };
                                $badgeText = match(true) {
                                    $totalContributions >= 20 => 'Muy Activo',
                                    $totalContributions >= 10 => 'Activo',
                                    $totalContributions > 0 => 'Principiante',
                                    default => 'Sin Actividad'
                                };
                            @endphp
                            
                            <div class="contributor-item" 
                                data-user-id="{{ $stat['usuario']->id }}" 
                                data-project-id="{{ $proyecto_actual->id }}">
                                <div class="contributor-rank {{ $rankClass }}">{{ $rank }}</div>
                                
                                <div class="contributor-avatar">
                                    @if($stat['usuario']->photo)
                                        <img src="{{ asset('storage/' . $stat['usuario']->photo) }}" alt="{{ $stat['usuario']->name }}">
                                    @else
                                        <div class="contributor-avatar-placeholder">
                                            {{ strtoupper(substr($stat['usuario']->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="contributor-info">
                                    <h5 class="contributor-name">{{ $stat['usuario']->name }}</h5>
                                    <p class="contributor-email">{{ $stat['usuario']->email }}</p>
                                </div>
                                
                                <div class="contributor-stats">
                                    <div class="contributor-contributions">
                                        {{ $totalContributions }} contribuciones
                                    </div>
                                    <div class="text-dark">
                                        {{ $badgeText }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                        <div class="empty-state-box">
                            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);">
                                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                                    <path d="M16 4C18.2 4 20 5.8 20 8C20 10.2 18.2 12 16 12C13.8 12 12 10.2 12 8C12 5.8 13.8 4 16 4ZM8 4C10.2 4 12 5.8 12 8C12 10.2 10.2 12 8 12C5.8 12 4 10.2 4 8C4 5.8 5.8 4 8 4ZM8 13C11.3 13 16 14.7 16 18V20H0V18C0 14.7 4.7 13 8 13ZM16 13C16.8 13 17.6 13.1 18.4 13.3C20.2 14.1 21.5 15.7 21.5 18V20H17.5V18.5C17.5 16.8 16.9 15.3 16 14.1V13Z"/>
                                </svg>
                            </div>
                            <h4 style="color: #dc2626; font-weight: 600; margin-bottom: 0.5rem;">Sin Colaboradores</h4>
                            <p style="color: #6b7280; margin: 0 0 1rem 0; line-height: 1.5;">No hay contribuciones registradas aún para este proyecto. Agrega colaboradores desde la gestión de usuarios.</p>
                        </div>
                    @endif

                    <!-- Gráfico de contribuciones - Solo mostrar si hay más de un colaborador -->
                    @if($estadisticas->count() > 1)
                        <div class="chart-container">
                            <h4 class="chart-title">Contribuciones en {{ $proyecto_actual->name }}</h4>
                            <div class="chart-wrapper">
                                <canvas id="contributionsChart"></canvas>
                            </div>
                        </div>
                    @elseif($estadisticas->count() === 1)
                        <div class="empty-state-box">
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V21A2 2 0 0 0 5 23H19A2 2 0 0 0 21 21V9M19 9H15V5H19V9Z"/>
                                </svg>
                            </div>
                            <h4 style="color: #4c51bf; font-weight: 600; margin-bottom: 0.5rem;">Proyecto Individual</h4>
                            <p style="color: #6b7280; margin: 0 0 1rem 0; line-height: 1.5;">El gráfico de comparación se muestra cuando hay múltiples colaboradores en el proyecto.</p>
                        </div>
                    @endif
                </div>
            @else
            <div class="no-project-message">
                <h3>No hay proyecto seleccionado</h3>
                <p>Por favor, selecciona un proyecto para ver las estadísticas.</p>
                @if(isset($proyectos_usuario) && $proyectos_usuario->count())
                    <div class="project-selector d-flex justify-content-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <label for="projectSelectPicker" class="form-label mb-0 fw-medium">
                                Seleccionar proyecto:
                            </label>
                            <div class="select-with-icon">
                                <select id="projectSelectPicker" class="form-select form-select-sm" style="min-width: 240px; max-width: 320px;"
                                        onchange="window.location.href = '/admin/homeadmin/project/' + this.value">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($proyectos_usuario as $project)
                                        <option value="{{ $project->id }}">
                                            {{ $project->name }} ({{ $project->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
      @endauth
    </div>
</div>

<!-- Modal de detalles de contribuciones - OPTIMIZADO -->
<div class="modal-overlay" id="contributorModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Detalles de Contribuciones
            </h3>
            <button class="modal-close" id="closeModal" aria-label="Cerrar modal">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="contributorModalContent">
                <!-- El contenido se carga dinámicamente aquí -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p>¿Está seguro de que desea eliminar permanentemente <span id="deleteUserTypeLabel">al usuario</span> <strong id="deleteUserName" class="text-danger"></strong>?</p>
                <div id="adminExtraNotice" class="mt-2 small text-warning" style="display:none;">
                    <i class="bi bi-info-circle"></i> Los proyectos del administrador NO se eliminarán.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteUserForm" method="POST" class="d-inline" data-user-id="" data-user-role="">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para confirmar restauración de usuario -->
<div class="modal fade" id="restoreUserModal" tabindex="-1" aria-labelledby="restoreUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreUserModalLabel">
                    <i class="bi bi-arrow-clockwise text-success"></i>
                    Confirmar Restauración
                </h5>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea restaurar el siguiente elemento?</p>
                <div class="alert alert-info">
                    <strong id="restoreUserName"></strong>
                    <br>
                    <small class="text-muted">El elemento será restaurado a su estado anterior a la eliminación.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreUserForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-clockwise me-1"></i> Restaurar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de proyecto -->
<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProjectModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p>¿Está seguro de que desea eliminar permanentemente el siguiente elemento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteProjectForm" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<style>
    /* Modales con z-index superior a navbar */
    .modal {
        z-index: 1600;
    }
    
    .modal-backdrop {
        z-index: 1599;
    }
    
    /* Alertas de notificación flotantes */
    #notificationContainer .alert {
        margin-bottom: 10px;
        animation: slideInRight 0.3s ease-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .alert.fade-out {
        animation: slideOutRight 0.3s ease-in;
    }
    
    /* Estilos para botones de acción */
    .btn {
        border: none;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>
@endpush

@push('js')
<script>
    // Función para mostrar notificaciones dinámicas
    function showNotification(message, type = 'success') {
        const container = document.getElementById('notificationContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertElement = document.createElement('div');
        alertElement.id = alertId;
        alertElement.className = `alert alert-${type} alert-dismissible fade show`;
        alertElement.style.position = 'relative';
        alertElement.innerHTML = `
            ${message}
            <button type="button" class=" " data-bs-dismiss="alert" aria-label="Cerrar"></button>
        `;
        
        container.appendChild(alertElement);
        
        // Auto-cerrar después de 5 segundos
        setTimeout(() => {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.add('fade-out');
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 300);
            }
        }, 5000);
    }

    // Funciones específicas para acciones de proyectos
    function showProjectSuccess(message) {
        showNotification(`<i class="bi bi-check-circle me-1"></i>${message}`, 'success');
    }

    function showProjectError(message) {
        showNotification(`<i class="bi bi-exclamation-triangle me-1"></i>${message}`, 'danger');
    }

    function showProjectWarning(message) {
        showNotification(`<i class="bi bi-exclamation-circle me-1"></i>${message}`, 'warning');
    }

    function showProjectInfo(message) {
        showNotification(`<i class="bi bi-info-circle me-1"></i>${message}`, 'info');
    }

    document.addEventListener('DOMContentLoaded', function() {
    const BASE_URL = `{{ url('/') }}`;
        // Manejo del modal de eliminación (solo establece la acción del formulario)
        const deleteProjectModal = document.getElementById('deleteProjectModal');
        const deleteProjectForm = document.getElementById('deleteProjectForm');
        if (deleteProjectModal && deleteProjectForm) {
        deleteProjectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
                const projectId = button?.getAttribute('data-project-id');
                const projectName = button?.getAttribute('data-project-name') || '';
                // Guardar nombre (por si se quiere usar en el contenido)
            deleteProjectForm.dataset.projectName = projectName;
            // Configurar la acción del formulario
                if (projectId) {
            deleteProjectForm.action = `{{ url('/') }}/admin/projects/${projectId}/admin-delete`;
                }
        });
            // Sin confirm() adicional: el modal ya actúa como confirmación
            }

        // Manejo del modal de eliminación de usuarios regulares (delegado)
        const deleteUserModal = document.getElementById('deleteUserModal');
        const deleteUserForm = document.getElementById('deleteUserForm');
        document.addEventListener('click', function(e){
            const trigger = e.target.closest('[data-bs-target="#deleteUserModal"]');
            if(!trigger) return;
            const userId = trigger.getAttribute('data-user-id');
            const userName = trigger.getAttribute('data-user-name');
            const userRole = trigger.getAttribute('data-user-role') || 'user';
            console.log('Click eliminar usuario', {userId, userName, userRole});
            const nameEl = document.getElementById('deleteUserName');
            if(nameEl) nameEl.textContent = userName;
            const typeEl = document.getElementById('deleteUserTypeLabel');
            if(typeEl) typeEl.textContent = (userRole === 'admin' ? 'administrador' : 'usuario');
            const adminNotice = document.getElementById('adminExtraNotice');
            if(adminNotice){
                adminNotice.classList.toggle('d-none', userRole !== 'admin');
            }
            if(deleteUserForm && userId){
                deleteUserForm.dataset.userId = userId;
                deleteUserForm.dataset.userRole = userRole;
                deleteUserForm.action = `${BASE_URL}/admin/users/${userId}/delete`;
                console.log('Acción usuario final:', deleteUserForm.action);
            }
        });

        // Fallback al enviar (asegura action correcta)
        if(deleteUserForm){
            deleteUserForm.addEventListener('submit', function(e){
                if(!this.action || this.action === '' || this.action.endsWith('/admin/homeadmin') || this.action.includes('ID_PLACEHOLDER')){
                    const uid = this.dataset.userId;
                    if(uid){
                        this.action = `${BASE_URL}/admin/users/${uid}/delete`;
                        console.warn('Action corregida justo antes de enviar (usuario):', this.action);
                    } else {
                        e.preventDefault();
                        alert('No se pudo determinar el usuario a eliminar. Intenta de nuevo.');
                    }
    // (Eliminado código de modal de admin: se usa deleteUserModal)
            });
        }

    // (Código antiguo de deleteAdminModal eliminado: se usa modal unificado)
    });
</script>
@endpush


@section('scripts')
<script src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
    <script>
        // Prevenir errores de extensiones del navegador
        window.addEventListener('error', function(e) {
            // Silenciar errores de extensiones del navegador
            if (e.filename && (e.filename.includes('extension') || e.filename.includes('chrome-extension') || e.filename.includes('moz-extension'))) {
                e.preventDefault();
                return;
            }
        });

        // Prevenir errores de promesas rechazadas por extensiones
        window.addEventListener('unhandledrejection', function(e) {
            if (e.reason && e.reason.message && 
                (e.reason.message.includes('permission error') || 
                 e.reason.message.includes('extension') ||
                 e.reason.code === 403)) {
                e.preventDefault();
                return;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Modal de eliminación de proyecto: solo establecer action del formulario (sin confirm extra)
                const deleteProjectModal2 = document.getElementById('deleteProjectModal');
                const deleteProjectForm2 = document.getElementById('deleteProjectForm');
                if (deleteProjectModal2 && deleteProjectForm2) {
                    deleteProjectModal2.addEventListener('show.bs.modal', function(event) {
                        try {
                            const button = event.relatedTarget;
                            const projectId = button?.getAttribute('data-project-id');
                            const projectName = button?.getAttribute('data-project-name') || '';
                            deleteProjectForm2.dataset.projectName = projectName;
                            if (projectId) {
                                deleteProjectForm2.action = `{{ url('/') }}/admin/projects/${projectId}/admin-delete`;
                            }
                        } catch (err) {
                            console.error('Error preparando modal de eliminación de proyecto:', err);
                        }
                    });
                }

                // JavaScript para manejar modales de eliminación y restauración de usuarios
                
                // Modal de eliminación de usuario (única inicialización)
                const deleteUserModal = document.getElementById('deleteUserModal');
                if (deleteUserModal) {
                    deleteUserModal.addEventListener('show.bs.modal', function (event) {
                        try {
                            const button = event.relatedTarget;
                            const userId = button?.getAttribute('data-user-id');
                            const userName = button?.getAttribute('data-user-name') || '';
                            const deleteUserNameEl = document.getElementById('deleteUserName');
                            if (deleteUserNameEl) deleteUserNameEl.textContent = userName;
                            const form = document.getElementById('deleteUserForm');
                            if (form && userId) form.action = `{{ url('/') }}/admin/users/${userId}/delete`;
                        } catch (error) {
                            console.error('Error en modal de eliminación:', error);
                        }
                    });
                }
                
                // Modal de restauración de usuario  
                const restoreUserModal = document.getElementById('restoreUserModal');
                if (restoreUserModal) {
                    restoreUserModal.addEventListener('show.bs.modal', function (event) {
                        try {
                            const button = event.relatedTarget;
                            const userId = button.getAttribute('data-user-id');
                            const userName = button.getAttribute('data-user-name');
                            
                            // Actualizar el contenido del modal
                            const restoreUserNameEl = document.getElementById('restoreUserName');
                            if (restoreUserNameEl) {
                                restoreUserNameEl.textContent = userName;
                            }
                            
                            // Actualizar la acción del formulario
                            const form = document.getElementById('restoreUserForm');
                            if (form && userId) {
                                form.action = `{{ url('/') }}/admin/users/${userId}/restore`;
                            }
                        } catch (error) {
                            console.error('Error en modal de restauración:', error);
                        }
                    });
                }
                
                // Referencias a los elementos DOM existentes - Actualizado para múltiples buscadores
                const searchInputs = {
                    usuarios: document.getElementById('searchUsuarios'),
                    proyectos: document.getElementById('searchProyectos'),
                    historial: document.getElementById('searchHistorial'),
                    sprints: document.getElementById('searchSprints')
                };

                const searchButtons = {
                    usuarios: document.getElementById('btnSearchUsuarios'),
                    proyectos: document.getElementById('btnSearchProyectos'),
                    historial: document.getElementById('btnSearchHistorial'),
                    sprints: document.getElementById('btnSearchSprints')
                };

                const tableRows = {
                    usuarios: document.querySelectorAll('.usuario-row'),
                    proyectos: document.querySelectorAll('.proyecto-row'),
                    historial: document.querySelectorAll('.historial-row'),
                    sprints: document.querySelectorAll('.sprint-row')
                };

                // Función genérica para filtrar tablas (usa DataTables si está disponible)
                function filterTable(tableType, searchColumns) {
                    try {
                        const searchInput = searchInputs[tableType];
                        const rows = tableRows[tableType];
                        // Si DataTables está activo, delegar búsqueda a su API
                        const tableIdMap = {
                            usuarios: '#usuariosTable',
                            proyectos: '#proyectosTable',
                            historial: '#historialTable',
                            sprints:   '#sprintsTable'
                        };
                        if (window.jQuery && $.fn && $.fn.DataTable) {
                            const sel = tableIdMap[tableType];
                            if (sel && $(sel).length && $(sel).hasClass('dataTable')) {
                                const dt = $(sel).DataTable();
                                dt.search((searchInput?.value || '').trim()).draw();
                                return; // Evitar filtrado manual
                            }
                        }
                        
                        if (!searchInput || !rows) return;
                        
                        const searchTerm = searchInput.value.toLowerCase().trim();
                        let visibleRows = 0;

                        rows.forEach(row => {
                            try {
                                let shouldShow = false;
                                
                                // Si no hay término de búsqueda, mostrar todo
                                if (searchTerm === '') {
                                    shouldShow = true;
                                } else {
                                    // Buscar en las columnas especificadas
                                    for (let columnIndex of searchColumns) {
                                        const cell = row.querySelector(`td:nth-child(${columnIndex})`);
                                        if (cell) {
                                            const cellText = cell.textContent.toLowerCase();
                                            if (cellText.includes(searchTerm)) {
                                                shouldShow = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                if (shouldShow) {
                                    row.style.display = '';
                                    row.classList.remove('highlighted-row');
                                    if (searchTerm !== '') {
                                        row.classList.add('highlighted-row');
                                    }
                                    visibleRows++;
                                } else {
                                    row.style.display = 'none';
                                    row.classList.remove('highlighted-row');
                                }
                            } catch (error) {
                                console.error('Error al filtrar fila:', error);
                            }
                        });

                        // Manejar mensaje de "sin resultados"
                        const tableBody = document.getElementById(`${tableType}TableBody`);
                        if (tableBody) {
                            const noResultsRow = tableBody.querySelector('.no-results-message');
                            
                            if (visibleRows === 0 && searchTerm !== '') {
                                if (!noResultsRow) {
                                    const emptyRow = document.createElement('tr');
                                    emptyRow.classList.add('no-results-message');
                                    const columnsCount = tableBody.querySelector('tr')?.children.length || 5;
                                    emptyRow.innerHTML = `<td colspan="${columnsCount}" class="no-results-row">No se encontraron resultados para "${searchTerm}"</td>`;
                                    tableBody.appendChild(emptyRow);
                                }
                            } else {
                                if (noResultsRow) {
                                    noResultsRow.remove();
                                }
                            }
                        }
                    } catch (error) {
                        console.error(`Error en filterTable para ${tableType}:`, error);
                    }
                }

                // Función específica para filtrar usuarios (columnas: nombre, email)
                function filterUsuarios() {
                    filterTable('usuarios', [1, 2]); // Columnas 1 (nombre) y 2 (email)
                }

                // Función específica para filtrar proyectos (columnas: nombre, responsable)
                function filterProyectos() {
                    filterTable('proyectos', [1, 2]); // Columnas 1 (nombre) y 2 (responsable)
                }

                // Función específica para filtrar historial (columnas: usuario, acción, detalles)
                function filterHistorial() {
                    filterTable('historial', [1, 2, 3]); // Columnas 1 (usuario), 2 (acción), 3 (detalles)
                }

                // Función específica para filtrar sprints (columnas: nombre, proyecto)
                function filterSprints() {
                    filterTable('sprints', [1, 2]); // Columnas 1 (nombre) y 2 (proyecto)
                }

                // Configurar event listeners para todos los buscadores
                const filterFunctions = {
                    usuarios: filterUsuarios,
                    proyectos: filterProyectos,
                    historial: filterHistorial,
                    sprints: filterSprints
                };

                // Configurar eventos para botones de búsqueda
                Object.keys(searchButtons).forEach(tableType => {
                    const button = searchButtons[tableType];
                    const filterFunction = filterFunctions[tableType];
                    
                    if (button && filterFunction) {
                        button.addEventListener('click', filterFunction);
                    }
                });

                // Configurar eventos para inputs de búsqueda
                Object.keys(searchInputs).forEach(tableType => {
                    const input = searchInputs[tableType];
                    const filterFunction = filterFunctions[tableType];
                    
                    if (input && filterFunction) {
                        let typingTimer;
                        
                        // Filtrar mientras se escribe (con delay)
                        input.addEventListener('keyup', function() {
                            try {
                                clearTimeout(typingTimer);
                                typingTimer = setTimeout(filterFunction, 300); // Delay de 300ms
                            } catch (error) {
                                console.error(`Error en keyup para ${tableType}:`, error);
                            }
                        });

                        // Limpiar timer al seguir escribiendo
                        input.addEventListener('keydown', function() {
                            try {
                                clearTimeout(typingTimer);
                            } catch (error) {
                                console.error(`Error en keydown para ${tableType}:`, error);
                            }
                        });

                        // Filtrar al presionar Enter
                        input.addEventListener('keypress', function(e) {
                            try {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    filterFunction();
                                }
                            } catch (error) {
                                console.error(`Error en keypress para ${tableType}:`, error);
                            }
                        });
                    }
                });

                // Función legacy para compatibilidad con código existente
                function filterProjects() {
                    filterProyectos();
                }
            } catch (error) {
                console.error('Error en DOMContentLoaded:', error);
            }
        });
    </script>
    
    <script>
        // Función de configuración de paginación para cualquier tabla
        function setupTablePagination(tableId, rowSelector, paginationId, rowsPerPage = 5) {
            try {
                const tableBody = document.getElementById(tableId);
                const pagination = document.getElementById(paginationId);
                
                if (!tableBody || !pagination) return;
                
                const rows = tableBody.querySelectorAll(rowSelector);

                // Calcular número de páginas
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                
                if (pageCount <= 1) {
                    pagination.style.display = 'none';
                    return;
                }

                // Limpiar paginación existente
                pagination.innerHTML = '';

                // Botón Anterior
                const prevLi = document.createElement('li');
                prevLi.classList.add('page-item');
                prevLi.innerHTML = '<a class="page-link" href="#">&laquo;</a>';
                pagination.appendChild(prevLi);

                // Páginas numeradas
                for (let i = 1; i <= pageCount; i++) {
                    const li = document.createElement('li');
                    li.classList.add('page-item');
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                    if (i === 1) li.classList.add('active');

                    li.addEventListener('click', function(e) {
                        try {
                            e.preventDefault();
                            showTablePage(tableBody, rows, i, rowsPerPage);

                            // Actualizar clase activa
                            const pageItems = pagination.querySelectorAll('.page-item');
                            pageItems.forEach(item => item.classList.remove('active'));
                            this.classList.add('active');
                        } catch (error) {
                            console.error('Error en click de página:', error);
                        }
                    });

                    pagination.appendChild(li);
                }

                // Botón Siguiente
                const nextLi = document.createElement('li');
                nextLi.classList.add('page-item');
                nextLi.innerHTML = '<a class="page-link" href="#">&raquo;</a>';
                pagination.appendChild(nextLi);

                // Configurar eventos para prev/next
                prevLi.addEventListener('click', function(e) {
                    try {
                        e.preventDefault();
                        const activeItem = pagination.querySelector('.page-item.active');
                        if (activeItem && activeItem.previousElementSibling && activeItem.previousElementSibling.classList.contains('page-item')) {
                            const prevLink = activeItem.previousElementSibling.querySelector('.page-link');
                            if (prevLink) prevLink.click();
                        }
                    } catch (error) {
                        console.error('Error en botón anterior:', error);
                    }
                });

                nextLi.addEventListener('click', function(e) {
                    try {
                        e.preventDefault();
                        const activeItem = pagination.querySelector('.page-item.active');
                        if (activeItem && activeItem.nextElementSibling && activeItem.nextElementSibling.classList.contains('page-item')) {
                            const nextLink = activeItem.nextElementSibling.querySelector('.page-link');
                            if (nextLink) nextLink.click();
                        }
                    } catch (error) {
                        console.error('Error en botón siguiente:', error);
                    }
                });

                // Mostrar primera página al inicio
                showTablePage(tableBody, rows, 1, rowsPerPage);
            } catch (error) {
                console.error('Error en setupTablePagination:', error);
            }
        }

        // Función para mostrar una página específica
        function showTablePage(tableBody, rows, page, rowsPerPage) {
            try {
                // Ocultar todas las filas
                rows.forEach(row => {
                    if (row && row.style) {
                        row.style.display = 'none';
                    }
                });

                // Calcular rango de filas para la página actual
                const startIndex = (page - 1) * rowsPerPage;
                const endIndex = Math.min(startIndex + rowsPerPage, rows.length);

                // Mostrar filas de la página actual
                for (let i = startIndex; i < endIndex; i++) {
                    if (rows[i] && rows[i].style) {
                        rows[i].style.display = '';
                    }
                }
            } catch (error) {
                console.error('Error en showTablePage:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Configuración de paginación para la tabla de proyectos
                setupTablePagination(
                    'projectsTableBody',
                    '.project-row',
                    'projectsPagination',
                    5
                );

                // Configuración de paginación para la tabla de historias
                setupTablePagination(
                    'historiasTableBody',
                    '.historia-row',
                    'historiasPagination',
                    5
                );

                // Configuración específica para la tabla de actividad reciente
                setupTablePagination(
                    'activityTableBody',
                    '.activity-row',
                    'activityPagination',
                    5
                );
            } catch (error) {
                console.error('Error en configuración de paginación:', error);
            }
        });
    </script>
    
    <!-- Scripts para estadísticas del proyecto -->
    <script>
        // Inyectar datos para estadísticas
        window.userContributions = @json($user_contributions ?? []);
        window.estadisticas = @json($estadisticas ?? []);
        window.projectId = @json($proyecto_actual->id ?? null);
        window.columnasOrdenadas = @json($columnas_ordenadas ?? []);
    </script>
    
    <!-- Script externo para estadísticas -->
    <script src="{{ asset('js/estadisticas-proy.js') }}"></script>

    <!-- jQuery (necesario para DataTables) - Local -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- DataTables JS + integración Bootstrap 5 - Local -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Evitar doble init
            if (!window.jQuery || !$.fn || !$.fn.DataTable) {
                console.error('DataTables no está disponible.');
                return;
            }

            // Utilidad para validar columnas (evita _DT_CellIndex)
            function hasConsistentColumns(table) {
                try {
                    const headCols = table.querySelectorAll('thead th').length;
                    const rows = table.querySelectorAll('tbody tr');
                    for (const row of rows) {
                        // Ignorar filas de mensajes personalizados
                        if (row.classList.contains('no-results-message')) continue;
                        const cells = row.querySelectorAll('td').length;
                        if (cells > 0 && cells !== headCols) return false;
                    }
                    return true;
                } catch (e) {
                    return true;
                }
            }

            const commonOpts = {
                paging: true,
                searching: true, // habilitamos búsqueda para buscadores personalizados
                ordering: false,
                info: true,
                lengthChange: true,
                lengthMenu: [ [5, 10, 20, 30], [5, 10, 20, 30] ],
                pageLength: 10,
                pagingType: 'full_numbers',
                language: {
                    emptyTable: 'No hay datos disponibles en la tabla',
                    zeroRecords: 'No se encontraron resultados',
                    lengthMenu: '_MENU_',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_',
                    infoEmpty: 'Mostrando 0 a 0 de 0',
                    infoFiltered: '(filtrado de _MAX_)',
                    search: 'Buscar:',
                    searchPlaceholder: '',
                    loadingRecords: 'Cargando...',
                    processing: 'Procesando...',
                    paginate: {
                        first: '«',
                        previous: '‹',
                        next: '›',
                        last: '»'
                    }
                },
                // l=length, t=table, i=info, p=pagination (ocultamos f=filter)
                dom: 'ltip',
                initComplete: function () {
                    try {
                        const api = this.api();
                        const tableId = api.table().node().id; // e.g., 'usuariosTable'
                        const wrapper = $(api.table().container()); // .dataTables_wrapper
                        const lengthDiv = wrapper.find('div.dataTables_length');
                        const map = {
                            'usuariosTable': '#usuariosLengthContainer',
                            'proyectosTable': '#proyectosLengthContainer',
                            'historialTable': '#historialLengthContainer',
                            'sprintsTable':   '#sprintsLengthContainer'
                        };
                        const targetSelector = map[tableId];
                        const target = targetSelector ? document.querySelector(targetSelector) : null;
                        if (target && lengthDiv.length) {
                            lengthDiv.addClass('mb-0');
                            // Ajuste visual
                            lengthDiv.find('label').addClass('mb-0 d-flex align-items-center gap-2');
                            lengthDiv.find('select')
                                .addClass('form-select form-select-sm')
                                .css({ width: 'auto' });
                            target.innerHTML = '';
                            target.appendChild(lengthDiv.get(0));
                        }
                    } catch (err) {
                        console.warn('No se pudo mover el selector de longitud:', err);
                    }
                }
            };

            const tables = [
                { id: '#usuariosTable', searchInput: '#searchUsuarios' },
                { id: '#proyectosTable', searchInput: '#searchProyectos' },
                { id: '#historialTable', searchInput: '#searchHistorial' },
                { id: '#sprintsTable', searchInput: '#searchSprints' },
            ];

            tables.forEach(cfg => {
                const el = document.querySelector(cfg.id);
                if (!el) return;
                if (!hasConsistentColumns(el)) {
                    console.warn('Columnas inconsistentes en', cfg.id, '— se omite DataTables');
                    return;
                }
                try {
                    const dt = $(cfg.id).DataTable(commonOpts);
                    
                    // Función optimizada para normalizar texto
                    function normalizarTexto(texto) {
                        if (!texto) return '';
                        return texto
                            .toLowerCase()
                            .normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '') // Remover acentos
                            .trim();
                    }
                    
                    // Conectar buscador personalizado optimizado
                    const input = document.querySelector(cfg.searchInput);
                    if (input) {
                        let searchTimeout;
                        input.addEventListener('input', function() {
                            clearTimeout(searchTimeout);
                            searchTimeout = setTimeout(() => {
                                const textoBusqueda = normalizarTexto(this.value);
                                
                                if (textoBusqueda === '') {
                                    dt.search('').draw();
                                    return;
                                }
                                
                                // Búsqueda simple y rápida - solo normalizar acentos
                                dt.search(textoBusqueda, false, true).draw(); // regex: false, smart: true
                            }, 150); // Reducido de 300ms a 150ms
                        });
                    }
                } catch (e) {
                    console.error('Error inicializando DataTable para', cfg.id, e);
                }
            });
        });
    </script>
@stop
