<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Tarjeta de proyecto -->
<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-{{ $project->id }}"
         class="project-card card h-100 position-relative"
         x-data="colorPicker({{ $project->id }}, '{{ route('projects.cambiarColor', $project->id) }}', '{{ $project->color ?? '#ffffff' }}')"
         :style="'background-color: ' + color + ' !important;'">

        <!-- Muestra el valor del color actual (solo para pruebas) -->
        {{-- <div><p x-text="color"></p></div> --}}

        <!-- Botón de 3 puntitos y menú -->
        <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
            <button @click="open = !open" class="btn btn-sm btn-light border-0">&#x22EE;</button>

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

            <div class="action-buttons">
                <a href="{{ route('tableros.show', $project->id) }}" class="btn btn-view">
                    <i class="fas fa-eye"></i> Ver
                </a>

                @if(auth()->id() === $project->user_id)
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"
                                onclick="return confirm('¿Estás segura de que deseas eliminar este proyecto?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Script Alpine + lógica -->
<script>
    function colorPicker(projectId, url, initialColor) {
        return {
            open: false,
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
                            this.open = false;
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
                    .catch(error => {
                        Toastify({
                            text: "Error al actualizar el color",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#FF0000"
                        }).showToast();
                        console.error('Error:', error);
                    });
            }
        }
    }
</script>

<!-- AlpineJS y Toastify -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">