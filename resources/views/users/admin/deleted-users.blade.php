@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">                    <h4 class="mb-0">
                        <i class="fas fa-trash-restore me-2"></i>
                        Deleted Users
                    </h4>                    <a href="{{ route('homeadmin') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Users
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($deletedUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">                                    <tr>                                        <th><i class="fas fa-user me-1"></i> User</th>
                                        <th><i class="fas fa-envelope me-1"></i> Email</th>
                                        <th><i class="fas fa-tag me-1"></i> Role</th>
                                        <th><i class="fas fa-calendar me-1"></i> Deleted At</th>
                                        <th><i class="fas fa-cogs me-1"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deletedUsers as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-danger rounded-circle">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-muted">{{ $user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($user->usertype) }}
                                                </span>
                                            </td>
                                            <td class="text-muted">
                                                <small>
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $user->deleted_at->format('d/m/Y H:i') }}
                                                    <br>
                                                    <span class="text-info">
                                                        ({{ $user->deleted_at->diffForHumans() }})
                                                    </span>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#restoreUserModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"                                                            title="Restore">>
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#permanentDeleteModal"
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}"
                                                            title="Permanently Delete">>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Paginación -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $deletedUsers->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">                            <div class="empty-state">
                                <i class="fas fa-user-check fa-4x text-success mb-3"></i>                                <h5 class="text-muted">No Data</h5>
                                <p class="text-muted">All users are active</p>
                                <a href="{{ route('homeadmin') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Users
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Restaurar Usuario -->
<div class="modal fade" id="restoreUserModal" tabindex="-1" aria-labelledby="restoreUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            <div class="modal-header bg-success text-white">                <h5 class="modal-title" id="restoreUserModalLabel">
                    <i class="fas fa-undo me-2"></i>
                    Restore User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-check fa-3x text-success"></i>
                </div>                <p class="text-center">
                    Are you sure you want to restore user <strong id="restoreUserName"></strong>?
                </p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    The user will be restored to active status.
                </div>
            </div>
            <div class="modal-footer">                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancel
                </button>
                <form id="restoreUserForm" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-undo me-1"></i>
                        Restore User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Eliminación Permanente -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            <div class="modal-header bg-danger text-white">                <h5 class="modal-title" id="permanentDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Permanent Delete Confirmation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger"></i>
                </div>                <p class="text-center">
                    Are you sure you want to permanently delete user <strong id="permanentDeleteUserName"></strong>?
                </p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
            </div>
            <div class="modal-footer">                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Cancel
                </button>
                <form id="permanentDeleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>
                        Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal de restaurar usuario
    const restoreModal = document.getElementById('restoreUserModal');
    const restoreForm = document.getElementById('restoreUserForm');
    const restoreUserName = document.getElementById('restoreUserName');
    
    restoreModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        
        restoreUserName.textContent = userName;
        restoreForm.action = `/admin/users/${userId}/restore`;
    });
    
    // Modal de eliminación permanente
    const permanentDeleteModal = document.getElementById('permanentDeleteModal');
    const permanentDeleteForm = document.getElementById('permanentDeleteForm');
    const permanentDeleteUserName = document.getElementById('permanentDeleteUserName');
    
    permanentDeleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        
        permanentDeleteUserName.textContent = userName;
        permanentDeleteForm.action = `/admin/users/${userId}/permanent-delete`;
    });
});
</script>
@endpush

<style>
.avatar-sm {
    height: 2.5rem;
    width: 2.5rem;
}

.avatar-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    height: 100%;
    width: 100%;
}

.empty-state {
    padding: 2rem;
}

.table th {
    font-weight: 600;
    border-top: none;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection
