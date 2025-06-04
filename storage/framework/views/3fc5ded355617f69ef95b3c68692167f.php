<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 1200px;">
    <!-- Tarjeta de Crear Nueva Tarea -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <!-- Título con Icono -->
        <h3 class="text-center mb-4 fw-bold" style="font-size: 1.8em;">
            📝 Crear Nueva Tarea para la Historia: <?php echo e($historia->nombre); ?>

        </h3>

        <!-- Mensaje de éxito -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Información del Usuario -->
        <?php if(Auth::check()): ?>
            <div class="mb-4">
                <strong>Bienvenido, <?php echo e(Auth::user()->name); ?></strong>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <strong>Usuario no autenticado</strong>
            </div>
        <?php endif; ?>

        <!-- Formulario de Nueva Tarea -->
        <form action="<?php echo e(route('tareas.store', $historia->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion">Configuración</option>
                    <option value="Desarrollo">Desarrollo</option>
                    <option value="Prueba">Prueba</option>
                    <option value="Diseño">Diseño</option>
                </select>
            </div>

            <!-- Usuario Responsable -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-bold">Usuario Responsable</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Sin asignar</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear Tarea</button>
            </div>
        </form>
    </div>

    <!-- Lista de Tareas -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <h3 class="text-center mb-4 fw-bold" style="font-size: 1.8em;">
            📋 Lista de Tareas para la Historia: <?php echo e($historia->nombre); ?>

        </h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Actividad</th>
                    <th>Usuario</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($tarea->id); ?></td>
                        <td><?php echo e($tarea->nombre); ?></td>
                        <td><?php echo e($tarea->descripcion); ?></td>
                        <td><?php echo e($tarea->actividad); ?></td>
                        <td><?php echo e(optional($tarea->user)->name ?? 'Sin asignar'); ?></td>
                        <td><?php echo e($tarea->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <!-- Botón Editar -->
                            <a href="<?php echo e(route('tareas.edit', [$historia->id, $tarea->id])); ?>" class="btn btn-warning btn-sm mb-1">
                                ✏️ Editar
                            </a>

                            <!-- Botón Eliminar -->
                            <form action="<?php echo e(route('tareas.destroy', [$historia->id, $tarea->id])); ?>" method="POST" style="display: inline-block;" 
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/Tareas.blade.php ENDPATH**/ ?>