@extends('layouts.app')

@section('title', 'Agile Desk')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/estadisticas-proy.css') }}">
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
                    <select id="projectSelect" onchange="window.location.href = '/homeuser/project/' + this.value">
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
                            <span class="summary-number">{{ $historias_en_proceso ?? 0 }}</span>
                            <span class="summary-label">En Proceso</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-number">{{ $historias_terminadas ?? 0 }}</span>
                            <span class="summary-label">Terminadas</span>
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

                    <!-- Gráfico de contribuciones - Solo mostrar si hay más de un colaborador -->
                    @if($estadisticas->count() > 1)
                        <div class="chart-container">
                            <h4 class="chart-title">Contribuciones en {{ $proyecto_actual->name }}</h4>
                            <div class="chart-wrapper">
                                <canvas id="contributionsChart"></canvas>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; margin-top: 1rem;">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; color: #64748b;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h4 style="margin: 0 0 0.5rem 0; color: #64748b;">Proyecto Individual</h4>
                            <p style="margin: 0; color: #9ca3af;">El gráfico de comparación se muestra cuando hay múltiples colaboradores en el proyecto.</p>
                        </div>
                    @endif
                </div>
            @endif
        @else
            <div class="no-project-message">
                <h3>No hay proyecto seleccionado</h3>
                <p>Por favor, selecciona un proyecto para ver las estadísticas.</p>
                @if(isset($proyectos_usuario) && $proyectos_usuario->count())
                    <div class="project-selector" style="justify-content: center;">
                        <label for="projectSelect">Seleccionar proyecto:</label>
                        <select id="projectSelect" onchange="window.location.href = '/homeuser/project/' + this.value">
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
<script src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
<script>
// Inyectar datos del servidor para que el archivo externo pueda acceder a ellos
window.userContributions = @json($user_contributions ?? []);
window.projectId = @json($proyecto_actual->id ?? null);
window.columnasOrdenadas = @json($columnas_ordenadas ?? []);
window.estadisticas = [
    @foreach($estadisticas as $stat)
        {
            usuario: {
                name: @json($stat['usuario']->name),
                email: @json($stat['usuario']->email),
                photo: @json($stat['usuario']->photo ? asset('storage/' . $stat['usuario']->photo) : null)
            },
            total_contribuciones: {{ $stat['total_contribuciones'] ?? 0 }}
        },
    @endforeach
];
</script>
<script src="{{ asset('js/estadisticas-proy.js') }}"></script>
@stop