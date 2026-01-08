@extends('layouts.app')

@section('title', 'Gestión de Administradores')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-people text-primary me-2"></i>Gestión de Administradores
                    </h2>
                    <p class="text-muted mb-0">Administra los usuarios con permisos de administrador</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i>Nuevo Administrador
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-check me-2"></i>Administradores Registrados
                        </h5>
                        <span class="badge bg-primary">{{ $admins->total() }} total</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($admins->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">Usuario</th>
                                        <th>Email</th>
                                        <th>Fecha de Registro</th>
                                        <th class="text-end px-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary text-white me-3">
                                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $admin->name }}</h6>
                                                        @if($admin->id === auth()->id())
                                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                                <i class="bi bi-person-check me-1"></i>Tu cuenta
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $admin->email }}" class="text-decoration-none">
                                                    {{ $admin->email }}
                                                </a>
                                            </td>
                                            <td>
                                                <span title="{{ $admin->created_at->format('d/m/Y H:i') }}">
                                                    {{ $admin->created_at->diffForHumans() }}
                                                </span>
                                            </td>
                                            <td class="text-end px-4">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.users.edit', $admin) }}" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if($admin->id !== auth()->id())
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteModal{{ $admin->id }}"
                                                                title="Eliminar">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($admins->hasPages())
                            <div class="card-footer bg-white">
                                {{ $admins->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people display-4 text-muted"></i>
                            <p class="text-muted mt-3">No hay administradores registrados.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Crear Primer Administrador
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales de eliminación (fuera de la tabla para evitar problemas de renderizado) --}}
@foreach($admins as $admin)
    @if($admin->id !== auth()->id())
    <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $admin->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $admin->id }}">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar al administrador <strong>{{ $admin->name }}</strong>?</p>
                    <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <form action="{{ route('admin.users.destroy', ['user' => $admin->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}
</style>
@endsection
