@extends('layouts.app')

@section('title', 'Historial del Sistema - Agile Desk')

@section('styles')
<!-- DataTables CSS Local -->
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
    }
    
    .stat-item {
        padding: 0.5rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .details-cell {
        max-width: 300px;
        word-wrap: break-word;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .badge {
        font-weight: 500;
    }
    
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .btn {
        border-radius: 6px;
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
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .stat-number {
            font-size: 1.25rem;
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
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }
    .card-header .dataTables_length select {
        height: 35px !important;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
        border: 2px solid #ced4da !important;
        border-radius: 0.375rem !important;
        background-color: #fff !important;
        font-size: 0.875rem !important;
        line-height: 1.5 !important;
        margin-left: 0.5rem !important;
        text-align: center !important;
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

    /* Estilos mejorados para la columna de detalles */
    .details-cell {
        max-width: 500px !important;
        word-wrap: break-word;
        word-break: break-word;
        line-height: 1.4;
        white-space: normal;
    }

    /* Espaciado inferior */
    .page-bottom-spacing {
        padding-bottom: 4rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Alertas de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <!-- Header con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-history me-2"></i>Historial Completo del Sistema
                            </h4>
                            <small class="opacity-75">Control total de cambios en AgileDesk</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark fs-6">
                                <i class="fas fa-shield-alt me-1"></i>Solo Superadministradores
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Estadísticas rápidas -->
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-primary">{{ number_format($stats['total_cambios']) }}</div>
                                <div class="stat-label">Total de Cambios</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-success">{{ number_format($stats['cambios_hoy']) }}</div>
                                <div class="stat-label">Cambios Hoy</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-info">{{ number_format($stats['cambios_semana']) }}</div>
                                <div class="stat-label">Esta Semana</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number text-warning">{{ number_format($stats['usuarios_activos']) }}</div>
                                <div class="stat-label">Usuarios Activos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <!-- Tabla de historial -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <span>Historial de Cambios ({{ $historial->count() }})</span>
                                        <div id="historialLengthContainer" class="d-flex align-items-center"></div>
                                        <!-- Buscador para historial -->
                                        <div class="input-group" style="width: 300px;">
                                            <input type="text" class="form-control form-control-sm" id="historialSearchInput" placeholder="Buscar en historial..." style="height: 35px;"maxlength="50"
                                                   pattern="[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s]+"
                                                   title="Solo se permiten letras, números y espacios">
                                            <button class="btn btn-outline-secondary" type="button" id="btnSearchHistorial">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    @if($historial->isEmpty())
                                        <div class="text-center py-5">
                                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No hay cambios registrados</h5>
                                            <p class="text-muted">No se encontraron registros en el sistema.</p>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" id="historialTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="border-0"><i class="fas fa-calendar-alt me-2"></i>Fecha y Hora</th>
                                                        <th class="border-0"><i class="fas fa-user me-2"></i>Usuario</th>
                                                        <th class="border-0"><i class="fas fa-bolt me-2"></i>Acción</th>
                                                        <th class="border-0"><i class="fas fa-info-circle me-2"></i>Detalles</th>
                                                        <th class="border-0"><i class="fas fa-project-diagram me-2"></i>Proyecto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($historial as $cambio)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class="d-flex flex-column">
                                                                    <span class="fw-medium">
                                                                        {{ $cambio->created_at->format('d/m/Y') }}
                                                                    </span>
                                                                    <small class="text-muted">
                                                                        {{ $cambio->created_at->format('H:i:s') }}
                                                                    </small>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                        {{ strtoupper(substr($cambio->usuario, 0, 1)) }}
                                                                    </div>
                                                                    <span>{{ $cambio->usuario }}</span>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                @php
                                                                    $badgeClass = match(strtolower($cambio->accion)) {
                                                                        'creación', 'crear', 'registro' => 'success',
                                                                        'actualización', 'edición', 'modificación', 'actualizar', 'editar' => 'warning',
                                                                        'eliminación', 'eliminar', 'borrar' => 'danger',
                                                                        'aprobación', 'aprobar', 'aprobación de usuario' => 'info',
                                                                        'rechazo', 'rechazar', 'rechazo de usuario' => 'secondary',
                                                                        'cambio de rol' => 'primary',
                                                                        'limpieza de historial' => 'dark',
                                                                        default => 'primary'
                                                                    };
                                                                @endphp
                                                                <span class="badge bg-{{ $badgeClass }} px-2 py-1">
                                                                    {{ ucfirst($cambio->accion) }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="details-cell">
                                                                    {{ Str::limit($cambio->detalles, 150) }}
                                                                    @if(strlen($cambio->detalles) > 150)
                                                                        <button class="btn btn-sm btn-link p-0 ms-1" 
                                                                                type="button" 
                                                                                data-bs-toggle="tooltip" 
                                                                                title="{{ $cambio->detalles }}">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                @if($cambio->proyecto)
                                                                    <span class="badge bg-light text-dark border">
                                                                        {{ $cambio->proyecto->name }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-muted">Sistema</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Navegación -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('homeadmin') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
                                </a>
                                <div class="text-muted">
                                    <small>
                                        <i class="fas fa-clock me-1"></i>
                                        Última actualización: {{ now()->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Espaciado inferior adicional -->
                            <div class="page-bottom-spacing"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
    }
    
    .stat-item {
        padding: 0.5rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .details-cell {
        max-width: 300px;
        word-wrap: break-word;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .badge {
        font-weight: 500;
    }
    
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .btn {
        border-radius: 6px;
    }
    
    /* Estilos para DataTables */
    .dataTables_length {
        margin: 0;
    }
    
    .dataTables_length select {
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
        border: 2px solid #ced4da;
        border-radius: 0.375rem;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.15s ease-in-out;
        text-align: center;
    }
    
    .dataTables_length select:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        outline: none;
    }
    
    .dataTables_length select:hover {
        border-color: #4a90e2;
    }
    
    .dataTables_info {
        padding-top: 0.75rem;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .dataTables_paginate {
        padding-top: 0.5rem;
    }
    
    .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 0.125rem;
        color: #007bff;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .dataTables_paginate .paginate_button:hover {
        color: #0056b3;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    .dataTables_paginate .paginate_button.current {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .dataTables_paginate .paginate_button.disabled {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
        cursor: not-allowed;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .dataTables_length,
        .dataTables_info,
        .dataTables_paginate {
            text-align: center;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<!-- jQuery y DataTables JS Locales -->
<script src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Configuración de DataTables
        var table = $('#historialTable').DataTable({
            "language": {
                "lengthMenu": "_MENU_",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 10,
            "lengthMenu": [[5, 10, 20, 30], [5, 10, 20, 30]],
            "order": [[0, "desc"]], // Ordenar por fecha descendente
            "searching": true,
            "paging": true,
            "info": true,
            "lengthChange": true,
            "columnDefs": [
                {
                    "targets": [0], // Columna de fecha
                    "type": "date"
                },
                {
                    "targets": [2], // Columna de acción (badges)
                    "orderable": true
                }
            ],
            "initComplete": function(settings, json) {
                // Mover el selector de length al contenedor personalizado
                $('#historialLengthContainer').append($('.dataTables_length'));
                
                // Ocultar el buscador original de DataTables
                $('.dataTables_filter').hide();
                
                // Inicializar tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            "drawCallback": function(settings) {
                // Reinicializar tooltips después de cada redibujado
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
        
        // Función optimizada para normalizar texto
        function normalizarTexto(texto) {
            if (!texto) return '';
            return texto
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') 
                .trim();
        }
        
        // Función para búsqueda optimizada
        function realizarBusquedaMejorada(input) {
            const textoBusqueda = normalizarTexto(input.value || input);
            
            if (textoBusqueda === '') {
                table.search('').draw();
                return;
            }
            
            // Búsqueda simple y rápida - usar smart search de DataTables
            table.search(textoBusqueda, false, true).draw(); 
        }
        
        // Conectar el buscador personalizado optimizado con delay reducido
        let searchTimeout;
        $('#historialSearchInput').on('keyup search input', function() {
            clearTimeout(searchTimeout);
            const inputValue = this.value;
            searchTimeout = setTimeout(() => {
                realizarBusquedaMejorada(inputValue);
            }, 100); 
        });

        $('#btnSearchHistorial').on('click', function() {
            var searchTerm = $('#historialSearchInput').val();
            realizarBusquedaMejorada(searchTerm);
        });

        // Permitir búsqueda con Enter (inmediata)
        $('#historialSearchInput').on('keypress', function(e) {
            if (e.which === 13) {
                clearTimeout(searchTimeout);
                realizarBusquedaMejorada(this.value);
            }
        });

        // Inicializar tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Auto-actualizar página cada 5 minutos (solo si no hay modales abiertos)
        setInterval(function() {
            if (!$('.modal.show').length) {
                location.reload();
            }
        }, 300000);
    });
</script>
<script>
document.getElementById("historialSearchInput").addEventListener("input", function () {
    const allowed = /^[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s]*$/;
    
    if (!allowed.test(this.value)) {
        this.value = this.value.replace(/[^A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s]/g, "");
    }
});
</script>

@endsection
