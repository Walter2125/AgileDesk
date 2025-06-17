<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Historial de Cambios</h1>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col">
                <input type="text" name="usuario" class="form-control" placeholder="Buscar por usuario" value="<?php echo e(request('usuario')); ?>">
            </div>
            <div class="col">
                <select name="accion" class="form-select">
                    <option value="">-- Acción --</option>
                    <option value="Creación" <?php echo e(request('accion') == 'Creación' ? 'selected' : ''); ?>>Creación</option>
                    <option value="Edición" <?php echo e(request('accion') == 'Edición' ? 'selected' : ''); ?>>Edición</option>
                    <option value="Eliminación" <?php echo e(request('accion') == 'Eliminación' ? 'selected' : ''); ?>>Eliminación</option>
                </select>
            </div>
            <div class="col">
                <input type="text" name="sprint" class="form-control" placeholder="Sprint ID" value="<?php echo e(request('sprint')); ?>">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Detalles</th>
                <th>Sprint</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $historial; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cambio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(\Carbon\Carbon::parse($cambio->fecha)->format('Y-m-d H:i')); ?></td>
                    <td><?php echo e($cambio->usuario); ?></td>
                    <td><?php echo e($cambio->accion); ?></td>
                    <td><?php echo e($cambio->detalles); ?></td>
                    <td><?php echo e($cambio->sprint ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">No se encontraron registros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php echo e($historial->withQueryString()->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/historial/index.blade.php ENDPATH**/ ?>