@extends('layouts.app')

@section('styles')
<style>
    /* Project Card Styling */
    .projects-container {
        margin-top: 2rem;
    }
    
    .project-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
        height: 100%;
        background-color: #fff;
        display: flex;
        flex-direction: column;
    }
    
    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .project-card .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.8rem;
        width: 100%;
    }
    
    .project-title-wrapper {
        flex: 1;
        text-align: left;
    }
    
    .project-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: flex-start;
        text-align: left;
    }
    
    .project-title i {
        color: #3498db;
        font-size: 1.1rem;
        flex-shrink: 0;
        text-align: left;
    }
    
    .project-code {
        font-size: 0.82rem;
        color:rgb(27, 27, 27);
        text-align: left;
    }
    
    /* Project Dates */
    .date-info {
    display: flex;
    justify-content: space-between; 
    gap: 1rem;
    margin-bottom: 1.2rem;
    color: #5d6778;
    font-size: 0.82rem;
    }

    
    .date-block {
        background-color: #f8f9fa;
        padding: 0.4rem 0.7rem;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .date-block i {
        color: #6c757d;
        font-size: 0.75rem;
    }
    
    /* Project Description */
    .project-description {
        margin: 0.5rem 0;
        font-size: 0.92rem;
        color: #495057;
        flex-grow: 1;
        text-align: left;
        line-height: 1.5;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.6rem;
        margin-top: 1.2rem;
    }
    
    .action-buttons .btn {
        flex: 1;
        min-width: 0;
        border-radius: 50px;
        padding: 0.5rem;
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        font-weight: 500;
        white-space: nowrap;
        height: 38px; /* Altura fija */
    }
    
    .btn-view {
        background-color: #00bcd4;
        border-color: #00bcd4;
        color: white;
    }
    
    .btn-edit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    
    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    
    /* Asegurar que el formulario no afecte el tamaño del botón */
    .action-buttons form {
        flex: 1;
        display: flex;
    }
    
    .action-buttons form .btn {
        width: 100%;
    }
    
    .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
    }
    
    /* Dropdown Options */
    .dropdown-card-options {
        margin-left: auto;
    }
    
    .dropdown-card-options .dropdown-toggle {
        padding: 0.2rem 0.5rem;
        font-size: 0.9rem;
        color: #6c757d;
        background: transparent;
        border: none;
    }
    
    /* Resto de estilos */
    .create-project-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 2px dashed #adb5bd;
        text-align: center;
        padding: 2.5rem 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    .page-title {
        color: #2c3e50;
        font-weight: 800;
        margin-bottom: 2rem;
        font-size: 2.2rem;
        border-left: 5px solid #3498db;
        padding-left: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 767.98px) {
        .date-info {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
        
        .project-code {
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container projects-container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (auth()->user()->usertype == 'admin')
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="create-project-card">
                    <p class="card-text">Comienza un nuevo proyecto colaborativo</p>
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-create">
                        <i class="fas fa-plus mr-2"></i> Crear Proyecto
                    </a>
                </div>
            </div>
        </div>
    @endif

    <h1 class="page-title">Proyectos más recientes</h1>

    @if(count($projects) > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="project-card card h-100">
                        <div class="card-body">
                            <div class="project-header">
                                <div class="project-title-wrapper">
                                    <h3 class="project-title">
                                        <i class="fas fa-project-diagram"></i> 
                                        <span>{{ $project->name }}</span>
                                    </h3>
                                    <div class="project-code">
                                        <strong>Código:</strong> {{ $project->codigo }}
                                    </div>
                                </div>

                                <div class="dropdown-card-options dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton{{ $project->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $project->id }}">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalIntegrantes{{ $project->id }}">
                                                Ver integrantes
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="date-info">
                                <div class="date-block">
                                    <i class="fas fa-calendar-alt"></i> 
                                    <span>{{ $project->fecha_inicio }}</span>
                                </div>
                                <div class="date-block">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>{{ $project->fecha_fin }}</span>
                                </div>
                            </div>

                            <div class="project-description">
                                {{ Str::limit($project->descripcion, 100) }}
                            </div>

                            <!-- Botones -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <a href="{{ route('tableros.show', $project->id) }}"  class="btn btn-info btn-sm rounded-pill">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                @if(auth()->id() === $project->user_id)
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de Integrantes -->
                <div class="modal fade" id="modalIntegrantes{{ $project->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $project->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $project->id }}">Integrantes del proyecto: {{ $project->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                @if($project->users && $project->users->count() > 0)
                                    <ul class="list-group">
                                        @foreach($project->users as $user)
                                            <li class="list-group-item">
                                                <strong>{{ $user->name }}</strong> <br>
                                                <small>{{ $user->email }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No hay integrantes registrados en este proyecto.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h3>No hay proyectos disponibles</h3>
            <p>Cuando se creen nuevos proyectos, aparecerán aquí.</p>
            @if (auth()->user()->usertype == 'admin')
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    Crear Proyecto
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>