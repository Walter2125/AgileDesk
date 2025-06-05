   
<?php $__env->startSection('styles'); ?>
<!-- Tabler Core CSS (Admin Template) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@2.28.0/dist/css/tabler.min.css">
    <!-- Bootstrap CSS -->
    <link rel="styleshee            // Actualiza la acción del formulario
            rejectUserForm.action = baseUrl + selectedUserId;

            // Habilita o deshabilita el botón de envío
            rejectSubmitBtn.disabled = !userId || userId === "0";"<?php echo e(asset('css/bootstrap.min.css')); ?>">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<style>
    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .alert-flash {
        border-left: 4px solid;
        animation: fadeInOut 5s ease-in-out;
    }
    .alert-flash.alert-success { border-left-color: #28a745; }
    @keyframes fadeInOut {
        0% { opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-flash d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div><?php echo e(session('success')); ?></div>
                </div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <h3 class="card-title mb-2 mb-md-0">
                            <i class="bi bi-hourglass-split me-2"></i> Usuarios pendientes
                        </h3>
                        <p class="text-muted mb-0">Gestiona las solicitudes de colaboradores para acceder a la plataforma</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0">
                        <div class="search-container">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchUsers" class="form-control form-control-sm search-input" placeholder="Buscar usuarios...">
                        </div>
                        <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center">
                            <i class="bi bi-arrow-clockwise me-1"></i><span>Actualizar</span>
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <?php if($pendingUsers->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <h4 class="fw-semibold text-muted mt-3">No hay usuarios pendientes</h4>
                            <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table id="pendingUsersTable" class="table table-striped table-hover table-bordered align-middle mb-0">
                                <thead class="table-light">
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
                                    <?php $__currentLoopData = $pendingUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-user-id="<?php echo e($user->id); ?>">
                                            <td class="text-center">
                                                <input class="form-check-input user-checkbox" type="checkbox" value="<?php echo e($user->id); ?>">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
                                                    <div>
                                                        <div class="fw-medium"><?php echo e($user->name); ?></div>
                                                        <small class="text-muted"><?php echo e($user->email); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo e($user->created_at->format('d/m/Y H:i')); ?>

                                                <div><small class="text-muted"><?php echo e($user->created_at->diffForHumans()); ?></small></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark status-badge">
                                                    <i class="bi bi-clock me-1"></i>Pendiente
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary action-btn btn-icon" 
                                                            data-bs-toggle="modal" data-bs-target="#userDetailModal" 
                                                            data-user-id="<?php echo e($user->id); ?>">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    
                                                    <form action="<?php echo e(route('admin.users.approve', $user->id)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-success action-btn btn-icon">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger action-btn btn-icon"
                                                            data-bs-toggle="modal" data-bs-target="#rejectModal"
                                                            data-user-id="<?php echo e($user->id); ?>"
                                                            data-user-name="<?php echo e($user->name); ?>">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Rechazo -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rechazar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="rejectUserForm" action="<?php echo e(route('admin.users.reject', 0)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p>¿Confirmas que deseas rechazar a <strong id="modalUserName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="rejectSubmitBtn" class="btn btn-danger">Rechazar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal de Detalle -->
<div class="modal fade" id="userDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h4 id="detailModalUserName"></h4>
                <p id="detailModalUserEmail"></p>
                <p id="detailModalUserCreated"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Búsqueda
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#pendingUsersTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Seleccionar todos
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    }

    // Modal de detalle
    const userDetailModal = document.getElementById('userDetailModal');
    if (userDetailModal) {
        userDetailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const row = document.querySelector(`tr[data-user-id="${userId}"]`);
            
            document.getElementById('detailModalUserName').textContent = row.querySelector('.fw-medium').textContent;
            document.getElementById('detailModalUserEmail').textContent = row.querySelector('.text-muted').textContent;
            document.getElementById('detailModalUserCreated').textContent = row.querySelector('td:nth-child(3)').textContent;
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

            // Actualiza el nombre del usuario en el modal
            document.getElementById('modalUserName').textContent = userName;

            // Actualiza la acción del formulario
            rejectUserForm.action = `/admin/users/${userId}/reject`;

            // Habilita o deshabilita el botón de envío
            rejectSubmitBtn.disabled = !userId || userId === "0";
        });
    }

    if (rejectUserForm) {
        rejectUserForm.addEventListener('submit', function(e) {
            if (this.action.endsWith('/0/reject')) {
                e.preventDefault();
                alert('No se puede rechazar: usuario inválido.');
            }
        });
    }

    // Alertas temporales-flash
    const flashAlerts = document.querySelectorAll('.alert-flash');
    if (flashAlerts.length) {
        setTimeout(() => {
            flashAlerts.forEach(alert => alert.remove());
        }, 5000);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wally\Herd\AgileDesk\resources\views/users/admin/index.blade.php ENDPATH**/ ?>