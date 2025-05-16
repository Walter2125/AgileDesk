@extends('layouts.app')

@push('styles')
<style>
    .create-project-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 1px dashed #adb5bd;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .create-project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        border-color: #4e73df;
    }

    .card.h-100 {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .card.h-100:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .card-body h3 {
        color: #00796b;
        font-weight: 600;
    }

    .btn-info {
        background-color: #00bcd4;
        border-color: #00bcd4;
        color: white;
    }

    .btn-info:hover {
        background-color: #0097a7;
        border-color: #0097a7;
        color: white;
    }

    .btn-warning,
    .btn-danger {
        border-radius: 50px;
    }

    .modal-content {
        border-radius: 15px;
    }

    .modal-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    h1 {
        font-weight: bold;
        color: #00695c;
        margin-bottom: 30px;
    }

    .empty-state {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 40px;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <h1>Mis Proyectos:</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (auth()->user()->usertype == 'admin')
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card text-center create-project-card">
                    <div class="card-body p-4">
                        <h4 class="card-title font-weight-bold text-dark">Crear Nuevo Proyecto</h4>
                        <p class="card-text text-muted">Comienza un nuevo proyecto colaborativo</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-plus mr-2"></i> Crear Proyecto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(count($projects) > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body">
                            <h3><i class="fas fa-project-diagram text-primary me-2"></i>{{ $project->name }}</h3>
                            <p>📅 <strong>Inicio:</strong> {{ $project->fecha_inicio }}</p>
                            <p>📅 <strong>Fin:</strong> {{ $project->fecha_fin }}</p>

                            <!-- BLOQUE ORIGINAL DE INTEGRANTES (sin cambios) -->
                            <h5><i class="fas fa-users text-info me-2"></i> Integrantes</h5>
                            <ul>
                                @foreach($project->users as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ul>

                            <!-- Botones -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <a href="*" class="btn btn-info btn-sm rounded-pill">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                @if(auth()->id() === $project->user_id)
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm rounded-pill">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>

                                    <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $project->id }}">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal confirmación eliminar -->
                <div class="modal fade" id="confirmDeleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $project->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title text-danger" id="confirmDeleteModalLabel{{ $project->id }}">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás segura de que deseas eliminar el proyecto <strong class="text-primary">{{ $project->name }}</strong>?</p>
                                <p class="text-muted small">Esta acción no se puede deshacer.</p>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @else
        <div class="empty-state text-center py-5">
            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
            <h3 class="text-secondary">No tienes proyectos aún</h3>
            <p class="text-muted">Crea tu primer proyecto para comenzar a colaborar</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Crear Primer Proyecto
            </a>
        </div>
    @endif
</div>
@endsection


