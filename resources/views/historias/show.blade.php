@extends('layouts.app')

@section('title')
       @section('title')
         @section('mensaje-superior')
            Detalle de Historia 
        @endsection
    

@section('content')


<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

<div class="container-fluid-m-2 mi-container m-2">

             @if (session('success'))
                <div class="alert alert-success mt-2" id="success-alert">
                    {{ session('success') }}
                </div>

                <script>
                    setTimeout(function() {
                        const alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            @endif

            <div class="historia-container-fluid">

                
    <div class="historia-header">
        <h2 class="historia-title"
            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; display: block;"
            title="{{ $historia->nombre }}">
            H{{ $historia->numero }} {{  $historia->nombre }}
        </h2>
      

                    <div class="historia-meta">
                        <span class="badge bg-primary">{{ $historia->prioridad }}</span>
                        <span class="badge bg-secondary">{{ $historia->trabajo_estimado }} horas</span>
                    </div>
                </div>

                <div class="historia-content">

                    </div>
                <div class="historia-section ">
                    <h3 class="section-title">Descripción</h3>
                    <div class="container" style="word-wrap: break-word; overflow-wrap: break-word;">
                        {{ $historia->descripcion }}
                    </div>
                </div>


        <div class="historia-details">
            <div class="detail-item">
                <span class="detail-label">Estado:</span>
           <span class="detail-value">{{ $historia->columna ? $historia->columna->nombre : 'Sin estado asignado' }}</span>            </div>
            <div class="detail-item">
                <span class="detail-label">Sprint:</span>
                <span class="detail-value">{{ $historia->sprint ?? 'No asignado' }}</span>
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
        <a href="{{ route('tareas.show', $historia->id) }}"
               class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
               style="background-color: #e6f2ff;">
                 Agregar Tareas
            </a>



            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('tableros.show', $historia->proyecto_id) }}" class="btn btn-secondary">Atrás</a>

                <a href="{{ route('historias.edit', $historia->id) }}" class="btn btn-primary ms-2">Editar</a>

                <form action="{{ route('historias.destroy', $historia->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $historia->id }}">Borrar</button>
                </form>
    </div>
</div>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="confirmDeleteModal{{ $historia->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $historia->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel{{ $historia->id }}">¿Desea eliminar esta historia?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                Se eliminará la historia "<strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 300px;" title="{{ $historia->nombre }}">
                                    {{ $historia->nombre }}
                                </strong>".
                                Esta acción no se puede deshacer.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- 🔽 NUEVA SECCIÓN: Comentarios Modernizados -->
<div class="card mt-5 shadow border-0 rounded-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center px-4 py-3">
        <h4 class="mb-0 text-dark"><i class="bi bi-chat-left-text me-2 text-info"></i>Comentarios</h4>
        <button class="btn btn-light btn-sm text-info fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#nuevoComentarioModal">
            <i class="bi bi-chat-left-text me-1"></i> Comentar
        </button>
    </div>

    <div class="card-body bg-light p-4">
        @if($historia->comentarios->count())
            @foreach ($historia->comentarios->where('parent_id', null) as $comentario)
                <div class="border rounded-4 p-4 mb-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong class="text-dark fs-6">{{ optional($comentario->user)->name ?? 'Usuario eliminado' }}</strong>
                            <small class="text-muted ms-2">{{ $comentario->created_at->diffForHumans() }}</small>
                        </div>
                        @if(Auth::id() === $comentario->user_id)
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary px-2 py-1" data-bs-toggle="modal" data-bs-target="#editarComentarioModal{{ $comentario->id }}">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </button>
                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este comentario?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger px-2 py-1">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <p class="mb-3 text-secondary">{{ $comentario->contenido }}</p>

                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#responderComentarioModal{{ $comentario->id }}">
                        <i class="bi bi-reply-fill me-1"></i> Responder
                    </button>

                    @foreach ($comentario->respuestas as $respuesta)
                        <div class="mt-3 ms-5 p-3 rounded-3 bg-white shadow-sm border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-primary">{{ optional($respuesta->user)->name ?? 'Usuario eliminado' }}</strong>
                                    <small class="text-muted ms-2">{{ $respuesta->created_at->diffForHumans() }}</small>
                                </div>
                                @if(Auth::id() === $respuesta->user_id)
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary px-2 py-1" data-bs-toggle="modal" data-bs-target="#editarComentarioModal{{ $respuesta->id }}">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </button>
                                        <form action="{{ route('comentarios.destroy', $respuesta) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta respuesta?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger px-2 py-1">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <p class="text-secondary mt-2 mb-0">{{ $respuesta->contenido }}</p>
                        </div>

                        <!-- Modal Editar Respuesta -->
                        <div class="modal fade" id="editarComentarioModal{{ $respuesta->id }}" tabindex="-1">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content shadow-lg rounded-3">
                                    <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-white rounded-top-3">
                                            <h5 class="modal-title">Editar Respuesta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="contenido" class="form-control" rows="3" required>{{ $respuesta->contenido }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Actualizar</button>
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal de Responder -->
                <div class="modal fade" id="responderComentarioModal{{ $comentario->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg p-0" style="background-color: #f9fafb;">
            <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                <div class="p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="bi bi-reply-fill text-info fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Responder Comentario</h4>
                            <small class="text-muted">Escribe una respuesta para este comentario.</small>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="respuesta{{ $comentario->id }}" class="form-label text-dark fw-semibold">Tu Respuesta</label>
                        <textarea name="contenido"
                                  id="respuesta{{ $comentario->id }}"
                                  class="form-control rounded-4 border-0 shadow-sm p-3"
                                  rows="5"
                                  placeholder="Escribe tu respuesta aquí..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-success text-white rounded-3 px-4 py-2">
                            <i class="bi bi-send me-1"></i> Publicar Respuesta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Modal Editar Comentario -->
<div class="modal fade" id="editarComentarioModal{{ $comentario->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg p-0" style="background-color: #f9fafb;">
            <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="bi bi-pencil-square text-warning fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Editar Comentario</h4>
                            <small class="text-muted">Modifica tu comentario.</small>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="editarContenido{{ $comentario->id }}" class="form-label text-dark fw-semibold">Tu Comentario</label>
                        <textarea name="contenido"
                                  id="editarContenido{{ $comentario->id }}"
                                  class="form-control rounded-4 border-0 shadow-sm p-3"
                                  rows="5"
                                  placeholder="Edita tu comentario..." required>{{ $comentario->contenido }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning text-white rounded-3 px-4 py-2">
                            <i class="bi bi-pencil-square me-1"></i> Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Comentario -->
<div class="modal fade" id="nuevoComentarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg p-0" style="background-color: #f9fafb;">
            <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                @csrf
                <div class="p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="bi bi-chat-left-text-fill text-primary fs-2"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Nuevo Comentario</h4>
                            <small class="text-muted">Participa compartiendo tu opinión o experiencia.</small>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="contenido" class="form-label text-dark fw-semibold">Tu Comentario</label>
                        <textarea name="contenido"
                                  id="contenido"
                                  class="form-control rounded-4 border-0 shadow-sm p-3"
                                  rows="5"
                                  placeholder="Escribe tu comentario aquí..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary text-white rounded-3 px-4 py-2">
                            <i class="bi bi-send-fill me-1"></i> Publicar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 @endforeach <!-- Cierre del foreach de comentarios -->
    @endif <!-- Cierre del if que verifica si hay comentarios -->
</div> <!-- Cierre del card-body -->

    @endsection
