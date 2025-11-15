@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header con gradiente -->
    <div class="bg-gradient-success rounded-lg shadow-lg p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white font-weight-bold">
                    <i class="fas fa-key mr-2"></i>Gestión de Permisos
                </h1>
                <p class="text-white-50 mb-0 mt-1">Administra los permisos del sistema</p>
            </div>
            <a href="{{ route('admin.configuracion.permisos.create') }}" class="btn btn-light shadow-sm">
                <i class="fas fa-plus mr-1"></i>Nuevo Permiso
            </a>
        </div>
    </div>

    <!-- Mensajes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row mb-4">
        <!-- Estadísticas rápidas -->
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Permisos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissions->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-key fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Módulos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissionsGrouped->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs de visualización -->
    <ul class="nav nav-tabs mb-3" id="permissionTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list" role="tab">
                <i class="fas fa-list mr-2"></i>Vista Lista
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="group-tab" data-toggle="tab" href="#group" role="tab">
                <i class="fas fa-layer-group mr-2"></i>Vista Agrupada
            </a>
        </li>
    </ul>

    <div class="tab-content" id="permissionTabsContent">
        <!-- Vista Lista -->
        <div class="tab-pane fade show active" id="list" role="tabpanel">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Todos los Permisos ({{ $permissions->total() }})
                    </h6>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">#</th>
                                    <th class="border-0 py-3">Nombre del Permiso</th>
                                    <th class="border-0 py-3">Guard</th>
                                    <th class="border-0 py-3 text-center">Roles Asignados</th>
                                    <th class="border-0 py-3">Fecha Creación</th>
                                    <th class="border-0 py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $index => $permission)
                                <tr>
                                    <td class="px-4 align-middle">
                                        <span class="text-muted">{{ $permissions->firstItem() + $index }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-shield-alt text-success mr-2"></i>
                                            <span class="font-weight-bold">{{ $permission->name }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary">{{ $permission->guard_name }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-primary badge-pill px-3 py-2">
                                            {{ $permission->roles->count() }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $permission->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.configuracion.permisos.edit', $permission->id) }}" 
                                               class="btn btn-primary" 
                                               title="Editar"
                                               data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    title="Eliminar"
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $permission->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de confirmación -->
                                <div class="modal fade" id="deleteModal{{ $permission->id }}" tabindex="-1">
                                    <div class="modal-dialog">
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
                                                <p>¿Estás seguro de eliminar el permiso <strong>{{ $permission->name }}</strong>?</p>
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-info-circle mr-2"></i>
                                                    Este permiso está asignado a {{ $permission->roles->count() }} rol(es).
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i>Cancelar
                                                </button>
                                                <form action="{{ route('admin.configuracion.permisos.destroy', $permission->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay permisos registrados</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($permissions->hasPages())
                <div class="card-footer bg-white">
                    {{ $permissions->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Vista Agrupada -->
        <div class="tab-pane fade" id="group" role="tabpanel">
            <div class="accordion" id="permissionsAccordion">
                @foreach($permissionsGrouped as $modulo => $perms)
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-header bg-gradient-primary text-white" id="heading{{ $loop->index }}">
                        <h6 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-white text-decoration-none d-flex justify-content-between align-items-center" 
                                    type="button" 
                                    data-toggle="collapse" 
                                    data-target="#collapse{{ $loop->index }}">
                                <span>
                                    <i class="fas fa-folder-open mr-2"></i>
                                    <strong>{{ ucfirst($modulo) }}</strong>
                                </span>
                                <span class="badge badge-light badge-pill">{{ $perms->count() }} permisos</span>
                            </button>
                        </h6>
                    </div>

                    <div id="collapse{{ $loop->index }}" 
                         class="collapse {{ $loop->first ? 'show' : '' }}" 
                         data-parent="#permissionsAccordion">
                        <div class="card-body">
                            <div class="row">
                                @foreach($perms as $permission)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-success shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="fas fa-key text-success mr-1"></i>
                                                        {{ $permission->name }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-users mr-1"></i>
                                                        {{ $permission->roles->count() }} roles
                                                    </small>
                                                </div>
                                                <div class="btn-group-vertical btn-group-sm">
                                                    <a href="{{ route('admin.configuracion.permisos.edit', $permission->id) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection