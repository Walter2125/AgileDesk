@extends('layouts.app')

@section('title', 'Agile Desk')

@section('styles')
    <style>
        /* Variables personalizadas */
        :root {
            --primary-gradient: linear-gradient(to right, #6fb3f2, #4a90e2);
            --hover-gradient: linear-gradient(to right, #4a90e2, #357abd);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 8px rgba(0,0,0,0.12);
            --shadow-lg: 0 8px 16px rgba(0,0,0,0.14);
            --github-bg: #0d1117;
            --github-border: #30363d;
            --github-text: #f0f6fc;
            --github-text-secondary: #8b949e;
            --github-green: #238636;
            --github-green-light: #2ea043;
            --github-card-bg: #161b22;
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

        /* Estadísticas estilo GitHub */
        .github-stats-section {
            background: var(--github-bg);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid var(--github-border);
        }

        .github-stats-title {
            color: var(--github-text);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .user-card {
            background: var(--github-card-bg);
            border: 1px solid var(--github-border);
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .user-card:hover {
            border-color: var(--github-green);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        .user-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--github-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 1rem;
            border: 2px solid var(--github-border);
        }

        .user-info h4 {
            color: var(--github-text);
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .user-info .user-email {
            color: var(--github-text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .stats-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--github-text);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--github-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Gráfico de contribuciones estilo GitHub */
        .contribution-graph {
            margin-top: 1rem;
        }

        .contribution-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            max-width: 200px;
            margin: 0 auto;
        }

        .contribution-day {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            background: #21262d;
            border: 1px solid var(--github-border);
        }

        .contribution-day.level-1 { background: #0e4429; }
        .contribution-day.level-2 { background: #006d32; }
        .contribution-day.level-3 { background: #26a641; }
        .contribution-day.level-4 { background: #39d353; }

        /* Barras de progreso mejoradas */
        .progress-item {
            margin-bottom: 0.75rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .progress-label {
            color: var(--github-text);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .progress-value {
            color: var(--github-text-secondary);
            font-size: 0.8rem;
        }

        .progress-bar-custom {
            width: 100%;
            height: 6px;
            background: #21262d;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .progress-fill.pendiente { background: #656d76; }
        .progress-fill.progreso { background: #d29922; }
        .progress-fill.listo { background: var(--github-green); }

        /* Resumen general */
        .overall-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            border: 1px solid var(--github-border);
        }

        .overall-stat {
            text-align: center;
        }

        .overall-stat-number {
            display: block;
            font-size: 2rem;
            font-weight: bold;
            color: var(--github-green-light);
            margin-bottom: 0.25rem;
        }

        .overall-stat-label {
            color: var(--github-text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .overall-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@stop

@section('content')
    <!-- Hero Section con parallax -->
    <div class="hero-section">
        <div class="hero-bg" id="hero-bg">
            <img src="{{ asset('img/notas.jpg') }}" alt="Fondo decorativo" id="parallax-bg">
        </div>
        <div class="hero-content" id="hero-content">
            <img src="{{ asset('img/software.png') }}" alt="Imagen de software" class="hero-img" id="software-img">
            <h1 class="hero-title" id="hero-title">Agile Desk</h1>
        </div>
    </div>

    {{--  
    <div class="detalle-btn-container">
        <a href="{{ route('mis_historias') }}" class="btn detalle-btn">Ver Mis Historias</a>
    </div>
    --}}

    <div class="container main-content">
        <h2 class="section-title text-center">Agile Desk Para Usuarios</h2>

        {{-- Selector visual de proyecto --}}
        @auth
        @if(isset($proyectos_usuario) && $proyectos_usuario->count())
        <form method="GET" action="" class="mb-4" id="selector-proyecto-form">
            <div class="row justify-content-center align-items-center">
                <div class="col-auto">
                    <label for="selector-proyecto" class="form-label fw-semibold mb-0">Proyecto actual:</label>
                </div>
                <div class="col-auto">
                    <select name="project_id" id="selector-proyecto" class="form-select" onchange="this.form.submit()">
                        @foreach($proyectos_usuario as $proy)
                            <option value="{{ $proy->id }}" @if(isset($proyecto_actual) && $proyecto_actual && $proy->id == $proyecto_actual->id) selected @endif>
                                {{ $proy->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        @endif
        @endauth

        <div class="carousel-wrapper">
            <div id="carouselAgileDesk" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/imagen1.jpg') }}" class="d-block" alt="Agile Desk - Organización visual">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/imagen3.jpg') }}" class="d-block" alt="Agile Desk - Trabajo colaborativo">
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

        @auth
        @if($estadisticas->count())
        <div class="github-stats-section">
            <h3 class="github-stats-title">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Estadísticas de Participación del Equipo
            </h3>

            <!-- Resumen general -->
            <div class="overall-stats">
                <div class="overall-stat">
                    <span class="overall-stat-number">{{ $estadisticas->sum('total') }}</span>
                    <span class="overall-stat-label">Total Historias</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-number">{{ $estadisticas->sum('listo') }}</span>
                    <span class="overall-stat-label">Completadas</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-number">{{ $estadisticas->sum('progreso') }}</span>
                    <span class="overall-stat-label">En Progreso</span>
                </div>
                <div class="overall-stat">
                    <span class="overall-stat-number">{{ $estadisticas->count() }}</span>
                    <span class="overall-stat-label">Colaboradores</span>
                </div>
            </div>

            <!-- Grid de usuarios -->
            <div class="stats-grid">
                @foreach($estadisticas as $stat)
                    <div class="user-card">
                        <div class="user-header">
                            @if ($stat['usuario']->photo)
                                <img src="{{ asset('storage/' . $stat['usuario']->photo) }}" alt="Foto de perfil" class="user-avatar" style="object-fit:cover; border-radius:50%; width:40px; height:40px; min-width:40px;">
                            @else
                                <div class="user-avatar">
                                    {{ strtoupper(substr($stat['usuario']->name,0,1)) }}
                                </div>
                            @endif
                            <div class="user-info">
                                <h4>{{ $stat['usuario']->name }}</h4>
                                <p class="user-email">{{ $stat['usuario']->email }}</p>
                            </div>
                        </div>

                        <div class="stats-summary">
                            <div class="stat-item">
                                <span class="stat-number">{{ $stat['total'] }}</span>
                                <span class="stat-label">Total</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $stat['listo'] }}</span>
                                <span class="stat-label">Listo</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $stat['total'] ? round(($stat['listo']/$stat['total'])*100) : 0 }}%</span>
                                <span class="stat-label">Completado</span>
                            </div>
                        </div>

                        <div class="progress-item">
                            <div class="progress-header">
                                <span class="progress-label">Pendiente</span>
                                <span class="progress-value">{{ $stat['pendientes'] }}</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill pendiente" style="width: {{ $stat['total'] ? ($stat['pendientes']/$stat['total'])*100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-item">
                            <div class="progress-header">
                                <span class="progress-label">En Progreso</span>
                                <span class="progress-value">{{ $stat['progreso'] }}</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill progreso" style="width: {{ $stat['total'] ? ($stat['progreso']/$stat['total'])*100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="progress-item">
                            <div class="progress-header">
                                <span class="progress-label">Completado</span>
                                <span class="progress-value">{{ $stat['listo'] }}</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill listo" style="width: {{ $stat['total'] ? ($stat['listo']/$stat['total'])*100 : 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Gráfico de contribuciones simulado -->
                        <div class="contribution-graph">
                            <div class="contribution-grid">
                                @for($i = 0; $i < 35; $i++)
                                    @php
                                        $level = 0;
                                        if($stat['total'] > 0) {
                                            $activity = rand(0, 4);
                                            if($activity > 0) $level = min(4, $activity);
                                        }
                                    @endphp
                                    <div class="contribution-day {{ $level > 0 ? 'level-'.$level : '' }}"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        @endauth
    </div>
@stop

@section('scripts')
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

            // Animación de las barras de progreso
            const progressBars = document.querySelectorAll('.progress-fill');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bar = entry.target;
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    }
                });
            });

            progressBars.forEach(bar => observer.observe(bar));
        });
    </script>
@stop