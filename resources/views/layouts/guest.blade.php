<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Agile Desk') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilos personalizados -->
        <style>
            :root {
                --vh: 1vh;
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            html, body {
                height: 100%;
                overflow: hidden;
                max-width: 100vw;
                position: fixed; /* Añadido para prevenir scroll en iOS */
                width: 100%; /* Añadido para prevenir scroll en iOS */
            }
            
            .auth-container {
                position: fixed; /* Cambiado de relative a fixed */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #fff;
                padding: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            
             .auth-card {
                display: flex;
                width: 100%;
                height: 100%;
                max-height: 100vh;
                overflow: auto; /* Cambiado para permitir scroll interno si es necesario */
                box-shadow: none;
                transition: all 0.3s ease;
            }
            
            .auth-sidebar {
                background-color: #62b0f0; 
                padding: 2rem 1.5rem;
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                color: white;
                transition: all 0.3s ease;
            }
            
            .auth-sidebar h2 {
                font-size: 1.5rem;
                font-weight: 500;
                margin-bottom: 1.5rem;
            }
            
            .auth-sidebar .rocket-illustration {
                width: 60%;
                max-width: 180px;
                margin: 1.5rem 0;
                transition: all 0.3s ease;
            }
            
            .auth-content {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                background-color: #2d3a4d; /* Azul oscuro */
                flex: 1;
                display: flex;
                flex-direction: column;
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
                background-color: #62b0f0;
                color: white;
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
                padding: 0.5rem 0;
                margin-bottom: 1.5rem;
                color: white;
                outline: none;
                transition: border-color 0.3s ease;
            }
            
            .auth-form input[type="text"]:focus,
            .auth-form input[type="email"]:focus,
            .auth-form input[type="password"]:focus {
                border-bottom-color: #4dd0b4;
            }
            
            .auth-form input[type="checkbox"] {
                accent-color: #62b0f0;
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
                background-color: #62b0f0;
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
                background-color: #62b0f0;
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

            /* Responsive breakpoints */
            
            /* Large devices (desktops, 992px and up) */
            @media (min-width: 992px) {
                .auth-card {
                    height: auto;
                    min-height: 550px;
                    max-width: 900px;
                    border-radius: 8px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                }
                
                .auth-container {
                    padding: 2rem;
                }
                
                .auth-sidebar {
                    padding: 3rem 2rem;
                }
                
                .auth-content {
                    padding: 3rem 2rem;
                }
                
                .auth-sidebar .rocket-illustration {
                    margin: 2rem 0;
                }
                
                .auth-submit-btn {
                    width: auto;
                }
                
                .auth-links {
                    text-align: right;
                }
            }
            
            /* Medium devices (tablets, 768px and up) */
            @media (min-width: 768px) and (max-width: 991.98px) {
                .auth-card {
                    height: auto;
                    min-height: 500px;
                    max-width: 700px;
                    border-radius: 8px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                }
                .auth-content {
                    padding: 2rem 1.5rem;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    width: 100%;
                }

                .auth-form {
                    width: 100%;
                    max-width: 400px;
                    margin: 0 auto;
                }
                .auth-container {
                    padding: 1.5rem;
                }
                
                .auth-submit-btn {
                    width: auto;
                }

                .rocket-illustration img {
                    max-width: 80%;
                    transform: scale(1.15); /* Aumenta el tamaño del logo en 15% */
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
                
                .auth-sidebar .rocket-illustration {
                    max-width: 120px;
                    margin: 1rem 0;
                }
                
                .auth-sidebar h2 {
                    font-size: 1.2rem;
                }
            }
            
            /* Extra small devices (portrait phones, less than 576px) */
            @media (max-width: 575.98px) {
                .auth-container {
                    background-color: #2d3a4d; /* Mismo color que auth-content para continuidad visual */
                    padding: 0;
                }
                
                .auth-card {
                    flex-direction: column;
                    height: auto;
                    min-height: 100%;
                    border-radius: 0;
                    background-color: #2d3a4d;
                }
                
                .auth-sidebar {
                    display: none; /* Oculta el sidebar en dispositivos móviles */
                }
                
                .auth-content {
                    padding: 1.5rem 1rem;
                    width: 100%;
                    justify-content: center; /* Centrar verticalmente */
                }
                
                .auth-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }
                
                .auth-header-links {
                    width: 100%;
                    display: flex;
                    gap: 0.5rem;
                }
                
                .auth-header-links a {
                    flex: 1;
                    text-align: center;
                }
            }
            
            .rocket-illustration {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 1.5rem auto;
                position: relative;
                z-index: 1;
            }

            .rocket-illustration img {
                max-width: 100%;
                height: auto;
                display: block;
                object-fit: contain;
                transition: transform 0.3s ease;
            }

            /* Media queries para ajustar el tamaño en dispositivos diferentes */
            @media (min-width: 992px) {
                .rocket-illustration img {
                    max-width: 80%;
                    transform: scale(1.25); /* Aumenta el tamaño del logo en 25% */
                }
            }

            @media (max-width: 767.98px) {
                .rocket-illustration {
                    max-width: 70%;
                }
            }

            @media (max-width: 575.98px) {
                .rocket-illustration {
                    max-width: 60%;
                }
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
            color: #62b0f0;
        }

        .auth-form input[type="password"] {
            padding-right: 40px;
            width: 100%;
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
                    <div class="pagination-dots">
                        <div class="dot active"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
                <div class="auth-content">
                    {{ $slot }}
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
            });
        </script>
        </body>
</html>