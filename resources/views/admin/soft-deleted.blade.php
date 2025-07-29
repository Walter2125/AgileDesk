@extends('layouts.app')

@section('title', 'Elementos Eliminados - Agile Desk')

@section('styles')
<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
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
    
    .actions-cell {
        white-space: nowrap;
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
</style>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Elementos Eliminados</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('homeadmin') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Elementos Eliminados</li>
                    </ol>
                </nav>
            </div>

            <!-- Filtros -->
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.soft-deleted') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Tipo de Elemento</label>
                        <select name="type" id="type" class="form-select">
                            <option value="all" {{ $type === 'all' ? 'selected' : '' }}>Todos</option>
                            <option value="users" {{ $type === 'users' ? 'selected' : '' }}>Usuarios</option>
                            <option value="projects" {{ $type === 'projects' ? 'selected' : '' }}>Proyectos</option>
                            <option value="historias" {{ $type === 'historias' ? 'selected' : '' }}>Historias</option>
                            <option value="tareas" {{ $type === 'tareas' ? 'selected' : '' }}>Tareas</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               value="{{ $search }}" placeholder="Buscar por nombre...">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">Desde</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" 
                               value="{{ $dateFrom }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">Hasta</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" 
                               value="{{ $dateTo }}">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="{{ route('admin.soft-deleted') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Resultados -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-trash-restore"></i>
                        Elementos Eliminados ({{ $deletedItems->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($deletedItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Eliminado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deletedItems as $item)
                                        <tr>
                                            <td>
                                                <span class="type-badge badge-{{ $item['type'] }}">
                                                    {{ $item['type_label'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $item['name'] }}</strong>
                                            </td>
                                            <td class="text-muted">
                                                {{ Str::limit($item['description'], 50) }}
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
                                                <div class="btn-group" role="group">
                                                    <!-- Botón Restaurar -->
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreModal"
                                                            data-type="{{ $item['type'] }}"
                                                            data-id="{{ $item['id'] }}"
                                                            data-name="{{ $item['name'] }}"
                                                            title="Restaurar">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                    
                                                    <!-- Botón Eliminar Permanentemente -->
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            data-type="{{ $item['type'] }}"
                                                            data-id="{{ $item['id'] }}"
                                                            data-name="{{ $item['name'] }}"
                                                            title="Eliminar Permanentemente">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
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
        </div>
    </div>
</div>

<!-- Modal de Restauración -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">
                    <i class="fas fa-undo text-success"></i>
                    Confirmar Restauración
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea restaurar el siguiente elemento?</p>
                <div class="alert alert-info">
                    <strong id="restoreItemName"></strong>
                    <br>
                    <small class="text-muted">El elemento será restaurado a su estado anterior a la eliminación.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-undo"></i> Restaurar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminación Permanente -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p>¿Está seguro de que desea eliminar permanentemente el siguiente elemento?</p>
                <div class="alert alert-warning">
                    <strong id="deleteItemName"></strong>
                    <br>
                    <small>Una vez eliminado permanentemente, no podrá ser recuperado.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
            
            modalItemName.textContent = name;
            modalForm.action = `/admin/soft-deleted/permanent-delete/${type}/${id}`;
        });
    }
});
</script>
@stop
