@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1200px;"> <!-- Aumenta el ancho máximo -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <!-- Título con Icono -->
        <h2 class="text-center mb-4" style="font-weight: bold; font-size: 2.5em;">
            <span style="font-size: 1.5em;">📝</span> Crear Nueva Tarea
        </h2>

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

        <!-- Formulario de Nueva Tarea -->
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            
            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre de la Tarea <span class="text-danger">*</span></label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
            </div>

            <!-- Actividad -->
            <div class="mb-4">
                <label for="actividad" class="form-label fw-bold">Actividad <span class="text-danger">*</span></label>
                <select name="actividad" id="actividad" class="form-control" required>
                    <option value="Configuracion">Configuración</option>
                    <option value="Desarrollo">Desarrollo</option>
                    <option value="Prueba">Prueba</option>
                    <option value="Diseño">Diseño</option>
                </select>
            </div>

            <!-- Usuario Responsable -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-bold">Usuario Responsable</label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">Sin asignar</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear Tarea</button>
            </div>
        </form>
    </div>

    <!-- Lista de Tareas -->
    <div class="card shadow-sm p-5 mb-5 bg-white rounded">
        <h2 class="text-center mb-4" style="font-weight: bold; font-size: 2.5em;">
            📋 Lista de Tareas
        </h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Actividad</th>
                    <th>Usuario</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->id }}</td>
                        <td>{{ $tarea->nombre }}</td>
                        <td>{{ $tarea->descripcion }}</td>
                        <td>{{ $tarea->actividad }}</td>
                        <td>{{ optional($tarea->user)->name ?? 'Sin asignar' }}</td>
                        <td>{{ $tarea->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
