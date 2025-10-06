@extends('modulos.aspirante.layou')

@section('title', 'Nueva Nota')
@section('page-title', 'Crear Nueva Nota')
@section('notas-active', 'active')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/aspirante/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/aspirante/notas">Mis Notas</a></li>
        <li class="breadcrumb-item active">Nueva Nota</li>
    </ol>
</nav>

<div class="row">
    <!-- Formulario principal -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit text-success"></i>
                    Editor de Nota
                </h5>
            </div>
            <div class="card-body">
                <form id="form-crear-nota">
                    <!-- Título de la nota -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la nota *</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" 
                               placeholder="Escribe un título descriptivo..." required>
                        <div class="form-text">Máximo 100 caracteres</div>
                    </div>

                    <!-- Categoría -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría *</label>
                            <select class="form-select" id="categoria" name="categoria" required>
                                <option value="">Seleccionar categoría</option>
                                <option value="proyecto">📋 Proyecto</option>
                                <option value="reunion">👥 Reunión</option>
                                <option value="capacitacion">🎓 Capacitación</option>
                                <option value="idea">💡 Ideas</option>
                                <option value="personal">👤 Personal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="visibilidad" class="form-label">Visibilidad *</label>
                            <select class="form-select" id="visibilidad" name="visibilidad" required>
                                <option value="privada">🔒 Privada (Solo yo puedo ver)</option>
                                <option value="publica">👁️ Pública (Otros miembros pueden ver)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Etiquetas -->
                    <div class="mb-3">
                        <label for="etiquetas" class="form-label">Etiquetas</label>
                        <input type="text" class="form-control" id="etiquetas" name="etiquetas" 
                               placeholder="Ej: reciclaje, educacion, salud... (separadas por comas)">
                        <div class="form-text">Ayuda a organizar y encontrar tus notas más fácilmente</div>
                    </div>

                    <!-- Contenido de la nota -->
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido *</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="12" 
                                  placeholder="Escribe aquí el contenido de tu nota..." required></textarea>
                        <div class="form-text">Puedes usar texto plano o formato simple</div>
                    </div>

                    <!-- Recordatorio -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="recordatorio" name="recordatorio">
                            <label class="form-check-label" for="recordatorio">
                                Establecer recordatorio
                            </label>
                        </div>
                        <div id="fecha-recordatorio" class="mt-2" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" id="hora" name="hora">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-outline-secondary" onclick="limpiarFormulario()">
                                <i class="fas fa-eraser"></i>
                                Limpiar
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-primary me-2" onclick="guardarBorrador()">
                                <i class="fas fa-save"></i>
                                Guardar Borrador
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i>
                                Crear Nota
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel lateral con ayuda -->
    <div class="col-md-4">
        <!-- Vista previa -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-eye text-info"></i>
                    Vista Previa
                </h6>
            </div>
            <div class="card-body">
                <div id="preview-titulo" class="h6 text-muted">Título aparecerá aquí...</div>
                <div id="preview-categoria" class="mb-2">
                    <span class="badge bg-secondary">Sin categoría</span>
                </div>
                <div id="preview-contenido" class="text-muted">
                    El contenido de la nota aparecerá aquí mientras escribes...
                </div>
                <hr>
                <div id="preview-etiquetas" class="mb-2"></div>
                <small class="text-muted">
                    <i class="fas fa-calendar"></i> 
                    <span id="preview-fecha">16 de Septiembre, 2025</span>
                </small>
            </div>
        </div>

        <!-- Guía de categorías -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle text-primary"></i>
                    Guía de Categorías
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <span class="badge bg-success me-2">Proyecto</span>
                    <small>Ideas, avances y reflexiones sobre proyectos</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-primary me-2">Reunión</span>
                    <small>Apuntes y conclusiones de reuniones</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-info me-2">Capacitación</span>
                    <small>Notas de talleres y entrenamientos</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-warning me-2">Ideas</span>
                    <small>Propuestas e innovaciones</small>
                </div>
                <div class="mb-2">
                    <span class="badge bg-secondary me-2">Personal</span>
                    <small>Objetivos y reflexiones personales</small>
                </div>
            </div>
        </div>

        <!-- Consejos de escritura -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb text-warning"></i>
                    Consejos de Escritura
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Usa títulos descriptivos y claros</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Organiza ideas con viñetas o numeración</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Incluye fechas y referencias importantes</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Usa etiquetas para facilitar búsquedas</small>
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <small>Revisa antes de publicar notas públicas</small>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Atajos de teclado -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-keyboard text-secondary"></i>
                    Atajos de Teclado
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <small><kbd>Ctrl</kbd> + <kbd>S</kbd></small>
                    </div>
                    <div class="col-6">
                        <small>Guardar borrador</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small><kbd>Ctrl</kbd> + <kbd>Enter</kbd></small>
                    </div>
                    <div class="col-6">
                        <small>Crear nota</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small><kbd>Esc</kbd></small>
                    </div>
                    <div class="col-6">
                        <small>Limpiar formulario</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Vista previa en tiempo real
document.getElementById('titulo').addEventListener('input', function() {
    const titulo = this.value || 'Título aparecerá aquí...';
    document.getElementById('preview-titulo').textContent = titulo;
});

document.getElementById('categoria').addEventListener('change', function() {
    const categoria = this.value;
    const preview = document.getElementById('preview-categoria');
    
    const colores = {
        'proyecto': 'bg-success',
        'reunion': 'bg-primary', 
        'capacitacion': 'bg-info',
        'idea': 'bg-warning',
        'personal': 'bg-secondary'
    };
    
    const nombres = {
        'proyecto': 'Proyecto',
        'reunion': 'Reunión',
        'capacitacion': 'Capacitación', 
        'idea': 'Ideas',
        'personal': 'Personal'
    };
    
    if (categoria) {
        preview.innerHTML = `<span class="badge ${colores[categoria]}">${nombres[categoria]}</span>`;
    } else {
        preview.innerHTML = '<span class="badge bg-secondary">Sin categoría</span>';
    }
});

document.getElementById('contenido').addEventListener('input', function() {
    const contenido = this.value || 'El contenido de la nota aparecerá aquí mientras escribes...';
    const preview = document.getElementById('preview-contenido');
    preview.textContent = contenido.substring(0, 150) + (contenido.length > 150 ? '...' : '');
});

document.getElementById('etiquetas').addEventListener('input', function() {
    const etiquetas = this.value;
    const preview = document.getElementById('preview-etiquetas');
    
    if (etiquetas.trim()) {
        const tags = etiquetas.split(',').map(tag => tag.trim()).filter(tag => tag);
        const tagHTML = tags.map(tag => `<span class="badge bg-light text-dark me-1">#${tag}</span>`).join('');
        preview.innerHTML = tagHTML;
    } else {
        preview.innerHTML = '';
    }
});

// Mostrar/ocultar fecha de recordatorio
document.getElementById('recordatorio').addEventListener('change', function() {
    const fechaDiv = document.getElementById('fecha-recordatorio');
    fechaDiv.style.display = this.checked ? 'block' : 'none';
});

// Funciones auxiliares
function limpiarFormulario() {
    if (confirm('¿Estás seguro de que quieres limpiar el formulario?')) {
        document.getElementById('form-crear-nota').reset();
        // Limpiar vista previa
        document.getElementById('preview-titulo').textContent = 'Título aparecerá aquí...';
        document.getElementById('preview-categoria').innerHTML = '<span class="badge bg-secondary">Sin categoría</span>';
        document.getElementById('preview-contenido').textContent = 'El contenido de la nota aparecerá aquí mientras escribes...';
        document.getElementById('preview-etiquetas').innerHTML = '';
        document.getElementById('fecha-recordatorio').style.display = 'none';
    }
}

function guardarBorrador() {
    // Simular guardado de borrador
    const titulo = document.getElementById('titulo').value;
    if (titulo.trim()) {
        alert('Borrador guardado: "' + titulo + '"');
    } else {
        alert('Agrega un título para guardar el borrador');
    }
}

// Envío del formulario
document.getElementById('form-crear-nota').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const titulo = document.getElementById('titulo').value;
    const categoria = document.getElementById('categoria').value;
    const contenido = document.getElementById('contenido').value;
    
    if (titulo && categoria && contenido) {
        alert('¡Nota creada exitosamente!\n\nTítulo: ' + titulo + '\nCategoría: ' + categoria);
        // Aquí redirigiría a la lista de notas
        // window.location.href = '/aspirante/notas';
    } else {
        alert('Por favor completa todos los campos obligatorios');
    }
});

// Atajos de teclado
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        guardarBorrador();
    }
    
    if (e.ctrlKey && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('form-crear-nota').dispatchEvent(new Event('submit'));
    }
    
    if (e.key === 'Escape') {
        limpiarFormulario();
    }
});
</script>
@endsection