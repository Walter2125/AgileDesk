@extends('layouts.app')

@section('title')

@section('mensaje-superior')
    <div class="mt-4 text-lg font-semibold text-blue-600">
        
       <h1 class="titulo-historia">📝Crea una nueva Historia</h1>
    </div>
@endsection


@section('content')

<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

<div class="container-fluid mi-container ">

        @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
            
        @endif

    <form action="{{ route('historias.store') }}" method="POST">
        @csrf
       <!-- <h1 class="titulo-historia">Crea una nueva Historia</h1>-->
        
        <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">
        <input type="hidden" name="columna_id" value="{{ $columna->id }}">
      

       <div class="mb-3 ">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" value="{{ old('nombre') }}" >
        </div>
        

        
        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimado* </label>
            <input type="number" name="trabajo_estimado" id="trabajo_estimado" class="form-control rounded" min="0" value="{{ old('trabajo_estimado') }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>
        
       <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignado a:</label>
            <select name="usuario_id" id="usuario_id" class="form-control">
                <option value="">Selecciona un usuario</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>


     
        <div class="mb-3">
            <label for="prioridad" class="form-label" >Prioridad</label>
            <select name="prioridad" id="prioridad" class="form-control rounded">
                <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
            </select>
        </div>

       
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3 d-flex justify-content-end">
             <a href="{{ route('tableros.show', ['project' => $proyecto->id]) }}" 
               class="btn btn-secondary me-2">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script>
    // Esto reemplaza la URL anterior en el historial
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

@endsection