<?php $__env->startSection('title'); ?>

<?php $__env->startSection('mensaje-superior'); ?>
    Crea una nueva Historia
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <meta http-equiv="Cache-Control" content="no-store" />
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

<link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">

<div class="container-fluid mi-container ">

        <?php if($errors->any()): ?>
        <div class="alert alert-danger mt-2">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <?php endif; ?>

    <form action="<?php echo e(route('historias.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
       <!-- <h1 class="titulo-historia">Crea una nueva Historia</h1>-->

        <input type="hidden" name="proyecto_id" value="<?php echo e($proyecto ? $proyecto->id : ''); ?>">
        <input type="hidden" name="columna_id" value="<?php echo e($columna ? $columna->id : ''); ?>">




        <div class="mb-3 ">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" value="<?php echo e(old('nombre')); ?>" >
        </div>



        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimado* </label>
            <input type="number" name="trabajo_estimado" id="trabajo_estimado" class="form-control rounded" min="0" value="<?php echo e(old('trabajo_estimado')); ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignado a:</label>
            <select name="usuario_id" id="usuario_id" class="form-control">
                <option value="">Selecciona un usuario</option>
                <?php if($usuarios->isNotEmpty()): ?>
                    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($usuario->id); ?>"><?php echo e($usuario->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <option value="">No hay usuarios disponibles</option>
                <?php endif; ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="prioridad" class="form-label" >Prioridad</label>
            <select name="prioridad" id="prioridad" class="form-control rounded">
                <option value="Alta" <?php echo e(old('prioridad') == 'Alta' ? 'selected' : ''); ?>>Alta</option>
                <option value="Media" <?php echo e(old('prioridad', 'Media') == 'Media' ? 'selected' : ''); ?>>Media</option>
                <option value="Baja" <?php echo e(old('prioridad') == 'Baja' ? 'selected' : ''); ?>>Baja</option>
            </select>
        </div>

        <?php if($columna && $columnas->isNotEmpty()): ?>
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
            <label for="sprint_id" class="form-label">Seleccionar Sprint:</label>
            <select name="sprint_id" id="sprint_id" class="form-control">
                <option value="">Selecciona un sprint</option>
                <?php if($sprints->isNotEmpty()): ?>
                    <?php $__currentLoopData = $sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sprint->id); ?>"><?php echo e($sprint->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <option value="">No hay sprints disponibles</option>
                <?php endif; ?>
            </select>
        </div>



        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4"><?php echo e(old('descripcion')); ?></textarea>
        </div>

        <div class="mb-3 d-flex justify-content-end">
             <a href="<?php echo e(route('tableros.show', ['project' => $proyecto->id])); ?>"
               class="btn btn-secondary me-2">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\trimi\AgileDesk\resources\views/historias/create.blade.php ENDPATH**/ ?>