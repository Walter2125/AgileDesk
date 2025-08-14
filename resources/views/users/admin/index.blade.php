@extends('layouts.app')

    @section('mensaje-superior')
        Usuarios Pendientes
    @endsection

@section('styles')
<!-- Meta CSRF token para peticiones AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    .truncate-email { max-width: 280px; }
    @media (max-width: 992px) {
        .truncate-name { max-width: 180px; }
        .truncate-email { max-width: 220px; }
    }
    @media (max-width: 576px) {
        .truncate-name { max-width: 140px; }
        .truncate-email { max-width: 180px; }
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
            gap: 1rem;
        }

        .card-header .d-flex.align-items-center {
            flex-wrap: wrap;
            gap: 0.5rem;
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
        margin: 0;
    }
    
    .card-header .dataTables_length label {
        font-size: 0.875rem;
        color: #6c757d;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header .dataTables_length select {
        height: 36px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 6px 12px;
        font-size: 0.875rem;
        min-width: 80px;
        background-color: white;
    }
    
    .card-header .dataTables_length select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 0.1rem rgba(74, 144, 226, 0.25);
        outline: none;
    }
    
    /* Ocultar controles de DataTables en lugares no deseados */
    .dataTables_wrapper .dataTables_length:not(.card-header .dataTables_length) {
        display: none;
    }
    
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }
    
    .dataTables_wrapper .dataTables_info {
        display: none;
    }

    /* Estilos para DataTables */
    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: center;
        float: none;
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

    /* Estilos consistentes con homeadmin.blade.php */
    .admin-card {
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .admin-card .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .admin-table th {
        background-color: #f8f9fa;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal personalizado */
    .modal {
        z-index: 1600;
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

        .modal-footer {
            padding: 1rem 1.25rem 1.25rem 1.25rem;
        }
    }

    /* Espaciado inferior */
    .page-bottom-spacing {
        padding-bottom: 4rem;
    }

    /* Mensaje de tabla vacía */
    .no-results-message td {
        border: none;
        background: transparent;
    }

    .no-results-message:hover {
        background: transparent;
    }

    /* Estilos para alertas de Bootstrap */
    .alert {
        border: none !important;
        border-radius: 0.5rem !important;
        padding: 1rem 1.25rem !important;
        margin-bottom: 1rem !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        font-weight: 500 !important;
    }

    .alert-success {
        background-color: #d1e7dd !important;
        color: #0f5132 !important;
        border-left: 4px solid #198754 !important;
    }

    .alert-danger {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        border-left: 4px solid #dc3545 !important;
    }

    .alert-warning {
        background-color: #fff3cd !important;
        color: #664d03 !important;
        border-left: 4px solid #ffc107 !important;
    }

    .alert-info {
        background-color: #cff4fc !important;
        color: #055160 !important;
        border-left: 4px solid #0dcaf0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    {{-- Alertas para operaciones CRUD --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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
            <i class="bi bi-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
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

    <div class="row">
        <div class="col-12">
            <div class="card admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Usuarios Pendientes ({{ $pendingUsers->count() }})</span>
                        <div id="pendingUsersLengthContainer" class="d-flex align-items-center"></div>
                        <!-- Buscador para usuarios pendientes -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="pendingUsersSearchInput" placeholder="Buscar usuarios..." style="height: 35px;">
                            <button class="btn btn-outline-secondary" type="button" id="btnSearchPendingUsers">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center flex-wrap" role="group">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary px-2 py-2">
                            <i class="bi bi-people"></i> Todos los Usuarios
                        </a>
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-warning px-2 py-2">
                            <i class="bi bi-archive"></i> Eliminados
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pendingUsersTable" class="table table-hover admin-table align-middle mb-0">
                                                        <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th class="text-center">Fecha de Registro</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pendingUsers->isEmpty())
                                    <tr class="no-results-message">
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                            <h4 class="fw-semibold text-muted mt-3">No hay usuarios pendientes</h4>
                                            <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($pendingUsers as $user)
                                        <tr data-user-id="{{ $user->id }}">
                                            <td>
                                                <div class="fw-medium truncate truncate-name" data-bs-title="{{ $user->name }}" title="" data-bs-toggle="tooltip">{{ $user->name }}</div>
                                            </td>
                                            <td>
                                                <div class="truncate truncate-email" data-bs-title="{{ $user->email }}" title="" data-bs-toggle="tooltip">{{ $user->email }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div>{{ $user->created_at->format('d/m/Y H:i') }}</div>
                                                <div><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small></div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark status-badge">
                                                    <i class="bi bi-clock me-1"></i>Pendiente
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-1 justify-content-center" role="group">
                                                    <!-- Botón para aprobar usuario -->
                                                    <button type="button" class="btn btn-outline-success px-2 py-1"
                                                            data-bs-toggle="modal" data-bs-target="#approveModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            data-user-email="{{ $user->email }}"
                                                            title="Aprobar">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>

                                                    <!-- Botón para rechazar usuario -->
                                                    <button type="button" class="btn btn-outline-danger px-2 py-1"
                                                            data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            title="Rechazar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Espaciado inferior adicional -->
            <div class="page-bottom-spacing"></div>
        </div>
    </div>
</div>

<!-- Modal de Aprobación -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">
                    <i class="bi bi-check-circle text-success"></i>
                    Aprobar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="approveUserForm" action="#">
                @csrf
                @method('POST')
                <input type="hidden" name="user_id" id="approveUserId" value="">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>¿Está seguro de que desea aprobar el siguiente usuario?</strong>
                    </div>
                    <p>El usuario recibirá acceso completo a la plataforma y podrá colaborar en proyectos.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="approveSubmitBtn" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Aprobar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Rechazo -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Rechazar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="rejectUserForm" action="#">
                @csrf
                @method('POST')
                <input type="hidden" name="user_id" id="rejectUserId" value="">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                    </div>
                    <p>¿Está seguro de que desea rechazar el siguiente usuario?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="rejectSubmitBtn" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Rechazar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

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
    console.log('DOM Content Loaded - Iniciando verificaciones...');
    
    // Usar setTimeout para asegurar que el DOM esté completamente renderizado
    setTimeout(function() {
        console.log('setTimeout ejecutado - Verificando dependencias...');
        
        // Verificar que jQuery esté disponible
        if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
            console.error('jQuery no está disponible');
            return;
        }

    // Pre-bind click handlers on action buttons to set actions early
    document.querySelectorAll('[data-bs-target="#approveModal"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const userId = btn.getAttribute('data-user-id');
            const approveForm = document.getElementById('approveUserForm');
            const approveHidden = document.getElementById('approveUserId');
            if (approveForm && userId) {
                approveForm.action = `/admin/users/${userId}/approve`;
                if (approveHidden) approveHidden.value = userId;
            }
        });
    });
    document.querySelectorAll('[data-bs-target="#rejectModal"]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const userId = btn.getAttribute('data-user-id');
            const rejectForm = document.getElementById('rejectUserForm');
            const rejectHidden = document.getElementById('rejectUserId');
            if (rejectForm && userId) {
                rejectForm.action = `/admin/users/${userId}/reject`;
                if (rejectHidden) rejectHidden.value = userId;
            }
        });
    });
        console.log('✓ jQuery disponible');
        
        // Verificar que DataTables esté disponible
        if (typeof $.fn.DataTable === 'undefined') {
            console.error('DataTables no está disponible');
            return;
        }
        console.log('✓ DataTables disponible');
        
        // Verificar que la tabla exista en el DOM
        const tableElement = document.getElementById('pendingUsersTable');
        if (!tableElement) {
            console.error('Tabla #pendingUsersTable no encontrada en el DOM');
            return;
        }
        console.log('✓ Tabla #pendingUsersTable encontrada');

        // Verificar que la tabla tenga filas de datos (excluyendo mensaje de tabla vacía)
        const tbody = tableElement.querySelector('tbody');
        const dataRows = tbody ? tbody.querySelectorAll('tr:not(.no-results-message)') : [];
        const messageRow = tbody ? tbody.querySelector('tr.no-results-message') : null;
        
        console.log('Filas de datos en la tabla:', dataRows.length);
        console.log('Mensaje de tabla vacía:', !!messageRow);

        console.log('Inicializando DataTables directamente...');

        // Configuración de DataTables
        const tableConfig = {
            paging: true,
            searching: false, // Usamos buscador personalizado
            ordering: true,
            info: true,
            lengthChange: true,
            lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
            pageLength: 10,
            pagingType: 'full_numbers',
            language: {
                emptyTable: 'No hay usuarios pendientes',
                zeroRecords: 'No se encontraron usuarios',
                lengthMenu: '_MENU_',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ usuarios',
                infoEmpty: 'Mostrando 0 a 0 de 0 usuarios',
                infoFiltered: '(filtrado de _MAX_ total)',
                paginate: {
                    first: '«',
                    previous: '‹',
                    next: '›',
                    last: '»'
                }
            },
            dom: 'ltip', // l=length, t=table, i=info, p=pagination
            columnDefs: [
                { orderable: false, targets: [4] }, // Desabilitar ordenamiento en columna Acciones
                { className: 'text-center', targets: [2, 3, 4] } // Centrar columnas Fecha, Estado y Acciones
            ],
            order: [[1, 'desc']], // Ordenar por fecha de registro (más recientes primero)
            initComplete: function() {
                const api = this.api();
                const wrapper = $(api.table().container());
                const lengthDiv = wrapper.find('div.dataTables_length');
                const target = document.querySelector('#pendingUsersLengthContainer');
                
                if (target && lengthDiv.length) {
                    lengthDiv.addClass('mb-0');
                    lengthDiv.find('label').addClass('mb-0 d-flex align-items-center gap-2');
                    lengthDiv.find('select').addClass('form-select form-select-sm').css({ width: 'auto' });
                    target.innerHTML = '';
                    target.appendChild(lengthDiv.get(0));
                }
            }
        };
        
        // Si la tabla está vacía, deshabilitar paginación
        if (dataRows.length === 0) {
            console.log('Tabla vacía detectada - deshabilitando paginación');
            tableConfig.paging = false;
            tableConfig.info = false;
        }

        // Inicializar tabla de usuarios pendientes
        try {
            const pendingUsersTable = $('#pendingUsersTable').DataTable(tableConfig);

            if (pendingUsersTable) {
                console.log('✓ Tabla de usuarios pendientes inicializada correctamente');
                console.log('DataTables instance:', pendingUsersTable);

                // Inicializar tooltips al cargar
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
                // Reinicializar tooltips tras cada redibujado de DataTables
                $('#pendingUsersTable').on('draw.dt', function() {
                    initTooltips();
                });
                
                // Conectar buscador personalizado solo si hay datos
                if (dataRows.length > 0) {
                    console.log('Conectando buscador personalizado...');
                    const searchInput = document.getElementById('pendingUsersSearchInput');
                    const searchButton = document.getElementById('btnSearchPendingUsers');
                    
                    if (searchInput && searchButton) {
                        console.log('✓ Conectando buscador personalizado');
                    
                        // Función para realizar búsqueda
                        function performSearch() {
                            const searchTerm = searchInput.value.trim();
                            pendingUsersTable.search(searchTerm).draw();
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
                                pendingUsersTable.search('').draw();
                                this.blur();
                            }
                        });
                    } else {
                        console.warn('Elementos de búsqueda no encontrados');
                    }
                } else {
                    console.log('Tabla vacía - omitiendo configuración de búsqueda');
                }
            } else {
                console.error('❌ Error: No se pudo inicializar la tabla');
                return;
            }
        } catch (error) {
            console.error('❌ Error durante la inicialización de DataTables:', error);
            return;
        }

    // Modal de aprobación
    const approveModal = document.getElementById('approveModal');
    const approveUserForm = document.getElementById('approveUserForm');
    const approveSubmitBtn = document.getElementById('approveSubmitBtn');
    let currentApproveUserId = null;

    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.getAttribute('data-user-email');

            // Guardar el ID del usuario actual
            currentApproveUserId = userId;

            // Actualizar la acción del formulario
            if (approveUserForm) {
                const newAction = `/admin/users/${userId}/approve`;
                console.log('Actualizando acción de aprobación a:', newAction);
                approveUserForm.action = newAction;
                const approveHidden = document.getElementById('approveUserId');
                if (approveHidden) approveHidden.value = userId;
            }

            // Habilitar botón de envío
            if (approveSubmitBtn) {
                approveSubmitBtn.disabled = !userId || userId === "0";
            }
        });
    }

    // Modal de rechazo
    const rejectModal = document.getElementById('rejectModal');
    const rejectUserForm = document.getElementById('rejectUserForm');
    const rejectSubmitBtn = document.getElementById('rejectSubmitBtn');
    let currentRejectUserId = null;

    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.dataset.userEmail ||
                             (document.querySelector(`tr[data-user-id="${userId}"] .text-muted`) ? 
                              document.querySelector(`tr[data-user-id="${userId}"] .text-muted`).textContent : '');

            // Guardar el ID del usuario actual
            currentRejectUserId = userId;

            // Actualizar la acción del formulario
            if (rejectUserForm) {
                const newAction = `/admin/users/${userId}/reject`;
                console.log('Actualizando acción de rechazo a:', newAction);
                rejectUserForm.action = newAction;
                const rejectHidden = document.getElementById('rejectUserId');
                if (rejectHidden) rejectHidden.value = userId;
            }

            // Habilitar botón de envío
            if (rejectSubmitBtn) {
                rejectSubmitBtn.disabled = !userId || userId === "0";
            }
        });
    }

    // Validación de formularios
    if (approveUserForm) {
        approveUserForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir envío normal del formulario
            
            // Asegurar action correcto si aún es placeholder '#'
            if (this.action.endsWith('#') || this.action.includes('undefined')) {
                const hiddenId = document.getElementById('approveUserId')?.value;
                if (hiddenId) {
                    this.action = `/admin/users/${hiddenId}/approve`;
                }
            }
            // Validar que la acción no sea la URL por defecto o tenga ID inválido
            if (this.action.endsWith('/0/approve') || this.action.endsWith('#') || this.action.includes('undefined')) {
                console.error('URL de acción inválida:', this.action);
                return false;
            }

            // Agregar indicador de carga
            if (approveSubmitBtn) {
                approveSubmitBtn.classList.add('loading');
                approveSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Aprobando...';
                approveSubmitBtn.disabled = true;
            }

            // Intentar envío AJAX primero
            const formData = new FormData(this);
            const currentForm = this;
            
            // Verificar que tenemos el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('Token CSRF no encontrado');
                return false;
            }
            
            console.log('Enviando solicitud de aprobación a:', this.action);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                }
            })
            .then(response => {
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    // Si no es JSON, usar envío tradicional
                    throw new Error('Fallback to traditional form submission');
                }
                
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Forzar cierre completo del modal
                    if (approveModal) {
                        approveModal.style.display = 'none';
                        approveModal.classList.remove('show');
                        approveModal.setAttribute('aria-hidden', 'true');
                        approveModal.removeAttribute('aria-modal');
                    }
                    
                    // Limpiar completamente el DOM
                    const allBackdrops = document.querySelectorAll('.modal-backdrop');
                    allBackdrops.forEach(backdrop => backdrop.remove());
                    
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    
                    // Remover fila de la tabla
                    const userRow = document.querySelector(`tr[data-user-id="${currentApproveUserId}"]`);
                    if (userRow) userRow.remove();
                    // Actualizar contador
                    updatePendingUsersCount();
                    // Recargar para mostrar alerta de servidor (flash)
                    setTimeout(() => window.location.reload(), 150);
                } else {
                    // En caso de error, solo cerrar modal
                    if (approveModal) {
                        approveModal.style.display = 'none';
                        approveModal.classList.remove('show');
                        approveModal.setAttribute('aria-hidden', 'true');
                        approveModal.removeAttribute('aria-modal');
                    }
                    
                    const allBackdrops = document.querySelectorAll('.modal-backdrop');
                    allBackdrops.forEach(backdrop => backdrop.remove());
                    
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }
            })
            .catch(error => {
                console.error('Error AJAX, intentando nuevamente sin redirección:', error);
                
                // Resetear botón
                if (approveSubmitBtn) {
                    approveSubmitBtn.classList.remove('loading');
                    approveSubmitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Aprobar Usuario';
                    approveSubmitBtn.disabled = false;
                }
                
                // Forzar cierre completo del modal primero
                if (approveModal) {
                    approveModal.style.display = 'none';
                    approveModal.classList.remove('show');
                    approveModal.setAttribute('aria-hidden', 'true');
                    approveModal.removeAttribute('aria-modal');
                }
                
                // Limpiar completamente el DOM
                const allBackdrops = document.querySelectorAll('.modal-backdrop');
                allBackdrops.forEach(backdrop => backdrop.remove());
                
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Intentar segundo fetch
                fetch(currentForm.action, {
                    method: 'POST',
                    body: new FormData(currentForm),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    }
                })
                .then(response => {
                    // Aceptar cualquier respuesta como exitosa si el status es 200-300
                    if (response.ok || response.redirected) {
                        // Remover fila de la tabla
                        const userRow = document.querySelector(`tr[data-user-id="${currentApproveUserId}"]`);
                        if (userRow) userRow.remove();
                        // Actualizar contador
                        updatePendingUsersCount();
                        // Recargar para mostrar alerta de servidor (flash)
                        setTimeout(() => window.location.reload(), 150);
                    } else {
                        throw new Error('Request failed');
                    }
                })
                .catch(secondError => {
                    console.error('Segundo intento falló:', secondError);
                    // Solo registrar el error, sin mostrar alertas
                });
            })
            .finally(() => {
                // Resetear botón
                if (approveSubmitBtn) {
                    approveSubmitBtn.classList.remove('loading');
                    approveSubmitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Aprobar Usuario';
                    approveSubmitBtn.disabled = false;
                }
            });
        });
    }

    if (rejectUserForm) {
        rejectUserForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir envío normal del formulario
            
            // Asegurar action correcto si aún es placeholder '#'
            if (this.action.endsWith('#') || this.action.includes('undefined')) {
                const hiddenId = document.getElementById('rejectUserId')?.value;
                if (hiddenId) {
                    this.action = `/admin/users/${hiddenId}/reject`;
                }
            }
            // Validar que la acción no sea la URL por defecto o tenga ID inválido
            if (this.action.endsWith('/0/reject') || this.action.endsWith('#') || this.action.includes('undefined')) {
                console.error('URL de acción inválida:', this.action);
                return false;
            }

            // Agregar indicador de carga
            if (rejectSubmitBtn) {
                rejectSubmitBtn.classList.add('loading');
                rejectSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Rechazando...';
                rejectSubmitBtn.disabled = true;
            }

            // Intentar envío AJAX primero
            const formData = new FormData(this);
            const currentForm = this;
            
            // Verificar que tenemos el token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('Token CSRF no encontrado');
                return false;
            }
            
            console.log('Enviando solicitud de rechazo a:', this.action);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                }
            })
            .then(response => {
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    // Si no es JSON, usar envío tradicional
                    throw new Error('Fallback to traditional form submission');
                }
                
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Forzar cierre completo del modal
                    if (rejectModal) {
                        rejectModal.style.display = 'none';
                        rejectModal.classList.remove('show');
                        rejectModal.setAttribute('aria-hidden', 'true');
                        rejectModal.removeAttribute('aria-modal');
                    }
                    
                    // Limpiar completamente el DOM
                    const allBackdrops = document.querySelectorAll('.modal-backdrop');
                    allBackdrops.forEach(backdrop => backdrop.remove());
                    
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    
                    // Remover fila de la tabla
                    const userRow = document.querySelector(`tr[data-user-id="${currentRejectUserId}"]`);
                    if (userRow) userRow.remove();
                    // Actualizar contador
                    updatePendingUsersCount();
                    // Recargar para mostrar alerta de servidor (flash)
                    setTimeout(() => window.location.reload(), 150);
                } else {
                    // En caso de error, solo cerrar modal
                    if (rejectModal) {
                        rejectModal.style.display = 'none';
                        rejectModal.classList.remove('show');
                        rejectModal.setAttribute('aria-hidden', 'true');
                        rejectModal.removeAttribute('aria-modal');
                    }
                    
                    const allBackdrops = document.querySelectorAll('.modal-backdrop');
                    allBackdrops.forEach(backdrop => backdrop.remove());
                    
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }
            })
            .catch(error => {
                console.error('Error AJAX, intentando nuevamente sin redirección:', error);
                
                // Resetear botón
                if (rejectSubmitBtn) {
                    rejectSubmitBtn.classList.remove('loading');
                    rejectSubmitBtn.innerHTML = '<i class="bi bi-trash3"></i> Rechazar Usuario';
                    rejectSubmitBtn.disabled = false;
                }
                
                // Forzar cierre completo del modal primero
                if (rejectModal) {
                    rejectModal.style.display = 'none';
                    rejectModal.classList.remove('show');
                    rejectModal.setAttribute('aria-hidden', 'true');
                    rejectModal.removeAttribute('aria-modal');
                }
                
                // Limpiar completamente el DOM
                const allBackdrops = document.querySelectorAll('.modal-backdrop');
                allBackdrops.forEach(backdrop => backdrop.remove());
                
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Intentar segundo fetch
                fetch(currentForm.action, {
                    method: 'POST',
                    body: new FormData(currentForm),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    }
                })
                .then(response => {
                    // Aceptar cualquier respuesta como exitosa si el status es 200-300
                    if (response.ok || response.redirected) {
                        // Remover fila de la tabla
                        const userRow = document.querySelector(`tr[data-user-id="${currentRejectUserId}"]`);
                        if (userRow) userRow.remove();
                        // Actualizar contador
                        updatePendingUsersCount();
                        // Recargar para mostrar alerta de servidor (flash)
                        setTimeout(() => window.location.reload(), 150);
                    } else {
                        throw new Error('Request failed');
                    }
                })
                .catch(secondError => {
                    console.error('Segundo intento falló:', secondError);
                    // Solo registrar el error, sin mostrar alertas
                });
            })
            .finally(() => {
                // Resetear botón
                if (rejectSubmitBtn) {
                    rejectSubmitBtn.classList.remove('loading');
                    rejectSubmitBtn.innerHTML = '<i class="bi bi-trash3"></i> Rechazar Usuario';
                    rejectSubmitBtn.disabled = false;
                }
            });
        });
    }

    // Limpiar formularios al cerrar modales
    [approveModal, rejectModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                // Resetear botones de envío
                const submitBtn = modal.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;

                    if (submitBtn.id === 'approveSubmitBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Aprobar Usuario';
                    } else if (submitBtn.id === 'rejectSubmitBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-trash3"></i> Rechazar Usuario';
                    }
                }

                // Limpiar formularios
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        }
    });
    }, 300); // Fin del setTimeout - retraso de 300ms para asegurar que todos los scripts estén cargados
});

// Función para actualizar el contador de usuarios pendientes
function updatePendingUsersCount() {
    const tableBody = document.querySelector('#pendingUsersTable tbody');
    const dataRows = tableBody ? tableBody.querySelectorAll('tr:not(.no-results-message)') : [];
    const count = dataRows.length;
    
    // Actualizar el contador en el header
    const headerSpan = document.querySelector('.card-header span');
    if (headerSpan) {
        headerSpan.textContent = `Usuarios Pendientes (${count})`;
    }
    
    // Si no hay más usuarios, mostrar mensaje de tabla vacía
    if (count === 0 && tableBody) {
        tableBody.innerHTML = `
            <tr class="no-results-message">
                <td colspan="5" class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <h4 class="fw-semibold text-muted mt-3">No hay usuarios pendientes</h4>
                    <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                </td>
            </tr>
        `;
        
        // También actualizar DataTables si está disponible
        if (window.jQuery && $.fn.DataTable && $.fn.DataTable.isDataTable('#pendingUsersTable')) {
            $('#pendingUsersTable').DataTable().clear().draw();
        }
    }
}
</script>
@endsection
