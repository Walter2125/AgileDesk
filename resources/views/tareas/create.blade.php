@extends('layouts.app')

@section('mensaje-superior')
    Crear Tarea: {{ Str::limit($historia->nombre, 20) }}
@endsection

@section('styles')
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        border-radius: 8px;
        padding: 20px;
    }

    .form-label,
    .fw-bold {
        color: #000000;
    }

    .form-control {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #cccccc;
    }

    .form-control:focus {
        background-color: #ffffff;
        color: #000000;
        border-color: #999999;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
    }

    .alert {
        font-weight: bold;
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn-secondary {
        background-color: #e0e0e0;
        color: #000000;
        border: 1px solid #999999;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004b9a;
    }
</style>
@endsection

@section('content')
<div class="container py-4" style="max-width: 1200px;">
    <div class="card p-5 mb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(Auth::check())
            <div class="mb-4">
                <strong>Formulario para Tareas</strong>
            </div>
        @else
            <div class="mb-4">
                <strong>Usuario no autenticado</strong>
            </div>
        @endif

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

        <form action="{{ route('tareas.store', $historia->id) }}" method="POST" autocomplete="off">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold" >Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" maxlength="100"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción <span class="text-danger">*</span></label>
                <textarea name="descripcion" id="descripcion"
                          class="form-control @error('descripcion') is-invalid @enderror"
                          required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Tipo de Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad"
                        class="form-control @error('actividad') is-invalid @enderror" required>
                    <option value="">Seleccione una actividad</option>
                    @foreach(['Configuracion', 'Desarrollo', 'Prueba', 'Diseño', 'OtroTipo'] as $opcion)
                        <option value="{{ $opcion }}" {{ old('actividad') == $opcion ? 'selected' : '' }}>
                            {{ $opcion }}
                        </option>
                    @endforeach
                </select>
                @error('actividad')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('historias.show', $historia->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
