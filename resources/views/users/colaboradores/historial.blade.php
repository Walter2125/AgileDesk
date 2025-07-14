@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Historial de Cambios del Proyecto: <strong>{{ $proyecto->nombre }}</strong></h2>

    <table class="table table-bordered mt-4">
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
                    <td colspan="5">No hay cambios registrados en este proyecto.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $historial->links() }}
</div>
@endsection
