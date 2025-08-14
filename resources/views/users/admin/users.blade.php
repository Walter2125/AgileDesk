@extends('layouts.app')

@section('title', 'Usuarios del Sistema - Agile Desk')
    @section('mensaje-superior')
        Usuarios del Sistema
    @endsection

@section('styles')
<!-- DataTables Bootstrap 5 CSS - Local -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
<style>
    /* Truncado con elipsis y tooltip */
    .truncate {
        display: inline-block;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: bottom;
    }
    .truncate-name { max-width: 220px; }
    .truncate-email { max-width: 260px; }
    @media (max-width: 992px) {
        .truncate-name { max-width: 180px; }
        .truncate-email { max-width: 220px; }
    }
    @media (max-width: 576px) {
        .truncate-name { max-width: 140px; }
        .truncate-email { max-width: 180px; }
    }
    .user-dropdown .dropdown-menu {
        z-index: 1550 !important;
    }
    
    .modal {
        z-index: 1600 !important;
    }

    .modal-backdrop {
        z-index: 1599 !important;
    }

    /* Estilos para DataTables */
    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: center;
        float: none !important;
        width: 100%;
        text-align: center;
        margin-top: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .pagination {
        gap: 14px;
    }

    .dataTables_wrapper .dataTables_paginate .page-item {
        margin: 0;
    }

    .dataTables_wrapper .dataTables_paginate .page-link {
        background: transparent;
        color: #6c757d;
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 4px 10px;
        line-height: 1.25;
    }

    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
        background: #0d6efd;
        color: #ffffff;
        border-color: #0d6efd;
        border-width: 2px;
        box-shadow: none;
    }

    .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
        color: #a3aab2;
        opacity: 0.6;
        border-color: transparent;
    }

    .dataTables_wrapper .dataTables_paginate .page-link:hover {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
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
            gap: 1rem !important;
        }

        .card-header .d-flex.align-items-center {
            flex-wrap: wrap;
            gap: 0.5rem !important;
        }

        .card-header .input-group {
            min-width: 200px;
            max-width: 250px;
        }

        .card-header .d-flex.gap-2 {
            justify-content: center;
            width: 100%;
        }

        .card-header .d-flex.align-items-center {
            justify-content: center;
        }

        .card-header span {
            font-size: 1rem;
            font-weight: bold;
        }
    }

    /* Ajustes del selector de paginación (DataTables) en card-header */
    .card-header .dataTables_length,
    .card-header .dataTables_length label,
    .card-header .dataTables_length select {
        margin: 0 !important;
    }
    .card-header .dataTables_length label {
        font-size: 0.875rem;
        color: #6c757d;
        white-space: nowrap;
    }

    /* Estilos para badges de rol */
    .badge-admin {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-collaborator {
        background-color: #0d6efd;
        color: white;
    }

    /* Espaciado inferior */
    .page-bottom-spacing {
        padding-bottom: 4rem;
    }

    /* Estilos para estados de usuario */
    .status-approved {
        color: #198754;
        font-weight: 500;
    }
    
    .status-pending {
        color: #fd7e14;
        font-weight: 500;
    }
    
    .status-rejected {
        color: #dc3545;
        font-weight: 500;
    }
</style>
@stop

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Usuarios ({{ $users->count() }})</span>
                        <div id="usersLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para usuarios -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="usersSearchInput" placeholder="Buscar usuarios..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchUsers">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap" role="group">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-2 py-2">
                            <i class="bi bi-clock"></i> Usuarios Pendientes
                        </a>
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-warning px-2 py-2">
                            <i class="bi bi-archive"></i> Eliminados
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="usersTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th class="text-center">Rol</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Fecha de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="user-row">
                                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                            <td>
                                                <strong class="truncate truncate-name" data-bs-title="{{ $user->name }}" title="" data-bs-toggle="tooltip">{{ $user->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="truncate truncate-email" data-bs-title="{{ $user->email }}" title="" data-bs-toggle="tooltip">{{ $user->email }}</span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $roleLabel = $user->usertype === 'admin' ? 'Administrador' : 'Colaborador';
                                                    $badgeClass = $user->usertype === 'admin' ? 'badge-admin' : 'badge-collaborator';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $roleLabel }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($user->usertype === 'admin')
                                                    <span class="status-approved">
                                                        <i class="bi bi-shield-check"></i> Activo
                                                    </span>
                                                @else
                                                    @if($user->is_approved)
                                                        <span class="status-approved">
                                                            <i class="bi bi-check-circle"></i> Aprobado
                                                        </span>
                                                    @elseif($user->is_rejected)
                                                        <span class="status-rejected">
                                                            <i class="bi bi-x-circle"></i> Rechazado
                                                        </span>
                                                    @else
                                                        <span class="status-pending">
                                                            <i class="bi bi-clock"></i> Pendiente
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $user->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Paginación manejada por DataTables --}}
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people" style="font-size: 3rem; color: #dee2e6;"></i>
                            <h4 class="mt-3">No hay usuarios registrados</h4>
                            <p class="text-muted">Aún no se han registrado usuarios en el sistema.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Espaciado inferior adicional -->
            <div class="page-bottom-spacing"></div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<!-- jQuery (necesario para DataTables) - Local -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- DataTables JS + integración Bootstrap 5 - Local -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- Configuración reutilizable de DataTables -->
<script src="{{ asset('js/datatables-config.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar que DataTables esté disponible
    if (!initializeDataTables()) {
        return;
    }

    // Inicializar tabla de usuarios
    const usersTable = DataTablesConfig.initTable(
        '#usersTable',
        DataTablesConfig.getUsersConfig()
    );

    if (usersTable) {
        console.log('Tabla de usuarios inicializada correctamente');
        // Inicializar tooltips al cargar y tras redraw
        const initTooltips = () => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(el => {
                const existing = bootstrap.Tooltip.getInstance(el);
                if (existing) existing.dispose();
                new bootstrap.Tooltip(el, {
                    container: 'body',
                    boundary: 'window',
                    placement: 'auto',
                    html: false
                });
            });
        };
        initTooltips();
        $('#usersTable').on('draw.dt', function() { initTooltips(); });
        
        // Conectar buscador personalizado
        const searchInput = document.getElementById('usersSearchInput');
        const searchButton = document.getElementById('btnSearchUsers');
        
        if (searchInput && searchButton) {
            // Función para realizar búsqueda
            function performSearch() {
                const searchTerm = searchInput.value.trim();
                usersTable.search(searchTerm).draw();
            }

            // Búsqueda en tiempo real mientras se escribe
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });

            // Búsqueda al hacer clic en el botón
            searchButton.addEventListener('click', performSearch);

            // Búsqueda al presionar Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            // Limpiar búsqueda al presionar Escape
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    usersTable.search('').draw();
                    this.blur();
                }
            });
        }
    }
});
</script>
@stop