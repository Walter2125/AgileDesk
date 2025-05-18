@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historial de Cambios</h1>

    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col">
                <input type="text" name="usuario" class="form-control" placeholder="Buscar por usuario" value="{{ request('usuario') }}">
            </div>
            <div class="col">
                <select name="accion" class="form-select">
                    <option value="">-- Acción --</option>
                    <option value="Creación" {{ request('accion') == 'Creación' ? 'selected' : '' }}>Creación</option>
                    <option value="Edición" {{ request('accion') == 'Edición' ? 'selected' : '' }}>Edición</option>
                    <option value="Eliminación" {{ request('accion') == 'Eliminación' ? 'selected' : '' }}>Eliminación</option>
                </select>
            </div>
            <div class="col">
                <input type="text" name="sprint" class="form-control" placeholder="Sprint ID" value="{{ request('sprint') }}">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Detalles</th>
                <th>Sprint</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($historial as $cambio)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($cambio->fecha)->format('Y-m-d H:i') }}</td>
                    <td>{{ $cambio->usuario }}</td>
                    <td>{{ $cambio->accion }}</td>
                    <td>{{ $cambio->detalles }}</td>
                    <td>{{ $cambio->sprint ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No se encontraron registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $historial->withQueryString()->links() }}
</div>
@endsection
