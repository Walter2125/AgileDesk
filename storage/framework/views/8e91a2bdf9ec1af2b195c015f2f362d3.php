<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<!-- Tarjeta de proyecto -->
<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-<?php echo e($project->id); ?>" 
         class="project-card card h-100 position-relative"
         style="background-color: <?php echo e($project->color ?? '#ffffff'); ?>;">

        <!-- Botón de 3 puntitos y menú -->
        <div 
            x-data="colorPicker(<?php echo e($project->id); ?>, '<?php echo e(route('projects.cambiarColor', $project->id)); ?>', '<?php echo e($project->color ?? '#ffffff'); ?>')"
            class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
            
            <button @click="open = !open" class="btn btn-sm btn-light border-0">
                &#x22EE;
            </button>

            <!-- Menú de selección de color -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 x-cloak
                 class="position-absolute end-0 mt-2 bg-white border rounded shadow p-3"
                 style="z-index: 20; width: 220px;">
                 
                <label class="form-label">Seleccionar color:</label>
                <input type="color"
                       x-model="color"
                       class="form-control form-control-color"
                       style="width: 100%;">

                <button @click.prevent="guardarColor"
                        class="btn btn-primary btn-sm w-100 mt-2">
                    Aplicar
                </button>
            </div>
        </div>

        <!-- Contenido principal de la tarjeta -->
        <div class="card-body">
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

            <div class="action-buttons">
                <a href="<?php echo e(route('tableros.show', $project->id)); ?>" class="btn btn-view">
                    <i class="fas fa-eye"></i> Ver
                </a>

                <?php if(auth()->id() === $project->user_id): ?>
                    <a href="<?php echo e(route('projects.edit', $project->id)); ?>" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="<?php echo e(route('projects.destroy', $project->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-delete"
                                onclick="return confirm('¿Estás segura de que deseas eliminar este proyecto?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function colorPicker(projectId, url, initialColor) {
    return {
        open: false,
        color: initialColor,
        async guardarColor() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(url, {
                    method: 'POST', // Cambiado de PUT a POST
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ color: this.color })
                });

                if (response.ok) {
                    document.querySelector(`#project-${projectId}`).style.backgroundColor = this.color;
                    this.open = false;
                    // Usar Toastr o similar para mejor UX
                    Toastify({
                        text: "Color actualizado correctamente",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#4CAF50",
                    }).showToast();
                } else {
                    const error = await response.json();
                    Toastify({
                        text: error.message || "Error al actualizar el color",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#f44336",
                    }).showToast();
                }
            } catch (error) {
                Toastify({
                    text: "Error de conexión: " + error.message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f44336",
                }).showToast();
            }
        }
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/projects/project-card.blade.php ENDPATH**/ ?>