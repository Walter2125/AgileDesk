@extends('layouts.app')

@section('title')

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

         <h1 class="titulo-historia">Editar Historia</h1>

    <form action="{{ route('historias.update',$historia->id) }}" method="POST">
        @csrf
        @method('PATCH')
       
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Historia*</label>
            <input type="text" name="nombre" id="nombre" class="form-control rounded" value="{{ $historia->nombre }}" >
        </div>

     
        <div class="mb-3">
            <label for="trabajo_estimado" class="form-label">Horas de trabajo estimado*</label>
            <input type="number" name="trabajo_estimado" id="trabajo_estimado" class="form-control rounded " min="0" value="{{ $historia->trabajo_estimado }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
        </div>

         <div class="mb-3">
            <label for="usuario_id" class="form-label">Asignado a:</label>
            <select name="usuario_id" id="usuario_id" class="form-control" disabled>
                <option value="">(Usuarios aún no disponibles)</option>
            </select>
        </div> 

        <!-- Prioridad -->
        <div class="mb-3">
            <label for="prioridad" class="form-label" >Prioridad</label>
             <select name="prioridad" id="prioridad" class="form-control rounded">
                <option value="Alta" {{ old('prioridad', $historia->prioridad) == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Media" {{ old('prioridad', $historia->prioridad) == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Baja" {{ old('prioridad', $historia->prioridad) == 'Baja' ? 'selected' : '' }}>Baja</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ $historia->descripcion }}</textarea>
        </div>

    

     

         <div class="mb-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>

@endsection