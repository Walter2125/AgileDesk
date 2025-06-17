<?php $__env->startSection('mensaje-superior'); ?>
    Backlog del Proyecto: <?php echo e($proyecto->nombre); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">


        <!-- Filtro por sprint -->
        <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
            <select name="sprint_id" class="form-select" style="max-height: 38px; height: 38px; max-width: 250px;" onchange="this.form.submit()">

            <option value="">Todos los Sprints</option>
                <?php $__currentLoopData = $proyecto->sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sprint->id); ?>" <?php echo e($sprintId == $sprint->id ? 'selected' : ''); ?>>
                        <?php echo e($sprint->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <!-- Botón Azul a la par -->
            <a href="<?php echo e(route('historias.create', ['proyecto' => $proyecto->id])); ?>" class="btn btn-primary" style="height: 38px; display: flex; align-items: center;">
                Agregar Historia
            </a>


            </a>
        </form>

        <?php $__empty_1 = true; $__currentLoopData = $historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('historias.show', $historia->id)); ?>" class="text-decoration-none text-dark">
                <div class="card mb-2 p-3" style="transition: box-shadow 0.2s; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo e($historia->nombre); ?></strong><br>
                            <small class="text-muted">Prioridad: <?php echo e($historia->prioridad); ?></small><br>
                            <small class="text-muted">
                                Estado:
                                <?php if($historia->columna): ?>
                                    <?php echo e($historia->columna->nombre); ?>

                                <?php else: ?>
                                    <span class="text-danger">No asignada</span>
                                <?php endif; ?>
                            </small>
                        </div>
                        <?php if(is_null($historia->columna_id)): ?>
                            <i class="bi bi-exclamation-circle-fill text-danger fs-4" title="No asignada a ninguna columna"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="alert alert-info">No hay historias en el backlog para este proyecto.</div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/users/admin/backlog.blade.php ENDPATH**/ ?>