@extends('layouts.app')

@section('title')
        @section('mensaje-superior')
            Editar Historia
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
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        transition: all 0.2s ease-in-out;
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

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: #ffffff;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c2c7;
        color: #842029;
    }
</style>
@endsection

@section('content')

<div class="container-fluid mi-container">
    <script src="{{ asset('vendor/jquery/jquery-3.6.0.min.js') }}"></script>

        @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        @endif

    <div id="ajax-messages"></div>

    <form id="editHistoriaForm" action="{{ route('historias.update',$historia->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" maxlength="100" value="{{ $historia->nombre }}" >
        </div>


        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimadas*</label>
            <input type="number" name="trabajo_estimado" id="trabajo_estimado" class="form-control rounded " min="0" value="{{ $historia->trabajo_estimado }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignado a:</label>
            <select name="usuario_id" id="usuario_id" class="form-control">
                <option value="">-- Seleccionar usuario --</option>
                @foreach($usuarios as $usuario)
                   <option value="{{ $usuario->id }}"
                        {{ old('usuario_id', $historia->usuario_id) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="prioridad" class="form-label" >Prioridad</label>
             <select name="prioridad" id="prioridad" class="form-control rounded">
                <option value="Alta" {{ old('prioridad', $historia->prioridad) == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Media" {{ old('prioridad', $historia->prioridad) == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Baja" {{ old('prioridad', $historia->prioridad) == 'Baja' ? 'selected' : '' }}>Baja</option>
            </select>
        </div>

        @if ($columnas && $columnas->isNotEmpty())
            <div class="mb-3">
                <label for="columna_id" class="form-label">Estado</label>
                <select name="columna_id" id="columna_id" class="form-control">
                    <option value="">Sin Estado</option>
                    @foreach ($columnas as $columna)
                        <option value="{{ $columna->id }}"
                            {{ old('columna_id', $historia->columna_id ?? '') == $columna->id ? 'selected' : '' }}>
                            {{ $columna->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif


        <div class="mb-3">
            <label for="sprint_id" class="form-label">Sprint</label>
            <select name="sprint_id" id="sprint_id" class="form-control rounded">
                <option value="">Ningún Sprint</option>
                @foreach ($sprints as $sprint)
                    <option value="{{ $sprint->id }}"
                        {{ old('sprint_id', $historia->sprint_id) == $sprint->id ? 'selected' : '' }}>
                        {{ $sprint->nombre }}
                    </option>
                @endforeach
            </select>
        </div>



        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" maxlength="5000" rows="4">{{ $historia->descripcion }}</textarea>
        </div>





         <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('historias.show', $historia->id) }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Atrás
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Actualizar
            </button>
        </div>
    </form>
</div>


@endsection
