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

        <!-- logo -->
        <link rel="icon" href="{{ asset('img/agiledesk.png') }}" type="image/x-icon">
    
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
                background: #fff; 
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
                flex: 0 0 45%; /* Ancho fijo del 45% para consistencia entre login y registro */
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
            
            .auth-sidebar h2 {
                font-size: 1.5rem;
                font-weight: 500;
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .auth-sidebar h1 {
                position: relative;
                z-index: 2;
            }
            
            .auth-sidebar .rocket-illustration {
                width: 60%;
                max-width: 180px;
                margin: 1.5rem 0;
                transition: all 0.3s ease;
                position: relative;
                z-index: 2;
            }
            
            .auth-content {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                background-color: #2d3a4d; /* Azul oscuro */
                flex: 0 0 55%; /* Ancho fijo del 55% para complementar el sidebar (login/registro) */
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
            #email {
                padding: 0.5rem;
            }
            #password {
                padding: 0.5rem;
            }
            #name {
                padding: 0.5rem;
            }
            #password_confirmation {
                padding: 0.5rem;
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
                    height: 520px;
                    max-width: 900px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                }
                
                .auth-container {
                    padding: 2rem;
                }
                
                .auth-sidebar {
                    padding: 3rem 2rem;
                    flex: 0 0 45%; /* Mantener ancho fijo en desktop */
                }
                
                .auth-content {
                    padding: 3rem 2rem;
                    flex: 0 0 55%; /* Mantener ancho fijo en desktop */
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
    html, body {
        height: auto !important; /* Sobrescribir */
        overflow: visible !important; /* Sobrescribir */
        position: static !important; /* Sobrescribir */
    }
    
    .auth-container {
        position: relative !important; /* Sobrescribir */
        min-height: 200vh; /* Altura mayor para permitir scroll */
        height: auto;
        overflow: visible !important;
    }
    
    /* Agregar más altura para garantizar scroll */
    .auth-content {
        min-height: 120vh; /* Aumentar altura para forzar scroll */
    }
    .auth-card {
        height: auto;
        min-height: 200vh; /* Altura mayor para scroll */
        max-width: none; /* Sin límite de ancho en tablets */
        width: 100%; /* Ancho completo */
        box-shadow: none; /* Sin sombra */
        flex-direction: column; /* En tablets, sidebar arriba y contenido abajo */
        overflow: visible;
        position: relative;
    }
    
    .auth-sidebar {
        position: fixed; /* Fijo para que se mueva con el scroll */
        top: 0;
        left: 0;
        width: 100%; /* Ancho completo */
        height: 60vh; /* Altura fija */
        overflow: hidden; /* Contener elementos parallax */
        background-attachment: scroll; /* Permitir que el fondo se mueva */
        z-index: 10; /* Z-index alto para estar encima */
        will-change: transform, background-position, background-image; /* Optimización de rendimiento */
        transition: transform 0.1s ease-out, background-image 0.3s ease;
        background-image: linear-gradient(135deg, #62b0f0 0%, #3d8cd6 100%); /* Gradiente por defecto */
        background-size: 200% 200%; /* Fondo más grande para movimiento */
        background-position: center center;
        transform: translateY(0); /* Inicial */
    }
    
    /* Elementos para el efecto parallax */
    .auth-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("{{ asset('img/agiledesk.png') }}") center no-repeat;
        background-size: 50%;
        opacity: 0.05;
        z-index: 0;
        transform: translateY(0);
        will-change: transform;
        pointer-events: none;
    }
    
    .auth-sidebar .parallax-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
    }
    
    .auth-sidebar .parallax-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        will-change: transform;
    }
    
    .auth-sidebar .circle-1 {
        width: 150px;
        height: 150px;
        top: -50px;
        right: -50px;
    }
    
    .auth-sidebar .circle-2 {
        width: 100px;
        height: 100px;
        bottom: -30px;
        left: 20%;
    }
    
    .auth-sidebar h1, 
    .auth-sidebar h2 {
        will-change: transform; /* Optimización para animaciones */
        backface-visibility: hidden; /* Reduce parpadeos */
    }
    
    .parallax-elements {
        pointer-events: none; /* Para que no interfiera con clics */
    }
    .auth-content {
        padding: 2rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 60vh; /* Margen para compensar el sidebar fijo */
        position: relative;
        z-index: 5; /* Z-index menor que el sidebar */
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
        position: relative;
        z-index: 1;
        will-change: transform;
    }
    
    /* Mostrar scroll spacer solo en tablets */
    .scroll-spacer {
        display: block !important;
        visibility: visible !important;
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
                
                /* Header móvil con logo y nombre */
                .mobile-header {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem 1rem 1rem 1rem;
                    color: white;
                    text-align: center;
                    margin-bottom: 1rem;
                }
                
                .mobile-header .mobile-logo {
                    width: 80px;
                    height: 80px;
                    margin-bottom: 1rem;
                    border-radius: 12px;
                    background: rgba(255, 255, 255, 0.1);
                    padding: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .mobile-header .mobile-logo img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }
                
                .mobile-header h1 {
                    font-size: 1.5rem;
                    font-weight: 600;
                    margin: 0;
                    letter-spacing: 0.5px;
                }
                
                .mobile-header p {
                    font-size: 0.875rem;
                    margin: 0.5rem 0 0 0;
                    opacity: 0.9;
                    font-weight: 400;
                }
                
                .auth-content {
                    padding: 0 1rem 1.5rem 1rem;
                    width: 100%;
                    justify-content: flex-start; /* Cambiar de center a flex-start para permitir header móvil */
                }
                
                .auth-header {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                    margin-top: 0; /* Eliminar margen superior ya que tenemos el header móvil */
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
        }            .auth-form input[type="password"] {
                padding-right: 40px;
                width: 100%;
            }
            
            /* Ocultar scroll spacer por defecto */
            .scroll-spacer {
                display: none !important;
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
                    <div class="mobile-header">
                        <div class="mobile-logo">
                            <img src="{{ asset('img/agiledesk.png') }}" alt="AgileDesk Logo" />
                        </div>
                        <h1>AgileDesk</h1>
                        <p>Gestión Ágil de Proyectos</p>
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
            });
        </script>
        <!-- Script para el efecto parallax con scroll y mouse -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Inicializando parallax con scroll...');
            console.log('Window width:', window.innerWidth);
            
            // Verificar si estamos en tablet (temporalmente deshabilitado para debug)
            const isTablet = true; // window.innerWidth >= 768 && window.innerWidth <= 991.98;
            
            if (!isTablet) {
                console.log('No es tablet, efecto parallax deshabilitado');
                return;
            }
            
            console.log('Tablet detectado, iniciando parallax');
            
            const sidebar = document.querySelector('.auth-sidebar');
            if (!sidebar) {
                console.log('No se encontró sidebar');
                return;
            }
            
            console.log('Sidebar encontrado:', sidebar);
            
            // Crear elementos parallax directamente en el HTML
            const parallaxHTML = `
                <div class="parallax-elements" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 0; pointer-events: none;">
                    <div class="parallax-circle circle-1" style="position: absolute; width: 150px; height: 150px; top: -50px; right: -50px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); will-change: transform; transition: transform 0.1s ease-out;"></div>
                    <div class="parallax-circle circle-2" style="position: absolute; width: 100px; height: 100px; bottom: -30px; left: 20%; border-radius: 50%; background: rgba(255, 255, 255, 0.15); will-change: transform; transition: transform 0.1s ease-out;"></div>
                    <div class="parallax-circle circle-3" style="position: absolute; width: 80px; height: 80px; top: 50%; left: 30%; border-radius: 50%; background: rgba(255, 255, 255, 0.25); will-change: transform; transition: transform 0.1s ease-out;"></div>
                </div>
            `;
            
            sidebar.insertAdjacentHTML('afterbegin', parallaxHTML);
            console.log('Elementos parallax insertados');
            
            // Referencias a elementos
            const circle1 = sidebar.querySelector('.circle-1');
            const circle2 = sidebar.querySelector('.circle-2');
            const circle3 = sidebar.querySelector('.circle-3');
            const logo = sidebar.querySelector('.rocket-illustration img');
            const h1 = sidebar.querySelector('h1');
            const h2 = sidebar.querySelector('h2');
            
            if (!circle1 || !circle2 || !circle3) {
                console.log('Error: no se encontraron todos los círculos');
                return;
            }
            
            console.log('Círculos encontrados, iniciando listeners');
            
            // Variables para el efecto combinado
            let scrollProgress = 0;
            let mouseX = 0;
            let mouseY = 0;
            
            function updateParallax() {
                // Combinar efectos de scroll y mouse
                const totalX = mouseX + (scrollProgress * 0.3);
                const totalY = mouseY + (scrollProgress * 0.5);
                
                // Movimiento de círculos con efecto combinado
                circle1.style.transform = `translate(${totalX * 40}px, ${totalY * 40 - scrollProgress * 30}px) rotate(${scrollProgress * 45}deg)`;
                circle2.style.transform = `translate(${totalX * -30}px, ${totalY * -30 + scrollProgress * 20}px) rotate(${-scrollProgress * 30}deg)`;
                circle3.style.transform = `translate(${totalX * 20}px, ${totalY * 20 - scrollProgress * 15}px) scale(${1 + scrollProgress * 0.2})`;
                
                // Movimiento sutil del logo y textos
                if (logo) {
                    logo.style.transform = `scale(${1.15 + scrollProgress * 0.1}) translate(${totalX * -10}px, ${totalY * -10 + scrollProgress * 20}px) rotate(${scrollProgress * 5}deg)`;
                }
                
                if (h1) {
                    h1.style.transform = `translate(${totalX * 5}px, ${totalY * 5 - scrollProgress * 10}px)`;
                }
                
                if (h2) {
                    h2.style.transform = `translate(${totalX * 3}px, ${totalY * 3 - scrollProgress * 8}px)`;
                }
                
                // Cambio dinámico del gradiente de fondo
                const hue1 = 210 + totalX * 15 + scrollProgress * 30;
                const hue2 = 220 + totalX * 20 + scrollProgress * 45;
                const sat1 = 70 + totalY * 15 + scrollProgress * 20;
                const sat2 = 80 + totalY * 10 + scrollProgress * 15;
                const light1 = 65 + totalY * 8 - scrollProgress * 10;
                const light2 = 55 + totalY * 5 - scrollProgress * 8;
                
                sidebar.style.background = `linear-gradient(${135 + totalX * 60 + scrollProgress * 90}deg, 
                    hsl(${hue1}, ${sat1}%, ${light1}%) 0%, 
                    hsl(${hue2}, ${sat2}%, ${light2}%) 100%)`;
                
                // Cambiar posición del fondo
                sidebar.style.backgroundPosition = `${50 + totalX * 20}% ${50 + totalY * 20 - scrollProgress * 30}%`;
            }
            
            // Parallax basado en scroll
            function handleScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const maxScroll = document.body.scrollHeight - window.innerHeight;
                scrollProgress = Math.min(scrollTop / Math.max(maxScroll, 1), 1); // Normalizar entre 0 y 1
                
                console.log('Scroll progress:', scrollProgress, 'ScrollTop:', scrollTop); // Debug
                
                // Mover el sidebar junto con el scroll (parallax)
                const sidebarMove = scrollTop * 0.5; // Velocidad de movimiento del sidebar (0.5 = mitad de velocidad)
                sidebar.style.transform = `translateY(${sidebarMove}px)`;
                
                // Agregar efecto de transparencia gradual
                const opacity = Math.max(0.3, 1 - scrollProgress * 0.7); // De 1 a 0.3 de opacidad
                sidebar.style.opacity = opacity;
                
                // Escalar ligeramente el sidebar
                const scale = 1 - scrollProgress * 0.1; // De 1 a 0.9
                sidebar.style.transform = `translateY(${sidebarMove}px) scale(${scale})`;
                
                updateParallax();
            }
            
            // Parallax basado en movimiento del mouse
            function handleMouseMove(e) {
                mouseX = (e.clientX / window.innerWidth) - 0.5; // -0.5 a 0.5
                mouseY = (e.clientY / window.innerHeight) - 0.5; // -0.5 a 0.5
                updateParallax();
            }
            
            // Event listeners
            window.addEventListener('scroll', handleScroll, { passive: true });
            document.addEventListener('mousemove', handleMouseMove);
            
            // Resetear al salir del mouse
            sidebar.addEventListener('mouseleave', function() {
                mouseX = 0;
                mouseY = 0;
                updateParallax();
            });
            
            // Inicializar
            handleScroll();
        });
        </script>
        </body>
</html>