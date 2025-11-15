@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header con gradiente -->
    <div class="bg-gradient-primary rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-user-tag mr-2"></i>Gestión de Roles
                </h1>
                <p class="text-white-50 mb-0 mt-1">Administra los roles y sus permisos del sistema</p>
            </div>
            <a href="{{ route('admin.configuracion.roles.create') }}" class="btn btn-light shadow-sm">
                <i class="fas fa-plus mr-1"></i>Nuevo Rol
            </a>
        </div>
    </div>

    <!-- Mensajes de alerta -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Card principal -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Lista de Roles ({{ $roles->total() }})
                </h6>
                <div class="text-muted">
                    <small>Mostrando {{ $roles->firstItem() ?? 0 }} - {{ $roles->lastItem() ?? 0 }} de {{ $roles->total() }}</small>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">#</th>
                            <th class="border-0 py-3">Rol</th>
                            <th class="border-0 py-3">Guard</th>
                            <th class="border-0 py-3 text-center">Permisos</th>
                            <th class="border-0 py-3 text-center">Usuarios</th>
                            <th class="border-0 py-3">Fecha Creación</th>
                            <th class="border-0 py-3 text-center">Estado</th>
                            <th class="border-0 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                        <tr>
                            <td class="px-4 align-middle">
                                <span class="text-muted">{{ $roles->firstItem() + $index }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-gradient-primary text-white mr-3">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <span class="font-weight-bold text-dark">{{ $role->name }}</span>
                                        @if(in_array($role->name, ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero']))
                                            <span class="badge badge-info badge-sm ml-2">
                                                <i class="fas fa-lock"></i> Sistema
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-secondary">{{ $role->guard_name }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-primary badge-pill px-3 py-2">
                                    {{ $role->permissions->count() }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-success badge-pill px-3 py-2">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $role->created_at->format('d/m/Y') }}
                                </small>
                            </td>
                            <td class="align-middle text-center">
                                @if(in_array($role->name, ['Super Admin', 'Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Aspirante']))
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Activo
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-star"></i> Personalizado
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.configuracion.roles.show', $role->id) }}" 
                                       class="btn btn-info" 
                                       title="Ver detalles"
                                       data-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($role->name !== 'Super Admin')
                                        <a href="{{ route('admin.configuracion.roles.edit', $role->id) }}" 
                                           class="btn btn-primary" 
                                           title="Editar"
                                           data-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        @if(!in_array($role->name, ['Presidente', 'Vicepresidente', 'Tesorero', 'Secretario', 'Vocero', 'Aspirante']))
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    title="Eliminar"
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $role->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    @else
                                        <button class="btn btn-secondary" disabled title="Protegido">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de confirmación de eliminación -->
                        <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>Confirmar Eliminación
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar el rol <strong>{{ $role->name }}</strong>?</p>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Esta acción no se puede deshacer.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i>Cancelar
                                        </button>
                                        <form action="{{ route('admin.configuracion.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash mr-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p class="mb-0">No hay roles registrados</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($roles->hasPages())
        <div class="card-footer bg-white border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $roles->firstItem() ?? 0 }} a {{ $roles->lastItem() ?? 0 }} de {{ $roles->total() }} resultados
                </div>
                {{ $roles->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection