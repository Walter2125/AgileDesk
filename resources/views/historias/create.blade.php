@extends('layouts.app')

@section('title', 'Crear Nueva Historia')

@section('mensaje-superior')
    Crea una nueva Historia
@endsection

@php
    $currentProject = $proyecto;
@endphp

@section('content')

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
            <a href="{{ route('tableros.show', ['project' => $proyecto->id]) }}"
                class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white mr-3 normal-case me-2">
                Cancelar
            </a>

            <button type="submit"
                class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">
                Guardar
            </button>
        </div>

    </form>

</div>

@endsection
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
