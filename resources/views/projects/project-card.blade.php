<div class="col-md-6 col-lg-4 mb-4">
    <div id="project-{{ $project->id }}" class="project-card card h-100 position-relative"
         style="background-color: {{ $project->color ?? '#ffffff' }};">

        <!-- Botón de opciones (tres puntitos) -->
        <div x-data="{ open: false }" class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
            <button @click="open = !open" class="btn btn-sm btn-light border-0">
                &#x22EE;
            </button>

            <!-- Menú de selección de color -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 x-cloak
                 class="position-absolute end-0 mt-2 bg-white border rounded shadow p-3"
                 style="z-index: 20; width: 220px;"
                 x-data="colorPicker({{ $project->id }}, @json(route('projects.cambiarColor', $project->id)))">

                <label class="form-label">Seleccionar color:</label>
                <input type="color"
                       x-model="color"
                       value="{{ $project->color ?? '#ffffff' }}"
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

<script>
function colorPicker(projectId, url) {
    return {
        color: @json($project->color ?? '#ffffff'),
        async guardarColor() {
            console.log('Enviando color:', this.color, 'a', url);

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(url, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ color: this.color })
                });

                if (response.ok) {
                    document.querySelector(`#project-${projectId}`).style.backgroundColor = this.color;
                    alert('Color aplicado exitosamente.');
                } else {
                    const data = await response.json().catch(() => ({}));
                    alert('Error al aplicar el color. ' + (data.message || ''));
                }
            } catch (error) {
                alert('Error de conexión: ' + error.message);
            }
        }
    }
}

</script>


<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


