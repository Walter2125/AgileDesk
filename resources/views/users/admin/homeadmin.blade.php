@extends('layouts.app')

@section('title', 'Panel de Administración - Agile Desk')

@section('styles')
    <style>
        /* Estilos para el panel de administración */
        .admin-header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a90e2;
        }

        .admin-card {
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .admin-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .button-container {
                justify-content: flex-end;
                padding-right: 20px;
            }
        }

        .button-container .btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
            border: none;
            color: white;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 5px;
        }

        .button-container .btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd);
            transform: scale(1.05);
        }

        .quick-stats {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .quick-stats .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a90e2;
        }

        .quick-stats .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .card-body {
            background-color: #ffffff;
            color: #333333;
        }
        .admin-table th {
            background-color: #f8f9fa;
        }

        /* Estilos para paginación */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        /* Modo oscuro para el panel de administración */
        /* === Modo oscuro global para cards === */
        [data-theme="dark"] .card,
        [data-theme="dark"] .admin-card,
        [data-theme="dark"] .card-body {
          background-color: #2b2b2b !important;
          color: #e0e0e0 !important;
          box-shadow: 0 2px 5px rgba(0,0,0,0.5) !important;
        }

        /* Ajusta color de cabecera de las cards */
        [data-theme="dark"] .card-header,
        [data-theme="dark"] .admin-card .card-header {
          background-color: #333333 !important;
          color: #ffffff !important;
        }

        /* === Modo oscuro global para tablas === */
        [data-theme="dark"] .table,
        [data-theme="dark"] .admin-table,
        [data-theme="dark"] .table-responsive {
          background-color: #2b2b2b;
          color: #e0e0e0;
        }

        /* Encabezados de tabla */
        [data-theme="dark"] .table thead th {
          background-color: #333333;
          color: #ffffff;
          border-color: #444444;
        }

        /* Filas y celdas */
        [data-theme="dark"] .table tbody td,
        [data-theme="dark"] .table tbody tr {
          border-color: #3a3a3a;
          color: #e0e0e0;
          background-color: #2b2b2b;
        }

        /* Hover en filas */
        [data-theme="dark"] .table-hover tbody tr:hover {
          background-color: rgba(255,255,255,0.05);
        }

        /* Si usas badges, botones o enlaces dentro de tablas/cards: */
        [data-theme="dark"] .badge,
        [data-theme="dark"] .btn-outline-secondary,
        [data-theme="dark"] a {
          color: #f1f1f1;
        }

        /* Optional: scrollbars oscuros en contenedores con overflow */
        [data-theme="dark"] .table-responsive::-webkit-scrollbar {
          width: 8px;
        }
        [data-theme="dark"] .table-responsive::-webkit-scrollbar-thumb {
          background-color: #555;
          border-radius: 4px;
        }

         /* Estilos para el buscador en modo claro */
         .input-group .form-control {
            border-radius: 0.25rem 0 0 0.25rem;
        }

        .input-group-append .btn {
            border-radius: 0 0.25rem 0.25rem 0;
        }

        /* Estilos para el buscador en modo oscuro */
        [data-theme="dark"] .input-group .form-control {
            background-color: #333;
            border-color: #444;
            color: #e0e0e0;
        }

        [data-theme="dark"] .input-group-append .btn {
            background-color: #444;
            border-color: #555;
            color: #e0e0e0;
        }

        [data-theme="dark"] .input-group-append .btn:hover {
            background-color: #555;
            border-color: #666;
        }

        [data-theme="dark"] ::placeholder {
            color: #999;
            opacity: 1;
        }

        /* Estilos para paginación en modo oscuro */
        [data-theme="dark"] .pagination .page-link {
            background-color: #333;
            border-color: #444;
            color: #e0e0e0;
        }

        [data-theme="dark"] .pagination .page-item.active .page-link {
            background-color: #4a90e2;
            border-color: #357abd;
        }

        [data-theme="dark"] .pagination .page-link:hover {
            background-color: #444;
        }

        /* Integración con la plantilla Tabler/Bootstrap */
        .page-header {
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .page-title {
            margin-bottom: 0;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
@stop

@section('content')
    <!-- Encabezado de página con búsqueda -->
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center">
        <h1 class="page-title">Panel de Administración</h1>
        
        <div class="action-buttons">
            <div class="input-group" style="width: 250px;">
                <input type="text" class="form-control" id="searchProjects" placeholder="Buscar proyectos...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="btnSearchProjects">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción rápida -->
    <div class="button-container mb-4">
        <a href="*" class="btn">
            <i class="bi bi-people me-1"></i> Usuarios
        </a>
        <a href="{{ route('projects.create') }}" class="btn">
            <i class="bi bi-plus-circle me-1"></i> Crear Proyecto
        </a>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="quick-stats">
                <div class="stat-number">10</div>
                <div class="stat-label">Proyectos</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="quick-stats">
                <div class="stat-number">25</div>
                <div class="stat-label">Usuarios</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="quick-stats">
                <div class="stat-number">5</div>
                <div class="stat-label">Sprints Activos</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="quick-stats">
                <div class="stat-number">42</div>
                <div class="stat-label">Historias</div>
            </div>
        </div>
    </div>

    <!-- Listado de Proyectos -->
    <div class="card admin-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Proyectos Activos</span>
            <button class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus"></i> Nuevo Proyecto
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover admin-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th class="d-none d-md-table-cell">Miembros</th>
                            <th class="d-none d-md-table-cell">Sprint Actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="projectsTableBody">
                        <tr class="project-row">
                            <td>Proyecto Alpha</td>
                            <td>John Doe</td>
                            <td class="d-none d-md-table-cell">5</td>
                            <td class="d-none d-md-table-cell">Sprint 3</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="project-row">
                            <td>Proyecto Beta</td>
                            <td>Jane Smith</td>
                            <td class="d-none d-md-table-cell">3</td>
                            <td class="d-none d-md-table-cell">Sprint 1</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <ul class="pagination" id="projectsPagination">
                        <!-- La paginación se generará con JavaScript -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card admin-card mt-4">
        <div class="card-header">
            <span>Actividad Reciente</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table admin-table" id="activityTable">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th class="d-none d-md-table-cell">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="activityTableBody">
                        <tr class="activity-row">
                            <td>Juan Pérez</td>
                            <td>Creó una nueva historia de usuario</td>
                            <td class="d-none d-md-table-cell">Hace 2 horas</td>
                        </tr>
                        <tr class="activity-row">
                            <td>María López</td>
                            <td>Actualizó el estado del Sprint 2</td>
                            <td class="d-none d-md-table-cell">Hace 5 horas</td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <ul class="pagination" id="activityPagination">
                        <!-- La paginación se generará con JavaScript -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Historias de Usuario Recientes -->
    <div class="card admin-card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Historias de Usuario Recientes</span>
            <button class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus"></i> Nueva Historia
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th class="d-none d-md-table-cell">Tablero</th>
                            <th class="d-none d-sm-table-cell">Responsable</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="historiasTableBody">
                        <tr class="historia-row">
                            <td>Login de usuarios</td>
                            <td class="d-none d-md-table-cell">Autenticación</td>
                            <td class="d-none d-sm-table-cell">Carlos Rodríguez</td>
                            <td>
                                <span class="badge bg-danger">Alta</span>
                            </td>
                            <td>
                                <span class="badge bg-success">Completada</span>
                            </td>
                        </tr>
                        <tr class="historia-row">
                            <td>Panel de administrador</td>
                            <td class="d-none d-md-table-cell">Admin</td>
                            <td class="d-none d-sm-table-cell">Ana Gómez</td>
                            <td>
                                <span class="badge bg-warning">Media</span>
                            </td>
                            <td>
                                <span class="badge bg-warning">Pendiente</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <ul class="pagination" id="historiasPagination">
                        <!-- La paginación se generará con JavaScript -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de Sprints -->
    <div class="card admin-card mt-4">
        <div class="card-header">
            <span>Resumen de Sprints</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: #6fb3f2">
                            Sprint 1 - Arranque
                        </div>
                        <div class="card-body">
                            <p><strong>Proyecto:</strong> Proyecto Alpha</p>
                            <p><strong>Estado:</strong> Completado</p>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Inicio:</strong> 01/03/2025</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Fin:</strong> 15/03/2025</p>
                                </div>
                            </div>
                            <p><strong>Historias:</strong> 8</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: #4a90e2">
                            Sprint 2 - Funcionalidades Core
                        </div>
                        <div class="card-body">
                            <p><strong>Proyecto:</strong> Proyecto Alpha</p>
                            <p><strong>Estado:</strong> En progreso</p>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Inicio:</strong> 16/03/2025</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Fin:</strong> 30/03/2025</p>
                                </div>
                            </div>
                            <p><strong>Historias:</strong> 12</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header" style="background-color: #357abd">
                            Sprint 1 - Diseño
                        </div>
                        <div class="card-body">
                            <p><strong>Proyecto:</strong> Proyecto Beta</p>
                            <p><strong>Estado:</strong> En progreso</p>
                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Inicio:</strong> 10/03/2025</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Fin:</strong> 25/03/2025</p>
                                </div>
                            </div>
                            <p><strong>Historias:</strong> 6</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a los elementos DOM
            const searchInput = document.getElementById('searchProjects');
            const searchButton = document.getElementById('btnSearchProjects');
            const projectRows = document.querySelectorAll('.project-row');

            // Función para filtrar proyectos
            function filterProjects() {
                const searchTerm = searchInput.value.toLowerCase().trim();

                projectRows.forEach(row => {
                    const projectName = row.querySelector('td:first-child').textContent.toLowerCase();
                    const projectManager = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                    // Si el texto de búsqueda está en el nombre del proyecto o en el responsable
                    if (projectName.includes(searchTerm) || projectManager.includes(searchTerm)) {
                        row.style.display = ''; // Mostrar la fila
                    } else {
                        row.style.display = 'none'; // Ocultar la fila
                    }
                });
            }

            // Event listeners
            if (searchButton) {
                searchButton.addEventListener('click', filterProjects);
            }

            // También filtrar mientras se escribe (después de un pequeño delay)
            if (searchInput) {
                let typingTimer;
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(filterProjects, 500); // Esperar 500ms después de que el usuario deje de escribir
                });

                // Limpiar el timer si se sigue escribiendo
                searchInput.addEventListener('keydown', function() {
                    clearTimeout(typingTimer);
                });

                // Filtrar también al presionar Enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        filterProjects();
                    }
                });
            }
        });
    </script>

    <script>
        // Función de configuración de paginación para cualquier tabla
        function setupTablePagination(tableId, rowSelector, paginationId, rowsPerPage = 5) {
            const tableBody = document.getElementById(tableId);
            const pagination = document.getElementById(paginationId);
            
            if (!tableBody || !pagination) return;
            
            const rows = tableBody.querySelectorAll(rowSelector);

            // Calcular número de páginas
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            
            if (pageCount <= 1) {
                pagination.style.display = 'none';
                return;
            }

            // Limpiar paginación existente
            pagination.innerHTML = '';

            // Botón Anterior
            const prevLi = document.createElement('li');
            prevLi.classList.add('page-item');
            prevLi.innerHTML = '<a class="page-link" href="#">&laquo;</a>';
            pagination.appendChild(prevLi);

            // Páginas numeradas
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                if (i === 1) li.classList.add('active');

                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    showTablePage(tableBody, rows, i, rowsPerPage);

                    // Actualizar clase activa
                    const pageItems = pagination.querySelectorAll('.page-item');
                    pageItems.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });

                pagination.appendChild(li);
            }

            // Botón Siguiente
            const nextLi = document.createElement('li');
            nextLi.classList.add('page-item');
            nextLi.innerHTML = '<a class="page-link" href="#">&raquo;</a>';
            pagination.appendChild(nextLi);

            // Configurar eventos para prev/next
            prevLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.previousElementSibling && activeItem.previousElementSibling.classList.contains('page-item')) {
                    activeItem.previousElementSibling.querySelector('.page-link').click();
                }
            });

            nextLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.nextElementSibling && activeItem.nextElementSibling.classList.contains('page-item')) {
                    activeItem.nextElementSibling.querySelector('.page-link').click();
                }
            });

            // Mostrar primera página al inicio
            showTablePage(tableBody, rows, 1, rowsPerPage);
        }

        // Función para mostrar una página específica
        function showTablePage(tableBody, rows, page, rowsPerPage) {
            // Ocultar todas las filas
            rows.forEach(row => {
                row.style.display = 'none';
            });

            // Calcular rango de filas para la página actual
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, rows.length);

            // Mostrar filas de la página actual
            for (let i = startIndex; i < endIndex; i++) {
                rows[i].style.display = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de paginación para la tabla de proyectos
            setupTablePagination(
                'projectsTableBody',
                '.project-row',
                'projectsPagination',
                5
            );

            // Configuración de paginación para la tabla de historias
            setupTablePagination(
                'historiasTableBody',
                '.historia-row',
                'historiasPagination',
                5
            );

            // Configuración específica para la tabla de actividad reciente
            setupTablePagination(
                'activityTableBody',
                '.activity-row',
                'activityPagination',
                5
            );
        });
    </script>
@stop