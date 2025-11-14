@extends('modulos.aspirante.layou')

@section('title', 'Nueva Nota')
@section('page-title', 'Crear Nueva Nota')
@section('notas-active', 'active')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('aspirante.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('aspirante.blog-notas') }}">Mis Notas</a></li>
        <li class="breadcrumb-item active">Nueva Nota</li>
    </ol>
</nav>

{{-- Mensajes de éxito o error --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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
                {{-- 👇 AQUÍ ESTÁ EL CAMBIO PRINCIPAL --}}
                <form id="form-crear-nota" action="{{ route('aspirante.notas.guardar') }}" method="POST">
                    @csrf
                    
                    <!-- Título de la nota -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la nota *</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" name="titulo" value="{{ old('titulo') }}"
                               placeholder="Escribe un título descriptivo..." required>
                        <div class="form-text">Máximo 200 caracteres</div>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría *</label>
                            <select class="form-select @error('categoria') is-invalid @enderror" 
                                    id="categoria" name="categoria" required>
                                <option value="">Seleccionar categoría</option>
                                <option value="proyecto" {{ old('categoria') == 'proyecto' ? 'selected' : '' }}>📋 Proyecto</option>
                                <option value="reunion" {{ old('categoria') == 'reunion' ? 'selected' : '' }}>👥 Reunión</option>
                                <option value="estudio" {{ old('categoria') == 'estudio' ? 'selected' : '' }}>🎓 Estudio</option>
                                <option value="trabajo" {{ old('categoria') == 'trabajo' ? 'selected' : '' }}>💼 Trabajo</option>
                                <option value="idea" {{ old('categoria') == 'idea' ? 'selected' : '' }}>💡 Ideas</option>
                                <option value="personal" {{ old('categoria') == 'personal' ? 'selected' : '' }}>👤 Personal</option>
                                <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>📌 Otro</option>
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="visibilidad" class="form-label">Visibilidad *</label>
                            <select class="form-select @error('visibilidad') is-invalid @enderror" 
                                    id="visibilidad" name="visibilidad" required>
                                <option value="privada" {{ old('visibilidad') == 'privada' ? 'selected' : '' }}>🔒 Privada (Solo yo puedo ver)</option>
                                <option value="publica" {{ old('visibilidad') == 'publica' ? 'selected' : '' }}>👁️ Pública (Otros miembros pueden ver)</option>
                            </select>
                            @error('visibilidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Etiquetas -->
                    <div class="mb-3">
                        <label for="etiquetas" class="form-label">Etiquetas</label>
                        <input type="text" class="form-control @error('etiquetas') is-invalid @enderror" 
                               id="etiquetas" name="etiquetas" value="{{ old('etiquetas') }}"
                               placeholder="Ej: reciclaje, educacion, salud... (separadas por comas)">
                        <div class="form-text">Ayuda a organizar y encontrar tus notas más fácilmente</div>
                        @error('etiquetas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contenido de la nota -->
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido *</label>
                        <textarea class="form-control @error('contenido') is-invalid @enderror" 
                                  id="contenido" name="contenido" rows="12" required
                                  placeholder="Escribe aquí el contenido de tu nota...">{{ old('contenido') }}</textarea>
                        <div class="form-text">Puedes usar texto plano o formato simple</div>
                        @error('contenido')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Recordatorio -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tiene-recordatorio" 
                                   {{ old('recordatorio') ? 'checked' : '' }}>
                            <label class="form-check-label" for="tiene-recordatorio">
                                Establecer recordatorio
                            </label>
                        </div>
                        <div id="fecha-recordatorio" class="mt-2" style="display: {{ old('recordatorio') ? 'block' : 'none' }};">
                            <label for="recordatorio" class="form-label">Fecha y hora del recordatorio</label>
                            <input type="datetime-local" class="form-control" id="recordatorio" 
                                   name="recordatorio" value="{{ old('recordatorio') }}">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('aspirante.blog-notas') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Cancelar
                            </a>
                        </div>
                        <div>
                            <button type="reset" class="btn btn-outline-warning me-2">
                                <i class="fas fa-eraser"></i>
                                Limpiar
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
                    <span id="preview-fecha">{{ date('d \d\e F, Y') }}</span>
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
                    <span class="badge bg-info me-2">Estudio</span>
                    <small>Notas de capacitaciones y aprendizaje</small>
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
        'estudio': 'bg-info',
        'trabajo': 'bg-dark',
        'idea': 'bg-warning',
        'personal': 'bg-secondary',
        'otro': 'bg-secondary'
    };
    
    const nombres = {
        'proyecto': 'Proyecto',
        'reunion': 'Reunión',
        'estudio': 'Estudio', 
        'trabajo': 'Trabajo',
        'idea': 'Ideas',
        'personal': 'Personal',
        'otro': 'Otro'
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
document.getElementById('tiene-recordatorio').addEventListener('change', function() {
    const fechaDiv = document.getElementById('fecha-recordatorio');
    fechaDiv.style.display = this.checked ? 'block' : 'none';
});
</script>
@endsection