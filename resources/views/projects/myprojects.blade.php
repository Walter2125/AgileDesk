@extends('layouts.app')
@section('mensaje-superior')
    Proyectos
@endsection

@section('styles')

<link rel="stylesheet" href="{{ asset('vendor/fontawesome/all-fixed.css') }}">

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
    .bg-color-dynamic {
        background-color: inherit !important;
    }

    /* Estilo para información del creador (superadmin) */
    .project-creator {
        font-size: 0.75rem;
        color: #6c757d;
        text-align: left;
    }

    .project-creator i {
        color: #3498db;
        font-size: 0.7rem;
        margin-right: 0.3rem;
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
.menu-three-dots {
    position: absolute;
    right: 0;
    margin-top: 0.5rem;
    background: white;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 0.5rem;
    z-index: 1050 !important;
    backface-visibility: visible !important;
    -webkit-backface-visibility: visible !important;
}

.menu-item {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    text-align: left;
    background: none;
    border: none;
    color: #333;
    font-size: 0.875rem;
    cursor: pointer;
    border-radius: 0.25rem;
    transition: background-color 0.15s ease;
}

.menu-item:hover {
    background-color: rgba(0,0,0,0.05);
}
/* Estilos base para las tarjetas de proyecto */
.project-card {
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    overflow: hidden;
    background-color: #fff;
    position: relative;
    backface-visibility: visible !important;
    -webkit-backface-visibility: visible !important;
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Evitar interferencia del hover cuando el modal está abierto */
.modal-open .project-card:hover,
.modal-open-custom .project-card:hover {
    transform: none !important;
}

/* Estilos adicionales para estabilidad del modal */
.modal-open-custom .btn-three-dots,
.modal-open .btn-three-dots {
    pointer-events: none;
}

.modal-open-custom .menu-three-dots,
.modal-open .menu-three-dots {
    display: none !important;
}

/* Asegurar que el botón de tres puntos no interfiera */
.btn-three-dots {
    background: transparent;
    color: #000;
    font-size: 1.2rem;
    line-height: 1;
    border-radius: 50%;
    padding: 0.25rem 0.4rem;
    border: none;
    position: relative;
    z-index: 10;
}

.btn-three-dots:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    background-color: #ffffff;
    margin-bottom: 20px;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Estilos para la lista de integrantes */
.contributors-ranking {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

.contributor-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e1e4e8;
}

.contributor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 12px;
    background-color: #f6f8fa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #24292e;
}

.contributor-info {
    flex: 1;
    min-width: 0;
}

.contributor-name {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #24292e;
}

.contributor-email {
    margin: 0;
    font-size: 12px;
    color: #586069;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Estilos para el ranking */
.contributor-rank {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #f6f8fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 12px;
    font-weight: 600;
    color: #586069;
}

.contributor-rank.top-1 {
    background-color: #ffd700;
    color: #000;
}

.contributor-rank.top-2 {
    background-color: #c0c0c0;
    color: #000;
}

.contributor-rank.top-3 {
    background-color: #cd7f32;
    color: #000;
}

/* Estilos para el modal */
.modal-content {
    border: none;
    border-radius: 12px;
}

.modal-header {
    border-bottom: 1px solid #e1e4e8;
    background-color: #f6f8fa;
}

/* Corrección específica para modales - evitar parpadeo */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1054 !important;
}

/* Evitar conflictos de backface-visibility en modales */
.modal-content,
.modal-dialog,
.modal-header,
.modal-body,
.modal-footer {
    backface-visibility: visible !important;
    -webkit-backface-visibility: visible !important;
    transform: translateZ(0);
}

html {
    overflow-x: hidden;
    scroll-behavior: smooth;
}
body {
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
}
.modal-body p {
    margin-top: 10px;
    font-size: 16px;
}

.modal-footer .btn {
    min-width: 180px; /* Botones del mismo ancho */
}

.projects-container {
    margin-top: 2rem;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

@media (min-width: 992px) {
    .projects-container {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
}
.container-fluid.projects-container {
    padding-left: var(--bs-gutter-x, 1.5rem) !important;
    padding-right: var(--bs-gutter-x, 1.5rem) !important;
}

/* Forzar misma alineación que la barra superior */
.container-fluid.projects-container {
    padding-left: 0 !important;
    padding-right: 0 !important;
    max-width: 100%; /* o el mismo valor que use tu barra */
}

/* Si la barra usa un max-width (por ejemplo en Bootstrap container) */
@media (min-width: 1200px) {
    .container-fluid.projects-container {
        max-width: 1140px; /* ajusta según el tamaño de tu barra */
        margin-left: auto;
        margin-right: auto;
    }
}


/* Asegurar que el dropdown del sidebar funcione correctamente */
.user-dropdown .dropdown-menu {
    z-index: 1600 !important;
    position: absolute !important;
    visibility: visible !important;
    opacity: 1;
    pointer-events: auto !important;
    display: none !important; /* Bootstrap lo mostrará cuando sea necesario */
}

.user-dropdown .dropdown-menu.show {
    display: block !important;
    z-index: 1600 !important;
    visibility: visible !important;
    opacity: 1 !important;
    pointer-events: auto !important;
}

/* Evitar que otros elementos interfieran con el dropdown del sidebar */
#sidebar-wrapper {
    z-index: 1500 !important;
}

#sidebar-wrapper .user-dropdown {
    z-index: 1550 !important;
    position: relative !important;
}

/* Forzar que el dropdown del usuario sea visible cuando está activo */
.user-dropdown .dropdown.show .dropdown-menu {
    display: block !important;
    z-index: 1600 !important;
}

/* Asegurar que el botón del dropdown funcione */
.user-dropdown .dropdown-toggle {
    pointer-events: auto !important;
}

/* Evitar interferencias de Alpine.js con el dropdown del sidebar */
.user-dropdown * {
    pointer-events: auto !important;
}

/* Forzar visibilidad del dropdown cuando se hace hover como fallback */
.user-dropdown:hover .dropdown-menu {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    transform: none !important;
}

/* CSS adicional para debug - remover en producción */
.user-dropdown .dropdown-menu {
    background-color: #343a40 !important;
    border: 1px solid #495057 !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.user-dropdown .dropdown-item {
    color: #fff !important;
}

.user-dropdown .dropdown-item:hover {
    background-color: #495057 !important;
    color: #fff !important;
}

</style>
@endsection


@section('content')
<div class="container-fluid projects-container">
@if (session('success'))
        <div id="success-alert" 
          class="alert alert-success alert-dismissible fade show mt-2" 
          style="background-color: #d1e7dd; color: #0f5132; display: flex; align-items: center; justify-content: space-between;">
          
          <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center;">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                 </div>
                 
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const alert = document.getElementById('success-alert');
                    if (alert) {
                        setTimeout(function () {
                            alert.style.transition = "opacity 0.5s ease";
                            alert.style.opacity = 0;
                            setTimeout(() => alert.remove(), 500);
                        }, 3000);
                    }
                });
            </script>
          </div>
      </div>
        @endif
   


    {{-- Proyectos recientes --}}
    <h1 class="page-title">
        Proyectos recientes
        @if (auth()->check() && (auth()->user()->usertype == 'admin' || auth()->user()->isSuperAdmin()))
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
                <h5 class="mb-1 text-black">{{ $project->name }}</h5>
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
        @can('update', $project)
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-edit">
                <i class="fas fa-edit"></i>
            </a>
        @endcan
        @can('delete', $project)
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button"
        class="btn btn-delete"
        title="Eliminar Proyecto"
        data-bs-toggle="modal"
        data-bs-target="#deleteProjectModal"
        data-project-id="{{ $project->id }}"
        data-project-name="{{ $project->name }}">
    <i class="fas fa-trash"></i>
</button>

            </form>
        @endcan
    </div>
</div>

        @if($project->descripcion)
            <button class="btn btn-sm btn-link mt-2 p-0 text-decoration-none text-info" type="button"
                    data-bs-toggle="collapse" data-bs-target="#desc-{{ $project->id }}">
                Mostrar descripción
            </button>
            <div class="collapse mt-2" id="desc-{{ $project->id }}">
                <p class="mb-0 text-muted">{{ $project->descripcion }}</p>
            </div>
        @endif
    </div>
<!-- Modal para confirmar eliminación de proyecto -->
<div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center"> 
            <div class="modal-header justify-content-center">
                <h5 class="modal-title" id="deleteProjectModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                    Confirmar Eliminación Permanente
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>¡ATENCIÓN!</strong> Esta acción no se puede deshacer.
                </div>
                <p id="deleteProjectText">¿Está seguro de que desea eliminar este proyecto?</p>
            </div>
            <div class="modal-footer justify-content-center"> <!-- Botones centrados -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3"></i> Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


@empty
    <p class="text-muted">No hay proyectos para mostrar.</p>
@endforelse

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Script original para modal de eliminación
    const modalEliminar = document.getElementById('modalConfirmarEliminarProyecto');
    if (modalEliminar) {
        modalEliminar.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = document.getElementById('formEliminarProyecto');
            if (form) {
                form.setAttribute('action', action);
            }
        });
    }

    // Mejoras para evitar parpadeo en modales de integrantes
    document.querySelectorAll('[id^="modal-integrantes-"]').forEach(modal => {
        modal.addEventListener('show.bs.modal', function () {
            // Desactivar efectos hover en las tarjetas mientras el modal esté abierto
            document.body.classList.add('modal-open-custom');
        });

        modal.addEventListener('hidden.bs.modal', function () {
            // Reactivar efectos hover
            document.body.classList.remove('modal-open-custom');
        });
    });

    // SOLUCIÓN COMPLETA PARA EL DROPDOWN DEL SIDEBAR
    function initializeSidebarDropdown() {
        console.log('Inicializando dropdown del sidebar...');
        const sidebarDropdown = document.getElementById('userDropdown');
        if (!sidebarDropdown) {
            console.error('No se encontró el elemento userDropdown');
            return;
        }

        console.log('Elemento userDropdown encontrado:', sidebarDropdown);
        console.log('Bootstrap disponible:', !!window.bootstrap);
        console.log('Bootstrap.Dropdown disponible:', !!(window.bootstrap && bootstrap.Dropdown));

        // Forzar inicialización de Bootstrap Dropdown
        if (window.bootstrap && bootstrap.Dropdown) {
            try {
                // Destruir instancia existente si existe
                const existingInstance = bootstrap.Dropdown.getInstance(sidebarDropdown);
                if (existingInstance) {
                    existingInstance.dispose();
                    console.log('Instancia existente del dropdown eliminada');
                }
                
                // Crear nueva instancia
                new bootstrap.Dropdown(sidebarDropdown);
                console.log('Sidebar dropdown inicializado correctamente con Bootstrap');
            } catch (error) {
                console.error('Error inicializando dropdown del sidebar:', error);
            }
        } else {
            console.warn('Bootstrap no está disponible, usando fallback manual');
        }

        // Manejar clicks manualmente como fallback
        sidebarDropdown.addEventListener('click', function(e) {
            console.log('Click en userDropdown detectado');
            e.preventDefault();
            e.stopPropagation();
            
            const dropdownMenu = sidebarDropdown.nextElementSibling;
            console.log('Dropdown menu encontrado:', dropdownMenu);
            
            if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                const isOpen = dropdownMenu.classList.contains('show');
                console.log('Estado actual del dropdown:', isOpen ? 'abierto' : 'cerrado');
                
                // Cerrar todos los otros dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
                
                // Cerrar dropdowns de Alpine.js
                document.querySelectorAll('[x-data*="open"]').forEach(dropdown => {
                    if (dropdown._x && dropdown.x.$data && dropdown._x.$data.open) {
                        dropdown.__x.$data.open = false;
                    }
                });
                
                // Toggle el dropdown del sidebar
                if (!isOpen) {
                    dropdownMenu.classList.add('show');
                    sidebarDropdown.setAttribute('aria-expanded', 'true');
                    console.log('Dropdown del sidebar abierto manualmente');
                } else {
                    dropdownMenu.classList.remove('show');
                    sidebarDropdown.setAttribute('aria-expanded', 'false');
                    console.log('Dropdown del sidebar cerrado manualmente');
                }
            }
        });

        // Cerrar dropdown cuando se hace click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                const dropdownMenu = sidebarDropdown.nextElementSibling;
                if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    sidebarDropdown.setAttribute('aria-expanded', 'false');
                    console.log('Dropdown del sidebar cerrado por click fuera');
                }
            }
        });
        
        // Test inmediato
        console.log('Test: Intentando abrir dropdown programáticamente...');
        const dropdownMenu = sidebarDropdown.nextElementSibling;
        if (dropdownMenu) {
            dropdownMenu.classList.add('show');
            setTimeout(() => {
                dropdownMenu.classList.remove('show');
                console.log('Test completado');
            }, 2000);
        }
    }

    // Inicializar después de que todo esté cargado
    setTimeout(initializeSidebarDropdown, 500);

    // Prevenir conflictos entre Alpine.js y Bootstrap
    document.addEventListener('alpine:init', () => {
        Alpine.directive('modal-safe', (el, { expression }, { evaluate }) => {
            el.addEventListener('click', () => {
                // Cerrar cualquier dropdown abierto antes de abrir modal, EXCEPTO el dropdown del sidebar
                const dropdowns = document.querySelectorAll('[x-data]');
                dropdowns.forEach(dropdown => {
                    // No cerrar el dropdown del sidebar
                    if (!dropdown.closest('.user-dropdown') && dropdown._x && dropdown._x.$data.open) {
                        dropdown.__x.$data.open = false;
                    }
                });
            });
        });
    });
});
</script>
@endpush

@push('css')
<style>
.modal-content {
    border: none;
    border-radius: 12px;
}
.modal-header {
    border-bottom: 1px solid #e1e4e8;
    background-color: #f6f8fa;
}
* {
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}
html {
    overflow-x: hidden;
    scroll-behavior: smooth;
}
body {
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
}
</style>
@endpush

@endsection