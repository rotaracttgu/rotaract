<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocero - Calendario de Eventos</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        /* Variables de colores */
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #06b6d4;
            --sidebar-bg: #1e293b;
            --sidebar-text: #e2e8f0;
            --otros-color: #8b5cf6; /* 🆕 Color para "Otros" */
        }

        /* Estilos base */
        body {
            background-color: #d0cfcd;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            overflow: hidden;
        }
        
        .sidebar-vocero {
            background: var(--sidebar-bg);
            width: 200px;
            position: fixed;
            left: 0;
            top: 0; 
            z-index: 20; 
            height: 100vh;
            padding-top: 64px;
            transition: all 0.3s ease;
        }

        .main-content-vocero {
            margin-left: 300px; 
            min-height: 100vh;
            flex-grow: 1;
            width: 900px;
            padding: 100;
            background: linear-gradient(135deg, #d0cfcd 0%, #c5c3c1 100%);
            position: relative;
            overflow-y: auto;
        }

        .main-content-vocero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: absolute; 
            top: 0;
            width: 100%;
            height: 64px; 
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 40; 
        }

        .sidebar-brand h4 {
            color: var(--sidebar-text);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar-vocero .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 4px 16px;
            padding: 12px 16px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .sidebar-vocero .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
        }

        .sidebar-vocero .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .content-wrapper {
            background: white;
            border-radius: 0;
            box-shadow: none;
            margin: 0;
            padding: 15px;
            height: 100vh;
            overflow: hidden;
        }

        .card {
            border: none;
            border-radius: 0;
            box-shadow: none;
            transition: transform 0.2s ease;
            height: calc(100vh - 100px);
        }

        .card-body {
            padding: 0 !important;
            height: 100%;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        #calendar {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            padding: 24px;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            animation: fadeInUp 0.6s ease-out;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .fc-toolbar-title {
            color: var(--primary-color) !important;
            font-weight: 700 !important;
            font-size: 1.75rem !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            animation: slideInRight 0.5s ease-out;
        }

        .fc-button-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%) !important;
            border-color: var(--primary-color) !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fc-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }

        .fc-button-primary:active {
            transform: translateY(0);
        }

        .fc-event {
            white-space: normal !important;
            overflow: visible !important;
            height: auto !important;
            min-height: 40px !important;
            padding: 6px 8px !important;
            font-size: 10px !important;
            line-height: 1.3 !important;
            border-radius: 6px !important;
            margin: 2px !important;
            border: none !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .fc-event-main {
            white-space: normal !important;
            overflow: visible !important;
            padding: 0 !important;
        }

        .fc-event-title {
            white-space: normal !important;
            overflow: visible !important;
            word-wrap: break-word !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
        }

        .fc-event-time {
            display: none !important;
        }

        .fc-daygrid-day-bottom {
            font-size: 10px;
            text-align: center;
            margin-top: 2px;
            cursor: pointer;
        }

        .more-events-indicator {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            color: white;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: 600;
            display: inline-block;
            margin: 2px auto;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(37, 99, 235, 0.3);
        }

        .more-events-indicator:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.4);
        }

        .fc-daygrid-day-frame {
            min-height: 110px !important;
            transition: all 0.3s ease;
            border-radius: 4px;
            cursor: pointer;
        }

        .fc-daygrid-day-frame:hover {
            background: rgba(37, 99, 235, 0.03);
        }

        .fc-daygrid-day-number {
            transition: all 0.3s ease;
            font-weight: 600 !important;
            cursor: pointer;
        }

        .fc-day-today .fc-daygrid-day-frame {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(37, 99, 235, 0.03) 100%);
            border: 2px solid rgba(37, 99, 235, 0.2) !important;
            animation: pulse 2s ease-in-out infinite;
        }

        .fc-day-today .fc-daygrid-day-number {
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700 !important;
        }

        .fc-col-header-cell {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            border: none !important;
            padding: 12px 8px !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .fc-scrollgrid {
            border: none !important;
            border-radius: 12px;
            overflow: hidden;
        }

        .fc-daygrid-day {
            transition: all 0.2s ease;
        }

        .fc-daygrid-day:hover {
            background: rgba(37, 99, 235, 0.02);
        }

        .event-fields {
            margin-top: 15px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active, 
        .fc .fc-button-primary:not(:disabled):active {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%) !important;
            border-color: #1d4ed8 !important;
            transform: scale(0.98);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .header-section {
            padding: 15px 20px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
        }

        .validation-message {
            font-size: 0.875rem;
            color: #dc2626;
            margin-top: 4px;
            display: none;
        }

        .validation-message.show {
            display: block;
        }

        .form-control.is-invalid {
            border-color: #dc2626 !important;
            background-image: none !important;
        }

        .event-list-item {
            padding: 16px;
            border-left: 5px solid;
            background: white;
            border-radius: 10px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .event-list-item:hover {
            background: #f8fafc;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: currentColor;
        }

        .event-list-item .event-time {
            font-weight: 700;
            color: #1e293b;
            min-width: 130px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
            padding: 8px 12px;
            background: #f1f5f9;
            border-radius: 8px;
        }

        .event-list-item .event-time .time-range {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }

        .event-list-item .event-time .duration {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
        }

        .event-list-item .event-info {
            flex-grow: 1;
        }

        .event-list-item .event-title {
            font-weight: 700;
            font-size: 15px;
            color: #0f172a;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-list-item .event-title .event-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .event-list-item .event-details {
            font-size: 12px;
            color: #64748b;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: center;
        }

        .event-list-item .event-details > span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .event-list-item .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .event-list-item .chevron-icon {
            color: #cbd5e1;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .event-list-item:hover .chevron-icon {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        /* Colores por tipo de evento */
        .event-list-item.reunion-virtual {
            border-left-color: #3b82f6;
        }

        .event-list-item.reunion-virtual .event-icon {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .event-list-item.reunion-presencial {
            border-left-color: #10b981;
        }

        .event-list-item.reunion-presencial .event-icon {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .event-list-item.inicio-proyecto {
            border-left-color: #f59e0b;
        }

        .event-list-item.inicio-proyecto .event-icon {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .event-list-item.finalizar-proyecto {
            border-left-color: #ef4444;
        }

        .event-list-item.finalizar-proyecto .event-icon {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* 🆕 ESTILOS PARA "OTROS" */
        .event-list-item.otros {
            border-left-color: #8b5cf6;
        }

        .event-list-item.otros .event-icon {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .badge-programado {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-en-curso {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-finalizado {
            background: #dcfce7;
            color: #166534;
        }

        .events-selector-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
            color: white;
            padding: 24px;
            border-radius: 12px 12px 0 0;
            margin: -16px -16px 24px -16px;
        }

        .events-selector-header h5 {
            margin: 0 0 8px 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .events-selector-header p {
            margin: 0;
            opacity: 0.95;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .events-selector-header .date-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            margin-left: 8px;
        }

        .no-events-message {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
        }

        .no-events-message i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #cbd5e1;
        }

        .no-events-message h5 {
            color: #475569;
            margin-bottom: 10px;
        }

        @keyframes slideInList {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .event-list-item {
            animation: slideInList 0.3s ease-out;
            animation-fill-mode: both;
        }

        .event-list-item:nth-child(1) { animation-delay: 0.05s; }
        .event-list-item:nth-child(2) { animation-delay: 0.1s; }
        .event-list-item:nth-child(3) { animation-delay: 0.15s; }
        .event-list-item:nth-child(4) { animation-delay: 0.2s; }
        .event-list-item:nth-child(5) { animation-delay: 0.25s; }

        @media (max-width: 768px) {
            .sidebar-vocero { 
                position: relative; 
                width: 100%; 
                height: auto; 
                padding-top: 0; 
            }
            .main-content-vocero { 
                margin-left: 0; 
                padding-top: 0; 
                width: 100%; 
            }
            
            .event-list-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .event-list-item .event-time {
                width: 100%;
            }
        }

        #events-list-container {
            max-height: 60vh;
            overflow-y: auto;
            padding-right: 8px;
        }

        #events-list-container::-webkit-scrollbar {
            width: 8px;
        }

        #events-list-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        #events-list-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #events-list-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* 🆕 Estilos para el modal de detalles del evento */
        .animated-modal {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .swal2-popup .swal2-html-container a.btn {
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .swal2-popup .swal2-html-container a.btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        {{-- MENÚ LATERAL (SIDEBAR) --}}
        <div class="sidebar-vocero">
            <div class="sidebar-brand">
                <h4><i class="fas fa-calendar-alt text-primary"></i> Macero</h4>
            </div>
            
            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('vocero.dashboard') ? 'active' : '' }}" href="{{ route('vocero.dashboard') }}">
                    <i class="fas fa-chart-line me-2"></i>
                    Resumen General
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.calendario') ? 'active' : '' }}" href="{{ route('vocero.calendario') }}">
                    <i class="fas fa-calendar me-2"></i>
                    Calendario
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.eventos') ? 'active' : '' }}" href="{{ route('vocero.eventos') }}">
                    <i class="fas fa-calendar-plus me-2"></i>
                    Gestión de Eventos
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.asistencias') ? 'active' : '' }}" href="{{ route('vocero.asistencias') }}">
                    <i class="fas fa-users me-2"></i>
                    Asistencias
                </a>
                <a class="nav-link {{ request()->routeIs('vocero.reportes') ? 'active' : '' }}" href="{{ route('vocero.reportes') }}">
                    <i class="fas fa-chart-bar me-2"></i>
                    Reportes
                </a>
            </nav>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="main-content-vocero">
            <div class="content-wrapper">
                <div class="header-section d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Calendario de Eventos</h2>
                        <p class="text-muted mb-0">Vista mensual de todos los eventos programados</p>
                    </div>
                    <button class="btn btn-primary" onclick="showCreateEventModal()">
                        <i class="fas fa-plus me-2"></i>Nuevo Evento
                    </button>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear/Editar Evento -->
    <div class="modal fade" id="eventoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventoForm">
                        <input type="hidden" id="eventoId">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Título del Evento *</label>
                                <input type="text" class="form-control" id="titulo" required>
                                <div id="titulo-validation-message" class="validation-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    No se permite la misma letra más de 3 veces consecutivas
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Evento *</label>
                                <select class="form-select" id="tipoEvento" required>
                                    <option value="">Seleccione...</option>
                                    <option value="reunion-virtual">Reunión Virtual</option>
                                    <option value="reunion-presencial">Reunión Presencial</option>
                                    <option value="inicio-proyecto">Inicio de Proyecto</option>
                                    <option value="finalizar-proyecto">Finalización de Proyecto</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha y Hora de Inicio *</label>
                                <input type="datetime-local" class="form-control" id="fecha_inicio" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha y Hora de Fin *</label>
                                <input type="datetime-local" class="form-control" id="fecha_fin" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organizador *</label>
                                <select class="form-select" id="organizador_id" required>
                                    <option value="">Seleccione un organizador...</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" id="estado">
                                    <option value="programado">Programado</option>
                                    <option value="en-curso">En Curso</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos Específicos según Tipo de Evento -->
                        <div id="virtualFields" class="event-fields" style="display: none;">
                            <label class="form-label">Enlace de Reunión Virtual</label>
                            <input type="url" class="form-control" id="enlace" placeholder="https://meet.google.com/...">
                        </div>

                        <div id="presencialFields" class="event-fields" style="display: none;">
                            <label class="form-label">Lugar de Reunión</label>
                            <input type="text" class="form-control" id="lugar" placeholder="Sala de conferencias, dirección, etc.">
                        </div>

                        <div id="proyectoFields" class="event-fields" style="display: none;">
                            <label class="form-label">Ubicación del Proyecto</label>
                            <input type="text" class="form-control" id="ubicacion_proyecto" placeholder="Ubicación del proyecto">
                        </div>

                        <div id="otrosFields" class="event-fields" style="display: none;">
                            <label class="form-label">Ubicación / Detalles</label>
                            <input type="text" class="form-control" id="ubicacion_otros" placeholder="Ubicación o detalles adicionales">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="eliminarBtn" style="display: none;">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="eventoForm" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PARA SELECCIONAR EVENTO DEL DÍA --}}
    <div class="modal fade" id="eventSelectorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="events-selector-header">
                        <h5>
                            <i class="fas fa-calendar-day"></i>
                            Eventos del Día
                        </h5>
                        <p id="selected-date-display"></p>
                    </div>
                    <div id="events-list-container">
                        <!-- Los eventos se cargarán aquí dinámicamente -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="showCreateEventFromSelector()">
                        <i class="fas fa-plus me-2"></i>Crear Nuevo Evento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>

    <script>
        let calendar;
        let eventModal;
        let eventSelectorModal;
        let selectedDatesInfo = null;
        let originalEventDates = null;
        let selectedDateForSelector = null;

        const colores = {
            'reunion-virtual': '#3b82f6',
            'reunion-presencial': '#10b981',
            'inicio-proyecto': '#f59e0b',
            'finalizar-proyecto': '#ef4444',
            'otros': '#8b5cf6'  // 🆕 Color para "Otros"
        };

        const iconosPorTipo = {
            'reunion-virtual': 'fa-video',
            'reunion-presencial': 'fa-users',
            'inicio-proyecto': 'fa-rocket',
            'finalizar-proyecto': 'fa-flag-checkered',
            'otros': 'fa-star'  // 🆕 Icono para "Otros"
        };

        $(document).ready(function() {
            initializeCalendar();
            initializeEventModal();
            initializeEventSelectorModal();
            cargarMiembros();
            initializeTituloValidation();
        });

        function initializeTituloValidation() {
            const tituloInput = $('#titulo');
            const validationMessage = $('#titulo-validation-message');
            
            tituloInput.on('input', function() {
                const value = $(this).val();
                
                if (tieneLetrasConsecutivasExcesivas(value)) {
                    $(this).addClass('is-invalid');
                    validationMessage.addClass('show');
                } else {
                    $(this).removeClass('is-invalid');
                    validationMessage.removeClass('show');
                }
            });
        }

        function tieneLetrasConsecutivasExcesivas(texto) {
            const patron = /(.)\1{3,}/i;
            return patron.test(texto);
        }

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                editable: true,
                selectable: false,
                selectMirror: false,
                dayMaxEvents: 2,
                height: '100%',
                
                events: function(info, successCallback, failureCallback) {
                    $.ajax({
                        url: '/api/calendario/eventos',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(eventos) {
                            successCallback(eventos);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al cargar eventos:', error);
                            showToast('Error al cargar eventos', 'error');
                            failureCallback(error);
                        }
                    });
                },
                
                dateClick: function(info) {
                    const eventosDelDia = calendar.getEvents().filter(event => {
                        const eventDate = new Date(event.start).toDateString();
                        const clickedDate = new Date(info.date).toDateString();
                        return eventDate === clickedDate;
                    });
                    
                    showEventSelector(info.date, eventosDelDia);
                },
                
                eventClick: function(info) {
                    info.jsEvent.stopPropagation();
                    
                    const eventosDelDia = calendar.getEvents().filter(event => {
                        const eventDate = new Date(event.start).toDateString();
                        const clickedDate = new Date(info.event.start).toDateString();
                        return eventDate === clickedDate;
                    });
                    
                    if (eventosDelDia.length > 1) {
                        showEventSelector(info.event.start, eventosDelDia);
                    } else {
                        editEvent(info);
                    }
                },
                
                moreLinkClick: function(info) {
                    info.jsEvent.stopPropagation();
                    showEventSelector(info.date, info.allSegs.map(seg => seg.event));
                    return 'popover';
                },
                
                eventDrop: function(info) {
                    updateEventDates(info);
                },
                
                eventResize: function(info) {
                    updateEventDates(info);
                },
                
                moreLinkText: function(num) {
                    return `+${num} más`;
                },
                
                eventContent: function(arg) {
                    const horaInicio = new Date(arg.event.start).toLocaleTimeString('es-ES', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    const horaFin = arg.event.end ? new Date(arg.event.end).toLocaleTimeString('es-ES', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    }) : '';
                    
                    const rangoHoras = horaFin ? `${horaInicio} - ${horaFin}` : horaInicio;
                    
                    return {
                        html: `
                            <div style="padding: 3px 5px; overflow: hidden; line-height: 1.2;">
                                <div style="font-weight: 600; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">
                                    ${arg.event.title}
                                </div>
                                <div style="font-size: 9px; opacity: 0.9; font-weight: 500;">
                                    ${rangoHoras}
                                </div>
                            </div>
                        `
                    };
                }
            });
            
            calendar.render();
        }

        function initializeEventModal() {
            eventModal = new bootstrap.Modal(document.getElementById('eventoModal'));
            
            $('#tipoEvento').change(function() {
                const selectedType = $(this).val();
                
                $('#virtualFields, #presencialFields, #proyectoFields, #otrosFields').hide();
                
                if (selectedType === 'reunion-virtual') {
                    $('#virtualFields').show();
                } else if (selectedType === 'reunion-presencial') {
                    $('#presencialFields').show();
                } else if (selectedType === 'inicio-proyecto' || selectedType === 'finalizar-proyecto') {
                    $('#proyectoFields').show();
                } else if (selectedType === 'otros') {  // 🆕 AGREGADO
                    $('#otrosFields').show();
                }
            });

            $('#eventoForm').submit(function(e) {
                e.preventDefault();
                saveEvent();
            });

            $('#eliminarBtn').click(function() {
                deleteEvent();
            });
        }

        function initializeEventSelectorModal() {
            eventSelectorModal = new bootstrap.Modal(document.getElementById('eventSelectorModal'));
        }

        function showEventSelector(date, eventos) {
            selectedDateForSelector = date;
            
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = date.toLocaleDateString('es-ES', options);
            const fechaCapitalizada = fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1);
            
            $('#selected-date-display').html(`
                ${fechaCapitalizada}
                <span class="date-badge">${eventos.length} evento${eventos.length !== 1 ? 's' : ''}</span>
            `);
            
            let eventosHTML = '';
            
            if (eventos.length === 0) {
                eventosHTML = `
                    <div class="no-events-message">
                        <i class="fas fa-calendar-times"></i>
                        <h5>No hay eventos programados</h5>
                        <p>Haz clic en "Crear Nuevo Evento" para agregar uno</p>
                    </div>
                `;
            } else {
                eventos.sort((a, b) => new Date(a.start) - new Date(b.start));
                
                eventos.forEach(evento => {
                    const props = evento.extendedProps || {};
                    const tipo = props.tipo_evento || 'reunion-virtual';
                    const estado = props.estado || 'programado';
                    const detalles = props.detalles || {};
                    
                    const horaInicio = new Date(evento.start);
                    const horaFin = evento.end ? new Date(evento.end) : new Date(horaInicio.getTime() + 60*60*1000);
                    const duracionMinutos = Math.round((horaFin - horaInicio) / 60000);
                    const duracionTexto = duracionMinutos >= 60 
                        ? `${Math.floor(duracionMinutos / 60)}h ${duracionMinutos % 60}m`
                        : `${duracionMinutos}m`;
                    
                    const horaInicioStr = horaInicio.toLocaleTimeString('es-ES', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    const horaFinStr = horaFin.toLocaleTimeString('es-ES', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    const tipoNombres = {
                        'reunion-virtual': 'Reunión Virtual',
                        'reunion-presencial': 'Reunión Presencial',
                        'inicio-proyecto': 'Inicio de Proyecto',
                        'finalizar-proyecto': 'Finalización de Proyecto',
                        'otros': 'Otros'  // 🆕 AGREGADO
                    };
                    
                    const estadoBadges = {
                        'programado': '<span class="event-badge badge-programado"><i class="fas fa-clock"></i> Programado</span>',
                        'en-curso': '<span class="event-badge badge-en-curso"><i class="fas fa-play-circle"></i> En Curso</span>',
                        'finalizado': '<span class="event-badge badge-finalizado"><i class="fas fa-check-circle"></i> Finalizado</span>'
                    };
                    
                    const organizador = detalles.organizador || 'Sin organizador';
                    const icono = iconosPorTipo[tipo] || 'fa-calendar';
                    
                    eventosHTML += `
                        <div class="event-list-item ${tipo}" onclick="selectEventFromList('${evento.id}')">
                            <div class="event-time">
                                <div class="time-range">
                                    <i class="fas fa-clock"></i>
                                    ${horaInicioStr} - ${horaFinStr}
                                </div>
                                <div class="duration">
                                    <i class="fas fa-hourglass-half"></i>
                                    ${duracionTexto}
                                </div>
                            </div>
                            <div class="event-info">
                                <div class="event-title">
                                    <div class="event-icon">
                                        <i class="fas ${icono}"></i>
                                    </div>
                                    ${evento.title}
                                </div>
                                <div class="event-details">
                                    <span><i class="fas fa-tag"></i> ${tipoNombres[tipo] || tipo}</span>
                                    <span><i class="fas fa-user"></i> ${organizador}</span>
                                    ${estadoBadges[estado] || ''}
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-chevron-right chevron-icon"></i>
                            </div>
                        </div>
                    `;
                });
            }
            
            $('#events-list-container').html(eventosHTML);
            eventSelectorModal.show();
        }

        function selectEventFromList(eventId) {
            const evento = calendar.getEventById(eventId);
            if (evento) {
                eventSelectorModal.hide();
                
                // Mostrar modal de detalles del evento
                setTimeout(() => {
                    mostrarDetallesEvento(evento);
                }, 300);
            }
        }

        // 🆕 NUEVA FUNCIÓN: Mostrar detalles del evento con opciones
        function mostrarDetallesEvento(evento) {
            const props = evento.extendedProps || {};
            const detalles = props.detalles || {};
            const tipo = props.tipo_evento || '';
            const estado = props.estado || 'programado';
            
            const fechaInicio = new Date(evento.start);
            const fechaFin = evento.end ? new Date(evento.end) : fechaInicio;
            
            const fechaFormateada = fechaInicio.toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            const horaInicio = fechaInicio.toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            const horaFin = fechaFin.toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            const tipoNombres = {
                'reunion-virtual': 'Reunión Virtual',
                'reunion-presencial': 'Reunión Presencial',
                'inicio-proyecto': 'Inicio de Proyecto',
                'finalizar-proyecto': 'Finalización de Proyecto',
                'otros': 'Otros'
            };
            
            const estadoNombres = {
                'programado': '🟡 Programado',
                'en-curso': '🔵 En Curso',
                'finalizado': '🟢 Finalizado'
            };
            
            let ubicacionHTML = '';
            
            // 🆕 ENLACE CLICKEABLE PARA REUNIÓN VIRTUAL
            if (tipo === 'reunion-virtual' && detalles.enlace) {
                ubicacionHTML = `
                    <div style="margin: 15px 0; padding: 15px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; text-align: center;">
                        <p style="margin: 0 0 10px 0; color: white; font-weight: 600; font-size: 14px;">
                            <i class="fas fa-video" style="margin-right: 8px;"></i>Enlace de Reunión Virtual
                        </p>
                        <a href="${detalles.enlace}" target="_blank" class="btn btn-light btn-sm" 
                           style="font-weight: 600; padding: 10px 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                            <i class="fas fa-external-link-alt me-2"></i>Unirse a la Reunión
                        </a>
                    </div>
                `;
            } else if (tipo === 'reunion-presencial' && detalles.lugar) {
                ubicacionHTML = `
                    <p style="margin: 10px 0;"><strong><i class="fas fa-map-marker-alt me-2"></i>Lugar:</strong> ${detalles.lugar}</p>
                `;
            } else if (detalles.ubicacion_proyecto) {
                ubicacionHTML = `
                    <p style="margin: 10px 0;"><strong><i class="fas fa-project-diagram me-2"></i>Ubicación del Proyecto:</strong> ${detalles.ubicacion_proyecto}</p>
                `;
            } else if (detalles.ubicacion_otros) {
                ubicacionHTML = `
                    <p style="margin: 10px 0;"><strong><i class="fas fa-info-circle me-2"></i>Ubicación:</strong> ${detalles.ubicacion_otros}</p>
                `;
            }
            
            Swal.fire({
                title: evento.title,
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                            <p style="margin: 5px 0;"><strong><i class="fas fa-calendar me-2"></i>Fecha:</strong> ${fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1)}</p>
                            <p style="margin: 5px 0;"><strong><i class="fas fa-clock me-2"></i>Horario:</strong> ${horaInicio} - ${horaFin}</p>
                            <p style="margin: 5px 0;"><strong><i class="fas fa-tag me-2"></i>Tipo:</strong> ${tipoNombres[tipo] || tipo}</p>
                            <p style="margin: 5px 0;"><strong><i class="fas fa-info-circle me-2"></i>Estado:</strong> ${estadoNombres[estado] || estado}</p>
                            <p style="margin: 5px 0;"><strong><i class="fas fa-user me-2"></i>Organizador:</strong> ${detalles.organizador || 'Sin asignar'}</p>
                        </div>
                        
                        ${ubicacionHTML}
                    </div>
                `,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-edit me-2"></i>Editar',
                denyButtonText: '<i class="fas fa-trash me-2"></i>Eliminar',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Cerrar',
                confirmButtonColor: '#3b82f6',
                denyButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                width: '600px',
                customClass: {
                    popup: 'animated-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Editar evento
                    editEvent({ event: evento });
                } else if (result.isDenied) {
                    // Eliminar evento
                    eliminarEventoDesdeDetalle(evento.id);
                }
            });
        }

        // 🆕 NUEVA FUNCIÓN: Eliminar evento desde modal de detalles
        function eliminarEventoDesdeDetalle(eventoId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/api/calendario/eventos/${eventoId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                calendar.refetchEvents();
                                showToast('Evento eliminado exitosamente', 'success');
                            } else {
                                showToast(response.mensaje || 'Error al eliminar el evento', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar evento:', error);
                            const mensaje = xhr.responseJSON?.mensaje || 'Error al eliminar el evento';
                            showToast(mensaje, 'error');
                        }
                    });
                }
            });
        }

        function showCreateEventFromSelector() {
            eventSelectorModal.hide();
            setTimeout(() => {
                const dateStr = selectedDateForSelector.toISOString().split('T')[0];
                showCreateEventModal({
                    startStr: dateStr + 'T09:00',
                    endStr: dateStr + 'T10:00'
                });
            }, 300);
        }

        function cargarMiembros() {
            $.ajax({
                url: '/api/calendario/miembros',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const select = $('#organizador_id');
                        select.empty();
                        select.append('<option value="">Seleccione un organizador...</option>');
                        
                        response.miembros.forEach(function(miembro) {
                            const nombreCompleto = `${miembro.Nombre} - ${miembro.Rol}`;
                            select.append(`<option value="${miembro.MiembroID}">${nombreCompleto}</option>`);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar miembros:', error);
                    showToast('Error al cargar la lista de miembros', 'error');
                }
            });
        }

        function showCreateEventModal(info = null) {
            $('#modal-title').text('Agregar Evento');
            $('#eventoForm')[0].reset();
            $('#eventoId').val('');
            $('#eliminarBtn').hide();
            $('#virtualFields, #presencialFields, #proyectoFields, #otrosFields').hide();
            
            $('#titulo').removeClass('is-invalid');
            $('#titulo-validation-message').removeClass('show');
            
            originalEventDates = null;
            $('#estado').val('programado');
            
            if (info) {
                selectedDatesInfo = info;
                $('#fecha_inicio').val(info.startStr.slice(0, 16));
                if (info.endStr) {
                    $('#fecha_fin').val(info.endStr.slice(0, 16));
                }
            }
            
            eventModal.show();
        }

        function editEvent(info) {
            $('#modal-title').text('Editar Evento');
            $('#eventoForm')[0].reset();
            $('#eliminarBtn').show();
            
            $('#titulo').removeClass('is-invalid');
            $('#titulo-validation-message').removeClass('show');
            
            $('#eventoId').val(info.event.id);
            $('#titulo').val(info.event.title);
            
            const fechaInicioOriginal = new Date(info.event.start).toISOString().slice(0, 16);
            const fechaFinOriginal = info.event.end ? new Date(info.event.end).toISOString().slice(0, 16) : fechaInicioOriginal;
            
            $('#fecha_inicio').val(fechaInicioOriginal);
            $('#fecha_fin').val(fechaFinOriginal);
            
            originalEventDates = {
                inicio: fechaInicioOriginal,
                fin: fechaFinOriginal
            };

            const props = info.event.extendedProps;
            
            if (props) {
                $('#tipoEvento').val(props.tipo_evento || '');
                $('#estado').val(props.estado || 'programado');
                $('#organizador_id').val(props.organizador_id || '');
            }
            
            $('#tipoEvento').trigger('change');
            
            const detalles = info.event.extendedProps.detalles;
            if (detalles) {
                $('#enlace').val(detalles.enlace || '');
                $('#lugar').val(detalles.lugar || '');
                $('#ubicacion_proyecto').val(detalles.ubicacion_proyecto || '');
                $('#ubicacion_otros').val(detalles.ubicacion_otros || '');  // 🆕 AGREGADO
            }
            
            eventModal.show();
        }

        function saveEvent() {
            const titulo = $('#titulo').val().trim();
            if (tieneLetrasConsecutivasExcesivas(titulo)) {
                $('#titulo').addClass('is-invalid');
                $('#titulo-validation-message').addClass('show');
                showToast('El título no puede tener la misma letra más de 3 veces consecutivas', 'error');
                return;
            }
            
            if (!titulo || !$('#organizador_id').val()) {
                showToast('Todos los campos obligatorios son requeridos', 'error');
                return;
            }
            
            if (!$('#fecha_inicio').val() || !$('#fecha_fin').val()) {
                showToast('Las fechas son obligatorias', 'error');
                return;
            }
            
            if (new Date($('#fecha_inicio').val()) >= new Date($('#fecha_fin').val())) {
                showToast('La fecha de fin debe ser posterior a la de inicio', 'error');
                return;
            }
            
            const id = $('#eventoId').val();
            const isEdit = Boolean(id);
            
            const tipo = $('#tipoEvento').val();
            const organizadorId = $('#organizador_id').val();
            const organizadorNombre = $('#organizador_id option:selected').text();

            let detalles = {
                organizador: organizadorNombre
            };
            
            if (tipo === 'reunion-virtual') {
                detalles.enlace = $('#enlace').val();
            } else if (tipo === 'reunion-presencial') {
                detalles.lugar = $('#lugar').val();
            } else if (tipo === 'inicio-proyecto' || tipo === 'finalizar-proyecto') {
                detalles.ubicacion_proyecto = $('#ubicacion_proyecto').val();
            } else if (tipo === 'otros') {  // 🆕 AGREGADO
                detalles.ubicacion_otros = $('#ubicacion_otros').val();
            }
            
            const eventData = {
                titulo: titulo,
                descripcion: titulo,
                tipo_evento: tipo,
                estado: $('#estado').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val(),
                organizador_id: organizadorId ? parseInt(organizadorId) : null,
                proyecto_id: null,
                detalles: detalles
            };
            
            const url = isEdit 
                ? `/api/calendario/eventos/${id}`
                : '/api/calendario/eventos';
            
            const method = isEdit ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(eventData),
                success: function(response) {
                    if (response.success) {
                        if (isEdit) {
                            const evento = calendar.getEventById(id);
                            if (evento) {
                                const fechaInicioActual = $('#fecha_inicio').val();
                                const fechaFinActual = $('#fecha_fin').val();
                                const fechasCambiaron = originalEventDates && 
                                    (fechaInicioActual !== originalEventDates.inicio || 
                                     fechaFinActual !== originalEventDates.fin);
                                
                                evento.setProp('title', titulo);
                                evento.setExtendedProp('tipo_evento', tipo);
                                evento.setExtendedProp('estado', $('#estado').val());
                                evento.setExtendedProp('organizador_id', organizadorId);
                                evento.setExtendedProp('detalles', detalles);
                                
                                const nuevoColor = colores[tipo] || '#3b82f6';
                                evento.setProp('backgroundColor', nuevoColor);
                                evento.setProp('borderColor', nuevoColor);
                                
                                if (fechasCambiaron) {
                                    evento.setStart(fechaInicioActual);
                                    evento.setEnd(fechaFinActual);
                                }
                            }
                        } else {
                            calendar.refetchEvents();
                        }
                        
                        eventModal.hide();
                        showToast(isEdit ? 'Evento actualizado exitosamente' : 'Evento creado exitosamente', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al guardar el evento', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar evento:', error);
                    const mensaje = xhr.responseJSON?.mensaje || 'Error al guardar el evento';
                    showToast(mensaje, 'error');
                }
            });
        }

        function deleteEvent() {
            const id = $('#eventoId').val();
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/api/calendario/eventos/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                calendar.refetchEvents();
                                eventModal.hide();
                                showToast('Evento eliminado exitosamente', 'success');
                            } else {
                                showToast(response.mensaje || 'Error al eliminar el evento', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al eliminar evento:', error);
                            const mensaje = xhr.responseJSON?.mensaje || 'Error al eliminar el evento';
                            showToast(mensaje, 'error');
                        }
                    });
                }
            });
        }

        function updateEventDates(info) {
            const eventData = {
                fecha_inicio: info.event.start.toISOString(),
                fecha_fin: info.event.end ? info.event.end.toISOString() : info.event.start.toISOString()
            };
            
            $.ajax({
                url: `/api/calendario/eventos/${info.event.id}/fechas`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify(eventData),
                success: function(response) {
                    if (response.success) {
                        showToast('Fechas actualizadas exitosamente', 'success');
                    } else {
                        showToast(response.mensaje || 'Error al actualizar fechas', 'error');
                        info.revert();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar fechas:', error);
                    const mensaje = xhr.responseJSON?.mensaje || 'Error al actualizar fechas';
                    showToast(mensaje, 'error');
                    info.revert();
                }
            });
        }

        function showToast(message, type = 'info') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>
</body>
</html>
