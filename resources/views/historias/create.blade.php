@extends('layouts.app')

@section('title', 'Crear Nueva Historia')

@section('mensaje-superior')
    Crea una nueva Historia
@endsection

@push('styles')
<!-- Enlace al archivo CSS externo -->

    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
@endpush

@section('content')
<div class="container-fluid mi-container">
  
    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

   
    <form action="{{ route('historias.store') }}" method="POST" autocomplete="off" >
        @csrf
        <input type="hidden" name="proyecto_id" value="{{ $proyecto ? $proyecto->id : '' }}">
        <input type="hidden" name="columna_id" value="{{ $columna ? $columna->id : '' }}">

        <div class="row mb-3">
          
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nombre*</label>
                    <input type="text" name="nombre" maxlength="100" 
                           class="form-control formulario-editable"
                           value="{{ old('nombre') }}" 
                           placeholder="Nombre de la historia" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Asignado a</label>
                    <select name="usuario_id" class="form-control formulario-editable">
                        <option value="">-- Seleccionar usuario --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

               <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="columna_id" class="form-control formulario-editable">
                        <option value="">Sin Estado</option>
                        @foreach ($columnas as $c)
                            <option value="{{ $c->id }}"
                                {{ (old('columna_id') == $c->id) || (isset($columna) && $columna->id == $c->id) ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

           
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-control formulario-editable">
                        <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Horas estimadas</label>
                    <input type="number" name="trabajo_estimado" 
                           class="form-control formulario-editable" min="0"
                           value="{{ old('trabajo_estimado') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Sprint</label>
                    <select name="sprint_id" class="form-control formulario-editable">
                        <option value="">Ningún Sprint</option>
                        @foreach ($sprints as $sprint)
                            <option value="{{ $sprint->id }}" {{ old('sprint_id') == $sprint->id ? 'selected' : '' }}>
                                {{ $sprint->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" maxlength="5000" 
                      class="form-control formulario-editable" rows="4">{{ old('descripcion') }}</textarea>
            </div>

            <div class="d-flex justify-content-end mb-3 mt-4">
            <a href="{{ route('tableros.show', ['project' => $proyecto->id]) }}"
               class="btn btn-secondary btn-form-actions me-2">
              <i class="bi bi-x-lg me-2"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary btn-form-actions">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Guardar
            </button>
            </div>
        </div>
        
        
    </form>
</div>

@push('scripts')
<script>
   
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) {
            const form = document.querySelector('form');
            form && form.reset();
        }
    });
</script>
@endpush
@endsection