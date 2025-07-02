@extends('layouts.app')

@section('title')
         @section('mensaje-superior')
            Editar Historia
        @endsection

@section('content')

<div class="container-fluid mi-container">
    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">

        @if ($errors->any())
        <div class="alert alert-danger mt-2">
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        @endif


    <form action="{{ route('historias.update',$historia->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" maxlength="100" value="{{ $historia->nombre }}" >
        </div>


        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimado*</label>
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

            <a href="{{ route('historias.show', $historia->id) }}" class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white mr-3 normal-case me-2">Atras</a>

            <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">Actualizar</button>
        </div>
    </form>
</div>

@endsection
