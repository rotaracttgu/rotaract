@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- ⭐ NUEVO: Contenedor para alertas dinámicas --}}
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;"></div>

    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-3xl font-bold bg-gradient-to-r from-teal-300 to-blue-400 bg-clip-text text-transparent">
                Sistema de Respaldo
            </h1>
        </div>
    </div>

    {{-- Mensajes de alerta --}}
    @if(session('error'))
        <div class="alert alert-danger bg-red-900/50 text-red-200 p-4 rounded-xl shadow-md mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success bg-emerald-900/50 text-emerald-200 p-4 rounded-xl shadow-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Panel Estado del Último Respaldo -->
        <div class="col-md-6">
            <div class="card bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-700/50">
                <div class="card-header bg-gradient-to-br from-emerald-600 to-teal-700 text-white p-4 rounded-t-2xl">
                    <h5 class="mb-0 text-lg font-bold flex items-center">
                        <i class="fas fa-database mr-2"></i> Respaldo del Sistema
                    </h5>
                    <small class="text-sm text-emerald-200">Gestiona y ejecuta las copias de seguridad de la base de datos</small>
                </div>
                <div class="card-body p-6">
                    <h6 class="text-md font-semibold text-gray-200 mb-3">Estado del Último Respaldo</h6>
                    @if($ultimoBackup)
                        <div class="alert alert-info bg-blue-900/50 text-blue-200 p-4 rounded-xl shadow-md mb-4">
                            <strong class="text-blue-100">Fecha:</strong> {{ $ultimoBackup->fecha_ejecucion->format('Y-m-d H:i') }}<br>
                            <strong class="text-blue-100">Estado:</strong> 
                            @if($ultimoBackup->estado == 'completado')
                                <span class="badge bg-emerald-900/50 text-emerald-200">Completado con éxito</span>
                            @else
                                <span class="badge bg-red-900/50 text-red-200">Falló</span>
                            @endif
                            <br>
                            <strong class="text-blue-100">Archivo:</strong> {{ $ultimoBackup->nombre_archivo }}<br>
                            @if($ultimoBackup->tamaño)
                                <strong class="text-blue-100">Tamaño:</strong> {{ $ultimoBackup->tamaño }}
                            @endif
                        </div>
                    @else
                        <div class="alert alert-warning bg-amber-900/50 text-amber-200 p-4 rounded-xl shadow-md mb-4">
                            No hay respaldos anteriores
                        </div>
                    @endif
                    
                    <button type="button" class="btn btn-success btn-lg w-100 bg-gradient-to-r from-emerald-600 to-teal-700 text-white hover:from-emerald-700 hover:to-teal-800 rounded-xl shadow-md transition-all duration-200" id="btnEjecutarBackup">
                        <i class="fas fa-play mr-2"></i> Ejecutar Respaldo Ahora
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Configuración de Respaldo Automático -->
        <div class="col-md-6">
            <div class="card bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-700/50">
                <div class="card-header bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-4 rounded-t-2xl">
                    <h5 class="mb-0 text-lg font-bold flex items-center">
                        <i class="fas fa-cog mr-2"></i> Configuración de Respaldo Automático
                    </h5>
                </div>
                <div class="card-body p-6">
                    <form id="formConfiguracion">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-gray-200">Frecuencia:</label>
                            <select class="form-control bg-gray-700 text-white border-gray-600 rounded-xl p-2 w-full" name="frecuencia" id="frecuencia">
                                <option value="diario">Diario</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label text-gray-200">Hora Programada:</label>
                            <input type="time" class="form-control bg-gray-700 text-white border-gray-600 rounded-xl p-2 w-full" name="hora_programada" value="02:00">
                        </div>
                        
                        <div class="mb-4" id="dia_mes_group" style="display: none;">
                            <label class="form-label text-gray-200">Día del Mes:</label>
                            <input type="number" class="form-control bg-gray-700 text-white border-gray-600 rounded-xl p-2 w-full" name="dia_mes" min="1" max="31" value="1">
                        </div>
                        
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input bg-gray-700 border-gray-600 text-emerald-600" name="activo" id="activo">
                            <label class="form-check-label text-gray-200" for="activo">
                                Activar respaldo automático
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 bg-gradient-to-r from-blue-600 to-indigo-700 text-white hover:from-blue-700 hover:to-indigo-800 rounded-xl shadow-md transition-all duration-200">
                            <i class="fas fa-save mr-2"></i> Guardar Configuración
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de Respaldos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-700/50">
                <div class="card-header bg-gray-900 p-4 rounded-t-2xl">
                    <h5 class="mb-0 text-lg font-bold text-gray-100 flex items-center">
                        <i class="fas fa-history mr-2"></i> Historial de Respaldos
                    </h5>
                </div>
                <div class="card-body p-6">
                    @if($historial->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped text-gray-200">
                                <thead class="bg-gray-900">
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
                                <tbody class="bg-gray-800">
                                    @foreach($historial as $backup)
                                    <tr class="hover:bg-gray-700/50 transition-all duration-200">
                                        <td>{{ $backup->id }}</td>
                                        <td>{{ $backup->fecha_ejecucion->format('Y-m-d H:i') }}</td>
                                        <td>{{ $backup->nombre_archivo ?: 'Sin archivo' }}</td>
                                        <td>
                                            <span class="badge {{ $backup->tipo == 'manual' ? 'bg-blue-900/50 text-blue-200' : 'bg-indigo-900/50 text-indigo-200' }} p-2 rounded-full">
                                                {{ ucfirst($backup->tipo) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($backup->estado == 'completado')
                                                <span class="badge bg-emerald-900/50 text-emerald-200 p-2 rounded-full">Completado</span>
                                            @elseif($backup->estado == 'en_proceso')
                                                <span class="badge bg-amber-900/50 text-amber-200 p-2 rounded-full">En proceso</span>
                                            @else
                                                <span class="badge bg-red-900/50 text-red-200 p-2 rounded-full">Fallido</span>
                                            @endif
                                        </td>
                                        <td>{{ $backup->tamaño ?? 'N/A' }}</td>
                                        <td>{{ $backup->user ? $backup->user->name : 'Sistema' }}</td>
                                        <td>
                                            @if($backup->estado == 'completado' && $backup->nombre_archivo)
                                                <!-- Botón Descargar -->
                                                <a href="{{ route('admin.backup.descargar', $backup->id) }}" 
                                                   class="btn btn-sm bg-gradient-to-r from-blue-600 to-indigo-700 text-white hover:from-blue-700 hover:to-indigo-800 rounded-full shadow-md transition-all duration-200" 
                                                   title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                
                                                <!-- Botón Restaurar -->
                                                <button type="button" 
                                                        class="btn btn-sm bg-gradient-to-r from-green-600 to-emerald-700 text-white hover:from-green-700 hover:to-emerald-800 rounded-full shadow-md transition-all duration-200 btn-restaurar" 
                                                        data-id="{{ $backup->id }}"
                                                        data-nombre="{{ $backup->nombre_archivo }}"
                                                        title="Restaurar">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                                
                                                <!-- Botón Eliminar -->
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger bg-gradient-to-r from-red-600 to-pink-700 text-white hover:from-red-700 hover:to-pink-800 rounded-full shadow-md transition-all duration-200 btn-eliminar" 
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
                        <div class="alert alert-info bg-blue-900/50 text-blue-200 p-4 rounded-xl shadow-md mb-4 text-center">
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
        alertDiv.className = `alert alert-${tipo} alert-dismissible fade show bg-${tipo === 'success' ? 'emerald-900/50' : 'red-900/50'} text-${tipo === 'success' ? 'emerald-200' : 'red-200'} p-4 rounded-xl shadow-md`;
        alertDiv.style.boxShadow = '0 4px 6px rgba(0,0,0,0.3)';
        alertDiv.innerHTML = `
            ${mensaje}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
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

 // ⭐ BOTONES RESTAURAR - CORREGIDO
document.querySelectorAll('.btn-restaurar').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const nombreArchivo = this.dataset.nombre;
        
        // Confirmación con advertencia seria
        if (!confirm(`⚠️ ADVERTENCIA IMPORTANTE ⚠️\n\n¿Estás ABSOLUTAMENTE SEGURO de restaurar este backup?\n\n"${nombreArchivo}"\n\n🔴 ESTA ACCIÓN:\n✓ Eliminará TODOS los datos actuales de la base de datos\n✓ Los reemplazará con los datos del backup seleccionado\n✓ NO SE PUEDE DESHACER\n\n¿Deseas continuar?`)) {
            return;
        }
        
        // Segunda confirmación
        if (!confirm('🔴 ÚLTIMA CONFIRMACIÓN\n\nEsto BORRARÁ todos los datos actuales.\n¿Estás 100% seguro?')) {
            return;
        }
        
        const btnOriginal = this;
        const originalText = btnOriginal.innerHTML;
        btnOriginal.disabled = true;
        btnOriginal.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        console.log('🔄 Restaurando backup ID:', id);
        
        fetch(`{{ url('admin/users/backup/restaurar') }}/${id}`, {  // ⭐ LÍNEA CORREGIDA
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('✅ Respuesta restaurar:', data);
            if (data.success) {
                mostrarAlerta('✅ Base de datos restaurada exitosamente. La página se recargará...', 'success');
                setTimeout(() => location.reload(), 2000);
            } else {
                mostrarAlerta('❌ Error: ' + data.message, 'danger');
                btnOriginal.disabled = false;
                btnOriginal.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('❌ Error:', error);
            mostrarAlerta('❌ Error al restaurar el backup: ' + error.message, 'danger');
            btnOriginal.disabled = false;
            btnOriginal.innerHTML = originalText;
        });
    });
});

   // ⭐ BOTONES ELIMINAR - CORREGIDO
document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
    btn.addEventListener('click', function() {
        if (!confirm('¿Estás seguro de eliminar este respaldo?')) return;
        
        const id = this.dataset.id;
        
        console.log('🗑️ Eliminando backup ID:', id);
        
        fetch(`{{ url('admin/users/backup/eliminar') }}/${id}`, {  // ⭐ LÍNEA CORREGIDA
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