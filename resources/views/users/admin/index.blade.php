@extends('layouts.app')
   
@section('styles')
<style>
    /* Estilos consistentes con homeadmin.blade.php */
    .admin-card {
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .admin-card .card-header {
        background-color: #f8f9fa !important;
        font-weight: bold;
    }

    .admin-table th {
        background-color: #f8f9fa !important;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2, #357abd);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }

    .search-container {
        position: relative;
        display: inline-block;
    }

    .search-container .bi-search {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #df1305;
        z-index: 2;
    }

    .search-input {
        padding-left: 35px !important;
    }

    /* Paginación */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }

    .row {
        padding-block-start: 1rem;
    }

    /* Efectos de hover mejorados */
    .btn-group .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Animación de carga para botones */
    .btn.loading {
        position: relative;
        pointer-events: none;
    }

    .btn.loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Modal personalizado */
    .modal {
        z-index: 1600 !important;
    }

    .modal-backdrop {
        z-index: 1599 !important;
    }

    .modal-content {
        border-radius: 8px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .modal-header {
        border-bottom: 1px solid #efeae9;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #efe9e9;
        padding: 1.5rem;
    }

    /* Mejorar centrado de modales */
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 3rem);
        margin: 1.5rem auto;
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
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card admin-card mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <h3 class="card-title mb-2 mb-md-0">
                            <i class="bi bi-hourglass-split me-2"></i> Usuarios Pendientes
                        </h3>
                        <p class="text-muted mb-0">Gestiona las solicitudes de colaboradores para acceder a la plataforma</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0">
                        <div class="search-container">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchUsers" class="form-control form-control-sm search-input" placeholder="Buscar usuarios...">
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($pendingUsers->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <h4 class="fw-semibold text-muted mt-3">No hay usuarios pendientes</h4>
                            <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="pendingUsersTable" class="table table-hover admin-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="w-1 text-center">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </th>
                                        <th>Usuario</th>
                                        <th>Fecha de registro</th>
                                        <th>Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendingUsers as $user)
                                        <tr data-user-id="{{ $user->id }}">
                                            <td class="text-center">
                                                <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($user->photo)
                                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de perfil" class="user-avatar me-3" style="object-fit:cover; border-radius:50%; width:40px; height:40px; min-width:40px;">
                                                    @else
                                                        <div class="user-avatar me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-medium">{{ $user->name }}</div>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('d/m/Y H:i') }}
                                                <div><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark status-badge">
                                                    <i class="bi bi-clock me-1"></i>Pendiente
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info btn-icon" 
                                                            data-bs-toggle="modal" data-bs-target="#userDetailModal" 
                                                            data-user-id="{{ $user->id }}"
                                                            title="Ver detalles">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    
                                                    <button type="button" class="btn btn-sm btn-success btn-icon"
                                                            data-bs-toggle="modal" data-bs-target="#approveModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            data-user-email="{{ $user->email }}"
                                                            title="Aprobar">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger btn-icon"
                                                            data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            title="Rechazar">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Aprobación -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">
                    <i class="bi bi-check-circle text-success me-2"></i>Aprobar usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="approveUserForm" action="{{ route('admin.users.approve', 0) }}">
                @csrf
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar me-3" id="approveModalUserAvatar"></div>
                        <div>
                            <h6 class="mb-1" id="approveModalUserName"></h6>
                            <small class="text-muted" id="approveModalUserEmail"></small>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex align-items-start">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div>
                            <strong>¿Confirmas que deseas aprobar este usuario?</strong>
                            <p class="mb-0 mt-1">El usuario recibirá acceso completo a la plataforma y podrá colaborar en proyectos.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Cancelar
                    </button>
                    <button type="submit" id="approveSubmitBtn" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Aprobar Usuario
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
                    <i class="bi bi-x-circle text-danger me-2"></i>Rechazar usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="rejectUserForm" action="{{ route('admin.users.reject', 0) }}">
                @csrf
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar me-3" id="rejectModalUserAvatar"></div>
                        <div>
                            <h6 class="mb-1" id="rejectModalUserName"></h6>
                            <small class="text-muted" id="rejectModalUserEmail"></small>
                        </div>
                    </div>
                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>¿Confirmas que deseas rechazar este usuario?</strong>
                            <p class="mb-0 mt-1">Esta acción eliminará permanentemente la solicitud del usuario.</p>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left me-1"></i>Cancelar
                    </button>
                    <button type="submit" id="rejectSubmitBtn" class="btn btn-danger">
                        <i class="bi bi-x-lg me-1"></i>Rechazar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Detalle -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">
                    <i class="bi bi-person-circle me-2"></i>Detalles del usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="user-avatar me-3" id="detailModalUserAvatar" style="width: 60px; height: 60px; font-size: 24px;"></div>
                    <div>
                        <h4 class="mb-1" id="detailModalUserName"></h4>
                        <p class="text-muted mb-0" id="detailModalUserEmail"></p>
                        <small class="text-success">
                            <i class="bi bi-clock me-1"></i>Solicitud pendiente
                        </small>
                    </div>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">Fecha de registro</small>
                                        <div class="fw-semibold" id="detailModalUserCreated"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-warning me-2"></i>
                                    <div>
                                        <small class="text-muted">Tiempo esperando</small>
                                        <div class="fw-semibold" id="detailModalUserWaiting"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-1"></i>Cerrar
                </button>
                <button type="button" class="btn btn-success" id="detailApproveBtn">
                    <i class="bi bi-check-lg me-1"></i>Aprobar
                </button>
                <button type="button" class="btn btn-danger" id="detailRejectBtn">
                    <i class="bi bi-x-lg me-1"></i>Rechazar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales para los modales
    let currentUserId = null;
    let currentUserData = {};

    // Búsqueda en tiempo real
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        let typingTimer;
        
        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#pendingUsersTable tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            }, 300);
        });

        searchInput.addEventListener('keydown', function() {
            clearTimeout(typingTimer);
        });
    }

    // Seleccionar todos los checkboxes
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Manejar checkboxes individuales
    const individualCheckboxes = document.querySelectorAll('.user-checkbox');
    individualCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(individualCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(individualCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Función para obtener datos del usuario desde la fila
    function getUserDataFromRow(userId) {
        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
        if (!row) return null;

        return {
            id: userId,
            name: row.querySelector('.fw-medium').textContent,
            email: row.querySelector('.text-muted').textContent,
            created: row.querySelector('td:nth-child(3)').textContent.trim(),
            waiting: row.querySelector('td:nth-child(3) small').textContent,
            initial: row.querySelector('.fw-medium').textContent.charAt(0).toUpperCase()
        };
    }

    // Modal de detalle del usuario
    const userDetailModal = document.getElementById('userDetailModal');
    if (userDetailModal) {
        userDetailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userData = getUserDataFromRow(userId);
            
            if (userData) {
                currentUserId = userId;
                currentUserData = userData;

                document.getElementById('detailModalUserName').textContent = userData.name;
                document.getElementById('detailModalUserEmail').textContent = userData.email;
                document.getElementById('detailModalUserCreated').textContent = userData.created;
                document.getElementById('detailModalUserWaiting').textContent = userData.waiting;
                document.getElementById('detailModalUserAvatar').textContent = userData.initial;
            }
        });
    }

    // Botones de acción en el modal de detalle
    const detailApproveBtn = document.getElementById('detailApproveBtn');
    const detailRejectBtn = document.getElementById('detailRejectBtn');

    if (detailApproveBtn) {
        detailApproveBtn.addEventListener('click', function() {
            bootstrap.Modal.getInstance(userDetailModal).hide();
            setTimeout(() => {
                const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
                // Simular click en el botón de aprobar
                const approveButton = document.querySelector(`button[data-bs-target="#approveModal"][data-user-id="${currentUserId}"]`);
                if (approveButton) {
                    approveButton.click();
                }
            }, 300);
        });
    }

    if (detailRejectBtn) {
        detailRejectBtn.addEventListener('click', function() {
            bootstrap.Modal.getInstance(userDetailModal).hide();
            setTimeout(() => {
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                // Simular click en el botón de rechazar
                const rejectButton = document.querySelector(`button[data-bs-target="#rejectModal"][data-user-id="${currentUserId}"]`);
                if (rejectButton) {
                    rejectButton.click();
                }
            }, 300);
        });
    }

    // Modal de aprobación
    const approveModal = document.getElementById('approveModal');
    const approveUserForm = document.getElementById('approveUserForm');
    const approveSubmitBtn = document.getElementById('approveSubmitBtn');

    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.getAttribute('data-user-email');
            const userInitial = userName.charAt(0).toUpperCase();

            // Actualizar contenido del modal
            document.getElementById('approveModalUserName').textContent = userName;
            document.getElementById('approveModalUserEmail').textContent = userEmail;
            document.getElementById('approveModalUserAvatar').textContent = userInitial;

            // Actualizar la acción del formulario
            if (approveUserForm) {
                approveUserForm.action = `/admin/users/${userId}/approve`;
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

    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userEmail = button.dataset.userEmail || 
                             document.querySelector(`tr[data-user-id="${userId}"] .text-muted`).textContent;
            const userInitial = userName.charAt(0).toUpperCase();

            // Actualizar contenido del modal
            document.getElementById('rejectModalUserName').textContent = userName;
            document.getElementById('rejectModalUserEmail').textContent = userEmail;
            document.getElementById('rejectModalUserAvatar').textContent = userInitial;

            // Actualizar la acción del formulario
            if (rejectUserForm) {
                rejectUserForm.action = `/admin/users/${userId}/reject`;
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
            if (this.action.endsWith('/0/approve')) {
                e.preventDefault();
                alert('No se puede aprobar: usuario inválido.');
                return false;
            }
            
            // Agregar indicador de carga
            if (approveSubmitBtn) {
                approveSubmitBtn.classList.add('loading');
                approveSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Aprobando...';
                approveSubmitBtn.disabled = true;
            }
        });
    }

    if (rejectUserForm) {
        rejectUserForm.addEventListener('submit', function(e) {
            if (this.action.endsWith('/0/reject')) {
                e.preventDefault();
                alert('No se puede rechazar: usuario inválido.');
                return false;
            }
            
            // Agregar indicador de carga
            if (rejectSubmitBtn) {
                rejectSubmitBtn.classList.add('loading');
                rejectSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Rechazando...';
                rejectSubmitBtn.disabled = true;
            }
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
                        submitBtn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Aprobar Usuario';
                    } else if (submitBtn.id === 'rejectSubmitBtn') {
                        submitBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Rechazar Usuario';
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
});
</script>
@endsection