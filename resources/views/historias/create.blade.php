@extends('layouts.app')

@section('title')

@section('mensaje-superior')
    Crea una nueva Historia
@endsection


@section('content')
   <meta http-equiv="Cache-Control" content="no-store" />
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

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

        <input type="hidden" name="proyecto_id" value="{{ $proyecto ? $proyecto->id : '' }}">
        <input type="hidden" name="columna_id" value="{{ $columna ? $columna->id : '' }}">




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
                @if($usuarios->isNotEmpty())
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                @else
                    <option value="">No hay usuarios disponibles</option>
                @endif
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

        @if ($columnas && $columnas->isNotEmpty())
            <div class="mb-3">
                <label for="columna_id" class="form-label">Estado</label>
                <select name="columna_id" id="columna_id" class="form-control">
                    <option value="">Sin Estado</option>
                    @foreach ($columnas as $columna)
                        <option value="{{ $columna->id }}" {{ old('columna_id') == $columna->id ? 'selected' : '' }}>
                            {{ $columna->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif



        <div class="mb-3">
            <label for="sprint_id" class="form-label">Seleccionar Sprint:</label>
            <select name="sprint_id" id="sprint_id" class="form-control">
                <option value="">Selecciona un sprint</option>
                @if($sprints->isNotEmpty())
                    @foreach ($sprints as $sprint)
                        <option value="{{ $sprint->id }}">{{ $sprint->nombre }}</option>
                    @endforeach
                @else
                    <option value="">No hay sprints disponibles</option>
                @endif
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



@endsection
