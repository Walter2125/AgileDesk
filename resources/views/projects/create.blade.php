@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-4">
            <h2 class="mb-4">{{ __('Crear Nuevo Proyecto') }}</h2>

            <form id="projectForm" method="POST" action="{{ route('projects.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">{{ __('Nombre del Proyecto') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>
                    @error('name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="fecha_inicio">{{ __('Fecha de Inicio') }}</label>
                    <input id="fecha_inicio" type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                        name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                    @error('fecha_inicio')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="fecha_fin">{{ __('Fecha de Fin') }}</label>
                    <input id="fecha_fin" type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                        name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                    @error('fecha_fin')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>{{ __('Buscar Usuarios') }}</label>
                    <div class="search-container mb-3">
                        <input type="text" class="form-control" id="userSearch" placeholder="Escribe el nombre de un usuario...">
                        <div id="searchResults" class="mt-2"></div>
                    </div>

                    <div class="selected-users-container mb-3">
                        <h5>Usuarios seleccionados:</h5>
                        <div id="selectedUsersContainer" class="d-flex flex-wrap gap-2"></div>
                    </div>

                    <div class="users-table-container">
                        <table class="table table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    @if ($user->usertype !== 'admin')
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="user-checkbox"
                                                    value="{{ $user->id }}"
                                                    id="user_{{ $user->id }}"
                                                    name="selected_users[]"
                                                    @if(in_array($user->id, old('selected_users', $selectedUsers))) checked @endif>
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('Guardar Proyecto') }}</button>
                    <a href="{{ route('projects.my') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('styles')
<style>
    .search-container {
        position: relative;
    }
    #searchResults {
        position: absolute;
        width: 100%;
        z-index: 1000;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }
    .selected-user {
        display: inline-flex;
        align-items: center;
        background: #0d6efd;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .remove-user {
        cursor: pointer;
        margin-left: 0.5rem;
        background: none;
        border: none;
        color: white;
        font-weight: bold;
    }
    .users-table-container {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Búsqueda en tiempo real
    $('#userSearch').on('input', function() {
        let query = $(this).val().trim();
        
        if (query.length >= 1) {
            $.ajax({
                url: '{{ route("projects.searchUsers") }}',
                type: 'GET',
                data: {query: query},
                success: function(data) {
                    if (data.length > 0) {
                        let html = '<table class="table table-sm"><tbody>';
                        data.forEach(user => {
                            // Verificar si el usuario ya está seleccionado
                            let isChecked = $(`#user_${user.id}`).is(':checked');
                            
                            html += `
                                <tr>
                                    <td>
                                        <input type="checkbox" class="user-checkbox-search" 
                                               value="${user.id}" id="search_user_${user.id}"
                                               ${isChecked ? 'checked' : ''}>
                                    </td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                </tr>
                            `;
                        });
                        html += '</tbody></table>';
                        $('#searchResults').html(html).show();
                    } else {
                        $('#searchResults').html('<div class="p-2">No se encontraron usuarios</div>').show();
                    }
                },
                error: function() {
                    $('#searchResults').html('<div class="p-2">Error en la búsqueda</div>').show();
                }
            });
        } else {
            $('#searchResults').hide();
        }
    });

    // Cerrar resultados al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#userSearch, #searchResults').length) {
            $('#searchResults').hide();
        }
    });

    // Manejar selección desde la búsqueda
    $(document).on('change', '.user-checkbox-search', function() {
        let userId = $(this).val();
        let isChecked = $(this).is(':checked');
        
        // Actualizar checkbox principal
        $(`#user_${userId}`).prop('checked', isChecked);
        
        // Actualizar lista de seleccionados
        updateSelectedUsers();
    });

    // Manejar selección desde la tabla principal
    $(document).on('change', '.user-checkbox', function() {
        updateSelectedUsers();
    });

    // Eliminar usuario seleccionado
    $(document).on('click', '.remove-user', function() {
        let userId = $(this).parent().data('id') || $(this).closest('span').find('input[type="hidden"]').val();
        $(`#user_${userId}`).prop('checked', false);
        updateSelectedUsers();
    });

    // Función para actualizar la lista de usuarios seleccionados
    function updateSelectedUsers() {
        let selectedUsers = [];
        $('.user-checkbox:checked').each(function() {
            selectedUsers.push($(this).val());
        });

        // Actualizar el contenedor de usuarios seleccionados
        let selectedUsersHtml = '';
        $('.user-checkbox:checked').each(function() {
            let userId = $(this).val();
            let userName = $(this).closest('tr').find('td:nth-child(2)').text();
            
            selectedUsersHtml += `
                <span class="badge bg-primary p-2">
                    ${userName}
                    <input type="hidden" name="selected_users[]" value="${userId}">
                    <button type="button" class="btn-close btn-close-white ms-2 remove-user" aria-label="Remove"></button>
                </span>
            `;
        });

        $('#selectedUsersContainer').html(selectedUsersHtml);
    }

    // Inicializar la lista de seleccionados al cargar la página
    updateSelectedUsers();
});
</script>
@endsection
