@extends('layouts.app')

       @section('title')
         @section('mensaje-superior')
        <div class="mt-4 text-lg font-semibold text-blue-300">
            <h1 class="titulo-historia">Detalle de la Historia</h1>
        </div>
    @endsection
            @endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

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

<div class="container-fluid-m-2 mi-container m-2">
            
        <div class="card-body">
               <div class="mb-4 d-flex justify-content-between align-items-center">
                
                    <h2 class="historia-title mb-0"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 1200px;"
                        title="{{ $historia->nombre }}">
                        H{{ $historia->numero }} {{ $historia->nombre }}
                    </h2>

                   
                    <div class="d-flex align-items-center">
                       
                        <div class="dropdown me-3">
                            <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li> <a href="{{ route('historias.edit', $historia->id) }}"class="dropdown-item">Editar</a></li>
                                <li><a href="{{ route('tableros.show', $historia->proyecto_id) }}" class="dropdown-item"> Atrás</a></li>
                                <li> <form action="{{ route('historias.destroy', $historia->id) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"class="dropdown-item"data-bs-toggle="modal"data-bs-target="#deleteHistoriaModal{{ $historia->id }}">Borrar</button></form></li>
                                <li><a href="{{ route('tareas.show', $historia->id) }}" class="dropdown-item" data-bs-toggle="tooltip" title="Crea una Tarea"><i class="bi bi-plus-lg"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Asignado a:</label>
                        <input type="text" class="form-control rounded" value="{{ $historia->usuario ? $historia->usuario->name : 'No asignado' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <input type="text" class="form-control rounded" 
                            value="{{ $historia->columna?->nombre ?? 'Sin estado asignado' }}" 
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prioridad</label>
                        <input type="text" class="form-control rounded" 
                            value="{{ $historia->prioridad }}" 
                            readonly>
                    </div>
                </div>

    
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Horas de trabajo estimadas*</label>
                        <input type="number" class="form-control form-control-sm rounded" value="{{ $historia->trabajo_estimado }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sprint</label>
                        <input type="text" class="form-control form-control-sm rounded" value="{{ $historia->sprint ?? 'No asignado' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Última modificación</label>
                        <input type="text" class="form-control form-control-sm rounded" 
                            value="{{ $historia->updated_at ? $historia->updated_at->format('d/m/Y - H:i') : 'No disponible' }}" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control border rounded  " rows="4" readonly> {{ $historia->descripcion }}</textarea>
                </div>


            </div>
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

                            
                
            



 <div class="container-md">
        <div class="container mt-4">
        <!-- 🔽 NUEVA SECCIÓN: Comentarios Modernizados -->
                <div class="card mt-5 shadow border-0 rounded-4">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center px-4 py-3">
                        <h4 class="mb-0 text-dark"><i class="bi bi-chat-left-text me-2 text-info"></i>Comentarios</h4>
                        <button class="btn btn-light btn-sm text-info fw-bold px-3 py-2" onclick="document.getElementById('nuevoComentarioModal').classList.remove('hidden')">
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
                                            <button class="btn btn-outline-secondary px-2 py-1" onclick="document.getElementById('editarComentarioModal{{ $comentario->id }}').classList.remove('hidden')">
                                                <i class="bi bi-pencil-square fs-5"></i>
                                            </button>
                                            <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar este comentario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteComentario{{ $comentario->id }}">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="modal fade" id="confirmDeleteComentario{{ $comentario->id }}" tabindex="-1" aria-labelledby="modalLabelComentario{{ $comentario->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title text-danger" id="modalLabelComentario{{ $comentario->id }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                                    <p class="mt-3">¿Estás seguro de que deseas eliminar este comentario?</p>
                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <p class="mb-3 text-secondary">{{ $comentario->contenido }}</p>

                                <button class="btn btn-sm btn-outline-info" onclick="document.getElementById('responderComentarioModal{{ $comentario->id }}').classList.remove('hidden')">
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
                                                    <button class="btn btn-outline-secondary px-2 py-1" onclick="document.getElementById('editarComentarioModal{{ $respuesta->id }}').classList.remove('hidden')">
                                                        <i class="bi bi-pencil-square fs-5"></i>
                                                    </button>
                                                    <form action="{{ route('comentarios.destroy', $respuesta) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta respuesta?')">
                                                    @csrf
                                                    @method('DELETE')
                                                        <button type="button" class="btn btn-outline-danger px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteRespuesta{{ $respuesta->id }}">
                                                            <i class="bi bi-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-secondary mt-2 mb-0">{{ $respuesta->contenido }}</p>
                                    </div>

                                    <!-- Modal Editar Respuesta -->
                                    <div id="editarComentarioModal{{ $respuesta->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                        <div class="bg-white rounded-4 shadow-lg w-full max-w-2xl p-6">
                                            <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="flex items-center mb-4">
                                                    <i class="bi bi-pencil-square text-warning fs-2 me-3"></i>
                                                    <div>
                                                        <h4 class="fw-bold text-dark mb-0">Editar Respuesta</h4>
                                                        <small class="text-muted">Puedes modificar tu respuesta aquí.</small>
                                                    </div>
                                                </div>
                                                <textarea name="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full mb-4" rows="5" required>{{ $respuesta->contenido }}</textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="this.closest('.fixed').classList.add('hidden')">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">
                                                        <i class="bi bi-save-fill me-1"></i> Actualizar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                </div>
                                    <div class="modal fade" id="confirmDeleteRespuesta{{ $respuesta->id }}" tabindex="-1" aria-labelledby="modalLabelRespuesta{{ $respuesta->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title text-danger" id="modalLabelRespuesta{{ $respuesta->id }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                                    <p class="mt-3">¿Estás seguro de que deseas eliminar esta respuesta?</p>
                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('comentarios.destroy', $respuesta) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <!-- Modal de Responder -->
                            <div id="responderComentarioModal{{ $comentario->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-4 shadow-lg w-full max-w-2xl p-6">
                                    <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                                        <div class="flex items-center mb-4">
                                            <i class="bi bi-reply-fill text-dark fs-2 me-3"></i>
                                            <div>
                                                <h4 class="fw-bold text-dark mb-0">Responder Comentario</h4>
                                                <small class="text-muted">Escribe tu respuesta a este comentario.</small>
                                            </div>
                                        </div>
                                        <textarea name="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full mb-4" rows="5" required></textarea>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="this.closest('.fixed').classList.add('hidden')">
                                                Cancelar
                                            </button>
                                            <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">
                                                <i class="bi bi-send-fill me-1"></i> Publicar Respuesta
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Editar Comentario -->
                            <div id="editarComentarioModal{{ $comentario->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                <div class="bg-white rounded-4 shadow-lg w-full max-w-2xl p-6">
                                    <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center mb-4">
                                            <i class="bi bi-pencil-square text-warning fs-2 me-3"></i>
                                            <div>
                                                <h4 class="fw-bold text-dark mb-0">Editar Comentario</h4>
                                                <small class="text-muted">Puedes actualizar tu comentario si deseas.</small>
                                            </div>
                                        </div>
                                        <textarea name="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full mb-4" rows="5" required>{{ $comentario->contenido }}</textarea>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="this.closest('.fixed').classList.add('hidden')">
                                                Cancelar
                                            </button>
                                            <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">
                                                <i class="bi bi-save-fill me-1"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @endforeach
                            <div class="modal fade" id="confirmDeleteComentario{{ $comentario->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $comentario->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header border-bottom-0">
                                                    <h5 class="modal-title text-danger" id="modalLabel{{ $comentario->id }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>
                                                    <p class="mt-3">¿Estás seguro de que deseas eliminar este comentario?</p>
                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                                @else
                                    <p class="text-muted text-center">No hay comentarios aún.</p>
                                @endif
                    </div>
                </div>

<!-- Modal Nuevo Comentario -->
                <div id="nuevoComentarioModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white border-0 rounded-4 shadow-lg w-full max-w-2xl p-6" style="Sbackground-color: #f9fafb;">
                        <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                            @csrf
                            <div class="flex items-center mb-4">
                                <i class="bi bi-chat-left-text-fill text-primary fs-2 me-3"></i>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">Nuevo Comentario</h4>
                                    <small class="text-muted">Participa compartiendo tu opinión o experiencia.</small>
                                </div>
                            </div>
                                        <div class="form-group mb-4">
                                            <label for="contenido" class="form-label text-dark fw-semibold">Tu Comentario</label>
                                            <textarea name="contenido"
                                                    id="contenido"
                                                    class="form-control rounded-4 border-0 shadow-sm p-3 w-full"
                                                    rows="5"
                                                    placeholder="Escribe tu comentario aquí..." required></textarea>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white mr-3 normal-case" onclick="document.getElementById('nuevoComentarioModal').classList.add('hidden')">
                                                Cancelar
                                            </button>
                                            <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">
                                                <i class="bi bi-send-fill me-1"></i> Publicar
                                            </button>
                                        </div>
                                </form>
                            </div>
                </div>

<!-- Modal Nuevo Comentario -->
            <div id="nuevoComentarioModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white border-0 rounded-4 shadow-lg w-full max-w-2xl p-6" style="Sbackground-color: #f9fafb;">
                    <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center mb-4">
                            <i class="bi bi-chat-left-text-fill text-primary fs-2 me-3"></i>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">Nuevo Comentario</h4>
                                <small class="text-muted">Participa compartiendo tu opinión o experiencia.</small>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="contenido" class="form-label text-dark fw-semibold">Tu Comentario</label>
                            <textarea name="contenido"
                                    id="contenido"
                                    class="form-control rounded-4 border-0 shadow-sm p-3 w-full"
                                    rows="5"
                                    placeholder="Escribe tu comentario aquí..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="document.getElementById('nuevoComentarioModal').classList.add('hidden')">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary text-white rounded-3 px-4 py-2">
                                <i class="bi bi-send-fill me-1"></i> Publicar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
               
</div> 
</div>
</div>

@endsection