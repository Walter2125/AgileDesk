        <?php $__env->startSection('mensaje-superior'); ?>
        <div class="mt-4 text-lg font-semibold text-blue-600">
                   
         <h1 class="titulo-historia">
            Lista de Tareas para la Historia: <?php echo e($historia->nombre); ?>

        </h1>
            </div>
        <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">
<div class="container" style="max-width: 1200px;">
    <!-- Lista de Tareas -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
       

        <!-- Mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <?php if(session('deleted')): ?>
            <div class="alert alert-info">
                <?php echo e(session('deleted')); ?>

            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo de Actividad</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($tarea->id); ?></td>
                        <td><?php echo e($tarea->nombre); ?></td>
                        <td><?php echo e($tarea->descripcion); ?></td>
                        <td><?php echo e($tarea->actividad); ?></td>
                        <td><?php echo e($tarea->created_at->format('d/m/Y H:i')); ?></td>
                        <td class="text-center">

                            <!-- Botón Editar (icono) -->
                            <a href="<?php echo e(route('tareas.edit', [$historia->id, $tarea->id])); ?>" 
                               class="btn btn-outline-warning btn-sm" 
                               title="Editar Tarea">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <!-- Botón Eliminar que abre el modal -->
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal<?php echo e($tarea->id); ?>"
                                    title="Eliminar Tarea">
                                <i class="bi bi-trash3"></i>
                            </button>

                            <!-- Modal de confirmación de eliminación -->
                            <div class="modal fade" id="deleteModal<?php echo e($tarea->id); ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo e($tarea->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded shadow">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title" id="deleteModalLabel<?php echo e($tarea->id); ?>">
                                                Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">¿Estás seguro de que deseas eliminar la tarea <strong><?php echo e($tarea->nombre); ?></strong>?</p>
                                            <p class="text-muted small mb-0">Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <form action="<?php echo e(route('tareas.destroy', [$historia->id, $tarea->id])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-info text-white">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay tareas registradas para esta historia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

         <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($tareas->links()); ?>

        </div>

        <!-- Botones -->
<div class="d-flex justify-content-between mt-4">
    <!-- Botón de Cancelar -->
    <a href="<?php echo e(route('historias.show', ['historia' => $historia->id])); ?>" 
   class="btn btn-light text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
   style="background-color: #e6f2ff;">
   ⬅️ Cancelar
</a>

    <!-- Botón de Crear Tarea -->
    <a href="<?php echo e(route('tareas.index', $historia->id)); ?>" 
   class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm" 
   style="background-color: #e6f2ff;">
     Crear Nueva Tarea
</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/tareas/show.blade.php ENDPATH**/ ?>