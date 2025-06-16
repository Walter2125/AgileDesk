@extends('layouts.app')
        @section('mensaje-superior')
          Crear tarea para: {{ $historia->nombre }}
        @endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/historias.css') }}">
<div class="container" style="max-width: 1200px;">
    <!-- Tarjeta de Crear Nueva Tarea -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Información del Usuario -->
        @if(Auth::check())
            <div class="mb-4">
                <strong>Bienvenido, {{ Auth::user()->name }}</strong>
            </div>
        @else
            <div class="mb-4">
                <strong>Usuario no autenticado</strong>
            </div>
        @endif

        <!-- Errores de Validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups, hubo algunos problemas con tu entrada:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de Nueva Tarea -->
        <form action="{{ route('tareas.store', $historia->id) }}" method="POST">
            @csrf
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción <span class="text-danger">*</span></label>
                <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control @error('actividad') is-invalid @enderror" required>
                    <option value=""> Seleccione una actividad </option>
                    @foreach(['Configuracion', 'Desarrollo', 'Prueba', 'Diseño', 'OtroTipo'] as $opcion)
                <option value="{{ $opcion }}" {{ old('actividad') == $opcion ? 'selected' : '' }}>
                 {{ $opcion == 'OtroTipo' ? 'Otro Tipo' : $opcion }}
                </option>

                @endforeach
                
                </select>
                @error('actividad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('tareas.show', $historia->id) }}" class="btn btn-secondary">
                    Cancelar
                </a>                
                <button type="submit" class="btn btn-primary">Crear Tarea</button>
            </div>
        </form>
    </div>
@endsection