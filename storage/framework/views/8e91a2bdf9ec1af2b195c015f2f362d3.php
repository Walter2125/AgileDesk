<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<!-- Tarjeta de proyecto -->
<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-<?php echo e($project->id); ?>"
         class="project-card card h-100 position-relative"
         x-data="colorPicker(<?php echo e($project->id); ?>, '<?php echo e(route('projects.cambiarColor', $project->id)); ?>', '<?php echo e($project->color ?? '#ffffff'); ?>')"
         :style="'background-color: ' + color + ' !important;'">

        <!-- Botón de 3 puntitos con menú estilo columnas historias -->
         
<div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
    <div class="dropdown">
        <button @click="open = !open" 
                class="btn btn-sm btn-light border-0" 
                type="button" id="dropdownMenuButton<?php echo e($project->id); ?>" 
                data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.2rem;">
            &#x22EE;
        </button>
        <ul x-show="open" @click.away="open = false" x-transition x-cloak
            class="dropdown-menu dropdown-menu-end" 
            aria-labelledby="dropdownMenuButton<?php echo e($project->id); ?>" style="min-width: 160px;">
            <li>
                <button class="dropdown-item btn btn-sm text-start w-100" @click.prevent="showColor = !showColor">
                    Cambiar color
                </button>
            </li>
            <li>
                <button class="dropdown-item btn btn-sm text-start w-100" data-bs-toggle="modal" data-bs-target="#modal-integrantes-<?php echo e($project->id); ?>">
                    Ver integrantes
                </button>
            </li>
            <!-- Paleta de colores -->
                <div x-show="showColor" x-transition x-cloak class="mt-2">
                    <label class="form-label mb-1">Color:</label>
                    <input type="color" x-model="color" class="form-control form-control-color" style="width: 100%;">
                    <button @click.prevent="guardarColor" class="btn btn-primary btn-sm w-100 mt-2">Aplicar</button>
                </div>
        </ul>
    </div>
</div>

        </div>

        <!-- Contenido principal de la tarjeta -->
        <div class="card-body" style="background-color: inherit !important;">
            <div class="project-header">
                <div class="project-title-wrapper">
                    <h3 class="project-title">
                        <i class="fas fa-project-diagram"></i>
                        <span><?php echo e($project->name); ?></span>
                    </h3>
                    <div class="project-code">
                        <strong>Código:</strong> <?php echo e($project->codigo); ?>

                    </div>
                </div>
            </div>

            <div class="date-info">
                <div class="date-block">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?php echo e($project->fecha_inicio); ?></span>
                </div>
                <div class="date-block">
                    <i class="fas fa-calendar-check"></i>
                    <span><?php echo e($project->fecha_fin); ?></span>
                </div>
            </div>

            <div class="project-description">
                <?php echo e(Str::limit($project->descripcion, 100)); ?>

            </div>

            <div class="action-buttons mt-3">
                <a href="<?php echo e(route('tableros.show', $project->id)); ?>" class="btn btn-view">
                    <i class="fas fa-eye"></i> Ver
                </a>

                <?php if(auth()->id() === $project->user_id): ?>
                    <a href="<?php echo e(route('projects.edit', $project->id)); ?>" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('projects.destroy', $project->id)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button"
                                class="btn btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#modalConfirmarEliminarProyecto"
                                data-action="<?php echo e(route('projects.destroy', $project->id)); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal de Ver Integrantes -->
        <div class="modal fade" id="modal-integrantes-<?php echo e($project->id); ?>" tabindex="-1" aria-labelledby="integrantesLabel-<?php echo e($project->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="integrantesLabel-<?php echo e($project->id); ?>">Integrantes del Proyecto</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <?php if($project->users && $project->users->count()): ?>
                            <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $project->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong><?php echo e($user->name); ?></strong>
                                            <div class="text-muted small"><?php echo e($user->email); ?></div>
                                        </div>
                                        <span class="badge bg-secondary rounded-pill"><?php echo e($user->usertype); ?></span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No hay integrantes asignados a este proyecto.</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Eliminar Proyecto -->
<div class="modal fade" id="modalConfirmarEliminarProyecto" tabindex="-1" aria-labelledby="eliminarProyectoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEliminarProyecto" method="POST" action="">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarProyectoLabel">Eliminar proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este proyecto? Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script para manejar el modal de eliminar proyecto -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEliminar = document.getElementById('modalConfirmarEliminarProyecto');
    modalEliminar.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');
        const form = document.getElementById('formEliminarProyecto');
        form.setAttribute('action', action);
    });
});
</script>

<!-- AlpineJS + Toastify + Función colorPicker -->
<script>
    function colorPicker(projectId, url, initialColor) {
        return {
            open: false,
            showColor: false,
            color: initialColor,
            guardarColor() {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ color: this.color })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showColor = false;
                        Toastify({
                            text: "Color actualizado correctamente",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4CAF50"
                        }).showToast();
                    } else {
                        Toastify({
                            text: data.error || "Error al actualizar el color",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#FF0000"
                        }).showToast();
                    }
                })
                .catch(() => {
                    Toastify({
                        text: "Error al actualizar el color",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#FF0000"
                    }).showToast();
                });
            }
        }
    }
</script>

<!-- Dependencias -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/projects/project-card.blade.php ENDPATH**/ ?>