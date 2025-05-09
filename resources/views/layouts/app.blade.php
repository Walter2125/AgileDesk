<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tabler Core CSS (Admin Template) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@2.28.0/dist/css/tabler.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

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
        }

        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            transition: all var(--transition-speed) ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            z-index: 1000;
        }

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

        #page-content-wrapper {
            width: 100%;
            transition: all var(--transition-speed) ease;
        }

        .navbar {
            padding: 0.75rem 1rem;
            background-color: #fff !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .navbar-brand {
            display: none;
        }

        .content-wrapper {
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
        }

        /* Collapsed sidebar styles */
        body.sidebar-collapsed #sidebar-wrapper {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .sidebar-text {
            display: none;
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
            border-radius: 50%;
            background-color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            body.sidebar-collapsed #sidebar-wrapper {
                margin-left: 0;
                width: var(--sidebar-width);
            }

            body.sidebar-collapsed .sidebar-text {
                display: inline;
            }

            body.sidebar-collapsed .list-group-item i {
                margin-right: 0.75rem;
            }

            .navbar-brand {
                display: block;
            }

            body.sidebar-collapsed .overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
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
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-white d-flex align-items-center">
                <i class="bi bi-code-slash me-2"></i>
                <span>{{ config('app.name', 'Laravel') }}</span>
            </div>
            
            <div class="list-group list-group-flush mb-auto">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            
        <!-- otros botones    
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span class="sidebar-text">Usuarios</span>
                    @if(isset($pending_users) && $pending_users > 0)
                    <span class="badge bg-danger rounded-pill nav-badge">{{ $pending_users }}</span>
                    @endif
                </a>
                
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i>
                    <span class="sidebar-text">Reportes</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span class="sidebar-text">Configuración</span>
                </a>
                
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i>
                    <span class="sidebar-text">Notificaciones</span>
                    @if(isset($unread_notifications) && $unread_notifications > 0)
                    <span class="badge bg-danger rounded-pill nav-badge">{{ $unread_notifications }}</span>
                    @endif
                </a>
                --> 
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
                        <i class="bi bi-chevron-up ms-auto sidebar-text"></i>
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
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
 
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
        }
        
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
</body>
</html>