<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Gestión de Eventos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --reunion-virtual: #3498db;
            --reunion-presencial: #e74c3c;
            --inicio-proyecto: #2ecc71;
            --fin-proyecto: #f39c12;
        }
        
        .calendar-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .calendar-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }
        
        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .nav-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .nav-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }
        
        .current-month {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        
        .weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .weekday {
            background: #f8f9fa;
            padding: 15px 8px;
            text-align: center;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #e9ecef;
            margin-top: 1px;
        }
        
        .calendar-day {
            background: white;
            min-height: 120px;
            padding: 8px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }
        
        .calendar-day:hover {
            background: #f8f9fa;
            border-color: #667eea;
        }
        
        .calendar-day.other-month {
            background: #f8f9fa;
            color: #adb5bd;
        }
        
        .calendar-day.today {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .day-number {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .event {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-bottom: 2px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            display: block;
            text-decoration: none;
        }
        
        .event:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }
        
        .event.reunion-virtual {
            background: var(--reunion-virtual);
        }
        
        .event.reunion-presencial {
            background: var(--reunion-presencial);
        }
        
        .event.inicio-proyecto {
            background: var(--inicio-proyecto);
        }
        
        .event.fin-proyecto {
            background: var(--fin-proyecto);
        }
        
        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 14px;
        }
        
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }
        
        .btn-edit {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .btn-edit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 30px rgba(102, 126, 234, 0.6);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        
        .event-details {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 100;
            display: none;
        }
    </style>
</head>
<body class="bg-light">

@php
    // Configuración del calendario
    $currentDate = now();
    if (request()->has('year') && request()->has('month')) {
        $currentDate = \Carbon\Carbon::createFromDate(request('year'), request('month'), 1);
    }
    
    $startOfMonth = $currentDate->copy()->startOfMonth();
    $endOfMonth = $currentDate->copy()->endOfMonth();
    $startOfCalendar = $startOfMonth->copy()->startOfWeek();
    $endOfCalendar = $endOfMonth->copy()->endOfWeek();
    
    // Datos de ejemplo de eventos - funcionan sin base de datos
    $eventos = collect([
        (object)[
            'id' => 1,
            'titulo' => 'Reunión de equipo',
            'descripcion' => 'Revisión semanal del proyecto',
            'fecha' => $currentDate->copy()->addDays(2)->format('Y-m-d'),
            'hora' => '10:00',
            'tipo' => 'reunion-virtual',
            'link' => 'https://meet.google.com/abc-def-ghi'
        ],
        (object)[
            'id' => 2,
            'titulo' => 'Presentación cliente',
            'descripcion' => 'Presentación del prototipo final',
            'fecha' => $currentDate->copy()->addDays(4)->format('Y-m-d'),
            'hora' => '14:30',
            'tipo' => 'reunion-presencial',
            'ubicacion' => 'Sala de juntas A'
        ],
        (object)[
            'id' => 3,
            'titulo' => 'Inicio Proyecto Alpha',
            'descripcion' => 'Kickoff del nuevo proyecto',
            'fecha' => $currentDate->copy()->addDays(6)->format('Y-m-d'),
            'hora' => '09:00',
            'tipo' => 'inicio-proyecto'
        ],
        (object)[
            'id' => 4,
            'titulo' => 'Entrega Proyecto Beta',
            'descripcion' => 'Entrega final del proyecto Beta',
            'fecha' => $currentDate->copy()->addDays(9)->format('Y-m-d'),
            'hora' => '17:00',
            'tipo' => 'fin-proyecto'
        ],
        (object)[
            'id' => 5,
            'titulo' => 'Reunión con Marketing',
            'descripcion' => 'Planificación campaña Q4',
            'fecha' => $currentDate->copy()->addDays(12)->format('Y-m-d'),
            'hora' => '11:30',
            'tipo' => 'reunion-virtual',
            'link' => 'https://zoom.us/j/123456789'
        ],
        (object)[
            'id' => 6,
            'titulo' => 'Workshop UX/UI',
            'descripcion' => 'Taller de diseño centrado en usuario',
            'fecha' => $currentDate->copy()->addDays(15)->format('Y-m-d'),
            'hora' => '09:30',
            'tipo' => 'reunion-presencial',
            'ubicacion' => 'Auditorio Principal'
        ]
    ]);
    
    $tiposEvento = [
        'reunion-virtual' => 'Reunión Virtual',
        'reunion-presencial' => 'Reunión Presencial',
        'inicio-proyecto' => 'Inicio de Proyecto',
        'fin-proyecto' => 'Fin de Proyecto'
    ];
@endphp

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="calendar-container">
                <!-- Header del Calendario -->
                <div class="calendar-header">
                    <div class="calendar-nav">
                        <button class="nav-btn" onclick="cambiarMes(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h2 class="current-month">
                            {{ $currentDate->locale('es')->isoFormat('MMMM YYYY') }}
                        </h2>
                        <button class="nav-btn" onclick="cambiarMes(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Leyenda de colores -->
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--reunion-virtual)"></div>
                            <span>Reunión Virtual</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--reunion-presencial)"></div>
                            <span>Reunión Presencial</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--inicio-proyecto)"></div>
                            <span>Inicio Proyecto</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: var(--fin-proyecto)"></div>
                            <span>Fin Proyecto</span>
                        </div>
                    </div>
                </div>
                
                <!-- Días de la semana -->
                <div class="weekdays">
                    <div class="weekday">Dom</div>
                    <div class="weekday">Lun</div>
                    <div class="weekday">Mar</div>
                    <div class="weekday">Mié</div>
                    <div class="weekday">Jue</div>
                    <div class="weekday">Vie</div>
                    <div class="weekday">Sáb</div>
                </div>
                
                <!-- Grid del calendario -->
                <div class="calendar-grid">
                    @for($date = $startOfCalendar; $date <= $endOfCalendar; $date->addDay())
                        @php
                            $isCurrentMonth = $date->month === $currentDate->month;
                            $isToday = $date->isToday();
                            $dayEvents = $eventos->filter(function($evento) use ($date) {
                                return $date->format('Y-m-d') === $evento->fecha;
                            });
                        @endphp
                        
                        <div class="calendar-day {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }}" 
                             onclick="abrirModalEvento('{{ $date->format('Y-m-d') }}')">
                            <div class="day-number">{{ $date->day }}</div>
                            
                            @foreach($dayEvents as $evento)
                                <div class="event {{ $evento->tipo }}" 
                                     onclick="event.stopPropagation(); verDetalleEvento({{ $evento->id }})"
                                     title="{{ $evento->titulo }} - {{ $evento->hora }}">
                                    <i class="fas fa-clock me-1"></i>{{ $evento->hora }} {{ Str::limit($evento->titulo, 15) }}
                                </div>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botón flotante para editar/agregar eventos -->
<button class="btn-edit" onclick="abrirModalEvento()" title="Agregar evento">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal para crear/editar eventos -->
<div class="modal fade" id="modalEvento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEventoTitulo">
                    <i class="fas fa-calendar-plus me-2"></i>Nuevo Evento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEvento" method="POST" action="{{ url('/eventos') }}"
                    @csrf
                    <input type="hidden" id="eventoId" name="id" value="">
                    <input type="hidden" id="metodo" name="_method" value="POST">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">
                                    <i class="fas fa-heading me-1"></i>Título del Evento
                                </label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-tags me-1"></i>Tipo de Evento
                                </label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="">Seleccionar tipo</option>
                                    @foreach($tiposEvento as $valor => $nombre)
                                        <option value="{{ $valor }}">{{ $nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Fecha
                                </label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hora" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Hora
                                </label>
                                <input type="time" class="form-control" id="hora" name="hora" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Descripción
                        </label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    
                    <!-- Campos específicos según tipo de evento -->
                    <div id="camposEspecificos"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnEliminar" style="display: none;" onclick="eliminarEvento()">
                    <i class="fas fa-trash me-1"></i>Eliminar
                </button>
                <button type="submit" form="formEvento" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Guardar Evento
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del evento -->
<div class="modal fade" id="modalDetalleEvento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleEventoTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleEventoContenido">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editarEventoDesdeDetalle()">
                    <i class="fas fa-edit me-1"></i>Editar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    let currentYear = {{ $currentDate->year }};
    let currentMonth = {{ $currentDate->month }};
    let eventoActual = null;
    
    // Datos de eventos (en tu app real, estos vendrían del servidor)
    let eventos = @json($eventos);
    
    function cambiarMes(direccion) {
        currentMonth += direccion;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        } else if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        
        window.location.href = `?year=${currentYear}&month=${currentMonth}`;
    }
    
    function abrirModalEvento(fecha = null) {
        const modal = new bootstrap.Modal(document.getElementById('modalEvento'));
        
        // Limpiar formulario
        document.getElementById('formEvento').reset();
        document.getElementById('eventoId').value = '';
        document.getElementById('metodo').value = 'POST';
        document.getElementById('modalEventoTitulo').innerHTML = '<i class="fas fa-calendar-plus me-2"></i>Nuevo Evento';
        document.getElementById('btnEliminar').style.display = 'none';
        document.getElementById('camposEspecificos').innerHTML = '';
        
        if (fecha) {
            document.getElementById('fecha').value = fecha;
        } else {
            // Si no se especifica fecha, usar hoy
            const hoy = new Date();
            const fechaHoy = hoy.toISOString().split('T')[0];
            document.getElementById('fecha').value = fechaHoy;
        }
        
        // Establecer hora por defecto
        const ahoraHora = new Date();
        const horaActual = ahoraHora.getHours().toString().padStart(2, '0') + ':' + 
                          ahoraHora.getMinutes().toString().padStart(2, '0');
        document.getElementById('hora').value = horaActual;
        
        modal.show();
    }
    
    function verDetalleEvento(eventoId) {
        const evento = eventos.find(e => e.id == eventoId);
        if (!evento) return;
        
        const modal = new bootstrap.Modal(document.getElementById('modalDetalleEvento'));
        const tiposEvento = {
            'reunion-virtual': 'Reunión Virtual',
            'reunion-presencial': 'Reunión Presencial',
            'inicio-proyecto': 'Inicio de Proyecto',
            'fin-proyecto': 'Fin de Proyecto'
        };
        
        document.getElementById('detalleEventoTitulo').innerHTML = evento.titulo;
        
        let contenido = `
            <div class="mb-3">
                <strong><i class="fas fa-calendar me-1"></i>Fecha:</strong> ${formatearFecha(evento.fecha)}
            </div>
            <div class="mb-3">
                <strong><i class="fas fa-clock me-1"></i>Hora:</strong> ${evento.hora}
            </div>
            <div class="mb-3">
                <strong><i class="fas fa-tags me-1"></i>Tipo:</strong> 
                <span class="badge" style="background: var(--${evento.tipo})">${tiposEvento[evento.tipo]}</span>
            </div>
        `;
        
        if (evento.descripcion) {
            contenido += `
                <div class="mb-3">
                    <strong><i class="fas fa-align-left me-1"></i>Descripción:</strong><br>
                    ${evento.descripcion}
                </div>
            `;
        }
        
        if (evento.link) {
            contenido += `
                <div class="mb-3">
                    <strong><i class="fas fa-link me-1"></i>Link:</strong><br>
                    <a href="${evento.link}" target="_blank" class="btn btn-sm btn-outline-primary">${evento.link}</a>
                </div>
            `;
        }
        
        if (evento.ubicacion) {
            contenido += `
                <div class="mb-3">
                    <strong><i class="fas fa-map-marker-alt me-1"></i>Ubicación:</strong><br>
                    ${evento.ubicacion}
                </div>
            `;
        }
        
        document.getElementById('detalleEventoContenido').innerHTML = contenido;
        eventoActual = evento;
        
        modal.show();
    }
    
    function editarEventoDesdeDetalle() {
        // Cerrar modal de detalle
        bootstrap.Modal.getInstance(document.getElementById('modalDetalleEvento')).hide();
        
        // Abrir modal de edición con datos del evento
        setTimeout(() => {
            const modal = new bootstrap.Modal(document.getElementById('modalEvento'));
            
            document.getElementById('eventoId').value = eventoActual.id;
            document.getElementById('metodo').value = 'PUT';
            document.getElementById('titulo').value = eventoActual.titulo;
            document.getElementById('tipo').value = eventoActual.tipo;
            document.getElementById('fecha').value = eventoActual.fecha;
            document.getElementById('hora').value = eventoActual.hora;
            document.getElementById('descripcion').value = eventoActual.descripcion || '';
            
            document.getElementById('modalEventoTitulo').innerHTML = '<i class="fas fa-edit me-2"></i>Editar Evento';
            document.getElementById('btnEliminar').style.display = 'inline-block';
            
            // Actualizar campos específicos
            actualizarCamposEspecificos();
            
            modal.show();
        }, 300);
    }
    
    function eliminarEvento() {
        if (!confirm('¿Estás seguro de que deseas eliminar este evento?')) return;
        
        // Aquí enviarías la petición DELETE al servidor
        console.log('Eliminando evento:', eventoActual.id);
        
        // Cerrar modal
        bootstrap.Modal.getInstance(document.getElementById('modalEvento')).hide();
        
        // En tu aplicación real, recargar o actualizar la vista
        location.reload();
    }
    
    function actualizarCamposEspecificos() {
        const tipo = document.getElementById('tipo').value;
        const contenedor = document.getElementById('camposEspecificos');
        
        let campos = '';
        
        switch(tipo) {
            case 'reunion-virtual':
                campos = `
                    <div class="mb-3">
                        <label for="link" class="form-label">
                            <i class="fas fa-link me-1"></i>Link de la reunión
                        </label>
                        <input type="url" class="form-control" id="link" name="link" placeholder="https://meet.google.com/...">
                    </div>
                `;
                break;
                
            case 'reunion-presencial':
                campos = `
                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Ubicación
                        </label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Sala de juntas, dirección, etc.">
                    </div>
                `;
                break;
                
            case 'inicio-proyecto':
            case 'fin-proyecto':
                campos = `
                    <div class="mb-3">
                        <label for="proyecto" class="form-label">
                            <i class="fas fa-project-diagram me-1"></i>Nombre del Proyecto
                        </label>
                        <input type="text" class="form-control" id="proyecto" name="proyecto" placeholder="Nombre del proyecto">
                    </div>
                `;
                break;
        }
        
        contenedor.innerHTML = campos;
    }
    
    function formatearFecha(fecha) {
        const date = new Date(fecha + 'T00:00:00');
        return date.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    // Event listeners
    document.getElementById('tipo').addEventListener('change', actualizarCamposEspecificos);
    
    // Configurar CSRF token para peticiones AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios = axios;
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
        }
    });
    
    // CRUD COMPLETO DEL CALENDARIO
    
    // ========================================
    // CREATE - Crear nuevo evento
    // ========================================
    function crearEvento(datosEvento) {
        return new Promise((resolve, reject) => {
            // Simular petición al servidor
            setTimeout(() => {
                try {
                    // Generar ID único
                    const nuevoEvento = {
                        id: Date.now() + Math.random(), // ID único
                        ...datosEvento,
                        created_at: new Date().toISOString(),
                        updated_at: new Date().toISOString()
                    };
                    
                    // Agregar a la lista de eventos
                    eventos.push(nuevoEvento);
                    
                    console.log('✅ CREATE - Evento creado:', nuevoEvento);
                    resolve(nuevoEvento);
                } catch (error) {
                    console.error('❌ ERROR CREATE:', error);
                    reject(error);
                }
            }, 500);
        });
    }
    
    // ========================================
    // READ - Leer evento por ID
    // ========================================
    function leerEvento(eventoId) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                const evento = eventos.find(e => e.id == eventoId);
                if (evento) {
                    console.log('✅ READ - Evento encontrado:', evento);
                    resolve(evento);
                } else {
                    console.error('❌ READ - Evento no encontrado:', eventoId);
                    reject(new Error('Evento no encontrado'));
                }
            }, 200);
        });
    }
    
    // ========================================
    // UPDATE - Actualizar evento existente
    // ========================================
    function actualizarEvento(eventoId, datosActualizados) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                try {
                    const index = eventos.findIndex(e => e.id == eventoId);
                    if (index === -1) {
                        throw new Error('Evento no encontrado para actualizar');
                    }
                    
                    // Mantener datos originales y actualizar solo los nuevos
                    const eventoOriginal = eventos[index];
                    const eventoActualizado = {
                        ...eventoOriginal,
                        ...datosActualizados,
                        updated_at: new Date().toISOString()
                    };
                    
                    // Reemplazar en el array
                    eventos[index] = eventoActualizado;
                    
                    console.log('✅ UPDATE - Evento actualizado:', eventoActualizado);
                    resolve(eventoActualizado);
                } catch (error) {
                    console.error('❌ ERROR UPDATE:', error);
                    reject(error);
                }
            }, 600);
        });
    }
    
    // ========================================
    // DELETE - Eliminar evento
    // ========================================
    function eliminarEventoCRUD(eventoId) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                try {
                    const index = eventos.findIndex(e => e.id == eventoId);
                    if (index === -1) {
                        throw new Error('Evento no encontrado para eliminar');
                    }
                    
                    const eventoEliminado = eventos[index];
                    eventos.splice(index, 1);
                    
                    console.log('✅ DELETE - Evento eliminado:', eventoEliminado);
                    resolve(eventoEliminado);
                } catch (error) {
                    console.error('❌ ERROR DELETE:', error);
                    reject(error);
                }
            }, 400);
        });
    }
    
    // ========================================
    // LIST - Listar todos los eventos
    // ========================================
    function listarEventos(filtros = {}) {
        return new Promise((resolve) => {
            setTimeout(() => {
                let eventosFiltrados = [...eventos];
                
                // Aplicar filtros si existen
                if (filtros.fecha) {
                    eventosFiltrados = eventosFiltrados.filter(e => e.fecha === filtros.fecha);
                }
                if (filtros.tipo) {
                    eventosFiltrados = eventosFiltrados.filter(e => e.tipo === filtros.tipo);
                }
                if (filtros.mes) {
                    eventosFiltrados = eventosFiltrados.filter(e => {
                        const fechaEvento = new Date(e.fecha);
                        return fechaEvento.getMonth() + 1 === filtros.mes;
                    });
                }
                
                // Ordenar por fecha y hora
                eventosFiltrados.sort((a, b) => {
                    if (a.fecha === b.fecha) {
                        return a.hora.localeCompare(b.hora);
                    }
                    return a.fecha.localeCompare(b.fecha);
                });
                
                console.log('✅ LIST - Eventos filtrados:', eventosFiltrados);
                resolve(eventosFiltrados);
            }, 300);
        });
    }
    
    // ========================================
    // MANEJADOR DEL FORMULARIO CON CRUD
    // ========================================
    document.getElementById('formEvento').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Validar formulario
        const errores = validarFormulario(formData);
        if (errores.length > 0) {
            mostrarNotificacion('❌ Errores en el formulario:\n• ' + errores.join('\n• '), 'error');
            return;
        }
        
        const eventoId = document.getElementById('eventoId').value;
        const esEdicion = eventoId && eventoId !== '';
        
        // Mostrar indicador de carga
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i>${esEdicion ? 'Actualizando...' : 'Creando...'}`;
        submitBtn.disabled = true;
        
        try {
            // Preparar datos del evento
            const datosEvento = {
                titulo: formData.get('titulo').trim(),
                descripcion: formData.get('descripcion') ? formData.get('descripcion').trim() : '',
                fecha: formData.get('fecha'),
                hora: formData.get('hora'),
                tipo: formData.get('tipo'),
                link: formData.get('link') ? formData.get('link').trim() : '',
                ubicacion: formData.get('ubicacion') ? formData.get('ubicacion').trim() : '',
                proyecto: formData.get('proyecto') ? formData.get('proyecto').trim() : ''
            };
            
            let evento;
            let mensaje;
            
            if (esEdicion) {
                // ACTUALIZAR evento existente
                evento = await actualizarEvento(eventoId, datosEvento);
                mensaje = '✅ Evento actualizado exitosamente';
            } else {
                // CREAR nuevo evento
                evento = await crearEvento(datosEvento);
                mensaje = '✅ Evento creado exitosamente';
            }
            
            // Actualizar vista del calendario
            await actualizarVistaCalendario();
            
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalEvento')).hide();
            
            // Mostrar notificación de éxito
            mostrarNotificacion(mensaje, 'success');
            
            // Log para debug
            console.log(`✅ CRUD ${esEdicion ? 'UPDATE' : 'CREATE'} exitoso:`, evento);
            
        } catch (error) {
            console.error('❌ Error en CRUD:', error);
            mostrarNotificacion(`❌ Error: ${error.message}`, 'error');
        } finally {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
    
    // ========================================
    // ELIMINAR EVENTO CON CRUD
    // ========================================
    async function eliminarEvento() {
        const eventoId = document.getElementById('eventoId').value;
        
        // Confirmar eliminación
        const confirmar = await mostrarDialogoConfirmacion(
            '🗑️ Eliminar Evento', 
            '¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.'
        );
        
        if (!confirmar) return;
        
        // Mostrar indicador de carga
        const btnEliminar = document.getElementById('btnEliminar');
        const originalText = btnEliminar.innerHTML;
        btnEliminar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Eliminando...';
        btnEliminar.disabled = true;
        
        try {
            // ELIMINAR evento
            const eventoEliminado = await eliminarEventoCRUD(eventoId);
            
            // Actualizar vista del calendario
            await actualizarVistaCalendario();
            
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalEvento')).hide();
            
            // Mostrar notificación de éxito
            mostrarNotificacion('✅ Evento eliminado exitosamente', 'success');
            
            console.log('✅ CRUD DELETE exitoso:', eventoEliminado);
            
        } catch (error) {
            console.error('❌ Error al eliminar:', error);
            mostrarNotificacion(`❌ Error al eliminar: ${error.message}`, 'error');
        } finally {
            // Restaurar botón
            btnEliminar.innerHTML = originalText;
            btnEliminar.disabled = false;
        }
    }
    
    // ========================================
    // VER DETALLE DE EVENTO CON CRUD
    // ========================================
    async function verDetalleEvento(eventoId) {
        try {
            // LEER evento por ID
            const evento = await leerEvento(eventoId);
            
            const modal = new bootstrap.Modal(document.getElementById('modalDetalleEvento'));
            const tiposEvento = {
                'reunion-virtual': 'Reunión Virtual',
                'reunion-presencial': 'Reunión Presencial',
                'inicio-proyecto': 'Inicio de Proyecto',
                'fin-proyecto': 'Fin de Proyecto'
            };
            
            document.getElementById('detalleEventoTitulo').innerHTML = `
                <i class="fas fa-eye me-2"></i>${evento.titulo}
            `;
            
            let contenido = `
                <div class="mb-3">
                    <strong><i class="fas fa-calendar me-1"></i>Fecha:</strong> 
                    ${formatearFecha(evento.fecha)}
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-clock me-1"></i>Hora:</strong> 
                    ${evento.hora}
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-tags me-1"></i>Tipo:</strong> 
                    <span class="badge" style="background: var(--${evento.tipo})">${tiposEvento[evento.tipo]}</span>
                </div>
            `;
            
            if (evento.descripcion) {
                contenido += `
                    <div class="mb-3">
                        <strong><i class="fas fa-align-left me-1"></i>Descripción:</strong><br>
                        <div class="p-2 bg-light rounded">${evento.descripcion}</div>
                    </div>
                `;
            }
            
            if (evento.link) {
                contenido += `
                    <div class="mb-3">
                        <strong><i class="fas fa-link me-1"></i>Link:</strong><br>
                        <a href="${evento.link}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Abrir enlace
                        </a>
                    </div>
                `;
            }
            
            if (evento.ubicacion) {
                contenido += `
                    <div class="mb-3">
                        <strong><i class="fas fa-map-marker-alt me-1"></i>Ubicación:</strong><br>
                        <div class="p-2 bg-light rounded">${evento.ubicacion}</div>
                    </div>
                `;
            }
            
            if (evento.proyecto) {
                contenido += `
                    <div class="mb-3">
                        <strong><i class="fas fa-project-diagram me-1"></i>Proyecto:</strong><br>
                        <div class="p-2 bg-light rounded">${evento.proyecto}</div>
                    </div>
                `;
            }
            
            // Información de auditoría
            contenido += `
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">
                            <i class="fas fa-plus-circle me-1"></i>Creado: ${formatearFechaHora(evento.created_at)}
                        </small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">
                            <i class="fas fa-edit me-1"></i>Actualizado: ${formatearFechaHora(evento.updated_at)}
                        </small>
                    </div>
                </div>
            `;
            
            document.getElementById('detalleEventoContenido').innerHTML = contenido;
            eventoActual = evento;
            
            modal.show();
            
        } catch (error) {
            console.error('❌ Error al cargar evento:', error);
            mostrarNotificacion(`❌ Error al cargar evento: ${error.message}`, 'error');
        }
    }
    
    // ========================================
    // FUNCIONES AUXILIARES PARA CRUD
    // ========================================
    
    function mostrarDialogoConfirmacion(titulo, mensaje) {
        return new Promise((resolve) => {
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">${titulo}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>${mensaje}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resolverConfirmacion(false)">
                                <i class="fas fa-times me-1"></i>Cancelar
                            </button>
                            <button type="button" class="btn btn-danger" onclick="resolverConfirmacion(true)">
                                <i class="fas fa-check me-1"></i>Confirmar
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            window.resolverConfirmacion = (resultado) => {
                bootstrap.Modal.getInstance(modal).hide();
                modal.remove();
                resolve(resultado);
                delete window.resolverConfirmacion;
            };
            
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        });
    }
    
    function formatearFechaHora(fechaISO) {
        if (!fechaISO) return 'N/A';
        const fecha = new Date(fechaISO);
        return fecha.toLocaleString('es-ES', {
            day: '2-digit',
            month: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    // ========================================
    // ESTADÍSTICAS DEL CRUD
    // ========================================
    function obtenerEstadisticas() {
        const stats = {
            total: eventos.length,
            porTipo: {},
            proximosEventos: 0,
            eventosHoy: 0
        };
        
        const hoy = new Date().toISOString().split('T')[0];
        
        eventos.forEach(evento => {
            // Contar por tipo
            stats.porTipo[evento.tipo] = (stats.porTipo[evento.tipo] || 0) + 1;
            
            // Eventos de hoy
            if (evento.fecha === hoy) {
                stats.eventosHoy++;
            }
            
            // Próximos eventos (próximos 7 días)
            const fechaEvento = new Date(evento.fecha);
            const fechaLimite = new Date();
            fechaLimite.setDate(fechaLimite.getDate() + 7);
            
            if (fechaEvento >= new Date() && fechaEvento <= fechaLimite) {
                stats.proximosEventos++;
            }
        });
        
        console.log('📊 Estadísticas del calendario:', stats);
        return stats;
    }
    
    // Mostrar estadísticas en consola cada vez que se actualiza
    function actualizarVistaCalendario() {
        return new Promise((resolve) => {
            // Obtener todos los días del calendario
            const diasCalendario = document.querySelectorAll('.calendar-day');
            
            // Limpiar eventos existentes de todos los días
            diasCalendario.forEach(dia => {
                const eventosEnDia = dia.querySelectorAll('.event');
                eventosEnDia.forEach(evento => evento.remove());
            });
            
            // Agregar eventos actualizados
            eventos.forEach(evento => {
                const fechaEvento = new Date(evento.fecha + 'T00:00:00');
                const diaDelMes = fechaEvento.getDate();
                
                // Buscar el día correspondiente en el calendario
                diasCalendario.forEach(diaElemento => {
                    const numeroDia = diaElemento.querySelector('.day-number');
                    if (numeroDia && parseInt(numeroDia.textContent) === diaDelMes) {
                        // Verificar que sea del mismo mes (no de meses anteriores/siguientes)
                        const esOtroMes = diaElemento.classList.contains('other-month');
                        if (!esOtroMes) {
                            // Crear elemento del evento
                            const eventoElemento = document.createElement('div');
                            eventoElemento.className = `event ${evento.tipo}`;
                            eventoElemento.onclick = function(e) {
                                e.stopPropagation();
                                verDetalleEvento(evento.id);
                            };
                            eventoElemento.title = `${evento.titulo} - ${evento.hora}`;
                            eventoElemento.innerHTML = `<i class="fas fa-clock me-1"></i>${evento.hora} ${truncarTexto(evento.titulo, 15)}`;
                            
                            // Agregar el evento al día
                            diaElemento.appendChild(eventoElemento);
                        }
                    }
                });
            });
            
            // Actualizar estadísticas
            obtenerEstadisticas();
            
            // Actualizar el array de eventos en JavaScript para futuras operaciones
            window.eventos = eventos;
            
            resolve();
        });
    }    // ========================================
    // FUNCIONES AUXILIARES RESTANTES
    // ========================================
    
    // Función de validación del formulario
    function validarFormulario(formData) {
        const errores = [];
        
        if (!formData.get('titulo').trim()) {
            errores.push('El título del evento es obligatorio');
        }
        
        if (!formData.get('fecha')) {
            errores.push('La fecha del evento es obligatoria');
        }
        
        if (!formData.get('hora')) {
            errores.push('La hora del evento es obligatoria');
        }
        
        if (!formData.get('tipo')) {
            errores.push('Debe seleccionar un tipo de evento');
        }
        
        // Validar que la fecha no sea en el pasado (opcional)
        const fechaEvento = new Date(formData.get('fecha'));
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        
        if (fechaEvento < hoy) {
            errores.push('La fecha del evento no puede ser en el pasado');
        }
        
        // Validaciones específicas por tipo
        const tipo = formData.get('tipo');
        if (tipo === 'reunion-virtual') {
            const link = formData.get('link');
            if (link && !isValidURL(link)) {
                errores.push('El link de la reunión virtual debe ser una URL válida');
            }
        }
        
        return errores;
    }
    
    // Función auxiliar para validar URLs
    function isValidURL(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Función auxiliar para truncar texto
    function truncarTexto(texto, longitud) {
        if (texto.length <= longitud) return texto;
        return texto.substring(0, longitud) + '...';
    }
    
    // Actualizar función editarEventoDesdeDetalle para usar datos actualizados
    async function editarEventoDesdeDetalle() {
        try {
            // Cerrar modal de detalle
            bootstrap.Modal.getInstance(document.getElementById('modalDetalleEvento')).hide();
            
            // Abrir modal de edición con datos del evento
            setTimeout(async () => {
                const modal = new bootstrap.Modal(document.getElementById('modalEvento'));
                
                // LEER datos actualizados del evento
                const evento = await leerEvento(eventoActual.id);
                
                document.getElementById('eventoId').value = evento.id;
                document.getElementById('metodo').value = 'PUT';
                document.getElementById('titulo').value = evento.titulo;
                document.getElementById('tipo').value = evento.tipo;
                document.getElementById('fecha').value = evento.fecha;
                document.getElementById('hora').value = evento.hora;
                document.getElementById('descripcion').value = evento.descripcion || '';
                
                document.getElementById('modalEventoTitulo').innerHTML = '<i class="fas fa-edit me-2"></i>Editar Evento';
                document.getElementById('btnEliminar').style.display = 'inline-block';
                
                // Actualizar campos específicos
                actualizarCamposEspecificos();
                
                // Llenar campos específicos si existen
                setTimeout(() => {
                    if (document.getElementById('link')) {
                        document.getElementById('link').value = evento.link || '';
                    }
                    if (document.getElementById('ubicacion')) {
                        document.getElementById('ubicacion').value = evento.ubicacion || '';
                    }
                    if (document.getElementById('proyecto')) {
                        document.getElementById('proyecto').value = evento.proyecto || '';
                    }
                }, 100);
                
                modal.show();
            }, 300);
            
        } catch (error) {
            console.error('❌ Error al cargar evento para editar:', error);
            mostrarNotificacion(`❌ Error al cargar evento: ${error.message}`, 'error');
        }
    }
    
    // ========================================
    // FUNCIONES DE BÚSQUEDA Y FILTRADO
    // ========================================
    
    // Buscar eventos por título
    async function buscarEventos(termino) {
        const eventosFiltrados = eventos.filter(evento => 
            evento.titulo.toLowerCase().includes(termino.toLowerCase()) ||
            (evento.descripcion && evento.descripcion.toLowerCase().includes(termino.toLowerCase()))
        );
        
        console.log(`🔍 Búsqueda "${termino}":`, eventosFiltrados);
        return eventosFiltrados;
    }
    
    // Obtener eventos por tipo
    async function obtenerEventosPorTipo(tipo) {
        return await listarEventos({ tipo });
    }
    
    // Obtener eventos de una fecha específica
    async function obtenerEventosPorFecha(fecha) {
        return await listarEventos({ fecha });
    }
    
    // ========================================
    // FUNCIONES DE EXPORTACIÓN E IMPORTACIÓN
    // ========================================
    
    // Exportar eventos a JSON
    function exportarEventos() {
        const datosExport = {
            eventos: eventos,
            exportado_en: new Date().toISOString(),
            total_eventos: eventos.length
        };
        
        const blob = new Blob([JSON.stringify(datosExport, null, 2)], {
            type: 'application/json'
        });
        
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `calendario_eventos_${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        mostrarNotificacion('📥 Eventos exportados correctamente', 'success');
    }
    
    // Importar eventos desde JSON
    function importarEventos(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                try {
                    const datos = JSON.parse(e.target.result);
                    
                    if (datos.eventos && Array.isArray(datos.eventos)) {
                        // Agregar eventos importados con IDs únicos
                        datos.eventos.forEach(evento => {
                            evento.id = Date.now() + Math.random();
                            evento.importado_en = new Date().toISOString();
                            eventos.push(evento);
                        });
                        
                        actualizarVistaCalendario();
                        mostrarNotificacion(`📤 ${datos.eventos.length} eventos importados correctamente`, 'success');
                        resolve(datos.eventos);
                    } else {
                        reject(new Error('Formato de archivo inválido'));
                    }
                } catch (error) {
                    reject(new Error('Error al procesar el archivo: ' + error.message));
                }
            };
            
            reader.onerror = () => reject(new Error('Error al leer el archivo'));
            reader.readAsText(file);
        });
    }
    
    // ========================================
    // FUNCIONES DE UTILIDAD PARA DEBUGGING
    // ========================================
    
    // Mostrar todos los eventos en consola
    window.debug_mostrarEventos = () => {
        console.table(eventos);
        return eventos;
    };
    
    // Limpiar todos los eventos
    window.debug_limpiarEventos = () => {
        if (confirm('⚠️ ¿Estás seguro de eliminar TODOS los eventos?')) {
            eventos.length = 0;
            actualizarVistaCalendario();
            mostrarNotificacion('🗑️ Todos los eventos han sido eliminados', 'warning');
        }
    };
    
    // Agregar eventos de prueba
    window.debug_agregarEventosPrueba = () => {
        const eventosPrueba = [
            {
                id: Date.now() + 1,
                titulo: 'Evento de Prueba 1',
                descripcion: 'Descripción de prueba',
                fecha: new Date().toISOString().split('T')[0],
                hora: '10:00',
                tipo: 'reunion-virtual',
                link: 'https://meet.google.com/test',
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString()
            },
            {
                id: Date.now() + 2,
                titulo: 'Evento de Prueba 2', 
                descripcion: 'Otra descripción',
                fecha: new Date(Date.now() + 86400000).toISOString().split('T')[0],
                hora: '15:30',
                tipo: 'reunion-presencial',
                ubicacion: 'Sala de Pruebas',
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString()
            }
        ];
        
        eventos.push(...eventosPrueba);
        actualizarVistaCalendario();
        mostrarNotificacion('🧪 Eventos de prueba agregados', 'info');
    };
    
    // ========================================
    // INICIALIZACIÓN AL CARGAR LA PÁGINA
    // ========================================
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🗓️ Sistema CRUD del Calendario inicializado');
        console.log('📊 Eventos cargados:', eventos.length);
        
        // Mostrar comandos de debug en consola
        console.log('🔧 Comandos de debug disponibles:');
        console.log('   - debug_mostrarEventos() - Muestra todos los eventos');
        console.log('   - debug_limpiarEventos() - Elimina todos los eventos');
        console.log('   - debug_agregarEventosPrueba() - Agrega eventos de ejemplo');
        console.log('   - obtenerEstadisticas() - Muestra estadísticas del calendario');
        
        // Mostrar estadísticas iniciales
        obtenerEstadisticas();
    });
    
    function mostrarNotificacion(mensaje, tipo = 'info') {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        const iconos = {
            'success': 'fas fa-check-circle',
            'error': 'fas fa-exclamation-triangle', 
            'info': 'fas fa-info-circle',
            'warning': 'fas fa-exclamation-circle'
        };
        
        const tipoClase = tipo === 'error' ? 'danger' : tipo;
        const icono = iconos[tipo] || iconos['info'];
        
        notificacion.className = `alert alert-${tipoClase} alert-dismissible fade show position-fixed`;
        notificacion.style.cssText = `
            top: 20px; 
            right: 20px; 
            z-index: 9999; 
            min-width: 350px;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border: none;
            border-radius: 10px;
        `;
        
        // Convertir saltos de línea a <br> para HTML
        const mensajeHTML = mensaje.replace(/\n/g, '<br>');
        
        notificacion.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="${icono} me-2 mt-1"></i>
                <div class="flex-grow-1">${mensajeHTML}</div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        document.body.appendChild(notificacion);
        
        // Añadir animación de entrada
        setTimeout(() => {
            notificacion.classList.add('show');
        }, 100);
        
        // Auto-remover después de 5 segundos (8 segundos para errores)
        const tiempoAutoRemover = tipo === 'error' ? 8000 : 5000;
        setTimeout(() => {
            if (notificacion.parentNode) {
                notificacion.classList.remove('show');
                setTimeout(() => {
                    if (notificacion.parentNode) {
                        notificacion.remove();
                    }
                }, 300);
            }
        }, tiempoAutoRemover);
    }
</script>

</body>
</html>