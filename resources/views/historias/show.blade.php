@extends('layouts.app')

       @section('title','Detalle de Historia')
         @section('mensaje-superior')
        <div class="mt-4 text-lg font-semibold text-blue-600">
            <h1 class="titulo-historia">Detalle de la Historia</h1>
        </div>
    @endsection


@section('content')
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

    <div class="container-fluid-m-2 mi-container m-2">

             @if (session('success'))
                <div class="alert alert-success mt-2" id="success-alert">
                    {{ session('success') }}
                </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    });
</script>
            @endif

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .respuesta-celeste {
    background-color: #e0f7fa !important; /* celeste */
}

.scroll-comentarios {
    max-height: 500px;
    overflow-y: auto;
}
</style>

<style>
    #accordionListaTareas {
        scrollbar-width: thin;
        scrollbar-color: #6f42c1 #f1f1f1;
    }
    #accordionListaTareas::-webkit-scrollbar {
        width: 6px;
    }
    #accordionListaTareas::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    #accordionListaTareas::-webkit-scrollbar-thumb {
        background-color: #6f42c1;
        border-radius: 4px;
    }
    /* Mejor apariencia del contenido interno */
    .contenido-tarea {
        background: #fafafa;
        border-left: 4px solid #6f42c1;
    }
    .contenido-tarea p {
        margin-bottom: 0.4rem;
        line-height: 1.4;
    }
    .contenido-tarea strong {
        color: #333;
    }
</style>

<style>
  .toggle-btn {
    position: relative;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.75rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: background-color 0.2s ease;
  }

  .toggle-btn::after {
    content: "";
    position: absolute;
    top: 12px;
    right: 16px;
    width: 12px;
    height: 12px;
    border-right: 2px solid #000;
    border-bottom: 2px solid #000;
    transform: rotate(45deg);
    pointer-events: none;
    transition: transform 0.2s ease;
  }

  .toggle-btn.active::after {
    transform: rotate(225deg); /* para cuando se despliega */
  }
</style>

 <div class="historia-header">
                    <div class="historia-header d-flex justify-content-between align-items-start">

                        <div>
                            <h2 class="historia-title mb-1"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;"
                                title="{{ $historia->nombre }}">
                                H{{ $historia->numero }} {{ $historia->nombre }}
                            </h2>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">{{ $historia->prioridad }}</span>
                                <span class="badge bg-secondary">{{ $historia->trabajo_estimado }} horas</span>
                            </div>
                        </div>
                        <a href="{{ route('tareas.show', $historia->id) }}" class="inline-block bg-teal-500 border border-teal-500 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-teal-700 mr-3 normal-case" data-bs-toggle="tooltip" title="Crea una Tarea"><i class="bi bi-plus-lg"></i></a>

                    </div>

                    <div class="historia-content">

                        <div class="historia-section ">
                            <h3 class="section-title">Descripción</h3>
                            <div class="container" style="word-wrap: break-word; overflow-wrap: break-word;">
                                        {{ $historia->descripcion }}
                        </div>
                    </div>


                        <div class="historia-details md-3">
                            <div class="detail-item">
                                <span class="detail-label">Estado:</span>
                                <span class="detail-value">{{ $historia->columna?->nombre ?? 'Sin estado asignado' }}</span>
                            </div>
                            <div class="detail-item">

                                <span class="detail-label">Sprint:</span>
                                <span class="detail-value">{{ $historia->sprint ?->nombre ?? 'No asignado' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Fecha creación:</span>
                                <span class="detail-value">{{ $historia->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Asignado a:</span>
                                <span class="detail-value">
                                    {{ $historia->usuario ? $historia->usuario->name : 'No asignado' }}
                                </span>
                            </div>

                        </div>

                                               <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top gap-2">
                                                <a href="{{ route('tableros.show', $historia->proyecto_id) }}"
                                                class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white normal-case">
                                                Atrás
                                                </a>

                                                <a href="{{ route('historias.edit', $historia->id) }}"
                                                class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 normal-case">
                                                Editar
                                                </a>

                                                <form action="{{ route('historias.destroy', $historia->id) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="inline-block bg-red-400 border border-red-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-red-600 normal-case"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteHistoriaModal{{ $historia->id }}">
                                                            Borrar
                                                    </button>
                                                </form>
                                            </div>

                            <div class="modal fade" id="deleteHistoriaModal{{ $historia->id }}" tabindex="-1" aria-labelledby="deleteHistoriaModalLabel{{ $historia->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 shadow">
                                            <div class="modal-header border-bottom-0">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>

                                        <div class="modal-body text-center">
                                                <div class="mb-4">
                                                    <h5 class="modal-title text-danger" id="deleteHistoriaModalLabel{{ $historia->id }}">Confirmar Eliminación</h5>
                                                    <h5 class="modal-title text-danger">¿Deseas eliminar esta historia?</h5>

                                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>

                                                    <div class="alert alert-danger d-flex align-items-center mt-3">
                                                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                        <div>
                                                            "<strong>{{ $historia->nombre }}</strong>" será eliminada permanentemente.
                                                        </div>
                                                    </div>
                                                </div>

                                            <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


{{-- ACORDEÓN DE TAREAS Y COMENTARIOS --}}
<div class="mb-0">
    {{-- BOTÓN: TAREAS RELACIONADAS --}}
    <div class="mb-0 border rounded">
        <button class="w-100 text-start fw-bold p-3 bg-light toggle-btn" data-target="tareas-acordeon" type="button" style="font-size: 0.95rem;">
            Tareas relacionadas
        </button>

        <div id="tareas-acordeon" class="contenido-acordeon" style="display: none;">
            @if($tareas->isEmpty())
                <div class="alert alert-warning m-2 py-2 px-3">No hay tareas registradas para esta historia.</div>
            @else
                {{-- CONTENEDOR SCROLL --}}
                <div class="accordion m-2" id="accordionListaTareas" style="max-height: 300px; overflow-y: auto; padding-right: 5px;">
                    @foreach($tareas as $tarea)
                        <div class="accordion-item mb-2 p-2 rounded shadow-sm border-0 bg-white hover-card">
                            <button class="accordion-button collapsed bg-white rounded-top d-flex align-items-center p-2" type="button"
                                    onclick="toggleTarea(this)" style="font-size: 0.9rem;">
                                <input type="checkbox"
                                       class="form-check-input me-2 tarea-checkbox"
                                       data-id="{{ $tarea->id }}"
                                       {{ $tarea->completada ? 'checked' : '' }}
                                       onclick="event.stopPropagation();">

                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold" style="font-size: 0.9rem;">{{ $tarea->nombre }}</h6>
                                </div>
                            </button>

                            <div class="contenido-tarea p-3 rounded-bottom" style="display: none; font-size: 0.85rem;">
                                <p>
                                    <strong> Descripción:</strong><br>
                                    <span style="color: #555;">{{ $tarea->descripcion }}</span>
                                </p>

                                <p>
                                    <strong> Fecha de creación:</strong><br>
                                    <span style="color: #555;">{{ $tarea->created_at->format('d/m/Y H:i') }}</span>
                                </p>

                                <p>
                                    <strong> Tipo de actividad:</strong><br>
                                    <span class="badge px-3 py-2 rounded-pill text-white" style="background-color: #6f42c1; font-size: 0.75rem;">
                                        <i class="bi bi-lightning-charge me-1"></i>{{ $tarea->actividad }}
                                    </span>
                                </p>

                                <div class="d-flex justify-content-end gap-2 mt-2">
                                    <a href="{{ route('tareas.edit', [$historia->id, $tarea->id]) }}" class="btn btn-outline-warning btn-sm p-1 px-2" title="Editar">
                                        <i class="bi bi-pencil-square"></i> 
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm p-1 px-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tarea->id }}" title="Eliminar">
                                        <i class="bi bi-trash3"></i> 
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal de confirmación --}}
                        <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <h5 class="modal-title text-danger mb-3">¿Deseas eliminar esta tarea?</h5>
                                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>

                                        <div class="alert alert-danger d-flex align-items-center mt-3 mb-4 py-2 px-3">
                                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                                            "<strong>{{ $tarea->nombre }}</strong>" será eliminada permanentemente.
                                        </div>

                                        <div class="d-flex justify-content-end gap-3">
                                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Botones finales --}}
            <div class="ms-2 mb-2">
                <a href="{{ route('tareas.index', $historia->id) }}"
                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 border border-blue-600 rounded-full bg-white hover:bg-blue-100 transition duration-300"
                   title="Ver tareas">
                    <span class="text-lg font-bold">+</span>
                </a>

                <a href="{{ route('tareas.show', $historia->id) }}"
                   class="inline-flex items-center justify-center w-8 h-8 text-blue-600 border border-blue-600 rounded-full hover:bg-blue-100 transition duration-300 ms-1"
                   title="Ver lista de tareas">
                    <i class="bi bi-eye text-base"></i>
                </a>
            </div>
        </div>
    </div>
</div>

 {{-- BOTÓN: COMENTARIOS --}}
<div class="mb-0">
<div class="mb-0 border rounded">
  <button class="w-100 text-start fw-bold p-3 bg-light toggle-btn" data-target="comentarios-acordeon" type="button">
    Comentarios
  </button>
  <div id="comentarios-acordeon" class="contenido-acordeon" style="display: none;">

    <!-- Comentarios Modernizados -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-body bg-light px-4 py-3 scroll-comentarios">
      <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center px-4 py-3">
        <h4 class="mb-0 text-dark"><i class="bi bi-chat-left-text me-2 text-info"></i>Comentarios</h4>
        <button class="btn btn-light btn-sm text-info fw-bold px-3 py-2" onclick="document.getElementById('nuevoComentarioModal').classList.remove('hidden')">
          <i class="bi bi-chat-left-text me-1"></i> Comentar
        </button>
      </div>

      <div class="card-body bg-light px-4 py-3">
        @if($historia->comentarios->count())
          @foreach ($historia->comentarios->where('parent_id', null) as $comentario)
            <div class="rounded-4 p-3 mb-3 bg-white shadow-sm">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <strong class="text-dark fs-6">{{ optional($comentario->user)->name ?? 'Usuario eliminado' }}</strong>
                  <small class="text-muted ms-2">{{ $comentario->created_at->diffForHumans() }}</small>
                </div>
                @if(Auth::id() === $comentario->user_id)
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary px-2 py-1" onclick="document.getElementById('editarComentarioModal{{ $comentario->id }}').classList.remove('hidden')">
                      <i class="bi bi-pencil-square fs-5"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteComentario{{ $comentario->id }}">
                      <i class="bi bi-trash fs-5"></i>
                    </button>
                  </div>
                @endif
              </div>

              <p class="mb-3 text-secondary">{{ $comentario->contenido }}</p>

              <!-- BOTÓN Y FORMULARIO DE RESPUESTA EN LÍNEA -->
              <button class="btn btn-sm btn-outline-info" onclick="document.getElementById('form-responder-{{ $comentario->id }}').classList.toggle('d-none')">
                <i class="bi bi-reply-fill me-1"></i> Responder
              </button>
              <div id="form-responder-{{ $comentario->id }}" class="mt-3 d-none">
                  <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                      @csrf
                      <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                      <textarea name="contenido" class="form-control rounded-4 border shadow-sm p-3 mb-2" rows="3" placeholder="Escribe tu respuesta..." required></textarea>
                      <div class="d-flex justify-content-end gap-2">
                          <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('form-responder-{{ $comentario->id }}').classList.add('d-none')">Cancelar</button>
                          <button type="submit" class="btn btn-primary btn-sm">
                              <i class="bi bi-send-fill me-1"></i> Publicar
                          </button>
                      </div>
                  </form>
              </div>
              <!-- FIN RESPUESTA EN LÍNEA -->

              {{-- RESPUESTAS --}}
              @foreach ($comentario->respuestas as $respuesta)
                  <div class="mt-3 ms-4 p-3 rounded-3 shadow-sm respuesta-celeste">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <strong class="text-dark">{{ optional($respuesta->user)->name ?? 'Usuario eliminado' }}</strong>
                      <small class="text-muted ms-2">{{ $respuesta->created_at->diffForHumans() }}</small>
                    </div>
                    @if(Auth::id() === $respuesta->user_id)
                      <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary px-2 py-1" onclick="document.getElementById('editarComentarioModal{{ $respuesta->id }}').classList.remove('hidden')">
                          <i class="bi bi-pencil-square fs-5"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteRespuesta{{ $respuesta->id }}">
                          <i class="bi bi-trash fs-5"></i>
                        </button>
                      </div>
                    @endif
                  </div>
                  <p class="text-secondary mt-2 mb-0">{{ $respuesta->contenido }}</p>

                  <!-- Modal Editar Respuesta -->
<div id="editarComentarioModal{{ $respuesta->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-4 shadow-lg w-full max-w-3xl p-6">
    <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-4 text-center">
        <i class="bi bi-pencil-square text-warning fs-1"></i>
        <h4 class="fw-bold text-dark">Editar Respuesta</h4>
        <p class="text-muted">Puedes modificar tu respuesta aquí.</p>
      </div>
      <textarea name="contenido" class="form-control rounded-4 border border-warning shadow-sm p-4 w-full mb-4" rows="6" required>{{ $respuesta->contenido }}</textarea>
      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="this.closest('.fixed').classList.add('hidden')">Cancelar</button>
        <button type="submit" class="btn btn-primary text-white">
          <i class="bi bi-save-fill me-1"></i> Actualizar
        </button>
      </div>
    </form>
  </div>
</div>

                  <!-- Modal Confirmar Eliminar Respuesta -->
                  <div class="modal fade" id="confirmDeleteRespuesta{{ $respuesta->id }}" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content rounded-4 shadow">
                        <div class="modal-header border-bottom-0">
                          <h5 class="modal-title text-danger">Confirmar Eliminación</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                          <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                          <p class="mt-3">¿Estás seguro de que deseas eliminar esta respuesta?</p>
                          <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('comentarios.destroy', $respuesta) }}" method="POST">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

              <!-- Modal Editar Comentario -->
              <div id="editarComentarioModal{{ $comentario->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-4 shadow-lg w-full max-w-3xl p-6">
    <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
      @csrf @method('PUT')
      <div class="mb-4 text-center">
        <i class="bi bi-pencil-square text-warning fs-1"></i>
        <h4 class="fw-bold text-dark">Editar Comentario</h4>
        <p class="text-muted">Puedes actualizar tu comentario si deseas.</p>
      </div>
      <textarea name="contenido" class="form-control rounded-4 border border-warning shadow-sm p-4 w-full mb-4" rows="6" required>{{ $comentario->contenido }}</textarea>
      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="this.closest('.fixed').classList.add('hidden')">Cancelar</button>
        <button type="submit" class="btn btn-primary text-white">
          <i class="bi bi-save-fill me-1"></i> Actualizar
        </button>
      </div>
    </form>
  </div>
</div>

              <!-- Modal Confirmar Eliminar Comentario -->
              <div class="modal fade" id="confirmDeleteComentario{{ $comentario->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content rounded-4 shadow">
                    <div class="modal-header border-bottom-0">
                      <h5 class="modal-title text-danger">Confirmar Eliminación</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                      <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                      <p class="mt-3">¿Estás seguro de que deseas eliminar este comentario?</p>
                      <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST">
                          @csrf @method('DELETE')
                          <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          @endforeach
        @else
          <p class="text-muted text-center">No hay comentarios aún.</p>
        @endif
      </div>
    </div>

 <!-- Modal Nuevo Comentario -->
<div id="nuevoComentarioModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white border-0 rounded-4 shadow-lg w-full max-w-3xl p-6" style="background-color: #f9fafb;">
    <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
      @csrf
      <div class="mb-4 text-center">
        <i class="bi bi-chat-left-text-fill text-primary fs-1"></i>
        <h4 class="fw-bold mb-0 text-dark">Nuevo Comentario</h4>
        <p class="text-muted">Participa compartiendo tu opinión o experiencia.</p>
      </div>
      <div class="form-group mb-4">
        <textarea name="contenido" id="contenido" class="form-control rounded-4 border border-info shadow-sm p-4 w-full" rows="6" placeholder="Escribe tu comentario aquí..." required></textarea>
      </div>
      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="document.getElementById('nuevoComentarioModal').classList.add('hidden')">Cancelar</button>
        <button type="submit" class="btn btn-primary text-white rounded-3 px-4 py-2">
          <i class="bi bi-send-fill me-1"></i> Publicar
        </button>
      </div>
    </form>
  </div>
</div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.toggle-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);

                const isVisible = target.style.display === 'block';

                // Cierra todos los acordeones principales
                document.querySelectorAll('.contenido-acordeon').forEach(section => {
                    section.style.display = 'none';
                });

                if (!isVisible) {
                    target.style.display = 'block';
                    localStorage.setItem('acordeonAbierto', targetId);
                } else {
                    localStorage.removeItem('acordeonAbierto');
                }
            });
        });

        // Abre acordeón guardado
        const acordeonGuardado = localStorage.getItem('acordeonAbierto');
        if (acordeonGuardado) {
            const target = document.getElementById(acordeonGuardado);
            if (target) {
                target.style.display = 'block';
            }
        }

        // SOLO UNA tarea puede estar abierta a la vez
        window.toggleTarea = function (button) {
            const currentContent = button.nextElementSibling;

            // Cerrar todas las demás tareas
            document.querySelectorAll('.contenido-tarea').forEach(content => {
                if (content !== currentContent) {
                    content.style.display = 'none';
                }
            });

            // Abrir o cerrar la actual
            if (currentContent && currentContent.classList.contains('contenido-tarea')) {
                const isOpen = currentContent.style.display === 'block';
                currentContent.style.display = isOpen ? 'none' : 'block';
            }
        };
    });
</script>

<script>
    function actualizarBarraProgreso() {
        const checkboxes = document.querySelectorAll('.tarea-checkbox');
        const total = checkboxes.length;
        const completadas = [...checkboxes].filter(cb => cb.checked).length;
        const porcentaje = total > 0 ? Math.round((completadas / total) * 100) : 0;

        const progressBar = document.getElementById('progress-bar');
        if (progressBar) {
            progressBar.style.width = porcentaje + '%';
            progressBar.setAttribute('aria-valuenow', porcentaje);
            progressBar.textContent = porcentaje + '%';
        }
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('tarea-checkbox')) {
            const checkbox = e.target;
            const tareaId = checkbox.dataset.id;
            const estaMarcado = checkbox.checked;

            // Enviar al backend
            fetch(`/tareas/${tareaId}/completar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            }).then(response => {
                if (response.ok) {
                    actualizarBarraProgreso();

                    // Sincroniza TODOS los checkboxes con ese ID
                    document.querySelectorAll(`.tarea-checkbox[data-id="${tareaId}"]`).forEach(cb => {
                        cb.checked = estaMarcado;
                    });
                } else {
                    alert('Error al guardar el progreso.');
                    checkbox.checked = !checkbox.checked;
                }
            });
        }
    });

    window.addEventListener('DOMContentLoaded', actualizarBarraProgreso);
</script>

@endsection