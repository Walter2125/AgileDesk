<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Agile Desk') }}</title>
        <!-- Fonts -->
        <link href="{{ asset('vendor/fonts/figtree/figtree-local.css') }}" rel="stylesheet" />

        <!-- logo -->
        <link rel="icon" href="{{ asset('img/agiledesk.png') }}" type="image/x-icon">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilos personalizados optimizados -->
        <style>
            :root {
                --vh: 1vh;
                --primary-blue: #62b0f0;
                --dark-blue: #2d3a4d;
                --accent-green: #4dd0b4;
                --auth-bg-image: url("{{ asset('img/trabajo.png') }}");
            }


             * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
                width: 100%;
                overflow: hidden;
            }

            /* Contenedor principal con imagen de fondo en vista completa */
            .auth-container {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                 background:
                    /* Overlay semi-transparente para mejor legibilidad */
                    linear-gradient(rgba(255, 255, 255, 0.573), rgba(255, 255, 255, 0.61)),
                    /* Imagen de fondo en vista completa */
                    var(--auth-bg-image) center/cover no-repeat fixed;
                padding: 0;
                width: 100vw;
                height: 100vh;
                z-index: 1;
            }

             /* Contenedor de la tarjeta de autenticación */
            .auth-card {
                background: #fff;
                display: flex;
                width: 100%;
                max-width: 1000px;
                height: auto;
                max-height: 90vh;
                overflow: auto;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                z-index: 2;
                position: relative;
            }

            .auth-sidebar {
                background-color: var(--primary-blue);
                padding: 2rem 1.5rem;
                flex: 0 0 45%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                color: white;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            /* Estilos globales para elementos parallax */
            .parallax-elements {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 0;
                pointer-events: none;
            }

            .parallax-circle {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.15);
                will-change: transform;
                transition: transform 0.2s ease-out;
            }

            .circle-1 {
                width: 150px;
                height: 150px;
                top: -50px;
                right: -50px;
                background: rgba(255, 255, 255, 0.1);
            }

            .circle-2 {
                width: 100px;
                height: 100px;
                bottom: -30px;
                left: 20%;
                background: rgba(255, 255, 255, 0.08);
            }

            .auth-sidebar h1,
            .auth-sidebar h2 {
                position: relative;
                z-index: 2;
            }

            .auth-sidebar h2 {
                font-size: 1.5rem;
                font-weight: 500;
                margin-bottom: 1.5rem;
            }

            .rocket-illustration {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 1.5rem auto;
                position: relative;
                z-index: 2;
            }

            .rocket-illustration img {
                max-width: 100%;
                height: auto;
                display: block;
                object-fit: contain;
                transition: transform 0.3s ease;
                width: 60%;
                max-width: 180px;
            }

            .auth-content {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                background-color: var(--dark-blue);
                flex: 0 0 55%;
                display: flex;
                flex-direction: column;
                padding: 2rem 1.5rem;
            }

            .auth-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                transition: all 0.3s ease;
            }

            .auth-header-links a {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                transition: all 0.3s ease;
                display: inline-block;
            }

            .auth-header-links a.active {
                background-color: var(--primary-blue);
                color: white;
            }

            .auth-header label {
                color: rgba(255, 255, 255, 0.7);
            }
            
            .auth-form label {
                display: block;
                text-transform: uppercase;
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
                color: rgba(255, 255, 255, 0.7);
            }

            .auth-form input[type="text"],
            .auth-form input[type="email"],
            .auth-form input[type="password"] {
                width: 100%;
                background-color: transparent;
                border: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding: 0.5rem;
                margin-bottom: 1.5rem;
                color: white;
                outline: none;
                transition: border-color 0.3s ease;
            }

            .auth-form input[type="text"]:focus,
            .auth-form input[type="email"]:focus,
            .auth-form input[type="password"]:focus {
                border-bottom-color: var(--accent-green);
            }

            .auth-form input[type="checkbox"] {
                accent-color: var(--primary-blue);
            }

            .auth-form .form-group {
                margin-bottom: 1.5rem;
            }

            .auth-form .checkbox-group {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
            }

            .auth-form .checkbox-group label {
                margin-bottom: 0;
                text-transform: none;
            }

            .auth-submit-btn {
                background-color: var(--primary-blue);
                color: white;
                border: none;
                border-radius: 4px;
                padding: 0.75rem 2rem;
                font-size: 0.875rem;
                cursor: pointer;
                transition: background-color 0.3s;
                width: 100%;
            }

            .auth-submit-btn:hover {
                background-color: var(--primary-blue);
                opacity: 0.9;
            }

            .auth-links {
                margin-top: 1rem;
                font-size: 0.75rem;
                text-align: center;
            }

            .auth-links a {
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
            }

            .auth-links a:hover {
                color: white;
            }

            .password-container {
                position: relative;
                width: 100%;
            }

            .toggle-password {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: rgba(255, 255, 255, 0.7);
                transition: all 0.3s ease;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 40px;
            }

            .toggle-password:hover {
                color: var(--primary-blue);
            }

            .auth-form input[type="password"] {
                padding-right: 40px;
            }

            .pagination-dots {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
                margin-top: 1.5rem;
            }

            .pagination-dots .dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.3);
            }

            .pagination-dots .dot.active {
                background-color: white;
            }

            /* RESPONSIVE DESIGN OPTIMIZADO */

            /* Large devices (desktops, 992px and up) */
            @media (min-width: 992px) {
                .auth-card {
                    max-height: 520px;
                    max-width: 1000px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                .auth-container {
                    padding: 2rem;
                }

                .auth-sidebar {
                    padding: 3rem 2rem;
                    flex: 0 0 45%;
                }

                .auth-content {
                    padding: 3rem 2rem;
                    flex: 0 0 55%;
                }

                .rocket-illustration img {
                    margin: 2rem 0;
                    max-width: 80%;
                    transform: scale(1.25);
                }

                .auth-submit-btn {
                    width: auto;
                }

                .auth-links {
                    text-align: right;
                }
            }

            /* Medium-Large devices (tablets grandes/laptops pequeños, 921px-991.98px) */
            @media (min-width: 921px) and (max-width: 991.98px) {
                .auth-container {
                    height: 100vh;
                    overflow: hidden;
                }

                .auth-card {
                    height: 100vh;
                    flex-direction: row;
                    overflow: hidden;
                }

                .auth-sidebar {
                    position: relative;
                    transform: none;
                    background: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                    background-position: center center;
                    width: 45%;
                    height: 100vh;
                    flex: 0 0 45%;
                    padding: 3rem 2rem;
                    overflow: hidden;
                }

                .auth-content {
                    margin-top: 0;
                    width: 55%;
                    flex: 0 0 55%;
                    height: 100vh;
                    overflow-y: auto;
                    padding: 3rem 2rem;
                }

                .parallax-elements {
                    display: none;
                }

                .rocket-illustration img {
                    transform: scale(1.1);
                }

                .scroll-spacer {
                    display: none;
                }
            }

            /* Fix para tamaño problemático (888px x 553px aprox) */
            @media (min-width: 850px) and (max-width: 920px) and (min-height: 520px) and (max-height: 580px) {
                html, body {
                    height: 100vh !important;
                    overflow: hidden !important;
                }

                .auth-container {
                    min-height: 100vh !important;
                    overflow: hidden !important;
                }

                .auth-card {
                    min-height: 100vh !important;
                    flex-direction: row !important;
                    overflow: hidden !important;
                }

                .auth-sidebar {
                    position: relative !important;
                    transform: none !important;
                    background: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%) !important;
                    background-position: center center !important;
                    width: 45% !important;
                    height: 100vh !important;
                    flex: 0 0 45% !important;
                    padding: 3rem 2rem !important;
                }

                .auth-content {
                    margin-top: 0 !important;
                    width: 55% !important;
                    flex: 0 0 55% !important;
                    height: 100vh !important;
                    overflow-y: auto !important;
                    padding: 3rem 2rem !important;
                }

                .parallax-elements {
                    display: none !important;
                }

                .rocket-illustration img {
                    transform: scale(1.0) !important;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Medium devices específicos (tablets medianos, 768px-849px) */
            @media (min-width: 768px) and (max-width: 849px) {
                html, body {
                    height: auto !important;
                    overflow: visible !important;
                    position: static !important;
                }

                .auth-container {
                    position: relative !important;
                    min-height: 180vh;
                    height: auto;
                    overflow: visible !important;
                }

                .auth-card {
                    height: auto;
                    min-height: 180vh;
                    max-width: none;
                    width: 100%;
                    box-shadow: none;
                    flex-direction: column;
                    overflow: visible;
                    position: relative;
                }

                .auth-sidebar {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 55vh;
                    overflow: hidden;
                    background-attachment: scroll;
                    z-index: 10;
                    will-change: transform, background-position, background-image;
                    transition: transform 0.1s ease-out, background-image 0.3s ease;
                    background-image: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                    background-size: 180% 180%;
                    background-position: center center;
                    transform: translateY(0);
                }

                .auth-content {
                    padding: 2rem 1.5rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    margin-top: 55vh;
                    position: relative;
                    z-index: 5;
                    min-height: 120vh;
                }

                .rocket-illustration img {
                    max-width: 75% !important;
                    transform: scale(1.1) !important;
                    position: relative;
                    z-index: 1;
                    will-change: transform;
                }

                .scroll-spacer {
                    display: block !important;
                    visibility: visible !important;
                }
            }

            /* Gap filler para 849px-850px */
            @media (min-width: 849px) and (max-width: 850px) {
                html, body {
                    height: auto !important;
                    overflow: visible !important;
                    position: static !important;
                }

                .auth-container {
                    position: relative !important;
                    min-height: 180vh;
                    height: auto;
                    overflow: visible !important;
                }

                .auth-card {
                    height: auto;
                    min-height: 180vh;
                    max-width: none;
                    width: 100%;
                    box-shadow: none;
                    flex-direction: column;
                    overflow: visible;
                    position: relative;
                }

                .auth-sidebar {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 55vh;
                    overflow: hidden;
                    background-attachment: scroll;
                    z-index: 10;
                    will-change: transform, background-position, background-image;
                    transition: transform 0.1s ease-out, background-image 0.3s ease;
                    background-image: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                    background-size: 180% 180%;
                    background-position: center center;
                    transform: translateY(0);
                }

                .auth-content {
                    padding: 2rem 1.5rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    margin-top: 55vh;
                    position: relative;
                    z-index: 5;
                    min-height: 120vh;
                }

                .rocket-illustration img {
                    max-width: 75% !important;
                    transform: scale(1.1) !important;
                    position: relative;
                    z-index: 1;
                    will-change: transform;
                }

                .scroll-spacer {
                    display: block !important;
                    visibility: visible !important;
                }
            }

            /* Landscape tablets con altura limitada */
            @media (min-width: 768px) and (max-width: 1024px) and (max-height: 600px) and (orientation: landscape) {
                html, body {
                    height: 100vh !important;
                    overflow: hidden !important;
                }

                .auth-container {
                    height: 100vh !important;
                    overflow: hidden !important;
                }

                .auth-card {
                    height: 100vh !important;
                    flex-direction: row !important;
                    overflow: hidden !important;
                }

                .auth-sidebar {
                    position: relative !important;
                    transform: none !important;
                    background: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%) !important;
                    background-position: center center !important;
                    width: 40% !important;
                    height: 100vh !important;
                    flex: 0 0 40% !important;
                    padding: 2rem 1.5rem !important;
                }

                .auth-content {
                    margin-top: 0 !important;
                    width: 60% !important;
                    flex: 0 0 60% !important;
                    height: 100vh !important;
                    overflow-y: auto !important;
                    padding: 2rem 1.5rem !important;
                }

                .parallax-elements {
                    display: none !important;
                }

                .rocket-illustration img {
                    transform: scale(0.9) !important;
                }

                .auth-sidebar h1 {
                    font-size: 1.3rem !important;
                }

                .auth-sidebar h2 {
                    font-size: 1.1rem !important;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Tablets portrait con altura muy alta */
            @media (min-width: 768px) and (max-width: 991.98px) and (min-height: 900px) and (orientation: portrait) {
                .auth-sidebar {
                    height: 50vh !important;
                }

                .auth-content {
                    margin-top: 50vh !important;
                }

                .rocket-illustration img {
                    transform: scale(1.3) !important;
                }
            }

            /* Media query adicional para tamaños intermedios 992px-1023px */
            @media (min-width: 992px) and (max-width: 1023px) {
                .auth-card {
                    max-height: 520px;
                    max-width: 900px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                .auth-container {
                    padding: 2rem;
                }

                .auth-sidebar {
                    padding: 3rem 2rem;
                    flex: 0 0 45%;
                }

                .auth-content {
                    padding: 3rem 2rem;
                    flex: 0 0 55%;
                }

                .parallax-elements {
                    display: none;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Media query para laptops pequeños 1024px-1199px */
            @media (min-width: 1024px) and (max-width: 1199px) {
                .auth-card {
                    max-height: 540px;
                    max-width: 950px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }

                .auth-container {
                    padding: 2.5rem;
                }

                .auth-sidebar {
                    padding: 3rem 2.5rem;
                    flex: 0 0 45%;
                }

                .auth-content {
                    padding: 3rem 2.5rem;
                    flex: 0 0 55%;
                }

                .parallax-elements {
                    display: none;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Optimización específica para 768px x 557.33px - Parallax restaurado */
            @media (min-width: 768px) and (max-width: 768px) and (min-height: 557px) and (max-height: 558px) {
                html, body {
                    height: auto !important;
                    overflow-x: hidden !important;
                    overflow-y: auto !important;
                    position: static !important;
                }

                .auth-container {
                    position: relative !important;
                    min-height: 200vh;
                    height: auto;
                    overflow: visible !important;
                }

                .auth-card {
                    height: auto;
                    min-height: 200vh;
                    max-width: none;
                    width: 100%;
                    box-shadow: none;
                    flex-direction: column;
                    overflow: visible;
                    position: relative;
                }

                .auth-sidebar {
                    position: fixed !important;
                    top: 0;
                    left: 0;
                    width: 100% !important;
                    height: 65vh !important;
                    overflow: hidden;
                    background-attachment: scroll;
                    z-index: 10;
                    will-change: transform, background-position, background-image, opacity;
                    transition: none;
                    background-image: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                    background-size: 300% 300%;
                    background-position: center center;
                    transform: translateY(0);
                    opacity: 1;
                }

                .auth-content {
                    padding: 2rem 1.5rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                    margin-top: 65vh !important;
                    position: relative;
                    z-index: 15;
                    min-height: 135vh;
                    background: var(--dark-blue);
                }

                .rocket-illustration img {
                    max-width: 85% !important;
                    transform: scale(1.2) !important;
                    position: relative;
                    z-index: 1;
                    will-change: transform;
                    transition: transform 0.1s ease-out;
                }

                .scroll-spacer {
                    display: block !important;
                    visibility: visible !important;
                    height: 200vh !important;
                }

                .parallax-elements {
                    display: block !important;
                    opacity: 1 !important;
                }

                .auth-sidebar h1, .auth-sidebar h2 {
                    will-change: transform;
                    transition: transform 0.1s ease-out;
                }
            }

            /* Fix adicional para heights muy pequeños en tablets */
            @media (min-width: 768px) and (max-width: 991.98px) and (max-height: 500px) {
                .auth-sidebar {
                    height: 45vh !important;
                }

                .auth-content {
                    margin-top: 45vh !important;
                    padding: 1.5rem !important;
                }

                .rocket-illustration img {
                    transform: scale(0.9) !important;
                }

                .auth-sidebar h1 {
                    font-size: 1.3rem !important;
                }

                .auth-sidebar h2 {
                    font-size: 1rem !important;
                }
            }

            /* Small devices (landscape phones, 576px and up) */
            @media (min-width: 576px) and (max-width: 767.98px) {
                .auth-card {
                    flex-direction: column;
                    height: auto;
                    min-height: 100%;
                    border-radius: 0;
                }

                .auth-sidebar {
                    padding: 2rem 1.5rem;
                }

                .auth-content {
                    padding: 2rem 1.5rem;
                }

                .rocket-illustration img {
                    max-width: 120px;
                    margin: 1rem 0;
                }

                .auth-sidebar h2 {
                    font-size: 1.2rem;
                }

                .parallax-elements {
                    display: none !important;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Media query de fallback para cualquier gap restante */
            @media (min-width: 768px) and (max-width: 991.98px) {
                .auth-container {
                    min-height: 100vh;
                }

                .auth-card {
                    min-height: 100vh;
                    flex-direction: column;
                }

                .auth-sidebar {
                    position: relative;
                    width: 100%;
                    height: 60vh;
                    background: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                }

                .auth-content {
                    width: 100%;
                    min-height: 40vh;
                    padding: 2rem;
                }

                .parallax-elements {
                    display: none;
                }

                .scroll-spacer {
                    display: block;
                    visibility: visible;
                }
            }

            /* Extra small devices (portrait phones, less than 576px) */
            @media (max-width: 575.98px) {
                html, body {
                    height: 100vh !important;
                    overflow: hidden !important;
                    position: fixed !important;
                    width: 100% !important;
                    max-width: 100vw !important;
                }

                .auth-container {
                    background-color: var(--dark-blue);
                    padding: 0;
                    height: 100vh !important;
                    overflow: hidden !important;
                    position: fixed !important;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .auth-card {
                    flex-direction: column;
                    height: 100vh !important;
                    min-height: 100vh !important;
                    max-height: 100vh !important;
                    border-radius: 0;
                    background-color: var(--dark-blue);
                    overflow: hidden !important;
                    background: var(--dark-blue);
                    display: flex;
                    width: 100%;
                    box-shadow: none;
                    transition: all 0.3s ease;
                }

                .auth-sidebar {
                    display: none;
                }

                .mobile-header {
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                    justify-content: center;
                    padding: 1.5rem 1rem 1rem 1rem;
                    color: white;
                    text-align: center;
                    margin-bottom: 1rem;
                    flex-shrink: 0;
                    height: auto;
                    max-height: 80px;
                }

                .mobile-header .mobile-logo {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .mobile-header .mobile-logo img {
                    width: 50px;
                    height: 50px;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, 0.1);
                    padding: 10px;
                    object-fit: contain;
                }

                .mobile-header h1 {
                    font-size: 1.3rem;
                    font-weight: 600;
                    letter-spacing: 0.5px;
                    margin: 0;
                }

                .auth-content {
                    padding: 0 1rem 1rem 1rem;
                    width: 100%;
                    height: calc(100vh - 80px) !important;
                    max-height: calc(100vh - 80px) !important;
                    min-height: calc(100vh - 80px) !important;
                    overflow-y: auto !important;
                    -webkit-overflow-scrolling: touch !important;
                    flex: 1;
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                    background-color: var(--dark-blue);
                }

                .auth-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                    margin-top: 0;
                    margin-bottom: 1.5rem;
                    flex-shrink: 0;
                    display: flex;
                    justify-content: space-between;
                    transition: all 0.3s ease;
                }

                .auth-header-links {
                    width: 100%;
                    display: flex;
                    gap: 0.5rem;
                }

                .auth-header-links a {
                    flex: 1;
                    text-align: center;
                    padding: 0.75rem 0.5rem;
                    font-size: 0.875rem;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    transition: all 0.3s ease;
                    display: inline-block;
                }

                .auth-form {
                    flex-shrink: 0;
                }

                .auth-form .form-group {
                    margin-bottom: 1.5rem;
                }

                .auth-form input[type="text"],
                .auth-form input[type="email"],
                .auth-form input[type="password"] {
                    padding: 0.75rem 0.5rem;
                    margin-bottom: 1.5rem;
                    font-size: 1rem;
                    width: 100%;
                    background-color: transparent;
                    border: none;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                    color: white;
                    outline: none;
                    transition: border-color 0.3s ease;
                }

                .auth-submit-btn {
                    padding: 1rem;
                    font-size: 1rem;
                    margin-top: 1rem;
                    background-color: var(--primary-blue);
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    width: 100%;
                }

                .auth-links {
                    margin-top: 1rem;
                    text-align: center;
                    flex-shrink: 0;
                    padding-bottom: 2rem;
                    font-size: 0.75rem;
                }

                .parallax-elements {
                    display: none !important;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }

            /* Mejora específica para móviles en landscape */
            @media (max-width: 767.98px) and (orientation: landscape) and (max-height: 500px) {
                html, body {
                    height: 100vh !important;
                    overflow: hidden !important;
                    position: fixed !important;
                    width: 100% !important;
                }

                .auth-container {
                    height: 100vh !important;
                    overflow: hidden !important;
                    position: fixed !important;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #fff;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .auth-card {
                    flex-direction: row !important;
                    height: 100vh !important;
                    min-height: 100vh !important;
                    max-height: 100vh !important;
                    border-radius: 0;
                    overflow: hidden !important;
                    background: #fff;
                    display: flex;
                    width: 100%;
                    box-shadow: none;
                    transition: all 0.3s ease;
                }

                .auth-sidebar {
                    display: flex !important;
                    width: 38% !important;
                    flex: 0 0 38% !important;
                    height: 100vh !important;
                    padding: 1rem 0.75rem !important;
                    background: linear-gradient(135deg, var(--primary-blue) 0%, #3d8cd6 100%);
                    text-align: center;
                    color: white;
                    position: relative;
                    overflow: hidden;
                    transition: all 0.3s ease;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                }

                .auth-sidebar h1 {
                    font-size: 1rem !important;
                    position: relative;
                    z-index: 2;
                    margin-bottom: 0.5rem;
                    font-weight: 600;
                }

                .auth-sidebar h2 {
                    font-size: 0.8rem !important;
                    margin-bottom: 0.75rem !important;
                    position: relative;
                    z-index: 2;
                    font-weight: 500;
                    line-height: 1.2;
                }

                .rocket-illustration {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin: 0.5rem auto !important;
                    position: relative;
                    z-index: 2;
                }

                .rocket-illustration img {
                    max-width: 50px !important;
                    margin: 0.25rem 0 !important;
                    height: auto;
                    display: block;
                    object-fit: contain;
                    transition: transform 0.3s ease;
                }

                .mobile-header {
                    display: none !important;
                }

                .auth-content {
                    width: 62% !important;
                    flex: 0 0 62% !important;
                    height: 100vh !important;
                    padding: 1rem !important;
                    overflow-y: auto !important;
                    -webkit-overflow-scrolling: touch !important;
                    background-color: var(--dark-blue);
                    display: flex;
                    flex-direction: column;
                }

                .auth-header {
                    margin-bottom: 1rem !important;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    transition: all 0.3s ease;
                    flex-shrink: 0;
                }

                .auth-header-links {
                    display: flex;
                    gap: 0.5rem;
                }

                .auth-header-links a {
                    padding: 0.5rem 0.75rem !important;
                    font-size: 0.75rem !important;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    transition: all 0.3s ease;
                    display: inline-block;
                }

                .auth-form {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .auth-form .form-group {
                    margin-bottom: 1rem !important;
                }

                .auth-form label {
                    display: block;
                    text-transform: uppercase;
                    font-size: 0.65rem !important;
                    margin-bottom: 0.25rem;
                    color: rgba(255, 255, 255, 0.7);
                }

                .auth-form input[type="text"],
                .auth-form input[type="email"],
                .auth-form input[type="password"] {
                    padding: 0.5rem !important;
                    margin-bottom: 1rem !important;
                    font-size: 0.85rem !important;
                    width: 100%;
                    background-color: transparent;
                    border: none;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                    color: white;
                    outline: none;
                    transition: border-color 0.3s ease;
                }

                .auth-form .checkbox-group {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    margin-bottom: 1rem;
                    flex-wrap: wrap;
                }

                .auth-form .checkbox-group label {
                    margin-bottom: 0;
                    text-transform: none;
                    font-size: 0.75rem !important;
                }

                .auth-submit-btn {
                    padding: 0.75rem !important;
                    font-size: 0.85rem !important;
                    margin-top: 0.5rem !important;
                    background-color: var(--primary-blue);
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    width: 100%;
                }

                .auth-links {
                    margin-top: 0.75rem !important;
                    padding-bottom: 0.5rem !important;
                    text-align: center;
                    font-size: 0.65rem !important;
                    flex-shrink: 0;
                }

                .parallax-elements {
                    display: none !important;
                }

                .scroll-spacer {
                    display: none !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-sidebar">
                    <h1>AgileDesk</h1>
                    <h2>Organiza tus proyectos de una manera facil y rapida</h2>
                    <div class="rocket-illustration">
                        <img src="{{ asset('img/agiledesk.png') }}" alt="Fondo decorativo" class="img-fluid">
                    </div>
                </div>
                <div class="auth-content">
                    <!-- Header móvil solo para dispositivos pequeños -->
                    <div class="mobile-header d-block d-sm-none">
                        <div class="mobile-logo">
                            <img src="{{ asset('img/agiledesk.png') }}" alt="AgileDesk Logo" />
                            <h1>AgileDesk</h1>
                        </div>
                    </div>

                    {{ $slot }}
                    <!-- Div invisible para forzar scroll en tablets -->
                    <div class="scroll-spacer" style="height: 150vh; width: 1px; visibility: hidden; pointer-events: none;"></div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/iconos.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButtons = document.querySelectorAll('.toggle-password');

                toggleButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const passwordContainer = this.closest('.password-container');
                        const passwordInput = passwordContainer.querySelector('input[type="password"], input[type="text"]');

                        if (passwordInput) {
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                this.classList.remove('fa-eye');
                                this.classList.add('fa-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                this.classList.remove('fa-eye-slash');
                                this.classList.add('fa-eye');
                            }
                        }
                    });
                });

                // Validación de email para dominio @unah.hn
                document.querySelectorAll('input[type="email"]').forEach(input => {
                    const contenedor = input.closest('.form-group') || input.parentElement;
                    let mensaje = contenedor.querySelector('.email-validation-message');

                    // Crear elemento de mensaje si no existe
                    if (!mensaje) {
                        mensaje = document.createElement('p');
                        mensaje.className = 'email-validation-message text-xs mt-1 hidden';
                        contenedor.appendChild(mensaje);
                    }

                    input.addEventListener('input', () => {
                        const email = input.value.trim();
                        const esValido = /^[a-zA-Z0-9._%+-]+@(unah\.hn|unah\.edu\.hn)$/i.test(email);

                        if (email === '') {
                            mensaje.classList.add('hidden');
                            input.style.borderBottomColor = 'rgba(255, 255, 255, 0.2)';
                            return;
                        }

                        // Configurar mensaje y estilos según validación
                        mensaje.textContent = esValido
                            ? '✓ Email UNAH válido'
                            : '✗ Solo se permiten emails @unah.hn o @unah.edu.hn';

                        mensaje.className = `email-validation-message text-xs mt-1 ${esValido ? 'text-green-400' : 'text-red-400'}`;
                        mensaje.classList.remove('hidden');
                        input.style.borderBottomColor = esValido ? '#4ade80' : '#ef4444';
                    });
                });
            });
        </script>
        <!-- Script para el efecto parallax PERSISTENTE Y ROBUSTO -->
        <script>
        // ====== SISTEMA PARALLAX PERSISTENTE ======
        window.AgileParallax = window.AgileParallax || {};

        // Variables globales para persistir estado
        window.AgileParallax.mouseX = 0;
        window.AgileParallax.mouseY = 0;
        window.AgileParallax.scrollProgress = 0;
        window.AgileParallax.isInitialized = false;
        window.AgileParallax.animationFrame = null;
        window.AgileParallax.eventListeners = [];

        // Función para limpiar listeners previos
        window.AgileParallax.cleanup = function() {
            if (this.animationFrame) {
                cancelAnimationFrame(this.animationFrame);
                this.animationFrame = null;
            }

            this.eventListeners.forEach(({ element, event, handler }) => {
                element.removeEventListener(event, handler);
            });
            this.eventListeners = [];

            this.isInitialized = false;
        };

        // Función principal de inicialización
        window.AgileParallax.init = function() {
            // Limpiar estado anterior
            this.cleanup();

            // Detectar tablets - RANGO ULTRA AMPLIO para asegurar funcionamiento
            const width = window.innerWidth;
            const height = window.innerHeight;
            const isTablet = width >= 750 && width <= 1400;

            // Si NO es tablet, salir inmediatamente
            if (!isTablet) {
                return false;
            }

            const sidebar = document.querySelector('.auth-sidebar');
            if (!sidebar) {
                return false;
            }

            // Limpiar elementos parallax existentes (por si los hay)
            const existingParallax = sidebar.querySelector('.parallax-elements');
            if (existingParallax) {
                existingParallax.remove();
            }

            // Crear elementos parallax SUTILES como en el ejemplo original
            const parallaxHTML = `
                <div class="parallax-elements" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 0; pointer-events: none;">
                    <div class="parallax-circle circle-1" style="position: absolute; width: 150px; height: 150px; top: -50px; right: -50px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); will-change: transform; transition: transform 0.1s ease-out;"></div>
                    <div class="parallax-circle circle-2" style="position: absolute; width: 100px; height: 100px; bottom: -30px; left: 20%; border-radius: 50%; background: rgba(255, 255, 255, 0.08); will-change: transform; transition: transform 0.1s ease-out;"></div>
                </div>
            `;

            sidebar.insertAdjacentHTML('afterbegin', parallaxHTML);

            // Referencias a elementos (re-buscar cada vez)
            this.elements = {
                sidebar: sidebar,
                circles: sidebar.querySelectorAll('.parallax-circle'),
                logo: sidebar.querySelector('.rocket-illustration img'),
                h1: sidebar.querySelector('h1'),
                h2: sidebar.querySelector('h2')
            };

            // Configurar event listeners con referencias guardadas
            this.setupEventListeners();

            // Marcar como inicializado
            this.isInitialized = true;

            // Ejecutar primera actualización
            this.updateParallax();

            return true;
        };

        // Configurar event listeners
        window.AgileParallax.setupEventListeners = function() {
            const mouseMoveHandler = (e) => {
                this.mouseX = (e.clientX / window.innerWidth) - 0.5; // -0.5 a 0.5
                this.mouseY = (e.clientY / window.innerHeight) - 0.5; // -0.5 a 0.5
                this.requestParallaxUpdate();
            };

            const scrollHandler = () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const maxScroll = Math.max(document.body.scrollHeight - window.innerHeight, 1);
                this.scrollProgress = Math.min(scrollTop / maxScroll, 1);
                this.requestParallaxUpdate();
            };

            // Añadir listeners y guardar referencias para limpieza
            document.addEventListener('mousemove', mouseMoveHandler, { passive: true });
            window.addEventListener('scroll', scrollHandler, { passive: true });

            this.eventListeners.push(
                { element: document, event: 'mousemove', handler: mouseMoveHandler },
                { element: window, event: 'scroll', handler: scrollHandler }
            );
        };

        // Solicitar actualización con throttling
        window.AgileParallax.requestParallaxUpdate = function() {
            if (!this.animationFrame) {
                this.animationFrame = requestAnimationFrame(() => {
                    this.updateParallax();
                    this.animationFrame = null;
                });
            }
        };

        // Función de actualización principal
        window.AgileParallax.updateParallax = function() {
            if (!this.isInitialized || !this.elements) return;

            try {
                const { sidebar, circles, logo, h1, h2 } = this.elements;
                const { mouseX, mouseY, scrollProgress } = this;

                // Movimiento de círculos SUTIL como en el ejemplo original
                circles.forEach((circle, index) => {
                    // Movimientos más suaves y pequeños
                    const moveX = mouseX * 40 + (index % 2 === 0 ? scrollProgress * 20 : -scrollProgress * 15);
                    const moveY = mouseY * 40 + scrollProgress * (index * 10 + 10);
                    const rotation = scrollProgress * 30 + mouseX * 60;
                    const scale = 1 + Math.abs(mouseX) * 0.1 + scrollProgress * 0.1;

                    circle.style.transform = `translate(${moveX}px, ${moveY}px) rotate(${rotation}deg) scale(${scale})`;
                });

                // Movimiento del logo MÁS SUTIL
                if (logo) {
                    const logoX = mouseX * -15;
                    const logoY = mouseY * -15 + scrollProgress * 20;
                    const logoRotation = scrollProgress * 5 + mouseX * 8;
                    const logoScale = 1.15 + scrollProgress * 0.1;

                    logo.style.transform = `scale(${logoScale}) translate(${logoX}px, ${logoY}px) rotate(${logoRotation}deg)`;
                }

                // Movimiento de textos MÁS SUTIL
                if (h1) {
                    const h1X = mouseX * 8;
                    const h1Y = mouseY * 8 - scrollProgress * 10;
                    h1.style.transform = `translate(${h1X}px, ${h1Y}px)`;
                }

                if (h2) {
                    const h2X = mouseX * 5;
                    const h2Y = mouseY * 5 - scrollProgress * 8;
                    h2.style.transform = `translate(${h2X}px, ${h2Y}px)`;
                }

                // MANTENER gradiente azul original - SIN cambios de color dramáticos
                const baseHue1 = 210; // Azul base
                const baseHue2 = 220; // Azul base
                const hue1 = baseHue1 + mouseX * 8 + scrollProgress * 15; // Cambios muy sutiles
                const hue2 = baseHue2 + mouseX * 10 + scrollProgress * 20; // Cambios muy sutiles
                const saturation = 70 + mouseY * 5; // Saturación base estable

                sidebar.style.background = `linear-gradient(135deg, hsl(${hue1}, ${saturation}%, 65%) 0%, hsl(${hue2}, ${saturation}%, 55%) 100%)`;

                // Parallax del sidebar MÁS SUTIL
                const sidebarMove = scrollProgress * 50; // Reducido de 80 a 50
                const opacity = Math.max(0.3, 1 - scrollProgress * 0.5); // Menos transparencia
                const sidebarScale = Math.max(0.9, 1 - scrollProgress * 0.1); // Menos escalado

                sidebar.style.transform = `translateY(${sidebarMove}px) scale(${sidebarScale})`;
                sidebar.style.opacity = opacity;

            } catch (error) {
                console.error('❌ Error en parallax:', error);
            }
        };

        // ====== INICIALIZACIÓN AUTOMÁTICA ======
        // Inicializar inmediatamente si el DOM está listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                window.AgileParallax.init();
            });
        } else {
            // DOM ya está listo, inicializar inmediatamente
            window.AgileParallax.init();
        }

        // Re-inicializar en resize si es necesario
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (!window.AgileParallax.isInitialized) {
                    window.AgileParallax.init();
                }
            }, 250);
        });
        </script>
    </body>
</html>
