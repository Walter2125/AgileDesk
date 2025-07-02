<div class="col-md-6 col-lg-4 mb-4">
    <div class="project-card card h-100">
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
                        <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás segura de que deseas eliminar este proyecto?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/projects/project-card.blade.php ENDPATH**/ ?>