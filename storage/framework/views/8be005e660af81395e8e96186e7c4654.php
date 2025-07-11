<?php $__env->startSection('mensaje-superior'); ?>
    Lista de Tareas: <?php echo e($historia->nombre); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .table {
        color: #000000;
    }

    .table th,
    .table td {
        vertical-align: middle;
        background-color: #ffffff;
        border: 1px solid #ccc;
        font-weight: normal;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .progress {
        height: 25px;
        background-color: #e0e0e0;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #198754;
        color:rgb(7, 6, 6);
        font-weight: bold;
        line-height: 25px;
        transition: width 0.4s ease-in-out;
    }

    .btn {
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    .form-check-input {
        border-radius: 50% !important;
        width: 20px;
        height: 20px;
    }

    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: #0bb2d6;
        border-color: #0bb2d6;
    }

    .alert {
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container py-4" style="max-width: 1200px;">
    <div class="card p-5 mb-5">

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('deleted')): ?>
            <div class="alert alert-info"><?php echo e(session('deleted')); ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <label class="fw-bold mb-2">Progreso de tareas completadas:</label>
            <div class="progress">
                <div id="progress-bar" class="progress-bar bg-primary" role="progressbar"
                     style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered text-dark">
            <thead>
                <tr class="text-center">
                    <th>✓</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo de Actividad</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox"
                                class="form-check-input tarea-checkbox"
                                data-id="<?php echo e($tarea->id); ?>"
                                <?php echo e($tarea->completada ? 'checked' : ''); ?>>
                        </td>
                        <td><?php echo e($tarea->id); ?></td>
                        <td><?php echo e($tarea->nombre); ?></td>
                        <td><?php echo e($tarea->descripcion); ?></td>
                        <td><?php echo e($tarea->actividad); ?></td>
                        <td><?php echo e($tarea->created_at->format('d/m/Y H:i')); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('tareas.edit', [$historia->id, $tarea->id])); ?>"
                                class="btn btn-outline-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal<?php echo e($tarea->id); ?>" title="Eliminar">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay tareas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($tareas->links()); ?>

                    </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo e(route('historias.show', ['historia' => $historia->id])); ?>"
                    class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white mr-3 normal-case">
                    Atras
                    </a>
                    <a href="<?php echo e(route('tareas.index', $historia->id)); ?>" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">Nueva Tarea</a>
                </div>
    </div>
    
                    <?php $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal fade" id="deleteModal<?php echo e($tarea->id); ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo e($tarea->id); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <div class="mb-4">
                                            <h5 class="modal-title text-danger" id="deleteModalLabel<?php echo e($tarea->id); ?>">Confirmar Eliminación</h5>
                                            <h5 class="modal-title text-danger">¿Deseas eliminar esta tarea?</h5>

                                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>

                                            <div class="alert alert-danger d-flex align-items-center mt-3">
                                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                <div>
                                                    "<strong><?php echo e($tarea->nombre); ?></strong>" será eliminada permanentemente.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="<?php echo e(route('tareas.destroy', [$historia->id, $tarea->id])); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
    function actualizarBarraProgreso() {
        const checkboxes = document.querySelectorAll('.tarea-checkbox');
        const total = checkboxes.length;
        const completadas = [...checkboxes].filter(cb => cb.checked).length;
        const porcentaje = total > 0 ? Math.round((completadas / total) * 100) : 0;

        const progressBar = document.getElementById('progress-bar');
        progressBar.style.width = porcentaje + '%';
        progressBar.setAttribute('aria-valuenow', porcentaje);
        progressBar.textContent = porcentaje + '%';
    }

    document.querySelectorAll('.tarea-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const tareaId = this.dataset.id;

            fetch(`/tareas/${tareaId}/completar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({})
            }).then(response => {
                if (response.ok) {
                    actualizarBarraProgreso();
                } else {
                    alert('Error al guardar el progreso.');
                    this.checked = !this.checked;
                }
            });
        });
    });

    window.addEventListener('DOMContentLoaded', actualizarBarraProgreso);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/tareas/show.blade.php ENDPATH**/ ?>