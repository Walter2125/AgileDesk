<div class="users-table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center">Seleccionar</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Email</th>
                <th class="text-center">Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="text-center">
                        <input type="checkbox"
                            class="user-checkbox"
                            value="{{ $user->id }}"
                            {{ in_array($user->id, $selectedUsers) ? 'checked' : '' }}>
                    </td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">
                                                @php
                                                    // Si el usuario está pendiente (no aprobado ni rechazado), mostrar "En proceso"
                                                    if (!$user->is_approved && !$user->is_rejected && $user->usertype !== 'superadmin' && $user->usertype !== 'admin') {
                                                        $roleData = ['label' => 'En proceso', 'class' => 'bg-info text-white'];
                                                    } else {
                                                        $roleData = match($user->usertype) {
                                                            'superadmin' => ['label' => 'Superadministrador', 'class' => 'bg-danger text-white'],
                                                            'admin' => ['label' => 'Administrador', 'class' => 'bg-warning text-dark'],
                                                            'collaborator' => ['label' => 'Colaborador', 'class' => 'bg-primary text-white'],
                                                            default => ['label' => 'Usuario', 'class' => 'bg-secondary text-white']
                                                        };
                                                    }
                                                @endphp
                        <span class="badge {{ $roleData['class'] }}">{{ $roleData['label'] }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>