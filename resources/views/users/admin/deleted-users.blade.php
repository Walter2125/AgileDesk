@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row" style="padding: 1rem;">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                    
                    <h4 class="mb-0">
                        Usuarios Eliminados
                    </h4>                    
                    <a href="{{ route('homeadmin') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Volver a Usuarios
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($deletedUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">                                    
                                    <tr>                                        
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Eliminado En</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deletedUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        @if ($user->photo)
                                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="rounded-circle" style="width: 2.5rem; height: 2.5rem; object-fit: cover; border: 2px solid #dc3545;">
                                                        @else
                                                            <div class="avatar-title bg-danger rounded-circle">
                                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">{{ $user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($user->usertype) }}
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                <small>
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $user->deleted_at->format('d/m/Y H:i') }}
                                                    <br>
                                                    <span class="text-info">
                                                        ({{ $user->deleted_at->diffForHumans() }})
                                                    </span>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Acciones de usuario">
                                                    <!-- Botón Restaurar -->
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm" 
                                                            title="Restaurar Usuario"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}">
                                                        <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
                                                    </button>
                                                    
                                                    <!-- Botón Eliminar Permanentemente -->
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" 
                                                            title="Eliminar Permanentemente"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}">
                                                        <i class="bi bi-trash3" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $deletedUsers->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">                            
                            <div class="empty-state">
                                <i class="bi bi-person-check fa-4x text-success mb-3"></i>
                                <h5 class="text-muted">Sin Datos</h5>
                                <p class="text-muted">Todos los usuarios están activos</p>
                                <a href="{{ route('homeadmin') }}" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Volver a Usuarios
                                </a>
                            </div>
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
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="restoreModalLabel">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Restaurar Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-question-circle fa-3x text-warning mb-3"></i>
                    <h6>¿Estás seguro de que deseas restaurar este usuario?</h6>
                    <p class="text-muted mb-0">Usuario: <strong id="restoreUserName"></strong></p>
                    <small class="text-muted">El usuario volverá a estar activo en el sistema.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>
                    Cancelar
                </button>
                <form id="restoreForm" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Sí, Restaurar
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
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Eliminar Permanentemente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h6 class="text-danger">¡Atención! Esta acción no se puede deshacer</h6>
                    <p class="text-muted mb-0">Usuario: <strong id="deleteUserName"></strong></p>
                    <div class="alert alert-danger mt-3" role="alert">
                        <small>
                            <i class="bi bi-info-circle me-1"></i>
                            El usuario y todos sus datos asociados serán eliminados permanentemente del sistema.
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i>
                        Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    height: 2.5rem;
    width: 2.5rem;
}

.avatar-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    height: 100%;
    width: 100%;
}

.empty-state {
    padding: 2rem;
}

.table th {
    font-weight: 600;
    border-top: none;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.modal-header.bg-success .btn-close-white,
.modal-header.bg-danger .btn-close-white {
    filter: brightness(0) invert(1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal de Restauración
    const restoreModal = document.getElementById('restoreModal');
    const restoreForm = document.getElementById('restoreForm');
    const restoreUserName = document.getElementById('restoreUserName');
    
    restoreModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        
        // Actualizar el contenido del modal
        restoreUserName.textContent = userName;
        restoreForm.setAttribute('action', `{{ url('admin/users') }}/${userId}/restore`);
    });
    
    // Modal de Eliminación
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUserName = document.getElementById('deleteUserName');
    
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        
        // Actualizar el contenido del modal
        deleteUserName.textContent = userName;
        deleteForm.setAttribute('action', `{{ url('admin/users') }}/${userId}/permanent-delete`);
    });
    
    // Opcional: Cerrar modal después del envío exitoso
    restoreForm.addEventListener('submit', function() {
        const modal = bootstrap.Modal.getInstance(restoreModal);
        setTimeout(() => modal.hide(), 100);
    });
    
    deleteForm.addEventListener('submit', function() {
        const modal = bootstrap.Modal.getInstance(deleteModal);
        setTimeout(() => modal.hide(), 100);
    });
});
</script>
@endsection