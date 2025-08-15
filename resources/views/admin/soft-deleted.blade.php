@extends('layouts.app')

@section('title', 'Elementos Eliminados - Agile Desk')
    @section('mensaje-superior')
        Elementos Eliminados
    @endsection

@section('styles')
<!-- DataTables Bootstrap 5 CSS - Local -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    
    /* Asegurar que el botón limpiar tenga la misma altura que los inputs */
    .filter-section .btn {
        height: calc(1.5em + 1.6rem + 1px) !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .type-badge {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    .badge-users { background-color: #e3f2fd; color: #0d47a1; }
    .badge-projects { background-color: #f3e5f5; color: #4a148c; }
    .badge-historias { background-color: #e8f5e8; color: #1b5e20; }
    .badge-tareas { background-color: #fff3e0; color: #e65100; }
    .badge-comentarios { background-color: #f0f0f0; color: #2c3e50; }
    
    .actions-cell {
        white-space: nowrap;
    }
    
    .description-cell {
        max-width: 300px;
        word-wrap: break-word;
        white-space: normal;
        cursor: help;
    }
    
    .description-cell:hover {
        background-color: #f8f9fa;
    }
    
    .table-responsive {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }
    
    /* Indicador de carga para filtros automáticos */
    .loading-indicator {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
    }
    
    .filter-loading {
        position: relative;
    }
    
    .filter-loading .loading-indicator {
        display: block;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
    
    /* Z-index para modales - superior al navbar */
    .modal {
        z-index: 1600;
    }
    
    .modal-backdrop {
        z-index: 1599;
    }
    
    /* Estilos para la paginación */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        color: #6c757d;
        border-color: #dee2e6;
    }
    
    .pagination .page-link:hover {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
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

    /* Altura del selector de longitud - más bajo y con bordes redondeados */
    #deletedItemsTable_length .form-select,
    #deletedItemsTable_length select {
        height: 36px !important; /* Más bajo que el original */
        padding: 6px 32px 6px 12px !important; /* Padding derecho mayor para el icono */
        line-height: 1.25;
        border-radius: 8px !important; /* Bordes redondeados */
        border: 1px solid #dee2e6 !important;
        font-size: 0.875rem !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 8px center !important;
        background-size: 12px 12px !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
    }
    
    #deletedItemsTable_length .form-select:focus,
    #deletedItemsTable_length select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
    }
    
    #deletedItemsTable_length label { 
        margin-bottom: 0;
        font-weight: 400 !important;
        font-size: 0.875rem;
        color: #6c757d;
    }

    /* Espaciado inferior de la página */
    .page-bottom-spacing {
        padding-bottom: 4rem;
    }

    /* Contenedor para el selector de longitud */
    .datatable-controls {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    /* Estilos para tooltips de descripción */
    .tooltip-inner {
        max-width: 400px;
        text-align: left;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Filtros -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.soft-deleted') }}" id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Tipo de Elemento</label>
                        <select name="type" id="type" class="form-select auto-filter">
                            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Todos</option>
                            <option value="users" {{ $type === 'users' ? 'selected' : '' }}>Usuarios</option>
                            <option value="projects" {{ $type === 'projects' ? 'selected' : '' }}>Proyectos</option>
                            <option value="historias" {{ $type === 'historias' ? 'selected' : '' }}>Historias</option>
                            <option value="tareas" {{ $type === 'tareas' ? 'selected' : '' }}>Tareas</option>
                            <option value="comentarios" {{ $type === 'comentarios' ? 'selected' : '' }}>Comentarios</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" name="search" id="search" class="form-control auto-filter" 
                               value="{{ $search }}" placeholder="Buscar por nombre...">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Desde</label>
                        <input type="date" name="date_from" id="date_from" class="form-control auto-filter" 
                               value="{{ $dateFrom }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Hasta</label>
                        <input type="date" name="date_to" id="date_to" class="form-control auto-filter" 
                               value="{{ $dateTo }}">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Resultados -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trash"></i>
                        Elementos Eliminados ({{ $deletedItemsPaginated->total() }})
                    </h5>
                    <!-- Selector de longitud de DataTables -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0" style="font-size: 0.875rem; color: #6c757d; white-space: nowrap;">Mostrar:</label>
                        <div id="deletedItemsLengthContainer"></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($deletedItemsPaginated->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="deletedItemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Eliminado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedItemsPaginated as $item)
                                        <tr class="deleted-item-row">
                                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="type-badge badge-{{ $item['type'] }}">
                                                    {{ $item['type_label'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $item['name'] }}</strong>
                                            </td>
                                            <td class="text-muted description-cell" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="{{ $item['full_description'] ?? $item['description'] }}">
                                                {{ Str::limit($item['description'], 80) }}
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $item['deleted_at']->format('d/m/Y H:i') }}
                                                    <br>
                                                    <span class="badge bg-secondary">
                                                        {{ $item['deleted_at']->diffForHumans() }}
                                                    </span>
                                                </small>
                                            </td>
                                            <td class="actions-cell text-center">
                                                <div class="d-flex gap-1 justify-content-center" role="group">
                                                    <!-- Botón Restaurar -->
                                                    <button type="button" class="btn btn-outline-success px-2 py-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreModal"
                                                            data-type="{{ $item['type'] }}"
                                                            data-id="{{ $item['id'] }}"
                                                            data-name="{{ $item['name'] }}"
                                                            title="Restaurar">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                    
                                                    <!-- Botón Eliminar Permanentemente -->
                                                    <button type="button" class="btn btn-outline-danger px-2 py-1" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            data-type="{{ $item['type'] }}"
                                                            data-id="{{ $item['id'] }}"
                                                            data-name="{{ $item['name'] }}"
                                                            title="Eliminar Permanentemente">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Paginación manejada por DataTables --}}
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h4>No hay elementos eliminados</h4>
                            <p class="text-muted">
                                @if($search || $dateFrom || $dateTo || $type !== 'all')
                                    No se encontraron elementos que coincidan con los filtros aplicados.
                                @else
                                    No hay elementos eliminados en el sistema.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Espaciado inferior adicional -->
            <div class="page-bottom-spacing"></div>
        </div>
    </div>
</div>

<!-- Modal de Restauración -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">
                    <i class="bi bi-arrow-clockwise text-success"></i>
                    Confirmar Restauración
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Está seguro de que desea restaurar el siguiente elemento?</p>
                <div class="alert alert-info">
                    <strong id="restoreItemName"></strong>
                    <br>
                    <small class="text-muted">El elemento será restaurado a su estado anterior a la eliminación.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-clockwise me-1"></i> Restaurar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Eliminación Permanente -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p>¿Está seguro de que desea eliminar permanentemente el siguiente elemento?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
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
@stop

@section('scripts')
<!-- jQuery (necesario para DataTables) - Local -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- DataTables JS + integración Bootstrap 5 - Local -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración para DataTables
    if (window.jQuery && $.fn && $.fn.DataTable) {
        // Configuración común de DataTables
        const commonOpts = {
            paging: true,
            searching: false, // deshabilitar búsqueda para evitar que aparezca
            ordering: true,
            info: true,
            lengthChange: true,
            lengthMenu: [ [5, 10, 20, 30], [5, 10, 20, 30] ],
            pageLength: 10,
            pagingType: 'full_numbers',
            language: {
                emptyTable: 'No hay elementos eliminados disponibles',
                zeroRecords: 'No se encontraron resultados',
                lengthMenu: '_MENU_ elementos',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ elementos',
                infoEmpty: 'Mostrando 0 a 0 de 0 elementos',
                infoFiltered: '(filtrado de _MAX_ elementos totales)',
                search: 'Buscar:',
                searchPlaceholder: 'Filtrar elementos...',
                loadingRecords: 'Cargando...',
                processing: 'Procesando...',
                paginate: {
                    first: '«',
                    previous: '‹',
                    next: '›',
                    last: '»'
                }
            },
            dom: 'ltip', // l=length, t=table, i=info, p=pagination (sin filtro)
            initComplete: function () {
                try {
                    const api = this.api();
                    const wrapper = $(api.table().container());
                    const lengthDiv = wrapper.find('div.dataTables_length');
                    const target = document.querySelector('#deletedItemsLengthContainer');
                    
                    if (target && lengthDiv.length) {
                        lengthDiv.addClass('mb-0');
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
            },
            columnDefs: [
                { orderable: false, targets: [5] }, // Deshabilitar ordenamiento en columna de acciones
                { className: 'text-center', targets: [0, 5] } // Centrar columnas específicas
            ]
        };

        // Inicializar DataTable para elementos eliminados
        const deletedTable = $('#deletedItemsTable');
        if (deletedTable.length) {
            try {
                const dt = deletedTable.DataTable(commonOpts);
            } catch (e) {
                console.error('Error inicializando DataTable para elementos eliminados:', e);
            }
        }
    } else {
        console.error('DataTables no está disponible.');
    }

    // Funcionalidad de filtros del formulario (mantener la funcionalidad existente)
    let filterTimeout;
    const filterForm = document.getElementById('filterForm');
    const autoFilterElements = document.querySelectorAll('.auto-filter');
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            html: true,
            trigger: 'hover focus'
        });
    });
    
    // Función para aplicar filtros automáticamente
    function applyFilters() {
        document.body.style.cursor = 'wait';
        filterForm.submit();
    }
    
    // Función debounce para evitar muchas peticiones
    function debounceFilter() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(applyFilters, 500);
    }
    
    // Agregar event listeners a todos los elementos de filtro
    autoFilterElements.forEach(element => {
        if (element.type === 'text') {
            element.addEventListener('input', debounceFilter);
        } else {
            element.addEventListener('change', applyFilters);
        }
    });
    
    // Modal de restauración
    const restoreModal = document.getElementById('restoreModal');
    if (restoreModal) {
        restoreModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const type = button.getAttribute('data-type');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            
            const modalItemName = restoreModal.querySelector('#restoreItemName');
            const modalForm = restoreModal.querySelector('#restoreForm');
            
            modalItemName.textContent = name;
            modalForm.action = `/admin/soft-deleted/restore/${type}/${id}`;
        });
    }
    
    // Modal de eliminación permanente
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const type = button.getAttribute('data-type');
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            
            const modalItemName = deleteModal.querySelector('#deleteItemName');
            const modalForm = deleteModal.querySelector('#deleteForm');
            
            if (modalItemName) modalItemName.textContent = name;
            modalForm.action = `/admin/soft-deleted/permanent-delete/${type}/${id}`;
        });
    }
});
</script>
@stop
