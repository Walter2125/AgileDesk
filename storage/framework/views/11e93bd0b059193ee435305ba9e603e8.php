<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1>Editar Proyecto: <?php echo e($project->name); ?></h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('projects.update', $project->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Nombre del Proyecto -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name', $project->name)); ?>" required>
            </div>

            <!-- Fechas -->
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo e(old('fecha_inicio', $project->fecha_inicio)); ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo e(old('fecha_fin', $project->fecha_fin)); ?>" required>
            </div>

            <!-- Dueño del Proyecto (Administrador) -->
            <div class="mb-3">
                <label class="form-label">Administrador del Proyecto</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <?php echo e($project->creator->name); ?>

                    </label>
                </div>
            </div>

            <!-- Selección de Usuarios -->
            <div class="mb-3">
                <label for="users" class="form-label">Seleccionar Usuarios</label>
                <div id="user_list">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- Mostrar al creador como seleccionado, pero no editable -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="users[]" value="<?php echo e($user->id); ?>" id="user<?php echo e($user->id); ?>"
                                <?php echo e(in_array($user->id, $project->users->pluck('id')->toArray()) ? 'checked' : ''); ?>

                                <?php echo e($user->id == $project->user_id ? 'disabled' : ''); ?>>
                            <label class="form-check-label" for="user<?php echo e($user->id); ?>"><?php echo e($user->name); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <small class="form-text text-muted">Selecciona uno o más usuarios para asignar al proyecto.</small>
            </div>

            <!-- Botón para Guardar Proyecto -->
            <button type="submit" class="btn btn-primary mt-3">Actualizar Proyecto</button>
        </form>
    </div>

    <style>
        #user_list .form-check {
            margin-bottom: 10px;
        }

        #user_list {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/projects/edit.blade.php ENDPATH**/ ?>