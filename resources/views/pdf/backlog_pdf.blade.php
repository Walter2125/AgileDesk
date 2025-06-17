<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backlog del Proyecto: {{ $proyecto->nombre }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .project-info {
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 18px;
            color: #3498db;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .meta {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .story-title {
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .priority-high {
            color: #e74c3c;
            font-weight: bold;
        }
        .priority-medium {
            color: #f39c12;
        }
        .priority-low {
            color: #27ae60;
        }
        .description {
            font-size: 11px;
            color: #555;
            margin-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Backlog del Proyecto</h1>
        <div class="meta">Generado el: {{ $fechaGeneracion }}</div>
    </div>

    <div class="project-info">
        <h2>{{ $proyecto->nombre }}</h2>
        <p>{{ $proyecto->descripcion }}</p>
        
        <!-- Información resumida -->
        <table>
            <tr>
                <th>Total de Historias</th>
                <th>Fecha de Inicio</th>
                <th>Estado</th>
            </tr>
            <tr>
                <td>{{ $historias->count() }}</td>
                <td>{{ $proyecto->created_at ? $proyecto->created_at->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $proyecto->estado }}</td>
            </tr>
        </table>
    </div>    @if($sprintId && $historias->count() > 0 && $historias->first()->sprints)
        <div class="section">
            <h2>Sprint: {{ $historias->first()->sprints->nombre ?? 'N/A' }}</h2>
        </div>
    @endif

    @forelse($historiasPorEstado as $estado => $historiasEstado)
        <div class="section">
            <h2>{{ $estado }}</h2>
            
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%">Código</th>
                        <th style="width: 35%">Historia</th>
                        <th style="width: 10%">Prioridad</th>
                        <th style="width: 8%">Estimación</th>
                        <th style="width: 15%">Responsable</th>
                        <th style="width: 8%">Sprint</th>
                        <th style="width: 16%">Fecha creación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historiasEstado as $historia)
                        <tr>
                            <td>{{ $historia->numero ?? 'N/A' }}</td>
                            <td>
                                <div class="story-title">{{ $historia->nombre }}</div>
                                <div class="description">{{ Str::limit($historia->descripcion, 100) }}</div>
                            </td>
                            <td class="priority-{{ strtolower($historia->prioridad) }}">{{ $historia->prioridad }}</td>
                            <td>{{ $historia->trabajo_estimado ?? 'N/A' }}</td>
                            <td>{{ $historia->usuario->name ?? 'Sin asignar' }}</td>
                            <td>{{ $historia->sprints->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $historia->created_at ? $historia->created_at->format('d/m/Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @empty
        <div class="section">
            <p>No hay historias en el backlog para este proyecto.</p>
        </div>
    @endforelse

    <div class="footer">
        <p>AgileDesk &copy; {{ date('Y') }} - Todos los derechos reservados</p>
        <p>Página 1</p>
    </div>
</body>
</html>
