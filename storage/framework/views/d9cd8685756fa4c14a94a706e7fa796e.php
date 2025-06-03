<?php $__env->startSection('title'); ?>
        <?php $__env->startSection('mensaje-superior'); ?>
            Detalle de la Historia
        <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>

        <link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">

        <div class="container-fluid mi-container ">

            <?php if(session('success')): ?>
                <div class="alert alert-success mt-2" id="success-alert">
                    <?php echo e(session('success')); ?>

                </div>

                <script>
                    setTimeout(function() {
                        const alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            <?php endif; ?>

            <div class="historia-container-fluid">

                <div class="historia-header">
                    <h2 class="historia-title"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; display: block;"
                        title="<?php echo e($historia->nombre); ?>">
                        <?php echo e($historia->nombre); ?>

                    </h2>

                    <div class="historia-meta">
                        <span class="badge bg-primary"><?php echo e($historia->prioridad); ?></span>
                        <span class="badge bg-secondary"><?php echo e($historia->trabajo_estimado); ?> horas</span>
                    </div>
                </div>

                <div class="historia-content">

                    <div class="historia-section">
                        <h3 class="section-title">Descripción</h3>
                        <div class="section-content">
                            <?php echo e($historia->descripcion); ?>

                        </div>
                    </div>


                    <div class="historia-details">
                        <div class="detail-item">
                            <span class="detail-label">Estado:</span>
                            <span class="detail-value">
                        <?php echo e($historia->columna ? $historia->columna->nombre : 'No especificado'); ?>

                    </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Sprint:</span>
                            <span class="detail-value">
                        <?php
                            $sprint = \App\Models\Sprint::find($historia->sprint_id);
                        ?>
                                <?php echo e($sprint ? $sprint->nombre : 'No asignado'); ?>

                    </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fecha creación:</span>
                            <span class="detail-value"><?php echo e($historia->created_at->format('d/m/Y')); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Asignado a:</span>
                            <span class="detail-value">
                        <?php echo e($historia->usuario ? $historia->usuario->name : 'No asignado'); ?>

                    </span>
                        </div>
                    </div>
                </div>

            </div>


            <a href="<?php echo e(route('tareas.show', $historia->id)); ?>"
               class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
               style="background-color: #e6f2ff;">
                📋 Agregar Tareas
            </a>



            <div class="mb-3 d-flex justify-content-end">
                <a href="<?php echo e(route('tableros.show', $historia->proyecto_id)); ?>" class="btn btn-secondary">Atrás</a>

                <a href="<?php echo e(route('historias.edit', $historia->id)); ?>" class="btn btn-primary ms-2">Editar</a>

                <form action="<?php echo e(route('historias.destroy', $historia->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo e($historia->id); ?>">Borrar</button>
                </form>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="confirmDeleteModal<?php echo e($historia->id); ?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?php echo e($historia->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel<?php echo e($historia->id); ?>">¿Desea eliminar esta historia?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                Se eliminará la historia "<strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 300px;" title="<?php echo e($historia->nombre); ?>">
                                    <?php echo e($historia->nombre); ?>

                                </strong>".
                                Esta acción no se puede deshacer.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                <form action="<?php echo e(route('historias.destroy', $historia->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wally\Herd\AgileDesk\resources\views/historias/show.blade.php ENDPATH**/ ?>