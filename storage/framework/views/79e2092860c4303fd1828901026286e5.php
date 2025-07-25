<?php $__env->startSection('title', 'Administration - Agile Desk'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Estilos para el panel de administración */
        .admin-header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a90e2;
        }

        .admin-card {
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .admin-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .button-container {
                justify-content: flex-end;
                padding-right: 20px;
            }
        }

        .button-container .btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
            border: none;
            color: white;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 5px;
        }

        .button-container .btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd);
            transform: scale(1.05);
        }

        .quick-stats {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .quick-stats .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a90e2;
        }

        .quick-stats .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .card-body {
            background-color: #ffffff;
            color: #333333;
        }
        .admin-table th {
            background-color: #f8f9fa;
        }

        /* Estilos para paginación */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

         /* Estilos para el buscador en modo claro */
         .input-group .form-control {
            border-radius: 0.25rem 0 0 0.25rem;
        }

        .input-group-append .btn {
            border-radius: 0 0.25rem 0.25rem 0;
        }

        /* Integración con la plantilla Tabler/Bootstrap */
        .page-header {
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .page-title {
            margin-bottom: 0;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .row{
            padding-block-start: 1rem;
        }

        /* Estilos para los btn-group sin bordes redondeados y separados */
        .btn-group {
            gap: 8px; /* Separación entre botones */
        }

        /* Quitar el borde entre los botones del grupo para que se vean como btn-info independientes */
        .btn-group .btn {
            border-radius: 6px !important;
            margin-right: 0;
            border: none !important;
            box-shadow: 1px 1px 8px rgba(0,0,0,0.08);
        }

        .btn-group .btn:focus, .btn-group .btn:active {
            outline: none;
            box-shadow: 0 0 0 0.15rem rgba(74,144,226,0.25);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <!-- Usuarios -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Usuarios</span>
                    <div class="btn-group" role="group">
                        <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-sm btn-info">
                            <i class="bi bi-people"></i> Ver Todos
                        </a>
                        <a href="<?php echo e(route('admin.deleted-users')); ?>" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Usuarios Eliminados
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="<?php echo e($usuario->trashed() ? 'table-secondary' : ''); ?>">
                                    <td>
                                        <?php echo e($usuario->name); ?>

                                        <?php if($usuario->trashed()): ?>
                                            <span class="badge bg-secondary ms-1">Eliminado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($usuario->email); ?></td>
                                    <td><?php echo e(ucfirst($usuario->usertype)); ?></td>
                                    <td>
                                        <?php if($usuario->trashed()): ?>
                                            <span class="badge bg-secondary">Eliminado</span>
                                        <?php else: ?>
                                            <span class="badge <?php echo e($usuario->is_approved ? 'bg-success' : 'bg-warning'); ?>">
                                                <?php echo e($usuario->is_approved ? 'Aprobado' : 'Pendiente'); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if($usuario->usertype !== 'admin'): ?>
                                                <?php if($usuario->trashed()): ?>
                                                    <!-- Botón para restaurar usuario -->
                                                    <button type="button" class="btn btn-sm btn-success" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreUserModal"
                                                            data-user-id="<?php echo e($usuario->id); ?>"
                                                            data-user-name="<?php echo e($usuario->name); ?>">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <!-- Botón para eliminar usuario -->
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteUserModal"
                                                            data-user-id="<?php echo e($usuario->id); ?>"
                                                            data-user-name="<?php echo e($usuario->name); ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay usuarios registrados</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            <?php echo e($usuarios->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proyectos -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Proyectos</span>
                    <a href="<?php echo e(route('projects.my')); ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-folder"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Responsable</th>
                                    <th>Miembros</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($proyecto->name); ?></td>
                                    <td><?php echo e($proyecto->creator->name ?? 'Sin responsable'); ?></td>
                                    <td><?php echo e($proyecto->users->count()); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('tableros.show', $proyecto->id)); ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay proyectos registrados</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            <?php echo e($proyectos->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Historial de Cambios</span>
                    <a href="<?php echo e(route('historial.index')); ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-clock-history"></i> Ver Todo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table align-middle">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Detalles</th>
                                    <!-- <th>Sprint</th> -->
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-semibold"><?php echo e($item->usuario); ?></span>
                                    </td>
                                    <td>
                                        <?php echo e($item->accion); ?>

                                    </td>
                                    <td>
                                        <span title="<?php echo e(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles)); ?>"><?php echo e(\Illuminate\Support\Str::limit(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles), 40)); ?></span>
                                    </td>
                                    <!-- <td>
                                        <?php if($item->sprint): ?>
                                            <span class="badge bg-info text-dark">#<?php echo e($item->sprint); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td> -->
                                    <td>
                                        <span title="<?php echo e($item->fecha ? \Carbon\Carbon::parse($item->fecha)->format('d/m/Y H:i:s') : $item->created_at->format('d/m/Y H:i:s')); ?>">
                                            <?php echo e($item->fecha ? \Carbon\Carbon::parse($item->fecha)->diffForHumans() : $item->created_at->diffForHumans()); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay historial registrado</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            <?php echo e($historial->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sprints -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Sprints</span>
                    <a href="#" class="btn btn-sm btn-info">
                        <i class="bi bi-flag"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($sprint->nombre); ?></td>
                                    <td><?php echo e($sprint->proyecto->name ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($sprint->estado === 'completado' ? 'bg-success' : ($sprint->estado === 'en progreso' ? 'bg-info' : 'bg-warning')); ?>">
                                            <?php echo e(ucfirst($sprint->estado)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay sprints registrados</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="pagination-container">
                            <?php echo e($sprints->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <h5 class="modal-title text-danger" id="deleteUserModalLabel">Confirmar Eliminación</h5>
                    <h5 class="modal-title text-danger">¿Deseas eliminar este usuario?</h5>
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                    <div class="alert alert-danger d-flex align-items-center mt-3">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>
                            "<strong><span id="deleteUserName"></span></strong>" será eliminado permanentemente.
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteUserForm" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal para confirmar restauración de usuario -->
<div class="modal fade" id="restoreUserModal" tabindex="-1" aria-labelledby="restoreUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreUserModalLabel">Confirmar Restauración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea restaurar al usuario <strong id="restoreUserName"></strong>?</p>
                <p class="text-muted small">El usuario será restaurado al estado activo.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="restoreUserForm" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-arrow-clockwise me-1"></i> Restaurar Usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // JavaScript para manejar modales de eliminación y restauración de usuarios
            
            // Modal de eliminación de usuario
            const deleteUserModal = document.getElementById('deleteUserModal');
            if (deleteUserModal) {
                deleteUserModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');
                    
                    // Actualizar el contenido del modal
                    document.getElementById('deleteUserName').textContent = userName;
                    
                    // Actualizar la acción del formulario
                    const form = document.getElementById('deleteUserForm');
                    form.action = `/admin/users/${userId}/delete`;
                });
            }
            
            // Modal de restauración de usuario  
            const restoreUserModal = document.getElementById('restoreUserModal');
            if (restoreUserModal) {
                restoreUserModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');
                    
                    // Actualizar el contenido del modal
                    document.getElementById('restoreUserName').textContent = userName;
                    
                    // Actualizar la acción del formulario
                    const form = document.getElementById('restoreUserForm');
                    form.action = `/admin/users/${userId}/restore`;
                });
            }
            
            // Referencias a los elementos DOM existentes
            const searchInput = document.getElementById('searchProjects');
            const searchButton = document.getElementById('btnSearchProjects');
            const projectRows = document.querySelectorAll('.project-row');

            // Función para filtrar proyectos
            function filterProjects() {
                const searchTerm = searchInput.value.toLowerCase().trim();

                projectRows.forEach(row => {
                    const projectName = row.querySelector('td:first-child').textContent.toLowerCase();
                    const projectManager = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                    // Si el texto de búsqueda está en el nombre del proyecto o en el responsable
                    if (projectName.includes(searchTerm) || projectManager.includes(searchTerm)) {
                        row.style.display = ''; // Mostrar la fila
                    } else {
                        row.style.display = 'none'; // Ocultar la fila
                    }
                });
            }

            // Event listeners
            if (searchButton) {
                searchButton.addEventListener('click', filterProjects);
            }

            // También filtrar mientras se escribe (después de un pequeño delay)
            if (searchInput) {
                let typingTimer;
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(filterProjects, 500); // Esperar 500ms después de que el usuario deje de escribir
                });

                // Limpiar el timer si se sigue escribiendo
                searchInput.addEventListener('keydown', function() {
                    clearTimeout(typingTimer);
                });

                // Filtrar también al presionar Enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        filterProjects();
                    }
                });
            }
        });
    </script>

    <script>
        // Función de configuración de paginación para cualquier tabla
        function setupTablePagination(tableId, rowSelector, paginationId, rowsPerPage = 5) {
            const tableBody = document.getElementById(tableId);
            const pagination = document.getElementById(paginationId);
            
            if (!tableBody || !pagination) return;
            
            const rows = tableBody.querySelectorAll(rowSelector);

            // Calcular número de páginas
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            
            if (pageCount <= 1) {
                pagination.style.display = 'none';
                return;
            }

            // Limpiar paginación existente
            pagination.innerHTML = '';

            // Botón Anterior
            const prevLi = document.createElement('li');
            prevLi.classList.add('page-item');
            prevLi.innerHTML = '<a class="page-link" href="#">&laquo;</a>';
            pagination.appendChild(prevLi);

            // Páginas numeradas
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                if (i === 1) li.classList.add('active');

                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    showTablePage(tableBody, rows, i, rowsPerPage);

                    // Actualizar clase activa
                    const pageItems = pagination.querySelectorAll('.page-item');
                    pageItems.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });

                pagination.appendChild(li);
            }

            // Botón Siguiente
            const nextLi = document.createElement('li');
            nextLi.classList.add('page-item');
            nextLi.innerHTML = '<a class="page-link" href="#">&raquo;</a>';
            pagination.appendChild(nextLi);

            // Configurar eventos para prev/next
            prevLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.previousElementSibling && activeItem.previousElementSibling.classList.contains('page-item')) {
                    activeItem.previousElementSibling.querySelector('.page-link').click();
                }
            });

            nextLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.nextElementSibling && activeItem.nextElementSibling.classList.contains('page-item')) {
                    activeItem.nextElementSibling.querySelector('.page-link').click();
                }
            });

            // Mostrar primera página al inicio
            showTablePage(tableBody, rows, 1, rowsPerPage);
        }

        // Función para mostrar una página específica
        function showTablePage(tableBody, rows, page, rowsPerPage) {
            // Ocultar todas las filas
            rows.forEach(row => {
                row.style.display = 'none';
            });

            // Calcular rango de filas para la página actual
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, rows.length);

            // Mostrar filas de la página actual
            for (let i = startIndex; i < endIndex; i++) {
                rows[i].style.display = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de paginación para la tabla de proyectos
            setupTablePagination(
                'projectsTableBody',
                '.project-row',
                'projectsPagination',
                5
            );

            // Configuración de paginación para la tabla de historias
            setupTablePagination(
                'historiasTableBody',
                '.historia-row',
                'historiasPagination',
                5
            );

            // Configuración específica para la tabla de actividad reciente
            setupTablePagination(
                'activityTableBody',
                '.activity-row',
                'activityPagination',
                5
            );
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/users/admin/homeadmin.blade.php ENDPATH**/ ?>