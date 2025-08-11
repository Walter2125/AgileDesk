@extends('layouts.app')

@section('title','Lista de Historias')

@section('mensaje-superior')
    Lista de Historias
@endsection

@section('styles')
<style>
    body {
        background-color: #ffffff;
        color: #000000;
        font-family: 'Segoe UI', sans-serif;
    }

    .container-fluid {
        background-color: #ffffff;
        color: #000000;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }

    .table {
        background-color: #ffffff;
        color: #000000;
    }

    .table th,
    .table td {
        background-color: #ffffff;
        color: #000000;
        border-color: #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        color: #000000;
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004b9a;
        color: #ffffff;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        color: #ffffff;
    }

    .modal-content {
        background-color: #ffffff;
        color: #000000;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .btn-outline-info {
        color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000000;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #ffffff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #ffffff;
    }

    .btn-secondary:hover {
        background-color: #545b62;
        border-color: #4e555b;
        color: #ffffff;
    }
</style>
@endsection
        
@section('content')

   

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Lista de Historias</h1>
            <a href="{{ route('historias.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Crear Historia
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historias as $historia)
                        <tr>
                            <th scope="row">{{ $historia->id }}</th>
                            <td>{{ $historia->nombre }}</td>
                            <td>{{ $historia->descripcion }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('historias.show', $historia->id) }}" class="btn btn-outline-info btn-sm" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('historias.edit', $historia->id) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $historia->id }}" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($historias as $historia)
        <!-- Modal -->
        <div class="modal fade" id="confirmDeleteModal{{ $historia->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $historia->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel{{ $historia->id }}">¿Desea eliminar esta historia?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        Se eliminará la historia "<strong>{{ $historia->nombre }}</strong>"<br>
                        Esta acción no se puede deshacer.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

