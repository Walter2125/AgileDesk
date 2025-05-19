<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agile-Desk') }}</title>

    <!-- Tabler Core CSS (Admin Template) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@2.28.0/dist/css/tabler.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Bootstrap Icons -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    :root {
        --sidebar-width: 280px;
        --sidebar-collapsed-width: 70px;
        --sidebar-bg: #212529;
        --sidebar-hover: #2c3136;
        --sidebar-active: #0d6efd;
        --transition-speed: 0.3s;
    }

    body {
        overflow-x: hidden;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    #wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Sidebar estático */
    #sidebar-wrapper {
        width: var(--sidebar-width);
        height: 100%;
        background-color: var(--sidebar-bg);
        transition: width var(--transition-speed) ease;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        z-index: 1000;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        overflow-y: auto;
    }
    /* Reducir el padding vertical de la clase container */
    .sidebar-heading {
        padding: 1.5rem 1rem;
        font-size: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .list-group-item {
        padding: 0.75rem 1.25rem;
        border: none;
        border-radius: 0 !important;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: var(--sidebar-hover) !important;
        padding-left: 1.5rem;
    }

    .list-group-item.active {
        background-color: var(--sidebar-active) !important;
        border-left: 4px solid #fff;
    }

    .list-group-item i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }

    /* Evita que el texto se desborde */
    .sidebar-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: calc(var(--sidebar-width) - 70px); /* Ancho máximo para texto */
    }

    #page-content-wrapper {
        width: 100%;
        margin-left: var(--sidebar-width); /* Usa margin en lugar de padding */
        transition: margin-left var(--transition-speed) ease;
        flex: 1;
    }

    .navbar {
        padding: 0.75rem 1rem;
        background-color: #fff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        position: sticky;
        top: 0;
        z-index: 900;
    }

    .navbar-brand {
        display: block;
        font-weight: bold;
        color: #212529;
    }

    .content-wrapper {
        padding: 0rem;
        transition: all var(--transition-speed) ease;
    }

    /* Collapsed sidebar styles */
    body.sidebar-collapsed #sidebar-wrapper {
        width: var(--sidebar-collapsed-width);
    }

    body.sidebar-collapsed #page-content-wrapper {
        margin-left: var(--sidebar-collapsed-width); /* Usa margin en lugar de padding */
    }

    body.sidebar-collapsed .sidebar-text {
        display: inline-block;
    }

    body.sidebar-collapsed .list-group-item i {
        margin-right: 0;
        font-size: 1.25rem;
    }

    body.sidebar-collapsed .sidebar-heading {
        text-align: center;
        padding: 1.5rem 0.5rem;
    }

    body.sidebar-collapsed .sidebar-heading span {
        display: none;
    }

    body.sidebar-collapsed .navbar-brand {
        display: block;
    }

    /* User dropdown in sidebar */
    .user-dropdown {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: auto;
    }

    .user-info {
        display: flex;
        align-items: center;
        padding: 1rem;
        color: white;
        cursor: pointer;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px; /* Evita que se encoja */
        border-radius: 50%;
        background-color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-weight: bold;
    }

    /* Limita el ancho para evitar desbordamiento */
    .user-info .sidebar-text {
        flex: 1;
        min-width: 0; /* Esto es crucial para que text-overflow funcione */
    }

    .user-info .sidebar-text div,
    .user-info .sidebar-text small {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Overlay for mobile */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    /* Layout vertical para el sidebar */
    .sidebar-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .list-group {
        flex-grow: 1;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Page title area */
    .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #dee2e6;
    }

    /* Notifications badge */
    .nav-badge {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        font-size: 0.65rem;
    }

    /* Dispositivos muy pequeños (menos de 320px) */
    @media (max-width: 320px) {
        :root {
            --sidebar-width: 220px;
        }

        .sidebar-heading {
            font-size: 1.2rem;
            padding: 1rem 0.75rem;
        }

        .list-group-item {
            padding: 0.5rem 1rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            min-width: 32px;
        }

        .content-wrapper {
            padding: 0.15rem;
        }
         body.sidebar-collapsed .sidebar-text {
            display: inline-block;
        }
    }

    /* Dispositivos plegables y de tamaño medio */
    @media (min-width: 321px) and (max-width: 375px) {
        :root {
            --sidebar-width: 230px;
        }
    }

    /* Media queries optimizados */
    /* Pantallas extra pequeñas (móviles, menos de 576px) */
    @media (max-width: 575.98px) {
        :root {
            --sidebar-width: 240px; /* Sidebar más pequeño en móviles */
        }

        #sidebar-wrapper {
            transform: translateX(-100%); /* Ocultar por defecto en móvil */
            width: var(--sidebar-width) !important;
        }

        body.sidebar-collapsed #sidebar-wrapper {
            transform: translateX(0); /* Mostrar al estar collapsed/abierto */
            width: var(--sidebar-width) !important;
        }

        #page-content-wrapper {
            margin-left: 0 !important;
        }

        body.sidebar-collapsed .sidebar-text {
            display: inline-block; /* Mostrar texto en móvil */
        }

        body.sidebar-collapsed .list-group-item i {
            margin-right: 0.75rem;
        }

        .navbar-brand {
            display: block;
            font-weight: bold;
            color: #212529;
        }

        .sidebar-heading .app-name {
            display: inline-block !important;
        }
    }

    /* Pantallas medianas y pequeñas */
    @media (min-width: 576px) and (max-width: 991.98px) {
        #sidebar-wrapper {
            transform: translateX(-100%);
            width: var(--sidebar-width) !important;
        }

        body.sidebar-collapsed #sidebar-wrapper {
            transform: translateX(0);
        }

        #page-content-wrapper {
            margin-left: 0 !important;
        }

        body.sidebar-collapsed .overlay {
            display: block;
        }

        .sidebar-heading .app-name {
            display: inline-block !important;
        }

        .navbar-brand {
            display: block;
        }
    }

    /* Pantallas grandes (desktops, 992px y más) */
    @media (min-width: 992px) {
        #sidebar-wrapper {
            transform: translateX(0); /* Siempre visible en escritorio */
        }

        #page-content-wrapper {
            margin-left: var(--sidebar-width);
        }

        body.sidebar-collapsed #page-content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }
    }


    /* iPads y tablets en modo retrato */
    @media (min-width: 768px) and (max-width: 991.98px) and (orientation: portrait) {
        .content-wrapper {
            padding: 0.25rem;
        }
    }

    /* iPads y tablets en modo paisaje */
    @media (min-width: 768px) and (max-width: 991.98px) and (orientation: landscape) {
        :root {
            --sidebar-width: 260px;
        }
    }

    /* Pantallas 2K y superiores */
    @media (min-width: 2048px) {
        :root {
            --sidebar-width: 320px;
            --sidebar-collapsed-width: 80px;
        }

        .sidebar-heading {
            font-size: 1.75rem;
            padding: 2rem 1.5rem;
        }

        .list-group-item {
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
        }

        .content-wrapper {
            padding: 0.5rem;
        }
    }

    /* Soporte para pantallas 4K */
    @media (min-width: 3840px) {
        :root {
            --sidebar-width: 400px;
            --sidebar-collapsed-width: 100px;
        }

        .sidebar-heading {
            font-size: 2rem;
            padding: 2.5rem 2rem;
        }

        .list-group-item {
            padding: 1.25rem 2rem;
            font-size: 1.25rem;
        }

        .content-wrapper {
            padding: 1.25rem;
        }
    }
</style>

    <!-- Estilos adicionales de las secciones -->
    @yield('styles')
    
</head>
<body class="font-sans antialiased">
    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-heading text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-code-slash me-2"></i>
                        <span class="sidebar-text app-name">Agile-Desk</span>
                    </div>
                    <!-- Botón para colapsar el sidebar -->
                    <button class="btn btn-sm btn-dark" onclick="toggleSidebar()">
                        <i class="bi bi-chevron-left" id="sidebar-toggle-icon"></i>
                    </button>
                </div>

                <div class="list-group list-group-flush mb-auto">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span class="sidebar-text">Inicio</span>
                    </a>

                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span class="sidebar-text">Inicio</span>
                    </a>
                    <!-- otros botones comentados por ahora -->
                </div>

                <!-- User dropdown in sidebar -->
                <div class="user-dropdown mt-auto">
                    <div class="dropup">
                        <div class="user-info" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'U' }}
                            </div>
                            <div class="sidebar-text">
                                <div>{{ Auth::check() ? Auth::user()->name : 'Usuario' }}</div>
                                <small class="text-muted">{{ Auth::check() ? Auth::user()->email : 'usuario@example.com' }}</small>
                            </div>
                        </div>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            @include('layouts.navigation')
            <!-- Main Content -->
            <div class="content-wrapper">
                <!-- Page Content -->
                <main>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            @if (session('message'))
                                <p>{{ session('message') }}</p>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Base Layout Script -->
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');

            // Cambiar el ícono del botón de colapsar
            const toggleIcon = document.getElementById('sidebar-toggle-icon');
            if (toggleIcon) {
                if (document.body.classList.contains('sidebar-collapsed')) {
                    // En dispositivos pequeños, 'sidebar-collapsed' significa abierto
                    if (window.innerWidth < 992) {
                        toggleIcon.classList.remove('bi-chevron-left');
                        toggleIcon.classList.add('bi-chevron-right');
                    } else {
                        // En dispositivos grandes, 'sidebar-collapsed' significa cerrado
                        toggleIcon.classList.remove('bi-chevron-left');
                        toggleIcon.classList.add('bi-chevron-right');
                    }
                } else {
                    toggleIcon.classList.remove('bi-chevron-right');
                    toggleIcon.classList.add('bi-chevron-left');
                }
            }
        }

        // Detectar cambios en el tamaño de la ventana
        window.addEventListener('resize', function() {
            // Si la pantalla se hace grande (más de 992px) y el sidebar estaba oculto, mostrarlo
            if (window.innerWidth >= 992 && !document.body.classList.contains('sidebar-collapsed')) {
                const toggleIcon = document.getElementById('sidebar-toggle-icon');
                if (toggleIcon) {
                    toggleIcon.classList.remove('bi-chevron-right');
                    toggleIcon.classList.add('bi-chevron-left');
                }
            }
        });

        // Close alerts automatically after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });
        });
    </script>

    <!-- Scripts adicionales de las secciones -->
    @yield('scripts')
</body>
</html>
