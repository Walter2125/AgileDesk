@extends('layouts.app') 
@section('mensaje-superior')
    Proyectos
@endsection

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .projects-container {
        margin-top: 2rem;
        /* Remover cualquier padding lateral para usar el del contenedor padre */
        /* Esto permite que el contenido se alinee con las migas de pan */
        padding-left: 0;
        padding-right: 0;
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
        width: 100%;
    }

    .project-title i {
        color: #3498db;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .project-code {
        font-size: 0.82rem;
        color: #6c757d;
        text-align: left;
    }

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

    .project-description {
        margin: 0.5rem 0;
        font-size: 0.92rem;
        color: #495057;
        flex-grow: 1;
        text-align: left;
        line-height: 1.5;
    }

    .action-buttons {
        display: flex;
        gap: 0.6rem;
        margin-top: 1.2rem;
    }

    .action-buttons .btn {
        flex: 1;
        min-width: 0;
        border-radius: 50px;
        padding: 0.5rem 0.7rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        font-weight: 600;
        white-space: nowrap;
        height: 40px;
        text-align: center;
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

    .action-buttons form {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-buttons form .btn {
        width: 100%;
    }

    .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
    }

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

    .page-title {
    color: #2c3e50;
    font-weight: 800;
    
    font-size: 2.2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    
}

.page-title::after {
    content: '';
    display: block;
    width: 100%;
    height: 4px;
    margin-top: 0.6rem;
    background: linear-gradient(to right,rgb(6, 95, 164),rgb(35, 181, 200));
    border-radius: 2px;
    position: absolute;
    bottom: -10px;
    left: 0;
    z-index: 0;
}

.page-title a {
    margin-left: 1rem;
    z-index: 1;
}


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

 .page-title {
    border-bottom: none !important;
    box-shadow: none !important;
}

.page-title::before {
    content: none !important;
    display: none !important;
}

h1.page-title {
    border-bottom: none !important;
    outline: none !important;
}

</style>
@endsection

@section('content')
<div class="projects-container">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Proyectos más recientes --}}
    <h1 class="page-title">
        Proyectos más recientes
        @if (auth()->check() && auth()->user()->usertype == 'admin')
            <a href="{{ route('projects.create') }}" class="btn btn-link p-0" title="Crear nuevo proyecto">
                <i class="fas fa-plus fa-lg text-primary"></i>
            </a>
        @endif
    </h1>
    <div class="row">
        @forelse($recentProjects as $project)
            @include('projects.project-card', ['project' => $project])
        @empty
            <p class="text-muted">No hay proyectos recientes aún.</p>
        @endforelse
    </div>
    

    <h2 class="page-title mt-5">Proyectos</h2>
    <div class="list-group">
    @forelse($allProjects as $project)
        <div class="mb-3 p-3 border rounded shadow-sm bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 text-blanck">{{ $project->name }}</h5>
                    <small class="text-muted">
                        {{ $project->created_at->format('d/m/Y') }}
                        @if($project->category)
                            | {{ $project->category->name }}
                        @endif
                    </small>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('tableros.show', $project->id) }}" class="btn btn-view">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if (auth()->check() && auth()->user()->usertype == 'admin')
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @if($project->descripcion)
                <button class="btn btn-sm btn-link mt-2 p-0 text-decoration-none text-info" type="button" data-bs-toggle="collapse" data-bs-target="#desc-{{ $project->id }}">
                    Mostrar descripción
                </button>
                <div class="collapse mt-2" id="desc-{{ $project->id }}">
                    <p class="mb-0 text-muted">{{ $project->descripcion }}</p>
                </div>
            @endif
        </div>
    @empty
        <p class="text-muted">No hay proyectos para mostrar.</p>
    @endforelse
    </div>
</div>
@endsection
