@extends('layouts.app')

@section('title', 'Administration - Agile Desk')

@section('styles')
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
            
            .card-header .btn-group {
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

        /* Estilos para los btn-group sin bordes redondeados y separados */
        .btn-group {
            gap: 8px; /* Separación entre botones */
        }

        /* Quitar el borde entre los botones del grupo para que se vean como btn-info independientes */
        .btn-group .btn {
            border-radius: 6px !important;
            margin-right: 0;
            border: none !important;
            box-shadow: 1px 1px 8px rgba(0,0,0,0.08);
        }

        .btn-group .btn:focus, .btn-group .btn:active {
            outline: none;
            box-shadow: 0 0 0 0.15rem rgba(74,144,226,0.25);
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

        /* Tooltip para mostrar el texto completo al hacer hover */
        .admin-table td[title] {
            cursor: help;
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
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
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
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            max-width: 90vw;
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
                padding: 1rem;
            }
        }
    </style>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Usuarios -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Usuarios</span>
                        <!-- Buscador para usuarios -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchUsuarios" placeholder="Buscar usuarios...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchUsuarios">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-info">
                            <i class="bi bi-people"></i> Ver Todos
                        </a>
                        <a href="{{ route('admin.deleted-users') }}" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Usuarios Eliminados
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="usuariosTableBody">
                                @forelse($usuarios as $usuario)
                                <tr class="usuario-row {{ $usuario->trashed() ? 'table-secondary' : '' }}">
                                    <td title="{{ $usuario->name }}">
                                        <div class="user-name-cell">
                                            <span class="user-name-text">{{ $usuario->name }}</span>
                                            @if($usuario->trashed())
                                                <span class="badge bg-secondary ms-1">Eliminado</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td title="{{ $usuario->email }}">{{ $usuario->email }}</td>
                                    <td title="{{ ucfirst($usuario->usertype) }}">{{ ucfirst($usuario->usertype) }}</td>
                                    <td>
                                        @if($usuario->trashed())
                                            <span class="badge bg-secondary">Eliminado</span>
                                        @else
                                            <span class="badge {{ $usuario->is_approved ? 'bg-success' : 'bg-warning' }}">
                                                {{ $usuario->is_approved ? 'Aprobado' : 'Pendiente' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($usuario->usertype !== 'admin')
                                                @if($usuario->trashed())
                                                    <!-- Botón para restaurar usuario -->
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreUserModal"
                                                            data-user-id="{{ $usuario->id }}"
                                                            data-user-name="{{ $usuario->name }}">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                @else
                                                    <!-- Botón para eliminar usuario -->
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteUserModal"
                                                            data-user-id="{{ $usuario->id }}"
                                                            data-user-name="{{ $usuario->name }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay usuarios registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            {{ $usuarios->links() }}
                        </div>
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
                        <!-- Buscador para proyectos -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchProyectos" placeholder="Buscar proyectos...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchProyectos">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('projects.my') }}" class="btn btn-sm btn-info">
                        <i class="bi bi-folder"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table proyectos-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Responsable</th>
                                    <th>Miembros</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="proyectosTableBody">
                                @forelse($proyectos as $proyecto)
                                <tr class="proyecto-row">
                                    <td title="{{ $proyecto->name }}">{{ $proyecto->name }}</td>
                                    <td title="{{ $proyecto->creator->name ?? 'Sin responsable' }}">{{ $proyecto->creator->name ?? 'Sin responsable' }}</td>
                                    <td>{{ $proyecto->users->count() }}</td>
                                    <td>
                                        <a href="{{ route('tableros.show', $proyecto->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay proyectos registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            {{ $proyectos->links() }}
                        </div>
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
                        <!-- Buscador para historial -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchHistorial" placeholder="Buscar historial...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchHistorial">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('historial.index') }}" class="btn btn-sm btn-info">
                        <i class="bi bi-clock-history"></i> Ver Todo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table historial-table align-middle">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Detalles</th>
                                    <!-- <th>Sprint</th> -->
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="historialTableBody">
                                @forelse($historial as $item)
                                <tr class="historial-row">
                                    <td title="{{ $item->usuario }}">
                                        <span class="fw-semibold">{{ $item->usuario }}</span>
                                    </td>
                                    <td title="{{ $item->accion }}">
                                        {{ $item->accion }}
                                    </td>
                                    <td title="{{ preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles) }}">
                                        <span>{{ \Illuminate\Support\Str::limit(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles), 40) }}</span>
                                    </td>
                                    <!-- <td>
                                        @if($item->sprint)
                                            <span class="badge bg-info text-dark">#{{ $item->sprint }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td> -->
                                    <td>
                                        <span title="{{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i:s') : $item->created_at->format('d/m/Y H:i:s') }}">
                                            {{ $item->fecha ? \Carbon\Carbon::parse($item->fecha)->diffForHumans() : $item->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay historial registrado</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            {{ $historial->links() }}
                        </div>
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
                        <!-- Buscador para sprints -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchSprints" placeholder="Buscar sprints...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchSprints">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="#" class="btn btn-sm btn-info">
                        <i class="bi bi-flag"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table sprints-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="sprintsTableBody">
                                @forelse($sprints as $sprint)
                                <tr class="sprint-row">
                                    <td title="{{ $sprint->nombre }}">{{ $sprint->nombre }}</td>
                                    <td title="{{ $sprint->proyecto->name ?? 'N/A' }}">{{ $sprint->proyecto->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $sprint->estado === 'completado' ? 'bg-success' : ($sprint->estado === 'en progreso' ? 'bg-info' : 'bg-warning') }}">
                                            {{ ucfirst($sprint->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay sprints registrados</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            {{ $sprints->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <h5 class="modal-title text-danger" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                    <h5 class="modal-title text-danger">¿Deseas eliminar este usuario?</h5>
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                    <div class="alert alert-danger d-flex align-items-center mt-3">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>
                            "<strong><span id="deleteUserName"></span></strong>" será eliminado permanentemente.
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteUserForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal para confirmar restauración de usuario -->
<div class="modal fade" id="restoreUserModal" tabindex="-1" aria-labelledby="restoreUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreUserModalLabel">Confirmar Restauración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea restaurar al usuario <strong id="restoreUserName"></strong>?</p>
                <p class="text-muted small">El usuario será restaurado al estado activo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreUserForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-clockwise me-1"></i> Restaurar Usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
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
                // JavaScript para manejar modales de eliminación y restauración de usuarios
                
                // Modal de eliminación de usuario
                const deleteUserModal = document.getElementById('deleteUserModal');
                if (deleteUserModal) {
                    deleteUserModal.addEventListener('show.bs.modal', function (event) {
                        try {
                            const button = event.relatedTarget;
                            const userId = button.getAttribute('data-user-id');
                            const userName = button.getAttribute('data-user-name');
                            
                            // Actualizar el contenido del modal
                            const deleteUserNameEl = document.getElementById('deleteUserName');
                            if (deleteUserNameEl) {
                                deleteUserNameEl.textContent = userName;
                            }
                            
                            // Actualizar la acción del formulario
                            const form = document.getElementById('deleteUserForm');
                            if (form && userId) {
                                form.action = `/admin/users/${userId}/delete`;
                            }
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
                                form.action = `/admin/users/${userId}/restore`;
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

                // Función genérica para filtrar tablas
                function filterTable(tableType, searchColumns) {
                    try {
                        const searchInput = searchInputs[tableType];
                        const rows = tableRows[tableType];
                        
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
@stop