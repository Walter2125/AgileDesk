<?php $__env->startSection('title'); ?>
       <?php $__env->startSection('title'); ?>
         <?php $__env->startSection('mensaje-superior'); ?>
            Detalle de Historia 
        <?php $__env->stopSection(); ?>
    

<?php $__env->startSection('content'); ?>


<link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">

<div class="container-fluid-m-2 mi-container m-2">

             <?php if(session('success')): ?>
                <div class="alert alert-success mt-2" id="success-alert">
                    <?php echo e(session('success')); ?>

                </div>

                <script>
                    setTimeout(function() {
                        const alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            <?php endif; ?>

            <div class="historia-container-fluid">

                
    <div class="historia-header">
        <h2 class="historia-title"
            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; display: block;"
            title="<?php echo e($historia->nombre); ?>">
            H<?php echo e($historia->numero); ?> <?php echo e($historia->nombre); ?>

        </h2>
      

                    <div class="historia-meta">
                        <span class="badge bg-primary"><?php echo e($historia->prioridad); ?></span>
                        <span class="badge bg-secondary"><?php echo e($historia->trabajo_estimado); ?> horas</span>
                    </div>
                </div>

                <div class="historia-content">

                    </div>
                <div class="historia-section ">
                    <h3 class="section-title">Descripción</h3>
                    <div class="container" style="word-wrap: break-word; overflow-wrap: break-word;">
                        <?php echo e($historia->descripcion); ?>

                    </div>
                </div>


        <div class="historia-details">
            <div class="detail-item">
                <span class="detail-label">Estado:</span>
           <span class="detail-value"><?php echo e($historia->columna ? $historia->columna->nombre : 'Sin estado asignado'); ?></span>            </div>
            <div class="detail-item">
                <span class="detail-label">Sprint:</span>
                <span class="detail-value"><?php echo e($historia->sprint ?? 'No asignado'); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Fecha creación:</span>
                <span class="detail-value"><?php echo e($historia->created_at->format('d/m/Y')); ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Asignado a:</span>
                <span class="detail-value">
                    <?php echo e($historia->usuario ? $historia->usuario->name : 'No asignado'); ?>

                </span>
            </div>
        </div>
        <a href="<?php echo e(route('tareas.show', $historia->id)); ?>"
               class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
               style="background-color: #e6f2ff;">
                 Agregar Tareas
            </a>



            <div class="mb-3 d-flex justify-content-end">
                <a href="<?php echo e(route('tableros.show', $historia->proyecto_id)); ?>" class="btn btn-secondary">Atrás</a>

                <a href="<?php echo e(route('historias.edit', $historia->id)); ?>" class="btn btn-primary ms-2">Editar</a>

                <form action="<?php echo e(route('historias.destroy', $historia->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo e($historia->id); ?>">Borrar</button>
                </form>
    </div>
</div>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="confirmDeleteModal<?php echo e($historia->id); ?>" tabindex="-1" aria-labelledby="confirmDeleteLabel<?php echo e($historia->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel<?php echo e($historia->id); ?>">¿Desea eliminar esta historia?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                Se eliminará la historia "<strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 300px;" title="<?php echo e($historia->nombre); ?>">
                                    <?php echo e($historia->nombre); ?>

                                </strong>".
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
            </div>
        </div>


<!-- 🔽 NUEVA SECCIÓN: Comentarios Modernizados -->
<div class="card mt-5 shadow border-0 rounded-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center px-4 py-3">
        <h4 class="mb-0 text-dark"><i class="bi bi-chat-left-text me-2 text-info"></i>Comentarios</h4>
        <button class="btn btn-light btn-sm text-info fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#nuevoComentarioModal">
    <i class="bi bi-chat-left-text me-1"></i> Comentar
</button>
    </div>

    <div class="card-body bg-light p-4">
        <?php if($historia->comentarios->count()): ?>
            <?php $__currentLoopData = $historia->comentarios->where('parent_id', null); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded-4 p-4 mb-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                         <strong class="text-dark fs-6">
                         <?php echo e(optional($comentario->user)->name ?? 'Usuario eliminado'); ?>

                         </strong>                            
                        <small class="text-muted ms-2"><?php echo e($comentario->created_at->diffForHumans()); ?></small>
                        </div>
                        <?php if(Auth::id() === $comentario->user_id): ?>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editarComentarioModal<?php echo e($comentario->id); ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="<?php echo e(route('comentarios.destroy', $comentario)); ?>" method="POST" onsubmit="return confirm('¿Deseas eliminar este comentario?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="mb-3 text-secondary"><?php echo e($comentario->contenido); ?></p>

                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#responderComentarioModal<?php echo e($comentario->id); ?>">
                        <i class="bi bi-reply-fill me-1"></i> Responder
                    </button>

                    <?php $__currentLoopData = $comentario->respuestas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respuesta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mt-4 ms-4 ps-4 border-start border-3 border-info">
                            <div class="d-flex justify-content-between">
                                <div>
                                <strong class="text-success">
                                 <?php echo e(optional($respuesta->user)->name ?? 'Usuario eliminado'); ?>

                                </strong>                                    
                                 <small class="text-muted ms-2"><?php echo e($respuesta->created_at->diffForHumans()); ?></small>
                                </div>
                                <?php if(Auth::id() === $respuesta->user_id): ?>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editarComentarioModal<?php echo e($respuesta->id); ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="<?php echo e(route('comentarios.destroy', $respuesta)); ?>" method="POST" onsubmit="return confirm('¿Eliminar respuesta?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="text-secondary mt-2"><?php echo e($respuesta->contenido); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Modal de Responder -->
                <div class="modal fade" id="responderComentarioModal<?php echo e($comentario->id); ?>" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-4">
                            <form action="<?php echo e(route('comentarios.store', $historia->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="parent_id" value="<?php echo e($comentario->id); ?>">
                                <div class="modal-header bg-dark text-white rounded-top-4">
                                    <h5 class="modal-title">Responder Comentario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea name="contenido" class="form-control" rows="4" placeholder="Escribe tu respuesta..." required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Publicar Respuesta</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p class="text-muted text-center">No hay comentarios aún.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Nuevo Comentario -->
<div class="modal fade" id="nuevoComentarioModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4">
            <form action="<?php echo e(route('comentarios.store', $historia->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title">Nuevo Comentario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea name="contenido" class="form-control" rows="5" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info text-white">Publicar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/historias/show.blade.php ENDPATH**/ ?>