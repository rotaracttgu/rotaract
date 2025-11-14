@extends('modulos.aspirante.layou')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil Personal')
@section('perfil-active', 'active')

@section('content')
<div class="row">
    <!-- Información principal del perfil -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <!-- Foto de perfil -->
                <div class="mb-3">
                    <div class="position-relative d-inline-block">
                        <img src="https://via.placeholder.com/150x150?text=Foto" 
                             class="rounded-circle" width="150" height="150" alt="Foto de perfil">
                        <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                                style="width: 35px; height: 35px;" data-bs-toggle="modal" data-bs-target="#cambiarFotoModal">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Información básica -->
                <h4 class="card-title">Juan Carlos Pérez</h4>
                <p class="text-muted">Aspirante a Rotaractiano</p>
                <span class="badge bg-warning mb-3">Aspirante</span>
                
                <!-- Estadísticas rápidas -->
                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="text-primary">3</h5>
                        <small class="text-muted">Proyectos</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-success">95%</h5>
                        <small class="text-muted">Asistencia</small>
                    </div>
                    <div class="col-4">
                        <h5 class="text-info">24</h5>
                        <small class="text-muted">Notas</small>
                    </div>
                </div>
                
                <hr>
                
                <!-- Información de contacto rápida -->
                <div class="text-start">
                    <p class="mb-1">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        juan.perez@email.com
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-phone text-muted me-2"></i>
                        +504 9999-9999
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-calendar text-muted me-2"></i>
                        Miembro desde: Ago 2025
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Progreso como aspirante -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-line text-success"></i>
                    Progreso como Aspirante
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Participación en Proyectos</label>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 75%">75%</div>
                    </div>
                    <small class="text-muted">3 de 4 proyectos requeridos</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Asistencia a Reuniones</label>
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 95%">95%</div>
                    </div>
                    <small class="text-muted">19 de 20 reuniones</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Capacitaciones Completadas</label>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 80%">80%</div>
                    </div>
                    <small class="text-muted">4 de 5 capacitaciones</small>
                </div>
                
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        Complete todos los requisitos para convertirse en miembro activo
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formularios de edición -->
    <div class="col-md-8">
        <!-- Información personal -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user text-primary"></i>
                    Información Personal
                </h5>
            </div>
            <div class="card-body">
                <form id="form-info-personal">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombres" class="form-label">Nombres *</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" 
                                   value="Juan Carlos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">Apellidos *</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" 
                                   value="Pérez García" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha-nacimiento" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" class="form-control" id="fecha-nacimiento" 
                                   name="fecha_nacimiento" value="1998-05-15" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <select class="form-select" id="genero" name="genero">
                                <option value="masculino" selected>Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro</option>
                                <option value="prefiero-no-decir">Prefiero no decir</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="identidad" class="form-label">Número de Identidad</label>
                            <input type="text" class="form-control" id="identidad" name="identidad" 
                                   value="0801-1998-12345">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado-civil" class="form-label">Estado Civil</label>
                            <select class="form-select" id="estado-civil" name="estado_civil">
                                <option value="soltero" selected>Soltero/a</option>
                                <option value="casado">Casado/a</option>
                                <option value="union-libre">Unión Libre</option>
                                <option value="divorciado">Divorciado/a</option>
                                <option value="viudo">Viudo/a</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Información de contacto -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-address-book text-success"></i>
                    Información de Contacto
                </h5>
            </div>
            <div class="card-body">
                <form id="form-contacto">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="juan.perez@email.com" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                   value="+504 9999-9999" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2">Col. Las Flores, Bloque M, Casa #15, Tegucigalpa, Francisco Morazán</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad" 
                                   value="Tegucigalpa">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select class="form-select" id="departamento" name="departamento">
                                <option value="francisco-morazan" selected>Francisco Morazán</option>
                                <option value="cortes">Cortés</option>
                                <option value="atlantida">Atlántida</option>
                                <option value="choluteca">Choluteca</option>
                                <!-- Más departamentos... -->
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Actualizar Contacto
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Información académica/profesional -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-graduation-cap text-info"></i>
                    Información Académica y Profesional
                </h5>
            </div>
            <div class="card-body">
                <form id="form-academico">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="institucion" class="form-label">Institución Educativa</label>
                            <input type="text" class="form-control" id="institucion" name="institucion" 
                                   value="Universidad Nacional Autónoma de Honduras">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="carrera" class="form-label">Carrera/Profesión</label>
                            <input type="text" class="form-control" id="carrera" name="carrera" 
                                   value="Ingeniería en Sistemas">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nivel-academico" class="form-label">Nivel Académico</label>
                            <select class="form-select" id="nivel-academico" name="nivel_academico">
                                <option value="secundaria">Educación Secundaria</option>
                                <option value="universitario" selected>Universitario</option>
                                <option value="tecnico">Técnico</option>
                                <option value="licenciatura">Licenciatura</option>
                                <option value="maestria">Maestría</option>
                                <option value="doctorado">Doctorado</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ano-graduacion" class="form-label">Año de Graduación</label>
                            <input type="number" class="form-control" id="ano-graduacion" 
                                   name="ano_graduacion" value="2026" min="2020" max="2030">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ocupacion" class="form-label">Ocupación Actual</label>
                            <input type="text" class="form-control" id="ocupacion" name="ocupacion" 
                                   value="Estudiante / Desarrollador Jr.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="empresa" class="form-label">Empresa/Organización</label>
                            <input type="text" class="form-control" id="empresa" name="empresa" 
                                   value="TechSolutions HN">
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i>
                            Guardar Información
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Seguridad y privacidad -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt text-warning"></i>
                    Seguridad y Privacidad
                </h5>
            </div>
            <div class="card-body">
                <form id="form-seguridad">
                    <div class="mb-3">
                        <label for="password-actual" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="password-actual" name="password_actual">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password-nueva" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password-nueva" name="password_nueva">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password-confirmar" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="password-confirmar" name="password_confirmar">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="perfil-publico" name="perfil_publico" checked>
                            <label class="form-check-label" for="perfil-publico">
                                Permitir que otros miembros vean mi perfil básico
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="notificaciones-email" name="notificaciones_email" checked>
                            <label class="form-check-label" for="notificaciones-email">
                                Recibir notificaciones por correo electrónico
                            </label>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-lock"></i>
                            Actualizar Seguridad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar foto -->
<div class="modal fade" id="cambiarFotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Foto de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="foto-perfil" class="form-label">Seleccionar nueva foto</label>
                    <input class="form-control" type="file" id="foto-perfil" accept="image/*">
                </div>
                <div class="text-center">
                    <img id="preview-foto" src="" class="rounded-circle" width="150" height="150" 
                         style="display: none;" alt="Vista previa">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar Foto</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Previsualización de foto
document.getElementById('foto-perfil').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-foto');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Simulación de guardado de formularios
document.getElementById('form-info-personal').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Información personal actualizada exitosamente');
});

document.getElementById('form-contacto').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Información de contacto actualizada exitosamente');
});

document.getElementById('form-academico').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Información académica actualizada exitosamente');
});

document.getElementById('form-seguridad').addEventListener('submit', function(e) {
    e.preventDefault();
    const passwordNueva = document.getElementById('password-nueva').value;
    const passwordConfirmar = document.getElementById('password-confirmar').value;
    
    if (passwordNueva && passwordNueva !== passwordConfirmar) {
        alert('Las contraseñas no coinciden');
        return;
    }
    
    alert('Configuración de seguridad actualizada exitosamente');
});
</script>
@endsection