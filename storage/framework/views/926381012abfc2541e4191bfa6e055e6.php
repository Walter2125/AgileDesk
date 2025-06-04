<?php $__env->startSection('title'); ?>
         <?php $__env->startSection('mensaje-superior'); ?>
            Editar Historia
        <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid mi-container">
    <link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">

        <?php if($errors->any()): ?>
        <div class="alert alert-danger mt-2">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <?php endif; ?>


    <form action="<?php echo e(route('historias.update',$historia->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" value="<?php echo e($historia->nombre); ?>" >
        </div>


        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimado*</label>
            <input type="number" name="trabajo_estimado" id="trabajo_estimado" class="form-control rounded " min="0" value="<?php echo e($historia->trabajo_estimado); ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignado a:</label>
            <select name="usuario_id" id="usuario_id" class="form-control">
                <option value="">-- Seleccionar usuario --</option>
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <option value="<?php echo e($usuario->id); ?>"
                        <?php echo e(old('usuario_id', $historia->usuario_id) == $usuario->id ? 'selected' : ''); ?>>
                        <?php echo e($usuario->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="prioridad" class="form-label" >Prioridad</label>
             <select name="prioridad" id="prioridad" class="form-control rounded">
                <option value="Alta" <?php echo e(old('prioridad', $historia->prioridad) == 'Alta' ? 'selected' : ''); ?>>Alta</option>
                <option value="Media" <?php echo e(old('prioridad', $historia->prioridad) == 'Media' ? 'selected' : ''); ?>>Media</option>
                <option value="Baja" <?php echo e(old('prioridad', $historia->prioridad) == 'Baja' ? 'selected' : ''); ?>>Baja</option>
            </select>
        </div>

        <?php if($columnas && $columnas->isNotEmpty()): ?>
            <div class="mb-3">
                <label for="columna_id" class="form-label">Estado</label>
                <select name="columna_id" id="columna_id" class="form-control">
                    <option value="">Sin Estado</option>
                    <?php $__currentLoopData = $columnas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($columna->id); ?>" <?php echo e(old('columna_id') == $columna->id ? 'selected' : ''); ?>>
                            <?php echo e($columna->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php endif; ?>


        <div class="mb-3">
            <label for="sprint_id" class="form-label">Sprint</label>
            <select name="sprint_id" id="sprint_id" class="form-control rounded">
                <option value="">Ningún Sprint</option>
                <?php $__currentLoopData = $sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sprint->id); ?>"
                        <?php echo e(old('sprint_id', $historia->sprint_id) == $sprint->id ? 'selected' : ''); ?>>
                        <?php echo e($sprint->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>



        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4"><?php echo e($historia->descripcion); ?></textarea>
        </div>





         <div class="mb-3 d-flex justify-content-end">
            <a href="<?php echo e(route('historias.show', $historia->id)); ?>" class="btn btn-secondary me-2">Atras</a>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/historias/edit.blade.php ENDPATH**/ ?>