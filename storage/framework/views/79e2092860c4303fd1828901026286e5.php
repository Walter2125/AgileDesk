<?php $__env->startSection('title', 'Administration - Agile Desk'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/estadisticas-proy.css')); ?>">
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

        /* Estilos para buscadores mejorados */
        .search-container {
            margin-bottom: 1rem;
        }

        .search-container .input-group {
            max-width: 400px;
        }

        .search-container .form-control {
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .search-container .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .search-container .btn-outline-secondary {
            border-color: #ced4da;
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .search-container .btn-outline-secondary:hover {
            background-color: #4a90e2;
            border-color: #4a90e2;
            color: white;
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
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem !important;
            }
            
            .card-header .d-flex.align-items-center {
                flex-direction: column;
                align-items: stretch !important;
                gap: 0.5rem !important;
            }
            
            .card-header .input-group {
                width: 100% !important;
                min-width: auto;
            }
            
            .card-header .btn-group {
                justify-content: center;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .card-header .d-flex.align-items-center {
                gap: 0.75rem !important;
            }
            
            .card-header span {
                font-size: 1rem;
                font-weight: bold;
            }
        }

        /* Resaltar filas filtradas */
        .highlighted-row {
            background-color: rgba(74, 144, 226, 0.1) !important;
        }

        /* Indicador de sin resultados */
        .no-results-row {
            text-align: center;
            font-style: italic;
            color: #6c757d;
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

        /* Estilos para truncar texto largo en las tablas */
        .admin-table td {
            max-width: 200px; /* Ancho máximo para las celdas */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Columnas específicas con anchos personalizados */
        .admin-table td:nth-child(1) { /* Columna Nombre */
            max-width: 150px;
        }

        .admin-table td:nth-child(2) { /* Columna Email */
            max-width: 180px;
        }

        .admin-table td:nth-child(3) { /* Columna Rol */
            max-width: 100px;
        }

        .admin-table td:nth-child(4) { /* Columna Estado */
            max-width: 120px;
        }

        .admin-table td:nth-child(5) { /* Columna Acciones */
            max-width: 120px;
            white-space: nowrap; /* Evitar que los botones se envuelvan */
        }

        /* Tooltip para mostrar el texto completo al hacer hover */
        .admin-table td[title] {
            cursor: help;
        }

        /* Estilos específicos para nombres de usuario con badges */
        .user-name-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            max-width: 150px;
        }

        .user-name-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        /* Responsive: ajustar anchos en pantallas pequeñas */
        @media (max-width: 768px) {
            .admin-table td:nth-child(1) {
                max-width: 120px;
            }
            
            .admin-table td:nth-child(2) {
                max-width: 140px;
            }
            
            .admin-table td:nth-child(3) {
                max-width: 80px;
            }
        }

        /* Configuración específica para cada tabla */
        .table-responsive {
            overflow-x: auto;
        }

        /* Tabla de historial con columnas específicas */
        .admin-table.historial-table td:nth-child(1) { /* Usuario */
            max-width: 130px;
        }

        .admin-table.historial-table td:nth-child(2) { /* Acción */
            max-width: 140px;
        }

        .admin-table.historial-table td:nth-child(3) { /* Detalles */
            max-width: 200px;
        }

        .admin-table.historial-table td:nth-child(4) { /* Fecha */
            max-width: 120px;
        }

        /* Tabla de proyectos */
        .admin-table.proyectos-table td:nth-child(1) { /* Nombre */
            max-width: 180px;
        }

        .admin-table.proyectos-table td:nth-child(2) { /* Responsable */
            max-width: 150px;
        }

        /* Tabla de sprints */
        .admin-table.sprints-table td:nth-child(1) { /* Nombre */
            max-width: 160px;
        }

        .admin-table.sprints-table td:nth-child(2) { /* Proyecto */
            max-width: 150px;
        }

        /* CORREGIR PROBLEMA DE Z-INDEX DE LOS MODALES */
        .modal {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
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

        /* Estilos para separar las secciones */
        .estadisticas-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
            position: relative;
        }

        .estadisticas-section::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
        }

        /* Asegurar que main-container tenga el padding correcto */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        @media (min-width: 768px) {
            .main-container {
                padding: 0 1.5rem;
            }
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="main-container">
    <!-- Sección administrativa -->
    <div class="row">
        <!-- Usuarios -->
        <div class="col-12 mb-3">
            <div class="card admin-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Usuarios</span>
                        <!-- Buscador para usuarios -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchUsuarios" placeholder="Buscar usuarios...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchUsuarios">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
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
                            <tbody id="usuariosTableBody">
                                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="usuario-row <?php echo e($usuario->trashed() ? 'table-secondary' : ''); ?>">
                                    <td title="<?php echo e($usuario->name); ?>">
                                        <div class="user-name-cell">
                                            <span class="user-name-text"><?php echo e($usuario->name); ?></span>
                                            <?php if($usuario->trashed()): ?>
                                                <span class="badge bg-secondary ms-1">Eliminado</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td title="<?php echo e($usuario->email); ?>"><?php echo e($usuario->email); ?></td>
                                    <td title="<?php echo e(ucfirst($usuario->usertype)); ?>"><?php echo e(ucfirst($usuario->usertype)); ?></td>
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
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Proyectos</span>
                        <!-- Buscador para proyectos -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchProyectos" placeholder="Buscar proyectos...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchProyectos">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="<?php echo e(route('projects.my')); ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-folder"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table proyectos-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Responsable</th>
                                    <th>Miembros</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="proyectosTableBody">
                                <?php $__empty_1 = true; $__currentLoopData = $proyectos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyecto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="proyecto-row">
                                    <td title="<?php echo e($proyecto->name); ?>"><?php echo e($proyecto->name); ?></td>
                                    <td title="<?php echo e($proyecto->creator->name ?? 'Sin responsable'); ?>"><?php echo e($proyecto->creator->name ?? 'Sin responsable'); ?></td>
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
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Historial de Cambios</span>
                        <!-- Buscador para historial -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchHistorial" placeholder="Buscar historial...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchHistorial">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="<?php echo e(route('historial.index')); ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-clock-history"></i> Ver Todo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table historial-table align-middle">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Detalles</th>
                                    <!-- <th>Sprint</th> -->
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="historialTableBody">
                                <?php $__empty_1 = true; $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="historial-row">
                                    <td title="<?php echo e($item->usuario); ?>">
                                        <span class="fw-semibold"><?php echo e($item->usuario); ?></span>
                                    </td>
                                    <td title="<?php echo e($item->accion); ?>">
                                        <?php echo e($item->accion); ?>

                                    </td>
                                    <td title="<?php echo e(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles)); ?>">
                                        <span><?php echo e(\Illuminate\Support\Str::limit(preg_replace('/\s*\(ID:.*?\)/', '', $item->detalles), 40)); ?></span>
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
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <span>Sprints</span>
                        <!-- Buscador para sprints -->
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control form-control-sm" id="searchSprints" placeholder="Buscar sprints...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnSearchSprints">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <a href="#" class="btn btn-sm btn-info">
                        <i class="bi bi-flag"></i> Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover admin-table sprints-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Proyecto</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="sprintsTableBody">
                                <?php $__empty_1 = true; $__currentLoopData = $sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="sprint-row">
                                    <td title="<?php echo e($sprint->nombre); ?>"><?php echo e($sprint->nombre); ?></td>
                                    <td title="<?php echo e($sprint->proyecto->name ?? 'N/A'); ?>"><?php echo e($sprint->proyecto->name ?? 'N/A'); ?></td>
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
    
    <!-- Sección de estadísticas del proyecto -->
    <div class="estadisticas-section">
        <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:0.7rem;letter-spacing:0.5px;">Estadisticas del Proyecto</h1>
        <?php if(auth()->guard()->check()): ?>
<?php endif; ?>
        
        <?php if(auth()->guard()->check()): ?>
            <?php if(isset($proyecto_actual)): ?>
                <!-- Selector de proyecto -->
                <div class="project-selector">
                    <label id="projectSelect-label">Proyecto:</label>
                    <select id="projectSelect" onchange="window.location.href = '/admin/homeadmin/project/' + this.value">
                        <?php $__currentLoopData = $proyectos_usuario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>" <?php echo e($project->id == $proyecto_actual->id ? 'selected' : ''); ?>>
                                <?php echo e($project->name); ?> (<?php echo e($project->codigo); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <!-- Botón de historial -->
                    <a href="<?php echo e(route('users.colaboradores.historial', $proyecto_actual->id)); ?>" 
                       class="btn btn-outline-primary me-2">
                         Ver Historial de Cambios
                    </a>
                </div>
                
                <h2 class="current-project-title">
                    <svg viewBox="0 0 16 16" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 2.5A2.5 2.5 0 014.5 0h8.75a.75.75 0 01.75.75v12.5a.75.75 0 01-.75.75h-2.5a.75.75 0 110-1.5h1.75v-2h-8a1 1 0 00-.714 1.7.75.75 0 01-1.072 1.05A2.495 2.495 0 012 11.5v-9zm10.5-1V9h-8c-.356 0-.694.074-1 .208V2.5a1 1 0 011-1h8zM5 12.25v3.25a.25.25 0 00.4.2l1.45-1.087a.25.25 0 01.3 0L8.6 15.7a.25.25 0 00.4-.2v-3.25a.25.25 0 00-.25-.25h-3.5a.25.25 0 00-.25.25z"/>
                    </svg>
                    <?php echo e($proyecto_actual->name); ?>

                </h2>
                
                <?php if($estadisticas->count()): ?>
                <div class="">

                    <!-- Resumen general del proyecto -->
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-number"><?php echo e($total_historias_proyecto); ?></span>
                            <span class="summary-label">Total Historias</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number"><?php echo e($total_tareas_proyecto); ?></span>
                            <span class="summary-label">Total Tareas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number"><?php echo e($total_en_proceso); ?></span>
                            <span class="summary-label">En Proceso</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number"><?php echo e($total_terminadas); ?></span>
                            <span class="summary-label">Terminadas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number"><?php echo e($total_contribuciones_proyecto); ?></span>
                            <span class="summary-label">Total Contribuciones</span>
                        </div>
                    </div>

                    <!-- Ranking de contribuidores -->
                    <div class="contributors-ranking">
                        <div class="ranking-header">
                            <h4 class="ranking-title">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.5 3.75a.75.75 0 0 1 1.5 0v.5h.5a.75.75 0 0 1 0 1.5h-.5v.5a.75.75 0 0 1-1.5 0v-.5h-.5a.75.75 0 0 1 0-1.5h.5v-.5zM2 7.5a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 7.5zm0 3a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 10.5zm8.25-3.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5zm0 3a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5z"/>
                                </svg>
                                Ranking de Contribuidores
                            </h4>
                            <small style="color: var(--github-text-secondary);">En este proyecto</small>
                        </div>
                        
                        <?php $__currentLoopData = $estadisticas->sortByDesc(fn($stat) => $stat['total_contribuciones']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $totalContributions = $stat['total_contribuciones'];
                                $rank = $index + 1;
                                $rankClass = $rank <= 3 ? 'top-' . $rank : '';
                                $badgeClass = match(true) {
                                    $totalContributions >= 20 => 'badge-active',
                                    $totalContributions >= 10 => 'badge-moderate',
                                    $totalContributions === 0 => 'badge-inactive',
                                    default => 'badge-new'
                                };
                                $badgeText = match(true) {
                                    $totalContributions >= 20 => 'Muy Activo',
                                    $totalContributions >= 10 => 'Activo',
                                    $totalContributions > 0 => 'Principiante',
                                    default => 'Sin Actividad'
                                };
                            ?>
                            
                            <div class="contributor-item" 
                                data-user-id="<?php echo e($stat['usuario']->id); ?>" 
                                data-project-id="<?php echo e($proyecto_actual->id); ?>">
                                <div class="contributor-rank <?php echo e($rankClass); ?>"><?php echo e($rank); ?></div>
                                
                                <div class="contributor-avatar">
                                    <?php if($stat['usuario']->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $stat['usuario']->photo)); ?>" alt="<?php echo e($stat['usuario']->name); ?>">
                                    <?php else: ?>
                                        <div class="contributor-avatar-placeholder">
                                            <?php echo e(strtoupper(substr($stat['usuario']->name, 0, 1))); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="contributor-info">
                                    <h5 class="contributor-name"><?php echo e($stat['usuario']->name); ?></h5>
                                    <p class="contributor-email"><?php echo e($stat['usuario']->email); ?></p>
                                </div>
                                
                                <div class="contributor-stats">
                                    <div class="contributor-contributions">
                                        <?php echo e($totalContributions); ?> contribuciones
                                    </div>
                                    <div class="contributor-badge <?php echo e($badgeClass); ?>">
                                        <?php echo e($badgeText); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Gráfico de contribuciones - Solo mostrar si hay más de un colaborador -->
                    <?php if($estadisticas->count() > 1): ?>
                        <div class="chart-container">
                            <h4 class="chart-title">Contribuciones en <?php echo e($proyecto_actual->name); ?></h4>
                            <div class="chart-wrapper">
                                <canvas id="contributionsChart"></canvas>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 2rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-top: 1rem;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; color: #64748b;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h4 style="margin: 0 0 0.5rem 0; color: #64748b;">Proyecto Individual</h4>
                            <p style="margin: 0; color: #9ca3af;">El gráfico de comparación se muestra cuando hay múltiples colaboradores en el proyecto.</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-project-message">
                <h3>No hay proyecto seleccionado</h3>
                <p>Por favor, selecciona un proyecto para ver las estadísticas.</p>
                <?php if(isset($proyectos_usuario) && $proyectos_usuario->count()): ?>
                    <div class="project-selector" style="justify-content: center;">
                        <label for="projectSelect">Seleccionar proyecto:</label>
                        <select id="projectSelect" onchange="window.location.href = '/admin/homeadmin/project/' + this.value">
                            <option value="">-- Seleccione --</option>
                            <?php $__currentLoopData = $proyectos_usuario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>">
                                    <?php echo e($project->name); ?> (<?php echo e($project->codigo); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    </div>
</div>

<!-- Modal de detalles de contribuciones - OPTIMIZADO -->
<div class="modal-overlay" id="contributorModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Detalles de Contribuciones
            </h3>
            <button class="modal-close" id="closeModal" aria-label="Cerrar modal">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="contributorModalContent">
                <!-- El contenido se carga dinámicamente aquí -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
    <div class="modal-dialog modal-dialog-centered">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prevenir errores de extensiones del navegador
        window.addEventListener('error', function(e) {
            // Silenciar errores de extensiones del navegador
            if (e.filename && (e.filename.includes('extension') || e.filename.includes('chrome-extension') || e.filename.includes('moz-extension'))) {
                e.preventDefault();
                return;
            }
        });

        // Prevenir errores de promesas rechazadas por extensiones
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
                // JavaScript para manejar modales de eliminación y restauración de usuarios
                
                // Modal de eliminación de usuario
                const deleteUserModal = document.getElementById('deleteUserModal');
                if (deleteUserModal) {
                    deleteUserModal.addEventListener('show.bs.modal', function (event) {
                        try {
                            const button = event.relatedTarget;
                            const userId = button.getAttribute('data-user-id');
                            const userName = button.getAttribute('data-user-name');
                            
                            // Actualizar el contenido del modal
                            const deleteUserNameEl = document.getElementById('deleteUserName');
                            if (deleteUserNameEl) {
                                deleteUserNameEl.textContent = userName;
                            }
                            
                            // Actualizar la acción del formulario
                            const form = document.getElementById('deleteUserForm');
                            if (form && userId) {
                                form.action = `/admin/users/${userId}/delete`;
                            }
                        } catch (error) {
                            console.error('Error en modal de eliminación:', error);
                        }
                    });
                }
                
                // Modal de restauración de usuario  
                const restoreUserModal = document.getElementById('restoreUserModal');
                if (restoreUserModal) {
                    restoreUserModal.addEventListener('show.bs.modal', function (event) {
                        try {
                            const button = event.relatedTarget;
                            const userId = button.getAttribute('data-user-id');
                            const userName = button.getAttribute('data-user-name');
                            
                            // Actualizar el contenido del modal
                            const restoreUserNameEl = document.getElementById('restoreUserName');
                            if (restoreUserNameEl) {
                                restoreUserNameEl.textContent = userName;
                            }
                            
                            // Actualizar la acción del formulario
                            const form = document.getElementById('restoreUserForm');
                            if (form && userId) {
                                form.action = `/admin/users/${userId}/restore`;
                            }
                        } catch (error) {
                            console.error('Error en modal de restauración:', error);
                        }
                    });
                }
                
                // Referencias a los elementos DOM existentes - Actualizado para múltiples buscadores
                const searchInputs = {
                    usuarios: document.getElementById('searchUsuarios'),
                    proyectos: document.getElementById('searchProyectos'),
                    historial: document.getElementById('searchHistorial'),
                    sprints: document.getElementById('searchSprints')
                };

                const searchButtons = {
                    usuarios: document.getElementById('btnSearchUsuarios'),
                    proyectos: document.getElementById('btnSearchProyectos'),
                    historial: document.getElementById('btnSearchHistorial'),
                    sprints: document.getElementById('btnSearchSprints')
                };

                const tableRows = {
                    usuarios: document.querySelectorAll('.usuario-row'),
                    proyectos: document.querySelectorAll('.proyecto-row'),
                    historial: document.querySelectorAll('.historial-row'),
                    sprints: document.querySelectorAll('.sprint-row')
                };

                // Función genérica para filtrar tablas
                function filterTable(tableType, searchColumns) {
                    try {
                        const searchInput = searchInputs[tableType];
                        const rows = tableRows[tableType];
                        
                        if (!searchInput || !rows) return;
                        
                        const searchTerm = searchInput.value.toLowerCase().trim();
                        let visibleRows = 0;

                        rows.forEach(row => {
                            try {
                                let shouldShow = false;
                                
                                // Si no hay término de búsqueda, mostrar todo
                                if (searchTerm === '') {
                                    shouldShow = true;
                                } else {
                                    // Buscar en las columnas especificadas
                                    for (let columnIndex of searchColumns) {
                                        const cell = row.querySelector(`td:nth-child(${columnIndex})`);
                                        if (cell) {
                                            const cellText = cell.textContent.toLowerCase();
                                            if (cellText.includes(searchTerm)) {
                                                shouldShow = true;
                                                break;
                                            }
                                        }
                                    }
                                }

                                if (shouldShow) {
                                    row.style.display = '';
                                    row.classList.remove('highlighted-row');
                                    if (searchTerm !== '') {
                                        row.classList.add('highlighted-row');
                                    }
                                    visibleRows++;
                                } else {
                                    row.style.display = 'none';
                                    row.classList.remove('highlighted-row');
                                }
                            } catch (error) {
                                console.error('Error al filtrar fila:', error);
                            }
                        });

                        // Manejar mensaje de "sin resultados"
                        const tableBody = document.getElementById(`${tableType}TableBody`);
                        if (tableBody) {
                            const noResultsRow = tableBody.querySelector('.no-results-message');
                            
                            if (visibleRows === 0 && searchTerm !== '') {
                                if (!noResultsRow) {
                                    const emptyRow = document.createElement('tr');
                                    emptyRow.classList.add('no-results-message');
                                    const columnsCount = tableBody.querySelector('tr')?.children.length || 5;
                                    emptyRow.innerHTML = `<td colspan="${columnsCount}" class="no-results-row">No se encontraron resultados para "${searchTerm}"</td>`;
                                    tableBody.appendChild(emptyRow);
                                }
                            } else {
                                if (noResultsRow) {
                                    noResultsRow.remove();
                                }
                            }
                        }
                    } catch (error) {
                        console.error(`Error en filterTable para ${tableType}:`, error);
                    }
                }

                // Función específica para filtrar usuarios (columnas: nombre, email)
                function filterUsuarios() {
                    filterTable('usuarios', [1, 2]); // Columnas 1 (nombre) y 2 (email)
                }

                // Función específica para filtrar proyectos (columnas: nombre, responsable)
                function filterProyectos() {
                    filterTable('proyectos', [1, 2]); // Columnas 1 (nombre) y 2 (responsable)
                }

                // Función específica para filtrar historial (columnas: usuario, acción, detalles)
                function filterHistorial() {
                    filterTable('historial', [1, 2, 3]); // Columnas 1 (usuario), 2 (acción), 3 (detalles)
                }

                // Función específica para filtrar sprints (columnas: nombre, proyecto)
                function filterSprints() {
                    filterTable('sprints', [1, 2]); // Columnas 1 (nombre) y 2 (proyecto)
                }

                // Configurar event listeners para todos los buscadores
                const filterFunctions = {
                    usuarios: filterUsuarios,
                    proyectos: filterProyectos,
                    historial: filterHistorial,
                    sprints: filterSprints
                };

                // Configurar eventos para botones de búsqueda
                Object.keys(searchButtons).forEach(tableType => {
                    const button = searchButtons[tableType];
                    const filterFunction = filterFunctions[tableType];
                    
                    if (button && filterFunction) {
                        button.addEventListener('click', filterFunction);
                    }
                });

                // Configurar eventos para inputs de búsqueda
                Object.keys(searchInputs).forEach(tableType => {
                    const input = searchInputs[tableType];
                    const filterFunction = filterFunctions[tableType];
                    
                    if (input && filterFunction) {
                        let typingTimer;
                        
                        // Filtrar mientras se escribe (con delay)
                        input.addEventListener('keyup', function() {
                            try {
                                clearTimeout(typingTimer);
                                typingTimer = setTimeout(filterFunction, 300); // Delay de 300ms
                            } catch (error) {
                                console.error(`Error en keyup para ${tableType}:`, error);
                            }
                        });

                        // Limpiar timer al seguir escribiendo
                        input.addEventListener('keydown', function() {
                            try {
                                clearTimeout(typingTimer);
                            } catch (error) {
                                console.error(`Error en keydown para ${tableType}:`, error);
                            }
                        });

                        // Filtrar al presionar Enter
                        input.addEventListener('keypress', function(e) {
                            try {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    filterFunction();
                                }
                            } catch (error) {
                                console.error(`Error en keypress para ${tableType}:`, error);
                            }
                        });
                    }
                });

                // Función legacy para compatibilidad con código existente
                function filterProjects() {
                    filterProyectos();
                }
            } catch (error) {
                console.error('Error en DOMContentLoaded:', error);
            }
        });
    </script>

    <script>
        // Función de configuración de paginación para cualquier tabla
        function setupTablePagination(tableId, rowSelector, paginationId, rowsPerPage = 5) {
            try {
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
                        try {
                            e.preventDefault();
                            showTablePage(tableBody, rows, i, rowsPerPage);

                            // Actualizar clase activa
                            const pageItems = pagination.querySelectorAll('.page-item');
                            pageItems.forEach(item => item.classList.remove('active'));
                            this.classList.add('active');
                        } catch (error) {
                            console.error('Error en click de página:', error);
                        }
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
                    try {
                        e.preventDefault();
                        const activeItem = pagination.querySelector('.page-item.active');
                        if (activeItem && activeItem.previousElementSibling && activeItem.previousElementSibling.classList.contains('page-item')) {
                            const prevLink = activeItem.previousElementSibling.querySelector('.page-link');
                            if (prevLink) prevLink.click();
                        }
                    } catch (error) {
                        console.error('Error en botón anterior:', error);
                    }
                });

                nextLi.addEventListener('click', function(e) {
                    try {
                        e.preventDefault();
                        const activeItem = pagination.querySelector('.page-item.active');
                        if (activeItem && activeItem.nextElementSibling && activeItem.nextElementSibling.classList.contains('page-item')) {
                            const nextLink = activeItem.nextElementSibling.querySelector('.page-link');
                            if (nextLink) nextLink.click();
                        }
                    } catch (error) {
                        console.error('Error en botón siguiente:', error);
                    }
                });

                // Mostrar primera página al inicio
                showTablePage(tableBody, rows, 1, rowsPerPage);
            } catch (error) {
                console.error('Error en setupTablePagination:', error);
            }
        }

        // Función para mostrar una página específica
        function showTablePage(tableBody, rows, page, rowsPerPage) {
            try {
                // Ocultar todas las filas
                rows.forEach(row => {
                    if (row && row.style) {
                        row.style.display = 'none';
                    }
                });

                // Calcular rango de filas para la página actual
                const startIndex = (page - 1) * rowsPerPage;
                const endIndex = Math.min(startIndex + rowsPerPage, rows.length);

                // Mostrar filas de la página actual
                for (let i = startIndex; i < endIndex; i++) {
                    if (rows[i] && rows[i].style) {
                        rows[i].style.display = '';
                    }
                }
            } catch (error) {
                console.error('Error en showTablePage:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            try {
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
            } catch (error) {
                console.error('Error en configuración de paginación:', error);
            }
        });
    </script>
    
    <!-- Scripts para estadísticas del proyecto -->
    <script>
        // Inyectar datos para estadísticas
        window.userContributions = <?php echo json_encode($user_contributions ?? [], 15, 512) ?>;
        window.estadisticas = <?php echo json_encode($estadisticas ?? [], 15, 512) ?>;
        window.projectId = <?php echo json_encode($proyecto_actual->id ?? null, 15, 512) ?>;
        window.columnasOrdenadas = <?php echo json_encode($columnas_ordenadas ?? [], 15, 512) ?>;
    </script>
    
    <!-- Script externo para estadísticas -->
    <script src="<?php echo e(asset('js/estadisticas-proy.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/users/admin/homeadmin.blade.php ENDPATH**/ ?>