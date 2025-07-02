<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                body.classList.add('dark-mode');
                html.style.backgroundColor = '#121218';
            } else {
                // Asegurar que en modo claro el fondo sea claro
                html.style.backgroundColor = '#f8f9fa';
                body.style.backgroundColor = '#f8f9fa';
            }
            
            // 4. Guardar el estado inicial para sincronización
            window.initialDarkModeState = darkMode;
        })();
    </script>

    <!-- Bootstrap CSS (solo una versión) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tabler Core CSS (Admin Template) - Comentado temporalmente para debugging -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@2.28.0/dist/css/tabler.min.css"> -->

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/agiledesk.png') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/historias.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light-mode-bootstrap.css') }}">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden;
        scroll-behavior: smooth;
    }

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

    /* Detección específica de sistemas Linux/macOS (aproximada) */
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
    .sidebar-heading {
        min-font-size: 1.25rem;
    }

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
        z-index: 1000;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        overflow-y: auto;
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
        min-height: 100vh;
        padding: 0; /* Sin padding para eliminar espacios */
        overflow-x: hidden; /* Evitar scroll horizontal */
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
        padding: 0rem;
        transition: all var(--transition-speed) ease;
        overflow-x: hidden; /* Evitar scroll horizontal */
    }

    /* Mejorar el comportamiento del scroll en contenedores internos */
    .container-fluid {
        overflow-x: hidden;
    }

    /* Scroll suave para toda la aplicación */
    * {
        scroll-behavior: smooth;
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
        justify-content: center;
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
    
    /* En tablets, mostrar nombre de app */
    @media (max-width: 991.98px) {
        body.sidebar-collapsed .sidebar-heading span {
            display: inline-block;
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
        margin-top: auto;
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

    .user-info:hover,
    .user-info:focus {
        color: white !important;
        background: rgba(255, 255, 255, 0.1) !important;
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
    }

    .user-info.user-dropdown-btn {
        border-radius: 0.5rem;
        transition: background 0.2s, box-shadow 0.2s;
        box-shadow: none;
        background: rgba(255,255,255,0.03);
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
    body.sidebar-collapsed .user-info .sidebar-text {
        display: none !important;
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
        z-index: 9999 !important;
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
            padding: 0.5rem 0.25rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            min-width: 32px;
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
        }
    }
    
/* Ajustes optimizados para alineación perfecta */
.sidebar-heading {
    width: 100%;
    padding: 0.75rem var(--navbar-padding-x); /* Usa la misma variable de padding */
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin: 0; /* Elimina márgenes inconsistentes */
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 64px; /* Altura consistente con navbar */
}

/* Asegura que el ancho del sidebar coincida exactamente */
#sidebar-wrapper {
    width: calc(var(--sidebar-width) - 1px); /* Compensa el borde del navbar */
    left: 0;
    top: 0;
    transform: none !important; /* Anula transformaciones conflictivas */
    border-right: 1px solid rgba(0, 0, 0, 0.1); /* Borde que coincide con navbar */
}

/* Corrección para el estado colapsado */
.sidebar-collapsed #sidebar-wrapper {
    width: calc(var(--sidebar-collapsed-width) - 1px);
}

/* Ajuste fino para el navbar */
.navbar-optimized {
    padding-left: var(--navbar-padding-x);
    padding-right: var(--navbar-padding-x);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1); /* Borde que coincide con sidebar */
    height: 64px; /* Altura fija para alineación vertical */
}

</style>

    <!-- Estilos adicionales de las secciones -->
    @yield('styles')

</head>


    <!-- Overlay for mobile -->
    <div class="overlay" onclick="toggleSidebar()"></div>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-heading text-white d-flex align-items-center justify-content-between py-3 px-2">
   
                        <span>
                            <i class="bi bi-code-slash me-2"></i>
                            <span class="sidebar-text app-name">Agile-Desk</span>
                        </span>
                        <button class="sidebar-toggle-btn ms-2" onclick="toggleSidebar()" aria-label="Colapsar sidebar">
                            <i class="bi bi-chevron-left" id="sidebar-toggle-icon"></i>
                        </button>
                    
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

                    {{-- Debug temporal
                     @isset($currentProject)
                        <div style="color: white; padding: 1rem; background: red;">
                            currentProject está definido: {{ $currentProject->id }}
                        </div>
                    @else
                        <div style="color: white; padding: 1rem; background: red;">
                            currentProject NO está definido
                        </div>
                    @endisset--}}

                    @if (isset($currentProject) && $currentProject instanceof \App\Models\Project)
                        <a href="{{ route('backlog.index', ['project' => $currentProject->id]) }}" class="list-group-item list-group-item-action text-white">
                            <i class="bi bi-list-task"></i>
                            <span class="sidebar-text">Backlog</span>
                        </a>

                        <a href="{{ route('tableros.show', ['project' => $currentProject->id]) }}" class="list-group-item list-group-item-action text-white">
                            <i class="bi bi-columns-gap"></i>
                            <span class="sidebar-text">Tablero</span>
                        </a>
                    @endif



                    <!-- -->

                    <!-- otros botones comentados por ahora -->

                     </a>
                     <!-- Ejemplo de submenú -->
                     <div class="list-group-item list-group-item-action text-white sidebar-has-tree" onclick="toggleSubmenu(event, 'submenu1')" title="Gestión">
                        <i class="bi bi-gear"></i>
                        <span class="sidebar-text">Gestión</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </div>
                    <div class="sidebar-submenu" id="submenu1">
                        <a href="#" class="list-group-item list-group-item-action text-white ps-5">Opción 1</a>
                        <a href="#" class="list-group-item list-group-item-action text-white ps-5">Opción 2</a>
                    </div>

                </div>

                <!-- User dropdown in sidebar -->
                <div class="user-dropdown mt-auto">
                    <div class="dropdown dropup">
                        <button class="user-info btn btn-link text-white p-0 w-100 text-start d-flex align-items-center gap-2 user-dropdown-btn"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        id="userDropdown">
    <div class="user-avatar d-flex align-items-center justify-content-center">
        {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'U' }}
    </div>
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
                    <div class="ps-3">
                         <x-breadcrumbs :breadcrumbs="$breadcrumbs ?? []" />
                    </div>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

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

            // Cerrar alerts automáticamente
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });

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
                    .sidebar-heading { font-size: 1.6rem !important; }
                    .list-group-item { font-size: 1rem !important; }
                    .user-avatar { font-size: 1rem !important; }
                `;
                console.log('🐧 Sistema Linux detectado - Aplicando ajustes de escalado');
            }

            if (isMac) {
                css += `
                    /* Ajustes específicos para macOS */
                    html { font-size: 16px !important; }
                    body { font-weight: 400 !important; }
                    .sidebar-heading { font-weight: 500 !important; }
                `;
                console.log('🍎 Sistema macOS detectado - Aplicando ajustes de escalado');
            }

            if (isFirefox && isLinux) {
                css += `
                    /* Ajustes específicos para Firefox en Linux */
                    html { font-size: 18px !important; }
                    .sidebar-heading { font-size: 1.7rem !important; }
                    .list-group-item { font-size: 1.1rem !important; }
                `;
                console.log('🦊 Firefox en Linux detectado - Aplicando ajustes especiales');
            }

            // Detectar DPI bajo (típico en algunos sistemas Linux)
            if (window.devicePixelRatio <= 1) {
                css += `
                    /* Ajustes para DPI bajo */
                    html { font-size: 18px !important; }
                    .sidebar-heading { font-size: 1.75rem !important; }
                    .list-group-item { font-size: 1.1rem !important; padding: 0.85rem 1.4rem !important; }
                    .user-avatar { width: 44px !important; height: 44px !important; font-size: 1.1rem !important; }
                `;
                console.log('📱 DPI bajo detectado - Aplicando escalado aumentado');

                console.log('✅ Event listeners agregados');
            } else {
                console.log('❌ No se encontraron los elementos del dropdown');
            }

            // Aplicar los estilos si hay alguno
            if (css) {
                osSpecificStyles.textContent = css;
                document.head.appendChild(osSpecificStyles);
            }

            // Mensaje de información en consola
            console.log('🎨 AgileDesk - Ajustes de escalado aplicados para:', {
                userAgent: navigator.userAgent,
                devicePixelRatio: window.devicePixelRatio,
                screenResolution: `${screen.width}x${screen.height}`,
                windowSize: `${window.innerWidth}x${window.innerHeight}`
            });
        });
    </script>

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

            // Cerrar alerts automáticamente
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }, 5000);
            });

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
                    .sidebar-heading { font-size: 1.6rem !important; }
                    .list-group-item { font-size: 1rem !important; }
                    .user-avatar { font-size: 1rem !important; }
                `;
                console.log('🐧 Sistema Linux detectado - Aplicando ajustes de escalado');
            }

            if (isMac) {
                css += `
                    /* Ajustes específicos para macOS */
                    html { font-size: 16px !important; }
                    body { font-weight: 400 !important; }
                    .sidebar-heading { font-weight: 500 !important; }
                `;
                console.log('🍎 Sistema macOS detectado - Aplicando ajustes de escalado');
            }

            if (isFirefox && isLinux) {
                css += `
                    /* Ajustes específicos para Firefox en Linux */
                    html { font-size: 18px !important; }
                    .sidebar-heading { font-size: 1.7rem !important; }
                    .list-group-item { font-size: 1.1rem !important; }
                `;
                console.log('🦊 Firefox en Linux detectado - Aplicando ajustes especiales');
            }

            // Detectar DPI bajo (típico en algunos sistemas Linux)
            if (window.devicePixelRatio <= 1) {
                css += `
                    /* Ajustes para DPI bajo */
                    html { font-size: 18px !important; }
                    .sidebar-heading { font-size: 1.75rem !important; }
                    .list-group-item { font-size: 1.1rem !important; padding: 0.85rem 1.4rem !important; }
                    .user-avatar { width: 44px !important; height: 44px !important; font-size: 1.1rem !important; }
                `;
                console.log('📱 DPI bajo detectado - Aplicando escalado aumentado');

                console.log('✅ Event listeners agregados');
            } else {
                console.log('❌ No se encontraron los elementos del dropdown');
            }

            // Aplicar los estilos si hay alguno
            if (css) {
                osSpecificStyles.textContent = css;
                document.head.appendChild(osSpecificStyles);
            }

            // Mensaje de información en consola
            console.log('🎨 AgileDesk - Ajustes de escalado aplicados para:', {
                userAgent: navigator.userAgent,
                devicePixelRatio: window.devicePixelRatio,
                screenResolution: `${screen.width}x${screen.height}`,
                windowSize: `${window.innerWidth}x${window.innerHeight}`
            });
        });
    </script>

    <!-- Scripts adicionales de las secciones -->
    @yield('scripts')
    <script src="bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dark-mode.js') }}"></script>

</body>
</html>
