@extends('layouts.app')

@section('title', 'Usuarios del Sistema - Agile Desk')
    @section('mensaje-superior')
        Usuarios del Sistema
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
    .input-group .form-control {
            border-radius: 0.25rem 0 0 0.25rem;
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
    /* Centrar solo el texto de los números de paginación */
    justify-content: center;
    width: 100%;
    text-align: center;
    }
    .card-header .dataTables_length select {
    text-align: left !important;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
        border: 2px solid #ced4da !important;
        border-radius: 0.375rem !important;
        background-color: #fff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        transition: all 0.15s ease-in-out !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.75rem center !important;
        background-size: 16px 12px !important;
    }
    
    .card-header .dataTables_length select:focus {
        border-color: #4a90e2 !important;
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25) !important;
        outline: none !important;
    }
    
    .card-header .dataTables_length select:hover {
        border-color: #4a90e2 !important;
    }

    /* Estilos para el select de roles */
    .role-select {
        border-radius: 6px !important;
        border: 2px solid #ced4da !important;
        background-color: #fff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        transition: all 0.15s ease-in-out !important;
        font-size: 0.875rem !important;
        padding: 0.25rem 1.5rem 0.25rem 0.5rem !important;
        display: block;
        margin: 0 auto;
        min-width: 140px;
        max-width: 180px;
        text-align: center;
    }
    
    .role-select:focus {
        border-color: #4a90e2 !important;
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25) !important;
        outline: none !important;
    }
    
    .role-select:hover {
        border-color: #4a90e2 !important;
    }

    /* Animación para el ícono de éxito */
    @keyframes fadeInOut {
        0% { opacity: 0; transform: translateY(-50%) scale(0.5); }
        20% { opacity: 1; transform: translateY(-50%) scale(1.1); }
        25% { opacity: 1; transform: translateY(-50%) scale(1); }
        85% { opacity: 1; transform: translateY(-50%) scale(1); }
        100% { opacity: 0; transform: translateY(-50%) scale(0.8); }
    }

    /* Estilos para el modal de confirmación */
    .modal-content {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header.bg-warning {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
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

    /* Nuevos estilos para los badges de roles usando clases Bootstrap */
    .bg-danger {
        background-color: #dc3545 !important;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
    }
    
    .bg-primary {
        background-color: #0d6efd !important;
    }
    
    .text-dark {
        color: #212529 !important;
    }
    
    .text-white {
        color: #ffffff !important;
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
<!-- Contenedor de alertas globales -->
<div id="global-alerts-container" class="container-fluid px-3 mt-2" style="max-width: 100%;"></div>
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
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-warning px-2 py-2">
                            <i class="bi bi-archive me-1"></i> Eliminados
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
                                        <th class="text-center">Acciones</th>
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
                                                    // Si el usuario está pendiente (no aprobado ni rechazado), mostrar "En proceso"
                                                    if (!$user->is_approved && !$user->is_rejected && $user->usertype !== 'superadmin' && $user->usertype !== 'admin') {
                                                        $roleData = ['label' => 'En proceso', 'class' => 'bg-info text-white'];
                                                    } else {
                                                        $roleData = match($user->usertype) {
                                                            'superadmin' => ['label' => 'Superadministrador', 'class' => 'bg-danger text-white'],
                                                            'admin' => ['label' => 'Administrador', 'class' => 'bg-warning text-dark'],
                                                            'collaborator' => ['label' => 'Colaborador', 'class' => 'bg-primary text-white'],
                                                            default => ['label' => 'Usuario', 'class' => 'bg-secondary text-white']
                                                        };
                                                    }
                                                @endphp

                                                @if(Auth::user()->isSuperAdmin() && Auth::user()->id !== $user->id && $user->is_approved)
                                                    {{-- Select para cambiar rol - Solo para superadmin editando a otro usuario aprobado --}}
                                                    <select class="form-select form-select-sm role-select" 
                                                            data-user-id="{{ $user->id }}" 
                                                            data-current-role="{{ $user->usertype }}"
                                                            style="width: auto; min-width: 140px;">
                                                        <option value="collaborator" {{ $user->usertype === 'collaborator' ? 'selected' : '' }}>
                                                            Colaborador
                                                        </option>
                                                        <option value="admin" {{ $user->usertype === 'admin' ? 'selected' : '' }}>
                                                            Administrador
                                                        </option>
                                                        <option value="superadmin" {{ $user->usertype === 'superadmin' ? 'selected' : '' }}>
                                                            Superadministrador
                                                        </option>
                                                    </select>
                                                @else
                                                    {{-- Badge normal para otros casos --}}
                                                    <span class="badge {{ $roleData['class'] }}">{{ $roleData['label'] }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user->usertype === 'superadmin')
                                                    <span class="status-approved">
                                                        <i class="bi bi-shield-fill me-1"></i> Superadmin
                                                    </span>
                                                @elseif($user->usertype === 'admin')
                                                    <span class="status-approved">
                                                        <i class="bi bi-shield-check me-1"></i> Activo
                                                    </span>
                                                @else
                                                    @if($user->is_approved)
                                                        <span class="status-approved">
                                                            <i class="bi bi-check-circle me-1"></i> Aprobado
                                                        </span>
                                                    @elseif($user->is_rejected)
                                                        <span class="status-rejected">
                                                            <i class="bi bi-x-circle me-1"></i> Rechazado
                                                        </span>
                                                    @else
                                                        <span class="status-pending">
                                                            <i class="bi bi-clock"></i> Pendiente
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $isCurrentUser = Auth::user()->id === $user->id;
                                                    $currentUserRole = Auth::user()->usertype;
                                                    $canManageUser = false;
                                                    
                                                    // Lógica de permisos basada en roles
                                                    if ($currentUserRole === 'superadmin' && !$isCurrentUser) {
                                                        $canManageUser = true;
                                                    } elseif ($currentUserRole === 'admin' && $user->usertype === 'collaborator' && !$user->is_approved) {
                                                        $canManageUser = true;
                                                    }
                                                @endphp
                                                
                                                @if($canManageUser)
                                                    <div class="d-flex gap-1 justify-content-center" role="group">
                                                        @if(!$user->is_approved && !$user->is_rejected)
                                                            {{-- Botones de Aprobar y Rechazar para usuarios pendientes --}}
                                                            <button type="button" class="btn btn-outline-success btn-sm px-2 py-1"
                                                                    data-bs-toggle="modal" data-bs-target="#approveModal"
                                                                    data-user-id="{{ $user->id }}"
                                                                    data-user-name="{{ $user->name }}"
                                                                    data-user-email="{{ $user->email }}"
                                                                    title="Aprobar Usuario">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm px-2 py-1"
                                                                    data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                                    data-user-id="{{ $user->id }}"
                                                                    data-user-name="{{ $user->name }}"
                                                                    title="Rechazar Usuario">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        @else
                                                            {{-- Botón de Eliminar para usuarios aprobados o rechazados --}}
                                                            <button type="button" class="btn btn-outline-danger btn-sm px-2 py-1"
                                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                    data-user-id="{{ $user->id }}"
                                                                    data-user-name="{{ $user->name }}"
                                                                    data-user-email="{{ $user->email }}"
                                                                    data-user-type="{{ $user->usertype }}"
                                                                    title="Eliminar Usuario">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @else
                                                    {{-- Sin acciones disponibles --}}
                                                    <span class="text-muted">
                                                        <i class="bi bi-dash"></i>
                                                    </span>
                                                @endif
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
    // Inicializar DataTable con select de paginación generado por DataTables
    const usersTable = $('#usersTable').DataTable({
        paging: true,
        searching: true, // habilitamos búsqueda para el buscador personalizado
        ordering: false,
        info: true,
        lengthChange: true,
        lengthMenu: [ [5, 10, 20, 30], [5, 10, 20, 30] ],
        pageLength: 10,
        pagingType: 'full_numbers',
        columnDefs: [
            { orderable: false, targets: [5] }, // Desactivar ordenamiento en columna Acciones (nuevo índice 5)
            { className: 'text-center', targets: [0, 3, 4, 5] } // Centrar columnas numéricas y de acciones
        ],
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
        dom: 'ltip', // l=length, t=table, i=info, p=pagination
        initComplete: function () {
            try {
                const api = this.api();
                const wrapper = $(api.table().container());
                const lengthDiv = wrapper.find('div.dataTables_length');
                const target = document.getElementById('usersLengthContainer');
                if (target && lengthDiv.length) {
                    lengthDiv.addClass('mb-0');
                    lengthDiv.find('label').addClass('mb-0 d-flex align-items-center gap-2');
                    lengthDiv.find('select')
                        .addClass('form-select form-select-sm rounded')
                        .css({ width: 'auto', height: '35px' });
                    target.innerHTML = '';
                    target.appendChild(lengthDiv.get(0));
                }
            } catch (err) {
                console.warn('No se pudo mover el selector de longitud:', err);
            }
        }
    });

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

    // Conectar buscador personalizado optimizado
    const searchInput = document.getElementById('usersSearchInput');
    const searchButton = document.getElementById('btnSearchUsers');

    if (searchInput && searchButton) {
        // Función optimizada para normalizar texto
        function normalizarTexto(texto) {
            if (!texto) return '';
            return texto
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remover acentos
                .trim();
        }

        // Función para realizar búsqueda optimizada
        function performSearch() {
            const textoBusqueda = normalizarTexto(searchInput.value);
            
            if (textoBusqueda === '') {
                usersTable.search('').draw();
                return;
            }
            
            // Búsqueda simple y rápida - usar smart search de DataTables
            usersTable.search(textoBusqueda, false, true).draw(); // regex: false, smart: true
        }

        // Búsqueda en tiempo real con delay reducido
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 100); // Reducido a 100ms
        });

        // Búsqueda al hacer clic en el botón
        searchButton.addEventListener('click', performSearch);

        // Búsqueda al presionar Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout); // Cancelar delay
                performSearch(); // Buscar inmediatamente
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
    // Variables globales para el modal de cambio de rol
    let pendingRoleChange = null;
    let isProcessingRoleChange = false;
    
    // Inicializar el modal una vez
    const roleChangeModal = document.getElementById('roleChangeModal');
    const confirmRoleChangeBtn = document.getElementById('confirmRoleChange');
    
    // Manejar cambios de rol
    document.addEventListener('change', function(e) {
        if (!e.target.classList.contains('role-select') || isProcessingRoleChange) {
            return; // Ignorar si no es el select correcto o si ya hay un proceso en curso
        }
        
        const select = e.target;
        const userId = select.dataset.userId;
        const currentRole = select.dataset.currentRole;
        const newRole = select.value;
        
        if (newRole === currentRole) {
            return; // No hay cambio
        }
        
        // Obtener nombre del usuario de la tabla
        const userRow = select.closest('tr');
        const userName = userRow.querySelector('td:first-child').textContent.trim();
        
        // Configurar el modal
        const roleNames = {
            'collaborator': 'Colaborador',
            'admin': 'Administrador',
            'superadmin': 'Superadministrador'
        };
        
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('modalNewRole').textContent = roleNames[newRole];
        
        // Guardar datos para usar en la confirmación
        pendingRoleChange = {
            userId: userId,
            newRole: newRole,
            selectElement: select,
            currentRole: currentRole
        };
        
        // Revertir temporalmente el select hasta que se confirme
        select.value = currentRole;
        
        // Mostrar el modal
        const modal = new bootstrap.Modal(roleChangeModal);
        modal.show();
    });
    
    // Manejar confirmación del modal (remover listeners previos)
    confirmRoleChangeBtn.replaceWith(confirmRoleChangeBtn.cloneNode(true));
    const newConfirmBtn = document.getElementById('confirmRoleChange');
    
    newConfirmBtn.addEventListener('click', function() {
        if (pendingRoleChange && !isProcessingRoleChange) {
            isProcessingRoleChange = true;
            
            // Deshabilitar botón de confirmación
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
            
            // Actualizar el select al nuevo valor
            pendingRoleChange.selectElement.value = pendingRoleChange.newRole;
            
            // Realizar el cambio
            updateUserRole(
                pendingRoleChange.userId, 
                pendingRoleChange.newRole, 
                pendingRoleChange.selectElement
            ).finally(() => {
                // Cerrar modal y limpiar estado
                const modal = bootstrap.Modal.getInstance(roleChangeModal);
                if (modal) {
                    modal.hide();
                }
                resetModalState();
            });
        }
    });
    
    // Manejar cancelación del modal
    roleChangeModal.addEventListener('hidden.bs.modal', function() {
        if (pendingRoleChange && !isProcessingRoleChange) {
            // Asegurar que el select vuelva al valor original
            pendingRoleChange.selectElement.value = pendingRoleChange.currentRole;
        }
        resetModalState();
    });
    
    // Función para resetear el estado del modal
    function resetModalState() {
        pendingRoleChange = null;
        isProcessingRoleChange = false;
        
        // Resetear botón de confirmación
        const confirmBtn = document.getElementById('confirmRoleChange');
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Confirmar Cambio';
    }
    
    // Función para actualizar el rol del usuario (ahora retorna una Promise)
    function updateUserRole(userId, newRole, selectElement) {
        // Deshabilitar el select mientras se procesa
        selectElement.disabled = true;
        
        // Obtener token CSRF fresco
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            console.error('CSRF token no encontrado');
            showNotification('Error: Token de seguridad no encontrado. Recarga la página.', 'error');
            selectElement.disabled = false;
            return Promise.reject('CSRF token not found');
        }
        
        return fetch(`/superadmin/users/${userId}/role`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                role: newRole
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Actualizar el dataset del select
                selectElement.dataset.currentRole = newRole;
                // Mostrar mensaje de éxito con información de permisos
                const roleNames = {
                    'collaborator': 'Colaborador',
                    'admin': 'Administrador', 
                    'superadmin': 'Superadministrador'
                };
                // Agregar ícono de éxito temporal al select
                showSuccessIcon(selectElement);
                showNotification(`Rol actualizado a "${roleNames[newRole]}" y permisos sincronizados automáticamente`, 'success');
                return data;
            } else {
                // Mostrar mensaje de error devuelto por el backend
                selectElement.value = selectElement.dataset.currentRole;
                showNotification(data.message || 'Error al actualizar el rol', 'error');
                // NO recargar la tabla si hay error
                throw new Error(data.message || 'Error al actualizar el rol');
            }
        })
        .catch(error => {
            // Manejo de error de red o validación
            selectElement.value = selectElement.dataset.currentRole;
            showNotification(error.message || 'Error de conexión al actualizar el rol', 'error');
            // NO recargar la tabla si hay error
        })
        .finally(() => {
            // Rehabilitar el select
            selectElement.disabled = false;
        });
    }
    
    // Función para mostrar ícono de éxito temporal (mejorada)
    function showSuccessIcon(selectElement) {
        // Remover ícono existente si hay uno
        const existingIcon = selectElement.parentElement.querySelector('.success-icon');
        if (existingIcon) {
            existingIcon.remove();
        }
        
        // Crear ícono de éxito
        const successIcon = document.createElement('i');
        successIcon.className = 'bi bi-check-circle-fill text-success position-absolute success-icon';
        successIcon.style.cssText = `
            right: 25px; 
            top: 50%; 
            transform: translateY(-50%); 
            font-size: 16px; 
            z-index: 10;
            pointer-events: none;
            animation: fadeInOut 3s ease-in-out;
        `;
        
        // Posicionar el contenedor del select como relativo
        const container = selectElement.parentElement;
        const currentPosition = getComputedStyle(container).position;
        if (currentPosition === 'static') {
            container.style.position = 'relative';
        }
        
        // Agregar el ícono
        container.appendChild(successIcon);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            if (successIcon.parentNode) {
                successIcon.remove();
            }
        }, 3000);
    }
    
    // Función auxiliar para mostrar notificaciones
    function showNotification(message, type) {
        // Crear un alert temporal en el contenedor global
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="bi ${iconClass} me-2"></i>${message}
        `;

        // Insertar en el contenedor global de alertas al inicio
        const alertsContainer = document.getElementById('global-alerts-container');
        if (alertsContainer) {
            alertsContainer.insertBefore(alertDiv, alertsContainer.firstChild);
        } else {
            document.body.appendChild(alertDiv);
        }

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // ==========================================
    // GESTIÓN DE MODALES PARA ACCIONES DE USUARIOS
    // ==========================================
    
    // Función para limpiar completamente los modales
    function cleanupModals() {
        // Remover todos los backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
        
        // Restaurar el estado del body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Cerrar todos los modales que puedan estar abiertos
        document.querySelectorAll('.modal.show').forEach(modal => {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }
    
    // Modal de Aprobación
    document.querySelectorAll('[data-bs-target="#approveModal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            const userEmail = this.getAttribute('data-user-email');
            
            document.getElementById('approveUserId').value = userId;
            document.getElementById('approveUserInfo').textContent = `${userName} (${userEmail})`;
            document.getElementById('approveUserForm').action = `{{ url('/') }}/admin/users/${userId}/approve`;
        });
    });

    // Modal de Rechazo
    document.querySelectorAll('[data-bs-target="#rejectModal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.getAttribute('data-user-name');
            
            document.getElementById('rejectUserId').value = userId;
            document.getElementById('rejectUserInfo').textContent = userName;
            document.getElementById('rejectUserForm').action = `{{ url('/') }}/admin/users/${userId}/reject`;
        });
    });

    // Modal de Eliminación (unificado y simplificado)
    const BASE_URL = `{{ url('/') }}`;
    document.addEventListener('click', function(e){
        const trigger = e.target.closest('[data-bs-target="#deleteModal"]');
        if(!trigger) return;
        const userId = trigger.getAttribute('data-user-id');
        const userName = trigger.getAttribute('data-user-name');
        const userEmail = trigger.getAttribute('data-user-email');
        const userType = trigger.getAttribute('data-user-type') || 'user';
        // Llenar campos visibles
        const infoEl = document.getElementById('deleteUserInfo');
        if(infoEl) infoEl.textContent = `${userName} (${userEmail})`;
        // Etiqueta tipo
        const typeLabel = document.getElementById('deleteUserTypeLabel');
        if(typeLabel) typeLabel.textContent = (userType === 'admin' ? 'administrador' : 'usuario');
        // Aviso extra admin
        const adminNotice = document.getElementById('adminExtraNotice');
        if(adminNotice){
            adminNotice.classList.toggle('d-none', userType !== 'admin');
        }
        // Form
        const form = document.getElementById('deleteUserForm');
        if(form){
            form.dataset.userId = userId;
            form.dataset.userRole = userType;
            form.action = `${BASE_URL}/admin/users/${userId}/delete`;
            console.log('Acción DELETE (users.blade):', form.action);
        }
    });

    // Manejo de envío de formularios con feedback
    const handleFormSubmit = (formId, successMessage, errorMessage) => {
        const form = document.getElementById(formId);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Cambiar estado del botón
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise spin me-1"></i> Procesando...';
            
            // Crear FormData
            const formData = new FormData(form);
            
            // Enviar solicitud AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(successMessage, 'success');
                    
                    // Limpiar modales completamente
                    cleanupModals();
                    
                    // Recargar página después de un breve delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showNotification(data.message || errorMessage, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(errorMessage, 'danger');
                
                // Limpiar modales en caso de error también
                cleanupModals();
            })
            .finally(() => {
                // Restaurar botón
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    };

    // Configurar manejo de formularios
    handleFormSubmit('approveUserForm', 'Usuario aprobado exitosamente', 'Error al aprobar el usuario');
    handleFormSubmit('rejectUserForm', 'Usuario rechazado exitosamente', 'Error al rechazar el usuario');
    // Eliminación: dejar envío tradicional del formulario (sin fetch) para evitar problemas de parsing JSON.

    // Limpiar backdrop cuando se cierran los modales manualmente
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function () {
            // Limpiar cualquier backdrop que pueda quedar
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            
            // Restaurar scroll del body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });

    // Listener global para limpiar modales con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            setTimeout(cleanupModals, 100);
        }
    });

    // Listener para clicks en backdrop
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            setTimeout(cleanupModals, 100);
        }
    });

    // Reinicializar event listeners después de DataTables draw
    $('#usersTable').on('draw.dt', function() {
        // Reinicializar botones de modales
        document.querySelectorAll('[data-bs-target="#approveModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                const userEmail = this.getAttribute('data-user-email');
                
                document.getElementById('approveUserId').value = userId;
                document.getElementById('approveUserInfo').textContent = `${userName} (${userEmail})`;
                document.getElementById('approveUserForm').action = `{{ url('/') }}/admin/users/${userId}/approve`;
            });
        });

        document.querySelectorAll('[data-bs-target="#rejectModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                
                document.getElementById('rejectUserId').value = userId;
                document.getElementById('rejectUserInfo').textContent = userName;
                document.getElementById('rejectUserForm').action = `{{ url('/') }}/admin/users/${userId}/reject`;
            });
        });

        document.querySelectorAll('[data-bs-target="#deleteModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                const userEmail = this.getAttribute('data-user-email');
                const userType = this.getAttribute('data-user-type');
                
                document.getElementById('deleteUserId').value = userId;
                document.getElementById('deleteUserInfo').textContent = `${userName} (${userEmail})`;
                // Mantener ruta unificada de soft delete siempre
                document.getElementById('deleteUserForm').action = `{{ url('/') }}/admin/users/${userId}/delete`;
            });
        });
    });
});
</script>

{{-- Agregar estilos para la animación de carga --}}
<style>
    .spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<!-- Modal de Confirmación de Cambio de Rol -->
<div class="modal fade" id="roleChangeModal" tabindex="-1" aria-labelledby="roleChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleChangeModalLabel">
                    <i class="bi bi-person-gear text-warning"></i>
                    Confirmar Cambio de Rol
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción modificará los permisos del usuario.
                </div>
                <p>¿Está seguro de que desea cambiar el rol de <strong id="modalUserName"></strong> a <strong id="modalNewRole"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="confirmRoleChange">
                    <i class="bi bi-check-circle me-1"></i> Confirmar Cambio
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Aprobación --}}
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
                <div class="modal-body text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>¿Confirmar aprobación?</strong>
                    </div>
                    <p>El usuario <strong id="approveUserInfo"></strong> será aprobado en el sistema.</p>
                    
                    @if(Auth::user()->isSuperAdmin())
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Asignar Rol:</label>
                            <select class="form-select" id="userRole" name="role" required>
                                <option value="">Seleccionar rol...</option>
                                <option value="collaborator">Colaborador</option>
                                <option value="admin">Administrador</option>
                                <option value="superadmin">Superadministrador</option>
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="role" value="collaborator">
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="approveSubmitBtn" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Aprobar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de Rechazo --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="bi bi-x-circle text-danger"></i>
                    Rechazar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="rejectUserForm" action="#">
                @csrf
                @method('POST')
                <input type="hidden" name="user_id" id="rejectUserId" value="">
                <div class="modal-body text-center">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                    </div>
                    <p>¿Está seguro de que desea rechazar a <strong id="rejectUserInfo"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="rejectSubmitBtn" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i> Rechazar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal de Eliminación --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-trash3 text-danger"></i>
                    Eliminar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="deleteUserForm" action="#">
                @csrf
                @method('DELETE')
                <input type="hidden" name="user_id" id="deleteUserId" value="">
                <div class="modal-body text-center">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                    </div>
                    <p>¿Está seguro de que desea eliminar permanentemente <span id="deleteUserTypeLabel">al usuario</span> <strong id="deleteUserInfo" class="text-danger"></strong>?</p>
                    <div id="adminExtraNotice" class="mt-2 small text-warning d-none">
                        <i class="bi bi-info-circle"></i> Los proyectos del administrador NO se eliminarán.
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="deleteSubmitBtn" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop