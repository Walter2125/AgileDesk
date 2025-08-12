<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Tarjeta de proyecto -->
<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-{{ $project->id }}"
         class="project-card card h-100 position-relative"
         x-data="colorPicker({{ $project->id }}, '{{ route('projects.cambiarColor', $project->id) }}', '{{ $project->color ?? '#ffffff' }}')"
         :style="'background-color: ' + color + ' !important;'">

        <!-- Botón de 3 puntitos con menú estilo columnas historias -->
        <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;" x-data="{ open: false }">
            <button @click="open = !open"
        class="btn btn-three-dots"
        aria-label="Opciones">&#x22EE;</button>

           <div x-show="open" 
     @click.away="open = false" 
     x-transition 
     x-cloak
     class="menu-three-dots"
     style="z-index: 20; width: 160px;">
    
    <button class="menu-item" @click.prevent="showColor = !showColor">
        Cambiar color
    </button>
    <button class="menu-item" data-bs-toggle="modal" data-bs-target="#modal-integrantes-{{ $project->id }}">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background-color: var(--github-bg); border-bottom: 1px solid var(--github-border);">
                <h5 class="modal-title" id="integrantesLabel-{{ $project->id }}" style="font-weight: 600;">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7.5 3.75a.75.75 0 0 1 1.5 0v.5h.5a.75.75 0 0 1 0 1.5h-.5v.5a.75.75 0 0 1-1.5 0v-.5h-.5a.75.75 0 0 1 0-1.5h.5v-.5zM2 7.5a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 7.5zm0 3a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 10.5zm8.25-3.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5zm0 3a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5z"/>
                    </svg>
                    Integrantes del Proyecto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0" style="background-color: var(--github-bg);">
                @if ($project->users && $project->users->count())
                    <div class="contributors-ranking">
                        
                        @foreach ($project->users as $index => $user)
                            @php
                                $rank = $index + 1;
                                $rankClass = $rank <= 3 ? 'top-' . $rank : '';
                            @endphp
                            
                            <div class="contributor-item">
                                <div class="contributor-rank {{ $rankClass }}">{{ $rank }}</div>
                                
                                <div class="contributor-avatar">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="contributor-avatar-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="contributor-info">
                                    <h5 class="contributor-name">{{ $user->name }}</h5>
                                    <p class="contributor-email">{{ $user->email }}</p>
                                </div>
                                
                                <!-- Espacio vacío para mantener el formato -->
                                <div class="contributor-stats"></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state-box" style="padding: 2rem; text-align: center;">
                        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);">
                            <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                                <path d="M16 4C18.2 4 20 5.8 20 8C20 10.2 18.2 12 16 12C13.8 12 12 10.2 12 8C12 5.8 13.8 4 16 4ZM8 4C10.2 4 12 5.8 12 8C12 10.2 10.2 12 8 12C5.8 12 4 10.2 4 8C4 5.8 5.8 4 8 4ZM8 13C11.3 13 16 14.7 16 18V20H0V18C0 14.7 4.7 13 8 13ZM16 13C16.8 13 17.6 13.1 18.4 13.3C20.2 14.1 21.5 15.7 21.5 18V20H17.5V18.5C17.5 16.8 16.9 15.3 16 14.1V13Z"/>
                            </svg>
                        </div>
                        <h4 style="color: #dc2626; font-weight: 600; margin-bottom: 0.5rem;">Sin Integrantes</h4>
                        <p style="color: #6b7280; margin: 0 0 1rem 0; line-height: 1.5;">No hay miembros asignados a este proyecto. Agrega colaboradores desde la gestión de usuarios.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer" style="background-color: var(--github-bg); border-top: 1px solid var(--github-border);">
                <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="background-color: var(--github-btn-bg); color: var(--github-text);">Cerrar</button>
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

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>