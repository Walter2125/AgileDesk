@extends('layouts.app')

@section('mensaje-superior')
    Crear Tarea: {{ Str::limit($historia->nombre, 20) }}
@endsection

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.05);
        border: none;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .form-label,
    .fw-bold {
        color: #fff;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.03);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #ffc107;
    }

    .alert {
        font-weight: bold;
    }

    .btn {
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    .btn-secondary {
        background-color: #fff;
        color: #000;
        border: none;
    }

    .btn-primary {
        background-color: #00adb5;
        border-color: #00adb5;
    }

    .btn-primary:hover {
        background-color: #009fa6;
        border-color: #009fa6;
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
                <strong>Bienvenido, {{ Auth::user()->name }}</strong>
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

        <form action="{{ route('tareas.store', $historia->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre"
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
                <label for="actividad" class="form-label fw-bold">Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad"
                        class="form-control @error('actividad') is-invalid @enderror" required>
                    <option value="">Seleccione una actividad</option>
                    @foreach(['Configuracion', 'Desarrollo', 'Prueba', 'Diseño'] as $opcion)
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
                <a href="{{ route('tareas.show', $historia->id) }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">Crear Tarea</button>
            </div>
        </form>
    </div>
</div>
@endsection
