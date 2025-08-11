@extends('layouts.app')

@section('title', 'Crear Nueva Historia')

@section('mensaje-superior')
    Crear una nueva Historia
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

@php
    $currentProject = $proyecto;
@endphp

<div class="container-fluid mi-container">

    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('historias.store') }}" method="POST" autocomplete="off">
        @csrf

        <input type="hidden" name="proyecto_id" value="{{ $proyecto ? $proyecto->id : '' }}">
        <input type="hidden" name="columna_id" value="{{ $columna ? $columna->id : '' }}">

        <div class="mb-4 d-flex justify-content-between align-items-center rounded">
            
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
               
                <label class="form-label rounded">Nombre*</label>
                <input type="text" name="nombre" maxlength="100" class="form-control form-control-lg rounded mt-2"
                    value="{{ old('nombre') }}" placeholder="Nombre de la historia" required />
                </div>
   


                <div class="mb-3">
                    <label class="form-label rounded">Asignado a</label>
                    <select name="usuario_id" class="form-control rounded" >
                        <option value="">-- Seleccionar usuario --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label rounded">Estado</label>
                    <select name="columna_id" class="form-control rounded" >
                        <option value="">Sin Estado</option>
                        @foreach ($columnas as $columna)
                            <option value="{{ $columna->id }}" {{ old('columna_id') == $columna->id ? 'selected' : '' }}>
                                {{ $columna->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                



            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label rounded">Prioridad</label>
                    <select name="prioridad" class="form-control rounded" >
                        <option value="Alta" {{ old('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ old('prioridad', 'Media') == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ old('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label rounded">Horas estimadas</label>
                    <input id="trabajo_estimado" type="number" name="trabajo_estimado" class="form-control rounded" min="0"
                        value="{{ old('trabajo_estimado') }}"  />
                </div>

                <div class="mb-3">
                    <label class="form-label rounded">Sprint</label>
                    <select name="sprint_id" class="form-control rounded">
                        <option value="">Ningún Sprint</option>
                        @foreach ($sprints as $sprint)
                            <option value="{{ $sprint->id }}" {{ old('sprint_id') == $sprint->id ? 'selected' : '' }}>
                                {{ $sprint->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label rounded">Descripción</label>
            <textarea name="descripcion" maxlength="5000" style="field-sizing: content;" class="form-control rounded" rows="4">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('tableros.show', ['project' => $proyecto->id]) }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Guardar
            </button>
        </div>

    </form>

</div>

<script>
    window.addEventListener("pageshow", function (event) {
        // Si la página fue cargada desde caché (por el botón "Atrás"), limpiamos el formulario
        if (event.persisted) {
            const form = document.querySelector('form');
            if (form) {
                form.reset();
            }
        }
    });
</script>

@endsection
