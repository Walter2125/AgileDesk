<?php $__env->startSection('title', 'Agile Desk'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Variables personalizadas */
        :root {
            --primary-gradient: linear-gradient(to right, #6fb3f2, #4a90e2);
            --hover-gradient: linear-gradient(to right, #4a90e2, #357abd);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 8px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.14);
        }

        /* Hero section y parallax */
        .hero-section {
            position: relative;
            height: 50vh;
            min-height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }

        .hero-img {
            max-width: 200px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            margin: 0;
        }

        /* Botón personalizado */
        .detalle-btn-container {
            display: flex;
            justify-content: flex-end;
            padding-right: 20px;
            margin: 1.5rem 0;
        }

        .detalle-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .detalle-btn:hover {
            background: var(--hover-gradient);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Contenido principal */
        .main-content {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        /* Carrusel */
        .carousel-wrapper {
            max-width: 800px;
            margin: 0 auto 2rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .carousel-item img {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        /* Descripción */
        .description {
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.2rem;
            line-height: 1.6;
            color: #555;
        }

        /* Media queries */
        @media (max-width: 768px) {
            .hero-section {
                height: 40vh;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-img {
                max-width: 150px;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section con parallax -->
    <div class="hero-section">
        <div class="hero-bg" id="hero-bg">
            <img src="<?php echo e(asset('img/notas.jpg')); ?>" alt="Fondo decorativo" id="parallax-bg">
        </div>
        <div class="hero-content" id="hero-content">
            <img src="<?php echo e(asset('img/software.png')); ?>" alt="Imagen de software" class="hero-img" id="software-img">
            <h1 class="hero-title" id="hero-title">Agile Desk</h1>
        </div>
    </div>

    

    <div class="container main-content">
        <h2 class="section-title text-center">Agile Desk Para Usuarios</h2>

        <div class="carousel-wrapper">
            <div id="carouselAgileDesk" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('img/imagen1.jpg')); ?>" class="d-block" alt="Agile Desk - Organización visual">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('img/imagen3.jpg')); ?>" class="d-block" alt="Agile Desk - Trabajo colaborativo">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAgileDesk" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselAgileDesk" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>

        <p class="description text-center">
            Tu tablero digital para organizar Sprints de manera eficiente y colaborativa. 
            Optimiza tu proceso de desarrollo con herramientas ágiles diseñadas para equipos modernos.
        </p>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        /**
         * Función para inicializar y gestionar el efecto parallax
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a elementos DOM
            const heroBg = document.getElementById('parallax-bg');
            const softwareImg = document.getElementById('software-img');
            const heroTitle = document.getElementById('hero-title');
            
            // Variables para el efecto parallax
            let lastScrollY = window.scrollY;
            let animationFrameId = null;
            
            // Aplicar el efecto parallax
            function applyParallax() {
                const scrollY = window.scrollY;
                
                // Solo actualizar si hay cambio en el scroll
                if (scrollY !== lastScrollY) {
                    // Cálculo del efecto parallax
                    // El fondo se mueve más lento que el scroll
                    if (heroBg) {
                        heroBg.style.transform = `translateY(${scrollY * 0.4}px)`;
                    }
                    
                    // La imagen y el título se mueven en dirección contraria para dar profundidad
                    if (softwareImg) {
                        softwareImg.style.transform = `translateY(${-scrollY * 0.1}px)`;
                    }
                    
                    if (heroTitle) {
                        heroTitle.style.transform = `translateY(${-scrollY * 0.15}px)`;
                    }
                    
                    lastScrollY = scrollY;
                }
                
                // Solicitar el siguiente frame
                animationFrameId = requestAnimationFrame(applyParallax);
            }
            
            // Iniciar el efecto parallax
            applyParallax();
            
            // Limpieza al desmontar para evitar memory leaks
            window.addEventListener('beforeunload', function() {
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                }
            });
            
            // Inicializar el carrusel si existe Bootstrap
            if (typeof bootstrap !== 'undefined') {
                const carouselElement = document.getElementById('carouselAgileDesk');
                if (carouselElement) {
                    new bootstrap.Carousel(carouselElement, {
                        interval: 5000,
                        pause: 'hover'
                    });
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\trimi\AgileDesk\resources\views/users/colaboradores/homeuser.blade.php ENDPATH**/ ?>