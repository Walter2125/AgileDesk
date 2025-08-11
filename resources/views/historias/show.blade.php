@extends('layouts.app')

       @section('title','Detalle de Historia')
         @section('mensaje-superior')
        <div class="mt-4 text-lg font-semibold text-blue-600">
            <h1 class="titulo-historia">Detalle de la Historia</h1>
        </div>
    @endsection


@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

   
        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-2 shadow-md">
                {{ session('success') }}
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        setTimeout(function () {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }, 3000);
                    }
                });
            </script>
        @endif
   


    

    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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
       

<div class="container-fluid-m-2 mi-container m-2">
   
<div class="card-body">

         <form id="formHistoria" action="{{ route('historias.update', $historia->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PATCH')

    <div class="mb-4 d-flex justify-content-between align-items-center rounded">
        <div class="mb-0" style="max-width: 600px; width: 100%;">
            <h2 id="tituloTexto" class="historia-title rounded"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                title="{{ $historia->nombre }}">
                H{{ $historia->numero }} <span id="nombreTexto">{{ $historia->nombre }}</span>
            </h2>

            <input id="tituloInput" type="text" name="nombre" maxlength="100"
                class="form-control form-control-lg rounded d-none"
                value="{{ old('nombre', $historia->nombre) }}"
                data-editable="true"
                style="font-weight: bold;"  />
        </div>

        <div class="d-flex align-items-center">
            <div id="dropdownMenuContainer" class="dropdown me-3">
                <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><button id="btnEditar" class="dropdown-item">Editar</button></li>
                    <li><a href="{{ route('tableros.show', $historia->proyecto_id) }}" class="dropdown-item">Atrás</a></li>
                    <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteHistoriaModal{{ $historia->id }}">Borrar</button></li>
                    <li><a href="{{ route('tareas.show', $historia->id) }}" class="dropdown-item">Lista de Tareas</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label rounded">Asignado a</label>
      

                <select name="usuario_id" class="form-control rounded" data-editable="true" disabled>
                    <option value="">-- Seleccionar usuario --</option>
    @foreach($usuarios as $usuario)
        <option value="{{ $usuario->id }}" {{ old('usuario_id', $historia->usuario_id) == $usuario->id ? 'selected' : '' }}>
            {{ $usuario->name }}
        </option>
    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label rounded">Estado</label>
                <select name="columna_id" class="form-control rounded" data-editable="true" disabled>
                    <option value="">Sin Estado</option>
                    @foreach ($columnas as $columna)
                        <option value="{{ $columna->id }}" {{ old('columna_id', $historia->columna_id) == $columna->id ? 'selected' : '' }}>
                            {{ $columna->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label rounded">Prioridad</label>
                <select name="prioridad" class="form-control rounded" data-editable="true" disabled>
                    <option value="Alta" {{ old('prioridad', $historia->prioridad) == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Media" {{ old('prioridad', $historia->prioridad) == 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Baja" {{ old('prioridad', $historia->prioridad) == 'Baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label rounded">Horas estimadas</label>
                <input type="number" class="form-control rounded" name="trabajo_estimado"
                    value="{{ old('trabajo_estimado', $historia->trabajo_estimado) }}"
                    data-editable="true" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label rounded">Sprint</label>
                <select name="sprint_id" class="form-control rounded" data-editable="true" disabled>
                    <option value="">Ningún Sprint</option>
                    @foreach ($sprints as $sprint)
                        <option value="{{ $sprint->id }}" {{ old('sprint_id', $historia->sprint_id) == $sprint->id ? 'selected' : '' }}>
                            {{ $sprint->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label rounded">Última modificación</label>
                <input type="text" class="form-control rounded"
                    value="{{ $historia->updated_at->format('d/m/Y - H:i') }}"
                    readonly>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea class="form-control" name="descripcion"
             maxlength="5000"
            data-editable="true" rows="4" readonly>{{ old('descripcion', $historia->descripcion) }}</textarea>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <button id="btnGuardar" type="submit"
            class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case d-none">
            Actualizar
        </button>
    </div>
</form>

<form action="{{ route('historias.destroy', $historia->id) }}" method="post">
    @csrf
    @method('DELETE')
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
     document.querySelectorAll('textarea[readonly]').forEach(textarea => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });
        const btnEditar = document.getElementById('btnEditar');
        const btnGuardar = document.getElementById('btnGuardar');
        const tituloTexto = document.getElementById('tituloTexto');
        const tituloInput = document.getElementById('tituloInput');
        const editableFields = document.querySelectorAll('[data-editable="true"]');
        const dropdownMenuContainer = document.getElementById('dropdownMenuContainer');

        btnEditar.addEventListener('click', function (e) {
            e.preventDefault();
            tituloTexto.classList.add('d-none');
            tituloInput.classList.remove('d-none');
            editableFields.forEach(field => {
                field.removeAttribute('readonly');
                field.removeAttribute('disabled');
              if (field.tagName === 'TEXTAREA') {
            field.style.height = 'auto';
            field.style.height = field.scrollHeight + 'px';
        }
    });
            btnGuardar.classList.remove('d-none');
            if (dropdownMenuContainer) {
                dropdownMenuContainer.classList.add('d-none');
            }
        });

        const form = document.getElementById('formHistoria');
        form.addEventListener('submit', function () {
            console.log('Formulario enviado');
        });
    });
</script>




       
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
                            
                   {{-- 🔽 ACORDEÓN DE TAREAS Y COMENTARIOS (UNO A LA VEZ, A PANTALLA COMPLETA) --}}
<div class="mt-5">
    {{-- BOTÓN: TAREAS RELACIONADAS --}}
    <div class="mb-3 border rounded">
        <button class="w-100 text-start fw-bold p-3 bg-light toggle-btn" data-target="tareas-acordeon" type="button">
            Tareas relacionadas
        </button>

        <div id="tareas-acordeon" class="contenido-acordeon" style="display: none;">
            @if($tareas->isEmpty())
                <div class="alert alert-warning m-3">No hay tareas registradas para esta historia.</div>
            @else
                <div class="accordion m-3" id="accordionListaTareas">
                    @foreach($tareas as $tarea)
                        <div class="accordion-item mb-4 p-3 rounded shadow-sm border-0 bg-white hover-card">
                            <button class="accordion-button collapsed bg-white rounded-top d-flex align-items-center" type="button"
                                    onclick="toggleTarea(this)">
                                <input type="checkbox"
                                       class="form-check-input me-3 tarea-checkbox"
                                       data-id="{{ $tarea->id }}"
                                       {{ $tarea->completada ? 'checked' : '' }}
                                       onclick="event.stopPropagation();">

                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $tarea->nombre }}</h6>
                                </div>
                            </button>

                            <div class="contenido-tarea bg-light p-4 rounded-bottom" style="display: none;">
                                <p class="mb-2">
                                    <strong>Descripción:</strong> {{ $tarea->descripcion }}
                                </p>

                                <p class="mb-2">
                                    <strong>Fecha de creación:</strong> {{ $tarea->created_at->format('d/m/Y H:i') }}
                                </p>

                                <p class="mb-2">
                                    <strong>Tipo de actividad:</strong>
                                    <span class="badge px-3 py-2 rounded-pill text-white" style="background-color: #6f42c1;">
                                        <i class="bi bi-lightning-charge me-1"></i>{{ $tarea->actividad }}
                                    </span>
                                </p>

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('tareas.edit', [$historia->id, $tarea->id]) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <!-- Botón Eliminar con modal -->
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tarea->id }}" title="Eliminar">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal estilizado de confirmación -->
                        <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <div class="mb-4">
                                            <h5 class="modal-title text-danger" id="deleteModalLabel{{ $tarea->id }}">Confirmar Eliminación</h5>
                                            <h5 class="modal-title text-danger">¿Deseas eliminar esta tarea?</h5>

                                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 3rem;"></i>

                                            <div class="alert alert-danger d-flex align-items-center mt-3">
                                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                                <div>
                                                    "<strong>{{ $tarea->nombre }}</strong>" será eliminada permanentemente.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-4 align-items-center mb-3">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
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
            @endif

            {{-- Botones finales --}}
            <div class="ms-3 mb-3">
                <a href="{{ route('tareas.index', $historia->id) }}"
                   class="inline-flex items-center justify-center w-10 h-10 text-blue-600 border border-blue-600 rounded-full bg-white hover:bg-blue-100 transition duration-300"
                   title="Ver tareas">
                    <span class="text-2xl font-bold">+</span>
                </a>

                <a href="{{ route('tareas.show', $historia->id) }}"
                   class="inline-flex items-center justify-center w-10 h-10 text-blue-600 border border-blue-600 rounded-full hover:bg-blue-100 transition duration-300 ms-2"
                   title="Ver lista de tareas">
                    <i class="bi bi-eye text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</div>

 {{-- BOTÓN: COMENTARIOS --}}
<div class="mb-0">
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

              <button class="btn btn-sm btn-outline-info" onclick="document.getElementById('responderComentarioModal{{ $comentario->id }}').classList.remove('hidden')">
                <i class="bi bi-reply-fill me-1"></i> Responder
              </button>

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
                    <div class="bg-white rounded-4 shadow-lg w-full max-w-2xl p-6">
                      <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="flex items-center mb-4">
                          <i class="bi bi-pencil-square text-warning fs-2 me-3"></i>
                          <div>
                            <h4 class="fw-bold text-dark mb-0">Editar Respuesta</h4>
                            <small class="text-muted">Puedes modificar tu respuesta aquí.</small>
                          </div>
                        </div>
                        <textarea name="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full mb-4" rows="5" required>{{ $respuesta->contenido }}</textarea>
                        <div class="flex justify-end gap-2">
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

              <!-- Modal Responder -->
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
                      <button type="button" class="btn btn-outline-secondary" onclick="this.closest('.fixed').classList.add('hidden')">Cancelar</button>
                      <button type="submit" class="btn btn-primary text-white">
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
                    @csrf @method('PUT')
                    <div class="flex items-center mb-4">
                      <i class="bi bi-pencil-square text-warning fs-2 me-3"></i>
                      <div>
                        <h4 class="fw-bold text-dark mb-0">Editar Comentario</h4>
                        <small class="text-muted">Puedes actualizar tu comentario si deseas.</small>
                      </div>
                    </div>
                    <textarea name="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full mb-4" rows="5" required>{{ $comentario->contenido }}</textarea>
                    <div class="flex justify-end gap-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('historias.show', $historia->id) }}'"> CancelarS</button>  
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
      <div class="bg-white border-0 rounded-4 shadow-lg w-full max-w-2xl p-6" style="background-color: #f9fafb;">
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
            <textarea name="contenido" id="contenido" class="form-control rounded-4 border-0 shadow-sm p-3 w-full" rows="5" placeholder="Escribe tu comentario aquí..." required></textarea>
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

@endsection