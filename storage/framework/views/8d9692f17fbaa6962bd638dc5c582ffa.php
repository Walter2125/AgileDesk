        <?php $__env->startSection('mensaje-superior'); ?>
        Editar Tarea: <?php echo e($tarea->nombre); ?>

        <?php $__env->stopSection(); ?>
            

<?php $__env->startSection('content'); ?>


<link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">
<div class="container" style="max-width: 1200px;">
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        

        <!-- Mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Formulario de Edición de Tarea -->
        <form action="<?php echo e(route('tareas.update', [$historia->id, $tarea->id])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo e($tarea->nombre); ?>" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"><?php echo e($tarea->descripcion); ?></textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion" <?php echo e($tarea->actividad == 'Configuracion' ? 'selected' : ''); ?>>Configuración</option>
                    <option value="Desarrollo" <?php echo e($tarea->actividad == 'Desarrollo' ? 'selected' : ''); ?>>Desarrollo</option>
                    <option value="Prueba" <?php echo e($tarea->actividad == 'Prueba' ? 'selected' : ''); ?>>Prueba</option>
                    <option value="Diseño" <?php echo e($tarea->actividad == 'Diseño' ? 'selected' : ''); ?>>Diseño</option>
                    <option value="OtroTipo" <?php echo e($tarea->actividad == 'OtroTipo' ? 'selected' : ''); ?>>Otro Tipo</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
<a href="<?php echo e(route('tareas.show', $historia->id)); ?>" 
   class="btn btn-secondary">
    Cancelar
</a>                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/tareas/edit.blade.php ENDPATH**/ ?>