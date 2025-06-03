<?php $__env->startSection('title','Lista de Historias'); ?>

<!--<i class="bi bi-plus"></i>
<i class="bi bi-trash"></i>
<i class="bi bi-pencil-square"></i> -->
<?php $__env->startSection('content'); ?>

   

<div class="container-fluid">
        <?php if(session('success')): ?>
            <div class="alert alert-success mt-2">
                <?php echo e(session('success')); ?>

            </div>
        
    <?php endif; ?>
    <h1>Lista de Historias</h1>

    <a href="<?php echo e(route('historias.create')); ?>" class="btn btn-primary">Crear</a>
        <table class="table">
            <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            </tr>
            </thead>

    <?php $__currentLoopData = $historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tbody>
            <tr>
            <th scope="row"><?php echo e($historia -> id); ?></th>
            <td><?php echo e($historia -> nombre); ?></td>
            <td><?php echo e($historia -> descripcion); ?></td>
            <td>
        </div>
              <a href="<?php echo e(route('historias.show', $historia->id)); ?>" class="btn btn-primary">VER</a>
                 <a href="<?php echo e(route('historias.edit', $historia->id)); ?>" class="btn btn-primary">EDITAR</a>
                 <form action="<?php echo e(route('historias.destroy', $historia->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                   <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo e($historia->id); ?>"> DELETE</button>
                 </form>
                       <!-- Modal -->
            <div class="modal fade" id="confirmDeleteModal<?php echo e($historia->id); ?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?php echo e($historia->id); ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel<?php echo e($historia->id); ?>">¿Desea eliminar esta historia?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    Se eliminara la historia "<strong><?php echo e($historia->nombre); ?></strong>"
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
            </td>
            </tr>
             </tbody>
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>


              

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\trimi\AgileDesk\resources\views/historias/index.blade.php ENDPATH**/ ?>