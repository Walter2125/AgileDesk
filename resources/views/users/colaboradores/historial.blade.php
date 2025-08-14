@extends('layouts.app')
    @section('mensaje-superior')
        Historial de Cambios
    @endsection
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-history me-2"></i>Historial de Cambios del Proyecto: 
                <strong>{{ $project->name }}</strong>
            </h4>
        </div>

        <div class="card-body">
           <form method="GET" action="{{ route('users.colaboradores.historial', ['project' => $project->id]) }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="busqueda" class="form-control" 
               placeholder="Buscar por usuario, acción, detalles o sprint..." 
               value="{{ request('busqueda') }}"
               aria-label="Buscar en historial">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search me-1"></i> Buscar
        </button>
        @if(request('busqueda'))
            <a href="{{ route('users.colaboradores.historial', ['project' => $project->id]) }}" 
               class="btn btn-outline-secondary">
                <i class="fas fa-times me-1"></i> Limpiar
            </a>
        @endif
    </div>
</form>


            @if($historial->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> No hay cambios registrados en este proyecto.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap"><i class="fas fa-calendar-alt me-2"></i>Fecha</th>
                                <th class="text-nowrap"><i class="fas fa-user me-2"></i>Usuario</th>
                                <th class="text-nowrap"><i class="fas fa-bolt me-2"></i>Acción</th>
                                <th><i class="fas fa-info-circle me-2"></i>Detalles</th>
                                <th class="text-nowrap"><i class="fas fa-tasks me-2"></i>Sprint</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historial as $cambio)
                                <tr>
                                    <td class="text-nowrap">
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y') }}
                                        </span>
                                        <small class="text-muted d-block">
                                            {{ \Carbon\Carbon::parse($cambio->fecha)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="d-inline-block rounded-circle bg-primary text-white text-center me-2" 
                                              style="width: 30px; height: 30px; line-height: 30px;">
                                            {{ strtoupper(substr($cambio->usuario, 0, 1)) }}
                                        </span>
                                        {{ $cambio->usuario }}
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'creación' => 'success',
                                                'actualización' => 'warning',
                                                'eliminación' => 'danger',
                                            ][strtolower($cambio->accion)] ?? 'primary';
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ $cambio->accion }}
                                        </span>
                                    </td>
                                    <td class="text-break">{{ $cambio->detalles }}</td>
                                    <td>
                                        @if($cambio->sprint)
                                            <span class="badge bg-info text-dark">
                                                {{ $cambio->sprint }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $historial->links('pagination::bootstrap-5') }}
                </div>
            @endif

            {{-- Botón "Volver" movido aquí --}}
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('homeuser') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('styles')
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 600;
        border-top: none;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .badge {
        font-weight: 500;
        padding: 5px 8px;
    }
</style>
@endsection