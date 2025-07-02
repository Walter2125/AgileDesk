    <?php $__env->startSection('mensaje-superior'); ?>
        Editar Proyecto: <?php echo e($project->name); ?>

    <?php $__env->stopSection(); ?>

<style>
    .search-container {
        position: relative;
    }

    #searchResults {
        position: absolute;
        width: 100%;
        z-index: 1000;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    /* ✅ Estilo global para campos redondeados */
    .form-control {
        border-radius: 15px !important;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-4">
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <form id="editProjectForm" method="POST" action="<?php echo e(route('projects.update', $project->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group mb-3">
                        <label for="name">Nombre del Proyecto</label>
                        <input id="name" type="text" class="form-control" name="name"
                               value="<?php echo e(old('name', $project->name)); ?>" required maxlength="30">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código del Proyecto</label>
                        <input type="text" name="codigo" id="codigo" class="form-control"
                            value="<?php echo e(old('codigo', $project->codigo)); ?>" required maxlength="10">
                        <small class="form-text text-muted">Debe ser un código único (por ejemplo: PRJ001).</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="descripcion"><?php echo e(__('Descripción')); ?></label>
                        <textarea id="descripcion" 
                            class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            name="descripcion" 
                            rows="4"><?php echo e(old('descripcion', $project->descripcion)); ?></textarea>
                        <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                               value="<?php echo e(old('fecha_inicio', $project->fecha_inicio)); ?>" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_fin">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                               value="<?php echo e(old('fecha_fin', $project->fecha_fin)); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Administrador del Proyecto</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <?php echo e($project->creator->name); ?>

                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Buscar Usuarios</label>
                        <div class="search-container mb-3">
                            <input type="text" class="form-control" id="userSearch" placeholder="Escribe el nombre de un usuario...">
                            <div id="searchResults" class="mt-2"></div>
                        </div>

                        <div id="usersTableContainer">
                            <?php echo $__env->make('projects.partials.users_table', [
                                'users' => $users,
                                'selectedUsers' => $selectedUsers,
                                'creatorId' => $project->user_id
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <div class="d-flex justify-content-center mt-3">
                                <?php echo e($users->links()); ?>

                            </div>
                        </div>
                    </div>

                    <div id="selectedUsersInputs">
                        <?php $__currentLoopData = $selectedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="users[]" value="<?php echo e($id); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
                        <a href="<?php echo e(route('projects.my')); ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .search-container { position: relative; }
        #searchResults {
            position: absolute; width: 100%; z-index: 1000;
            background: #fff; border: 1px solid #ddd; border-radius: 4px;
            max-height: 300px; overflow-y: auto; display: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            let selectedUsers = <?php echo json_encode($selectedUsers, 15, 512) ?>;

            function applySelections() {
                $('input.user-checkbox, input.user-checkbox-search').each(function() {
                    const id = $(this).val();
                    $(this).prop('checked', selectedUsers.includes(parseInt(id)));
                });
            }

            function updateHiddenInputs() {
                const container = $('#selectedUsersInputs');
                container.empty();
                selectedUsers.forEach(id => {
                    container.append(`<input type="hidden" name="users[]" value="${id}">`);
                });
            }

            $(document).on('change', '.user-checkbox, .user-checkbox-search', function() {
                const id = parseInt($(this).val());
                if ($(this).is(':checked')) {
                    if (!selectedUsers.includes(id)) selectedUsers.push(id);
                } else {
                    selectedUsers = selectedUsers.filter(u => u !== id);
                }
                applySelections();
                updateHiddenInputs();
            });

            // AJAX Paginación
            $(document).on('click', '#usersTableContainer .pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                $.ajax({
                    url: url,
                    data: { selected_users: selectedUsers },
                    success: function(data) {
                        $('#usersTableContainer').html(data.html + data.pagination);
                        applySelections();
                    },
                    error: function() {
                        alert('Error cargando la página de usuarios.');
                    }
                });
            });

            // Buscador AJAX
            $('#userSearch').on('input', function() {
                const q = $(this).val().trim();
                if (q.length < 1) return $('#searchResults').hide();

                $.getJSON('<?php echo e(route("projects.searchUsers")); ?>', { query: q })
                    .done(users => {
                        if (!users.length) {
                            return $('#searchResults').html('<div class="p-2">No se encontraron usuarios</div>').show();
                        }

                        let html = '<table class="table table-sm"><tbody>';
                        users.forEach(u => {
                            const checked = selectedUsers.includes(u.id) ? 'checked' : '';
                            html += `
                        <tr>
                            <td>
                                <input type="checkbox" class="user-checkbox-search" value="${u.id}" ${checked}>
                            </td>
                            <td>${u.name}</td>
                            <td>${u.email}</td>
                        </tr>`;
                        });
                        $('#searchResults').html(html + '</tbody></table>').show();
                    })
                    .fail(() => $('#searchResults').html('<div class="p-2">Error en la búsqueda</div>').show());
            });

            // Ocultar resultados al hacer clic fuera
            $(document).on('click', e => {
                if (!$(e.target).closest('#userSearch, #searchResults').length) {
                    $('#searchResults').hide();
                }
            });

            // Inicialización
            applySelections();
            updateHiddenInputs();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/projects/edit.blade.php ENDPATH**/ ?>