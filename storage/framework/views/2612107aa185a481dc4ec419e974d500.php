        <?php $__env->startSection('mensaje-superior'); ?>
            Tablero de <?php echo e($project->name); ?>

        <?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/historias.css')); ?>">
    <?php

$colCount = $tablero->columnas->count();
        $widthStyle = ($colCount <= 4)
            ? 'width: calc(100% / ' . $colCount . ' - 1rem); max-width: none;'
            : 'width: 300px; flex-shrink: 0;';
    ?>

    <div class="container py-4">

            <!-- Contenedor para select y botones -->
            <div class="d-flex align-items-center gap-3 flex-wrap">

                <!-- Select de sprints -->
                <?php if($tablero->sprints && $tablero->sprints->count()): ?>
                    <select class="form-select"
                            id="sprintSelect"
                            aria-label="Seleccionar sprint"
                            style="min-width: 200px; max-width: 240px;">
                        <option selected disabled>Selecciona un sprint</option>
                        <?php $__currentLoopData = $tablero->sprints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sprint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sprint->id); ?>"><?php echo e($sprint->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>

                <!-- Botón para agregar columna -->
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAgregarColumna">
                    Agregar columna
                </button>

                <!-- Botón para crear sprint -->
                <button class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalCrearSprint"
                        id="btnAbrirCrearSprint">
                    Crear sprint
                </button>
            </div>
        </div>

        <!-- Contenedor de columnas scrollable horizontal -->
        <div class="overflow-auto pb-3 mt-3" style="width: 100%;">

       <div class="input-group mb-3" style="width: 55%;">
    <input type="text" id="buscadorHistorias" class="form-control" placeholder="🔍 Buscar historia por nombre...">
    <button class="btn btn-outline-secondary" type="button" id="limpiarBusqueda">
        ✖️
    </button>
</div>

        <div class="overflow-auto pb-3" style="width: 100%;">

            <div id="kanban-board" class="d-flex" style="min-width: max-content; gap: 1rem; min-height: 500px;">
                <?php $__currentLoopData = $tablero->columnas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white border rounded shadow-sm d-flex flex-column "
                         style="<?php echo e($widthStyle); ?> min-height: 500px;">
                        <div class="d-flex justify-content-between align-items-start bg-light p-2 border-bottom">
                            <?php if($columna->es_backlog): ?>
                                <strong><?php echo e($columna->nombre); ?></strong>
                            <?php else: ?>
                                <input type="text"
                                       value="<?php echo e($columna->nombre); ?>"
                                       class="form-control form-control-sm me-2 editable-title"
                                       data-column-id="<?php echo e($columna->id); ?>">
                            <?php endif; ?>

                                <div class="dropdown ms-2">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton<?php echo e($columna->id); ?>"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo e($columna->id); ?>">
                                        <li>
                                            <button class="dropdown-item" disabled>
                                                <strong>Acciones</strong>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item"
                                                    onclick="abrirModalEliminarColumna(<?php echo e($columna->id); ?>, '<?php echo e($columna->nombre); ?>')">
                                                Eliminar columna
                                            </button>
                                        </li>
                                    </ul>
                                </div>


                        </div>

                        <div class="p-2 border-bottom">
                            <a href="<?php echo e(route('historias.create.fromColumna', ['columna' => $columna->id])); ?>"
                            class="btn btn-sm btn-primary w-100">
                                Agregar historias
                            </a>
                        </div>

                        <div class="overflow-auto p-2 historia-lista"
                             data-columna-id="<?php echo e($columna->id); ?>"
                             style="flex: 1; min-height: 100px;">
                            <?php $__currentLoopData = $columna->historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <a href="<?php echo e(route('historias.show', $historia->id)); ?>"
                                  class="card mb-2 p-2 text-decoration-none text-dark d-block historia-item"
                                  data-historia-id="<?php echo e($historia->id); ?>"
                                  style="width: 100%; word-break: break-word; overflow: hidden;">
                                   <strong class="d-block" title="<?php echo e($historia->nombre); ?>">
                                       <?php echo e($historia->nombre); ?>

                                   </strong>
                               </a>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll(".historia-lista").forEach(function (el) {
                new Sortable(el, {
                    group: 'historias',
                    animation: 150,
                    onEnd: function (evt) {
                        const historiaId = evt.item.dataset.historiaId;
                        const nuevaColumnaId = evt.to.dataset.columnaId;

                        fetch(`/historias/${historiaId}/mover`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                columna_id: nuevaColumnaId
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error("Error al mover la historia.");
                            return response.json();
                        })
                        .then(data => {
                            console.log("Historia movida correctamente", data);
                        })
                        .catch(error => {
                            console.error(error);
                            alert("No se pudo mover la historia.");
                        });
                    }
                });
            });
        });
    </script>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editable-title").forEach(input => {
                input.addEventListener("blur", function () {
                    const columnId = this.dataset.columnId;
                    const newName = this.value.trim();

                    if (!newName) {
                        alert("El nombre no puede estar vacío.");
                        return;
                    }

                    fetch(/columnas/${columnId}, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ nombre: newName })
                    })
                        .then(response => {
                            if (!response.ok) throw new Error("Error HTTP " + response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Columna actualizada:', data);
                        })
                        .catch(error => {
                            alert("No se pudo actualizar el nombre de la columna.");
                            console.error(error);
                        });
                });
            });
        });
    </script>

 <!-- Modal Bootstrap para agregar columna -->
    <div class="modal fade" id="modalAgregarColumna" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="<?php echo e(route('columnas.store', $tablero->id)); ?>" class="modal-content">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar nueva columna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la columna</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>
    
 <!-- Modal para crear sprint -->
    <div class="modal fade" id="modalCrearSprint" tabindex="-1" aria-labelledby="modalCrearSprintLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formCrearSprint" method="POST" action="<?php echo e(route('sprints.store', $project->id)); ?>" class="modal-content">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="tablero_id" value="<?php echo e($tablero->id); ?>">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearSprintLabel">Crear Sprint <span id="numeroSprint"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                    </div>
                </div>


<!-- Modal de confirmación para eliminar columna -->
<!-- Modal de confirmación para eliminar columna -->
<div class="modal fade" id="modalConfirmarEliminarColumna" tabindex="-1" aria-labelledby="eliminarColumnaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEliminarColumna" method="POST" action="">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <input type="hidden" name="modo" id="modoEliminar">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarColumnaLabel">Eliminar columna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p id="mensajeEliminarColumna">¿Qué deseas hacer con las historias de esta columna?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger" onclick="enviarFormularioEliminar('eliminar_todo')">
                        Borrar columna y sus historias
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="enviarFormularioEliminar('solo_columna')">
                        Borrar columna, conservar historias
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear sprint</button>
                </div>
            </form>
        </div>
    </div>

    <!-- AJAX para actualizar nombre -->
    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".editable-title").forEach(input => {
                input.addEventListener("blur", function () {
                    const columnId = this.dataset.columnId;
                    const newName = this.value.trim();

                    if (!newName) {
                        alert("El nombre no puede estar vacío.");
                        return;
                    }

                    fetch(`/columnas/${columnId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ nombre: newName })
                    })
                        .then(response => {
                            if (!response.ok) throw new Error("Error HTTP " + response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Columna actualizada:', data);
                        })
                        .catch(error => {
                            alert("No se pudo actualizar el nombre de la columna.");
                            console.error(error);
                        });
                });
            });
        });
    </script>



            <script>
                // que en funcion del sprint actual o sea de las fechas esas sean las historias que me salgan al entrar al tablero , que esas sean las que aparezcan
                document.addEventListener('DOMContentLoaded', function () {
                    const btnAbrirCrearSprint = document.getElementById('btnAbrirCrearSprint');
                    const numeroSprintSpan = document.getElementById('numeroSprint');

                    // Obtén el último número de sprint del backend, o 0 si no hay
                    let ultimoNumeroSprint = <?php echo json_encode($tablero->sprints->max('numero_sprint') ?? 0, 15, 512) ?>;

                    btnAbrirCrearSprint.addEventListener('click', () => {
                        const nuevoNumero = ultimoNumeroSprint + 1;
                        numeroSprintSpan.textContent = nuevoNumero;

                        // Limpiar inputs de fecha al abrir
                        document.getElementById('fecha_inicio').value = '';
                        document.getElementById('fecha_fin').value = '';
                    });

                    // Opcional: validar que fecha_fin sea mayor que fecha_inicio antes de enviar
                    document.getElementById('formCrearSprint').addEventListener('submit', function(e) {
                        const inicio = document.getElementById('fecha_inicio').value;
                        const fin = document.getElementById('fecha_fin').value;

                        if (inicio === '' || fin === '') {
                            alert('Por favor selecciona ambas fechas.');
                            e.preventDefault();
                            return;
                        }

                        if (fin <= inicio) {
                            alert('La fecha de fin debe ser mayor que la fecha de inicio.');
                            e.preventDefault();
                        }
                    });
                });
            </script>
<script>
    document.getElementById('sprintSelect').addEventListener('change', function () {
        const sprintId = this.value;
        const url = new URL(window.location.href);

        if (sprintId) {
            // Si selecciona un sprint específico, actualiza el parámetro
            url.searchParams.set('sprint_id', sprintId);
        } else {
            // Si selecciona "Ningún Sprint", elimina el parámetro para mostrar todos
            url.searchParams.delete('sprint_id');
        }

        // Redirige a la nueva URL
        window.location.href = url.toString();
    });

</script>
<script>
    let columnaIdParaEliminar = null;

    // Función para abrir el modal y asignar el action del formulario
    function abrirModalEliminarColumna(columnaId) {
        columnaIdParaEliminar = columnaId;
        const form = document.getElementById('formEliminarColumna');
        form.action = `/columnas/${columnaId}`; // URL para eliminar columna (ajusta si usas prefijo)

        // Resetea el input modo por si acaso
        document.getElementById('modoEliminar').value = '';

        // Mostrar modal con Bootstrap 5
        var modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminarColumna'));
        modal.show();
    }

    // Función para enviar el formulario con el modo seleccionado
    function enviarFormularioEliminar(modo) {
        document.getElementById('modoEliminar').value = modo;
        document.getElementById('formEliminarColumna').submit();
    }
</script>






    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnAbrirCrearSprint = document.getElementById('btnAbrirCrearSprint');
            const numeroSprintSpan = document.getElementById('numeroSprint');
            let ultimoNumeroSprint = <?php echo json_encode($tablero->sprints->max('numero_sprint') ?? 0, 15, 512) ?>;

            btnAbrirCrearSprint.addEventListener('click', () => {
                const nuevoNumero = ultimoNumeroSprint + 1;
                numeroSprintSpan.textContent = nuevoNumero;

                document.getElementById('fecha_inicio').value = '';
                document.getElementById('fecha_fin').value = '';
            });

            document.getElementById('formCrearSprint').addEventListener('submit', function(e) {
                const inicio = document.getElementById('fecha_inicio').value;
                const fin = document.getElementById('fecha_fin').value;

                if (inicio === '' || fin === '') {
                    alert('Por favor selecciona ambas fechas.');
                    e.preventDefault();
                    return;
                }

                if (fin <= inicio) {
                    alert('La fecha de fin debe ser mayor que la fecha de inicio.');
                    e.preventDefault();
                }
            });
        });
    </script>

   <script>
 document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscadorHistorias");
    const limpiarBtn = document.getElementById("limpiarBusqueda");
    const columnas = document.querySelectorAll(".historia-lista");

    function realizarBusqueda() {
        const textoBusqueda = buscador.value.toLowerCase().trim();
        
        columnas.forEach(columna => {
            const historias = columna.querySelectorAll(".historia-item");
            let historiasVisibles = 0;
            
            historias.forEach(historia => {
                const nombre = historia.textContent.toLowerCase();
                if (nombre.includes(textoBusqueda)) {
                    historia.style.display = "block";
                    historiasVisibles++;
                } else {
                    historia.style.display = "none";
                }
            });
            
            // Opcional: ocultar columnas vacías
            columna.style.display = historiasVisibles > 0 ? "block" : "none";
        });
    }

    buscador.addEventListener("input", realizarBusqueda);
    limpiarBtn.addEventListener("click", function () {
        buscador.value = "";
        columnas.forEach(columna => {
            columna.style.display = "block";
            columna.querySelectorAll(".historia-item").forEach(h => h.style.display = "block");
        });
    });
});

</script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wally\Herd\AgileDesk\resources\views/users/admin/tablero.blade.php ENDPATH**/ ?>