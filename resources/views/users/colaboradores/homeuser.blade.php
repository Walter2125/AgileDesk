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

/* Hero section */
.hero-section {
    background: var(--primary-gradient);
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
    inset: 0;
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

/* Sección de estadísticas */
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

/* Selector de proyecto */
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

.no-project-message {
    background: white;
    padding: 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    margin: 2rem 0;
    box-shadow: var(--shadow-sm);
}

/* Resumen general */
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
    animation: fadeInUp 0.5s ease-out;
}

.contributor-item:last-child {
    border-bottom: none;
}

.contributor-item:hover {
    background: rgba(255,255,255,0.03);
}

.contributor-item:nth-child(2) { animation-delay: 0.1s; }
.contributor-item:nth-child(3) { animation-delay: 0.2s; }
.contributor-item:nth-child(4) { animation-delay: 0.3s; }
.contributor-item:nth-child(5) { animation-delay: 0.4s; }

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

/* Modal styles - Optimizado para centrado perfecto */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    padding: 20px;
    box-sizing: border-box;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: var(--border-radius);
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
}

.modal-header {
    padding: 2rem 2rem 1rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: var(--github-text);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-close {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    cursor: pointer;
    color: var(--github-text-secondary);
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #e2e8f0;
    color: var(--github-text);
    transform: scale(1.05);
}

.modal-body {
    padding: 2rem;
    max-height: calc(90vh - 120px);
    overflow-y: auto;
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

/* Modal mejorado */
.user-details-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.user-info {
    flex: 1;
}

.user-name {
    font-size: 1.75rem;
    margin: 0 0 0.5rem 0;
    color: #1e293b;
    font-weight: 700;
}

.user-email {
    color: #64748b;
    margin: 0;
    font-size: 1rem;
}

.stories-container {
    margin-top: 2rem;
}

.story-item {
    background: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.story-item:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.story-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    gap: 1rem;
}

.story-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #0ea5e9;
    margin: 0;
    text-decoration: none;
    transition: color 0.2s ease;
    flex: 1;
}

.story-title:hover {
    color: #0284c7;
    text-decoration: underline;
}

.story-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.story-description {
    color: #64748b;
    margin-bottom: 1.5rem;
    line-height: 1.6;
    font-size: 0.95rem;
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

.accordion-content .tasks-list {
    margin: 0;
    padding: 1rem;
}

.accordion-content .tasks-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.accordion-content .tasks-list li:last-child {
    border-bottom: none;
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

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

/* Responsive design - MEJORADO */
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
    
    /* Modal responsive */
    .modal-overlay {
        padding: 10px;
    }
    
    .modal-container {
        max-width: 100%;
        width: 100%;
        max-height: 95vh;
    }
    
    .modal-header {
        padding: 1.5rem 1rem;
    }
    
    .modal-title {
        font-size: 1.25rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .user-details-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .user-details-header > div:last-child {
        grid-template-columns: repeat(2, 1fr);
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
        width: 100%;
        max-height: 100vh;
        border-radius: 0;
    }
    
    .modal-header {
        padding: 1rem;
    }
    
    .modal-title {
        font-size: 1.1rem;
    }
    
    .user-details-header > div:last-child {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .story-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .story-status {
        align-self: flex-end;
    }
}
    </style>
@stop

@section('content')
    <div class="main-container">
        <h1 style="font-size:2.2rem;font-weight:700;margin-bottom:0.7rem;letter-spacing:0.5px;">Agile Desk</h1>
        @auth
@endauth
        
        @auth
            @if(isset($proyecto_actual))
                <!-- Selector de proyecto -->
                <div class="project-selector">
                    <label id="projectSelect-label">Proyecto:</label>
                    <select id="projectSelect" onchange="window.location.href = '/homeuser/' + this.value">
                        @foreach($proyectos_usuario as $project)
                            <option value="{{ $project->id }}" {{ $project->id == $proyecto_actual->id ? 'selected' : '' }}>
                                {{ $project->name }} ({{ $project->codigo }})
                            </option>
                        @endforeach
                    </select>
                    <!-- Botón de historial -->
                    <a href="{{ route('users.colaboradores.historial', $proyecto_actual->id) }}" 
                       class="btn btn-outline-primary me-2">
                         Ver Historial de Cambios
                    </a>
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
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_tareas_proyecto }}</span>
                            <span class="summary-label">Total Tareas</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $total_contribuciones_proyecto }}</span>
                            <span class="summary-label">Total Contribuciones</span>
                        </div>
                    </div>

                    <!-- Ranking de contribuidores -->
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
                        
                        @foreach($estadisticas->sortByDesc(fn($stat) => $stat['total_contribuciones']) as $index => $stat)
                            @php
                                $totalContributions = $stat['total_contribuciones'];
                                $rank = $index + 1;
                                $rankClass = $rank <= 3 ? 'top-' . $rank : '';
                                $badgeClass = match(true) {
                                    $totalContributions >= 20 => 'badge-active',
                                    $totalContributions >= 10 => 'badge-moderate',
                                    $totalContributions === 0 => 'badge-inactive',
                                    default => 'badge-new'
                                };
                                $badgeText = match(true) {
                                    $totalContributions >= 20 => 'Muy Activo',
                                    $totalContributions >= 10 => 'Activo',
                                    $totalContributions > 0 => 'Principiante',
                                    default => 'Sin Actividad'
                                };
                            @endphp
                            
                            <div class="contributor-item" 
                                data-user-id="{{ $stat['usuario']->id }}" 
                                data-project-id="{{ $proyecto_actual->id }}">
                                <div class="contributor-rank {{ $rankClass }}">{{ $rank }}</div>
                                
                                <div class="contributor-avatar">
                                    @if($stat['usuario']->photo)
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
                                        {{ $badgeText }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Gráfico de contribuciones -->
                    <div class="chart-container">
                        <h4 class="chart-title">Contribuciones en {{ $proyecto_actual->name }}</h4>
                        <div class="chart-wrapper">
                            <canvas id="contributionsChart"></canvas>
                        </div>
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

<!-- Modal de detalles de contribuciones - OPTIMIZADO -->
<div class="modal-overlay" id="contributorModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Detalles de Contribuciones
            </h3>
            <button class="modal-close" id="closeModal" aria-label="Cerrar modal">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="contributorModalContent">
                <!-- El contenido se carga dinámicamente aquí -->
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const modal = document.getElementById('contributorModal');
    const closeModal = document.getElementById('closeModal');
    const modalContent = document.getElementById('contributorModalContent');
    
    // Datos del servidor
    const userContributions = @json($user_contributions ?? []);
    const projectId = @json($proyecto_actual->id ?? null);
    
    // Debug inicial
    console.log('=== INICIALIZACIÓN ===');
    console.log('userContributions cargado:', userContributions);
    console.log('Número de usuarios:', Object.keys(userContributions).length);
    console.log('projectId:', projectId);
    console.log('Tipo de userContributions:', typeof userContributions);
    
    // Verificar si está vacío
    if (Object.keys(userContributions).length === 0) {
        console.warn('⚠️ userContributions está vacío - revisar controlador');
    }
    
    // Función para crear el avatar del usuario
    function createUserAvatar(user, size = 80) {
    const baseStyle = `
        width: ${size}px;
        height: ${size}px;
        border-radius: 50%;
        border: 3px solid var(--github-border);
        object-fit: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--github-green);
        color: white;
        font-weight: 700;
        font-size: ${size/2.5}px;
        overflow: hidden;
    `;
    
    if (user.photo) {
        return `
            <div style="${baseStyle}">
                <img src="${user.photo}" 
                     alt="${user.name}" 
                     style="width:100%; height:100%; object-fit:cover;">
            </div>`;
    }
    
    return `
        <div style="${baseStyle}">
            ${user.name.charAt(0).toUpperCase()}
        </div>`;
}
    
    // Función para crear el contenido de tareas con acordeón - MEJORADA
    function createTasksAccordion(story) {
        const accordionId = `accordion-${story.id}`;
        const tasks = story.tareas || [];
        const taskCount = tasks.length;
        const completedTasks = tasks.filter(t => t.completada).length;
        
        let tasksHtml = `
            <li style="text-align: center; padding: 2rem; color: #64748b; font-style: italic;">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 0.5rem; opacity: 0.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div>No hay tareas asignadas para esta historia</div>
            </li>
        `;
        
        if (taskCount > 0) {
            tasksHtml = tasks.map((task, index) => {
                const completedIcon = task.completada 
                    ? '<svg width="16" height="16" fill="#10b981" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                    : '<svg width="16" height="16" fill="#6b7280" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>';
                
                const taskStyle = task.completada 
                    ? 'text-decoration: line-through; color: #9ca3af;'
                    : 'color: #374151;';
                
                const assigneeInfo = task.user 
                    ? `<span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                         ${task.user.photo ? `<img src="${task.user.photo}" alt="${task.user.name}" style="width: 20px; height: 20px; border-radius: 50%; object-fit: cover;">` : `<div style="width: 20px; height: 20px; border-radius: 50%; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">${task.user.name.charAt(0)}</div>`}
                         ${task.user.name}
                       </span>`
                    : '<span style="font-size: 0.875rem; color: #9ca3af;">o</span>';
                
                return `
                    <li style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6; animation: fadeInUp 0.2s ease ${index * 0.05}s both;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1;">
                            ${completedIcon}
                            <span style="${taskStyle} font-weight: 500;">${task.nombre}</span>
                        </div>
                        ${assigneeInfo}
                    </li>
                `;
            }).join('');
        }
        
        const progressPercentage = taskCount > 0 ? Math.round((completedTasks / taskCount) * 100) : 0;
        const progressColor = progressPercentage === 100 ? '#10b981' : progressPercentage > 50 ? '#3b82f6' : '#f59e0b';
        
        return `
            <div class="tasks-accordion" style="margin-top: 1rem;">
                <button class="accordion-toggle" type="button" data-target="#${accordionId}" style="
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 1rem;
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                    cursor: pointer;
                    transition: all 0.2s ease;
                " onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="font-weight: 600; color: #374151;">Tareas</span>
                        ${taskCount > 0 ? `
                        ` : ''}
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="background: ${taskCount > 0 ? '#3b82f6' : '#9ca3af'}; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; min-width: 24px; text-align: center;">
                            ${taskCount}
                        </span>
                        <svg class="chevron-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: transform 0.2s ease;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div id="${accordionId}" class="accordion-content" style="
                    max-height: 0;
                    overflow: hidden;
                    transition: max-height 0.3s ease;
                    border: 1px solid #e2e8f0;
                    border-top: none;
                    border-radius: 0 0 8px 8px;
                    background: white;
                ">
                    <ul style="list-style: none; margin: 0; padding: 1rem;">${tasksHtml}</ul>
                </div>
            </div>
        `;
    }
    
    // Función para crear el contenido del modal - MEJORADA
    function createModalContent(userData) {
        console.log('Datos del usuario:', userData); // Debug
        
        if (!userData || !userData.user) {
            return `
                <div class="alert alert-warning" style="margin: 2rem; padding: 1.5rem; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 8px;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #92400e;">⚠️ Sin datos</h4>
                    <p style="margin: 0; color: #92400e;">No se encontraron datos para este usuario.</p>
                </div>
            `;
        }
        
        const { user, stories = [] } = userData;
        const userAvatar = createUserAvatar(user, 100);
        
        console.log('Historias encontradas:', stories.length); // Debug
        
        // Estadísticas del usuario
        const totalHistorias = stories.length;
        const tareasCompletadas = stories.reduce((total, story) => {
            return total + (story.tareas?.filter(t => t.completada).length || 0);
        }, 0);
        const totalTareas = stories.reduce((total, story) => total + (story.tareas?.length || 0), 0);
        
        // Estadísticas por estado
        const estadoStats = {
            'Pendiente': stories.filter(s => s.columna?.nombre === 'Pendiente').length,
            'En progreso': stories.filter(s => s.columna?.nombre === 'En progreso').length,
            'Listo': stories.filter(s => s.columna?.nombre === 'Listo').length
        };
        
        let storiesHtml = `
            <div style="text-align: center; padding: 3rem; color: #64748b;">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.5;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h4 style="margin: 0 0 0.5rem 0;">No hay historias asignadas</h4>
                <p style="margin: 0;">Este usuario aún no tiene historias asignadas en el proyecto.</p>
            </div>
        `;
        
        if (stories.length > 0) {
            storiesHtml = stories.map((story, index) => {
                const statusMap = {
                    'Pendiente': { class: 'status-pending', text: 'Pendiente', color: '#f59e0b' },
                    'En progreso': { class: 'status-progress', text: 'En progreso', color: '#3b82f6' },
                    'Listo': { class: 'status-ready', text: 'Listo', color: '#10b981' }
                };
                const status = statusMap[story.columna?.nombre] || statusMap['Pendiente'];
                
                return `
                    <div class="story-item" style="animation: fadeInUp 0.3s ease ${index * 0.1}s both;">
                        <div class="story-header">
                            <a href="/historas/${story.id}/show" class="story-title" style="text-decoration: none; color: #0ea5e9; font-size: 1.2rem; font-weight: 600; margin: 0; transition: color 0.2s ease; flex: 1;" onmouseover="this.style.color='#0284c7'; this.style.textDecoration='underline'" onmouseout="this.style.color='#0ea5e9'; this.style.textDecoration='none'">${story.nombre || 'Sin título'}</a>
                            <span class="story-status ${status.class}" style="background: ${status.color}; color: white;">
                                ${status.text}
                            </span>
                        </div>
                        <p class="story-description">${story.descripcion || 'Sin descripción disponible.'}</p>
                        ${createTasksAccordion(story)}
                    </div>
                `;
            }).join('');
        }
        
        return `
            <div class="user-details-header">
                ${userAvatar}
                <div class="user-info gap-3">
                    <h3 class="user-name">${user.name}</h3>
                    <p class="user-email">${user.email}</p>
                    
                    <!-- Estadísticas del usuario -->
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-top: 1rem;">
                        <div style="text-align: center; padding: 1rem; background: #f1f5f9; border-radius: 8px;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #0ea5e9;">${totalHistorias}</div>
                            <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Historias</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; background: #f1f5f9; border-radius: 8px;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #8b5cf6;">${totalTareas}</div>
                            <div style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Tareas</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="stories-container">
                <h4 class="section-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Historias Asignadas (${stories.length})
                </h4>
                ${storiesHtml}
            </div>
        `;
    }
    
    // Función para manejar los acordeones
    function handleAccordionToggle(event) {
        const button = event.target.closest('.accordion-toggle');
        if (!button) return;
        
        const targetId = button.getAttribute('data-target');
        const accordion = document.querySelector(targetId);
        const chevron = button.querySelector('.chevron-icon');
        
        if (!accordion || !chevron) return;
        
        const isActive = accordion.classList.contains('active');
        accordion.classList.toggle('active', !isActive);
        chevron.style.transform = isActive ? 'rotate(0deg)' : 'rotate(180deg)';
    }
    
    // Función para inicializar el gráfico
    function initChart() {
        const canvas = document.getElementById('contributionsChart');
        if (!canvas || typeof Chart === 'undefined') return;
        
        const ctx = canvas.getContext('2d');
        const contributorData = [
            @foreach($estadisticas as $stat)
                {
                    name: @json($stat['usuario']->name),
                    contributions: {{ $stat['total_contribuciones'] ?? 0 }},
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
                            label: (context) => `${contributorData[context.dataIndex].contributions} contribuciones`,
                            afterLabel: (context) => contributorData[context.dataIndex].email
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
                        ticks: { color: '#7d8590', maxRotation: 45, minRotation: 0 },
                        grid: { display: false }
                    }
                },
                animation: { duration: 1000, easing: 'easeOutQuart' }
            }
        });
    }
    
    // Event listeners - MEJORADOS CON MEJOR DEBUGGING
    document.addEventListener('click', function(event) {
        // Manejo del modal de contribuidor
        const contributorItem = event.target.closest('.contributor-item');
        if (contributorItem) {
            event.preventDefault();
            
            const userId = contributorItem.dataset.userId;
            const userData = userContributions[userId];
            
            console.log('=== DEBUG MODAL ===');
            console.log('Usuario seleccionado ID:', userId);
            console.log('userContributions completo:', userContributions);
            console.log('Claves disponibles:', Object.keys(userContributions));
            console.log('Datos del usuario encontrados:', userData);
            console.log('Tipo de userContributions:', typeof userContributions);
            console.log('Es array userContributions:', Array.isArray(userContributions));
            
            // Verificar si los datos existen
            if (!userData) {
                console.error('❌ No se encontraron datos para el usuario:', userId);
                modalContent.innerHTML = `
                    <div style="text-align: center; padding: 3rem;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">❌</div>
                        <h3 style="color: #dc2626; margin-bottom: 1rem;">Error de datos</h3>
                        <p style="color: #6b7280; margin-bottom: 1rem;">No se encontraron datos para el usuario ID: ${userId}</p>
                        <details style="text-align: left; background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                            <summary style="cursor: pointer; font-weight: bold;">Información de debug</summary>
                            <pre style="font-size: 0.875rem; margin-top: 0.5rem; overflow-x: auto;">
Datos disponibles: ${JSON.stringify(Object.keys(userContributions), null, 2)}
userContributions: ${JSON.stringify(userContributions, null, 2)}
                            </pre>
                        </details>
                    </div>
                `;
                modal.classList.add('active');
                return;
            }
            
            // Si hay datos, mostrar loading
            modalContent.innerHTML = `
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 300px; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    <p style="color: #6b7280; margin: 0;">Cargando datos del usuario...</p>
                    <small style="color: #9ca3af;">Usuario: ${userData.user?.name || 'Desconocido'}</small>
                </div>
                <style>
                    @keyframes spin {
                        0% { transform: rotate(0deg); }
                        100% { transform: rotate(360deg); }
                    }
                </style>
            `;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Mostrar contenido real después de un delay más corto
            setTimeout(() => {
                try {
                    const content = createModalContent(userData);
                    modalContent.innerHTML = content;
                    console.log('✅ Modal cargado exitosamente');
                } catch (error) {
                    console.error('❌ Error al crear contenido del modal:', error);
                    modalContent.innerHTML = `
                        <div style="text-align: center; padding: 3rem;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">⚠️</div>
                            <h3 style="color: #dc2626; margin-bottom: 1rem;">Error al cargar</h3>
                            <p style="color: #6b7280;">Error: ${error.message}</p>
                        </div>
                    `;
                }
            }, 300);
            
            return;
        }
        
        // Manejo del acordeón
        const accordionButton = event.target.closest('.accordion-toggle');
        if (accordionButton) {
            event.preventDefault();
            
            const targetId = accordionButton.getAttribute('data-target');
            const accordion = document.querySelector(targetId);
            const chevron = accordionButton.querySelector('.chevron-icon');
            
            if (accordion && chevron) {
                const isActive = accordion.style.maxHeight && accordion.style.maxHeight !== '0px';
                
                if (isActive) {
                    accordion.style.maxHeight = '0px';
                    chevron.style.transform = 'rotate(0deg)';
                } else {
                    accordion.style.maxHeight = accordion.scrollHeight + 'px';
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
            
            return;
        }
    });
    
    // Cerrar modal - MEJORADO
    function closeModalHandler() {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar scroll del body
        
        // Limpiar contenido después de la animación
        setTimeout(() => {
            modalContent.innerHTML = '';
        }, 300);
    }
    
    closeModal.addEventListener('click', closeModalHandler);
    
    // Cerrar modal al hacer clic fuera
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModalHandler();
        }
    });
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModalHandler();
        }
    });
    
    // Inicializar gráfico
    initChart();
});
</script>
@stop