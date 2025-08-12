<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Tarjeta de proyecto -->
<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-{{ $project->id }}"
         class="project-card card h-100 position-relative"
         x-data="colorPicker({{ $project->id }}, '{{ route('projects.cambiarColor', $project->id) }}', '{{ $project->color ?? '#ffffff' }}')"
         :style="'background-color: ' + color + ' !important;'">

        <!-- Botón de 3 puntitos con menú estilo columnas historias -->
         {{-- Botón de 3 puntitos con menú estilo columnas historias --}}
<div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
    <div class="dropdown">
        <button class="btn btn-sm btn-light border-0" type="button" id="dropdownMenuButton{{ $project->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.2rem;">
            &#x22EE;
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $project->id }}" style="min-width: 160px;">
            <li>
                <button class="dropdown-item btn btn-sm text-start w-100" @click.prevent="showColor = !showColor">
                    Cambiar color
                </button>
            </li>
            <li>
                <button class="dropdown-item btn btn-sm text-start w-100" data-bs-toggle="modal" data-bs-target="#modal-integrantes-{{ $project->id }}">
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

<div class="position-absolute top-0 end-0 p-2" style="z-index: 10;" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="btn btn-sm btn-light border-0" 
                    aria-label="Opciones">&#x22EE;
                </button>

            <div x-show="open" @click.away="open = false" x-transition x-cloak
                 class="position-absolute end-0 mt-2 bg-white border rounded shadow p-2"
                 style="z-index: 20; width: 160px;">
                <button class="dropdown-item btn btn-sm text-start" @click.prevent="showColor = !showColor">
                    Cambiar color
                </button>
                <button class="dropdown-item btn btn-sm text-start" data-bs-toggle="modal" data-bs-target="#modal-integrantes-{{ $project->id }}">
                    Ver integrantes
                </button>

                <!-- Paleta de colores -->
                <div x-show="showColor" x-transition x-cloak class="mt-2">
                    <label class="form-label mb-1">Color:</label>
                    <input type="color" x-model="color" class="form-control form-control-color" style="width: 100%;">
                    <button @click.prevent="guardarColor" class="btn btn-primary btn-sm w-100 mt-2">Aplicar</button>
                </div>
            </div>
        </div>

        <!-- Contenido principal de la tarjeta -->
        <div class="card-body" style="background-color: inherit !important;">
            <div class="project-header">
                <div class="project-title-wrapper">
                    <h3 class="project-title">
                        <i class="fas fa-project-diagram"></i>
                        <span>{{ $project->name }}</span>
                    </h3>
                    <div class="project-code">
                        <strong>Código:</strong> {{ $project->codigo }}
                    </div>
                </div>
            </div>

            <div class="date-info">
                <div class="date-block">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $project->fecha_inicio }}</span>
                </div>
                <div class="date-block">
                    <i class="fas fa-calendar-check"></i>
                    <span>{{ $project->fecha_fin }}</span>
                </div>
            </div>

            <div class="project-description">
                {{ Str::limit($project->descripcion, 100) }}
            </div>

            <div class="action-buttons mt-3">
                <a href="{{ route('tableros.show', $project->id) }}" class="btn btn-view">
                    <i class="fas fa-eye"></i> Ver
                </a>

                @if(auth()->id() === $project->user_id)
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="btn btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#modalConfirmarEliminarProyecto"
                                data-action="{{ route('projects.destroy', $project->id) }}">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Modal de Ver Integrantes -->
        <div class="modal fade" id="modal-integrantes-{{ $project->id }}" tabindex="-1" aria-labelledby="integrantesLabel-{{ $project->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="integrantesLabel-{{ $project->id }}">Integrantes del Proyecto</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        @if ($project->users && $project->users->count())
                            <ul class="list-group list-group-flush">
                                @foreach ($project->users as $user)
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <div class="text-muted small">{{ $user->email }}</div>
                                        </div>
                                        <span class="badge bg-secondary rounded-pill">{{ $user->usertype }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No hay integrantes asignados a este proyecto.</p>
                        @endif
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
            @csrf
            @method('DELETE')
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
