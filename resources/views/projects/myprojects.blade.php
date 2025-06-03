@extends('layouts.app')
     @section('mensaje-superior')
            Proyectos
        @endsection
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
    }
    
    .project-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .project-card .card-body {
        padding: 1.5rem;
    }
    
    /* Project Card Header */
    .project-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .project-title i {
        color: #3498db;
        font-size: 1.2rem;
    }
    
    /* Project Dates */
    .date-info {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        color: #5d6778;
        font-size: 0.9rem;
    }
    
    .date-block {
        background-color: #f8f9fa;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .date-block i {
        color: #6c757d;
    }
    
    /* Team Members Section */
    .team-section {
        margin: 1rem 0;
        padding: 1rem;
        background: linear-gradient(to right, #f1f6fe, #f5f7fa);
        border-radius: 10px;
    }
    
    .team-heading {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #3498db;
        margin-bottom: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .team-list {
        list-style-type: none;
        padding-left: 0.5rem;
        margin-bottom: 0;
    }
    
    .team-list li {
        padding: 0.4rem 0;
        color: #444;
        font-size: 0.95rem;
        border-bottom: 1px dashed rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
    }
    
    .team-list li:last-child {
        border-bottom: none;
    }
    
    .team-list li:before {
        content: "👤";
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-top: 1.5rem;
    }
    
    .btn-view {
        background-color: #00bcd4;
        border-color: #00bcd4;
        color: white;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-view:hover {
        background-color: #0097a7;
        border-color: #0097a7;
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-edit:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-delete:hover {
        background-color: #c82333;
        border-color: #c82333;
        transform: translateY(-2px);
    }
    
    /* Create Project Card */
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
    
    .create-project-card:hover {
        transform: translateY(-8px);
        border-color: #3498db;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .create-project-card .card-text {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        color: #495057;
    }
    
    .create-project-card .btn-create {
        background: linear-gradient(to right, #3498db, #2980b9);
        border: none;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .create-project-card .btn-create:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Page Title */
    .page-title {
        color: #2c3e50;
        font-weight: 800;
        margin-bottom: 2rem;
        font-size: 2.2rem;
        border-left: 5px solid #3498db;
        padding-left: 1rem;
    }
    
    /* Alert Styling */
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        position: relative;
        animation: fadeInDown 0.5s;
    }
    
    /* Empty State */
    .empty-state {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1.5rem;
    }
    
    .empty-state h3 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }
    
    .empty-state .btn {
        background: linear-gradient(to right, #3498db, #2980b9);
        border: none;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .empty-state .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Modal Styling */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(to right, #f8f9fa, #eff1f3);
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modal-body {
        padding: 2rem 1.5rem;
    }
    
    .modal-footer {
        padding: 1.5rem;
        border-top: none;
    }
    
    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .date-info {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-view, .btn-edit, .btn-delete {
            width: 100%;
            justify-content: center;
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
                            <h3 class="project-title">
                                <i class="fas fa-project-diagram"></i>
                                {{ $project->name }}
                            </h3>
                            
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

                            <div class="team-section">
                                <div class="team-heading">
                                    <i class="fas fa-users"></i> Integrantes
                                </div>
                                <ul class="team-list">
                                    @foreach($project->users as $user)
                                        <li>{{ $user->name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="action-buttons">
                                <a href="{{ route('tableros.show', $project->id) }}" class="btn btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>

                                @if(auth()->id() === $project->user_id)
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                                        <i class="fas fa-pencil-alt"></i> Editar
                                    </a>

                                    <button class="btn btn-delete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $project->id }}">
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
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="confirmDeleteModalLabel{{ $project->id }}">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar el proyecto <strong class="text-primary">{{ $project->name }}</strong>?</p>
                                <p class="text-muted small">Esta acción no se puede deshacer.</p>
                            </div>
                            <div class="modal-footer">
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
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h3>No tienes proyectos aún</h3>
            <p>Crea tu primer proyecto para comenzar a colaborar</p>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Crear Primer Proyecto
            </a>
        </div>
    @endif
</div>
@endsection