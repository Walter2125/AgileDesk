<div class="col-md-6 col-lg-4 mb-4 project-card-container">
    <div id="project-{{ $project->id }}" class="project-card card h-100 position-relative w-100"
         style="background-color: {{ $project->color ?? '#ffffff' }}; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">

        <!-- Botón de opciones (tres puntitos) -->
        <div id="color-picker-{{ $project->id }}" 
             x-data='{ 
                open: false, 
                projectColor: "{{ $project->color ?? '#ffffff' }}", 
                guardarColor() { 
                    const url = "{{ route('projects.cambiarColor', $project->id) }}";
                    const data = { color: this.projectColor };
                    const headers = {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]").getAttribute("content")
                    };
                    
                    fetch(url, {
                        method: "POST",
                        headers: headers,
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (response.ok) {
                            document.getElementById("project-{{ $project->id }}").style.backgroundColor = this.projectColor;
                            this.open = false;
                        }
                    })
                    .catch(error => console.error("Error:", error));
                }
             }'
             class="position-absolute top-0 end-0 p-2" 
             style="z-index: 10;">
            <button @click="open = !open" class="btn btn-sm btn-light border-0">
                &#x22EE;
            </button>

            <!-- Menú desplegable -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 x-cloak
                 class="position-absolute end-0 mt-2 bg-white border rounded shadow p-3"
                 style="z-index: 20; width: 220px;">

                <label class="form-label">Seleccionar color:</label>
                <input type="color"
                       x-model="projectColor"
                       class="form-control form-control-color"
                       style="width: 100%;">

                <button @click.prevent="guardarColor"
                        class="btn btn-primary btn-sm w-100 mt-2">
                    Aplicar
                </button>
            </div>
        </div>

        <!-- Cuerpo de la tarjeta -->
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

