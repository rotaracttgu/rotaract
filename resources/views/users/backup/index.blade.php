@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- ⭐ NUEVO: Contenedor para alertas dinámicas --}}
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Sistema de Respaldo</h1>
        </div>
    </div>

    {{-- Mensajes de alerta --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Panel Estado del Último Respaldo -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-database"></i> Respaldo del Sistema
                    </h5>
                    <small>Gestiona y ejecuta las copias de seguridad de la base de datos</small>
                </div>
                <div class="card-body">
                    <h6>Estado del Último Respaldo</h6>
                    @if($ultimoBackup)
                        <div class="alert alert-info">
                            <strong>Fecha:</strong> {{ $ultimoBackup->fecha_ejecucion->format('Y-m-d H:i') }}<br>
                            <strong>Estado:</strong> 
                            @if($ultimoBackup->estado == 'completado')
                                <span class="badge bg-success">Completado con éxito</span>
                            @else
                                <span class="badge bg-danger">Falló</span>
                            @endif
                            <br>
                            <strong>Archivo:</strong> {{ $ultimoBackup->nombre_archivo }}<br>
                            @if($ultimoBackup->tamaño)
                                <strong>Tamaño:</strong> {{ $ultimoBackup->tamaño }}
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning">
                            No hay respaldos anteriores
                        </div>
                    @endif
                    
                    <button type="button" class="btn btn-success btn-lg w-100" id="btnEjecutarBackup">
                        <i class="fas fa-play"></i> Ejecutar Respaldo Ahora
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Configuración de Respaldo Automático -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog"></i> Configuración de Respaldo Automático
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formConfiguracion">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Frecuencia:</label>
                            <select class="form-control" name="frecuencia" id="frecuencia">
                                <option value="diario">Diario</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Hora Programada:</label>
                            <input type="time" class="form-control" name="hora_programada" value="02:00">
                        </div>
                        
                        <div class="mb-3" id="dia_mes_group" style="display: none;">
                            <label class="form-label">Día del Mes:</label>
                            <input type="number" class="form-control" name="dia_mes" min="1" max="31" value="1">
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="activo" id="activo">
                            <label class="form-check-label" for="activo">
                                Activar respaldo automático
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Guardar Configuración
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Respaldos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Historial de Respaldos
                    </h5>
                </div>
                <div class="card-body">
                    @if($historial->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Archivo</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Tamaño</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historial as $backup)
                                    <tr>
                                        <td>{{ $backup->id }}</td>
                                        <td>{{ $backup->fecha_ejecucion->format('Y-m-d H:i') }}</td>
                                        <td>{{ $backup->nombre_archivo ?: 'Sin archivo' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $backup->tipo == 'manual' ? 'info' : 'primary' }}">
                                                {{ ucfirst($backup->tipo) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($backup->estado == 'completado')
                                                <span class="badge bg-success">Completado</span>
                                            @elseif($backup->estado == 'en_proceso')
                                                <span class="badge bg-warning">En proceso</span>
                                            @else
                                                <span class="badge bg-danger">Fallido</span>
                                            @endif
                                        </td>
                                        <td>{{ $backup->tamaño ?? 'N/A' }}</td>
                                        <td>{{ $backup->user ? $backup->user->name : 'Sistema' }}</td>
                                        <td>
                                            @if($backup->estado == 'completado' && $backup->nombre_archivo)
                                                <a href="{{ route('admin.backup.descargar', $backup->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger btn-eliminar" 
                                                        data-id="{{ $backup->id }}"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $historial->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No hay respaldos registrados aún. Haz clic en "Ejecutar Respaldo Ahora" para crear el primero.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ⭐ FUNCIÓN para mostrar alertas visuales
    function mostrarAlerta(mensaje, tipo = 'success') {
        const alertContainer = document.getElementById('alertContainer');
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show`;
        alertDiv.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alertDiv);
        
        // Auto-cerrar después de 5 segundos
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // ⭐ BOTÓN EJECUTAR BACKUP - MEJORADO
    document.getElementById('btnEjecutarBackup').addEventListener('click', function() {
        if (!confirm('¿Estás seguro de ejecutar un respaldo ahora?')) return;
        
        const btn = this;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ejecutando respaldo...';
        
        console.log('🔄 Iniciando backup...');
        
        fetch('{{ route("admin.backup.ejecutar") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                descripcion: 'Backup manual ejecutado desde el panel'
            })
        })
        .then(response => {
            console.log('📡 Estado de respuesta:', response.status);
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('📦 Datos recibidos:', data);
            
            if (data.success) {
                mostrarAlerta('✅ Respaldo ejecutado exitosamente.<br>Archivo: ' + data.data.nombre_archivo, 'success');
                setTimeout(() => location.reload(), 2000);
            } else {
                mostrarAlerta('❌ Error: ' + (data.message || 'Error desconocido'), 'danger');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('❌ Error completo:', error);
            mostrarAlerta('❌ Error al ejecutar el respaldo: ' + error.message + '<br>Revisa la consola (F12) para más detalles.', 'danger');
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });

    // ⭐ CONFIGURACIÓN AUTOMÁTICA - MEJORADO
    document.getElementById('formConfiguracion').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            if (key !== '_token') {
                data[key] = value;
            }
        });
        
        data.activo = document.getElementById('activo').checked ? 1 : 0;
        
        console.log('⚙️ Guardando configuración...', data);
        
        fetch('{{ route("admin.backup.configuracion") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            console.log('✅ Respuesta configuración:', data);
            if (data.success) {
                mostrarAlerta('✅ Configuración guardada exitosamente', 'success');
            } else {
                mostrarAlerta('❌ Error al guardar la configuración', 'danger');
            }
        })
        .catch(error => {
            console.error('❌ Error:', error);
            mostrarAlerta('❌ Error al guardar la configuración: ' + error.message, 'danger');
        });
    });

    // ⭐ BOTONES ELIMINAR - MEJORADO
    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('¿Estás seguro de eliminar este respaldo?')) return;
            
            const id = this.dataset.id;
            
            console.log('🗑️ Eliminando backup ID:', id);
            
            fetch(`{{ url('/admin/backup/eliminar') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('✅ Respuesta eliminar:', data);
                if (data.success) {
                    mostrarAlerta('✅ Respaldo eliminado exitosamente', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    mostrarAlerta('❌ Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                mostrarAlerta('❌ Error al eliminar el respaldo: ' + error.message, 'danger');
            });
        });
    });

    // Mostrar/ocultar campo día del mes
    document.getElementById('frecuencia').addEventListener('change', function() {
        const diaMesGroup = document.getElementById('dia_mes_group');
        diaMesGroup.style.display = this.value === 'mensual' ? 'block' : 'none';
    });
});
</script>
@endsection