@extends('layouts.app')

@section('content')
<!-- Contenedor de notificaciones flotantes -->
<div id="notification-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1600; width: auto; max-width: 350px;"></div>

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
                                            <td title="{{ $user->name }}">
                                                <div class="user-info-container">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        @if ($user->photo)
                                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="rounded-circle" style="width: 2.5rem; height: 2.5rem; object-fit: cover; border: 2px solid #dc3545;">
                                                        @else
                                                            <div class="avatar-title bg-danger rounded-circle">
                                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="user-name">
                                                        <h6 class="mb-0 text-muted">{{ $user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted" title="{{ $user->email }}">{{ $user->email }}</td>
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
    <div class="modal-dialog modal-dialog-centered">
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
    <div class="modal-dialog modal-dialog-centered">
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
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    max-width: 90vw;
}

/* SOLUCIONAR DEFORMACIÓN DE TABLA CON TEXTO LARGO */
.table-responsive {
    overflow-x: auto;
}

/* Truncar texto largo en las celdas de la tabla */
.table td {
    max-width: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Anchos específicos para cada columna */
.table td:nth-child(1) { /* Usuario */
    max-width: 200px;
    min-width: 150px;
}

.table td:nth-child(2) { /* Email */
    max-width: 250px;
    min-width: 180px;
}

.table td:nth-child(3) { /* Rol */
    max-width: 100px;
    min-width: 80px;
    white-space: normal; /* Permitir wrap para badges */
}

.table td:nth-child(4) { /* Eliminado En */
    max-width: 150px;
    min-width: 120px;
    white-space: normal; /* Permitir wrap para fechas */
}

.table td:nth-child(5) { /* Acciones */
    max-width: 120px;
    min-width: 100px;
    white-space: nowrap;
}

/* Tooltips para mostrar texto completo */
.table td[title] {
    cursor: help;
}

/* Estilo para el nombre del usuario con avatar */
.user-info-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    max-width: 100%;
    min-width: 0;
}

.user-name {
    flex: 1;
    min-width: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive: ajustar en pantallas pequeñas */
@media (max-width: 768px) {
    .table td:nth-child(1) {
        max-width: 120px;
        min-width: 100px;
    }
    
    .table td:nth-child(2) {
        max-width: 150px;
        min-width: 120px;
    }
    
    .table td:nth-child(4) {
        max-width: 120px;
        min-width: 100px;
    }
    
    .modal-dialog {
        margin: 1rem;
        max-width: calc(100% - 2rem);
        min-height: calc(100vh - 2rem);
    }
}

/* Mejorar apariencia del modal en móviles */
@media (max-width: 576px) {
    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 1rem;
    }
    
    .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .modal-footer .btn {
        width: 100%;
    }
}
</style>

<script>
// Prevenir errores de extensiones del navegador
window.addEventListener('error', function(e) {
    if (e.filename && (e.filename.includes('extension') || e.filename.includes('chrome-extension') || e.filename.includes('moz-extension'))) {
        e.preventDefault();
        return;
    }
});

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
        // Modal de Restauración
        const restoreModal = document.getElementById('restoreModal');
        const restoreForm = document.getElementById('restoreForm');
        const restoreUserName = document.getElementById('restoreUserName');
        
        if (restoreModal) {
            restoreModal.addEventListener('show.bs.modal', function(event) {
                try {
                    const button = event.relatedTarget;
                    const userId = button?.getAttribute('data-user-id');
                    const userName = button?.getAttribute('data-user-name');
                    
                    // Actualizar el contenido del modal
                    if (restoreUserName && userName) {
                        restoreUserName.textContent = userName;
                    }
                    if (restoreForm && userId) {
                        const actionUrl = `/admin/users/${userId}/restore`;
                        restoreForm.setAttribute('action', actionUrl);
                        console.log('Restore form action set to:', actionUrl);
                    }
                } catch (error) {
                    console.error('Error en modal de restauración:', error);
                }
            });
        }
        
        // Modal de Eliminación
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteUserName = document.getElementById('deleteUserName');
        
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                try {
                    const button = event.relatedTarget;
                    const userId = button?.getAttribute('data-user-id');
                    const userName = button?.getAttribute('data-user-name');
                    
                    // Actualizar el contenido del modal
                    if (deleteUserName && userName) {
                        deleteUserName.textContent = userName;
                    }
                    if (deleteForm && userId) {
                        const actionUrl = `/admin/users/${userId}/permanent-delete`;
                        deleteForm.setAttribute('action', actionUrl);
                        console.log('Delete form action set to:', actionUrl);
                    }
                } catch (error) {
                    console.error('Error en modal de eliminación:', error);
                }
            });
        }
        
        // Opcional: Cerrar modal después del envío exitoso
        if (restoreForm) {
            restoreForm.addEventListener('submit', function() {
                try {
                    const modal = bootstrap.Modal.getInstance(restoreModal);
                    if (modal) {
                        setTimeout(() => modal.hide(), 100);
                    }
                } catch (error) {
                    console.error('Error al cerrar modal de restauración:', error);
                }
            });
        }
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function() {
                try {
                    const modal = bootstrap.Modal.getInstance(deleteModal);
                    if (modal) {
                        setTimeout(() => modal.hide(), 100);
                    }
                } catch (error) {
                    console.error('Error al cerrar modal de eliminación:', error);
                }
            });
        }
    } catch (error) {
        console.error('Error en DOMContentLoaded:', error);
    }
});

// Función para mostrar notificaciones dinámicas
function showNotification(type, message) {
    const alertType = type === 'error' ? 'danger' : type;
    const iconMap = {
        'success': 'bi-check-circle',
        'danger': 'bi-exclamation-circle', 
        'warning': 'bi-exclamation-triangle',
        'info': 'bi-info-circle'
    };
    const icon = iconMap[alertType] || 'bi-info-circle';
    
    const alertHtml = `
        <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
            <i class="bi ${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    `;

    const notificationContainer = document.getElementById('notification-container') || document.body;
    notificationContainer.insertAdjacentHTML('afterbegin', alertHtml);

    // Eliminar la notificación después de 5 segundos
    setTimeout(() => {
        const alert = notificationContainer.querySelector('.alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
}

// Funciones de conveniencia para notificaciones comunes
function showSuccessNotification(message) {
    showNotification('success', message);
}

function showErrorNotification(message) {
    showNotification('error', message);
}

function showWarningNotification(message) {
    showNotification('warning', message);
}

function showInfoNotification(message) {
    showNotification('info', message);
}
</script>
@endsection