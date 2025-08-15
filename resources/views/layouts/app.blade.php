<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Agile-Desk') }}</title>
    <script>
        // Detectar y aplicar el modo oscuro antes de renderizar
        (function() {
            const DARK_MODE_KEY = 'agiledesk-darkMode';
            const html = document.documentElement;
            const body = document.body;

            // 1. Añadir clase preload inmediatamente
            html.classList.add('dark-mode-preload');

            // 2. Determinar el modo preferido
            let darkMode = false;
            const saved = localStorage.getItem(DARK_MODE_KEY);

            if (saved === 'enabled') {
                darkMode = true;
            } else if (saved === 'disabled') {
                darkMode = false;
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                darkMode = true;
            }

            // 3. Aplicar el modo oscuro ANTES de que se renderice la página
            if (darkMode) {
                html.classList.add('dark-mode');
                //body.classList.add('dark-mode');
                html.style.backgroundColor = '#121218';
            } else {
                // Asegurar que en modo claro el fondo sea claro
                html.style.backgroundColor = '#f8f9fa';
            }

            // 4. Guardar el estado inicial para sincronización
            window.initialDarkModeState = darkMode;
        })();
    </script>

    <!-- Bootstrap CSS local -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons local -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons-fixed.css') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/agiledesk.png') }}" type="image/x-icon">
    <!-- Fonts locales (usando fuentes del sistema) -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>


    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/all-fixed.css') }}">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light-mode-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout-fixes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/breadcrumb-fixes.css') }}">

    <style>
    /* Normalización para compatibilidad entre SO */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        overflow-x: hidden;
        scroll-behavior: smooth;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    /* Fixes para navbar - NOTA: definición completa más adelante */
    .navbar-optimized .container-fluid {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .navbar-optimized .btn-optimized {
        flex-shrink: 0;
        min-width: auto;
        white-space: nowrap;
        overflow: hidden;
    }

    /* Breadcrumbs mejorados */
    .breadcrumb {
        margin-bottom: 0;
        padding: 0;
        background: transparent;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #6c757d;
        font-weight: bold;
        margin: 0 0.5rem;
    }

    .breadcrumb-item {
        display: inline-flex;
        align-items: center;
    }

    .breadcrumb-item a {
        color: var(--bs-primary, #0d6efd);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-item a:hover {
        color: var(--bs-primary-dark, #0a58ca);
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d;
        font-weight: 500;
    }

    /* Responsive fixes */
    @media (max-width: 991.98px) {
        .navbar-optimized .d-lg-flex {
            display: none !important;
        }

        .navbar-optimized .d-lg-none {
            display: flex !important;
        }

        .navbar-sidebar-header {
            margin-left: 0 !important;
        }
    }

    @media (min-width: 992px) {
        .navbar-optimized .d-lg-flex {
            display: flex !important;
        }

        .navbar-optimized .d-lg-none {
            display: none !important;
        }
    }

    /* Eliminamos la repetición del html, body que causa problemas */
    /* Mejoras específicas para compatibilidad entre sistemas operativos */
    @media screen {
        /* Asegurar consistencia de fuentes entre SO */
        html, body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-feature-settings: "liga", "kern";
        }

        /* Base font size más robusta */
        html {
            font-size: 16px; /* Base explícita */
        }

        body {
            font-size: 1rem;
            line-height: 1.5;
            font-family: "Figtree", -apple-system, BlinkMacSystemFont, "Segoe UI",
                         "Ubuntu", "Cantarell", "Noto Sans", sans-serif;
        }

        /* Mejorar el escalado en sistemas Linux/macOS */
        .sidebar-heading {
            font-size: clamp(1.25rem, 2.5vw, 1.5rem);
            padding: clamp(1rem, 3vw, 1.5rem);
        }

        .list-group-item {
            font-size: clamp(0.875rem, 2vw, 1rem);
            padding: clamp(0.5rem, 2vw, 0.75rem) clamp(1rem, 3vw, 1.25rem);
        }

        /* Asegurar tamaños mínimos consistentes */
        .user-avatar {
            width: clamp(32px, 5vw, 40px);
            height: clamp(32px, 5vw, 40px);
            min-width: clamp(32px, 5vw, 40px);
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        /* Mejoras específicas para Firefox/Linux */
        @supports (-moz-appearance: none) {
            body {
                font-size: 1.1rem; /* Ligeramente más grande en Firefox */
            }

            .sidebar-heading {
                font-size: 1.6rem;
            }

            .list-group-item {
                font-size: 1rem;
                padding: 0.8rem 1.3rem;
            }
        }
    }

    /* Media query específica para detectar sistemas con DPI bajo */
    @media screen and (max-resolution: 96dpi) {
        html {
            font-size: 18px; /* Base más grande para DPI bajo */
        }

        .sidebar-heading {
            font-size: 1.75rem;
            padding: 1.75rem 1.25rem;
        }

        .list-group-item {
            font-size: 1.1rem;
            padding: 0.85rem 1.4rem;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            min-width: 44px;
            font-size: 1.1rem;
        }
    }

    /* Para sistemas con scaling alto */
    @media screen and (min-resolution: 144dpi) {
        html {
            font-size: 15px; /* Base ligeramente menor para DPI alto */
        }
    }

            border: 2px solid #fff2;
            box-sizing: border-box; /* Permite padding interno sin crecer de 40x40 */
    @supports (font-variant-ligatures: normal) {
        /* Mejoras para sistemas que probablemente usan FreeType o CoreText */
        body {
            font-weight: 450; /* Peso ligeramente mayor para mejor legibilidad */
            letter-spacing: 0.01em;
        }

        .sidebar-heading {
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .list-group-item {
            font-weight: 500;
            letter-spacing: 0.005em;
        }
    }

    /* Asegurar que los elementos no se vean muy pequeños */
    /* NOTA: sidebar-heading se define más adelante con tamaño específico */

    .list-group-item {
        min-font-size: 0.875rem;
    }

    .navbar {
        min-height: 3.5rem;
    }

    /* Botones más grandes para mejor usabilidad */
    .sidebar-toggle-btn {
        min-width: 32px;
        min-height: 32px;
        font-size: clamp(1rem, 2.5vw, 1.2rem);
    }

    /* Iconos con tamaño consistente */
    .list-group-item i {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        min-width: 20px;
    }

    :root {
        --sidebar-width: 250px;
        --sidebar-collapsed-width: 56px; /* Más angosto, como AdminLTE */
        --sidebar-bg: #212529;
        --sidebar-hover: #2c3136;
        --sidebar-active: #0d6efd;
        --transition-speed: 0.3s;
    }

    body {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    #wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Sidebar estático con scroll optimizado */
    #sidebar-wrapper {
        width: var(--sidebar-width);
        height: 100vh;
        background-color: var(--sidebar-bg);
        transition: width var(--transition-speed) ease;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        z-index: 1500;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        overflow-y: hidden;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
    }
        scrollbar-color: rgba(255, 255, 255, 0.3) transparent; /* Para Firefox */
    }

    /* Personalizar scrollbar del sidebar para Webkit */
    #sidebar-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    #sidebar-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    #sidebar-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    #sidebar-wrapper::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.5);
    }
    /* NOTA: sidebar-heading se define más adelante con altura específica */

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
        min-height: 100vh;
        padding: 0; /* Sin padding para eliminar espacios */
        overflow-x: hidden; /* Evitar scroll horizontal */
        display: flex;
        flex-direction: column;
        padding-top: 4rem !important; /* Exactamente la altura del navbar */
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        padding-top: 60px !important; /* Espacio para el navbar fijo */
    }

    .navbar {
        padding: 0.75rem 1rem;
        background-color: #fff !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        position: static; /* Permite que se desplace con el scroll */
        z-index: 900;
        margin: 0; /* Sin margen para eliminar espacios */
    }

    .content-wrapper {
        padding: 0 !important; /* Eliminar padding para aprovechar toda la pantalla */
        transition: all var(--transition-speed) ease;
        overflow-x: hidden; /* Evitar scroll horizontal */
        min-height: calc(100vh - 56px); /* Altura mínima menos el navbar */
        margin: 0 !important; /* Sin márgenes */
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    /* Mejorar el comportamiento del scroll en contenedores internos */
    .container-fluid {
        overflow-x: hidden;
        max-width: 100% !important; /* Usar todo el ancho disponible */
        padding-left: 0rem;
        padding-right: 0rem;
    }

    /* Asegurar que el main use toda la altura disponible */
    main {
        min-height: calc(100vh - 56px); /* Altura completa menos navbar */
        width: 100%;
    }

    /* Para páginas con contenido dinámico */
    .content-area {
        min-height: calc(100vh - 120px); /* Altura menos navbar y breadcrumbs */
        width: 100%;
    }

    /* Scroll suave para toda la aplicación */
    * {
        scroll-behavior: smooth;
    }

    /* Mediaquery para dispositivos móviles */
    @media (max-width: 768px) {
        .sidebar-wrapper {
            position: static; /* o relative, según el contexto */
            display: block !important;
            transform: none !important;
            left: 0;
            top: 0;
            height: auto;
            z-index: auto;
            visibility: visible !important;
            opacity: 1 !important;
        }
        .content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }

        .container-fluid.content-area {
            padding: 0.5rem !important;
        }

        .main-content {
            padding: 0 !important;
            margin: 0 !important;
        }

        .breadcrumb-container {
            padding: 0.25rem 0.5rem !important;
        }

        #page-content-wrapper {
            margin-left: 0 !important;
        }
    }

    /* Asegurar que todos los elementos usen el ancho completo */
    html, body {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        margin: 0;
        padding: 0;
    }

    /* Layout completo sin espacios innecesarios */
    .container-fluid.content-area {
        padding: 0.75rem;
        padding-top: 0;
        min-height: calc(100vh - 110px);
        width: 100% !important;
        max-width: none !important;
        margin-top: 0;
    }

    /* Asegurar que todos los encabezados no tengan margen superior */
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
        margin-top: 0;
        padding-top: 0;
    }

    /* Contenido de página completo */
    .content-wrapper {
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Estilos para el contenido principal */
    .main-content {
        display: flex;
        flex-direction: column;
        padding: 0 !important;
        margin: 0 !important;
        width: 100%;
    }

    /* Contenedor de migas de pan */
    .breadcrumb-container {
        margin-top: 0;
        padding-top: 0.5rem;
    }

    /* Asegurar que las tarjetas y contenedores tengan ancho completo */
    .card, .table-responsive {
        width: 100% !important;
    }

    /* Elementos de interfaz siempre visibles */
    .row {
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .navbar-brand {
        display: block;
        font-weight: bold;
        color: #212529;
    }

    .content-wrapper {
        padding: 0; /* Sin padding adicional */
        transition: all var(--transition-speed) ease;
    }

    /* Botón toggle del sidebar personalizado */
    .sidebar-toggle-btn {
        background: transparent;
        border: none;
        color: #ffffff;
        padding: 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem; /* más espacio horizontal contra los bordes */
        width: 32px;
        height: 32px;
    }

    .sidebar-toggle-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .sidebar-toggle-btn:focus {
        box-shadow: none;
        outline: none;
        background-color: rgba(255, 255, 255, 0.15);
    }

    .sidebar-toggle-btn i {
        font-size: 1rem;
        transition: transform 0.2s ease;
    }

    /* Collapsed sidebar styles */
    body.sidebar-collapsed #sidebar-wrapper {
        width: var(--sidebar-collapsed-width);
    }

    body.sidebar-collapsed #page-content-wrapper {
        margin-left: var(--sidebar-collapsed-width);
    }

    body.sidebar-collapsed .sidebar-text,
    body.sidebar-collapsed .sidebar-submenu {
        display: none !important;
    }

    body.sidebar-collapsed .list-group-item {
        padding: 0.75rem 0 !important;
        text-align: center;
        justify-content: center;
    }

    body.sidebar-collapsed .list-group-item i {
        margin-right: 0 !important;
        font-size: 1.25rem;
    }

    body.sidebar-collapsed .sidebar-has-tree .bi-chevron-down {
        display: none !important;
    }

    body.sidebar-collapsed .sidebar-has-tree {
        cursor: default;
    }        /* En pantallas grandes */
    @media (min-width: 992px) {
        body.sidebar-collapsed .sidebar-heading span {
            display: none;
        }
    }

    /* Ajustes específicos para pantallas pequeñas */
    @media (max-width: 767.98px) {
        #page-content-wrapper {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .breadcrumb-container {
            padding-top: 0 !important;
            margin-top: 0.25rem !important;
        }

        .content-area {
            padding-top: 0.25rem !important;
        }

        .navbar-optimized {
            margin-bottom: 0 !important;
        }
        .sidebar-wrapper {
            position: static;
            width: 100%;
            height: auto;
            display: block !important;
            transform: none !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    }

    /* En tablets, mostrar nombre de app */
    @media (max-width: 991.98px) {
        body.sidebar-collapsed .sidebar-heading span {
            display: inline-block;
        }

        /* Asegurar que el contenido use toda la pantalla en móviles */
        #page-content-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .content-wrapper {
            padding: 0 !important;
            margin-top: 0 !important;
        }

        .container-fluid {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            max-width: 100% !important;
        }

        main {
            min-height: calc(100vh - 56px) !important;
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .breadcrumb-container {
            padding-top: 0.25rem !important;
            padding-bottom: 0 !important;
        }
    }

    body.sidebar-collapsed .sidebar-heading {
        text-align: center;
        padding: 1.5rem 0.5rem;
    }

    /* Submenú oculto por completo cuando está colapsado */
    .sidebar-submenu {
        display: none;
        background: #23272b;
        padding-left: 0;
    }

    .sidebar-submenu.open {
        display: block;
        animation: fadeIn 0.3s;
    }

    body.sidebar-collapsed .sidebar-submenu,
    body.sidebar-collapsed .sidebar-submenu.open {
        display: none !important;
    }

    /* User dropdown in sidebar */
    .user-dropdown {
        position: relative;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        /* margin-top:auto removido para evitar que desaparezca en móviles */
        padding-bottom: .5rem;
    }

    @media (max-width: 767.98px) {
        .sidebar .user-dropdown {
            position: sticky;
            bottom: 0;
            background: rgba(0,0,0,0.15);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            padding-top: .5rem;
            z-index: 1200;
        }
        .sidebar .user-dropdown .dropdown-menu {
            max-height: 50vh;
            overflow-y: auto;
        }
    }

    .user-info {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        color: white;
        cursor: pointer;
        background: transparent !important;
        border: none !important;
        text-decoration: none !important;
    }


    .user-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd 60%, #6c63ff 100%);
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(13,110,253,0.08);
        transition: background 0.3s, color 0.3s, box-shadow 0.3s;
        border: 2px solid #fff2;
        /* Mejoras para centrado perfecto */
        line-height: 1;
        text-align: center;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        letter-spacing: 0;
        text-transform: uppercase;
        /* Eliminar cualquier padding o margin que pueda afectar el centrado */
        padding: 0;
        margin: 0;
        /* Asegurar que el texto no tenga espacio extra */
        white-space: nowrap;
        overflow: hidden;
        /* Centrado adicional para navegadores antiguos */
        vertical-align: middle;
        /* Compensar cualquier offset de la fuente */
        position: relative;
    }

    .user-avatar::before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        width: 0;
    }

    .user-info.user-dropdown-btn {
        border-radius: 0.5rem;
        transition: background 0.2s, box-shadow 0.2s;
        box-shadow: none;
        background: rgba(255,255,255,0.03);
        padding: 0.5rem 0.75rem !important; /* separa del borde (override p-0) */
    }

    .user-info.user-dropdown-btn:hover, .user-info.user-dropdown-btn:focus {
        background: rgba(13,110,253,0.08);
        box-shadow: 0 2px 8px rgba(13,110,253,0.10);
    }

    /* Centrar avatar y ocultar texto cuando sidebar está colapsado */
    body.sidebar-collapsed .user-info.user-dropdown-btn {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    body.sidebar-collapsed .user-avatar {
        margin: 0 auto !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
    @media (max-width: 991.98px) {
        body.sidebar-collapsed .user-info .sidebar-text {
            display: flex !important;
            flex-direction: column;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
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

    /* Dropdown específico del sidebar */
    .user-dropdown .dropdown-menu {
        position: absolute !important;
        transform: none !important;
        margin-bottom: 0.5rem;
    min-width: 200px;
    max-width: calc(100vw - 2rem);
    width: max-content;
    z-index: 1600 !important;
    overflow-y: auto;
    max-height: 60vh;
    white-space: normal;
    }

    .user-dropdown .dropup .dropdown-menu {
        bottom: 100% !important;
        top: auto !important;
    }

    /* Dropdown cuando sidebar está colapsado */
    body.sidebar-collapsed .user-dropdown .dropdown-menu {
        left: 100% !important; /* Aparece a la derecha del sidebar colapsado */
        bottom: 0 !important;
        top: auto !important;
        margin-left: 0.5rem;
    margin-bottom: 0 !important;
    max-height: 80vh;
    }

    body.sidebar-collapsed .user-dropdown .dropup .dropdown-menu {
        left: 100% !important;
        bottom: 0 !important;
        top: auto !important;
    }

    /* Ocultar texto del usuario cuando sidebar está colapsado */
    body.sidebar-collapsed .user-info .sidebar-text {
        display: none;
    }

    /* Centrar avatar cuando sidebar está colapsado */
    body.sidebar-collapsed .user-info {
        justify-content: center;
        padding: 0.75rem 0.5rem;
    }

    body.sidebar-collapsed .user-avatar {
        margin-right: 0;
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
        z-index: 1499;
    }

    /* Layout vertical para el sidebar */
    .sidebar-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .list-group {
        flex-grow: 1;
        overflow-y: visible;
        max-height: calc(100vh - 200px);
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

    .sidebar-has-tree {
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
    }

    .sidebar-has-tree .bi-chevron-down {
        transition: transform 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-height: 600px) {
        .user-dropdown .dropdown-menu {
            max-height: 55vh;
        }
    }

    /* Asegurar que las alertas sean visibles por encima del navbar */
    .alert {
        position: relative !important;
        z-index: 1500 !important; /* Mayor que el navbar (z-index: 1400) */
        margin: 0.5rem 1rem !important;
        border-radius: 0.25rem !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: 0.875rem !important;
        line-height: 1.4 !important;
        padding: 0.75rem 1rem !important;
        max-width: calc(100% - 2rem) !important;
        border: 1px solid !important;
    }

    /* Contenedor de alertas fijo */
    .alerts-container {
        transition: left var(--transition-speed) ease !important;
    }

    /* Ajustar posición cuando sidebar está colapsado */
    body.sidebar-collapsed .alerts-container {
        left: var(--sidebar-collapsed-width) !important;
    }

    /* Responsive para móviles y tablets */
    @media (max-width: 991.98px) {
        .alerts-container {
            left: 0 !important;
        }

        body.sidebar-collapsed .alerts-container {
            left: 0 !important;
        }

        .sidebar-wrapper {
            position: static;
            width: 100%;
            height: auto;
            display: block !important;
            transform: none !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    }

    /* Animación de entrada para alertas */
    .alert.fade.show {
        animation: slideInFromTop 0.3s ease-out !important;
    }

    @keyframes slideInFromTop {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Restaurar los colores estándar de Bootstrap para las alertas */
    .alert-danger {
        color: #721c24 !important;
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
    }

    .alert-success {
        color: #155724 !important;
        background-color: #d4edda !important;
        border-color: #c3e6cb !important;
    }

    .alert-warning {
        color: #856404 !important;
        background-color: #fff3cd !important;
        border-color: #ffeaa7 !important;
    }

    .alert-info {
        color: #0c5460 !important;
        background-color: #d1ecf1 !important;
        border-color: #bee5eb !important;
    }

    /* Botón de cerrar normal */
    .alert .btn-close {
        position: relative !important;
        z-index: 1501 !important;
        opacity: 0.75 !important;
        font-size: 0.75rem !important;
        width: 1rem !important;
        height: 1rem !important;
        padding: 0 !important;
    }

    .alert .btn-close:hover {
        opacity: 1 !important;
    }

    .alert .btn-close-sm {
        font-size: 0.7rem !important;
        width: 0.875rem !important;
        height: 0.875rem !important;
    }

    /* Estilos para el contenido de las alertas */
    .alert strong {
        font-weight: 600 !important;
    }

    .alert p {
        margin: 0.5rem 0 0 0 !important;
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
            font-size: 1rem;
            line-height: 1;
        }

        .content-wrapper {
            padding: 0.15rem;
        }
        body.sidebar-collapsed .sidebar-text {
            display: none;
        }

        body.sidebar-collapsed .list-group-item {
            text-align: center;
            padding: 0.5rem 0;
        }

        body.sidebar-collapsed .list-group-item:hover {
            padding-left: 0;
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
            --sidebar-collapsed-width: 56px;
        }

        #sidebar-wrapper {
            transform: translateX(-100%); /* Ocultar por defecto en móvil */
            width: var(--sidebar-width) !important;
        }

        body.sidebar-collapsed #sidebar-wrapper {
            transform: translateX(0); /* Mostrar al estar collapsed/abierto */
            width: var(--sidebar-collapsed-width) !important;
        }

        #page-content-wrapper {
            margin-left: 0 !important;
        }

        /* En móviles, mantener solo iconos cuando está colapsado */
        body.sidebar-collapsed .sidebar-text {
            display: none !important;
        }

        body.sidebar-collapsed .list-group-item {
            text-align: center;
            padding: 0.75rem 0;
        }

        body.sidebar-collapsed .list-group-item i {
            margin-right: 0;
        }

        body.sidebar-collapsed .list-group-item:hover {
            padding-left: 0;
        }

        /* Mostrar tooltips en móviles cuando está colapsado */
        body.sidebar-collapsed .list-group-item::after {
            display: block;
        }

        .navbar-brand {
            display: block;
            font-weight: bold;
            color: #212529;
        }

        .sidebar-heading .app-name {
            display: inline-block !important;
        }
        .sidebar-wrapper {
            position: static;
            width: 100%;
            height: auto;
            display: block !important;
            transform: none !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
    }

    /* Pantallas medianas y pequeñas */
    @media (min-width: 576px) and (max-width: 991.98px) {
        :root {
            --sidebar-width: 220px; /* Sidebar más angosto en tablets */
            --sidebar-collapsed-width: 56px; /* Sidebar colapsado más angosto en tablets */
        }
        #sidebar-wrapper {
            transform: translateX(-100%);
            width: var(--sidebar-width) !important;
        }

        /* Sidebar expandido (visible) */
        body:not(.sidebar-collapsed) #sidebar-wrapper {
            transform: translateX(0) !important;
            width: var(--sidebar-width) !important;
        }

        /* Sidebar colapsado (oculto en tablets) */
        body.sidebar-collapsed #sidebar-wrapper {
            transform: translateX(-100%) !important;
            width: var(--sidebar-collapsed-width) !important;
        }
        #page-content-wrapper {
            margin-left: 0 !important;
        }
        body.sidebar-collapsed .overlay {
            display: none; /* Ocultar overlay cuando sidebar está colapsado */
        }

        /* Mostrar overlay cuando sidebar está expandido en tablets */
        body:not(.sidebar-collapsed) .overlay {
            display: block;
        }
        body.sidebar-collapsed .sidebar-text,
        body.sidebar-collapsed .sidebar-submenu {
            display: inline-block !important;
        }
        body.sidebar-collapsed .list-group-item {
            text-align: left;
            padding: 0.75rem 1.25rem !important;
        }
        body.sidebar-collapsed .list-group-item i {
            margin-right: 0.75rem !important;
        }
        body.sidebar-collapsed .list-group-item:hover {
            padding-left: 1.5rem;
        }
        body.sidebar-collapsed .sidebar-has-tree .bi-chevron-down {
            display: inline-block !important;
        }
        .sidebar-heading .app-name {
            display: inline-block !important;
        }
        .navbar-brand {
            display: block;
        }
        /* Mejorar el área de usuario en tablets */
         .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem; /* Espacio entre avatar y texto */
        padding: 0.5rem 0.75rem;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        min-width: 36px;
        border-radius: 50%;
        font-size: 1rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #eee; /* o tu color base */
        color: #333;            /* contraste del texto */
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

    /* Pantallas ultrawide (21:9 y 32:9) */
    @media (min-aspect-ratio: 21/9) and (min-width: 1680px) {
        :root {
            --sidebar-width: 350px;
            --sidebar-collapsed-width: 70px;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.75rem;
        }

        .sidebar-heading {
            font-size: 1.6rem;
        }

        .list-group-item {
            font-size: 1.05rem;
        }
    }

    /* Monitores gaming ultrawide (3440x1440) */
    @media (min-width: 3440px) and (max-width: 3839px) {
        :root {
            --sidebar-width: 380px;
            --sidebar-collapsed-width: 85px;
        }

        .sidebar-heading {
            font-size: 1.8rem;
            padding: 2rem 1.5rem;
        }

        .list-group-item {
            padding: 1rem 1.75rem;
            font-size: 1.15rem;
        }

        .content-wrapper {
            padding: 1rem;
            max-width: 1600px;
            margin: 0 auto;
        }
    }

    /* Soporte para pantallas 4K (3840x2160) */
    @media (min-width: 3840px) and (max-width: 5119px) {
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
            max-width: 1800px;
            margin: 0 auto;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            min-width: 50px;
        }

        .navbar {
            padding: 1rem 1.5rem;
        }
    }

    /* Pantallas 5K y superiores */
    @media (min-width: 5120px) {
        :root {
            --sidebar-width: 480px;
            --sidebar-collapsed-width: 120px;
        }

        .sidebar-heading {
            font-size: 2.5rem;
            padding: 3rem 2.5rem;
        }

        .list-group-item {
            padding: 1.5rem 2.5rem;
            font-size: 1.5rem;
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 2200px;
            margin: 0 auto;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            min-width: 60px;
            font-size: 1.5rem;
        }

        .navbar {
            padding: 1.25rem 2rem;
        }
    }

    /* Pantallas muy anchas pero no tan altas (resoluciones específicas) */
    @media (min-width: 1920px) and (max-height: 800px) {
        .content-wrapper {
            padding: 0.5rem;
        }

        .sidebar-heading {
            padding: 1.25rem 1rem;
        }

        .list-group-item {
            padding: 0.5rem 1rem;
        }
    }

    /* Optimización para resoluciones comunes de laptops gaming */
    @media (min-width: 1366px) and (max-width: 1599px) {
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 60px;
        }

        .content-wrapper {
            padding: 0.5rem;
        }
    }

    /* Optimización para monitores QHD (2560x1440) */
    @media (min-width: 2560px) and (max-width: 3439px) {
        :root {
            --sidebar-width: 320px;
            --sidebar-collapsed-width: 75px;
        }

        .sidebar-heading {
            font-size: 1.6rem;
            padding: 1.75rem 1.25rem;
        }

        .list-group-item {
            padding: 0.875rem 1.5rem;
            font-size: 1.1rem;
        }

        .content-wrapper {
            padding: 0.75rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            min-width: 45px;
        }
    }

    /* Pantallas con orientación vertical (monitores rotados) */
    @media (orientation: portrait) and (min-height: 1080px) {
        :root {
            --sidebar-width: 280px;
        }

        .content-wrapper {
            padding: 0.75rem;
        }

        .list-group {
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }
    }

    /* Dispositivos con densidad de píxeles alta (Retina y similares) */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .sidebar-heading {
            font-weight: 500;
        }

        .list-group-item {
            font-weight: 400;
        }

        .user-avatar {
            font-weight: 600;
            /* Centrado mejorado para pantallas de alta densidad */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    }

    /* Ajustes adicionales para centrado perfecto del avatar en todos los navegadores */
    .user-avatar {
        /* Compatibilidad cross-browser para centrado perfecto */
        place-items: center; /* CSS Grid fallback */
        place-content: center; /* CSS Grid fallback */
    }

    /* Centrado específico para navegadores webkit */
    @supports (-webkit-appearance: none) {
        .user-avatar {
            -webkit-text-align-last: center;
            -webkit-user-select: none;
        }
    }

    /* Centrado específico para Firefox */
    @-moz-document url-prefix() {
        .user-avatar {
            -moz-text-align-last: center;
            -moz-user-select: none;
        }
    }

    /* Ajuste fino para el navbar */
    .navbar-optimized {
        padding-left: var(--navbar-padding-x);
        padding-right: var(--navbar-padding-x);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        height: 4rem;
        min-height: 0;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        background-color: var(--bs-body-bg, #fff);
    }

    /* Mejoras para los elementos dentro del navbar */
    .navbar-optimized .navbar-brand {
        font-weight: 600;
        color: var(--bs-primary, #0d6efd);
        padding: 0.5rem 0;
        margin-right: 1rem;
    }

    .navbar-optimized .nav-link {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        transition: color 0.2s ease;
    }

    .navbar-optimized .navbar-toggler {
        border: none;
        padding: 0.25rem 0.5rem;
        box-shadow: none;
    }

    .navbar-optimized .navbar-toggler:focus {
        outline: none;
        box-shadow: none;
    }
    /* ========================================================================
       ALINEACIÓN PERFECTA: NAVBAR Y SIDEBAR-HEADING
       ========================================================================

       Ambos elementos deben tener EXACTAMENTE la misma altura para mantener
       la alineación visual perfecta:

       - height: 4rem (64px)
       - min-height: 4rem
       - max-height: 4rem
       - box-sizing: border-box
       - padding: 0 var(--navbar-padding-x)

       Esto asegura que el navbar y el sidebar-heading estén perfectamente
       alineados independientemente del contenido o sistema operativo.
       ======================================================================== */

    /* Ajustes optimizados para alineación perfecta */

:root {
    --navbar-padding-x: 1rem;
}

.sidebar-heading {
    width: 100%;
    padding: 0 var(--navbar-padding-x);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 4rem;
    min-height: 4rem;
    max-height: 4rem;
    box-sizing: border-box;
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
}

/* Asegura que el ancho del sidebar coincida exactamente */
#sidebar-wrapper {
    width: calc(var(--sidebar-width) - 1px); /* Compensa el borde del navbar */
    left: 0;
    top: 0;
    transform: none !important; /* Anula transformaciones conflictivas */
    border-right: 1px solid rgba(0, 0, 0, 0.1); /* Borde que coincide con navbar */
    position: fixed;
    height: 100vh;
    box-sizing: border-box;
    z-index: 1500;
    overflow: hidden;
}

/* Corrección para el estado colapsado */
.sidebar-collapsed #sidebar-wrapper {
    width: calc(var(--sidebar-collapsed-width) - 1px);
}

/* Ajuste completo para el navbar */
.navbar-optimized {
    padding-left: var(--navbar-padding-x);
    padding-right: var(--navbar-padding-x);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    height: 4rem;
    min-height: 4rem;
    max-height: 4rem;
    box-sizing: border-box;
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    background-color: var(--bs-body-bg, #fff);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1400;
}

/* ========================================================================
       ALINEACIÓN CONSISTENTE ENTRE BREADCRUMBS Y CONTENIDO
       ======================================================================== */

    /* Asegurar que todo el contenido use el mismo padding lateral que las migas de pan */
    .content-section {
        /* El contenido principal ya está dentro de un contenedor con padding: 0 var(--navbar-padding-x) */
        /* Esto garantiza que esté alineado con las migas de pan */
    }

    /* Para elementos que necesiten alineación específica con las breadcrumbs */
    .breadcrumb-aligned {
        padding-left: var(--navbar-padding-x);
        padding-right: var(--navbar-padding-x);
    }

    /* Asegurar que las tarjetas y contenido principal mantengan la alineación */
    .container-fluid.content-area .card,
    .container-fluid.content-area .table-responsive,
    .container-fluid.content-area .row {
        /* Ya heredan el padding del contenedor padre */
    }

    /* Mobile alignment fixes for sidebar heading */
    @media (max-width: 575.98px) {
        .sidebar-heading {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            padding: 0 1rem !important;
            gap: 0.75rem !important;
        }

        .sidebar-heading > span {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }

        .sidebar-heading .bi-columns-gap {
            font-size: 1.5rem !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .sidebar-heading .app-name {
            display: inline-flex !important;
            align-items: center !important;
            font-size: 1.25rem !important;
            line-height: 1.2 !important;
            font-weight: 600 !important;
        }
    }

    /* ======================================================================== */
</style>
    @yield('styles')
</head>


    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-content">

                <div class="sidebar-heading text-white d-flex align-items-center justify-content-between">

                        <span>
                            <i class="bi bi-columns-gap"></i>
                            <span class="sidebar-text app-name">Agile-Desk</span>
                        </span>
                </div>

                <div class="list-group list-group-flush mb-auto">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Inicio">
                        <i class="bi bi-speedometer2"></i>
                        <span class="sidebar-text">Inicio</span>
                    </a>
                     <a href="{{ route('projects.my') }}" class="list-group-item list-group-item-action text-white" title="Proyectos">
                        <i class="bi bi-folder-fill"></i>
                        <span class="sidebar-text">Proyectos</span>
                     </a>
                    @if(Auth::check() && (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()))
                        @if(Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action text-white" title="Usuarios">
                                <i class="bi bi-person-lines-fill"></i>
                                <span class="sidebar-text">Usuarios</span>
                            </a>
                            <a href="{{ route('historial.sistema') }}" class="list-group-item list-group-item-action text-white" title="Usuarios">
                                <i class="bi bi-clock-history"></i>
                                <span class="sidebar-text">Historial</span>
                            </a>
                        @else
                            <a href="{{ route('admin.users.manage') }}" class="list-group-item list-group-item-action text-white" title="Usuarios">
                                <i class="bi bi-person-lines-fill"></i>
                                <span class="sidebar-text">Usuarios</span>
                            </a>
                        @endif
                    @endif

                    @if (isset($currentProject) && $currentProject instanceof \App\Models\Project)
                        <a href="{{ route('backlog.index', ['project' => $currentProject->id]) }}" class="list-group-item list-group-item-action text-white">
                            <i class="bi bi-list-task"></i>
                            <span class="sidebar-text">Backlog</span>
                        </a>

                        <a href="{{ route('tableros.show', ['project' => $currentProject->id]) }}" class="list-group-item list-group-item-action text-white">
                            <i class="bi bi-columns-gap"></i>
                            <span class="sidebar-text">Tablero</span>
                        </a>

                        @if(Auth::check() && (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()))
                            <a href="{{ route('sprints.index', ['project' => $currentProject->id]) }}" class="list-group-item list-group-item-action text-white">
                                <i class="bi bi-calendar-range"></i>
                                <span class="sidebar-text">Sprints</span>
                            </a>
                        @endif

                    @endif


                    <!-- otros botones comentados por ahora -->

                     </a>


                </div>

                <!-- User dropdown in sidebar (ajustado para móviles) -->
                <div class="user-dropdown">
                    <div class="dropdown">
                        <button class="user-info btn btn-link text-white p-0 w-100 text-start d-flex align-items-center gap-2 user-dropdown-btn"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                id="userDropdown">
                            @if (Auth::check() && Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto de perfil" class="user-avatar" style="object-fit:cover; border-radius:50%; border:2px solid #fff2; width:40px; height:40px; min-width:40px;">
                            @else
                                <div class="user-avatar d-flex align-items-center justify-content-center">
                                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'U' }}
                                </div>
                            @endif
                            <div class="sidebar-text flex-grow-1 d-flex flex-column justify-content-center ms-2">
                                <div class="fw-semibold" style="font-size:1rem; line-height:1.1;">{{ Auth::check() ? Auth::user()->name : 'Usuario' }}</div>
                                <small class="text-muted" style="font-size:0.85rem;">{{ Auth::check() ? Auth::user()->email : 'usuario@example.com' }}</small>
                            </div>
                        </button>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
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
                <main class="h-100 w-100 main-content">
                    <div class="container-fluid content-area w-100" style="padding: 0 var(--navbar-padding-x); margin-top: 4rem;">
                        <div class="mb-2 breadcrumb-wrapper" style="padding-top: 0.5rem;">
                            <x-breadcrumbs :breadcrumbs="$breadcrumbs ?? []" />
                        </div>
                        <div class="content-section" style="padding: 0 0;">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Core JS local -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Base Layout Script -->
    <script>
        // Constantes para localStorage
        const SIDEBAR_STATE_KEY = 'agiledesk_sidebar_collapsed';

        // Función para obtener el estado guardado del sidebar
        function getSavedSidebarState() {
            const saved = localStorage.getItem(SIDEBAR_STATE_KEY);
            return saved === 'true';
        }

        // Función para guardar el estado del sidebar
        function saveSidebarState(isCollapsed) {
            localStorage.setItem(SIDEBAR_STATE_KEY, isCollapsed.toString());
        }

        // Función para aplicar el estado del sidebar
        function applySidebarState(isCollapsed) {
            const body = document.body;
            const toggleIcon = document.getElementById('sidebar-toggle-icon');
            const mobileIcon = document.getElementById('mobile-sidebar-icon');
            const overlay = document.querySelector('.overlay');

            if (isCollapsed) {
                body.classList.add('sidebar-collapsed');
                if (toggleIcon) {
                    toggleIcon.classList.remove('bi-chevron-left');
                    toggleIcon.classList.add('bi-chevron-right');
                }
                if (mobileIcon) {
                    mobileIcon.classList.remove('bi-x');
                    mobileIcon.classList.add('bi-list');
                }
                if (window.innerWidth < 992 && overlay) {
                    overlay.style.display = 'none';
                }
            } else {
                body.classList.remove('sidebar-collapsed');
                if (toggleIcon) {
                    toggleIcon.classList.remove('bi-chevron-right');
                    toggleIcon.classList.add('bi-chevron-left');
                }
                if (mobileIcon) {
                    mobileIcon.classList.remove('bi-list');
                    mobileIcon.classList.add('bi-x');
                }
                if (window.innerWidth < 992 && overlay) {
                    overlay.style.display = 'block';
                }
            }
        }

        // Sidebar toggle functionality mejorada
        function toggleSidebar() {
            const isCurrentlyCollapsed = document.body.classList.contains('sidebar-collapsed');
            const newState = !isCurrentlyCollapsed;
            applySidebarState(newState);
            saveSidebarState(newState);
        }

        // Inicializar el sidebar con el estado guardado al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar sidebar
            const savedState = getSavedSidebarState();
            applySidebarState(savedState);

            // Detectar cambios en el tamaño de la ventana para actualizar íconos y overlay
            window.addEventListener('resize', function() {
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                applySidebarState(isCollapsed);
            });

            // Cerrar sidebar al hacer clic en overlay en móvil
            const overlay = document.querySelector('.overlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        applySidebarState(true);
                        saveSidebarState(true);
                    }
                });
            }

            // Auto-flip para el dropdown de usuario (dropup vs dropdown)
            const userDropdownBtn = document.getElementById('userDropdown');
            if (userDropdownBtn) {
                userDropdownBtn.addEventListener('click', function() {
                    const container = userDropdownBtn.closest('.dropdown');
                    const menu = container ? container.querySelector('.dropdown-menu') : null;
                    // Asegurar que Bootstrap construya el menu primero
                    setTimeout(() => {
                        if (!container || !menu) return;
                        // Resetear estados
                        container.classList.remove('dropup');
                        menu.style.maxHeight = '';
                        menu.style.bottom = '';
                        menu.style.top = '';

                        const rect = userDropdownBtn.getBoundingClientRect();
                        const viewportH = window.innerHeight || document.documentElement.clientHeight;
                        const spaceBelow = viewportH - rect.bottom;
                        const spaceAbove = rect.top;
                        const desiredMenuHeight = Math.min(320, viewportH * 0.6);

                        // Elegir dirección
                        if (spaceBelow < 200 && spaceAbove > spaceBelow) {
                            // Mostrar hacia arriba
                            container.classList.add('dropup');
                            menu.style.maxHeight = Math.max(160, Math.min(spaceAbove - 16, desiredMenuHeight)) + 'px';
                        } else {
                            // Mostrar hacia abajo
                            container.classList.remove('dropup');
                            menu.style.maxHeight = Math.max(160, Math.min(spaceBelow - 16, desiredMenuHeight)) + 'px';
                        }

                        // Si el sidebar está colapsado y en móvil/tablet, forzar que no desborde la pantalla
                        if (document.body.classList.contains('sidebar-collapsed') && window.innerWidth < 992) {
                            menu.style.maxWidth = 'calc(100vw - 1rem)';
                        }
                    }, 0);
                });
            }
        });

        // Submenu toggle
        function toggleSubmenu(event, submenuId) {
            event.stopPropagation();
            const submenu = document.getElementById(submenuId);
            if (submenu) {
                submenu.classList.toggle('open');
            }
        }

        // Soporte para gestos de swipe en móviles mejorado
        let touchStartX = 0;
        let touchEndX = 0;
        let touchStartY = 0;
        let touchEndY = 0;
        let isSwipeGesture = false;
        function handleSwipeGesture() {
            if (window.innerWidth >= 992) return;
            const threshold = 80;
            const swipeDistanceX = touchEndX - touchStartX;
            const swipeDistanceY = Math.abs(touchEndY - touchStartY);
            if (swipeDistanceY > 100) return;
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            if (Math.abs(swipeDistanceX) > threshold && isSwipeGesture) {
                if (swipeDistanceX > 0 && touchStartX < 30 && isCollapsed) {
                    applySidebarState(false);
                    saveSidebarState(false);
                } else if (swipeDistanceX < -50 && !isCollapsed && touchStartX < 250) {
                    applySidebarState(true);
                    saveSidebarState(true);
                }
            }
        }
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
            isSwipeGesture = true;
        });
        document.addEventListener('touchmove', function(e) {
            const currentY = e.changedTouches[0].screenY;
            const deltaY = Math.abs(currentY - touchStartY);
            if (deltaY > 50) {
                isSwipeGesture = false;
            }
        });
        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            touchEndY = e.changedTouches[0].screenY;
            handleSwipeGesture();
            isSwipeGesture = false;
        });
    </script>


    <!-- Sistema operativo y escalado automático -->
    <script>
        // Detectar sistema operativo y aplicar ajustes específicos
        document.addEventListener('DOMContentLoaded', function() {
            const userAgent = navigator.userAgent.toLowerCase();
            const isLinux = userAgent.includes('linux');
            const isMac = userAgent.includes('mac');
            const isFirefox = userAgent.includes('firefox');

            // Crear elemento de estilo para ajustes específicos del SO
            const osSpecificStyles = document.createElement('style');
            let css = '';

            if (isLinux) {
                css += `
                    /* Ajustes específicos para Linux */
                    html { font-size: 17px !important; }
                    .sidebar-heading {
                        font-size: 1.6rem !important;
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                    }
                    .list-group-item { font-size: 1rem !important; }
                    .user-avatar { font-size: 1rem !important; }
                `;
            }

            if (isMac) {
                css += `
                    /* Ajustes específicos para macOS */
                    html { font-size: 16px !important; }
                    body { font-weight: 400 !important; }
                    .sidebar-heading { font-weight: 500 !important; }
                `;
            }

            if (isFirefox && isLinux) {
                css += `
                    /* Ajustes específicos para Firefox en Linux */
                    html { font-size: 18px !important; }
                    .sidebar-heading {
                        font-size: 1.7rem !important;
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                    }
                    .list-group-item { font-size: 1.1rem !important; }
                `;
            }

            // Detectar DPI bajo (típico en algunos sistemas Linux)
            if (window.devicePixelRatio <= 1) {
                css += `
                    /* Ajustes para DPI bajo */
                    html { font-size: 18px !important; }
                    .sidebar-heading {
                        font-size: 1.75rem !important;
                        height: 4rem !important;
                        min-height: 4rem !important;
                        max-height: 4rem !important;
                    }
                    .list-group-item { font-size: 1.1rem !important; padding: 0.85rem 1.4rem !important; }
                    .user-avatar { width: 44px !important; height: 44px !important; font-size: 1.1rem !important; line-height: 1 !important; }
                `;

            }

            // Aplicar los estilos si hay alguno
            if (css) {
                osSpecificStyles.textContent = css;
                document.head.appendChild(osSpecificStyles);
            }
        });
    </script>

    <!-- Scripts adicionales de las secciones -->
    @yield('scripts')
    <!-- <script src="bootstrap.bundle.min.js"></script> -->
    <script src="{{ asset('js/dark-mode.js') }}"></script>
    <script src="{{ asset('js/breadcrumb-fix.js') }}"></script>

    <script>
    // Ajuste dinámico: evitar que el menú de usuario quede fuera de la pantalla en móviles
    document.addEventListener('DOMContentLoaded', function(){
        const wrapper = document.querySelector('.user-dropdown .dropdown');
        const toggle = document.getElementById('userDropdown');
        if(!wrapper || !toggle) return;

        function adjust(){
            if(window.innerWidth > 992){
                wrapper.classList.remove('dropup');
                return;
            }
            const menu = wrapper.querySelector('.dropdown-menu');
            if(!menu) return;
            // Mostrar temporalmente para medir
            const prevDisplay = menu.style.display;
            const prevVis = menu.style.visibility;
            menu.style.display='block';
            menu.style.visibility='hidden';
            const menuHeight = menu.offsetHeight;
            menu.style.display=prevDisplay;
            menu.style.visibility=prevVis;
            const toggleRect = toggle.getBoundingClientRect();
            const spaceBelow = window.innerHeight - toggleRect.bottom;
            const spaceAbove = toggleRect.top;
            if(menuHeight > spaceBelow && spaceAbove > spaceBelow){
                wrapper.classList.add('dropup');
            } else {
                wrapper.classList.remove('dropup');
            }
        }
        toggle.addEventListener('click', ()=> setTimeout(adjust, 60));
        window.addEventListener('resize', adjust);
        adjust();
    });
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownDiv = document.querySelector('.dropdown');

        function ajustarDropdown() {
            if (window.innerWidth < 768) {
                dropdownDiv.classList.add('dropup');
            } else {
                dropdownDiv.classList.remove('dropup');
            }
        }

        ajustarDropdown();
        window.addEventListener('resize', ajustarDropdown);
    });

    </script>


</body>
</html>
