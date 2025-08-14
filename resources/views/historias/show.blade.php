@extends('layouts.app')

       @section('title','Detalle de Historia')
        @section('mensaje-superior')
            Detalles de la Historia
        @endsection

@section('styles')
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .container-fluid {
        background-color: #ffffff;
        color: #000000;
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .historia-header {
            flex-direction: column;
            gap: 15px;
        }
        
        .historia-header .titulo-container {
            max-width: 100% !important;
            width: 100% !important;
        }
        
        .historia-header .actions-container {
            align-self: flex-end;
            width: auto;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem 0.5rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        color: #000000;
    }

    .card-body {
        background-color: #ffffff;
        color: #000000;
    }

    .form-label {
        color: #000000;
        font-weight: 600;
    }

    .form-control {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        background-color: #ffffff;
        color: #000000;
        border-color: #86b7fe;
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-primary {
        color: #0d6efd;
        border-color: #0d6efd;
        background-color: transparent;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .btn-outline-warning {
        color: #fd7e14;
        border-color: #fd7e14;
        background-color: transparent;
    }

    .btn-outline-warning:hover {
        background-color: #fd7e14;
        border-color: #fd7e14;
        color: #ffffff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        background-color: transparent;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .btn-outline-info {
        color: #0dcaf0;
        border-color: #0dcaf0;
        background-color: transparent;
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
        background-color: transparent;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #212529;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #000000;
    }

    .text-dark {
        color: #212529 !important;
    }

    .text-secondary {
        color: #6c757d !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .bg-white {
        background-color: #ffffff !important;
    }

    .historia-title {
        color: #000000;
        font-weight: bold;
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .respuesta-celeste {
        background-color: #e0f7fa !important;
    }

    .scroll-comentarios {
        max-height: 500px;
        overflow-y: auto;
    }

    /* Modal layering tuned for Admin sidebar (use Bootstrap defaults as much as possible) */
    .modal { z-index: 2050; }
    .modal-backdrop { z-index: 2040; }
    .modal-content { background-color: #ffffff; color: #000000; }
    .modal-dialog { margin: 1.75rem auto; }
    @media (max-width: 576px) {
        .modal-dialog { margin: 0.5rem; }
        .modal-lg { max-width: calc(100vw - 1rem); }
    }

    .accordion-button {
        background-color: #ffffff !important;
        color: #000000 !important;
        border: none !important;
    }

    .accordion-button:not(.collapsed) {
        background-color: #ffffff !important;
        color: #000000 !important;
    }

    .accordion-item {
        background-color: #ffffff !important;
        border: 1px solid #dee2e6 !important;
    }

    .contenido-tarea {
        background-color: #f8f9fa !important;
        color: #000000 !important;
    }

    .toggle-btn {
        background-color: #f8f9fa !important;
        color: #000000 !important;
        border: 1px solid #dee2e6 !important;
    }

    .toggle-btn:hover {
        background-color: #e9ecef !important;
        color: #000000 !important;
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

<style>
.descripcion-tarea {
    display: block;
    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
  }
 </style>   
 
@endsection


@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

@endpush
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

   
@if (session('success'))
        <div id="success-alert" 
          class="alert alert-success alert-dismissible fade show mt-2" 
          style="background-color: #d1e7dd; color: #0f5132; display: flex; align-items: center; justify-content: space-between;">
          
          <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i class="bi bi-check-circle me-2"></i>
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
          </div>
      </div>
        @endif
   
   @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> <!-- aquí ya se reemplazan :min, :max automáticamente -->
            @endforeach
        </ul>
    </div>
@endif


<div class="container-fluid-m-2 mi-container m-2">
   
<div class="card-body">


         
<form id="formHistoria" action="{{ route('historias.update', $historia->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PATCH')
    <div class="row mb-3">

                <div class="mb-4 d-flex justify-content-between align-items-center rounded gap-2">
                    <div class="flex-grow-1" style="min-width: 0; font-weight: bold;">
                        <label class="form-label rounded">Nombre de la Historia</label>
                        <h2 id="tituloTexto" class="historia-title rounded m-0 text-truncate"
                            title="{{ $historia->nombre }}">
                            H{{ $historia->numero }} <span id="nombreTexto">{{ $historia->nombre }}</span>
                        </h2>
                        <input id="tituloInput" type="text" name="nombre" maxlength="100"
                              class="form-control formulario-editable rounded d-none"
                              value="{{ old('nombre', $historia->nombre) }}"
                              data-editable="true" />
                    </div>

                    <div class="flex-shrink-0">
                        <div id="dropdownMenuContainer" class="dropdown">
                            <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
    <li><button id="btnEditar" class="dropdown-item">Editar</button></li>
    <li><a href="{{ route('tableros.show', $historia->proyecto_id) }}" class="dropdown-item">Atrás</a></li>
    <li>
        <button type="button" 
                class="dropdown-item " 
                data-bs-toggle="modal"
                data-bs-target="#deleteHistoriaModal"
                data-historia-id="{{ $historia->id }}" 
                data-historia-nombre="{{ $historia->nombre }}">
             Eliminar
        </button>
    </li>
    <li><a href="{{ route('tareas.show', $historia->id) }}" class="dropdown-item">Lista de Tareas</a></li>
</ul>
                        </div>
                    </div>
                </div>
        <div class="col-lg-6 col-md-12 ">
       
          
            <div class="mb-3">
                <label class="form-label rounded">Asignado a</label>
      

                   <select name="usuario_id" class="form-control formulario-editable" data-editable="true" disabled>
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
                <select name="columna_id" class="form-control formulario-editable" data-editable="true" disabled>
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
                 <select name="prioridad" class="form-control formulario-editable" data-editable="true" disabled>
                    <option value="Alta" {{ old('prioridad', $historia->prioridad) == 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Media" {{ old('prioridad', $historia->prioridad) == 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Baja" {{ old('prioridad', $historia->prioridad) == 'Baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="mb-3">
                <label class="form-label rounded">Horas estimadas</label>
                <input type="number" class="form-control formulario-editable" name="trabajo_estimado"
                    value="{{ old('trabajo_estimado', $historia->trabajo_estimado) }}"
                    data-editable="true" readonly>
                    
                    
            </div>

            <div class="mb-3">
                <label class="form-label rounded">Sprint</label>
                <select name="sprint_id" class="form-control formulario-editable" data-editable="true" disabled >
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
                <input type="text" class="form-control formulario-editable"
                    value="{{ $historia->updated_at->format('d/m/Y - H:i') }}"
                    readonly>
            </div>
        </div>
                <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control formulario-editable" name="descripcion"
                    maxlength="5000"
                    data-editable="true" rows="4" readonly>{{ old('descripcion', $historia->descripcion) }}</textarea>
                 </div>
            <div class="d-flex justify-content-end mb-3">
            <button id="btnCancelar" type="button" class="btn btn-secondary d-none">
                <i class="bi bi-x-lg me-2"></i> Cancelar
            </button>
    
            <button id="btnGuardar" type="submit" class="btn btn-primary ms-2 d-none">
                <i class="bi bi-arrow-repeat me-2"></i> Actualizar</button>
        
            </div>
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



<!-- Modal para confirmar eliminación de historia -->
<div class="modal fade" id="deleteHistoriaModal" tabindex="-1" aria-labelledby="deleteHistoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center"> <!-- Centramos todo -->
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="deleteHistoriaModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p id="deleteHistoriaText">¿Está seguro de que desea eliminar esta historia?</p>
            </div>
            <div class="modal-footer justify-content-center"> <!-- Botones centrados -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteHistoriaModal = document.getElementById('deleteHistoriaModal');
    const deleteHistoriaForm = document.getElementById('deleteHistoriaForm');
    const deleteHistoriaText = document.getElementById('deleteHistoriaText');

    deleteHistoriaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const historiaId = button.getAttribute('data-historia-id');
        const historiaNombre = button.getAttribute('data-historia-nombre') || '';

        deleteHistoriaText.textContent = `¿Está seguro de que desea eliminar la historia "${historiaNombre}"?`;
        deleteHistoriaForm.action = `/historias/${historiaId}`;
    });
});
</script>
@endpush

{{-- ACORDEÓN DE TAREAS Y COMENTARIOS --}}
<div class="mb-0">
    {{-- BOTÓN: TAREAS RELACIONADAS --}}
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
                                    <span style="color: #555; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
                                        {{ $tarea->descripcion }}
                                    </span>
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
                                    <button class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteTareaModal"
                                    data-tarea-id="{{ $tarea->id }}"
                                    data-tarea-nombre="{{ $tarea->nombre }}"
                                    title="Eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para confirmar eliminación de tarea -->
<div class="modal fade" id="deleteTareaModal" tabindex="-1" aria-labelledby="deleteTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center"> <!-- Centramos todo -->
            
            <div class="modal-header justify-content-center position-relative">
                <h5 class="modal-title fs-4 fw-bold" id="deleteTareaModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
                <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p id="deleteTareaText">¿Está seguro de que desea eliminar esta tarea?</p>
            </div>

            <div class="modal-footer justify-content-center"> <!-- Botones centrados -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('tareas.destroy', [$historia->id, $tarea->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Eliminar Permanentemente
                    </button>
                </form>
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
       class="btn btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center me-2"
       style="width: 40px; height: 40px;"
       title="Crear tarea">
        <i class="bi bi-plus-lg"></i>
    </a>

    @if($tareas->isEmpty())
        {{-- Si no hay tareas, que el ojito vaya al index --}}
        <a href="{{ route('tareas.index', $historia->id) }}"
           class="btn btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;"
           title="Ver lista de tareas">
            <i class="bi bi-eye"></i>
        </a>
    @else
        {{-- Si hay tareas, que el ojito vaya al show --}}
        <a href="{{ route('tareas.show', [$historia->id, $tareas->first()->id]) }}"
           class="btn btn-outline-primary rounded-circle d-inline-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;"
           title="Ver lista de tareas">
            <i class="bi bi-eye"></i>
        </a>
    @endif
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

    <!-- Comentarios -->
    <div class="card shadow border-0 rounded-4">
      <div class="card-body bg-light px-4 py-3 scroll-comentarios">

        <!-- Encabezado -->
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center px-4 py-3">
          <h4 class="mb-0 text-dark">
            <i class="bi bi-chat-left-text me-2 text-info"></i> Comentarios
          </h4>
          <button class="btn btn-light btn-sm text-info fw-bold px-3 py-2"
            onclick="document.getElementById('nuevoComentarioModal').classList.remove('d-none')">
            <i class="bi bi-chat-left-text me-1"></i> Comentar
          </button>
        </div>

        <!-- Lista de Comentarios -->
        <div class="card-body bg-light px-4 py-3">
          @if($historia->comentarios->count())

            @foreach ($historia->comentarios->where('parent_id', null) as $comentario)
              <!-- Comentario Principal -->
              <div class="rounded-4 p-3 mb-3 bg-white shadow-sm">

                <!-- Usuario y Acciones -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div>
                    <strong class="text-dark fs-6">{{ optional($comentario->user)->name ?? 'Usuario eliminado' }}</strong>
                    <small class="text-muted ms-2">{{ $comentario->created_at->diffForHumans() }}</small>

                  </div>
                  @if(Auth::id() === $comentario->user_id)
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-secondary px-2 py-1"
                        onclick="document.getElementById('editarComentarioModal{{ $comentario->id }}').classList.remove('d-none')">
                        <i class="bi bi-pencil-square fs-5"></i>
                      </button>
                      <button type="button"
                        class="btn btn-outline-danger btn-sm px-2 py-1"
                        title="Eliminar Comentario"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteComentarioModal{{ $comentario->id }}">
                        <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                      </button>
                    </div>
                  @endif
                </div>

                <!-- Contenido -->
                <p class="mb-3 text-secondary">{{ $comentario->contenido }}</p>

                <!-- Botón Responder -->
                <button class="btn btn-sm btn-outline-info"
                  onclick="document.getElementById('form-responder-{{ $comentario->id }}').classList.toggle('d-none')">
                  <i class="bi bi-reply-fill me-1"></i> Responder
                </button>

                <!-- Formulario de Respuesta -->
                <div id="form-responder-{{ $comentario->id }}" class="mt-3 d-none">
                  <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                    <textarea name="contenido" class="form-control rounded-4 border shadow-sm p-3 mb-2" rows="3"
                      placeholder="Escribe tu respuesta..." required></textarea>
                    <div class="d-flex justify-content-end gap-2">
                      <button type="button" class="btn btn-outline-secondary btn-sm"
                        onclick="document.getElementById('form-responder-{{ $comentario->id }}').classList.add('d-none')">Cancelar</button>
                      <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-send-fill me-1"></i> Publicar
                      </button>
                    </div>
                  </form>
                </div>

                <!-- Respuestas -->
                @foreach ($comentario->respuestas as $respuesta)
                  <div class="mt-3 ms-4 p-3 rounded-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong class="text-dark">{{ optional($respuesta->user)->name ?? 'Usuario eliminado' }}</strong>
                        <small class="text-muted ms-2">{{ $respuesta->created_at->diffForHumans() }}</small>
                      </div>
                      @if(Auth::id() === $respuesta->user_id)
                        <div class="btn-group btn-group-sm">
                          <button class="btn btn-outline-secondary px-2 py-1"
                            onclick="document.getElementById('editarComentarioModal{{ $respuesta->id }}').classList.remove('d-none')">
                            <i class="bi bi-pencil-square fs-5"></i>
                          </button>
                          <button type="button"
                            class="btn btn-outline-danger btn-sm px-2 py-1"
                            title="Eliminar Respuesta"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteRespuestaModal{{ $respuesta->id }}">
                            <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                          </button>
                        </div>
                      @endif
                    </div>
                    <p class="text-secondary mt-2 mb-0">{{ $respuesta->contenido }}</p>

                    <!-- Modal Editar Respuesta -->
                    <div id="editarComentarioModal{{ $respuesta->id }}" class="position-fixed top-0 start-0 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-50 d-none custom-modal" style="z-index: 1050;">
                      <div class="bg-white rounded-4 shadow-lg w-100 p-4" style="max-width: 600px; margin: 1rem;">
                        <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
                          @csrf @method('PUT')
                          <div class="mb-4 text-center">
                            <i class="bi bi-pencil-square text-warning fs-1"></i>
                            <h4 class="fw-bold text-dark">Editar Respuesta</h4>
                            <p class="text-muted">Puedes modificar tu respuesta aquí.</p>
                          </div>
                          <textarea name="contenido" class="form-control rounded-4 border border-warning shadow-sm p-3 w-100 mb-4" rows="6" required>{{ $respuesta->contenido }}</textarea>
                          <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="this.closest('.position-fixed').classList.add('d-none')">Cancelar</button>
                            <button type="submit" class="btn btn-primary text-white">
                              <i class="bi bi-save-fill me-1"></i> Actualizar
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>

                    <!-- Modal Eliminar Respuesta (único por respuesta) -->
                    <div class="modal fade" id="deleteRespuestaModal{{ $respuesta->id }}" tabindex="-1" aria-labelledby="deleteRespuestaModalLabel{{ $respuesta->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 shadow text-center">
                          <div class="modal-header justify-content-center position-relative border-bottom-0">
                            <h5 class="modal-title fs-4 fw-bold text-danger" id="deleteRespuestaModalLabel{{ $respuesta->id }}">
                              <i class="bi bi-exclamation-triangle"></i>
                              Confirmar Eliminación Permanente
                            </h5>
                            <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                          </div>

                          <div class="modal-body">
                            <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                              <i class="bi bi-exclamation-triangle"></i>
                              <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                            </div>
                            <p>¿Está seguro de que desea eliminar esta respuesta?</p>
                          </div>

                          <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('comentarios.destroy', $respuesta) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash3"></i> Eliminar Permanentemente
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                @endforeach

              <!-- Modal Editar Comentario -->
              <div class="modal fade" id="editarComentarioModal{{ $comentario->id }}" tabindex="-1" aria-labelledby="editarComentarioModalLabel{{ $comentario->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content border-0 rounded-4 shadow-lg">
                    <div class="modal-header border-0 text-center pb-0">
                      <div class="w-100 text-center">
                        <i class="bi bi-pencil-square text-warning fs-1"></i>
                        <h4 class="modal-title fw-bold text-dark" id="editarComentarioModalLabel{{ $comentario->id }}">Editar Comentario</h4>
                        <p class="text-muted">Puedes actualizar tu comentario si deseas.</p>
                      </div>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
                      @csrf @method('PUT')
                      <div class="modal-body pt-0">
                        <textarea name="contenido" class="form-control rounded-4 border border-warning shadow-sm p-3 w-100" rows="6" required>{{ $comentario->contenido }}</textarea>
                      </div>
                      <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary text-white">
                          <i class="bi bi-save-fill me-1"></i> Actualizar
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

                <!-- Modal Eliminar Comentario (único por comentario) -->
                <div class="modal fade" id="deleteComentarioModal{{ $comentario->id }}" tabindex="-1" aria-labelledby="deleteComentarioModalLabel{{ $comentario->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow text-center">
                      <div class="modal-header justify-content-center position-relative border-bottom-0">
                        <h5 class="modal-title fs-4 fw-bold text-danger" id="deleteComentarioModalLabel{{ $comentario->id }}">
                          <i class="bi bi-exclamation-triangle"></i>
                          Confirmar Eliminación Permanente
                        </h5>
                        <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>

                      <div class="modal-body">
                        <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                          <i class="bi bi-exclamation-triangle"></i>
                          <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                        </div>
                        <p>¿Está seguro de que desea eliminar este comentario?</p>
                      </div>

                      <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3"></i> Eliminar Permanentemente
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

              </div> <!-- Cierre del recuadro del comentario principal -->
            @endforeach

          @else
            <p class="text-muted text-center">No hay comentarios aún.</p>
          @endif
        </div>
      </div>
    </div>
    <!-- Modal Nuevo Comentario -->
    <div id="nuevoComentarioModal" class="position-fixed top-0 start-0 h-100 d-flex align-items-center justify-content-center bg-black bg-opacity-50 d-none custom-modal" style="z-index: 1050;">
      <div class="bg-white border-0 rounded-4 shadow-lg w-100 p-4" style="max-width: 600px; margin: 1rem;">
        <form action="{{ route('comentarios.store', $historia->id) }}" method="POST">
          @csrf
          <div class="mb-4 text-center">
            <i class="bi bi-chat-left-text-fill text-primary fs-1"></i>
            <h4 class="fw-bold mb-0 text-dark">Nuevo Comentario</h4>
            <p class="text-muted">Participa compartiendo tu opinión o experiencia.</p>
          </div>
          <div class="form-group mb-4">
            <textarea name="contenido" id="contenido" class="form-control rounded-4 border border-info shadow-sm p-3 w-100" rows="6" placeholder="Escribe tu comentario aquí..." required></textarea>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" onclick="document.getElementById('nuevoComentarioModal').classList.add('d-none')">Cancelar</button>
            <button type="submit" class="btn btn-primary text-white rounded-3 px-4 py-2">
              <i class="bi bi-send-fill me-1"></i> Publicar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- MODALES PARA RESPUESTAS (FUERA DEL ACORDEÓN) --}}
@foreach ($historia->comentarios->where('parent_id', null) as $comentario)
  @foreach ($comentario->respuestas as $respuesta)
    <!-- Modal Editar Respuesta -->
    <div class="modal fade" id="editarRespuestaModal{{ $respuesta->id }}" tabindex="-1" aria-labelledby="editarRespuestaModalLabel{{ $respuesta->id }}" aria-hidden="true" style="z-index: 10000;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title" id="editarRespuestaModalLabel{{ $respuesta->id }}">
              <i class="bi bi-pencil-square text-warning me-2"></i>
              Editar Respuesta
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('comentarios.update', $respuesta->id) }}" method="POST">
              @csrf @method('PUT')
              <div class="mb-3">
                <label for="contenidoRespuesta{{ $respuesta->id }}" class="form-label">Contenido de la respuesta</label>
                <textarea name="contenido" id="contenidoRespuesta{{ $respuesta->id }}" class="form-control rounded-3" rows="5" required>{{ $respuesta->contenido }}</textarea>
              </div>
              <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save-fill me-1"></i> Actualizar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <!-- Modal único para eliminar Comentario -->
<div class="modal fade" id="deleteComentarioModal" tabindex="-1" aria-labelledby="deleteComentarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow text-center">
            
            <div class="modal-header justify-content-center position-relative border-bottom-0">
                <h5 class="modal-title fs-4 fw-bold text-danger" id="deleteComentarioModalLabel">
                    <i class="bi bi-exclamation-triangle"></i>
                    Confirmar Eliminación Permanente
                </h5>
                <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p id="deleteComentarioText">¿Está seguro de que desea eliminar este comentario?</p>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

  @endforeach
@endforeach
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteRespuestaModal = document.getElementById('deleteRespuestaModal');
    const deleteRespuestaForm = document.getElementById('deleteRespuestaForm');
    const deleteRespuestaText = document.getElementById('deleteRespuestaText');

    // Base URL con marcador para reemplazar
    const baseDeleteUrl = "{{ route('comentarios.destroy', ['comentario' => '__ID__']) }}";

    deleteRespuestaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const respuestaId = button.getAttribute('data-respuesta-id');

        deleteRespuestaText.textContent = `¿Está seguro de que desea eliminar esta respuesta?`;
        deleteRespuestaForm.action = baseDeleteUrl.replace('__ID__', respuestaId);
    });
});
</script>
@endpush

@push('css')
<style>
.modal-content {
    border-radius: 12px;
}
.modal-header {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteComentarioModal = document.getElementById('deleteComentarioModal');
    const deleteComentarioForm = document.getElementById('deleteComentarioForm');
    const deleteComentarioText = document.getElementById('deleteComentarioText');

    // Base de la URL de eliminación
    const baseDeleteUrl = "{{ route('comentarios.destroy', ['comentario' => '__ID__']) }}";

    deleteComentarioModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const comentarioId = button.getAttribute('data-comentario-id');

        deleteComentarioText.textContent = `¿Está seguro de que desea eliminar este comentario?`;
        deleteComentarioForm.action = baseDeleteUrl.replace('__ID__', comentarioId);
    });
});
</script>
@endpush

@push('css')
<style>
.modal-content {
    border-radius: 12px;
}
.modal-header {
    background-color: #f8f9fa;
}
</style>
@endpush
{{-- ✅ Scripts para el modal (como en sprints/proyectos) --}}
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteTareaModal = document.getElementById('deleteTareaModal');
    const deleteTareaForm = document.getElementById('deleteTareaForm');
    const deleteTareaText = document.getElementById('deleteTareaText');

    deleteTareaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const tareaId = button.getAttribute('data-tarea-id');
        const tareaNombre = button.getAttribute('data-tarea-nombre') || '';

        deleteTareaText.textContent = `¿Está seguro de que desea eliminar la tarea "${tareaNombre}"?`;
        deleteTareaForm.action = `/historias/{{ $historia->id }}/tareas/${tareaId}`;
    });
});
</script>
@endpush

@push('css')
<style>
.modal-content {
    border: none;
    border-radius: 12px;
}
.modal-header {
    border-bottom: 1px solid #e1e4e8;
    background-color: #f6f8fa;
}
</style>
@endpush

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ensure modals are appended to body to avoid layout/overflow issues with sidebars or parents
        document.querySelectorAll('.modal').forEach(modal => {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        });

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
    function guardarEstadoCheckbox(tareaId, estado) {
        let estados = JSON.parse(localStorage.getItem('tareasEstado')) || {};
        estados[tareaId] = estado;
        localStorage.setItem('tareasEstado', JSON.stringify(estados));
    }

    function cargarEstadoCheckboxes() {
        let estados = JSON.parse(localStorage.getItem('tareasEstado')) || {};
        document.querySelectorAll('.tarea-checkbox').forEach(cb => {
            const id = cb.dataset.id;
            if (estados.hasOwnProperty(id)) {
                cb.checked = estados[id];
            }
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('tarea-checkbox')) {
            const checkbox = e.target;
            const tareaId = checkbox.dataset.id;
            const estaMarcado = checkbox.checked;

            // Guardar en localStorage
            guardarEstadoCheckbox(tareaId, estaMarcado);

            // Sincronizar checkboxes con el mismo data-id en la misma página
            document.querySelectorAll(`.tarea-checkbox[data-id="${tareaId}"]`)
                    .forEach(cb => cb.checked = estaMarcado);
        }
    });

    // Cargar estado al abrir la página
    window.addEventListener('DOMContentLoaded', cargarEstadoCheckboxes);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('textarea[readonly]').forEach(textarea => {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        });

        const btnEditar = document.getElementById('btnEditar');
        const btnGuardar = document.getElementById('btnGuardar');
        const btnCancelar = document.getElementById('btnCancelar');
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
            btnCancelar.classList.remove('d-none');  // Mostrar botón Cancelar
            if (dropdownMenuContainer) {
                dropdownMenuContainer.classList.add('d-none');
            }
        });

        btnCancelar.addEventListener('click', function () {
            // Revertir al modo sólo lectura / deshabilitado
            tituloTexto.classList.remove('d-none');
            tituloInput.classList.add('d-none');
            editableFields.forEach(field => {
                field.setAttribute('readonly', true);
                field.setAttribute('disabled', true);
                if (field.tagName === 'TEXTAREA') {
                    field.style.height = 'auto';
                    field.style.height = field.scrollHeight + 'px';
                }
            });
            btnGuardar.classList.add('d-none');
            btnCancelar.classList.add('d-none');
            if (dropdownMenuContainer) {
                dropdownMenuContainer.classList.remove('d-none');
            }
        });

        const form = document.getElementById('formHistoria');
        form.addEventListener('submit', function () {
            console.log('Formulario enviado');
        });
    });
</script>
</div>
</div>
@endsection