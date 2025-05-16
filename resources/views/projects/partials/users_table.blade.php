<div class="users-table-container">
    <table class="table table-hover">
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
                        <input type="checkbox"
                            class="user-checkbox"
                            value="{{ $user->id }}"
                            {{ in_array($user->id, $selectedUsers ?? []) ? 'checked' : '' }}>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

