@extends('layouts.app')

@section('mensaje-superior')
    Sprints del Proyecto
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">

        <div class="mb-3 d-flex justify-content-end boton-wrapper">
            <a href="{{ route('historias.create', ['proyecto' => $proyecto->id]) }}"
               class="btn btn-primary boton-ajustado"
               style="height: 38px; display: flex; align-items: center;">
                Crear Sprint
            </a>

        </div>

        <!-- Lista de Sprints, ocupando todo el ancho -->
        <div class="mx-n3 mx-md-n4">
            @forelse ($proyecto->sprints as $sprint)
                <div class="card mb-2 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $sprint->nombre }}</strong><br>
                            <small class="text-muted">Inicio: {{ $sprint->fecha_inicio }} | Fin: {{ $sprint->fecha_fin }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('sprints.edit', $sprint->id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1">
                                <i class="bi bi-pencil" style="font-size: 0.9rem;"></i>
                            </a>

                            <button class="btn btn-outline-danger btn-sm px-2 py-1" data-bs-toggle="modal" data-bs-target="#modalEliminarSprint{{ $sprint->id }}">
                                <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="modalEliminarSprint{{ $sprint->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $sprint->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-body text-center">
                                <div class="mb-4">
                                    <h5 class="modal-title text-danger" id="confirmDeleteLabel{{ $sprint->id }}">Confirmar Eliminación</h5>
                                    <h5 class="modal-title text-danger">¿Deseas eliminar este sprint?</h5>
                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                    <div class="alert alert-danger d-flex align-items-center mt-3">
                                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                                        <div>"<strong>{{ $sprint->nombre }}</strong>" será eliminado permanentemente.</div>
                                    </div>
                                </div>

                                <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    No hay sprints registrados en este proyecto.
                </div>
            @endforelse
        </div>

    </div>
    <script>
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                const sidebar = document.querySelector('.sidebar-collapse'); // Ajusta selector
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                }
            });
        });

    </script>
    <style>
    @media (min-width: 768px) {
    .boton-wrapper {
    position: relative;
    right: -20px;
    }
    }
    </style>


@endsection
