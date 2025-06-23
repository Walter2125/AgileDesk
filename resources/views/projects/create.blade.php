@extends('layouts.app')
    @section('mensaje-superior')
        Crear Nuevo Proyecto
    @endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-4">
            <form id="projectForm" method="POST" action="{{ route('projects.store') }}">
                @csrf

                <!-- Nombre -->
                <div class="form-group mb-3">
                    <label for="name">Nombre del Proyecto</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ old('name') }}"
                        required autocomplete="off" autofocus>
                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Descripción -->
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" 
                        class="form-control @error('descripcion') is-invalid @enderror" 
                        name="descripcion" 
                        rows="4">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Fecha Inicio -->
                <div class="form-group mb-3">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input id="fecha_inicio" type="date"
                        class="form-control @error('fecha_inicio') is-invalid @enderror"
                        name="fecha_inicio"
                        value="{{ old('fecha_inicio') }}"
                        required>
                    @error('fecha_inicio')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Fecha Fin -->
                <div class="form-group mb-3">
                    <label for="fecha_fin">Fecha de Finalización</label>
                    <input id="fecha_fin" type="date"
                        class="form-control @error('fecha_fin') is-invalid @enderror"
                        name="fecha_fin"
                        value="{{ old('fecha_fin') }}"
                        required>
                    @error('fecha_fin')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Buscador y tabla -->
                <div class="form-group mb-3">
                    <label>Buscar Usuarios</label>
                    <div class="search-container mb-3">
                        <input type="text" class="form-control" id="userSearch" placeholder="Escribe el nombre de un usuario...">
                        <div id="searchResults" class="mt-2"></div>
                    </div>

                    <div id="usersTableContainer">
                        @include('projects.partials.users_table', [
                            'users' => $users,
                            'selectedUsers' => old('selected_users', [])
                        ])
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>

                <!-- Campo oculto con usuarios seleccionados -->
                @foreach(old('selected_users', []) as $id)
                    <input type="hidden" name="selected_users[]" value="{{ $id }}">
                @endforeach
                <div id="selectedUsersInputs"></div>

                <!-- Botones -->
                <div class="form-group mt-4">
                    <button type="submit" class="inline-block bg-blue-400 border border-blue-300 rounded font-bold text-white text-base px-3 py-2 transition duration-300 ease-in-out hover:no-underline hover:bg-blue-600 mr-3 normal-case">Guardar Proyecto</button>
                    <a href="{{ route('projects.my') }}" class="inline-block border border-gray-500 rounded font-bold text-gray-400 text-base px-3 py-2 transition duration-300 ease-in-out hover:bg-gray-600 hover:no-underline hover:text-white mr-3 normal-case">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .search-container { position: relative; }
    #searchResults {
        position: absolute; width: 100%; z-index: 1000;
        background: #fff; border: 1px solid #ddd; border-radius: 4px;
        max-height: 300px; overflow-y: auto; display: none;
    }
</style>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    // Recuperar datos del sessionStorage si existen
    let selectedUsers = @json(old('selected_users', []));
    let formData = JSON.parse(sessionStorage.getItem('projectFormData')) || {
        name: $('#name').val(),
        descripcion: $('#descripcion').val(),
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_fin: $('#fecha_fin').val()
    };

    // Restaurar valores del formulario
    $('#name').val(formData.name);
    $('#descripcion').val(formData.descripcion);
    $('#fecha_inicio').val(formData.fecha_inicio);
    $('#fecha_fin').val(formData.fecha_fin);

    // Función para guardar el estado actual
    function saveFormState() {
        sessionStorage.setItem('projectFormData', JSON.stringify({
            name: $('#name').val(),
            descripcion: $('#descripcion').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_fin: $('#fecha_fin').val(),
            selectedUsers: selectedUsers
        }));
    }

    // Guardar estado cuando cambien los campos
    $('#name, #descripcion, #fecha_inicio, #fecha_fin').on('change input', saveFormState);

    function applySelections() {
        $('input.user-checkbox, input.user-checkbox-search').each(function() {
            const id = $(this).val();
            $(this).prop('checked', selectedUsers.includes(id));
        });
    }

    function updateHiddenInputs() {
        const container = $('#selectedUsersInputs');
        container.empty();
        selectedUsers.forEach(id => {
            container.append(`<input type="hidden" name="selected_users[]" value="${id}">`);
        });
    }

    $(document).on('change', '.user-checkbox, .user-checkbox-search', function() {
        const id = $(this).val();
        if ($(this).is(':checked')) {
            if (!selectedUsers.includes(id)) selectedUsers.push(id);
        } else {
            selectedUsers = selectedUsers.filter(u => u !== id);
        }
        saveFormState();
        applySelections();
        updateHiddenInputs();
    });

    // AJAX Paginación
    $(document).on('click', '#usersTableContainer .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');

        $.ajax({
            url: url,
            data: {
                selected_users: selectedUsers
            },
            success: function(data) {
                $('#usersTableContainer').html(data.html + data.pagination);
                applySelections();
            },
            error: function() {
                alert('Error cargando la página de usuarios.');
            }
        });
    });



    // Buscador (sin cambios)
    $('#userSearch').on('input', function() {
        const q = $(this).val().trim();
        if (q.length < 1) return $('#searchResults').hide();

        $.getJSON('{{ route("projects.searchUsers") }}', { query: q })
            .done(users => {
                if (!users.length) {
                    return $('#searchResults').html('<div class="p-2">No se encontraron usuarios</div>').show();
                }

                let html = '<table class="table table-sm"><tbody>';
                users.forEach(u => {
                    const checked = selectedUsers.includes(String(u.id)) ? 'checked' : '';
                    html += `
                        <tr>
                            <td>
                                <input type="checkbox"
                                       class="user-checkbox-search"
                                       value="${u.id}"
                                       id="search_user_${u.id}"
                                       ${checked}>
                            </td>
                            <td>${u.name}</td>
                            <td>${u.email}</td>
                        </tr>`;
                });
                $('#searchResults').html(html + '</tbody></table>').show();
            })
            .fail(() => $('#searchResults').html('<div class="p-2">Error en la búsqueda</div>').show());
    });

    $(document).on('click', e => {
        if (!$(e.target).closest('#userSearch, #searchResults').length) {
            $('#searchResults').hide();
        }
    });

    // Limpiar sessionStorage al enviar el formulario
    $('#projectForm').on('submit', function() {
        sessionStorage.removeItem('projectFormData');
    });

    // Inicializar
    applySelections();
    updateHiddenInputs();
});
</script>
@endsection