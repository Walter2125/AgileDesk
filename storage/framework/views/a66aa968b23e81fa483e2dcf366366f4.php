<<<<<<< HEAD
=======
    <?php $__env->startSection('mensaje-superior'); ?>
        Crear Nuevo Proyecto
    <?php $__env->stopSection(); ?>
>>>>>>> origin/main
<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-4">
<<<<<<< HEAD
            <h2 class="mb-4">Create New Project</h2>

=======
>>>>>>> origin/main
            <form id="projectForm" method="POST" action="<?php echo e(route('projects.store')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Nombre -->
                <div class="form-group mb-3">
<<<<<<< HEAD
                    <label for="name">Project Name</label>
=======
                    <label for="name">Nombre del Proyecto</label>
>>>>>>> origin/main
                    <input id="name" type="text"
                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        required autocomplete="off" autofocus>
                    <?php $__errorArgs = ['name'];
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
                <!-- Descripción -->
                <div class="form-group mb-3">
<<<<<<< HEAD
                    <label for="descripcion"><?php echo e(__('Descripción')); ?></label>
=======
                    <label for="descripcion">Descripción</label>
>>>>>>> origin/main
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
                        rows="4"><?php echo e(old('descripcion')); ?></textarea>
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
                <!-- Fecha Inicio -->
                <div class="form-group mb-3">
<<<<<<< HEAD
                    <label for="fecha_inicio">Start Date</label>
=======
                    <label for="fecha_inicio">Fecha de Inicio</label>
>>>>>>> origin/main
                    <input id="fecha_inicio" type="date"
                        class="form-control <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        name="fecha_inicio"
                        value="<?php echo e(old('fecha_inicio')); ?>"
                        required>
                    <?php $__errorArgs = ['fecha_inicio'];
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

                <!-- Fecha Fin -->
                <div class="form-group mb-3">
<<<<<<< HEAD
                    <label for="fecha_fin">End Date</label>
=======
                    <label for="fecha_fin">Fecha de Finalización</label>
>>>>>>> origin/main
                    <input id="fecha_fin" type="date"
                        class="form-control <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        name="fecha_fin"
                        value="<?php echo e(old('fecha_fin')); ?>"
                        required>
                    <?php $__errorArgs = ['fecha_fin'];
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

                <!-- Buscador y tabla -->
                <div class="form-group mb-3">
<<<<<<< HEAD
                    <label>Search Users</label>
=======
                    <label>Buscar Usuarios</label>
>>>>>>> origin/main
                    <div class="search-container mb-3">
                        <input type="text" class="form-control" id="userSearch" placeholder="Escribe el nombre de un usuario...">
                        <div id="searchResults" class="mt-2"></div>
                    </div>

                    <div id="usersTableContainer">
                        <?php echo $__env->make('projects.partials.users_table', [
                            'users' => $users,
                            'selectedUsers' => old('selected_users', [])
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($users->links()); ?>

                        </div>
                    </div>
                </div>

                <!-- Campo oculto con usuarios seleccionados -->
                <?php $__currentLoopData = old('selected_users', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="selected_users[]" value="<?php echo e($id); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div id="selectedUsersInputs"></div>

                <!-- Botones -->
                <div class="form-group mt-4">
<<<<<<< HEAD
                    <button type="submit" class="btn btn-primary">Save Project</button>
                    <a href="<?php echo e(route('projects.my')); ?>" class="btn btn-secondary">Cancel</a>
=======
                    <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
                    <a href="<?php echo e(route('projects.my')); ?>" class="btn btn-secondary">Cancelar</a>
>>>>>>> origin/main
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
    // Recuperar datos del sessionStorage si existen
    let selectedUsers = <?php echo json_encode(old('selected_users', []), 512) ?>;
    let formData = JSON.parse(sessionStorage.getItem('projectFormData')) || {
        name: $('#name').val(),
        descripcion: $('#descripcion').val(),
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val()
    };

    // Restaurar valores del formulario
    $('#name').val(formData.name);
    $('#descripcion').val(formData.descripcion);
    $('#fecha_inicio').val(formData.fecha_inicio);
    $('#fecha_fin').val(formData.fecha_fin);

    // Función para guardar el estado actual
    function saveFormState() {
        sessionStorage.setItem('projectFormData', JSON.stringify({
            name: $('#name').val(),
            descripcion: $('#descripcion').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            selectedUsers: selectedUsers
        }));
    }

    // Guardar estado cuando cambien los campos
    $('#name, #descripcion, #fecha_inicio, #fecha_fin').on('change input', saveFormState);

    function applySelections() {
        $('input.user-checkbox, input.user-checkbox-search').each(function() {
            const id = $(this).val();
            $(this).prop('checked', selectedUsers.includes(id));
        });
    }

    function updateHiddenInputs() {
        const container = $('#selectedUsersInputs');
        container.empty();
        selectedUsers.forEach(id => {
            container.append(`<input type="hidden" name="selected_users[]" value="${id}">`);
        });
    }

    $(document).on('change', '.user-checkbox, .user-checkbox-search', function() {
        const id = $(this).val();
        if ($(this).is(':checked')) {
            if (!selectedUsers.includes(id)) selectedUsers.push(id);
        } else {
            selectedUsers = selectedUsers.filter(u => u !== id);
        }
        saveFormState();
        applySelections();
        updateHiddenInputs();
    });

    // AJAX Paginación
    $(document).on('click', '#usersTableContainer .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');

        $.ajax({
            url: url,
            data: {
                selected_users: selectedUsers
            },
            success: function(data) {
                $('#usersTableContainer').html(data.html + data.pagination);
                applySelections();
            },
            error: function() {
                alert('Error cargando la página de usuarios.');
            }
        });
    });



    // Buscador (sin cambios)
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
                    const checked = selectedUsers.includes(String(u.id)) ? 'checked' : '';
                    html += `
                        <tr>
                            <td>
                                <input type="checkbox"
                                       class="user-checkbox-search"
                                       value="${u.id}"
                                       id="search_user_${u.id}"
                                       ${checked}>
                            </td>
                            <td>${u.name}</td>
                            <td>${u.email}</td>
                        </tr>`;
                });
                $('#searchResults').html(html + '</tbody></table>').show();
            })
            .fail(() => $('#searchResults').html('<div class="p-2">Error en la búsqueda</div>').show());
    });

    $(document).on('click', e => {
        if (!$(e.target).closest('#userSearch, #searchResults').length) {
            $('#searchResults').hide();
        }
    });

    // Limpiar sessionStorage al enviar el formulario
    $('#projectForm').on('submit', function() {
        sessionStorage.removeItem('projectFormData');
    });

    // Inicializar
    applySelections();
    updateHiddenInputs();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wally\Herd\AgileDesk\resources\views/projects/create.blade.php ENDPATH**/ ?>