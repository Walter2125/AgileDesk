@extends('layouts.app')

@section('layouts_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('vendor/fontawesome/all-fixed.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

 <style>
    .user-dropdown .dropdown-menu {
        z-index: 1550 !important; /* Menor que modales pero mayor que navbar */
    }
    
    /* Asegurar z-index correcto para modales si los hay */
    .modal {
        z-index: 1600 !important; /* Mayor que el navbar (z-index: 1400) */
    }

    .modal-backdrop {
        z-index: 1599 !important; /* Justo debajo del modal */
    }
</style>
    @stop

@section('title', 'Miembros del Sistema')

@section('content_header')
    <h1>Miembros del Sistema</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Usuarios</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha de creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->usertype == 'admin' ? 'danger' : 'primary' }}">
                                                {{ $user->usertype }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay usuarios registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('layouts_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Aquí podrías añadir funcionalidades adicionales si lo necesitas
            // Por ejemplo, confirmaciones para eliminar usuarios, filtros, etc.
        });
    </script>
@stop