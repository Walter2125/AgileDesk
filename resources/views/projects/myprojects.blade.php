@extends('layouts.app') 
@section('mensaje-superior')
    Proyectos
@endsection

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
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
<div class="container projects-container">

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

    {{-- Todos los proyectos --}}
    <h2 class="page-title mt-5">Todos los proyectos</h2>
    <div class="row">
        @forelse($allProjects as $project)
            @include('projects.project-card', ['project' => $project])
        @empty
            <p class="text-muted">No hay proyectos para mostrar.</p>
        @endforelse
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>