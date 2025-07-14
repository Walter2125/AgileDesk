@extends('layouts.app')

@section('title', 'Agile Desk')

@section('styles')
    <style>
        /* Variables personalizadas */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --hover-gradient: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            --shadow-md: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
            --shadow-lg: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            --github-bg: #0d1117;
            --github-border: #21262d;
            --github-card-bg: #ffffff;
            --github-text: #111111;
            --github-text-secondary: #444444;
            --github-green: #679def;
            --github-green-light: #679def;
            --github-orange: #fb8500;
            --github-red: #da3633;
            --github-blue: #1f6feb;
            --contribution-level-0: #161b22;
            --contribution-level-1: #0e4429;
            --contribution-level-2: #006d32;
            --contribution-level-3: #26a641;
            --contribution-level-4: #39d353;
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hero section mejorado */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2.5vw, 1.3rem);
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Contenedor principal */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Sección de estadísticas estilo GitHub */
        .github-stats-section {
            background: var(--github-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid var(--github-border);
            box-shadow: var(--shadow-lg);
        }

        .github-stats-title {
            color: var(--github-text);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stats-icon {
            width: 20px;
            height: 20px;
            fill: var(--github-green);
        }

        /* Resumen general mejorado */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--github-card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--github-border);
        }

        .summary-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.02);
            transition: var(--transition);
        }

        .summary-item:hover {
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
        }

        .summary-number {
            display: block;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            color: var(--github-green-light);
            margin-bottom: 0.5rem;
        }

        .summary-label {
            color: var(--github-text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Ranking de contribuidores */
        .contributors-ranking {
            background: var(--github-card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--github-border);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .ranking-header {
            padding: 1.5rem;
            background: rgba(255,255,255,0.02);
            border-bottom: 1px solid var(--github-border);
        }

        .ranking-title {
            color: var(--github-text);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .contributor-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--github-border);
            transition: var(--transition);
            position: relative;
            cursor: pointer;
        }

        .contributor-item:last-child {
            border-bottom: none;
        }

        .contributor-item:hover {
            background: rgba(255,255,255,0.03);
        }

        .contributor-rank {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--github-text-secondary);
            min-width: 2.5rem;
            text-align: center;
        }

        .contributor-rank.top-1 { color: #ffd700; }
        .contributor-rank.top-2 { color: #c0c0c0; }
        .contributor-rank.top-3 { color: #cd7f32; }

        .contributor-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin: 0 1rem;
            border: 2px solid var(--github-border);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }

        .contributor-avatar:hover {
            border-color: var(--github-green);
            transform: scale(1.05);
        }

        .contributor-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .contributor-avatar-placeholder {
            width: 100%;
            height: 100%;
            background: var(--github-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .contributor-info {
            flex: 1;
            min-width: 0;
        }

        .contributor-name {
            color: var(--github-text);
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            line-height: 1.2;
        }

        .contributor-email {
            color: var(--github-text-secondary);
            font-size: 0.85rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contributor-stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }

        .contributor-contributions {
            color: var(--github-text);
            font-size: 1.1rem;
            font-weight: 700;
        }

        .contributor-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-active {
            background: var(--github-green);
            color: white;
        }

        .badge-moderate {
            background: var(--github-orange);
            color: white;
        }

        .badge-inactive {
            background: var(--github-red);
            color: white;
        }

        .badge-new {
            background: var(--github-blue);
            color: white;
        }

        /* Gráfico de contribuciones */
        .chart-container {
            background: var(--github-card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--github-border);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-title {
            color: var(--github-text);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: var(--github-text);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--github-text-secondary);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .contributor-modal-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: block;
            border: 3px solid var(--github-border);
        }

        .contributor-modal-name {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--github-text);
        }

        .contributor-modal-email {
            text-align: center;
            color: var(--github-text-secondary);
            margin-bottom: 1.5rem;
        }

        .contributions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .contribution-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }

        .contribution-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--github-green);
            margin-bottom: 0.5rem;
        }

        .contribution-label {
            font-size: 0.9rem;
            color: var(--github-text-secondary);
        }

        .contribution-details {
            margin-top: 1.5rem;
        }

        .contribution-details-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--github-text);
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }

        .contribution-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contribution-list-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
        }

        .contribution-list-item:last-child {
            border-bottom: none;
        }

        .contribution-task {
            font-weight: 500;
            color: var(--github-text);
        }

        .contribution-status {
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-weight: 500;
        }

        .status-ready {
            background: #d1fae5;
            color: #065f46;
        }

        .status-progress {
            background: #bfdbfe;
            color: #1e40af;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contributor-item {
            animation: fadeInUp 0.5s ease-out;
        }

        .contributor-item:nth-child(2) { animation-delay: 0.1s; }
        .contributor-item:nth-child(3) { animation-delay: 0.2s; }
        .contributor-item:nth-child(4) { animation-delay: 0.3s; }
        .contributor-item:nth-child(5) { animation-delay: 0.4s; }

        /* Responsive design */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 35vh;
                padding: 1rem;
            }

            .github-stats-section {
                padding: 1.5rem;
                margin: 1rem 0;
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
                padding: 1rem;
            }

            .contributor-item {
                padding: 1rem;
                flex-wrap: wrap;
            }

            .contributor-avatar {
                width: 40px;
                height: 40px;
                margin: 0 0.75rem;
            }

            .contributor-info {
                flex: 1;
                min-width: 120px;
            }

            .contributor-name {
                font-size: 0.95rem;
            }

            .contributor-email {
                font-size: 0.8rem;
            }

            .contributor-stats {
                margin-top: 0.5rem;
                align-items: flex-start;
                width: 100%;
            }

            .chart-wrapper {
                height: 250px;
            }

            .contributions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 1rem;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .contributor-rank {
                min-width: 2rem;
                font-size: 1rem;
            }

            .contributor-avatar {
                width: 36px;
                height: 36px;
                margin: 0 0.5rem;
            }

            .chart-wrapper {
                height: 200px;
            }

            .modal-container {
                width: 95%;
            }
        }

        /* Loading states */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        .project-selector {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }
        
        .project-selector label {
            font-weight: 600;
            color: var(--github-text);
        }
        
        .project-selector select {
            flex: 1;
            max-width: 300px;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: 1px solid var(--github-border);
            background: var(--github-card-bg);
            color: var(--github-text);
            font-size: 1rem;
        }
        
        .current-project-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--github-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .current-project-title svg {
            width: 24px;
            height: 24px;
            fill: var(--github-green);
        }
        no-project-message {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            text-align: center;
            margin: 2rem 0;
            box-shadow: var(--shadow-sm);
        }
         /* Estilos para el modal mejorado */
    .user-details-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1.5rem;
        border: 3px solid #e1e4e8;
    }
    
    .user-info {
        flex: 1;
    }
    
    .user-name {
        font-size: 1.5rem;
        margin: 0 0 0.25rem 0;
        color: #24292e;
    }
    
    .user-email {
        color: #586069;
        margin: 0;
    }
    
    .stories-container {
        margin-top: 2rem;
    }
    
    .story-item {
        background: #f6f8fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e1e4e8;
    }
    
    .story-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .story-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0366d6;
        margin: 0;
    }
    
    .story-status {
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .status-pending { background: #ffd33d; color: #735c0f; }
    .status-progress { background: #79b8ff; color: #0349b4; }
    .status-ready { background: #28a745; color: white; }
    
    .story-description {
        color: #586069;
        margin-bottom: 1rem;
    }
    
    .tasks-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .task-item {
        padding: 0.75rem;
        border-bottom: 1px solid #e1e4e8;
        display: flex;
        align-items: center;
    }
    
    .task-item:last-child {
        border-bottom: none;
    }
    
    .task-checkbox {
        margin-right: 0.75rem;
    }
    
    .task-name {
        flex: 1;
        color: #24292e;
    }
    
    .task-assignee {
        font-size: 0.85rem;
        color: #586069;
    }
    
    .task-assignee-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-left: 0.5rem;
        vertical-align: middle;
    }
    
    .no-tasks {
        color: #586069;
        font-style: italic;
        padding: 0.75rem;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 1.5rem 0 1rem 0;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e1e4e8;
    }

    .tasks-accordion {
    margin-top: 1rem;
}

.accordion-toggle {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.accordion-toggle:hover {
    background: #e9ecef;
}

.task-counter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.counter-badge {
    background: #679def;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    min-width: 20px;
    text-align: center;
}

.chevron-icon {
    transition: transform 0.2s ease;
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 6px 6px;
}

.accordion-content.active {
    max-height: 300px;
    overflow-y: auto;
}

.tasks-list {
    margin: 0;
    padding: 1rem;
    list-style: none;
}

.tasks-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.tasks-list li:last-child {
    border-bottom: none;
}
    </style>
@stop

@section('content')
    <div class="main-container">
        <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:0.7rem;letter-spacing:0.5px;">Agile Desk</h1>
        
        @auth
            @if(isset($proyecto_actual))
                <!-- Selector de proyecto -->
                <div class="project-selector">
                    <label for="projectSelect">Proyecto:</label>
                    <select id="projectSelect" onchange="window.location.href = '/homeuser/' + this.value">
                        @foreach($proyectos_usuario as $project)
                            <option value="{{ $project->id }}" {{ $project->id == $proyecto_actual->id ? 'selected' : '' }}>
                                {{ $project->name }} ({{ $project->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <h2 class="current-project-title">
                    <svg viewBox="0 0 16 16" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 2.5A2.5 2.5 0 014.5 0h8.75a.75.75 0 01.75.75v12.5a.75.75 0 01-.75.75h-2.5a.75.75 0 110-1.5h1.75v-2h-8a1 1 0 00-.714 1.7.75.75 0 01-1.072 1.05A2.495 2.495 0 012 11.5v-9zm10.5-1V9h-8c-.356 0-.694.074-1 .208V2.5a1 1 0 011-1h8zM5 12.25v3.25a.25.25 0 00.4.2l1.45-1.087a.25.25 0 01.3 0L8.6 15.7a.25.25 0 00.4-.2v-3.25a.25.25 0 00-.25-.25h-3.5a.25.25 0 00-.25.25z"/>
                    </svg>
                    {{ $proyecto_actual->name }}
                </h2>
                
                @if($estadisticas->count())
                <div class="">
                    <h3 class="github-stats-title">
                        <svg class="stats-icon" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Estadísticas del Proyecto
                    </h3>

                    <!-- Resumen general del proyecto -->
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_historias_proyecto }}</span>
                            <span class="summary-label">Total Historias</span>
                        </div>
                        <!--
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_listo }}</span>
                            <span class="summary-label">Completadas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_progreso }}</span>
                            <span class="summary-label">En Progreso</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_pendientes }}</span>
                            <span class="summary-label">Pendientes</span>
                        </div>
                        -->
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_tareas_proyecto }}</span>
                            <span class="summary-label">Total Tareas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_contribuciones_proyecto }}</span>
                            <span class="summary-label">Total Contribuciones</span>
                        </div>
                    </div>

                    <!-- Ranking de contribuidores en este proyecto -->
                    <div class="contributors-ranking">
                        <div class="ranking-header">
                            <h4 class="ranking-title">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.5 3.75a.75.75 0 0 1 1.5 0v.5h.5a.75.75 0 0 1 0 1.5h-.5v.5a.75.75 0 0 1-1.5 0v-.5h-.5a.75.75 0 0 1 0-1.5h.5v-.5zM2 7.5a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 7.5zm0 3a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5A.75.75 0 0 1 2 10.5zm8.25-3.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5zm0 3a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5h-1.5z"/>
                                </svg>
                                Ranking de Contribuidores
                            </h4>
                            <small style="color: var(--github-text-secondary);">En este proyecto</small>
                        </div>
                        
                        @php
                            // Ordenar por contribuciones
                            $sortedStats = $estadisticas->sortByDesc(function($stat) {
                                return ($stat['total'] ?? 0) + ($stat['progreso'] ?? 0) + ($stat['listo'] ?? 0) + ($stat['pendientes'] ?? 0);
                            });
                        @endphp

                        @foreach($sortedStats as $index => $stat)
                            @php
                                // Usar total_contribuciones en lugar de la suma manual
                                $totalContributions = $stat['total_contribuciones'];
                                $rank = $index + 1;
                                $rankClass = '';
                                $badgeClass = 'badge-new';
                                
                                if ($rank <= 3) {
                                    $rankClass = 'top-' . $rank;
                                }
                                
                                if ($totalContributions >= 20) {
                                    $badgeClass = 'badge-active';
                                } elseif ($totalContributions >= 10) {
                                    $badgeClass = 'badge-moderate';
                                } elseif ($totalContributions === 0) {
                                    $badgeClass = 'badge-inactive';
                                }
                            @endphp
                                                    
                            <div class="contributor-item" 
                                data-user-id="{{ $stat['usuario']->id }}" 
                                data-user-name="{{ $stat['usuario']->name }}" 
                                data-user-email="{{ $stat['usuario']->email }}"
                                data-user-avatar="{{ $stat['usuario']->photo ? asset('storage/' . $stat['usuario']->photo) : '' }}"
                                data-total-historias="{{ $stat['total_historias'] ?? 0 }}"
                                data-total-tareas="{{ $stat['total_tareas'] ?? 0 }}"
                                data-ready="{{ $stat['listo'] ?? 0 }}"
                                data-progress="{{ $stat['progreso'] ?? 0 }}"
                                data-pending="{{ $stat['pendientes'] ?? 0 }}"
                                data-project-id="{{ $proyecto_actual->id }}"
                                data-project-name="{{ $proyecto_actual->name }}">
                                <div class="contributor-rank {{ $rankClass }}">
                                    {{ $rank }}
                                </div>
                                
                                <div class="contributor-avatar">
                                    @if ($stat['usuario']->photo)
                                        <img src="{{ asset('storage/' . $stat['usuario']->photo) }}" alt="{{ $stat['usuario']->name }}">
                                    @else
                                        <div class="contributor-avatar-placeholder">
                                            {{ strtoupper(substr($stat['usuario']->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="contributor-info">
                                    <h5 class="contributor-name">{{ $stat['usuario']->name }}</h5>
                                    <p class="contributor-email">{{ $stat['usuario']->email }}</p>
                                </div>
                                
                                <div class="contributor-stats">
                                    <div class="contributor-contributions">
                                        {{ $totalContributions }} contribuciones
                                    </div>
                                    <div class="contributor-badge {{ $badgeClass }}">
                                        @if ($totalContributions >= 20)
                                            Muy Activo
                                        @elseif ($totalContributions >= 10)
                                            Activo
                                        @elseif ($totalContributions > 0)
                                            Principiante
                                        @else
                                            Sin Actividad
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Gráfico de contribuciones en este proyecto -->
                    <div class="chart-container">
                        <h4 class="chart-title">Contribuciones en {{ $proyecto_actual->name }}</h4>
                        <div class="chart-wrapper">
                            <canvas id="contributionsChart"></canvas>
                        </div>
                        @if($proyecto_actual && $historial->count())
<div class="historial-section mt-5">
    <h3 class="text-center">🕒 Historial de Cambios Recientes</h3>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historial as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->fecha)->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->usuario }}</td>
                    <td>{{ $item->accion }}</td>
                    <td>{{ $item->detalles }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('usuarios.historial', $proyecto_actual->id) }}" class="btn btn-outline-primary">
            Ver todo el historial
        </a>
    </div>
</div>
@endif

                    </div>
                </div>
                @endif
            @else
                <div class="no-project-message">
                    <h3>No hay proyecto seleccionado</h3>
                    <p>Por favor, selecciona un proyecto para ver las estadísticas.</p>
                    @if(isset($proyectos_usuario) && $proyectos_usuario->count())
                        <div class="project-selector" style="justify-content: center;">
                            <label for="projectSelect">Seleccionar proyecto:</label>
                            <select id="projectSelect" onchange="window.location.href = '/homeuser/' + this.value">
                                <option value="">-- Seleccione --</option>
                                @foreach($proyectos_usuario as $project)
                                    <option value="{{ $project->id }}">
                                        {{ $project->name }} ({{ $project->codigo }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            @endif
        @endauth
    </div>

    <!-- Modal de detalles de contribuciones -->
        <div class="modal-overlay" id="contributorModal">
        <div class="modal-container" style="max-width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">Detalles de Contribuciones</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="contributorModalContent">
                    <!-- Contenido dinámico se insertará aquí -->
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Obtener elementos del DOM
        const modal = document.getElementById('contributorModal');
        const closeModal = document.getElementById('closeModal');
        const modalContent = document.getElementById('contributorModalContent');
        
        // Convertir los datos de PHP a JSON para usar en JavaScript
        const userContributions = @json($user_contributions ?? []);
        
        // Verificar que userContributions tiene datos
        console.log('Datos de contribuciones:', userContributions);
        
        // Función para renderizar el contenido del modal
        function renderModalContent(userData) {
            if (!userData || !userData.user) {
                return `
                    <div class="alert alert-warning">
                        No se encontraron datos para este usuario.
                    </div>
                `;
            }
            
            // Construir avatar
            let avatarHtml = userData.user.photo 
                ? `<img src="${userData.user.photo}" alt="${userData.user.name}" class="user-avatar">`
                : `<div class="user-avatar contributor-avatar-placeholder" style="width:80px;height:80px;font-size:2rem;">
                    ${userData.user.name.charAt(0).toUpperCase()}
                </div>`;
            
            // Construir historias
            let storiesHtml = '';
            
            if (userData.stories && userData.stories.length > 0) {
                userData.stories.forEach(story => {
                    let statusClass = 'status-pending';
                    let statusText = 'Pendiente';
                    
                    if (story.columna && story.columna.nombre === 'En progreso') {
                        statusClass = 'status-progress';
                        statusText = 'En progreso';
                    } else if (story.columna && story.columna.nombre === 'Listo') {
                        statusClass = 'status-ready';
                        statusText = 'Listo';
                    }
                    
                    // Construir tareas - SIMPLIFICADO CON ACORDEÓN
                    let tasksHtml = '';
                    let taskCount = 0;
                    
                    if (story.tareas && story.tareas.length > 0) {
                        story.tareas.forEach(task => {
                            // Verificar si task.user existe antes de acceder a sus propiedades
                            if (!task.user) {
                                console.warn('Tarea sin usuario asignado:', task);
                                tasksHtml += `<li>${task.nombre}</li>`;
                                taskCount++;
                                return; // Salir de esta iteración
                            }
                            
                            tasksHtml += `<li>${task.nombre}</li>`;
                            taskCount++;
                        });
                    } else {
                        tasksHtml = `<li>No hay tareas asignadas</li>`;
                        taskCount = 0;
                    }
                    
                    const accordionId = `accordion-${story.id}`;
                    
                    storiesHtml += `
                        <div class="story-item">
                            <div class="story-header">
                                <a href="/historas/${story.id}/show" class="story-title">${story.nombre}</a>
                                <span class="story-status ${statusClass}">${statusText}</span>
                            </div>
                            <p class="story-description">${story.descripcion || 'Sin descripción'}</p>
                            
                            <div class="tasks-accordion">
                                <button class="accordion-toggle" type="button" data-target="#${accordionId}" onclick="toggleAccordion('${accordionId}')">
                                    <span>Tareas</span>
                                    <div class="task-counter">
                                        <span class="counter-badge">${taskCount}</span>
                                        <svg class="chevron-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </button>
                                <div id="${accordionId}" class="accordion-content">
                                    <ul class="tasks-list">
                                        ${tasksHtml}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                storiesHtml = `<p class="no-stories">No hay historias asignadas</p>`;
            }
            
            return `
                <div class="user-details-header">
                    ${avatarHtml}
                    <div class="user-info gap-3">
                        <h3 class="user-name">${userData.user.name}</h3>
                        <p class="user-email">${userData.user.email}</p>
                    </div>
                </div>
                
                <div class="stories-container">
                    <h4 class="section-title">Historias Asignadas</h4>
                    ${storiesHtml}
                </div>
            `;
        }
        
        // Manejador de eventos para los items de contribuidores
        document.addEventListener('click', function(e) {
            const contributorItem = e.target.closest('.contributor-item');
            if (!contributorItem) return;
            
            const userId = contributorItem.getAttribute('data-user-id');
            const projectId = contributorItem.getAttribute('data-project-id');
            
            console.log(`Mostrando contribuciones para usuario ${userId} en proyecto ${projectId}`);
            
            // Mostrar spinner de carga
            modalContent.innerHTML = `
                <div style="display:flex;justify-content:center;align-items:center;height:200px;">
                    <div class="loading-spinner"></div>
                </div>
            `;
            modal.classList.add('active');
            
            // Obtener datos del usuario
            const userData = userContributions[userId];
            console.log('Datos del usuario:', userData);
            
            // Renderizar contenido (con retraso para ver el spinner)
            setTimeout(() => {
                modalContent.innerHTML = renderModalContent(userData);
            }, 300);
        });
        
        // Cerrar modal
        closeModal.addEventListener('click', function() {
            modal.classList.remove('active');
        });
        
        // Cerrar al hacer click fuera del modal
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
        
        // Función para el acordeón
        window.toggleAccordion = function(accordionId) {
            const accordion = document.getElementById(accordionId);
            const button = document.querySelector(`[data-target="#${accordionId}"]`);
            const chevron = button.querySelector('.chevron-icon');
            
            if (accordion.classList.contains('active')) {
                accordion.classList.remove('active');
                chevron.style.transform = 'rotate(0deg)';
            } else {
                accordion.classList.add('active');
                chevron.style.transform = 'rotate(180deg)';
            }
        };
        
        // Inicializar gráfico si existe
        const chartCanvas = document.getElementById('contributionsChart');
        if (chartCanvas && typeof Chart !== 'undefined') {
            initializeChart();
        }
        
        function initializeChart() {
            const ctx = chartCanvas.getContext('2d');
            
            const contributorData = [
                @foreach($estadisticas as $stat)
                    {
                        name: @json($stat['usuario']->name),
                        contributions: {{ $stat['total_contribuciones'] ?? 0 }},
                        avatar: @json($stat['usuario']->photo ? asset('storage/' . $stat['usuario']->photo) : null),
                        email: @json($stat['usuario']->email)
                    },
                @endforeach
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: contributorData.map(user => user.name),
                    datasets: [{
                        label: 'Contribuciones',
                        data: contributorData.map(user => user.contributions),
                        backgroundColor: '#679def',
                        borderColor: '#21262d',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#161b22',
                            titleColor: '#e6edf3',
                            bodyColor: '#e6edf3',
                            borderColor: '#21262d',
                            borderWidth: 1,
                            cornerRadius: 6,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    const user = contributorData[context.dataIndex];
                                    return `${user.contributions} contribuciones`;
                                },
                                afterLabel: function(context) {
                                    const user = contributorData[context.dataIndex];
                                    return user.email;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#7d8590', stepSize: 1 },
                            grid: { color: '#21262d' }
                        },
                        x: {
                            ticks: {
                                color: '#7d8590',
                                maxRotation: 45,
                                minRotation: 0
                            },
                            grid: { display: false }
                        }
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }
    });
    </script>
@stop