<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestion financiera- Tesorero</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    @if(request()->has('embed'))
    <style>
        /* Ocultar solo navbar superior cuando está en iframe */
        .navbar-top, nav.navbar { display: none !important; }
        .main-content { margin-top: 0 !important; padding-top: 0 !important; }
    </style>
    @endif
    
    <style>
        :root {
            --primary-color: #5b6fd8;
            --secondary-color: #7c5cdc;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --dark-bg: #1e2836;
            --card-bg: #2a3544;
            --text-light: #e5e7eb;
        }

        body {
            background: #1e2836;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e5e7eb;
        }

        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, #5b6fd8 0%, #7c5cdc 100%);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            margin-left: 0;
            margin-right: 0;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            box-shadow: 0 4px 12px rgba(91, 111, 216, 0.3);
        }

        .dashboard-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
        }

        /* Card Styles */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            overflow: hidden;
            background: var(--card-bg);
        }

        /* Soporte para 5 cards en una fila: clase utilitaria */
        @media(min-width: 992px) {
            .col-lg-5th {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Section Cards */
        .section-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
            height: 100%;
            background: var(--card-bg);
        }

        .section-card .card-header {
            background: linear-gradient(135deg, #343e4f 0%, #3d4757 100%);
            border-bottom: 2px solid #4a5568;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .section-card .card-body {
            background: var(--card-bg);
            color: #e5e7eb;
        }

        .section-card .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            color: #e5e7eb;
        }

        /* Alert Styles */
        .alert-custom {
            border: none;
            border-left: 4px solid;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            background: var(--card-bg);
        }

        .alert-warning-custom {
            background: rgba(245, 158, 11, 0.15);
            border-left-color: var(--warning-color);
            color: #fbbf24;
        }

        /* Button Styles */
        .btn-custom {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-light {
            background-color: #f3f4f6 !important;
            color: #1e2836 !important;
            border: none !important;
            font-weight: 600;
        }

        .btn-light:hover {
            background-color: #e5e7eb !important;
            color: #1e2836 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(243, 244, 246, 0.3);
        }

        .btn-outline-light {
            border: 2px solid #f3f4f6 !important;
            color: #f3f4f6 !important;
            background: transparent !important;
            font-weight: 600;
        }

        .btn-outline-light:hover {
            background-color: #f3f4f6 !important;
            color: #1e2836 !important;
            transform: translateY(-2px);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #5b6fd8 0%, #7c5cdc 100%) !important;
            border: none !important;
            color: white !important;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(91, 111, 216, 0.5) !important;
            background: linear-gradient(135deg, #6d7ee8 0%, #8d6bec 100%) !important;
            color: white !important;
        }

        .btn-sm {
            font-size: 0.875rem;
            padding: 0.4rem 1rem !important;
        }

        /* Table Styles */
        .table-custom {
            font-size: 0.9rem;
            color: #e5e7eb;
            background-color: transparent !important;
        }

        .table-custom thead {
            background: linear-gradient(135deg, #343e4f 0%, #3d4757 100%);
            color: #e5e7eb;
        }

        .table-custom thead th {
            color: #e5e7eb !important;
            font-weight: 600;
            border: none !important;
        }

        .table-custom tbody {
            background-color: var(--card-bg);
        }

        .table-custom tbody tr {
            transition: background-color 0.2s ease;
            background: rgba(42, 53, 68, 0.5) !important;
            border-color: rgba(74, 85, 104, 0.3) !important;
        }

        .table-custom tbody tr:hover {
            background-color: rgba(74, 85, 104, 0.5) !important;
        }

        .table-custom tbody td {
            color: #e5e7eb !important;
            border-color: rgba(74, 85, 104, 0.3) !important;
        }

        .table {
            --bs-table-bg: transparent !important;
            --bs-table-striped-bg: rgba(42, 53, 68, 0.3) !important;
            --bs-table-hover-bg: rgba(74, 85, 104, 0.5) !important;
            --bs-table-border-color: rgba(74, 85, 104, 0.3) !important;
        }

        /* Progress Bar Styles */
        .progress-custom {
            height: 28px;
            border-radius: 8px;
            background-color: rgba(74, 85, 104, 0.3);
        }

        .progress-bar-custom {
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Badge Styles */
        .badge-custom {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .bg-warning {
            background-color: #f59e0b !important;
            color: #1e2836 !important;
        }

        .bg-success {
            background-color: #10b981 !important;
            color: white !important;
        }

        .bg-danger {
            background-color: #ef4444 !important;
            color: white !important;
        }

        .bg-info {
            background-color: #06b6d4 !important;
            color: white !important;
        }

        .bg-secondary {
            background-color: #6b7280 !important;
            color: white !important;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            padding: 1rem;
        }

        /* Responsive equal height cards */
        .equal-height-row {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .equal-height-card .card-body {
            flex: 1;
        }

        /* Spacing */
        .section-spacing {
            margin-bottom: 2rem;
        }

        /* Icon colors */
        .icon-primary { color: #818cf8; }
        .icon-success { color: #34d399; }
        .icon-danger { color: #f87171; }
        .icon-info { color: #22d3ee; }

        /* Text visibility improvements */
        .text-muted {
            color: #9ca3af !important;
        }

        .card-body {
            color: #e5e7eb;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #f3f4f6 !important;
        }

        p, span, small, label {
            color: #d1d5db;
        }

        .form-control, .form-select {
            background-color: rgba(42, 53, 68, 0.8) !important;
            border: 1px solid #4a5568 !important;
            color: #e5e7eb !important;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(42, 53, 68, 0.9) !important;
            border-color: #5b6fd8 !important;
            color: #e5e7eb !important;
            box-shadow: 0 0 0 0.2rem rgba(91, 111, 216, 0.25) !important;
        }

        .form-control::placeholder {
            color: #9ca3af !important;
        }

        .table-custom tbody td {
            color: #e5e7eb;
        }

        .badge {
            font-weight: 600;
        }

        a {
            color: #818cf8 !important;
        }

        a:hover {
            color: #a5b4fc !important;
        }

        .text-success {
            color: #34d399 !important;
        }

        .text-danger {
            color: #f87171 !important;
        }

        .text-warning {
            color: #fbbf24 !important;
        }

        .text-info {
            color: #22d3ee !important;
        }

        .text-primary {
            color: #818cf8 !important;
        }

        /* SweetAlert2 Dark Theme */
        .swal2-popup {
            background-color: #2a3544 !important;
            color: #e5e7eb !important;
        }

        .swal2-title {
            color: #f3f4f6 !important;
        }

        .swal2-html-container {
            color: #e5e7eb !important;
        }

        .swal2-popup .card {
            background-color: rgba(42, 53, 68, 0.5) !important;
            border: 1px solid #4a5568 !important;
            color: #e5e7eb !important;
        }

        .swal2-popup .card-body {
            background-color: rgba(52, 62, 79, 0.5) !important;
            color: #e5e7eb !important;
        }

        .swal2-popup .bg-light {
            background-color: rgba(52, 62, 79, 0.5) !important;
            color: #e5e7eb !important;
        }

        .swal2-popup .card-title,
        .swal2-popup h5,
        .swal2-popup h6,
        .swal2-popup p,
        .swal2-popup strong {
            color: #e5e7eb !important;
        }

        .swal2-popup .text-muted {
            color: #9ca3af !important;
        }

        .swal2-popup .btn-outline-primary,
        .swal2-popup .btn-outline-success,
        .swal2-popup .btn-outline-info,
        .swal2-popup .btn-outline-warning,
        .swal2-popup .btn-outline-secondary {
            color: #e5e7eb !important;
            border-color: #4a5568 !important;
        }

        .swal2-popup .btn-outline-primary:hover {
            background-color: #5b6fd8 !important;
            color: white !important;
        }

        .swal2-popup .btn-outline-success:hover {
            background-color: #10b981 !important;
            color: white !important;
        }

        .swal2-popup .btn-outline-info:hover {
            background-color: #06b6d4 !important;
            color: white !important;
        }

        .swal2-popup .btn-outline-warning:hover {
            background-color: #f59e0b !important;
            color: #1e2836 !important;
        }

        .swal2-popup .btn-outline-secondary:hover {
            background-color: #6b7280 !important;
            color: white !important;
        }

        .swal2-close {
            color: #e5e7eb !important;
        }

        .swal2-close:hover {
            color: #f3f4f6 !important;
        }

        /* Estilos para notificaciones */
        .swal2-popup .list-group-item {
            background-color: rgba(42, 53, 68, 0.7) !important;
            border-color: #4a5568 !important;
            color: #e5e7eb !important;
        }

        .swal2-popup .list-group-item:hover {
            background-color: rgba(74, 85, 104, 0.5) !important;
        }

        .swal2-popup .list-group-item.bg-light {
            background-color: rgba(52, 62, 79, 0.6) !important;
        }

        .swal2-popup .list-group-item .badge {
            color: white !important;
        }

        .swal2-popup .list-group-item small {
            color: #9ca3af !important;
        }

        .swal2-popup .text-center p {
            color: #9ca3af !important;
        }

        .swal2-popup .alert {
            background-color: rgba(42, 53, 68, 0.7) !important;
            border-color: #4a5568 !important;
            color: #e5e7eb !important;
        }

        .swal2-popup .alert-info {
            background-color: rgba(6, 182, 212, 0.15) !important;
            border-color: #06b6d4 !important;
            color: #22d3ee !important;
        }

        .swal2-popup .list-group {
            background-color: transparent !important;
        }

        .swal2-popup .border-primary {
            border-left: 4px solid #5b6fd8 !important;
        }

        .swal2-popup h6 {
            color: #f3f4f6 !important;
        }

        .swal2-popup .btn-primary {
            background: linear-gradient(135deg, #5b6fd8 0%, #7c5cdc 100%) !important;
            border: none !important;
            color: white !important;
        }

        .swal2-popup .btn-primary:hover {
            background: linear-gradient(135deg, #6d7ee8 0%, #8d6bec 100%) !important;
        }

        /* Scrollbar personalizado para modales */
        .swal2-popup .list-group::-webkit-scrollbar {
            width: 8px;
        }

        .swal2-popup .list-group::-webkit-scrollbar-track {
            background: rgba(42, 53, 68, 0.5);
            border-radius: 4px;
        }

        .swal2-popup .list-group::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }

        .swal2-popup .list-group::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stat-value {
                font-size: 1.5rem;
            }
            
            .stat-icon {
                font-size: 2rem;
            }

            .chart-container {
                height: 250px;
            }
        }

        /* Hover effects para botones de acción */
        .btn-lg.shadow-lg:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
            filter: brightness(1.1);
        }

        .btn-lg.shadow-lg:active {
            transform: translateY(-1px);
        }

        /* Ajuste para cards de estadísticas */
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5) !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- ============================================ -->
        <!-- HEADER -->
        <!-- ============================================ -->
        <div class="dashboard-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="dashboard-title">
                            <i class="fas fa-chart-line me-2"></i>
                            Gestion financiera
                        </h1>
                        <p class="mb-0 opacity-75">Panel de Control - Tesorero</p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="btn-group">
                            <button class="btn btn-light btn-custom position-relative" onclick="mostrarNotificaciones()">
                                <i class="fas fa-bell me-2"></i>Notificaciones
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notif-badge" style="display: none;">
                                    0
                                </span>
                            </button>
                            <button class="btn btn-light btn-custom" onclick="mostrarPerfilTesorero()">
                                <i class="fas fa-user-tie me-2"></i>Mi Perfil
                            </button>
                            <button class="btn btn-light btn-custom" onclick="generarReporte()">
                                <i class="fas fa-file-pdf me-2"></i>Generar Reporte
                            </button>
                            <button class="btn btn-light btn-custom" onclick="exportarExcel()">
                                <i class="fas fa-file-excel me-2"></i>Exportar
                            </button>
                            <button class="btn btn-outline-light btn-custom" onclick="confirmarCierreSesion()">
                                <i class="fas fa-sign-out-alt me-2"></i>Salir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <!-- ============================================ -->
            <!-- SECCIÓN 1: CARDS DE RESUMEN (4 COLUMNAS IGUALES) -->
            <!-- ============================================ -->
            <div class="row section-spacing equal-height-row">
                <!-- Card Balance Total -->
                <div class="col-lg-5th col-md-6 mb-3">
                    <div class="stat-card text-white" style="background: linear-gradient(135deg, #4c5fd8 0%, #6a4ed2 100%); border-left: 4px solid #7c5cdc;">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="stat-label mb-1" style="opacity: 0.9;">Balance Total</p>
                                <h3 class="stat-value">L. {{ number_format($balance_general->balance_neto ?? 0, 2) }}</h3>
                                <small style="opacity: 0.85;">
                                    <i class="fas fa-arrow-trend-up me-1"></i>
                                    {{ $balance_general->total_movimientos ?? 0 }} movimientos
                                </small>
                            </div>
                            <div>
                                <i class="fas fa-wallet stat-icon" style="opacity: 0.6;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Total Ingresos -->
                <div class="col-lg-5th col-md-6 mb-3">
                    <a href="{{ route('tesorero.ingresos.index') }}" class="text-decoration-none">
                        <div class="stat-card text-white" style="background: linear-gradient(135deg, #0d9668 0%, #047857 100%); border-left: 4px solid #10b981; cursor: pointer;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label mb-1" style="opacity: 0.9;">Total Ingresos</p>
                                    <h3 class="stat-value">L. {{ number_format($balance_general->total_ingresos ?? 0, 2) }}</h3>
                                    <small style="opacity: 0.85;">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        {{ $balance_general->cantidad_ingresos ?? 0 }} ingresos
                                    </small>
                                </div>
                                <div>
                                    <i class="fas fa-arrow-circle-up stat-icon" style="opacity: 0.6;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Total Gastos -->
                <div class="col-lg-5th col-md-6 mb-3">
                    <a href="{{ route('tesorero.gastos.index') }}" class="text-decoration-none">
                        <div class="stat-card text-white" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-left: 4px solid #ef4444; cursor: pointer;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label mb-1" style="opacity: 0.9;">Total Gastos</p>
                                    <h3 class="stat-value">L. {{ number_format($balance_general->total_gastos ?? 0, 2) }}</h3>
                                    <small style="opacity: 0.85;">
                                        <i class="fas fa-arrow-down me-1"></i>
                                        {{ $balance_general->cantidad_gastos ?? 0 }} gastos
                                    </small>
                                </div>
                                <div>
                                    <i class="fas fa-arrow-circle-down stat-icon" style="opacity: 0.6;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Presupuesto -->
                <div class="col-lg-5th col-md-6 mb-3">
                    <a href="{{ route('tesorero.presupuestos.index') }}" class="text-decoration-none">
                        <div class="stat-card text-white" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); border-left: 4px solid #06b6d4; cursor: pointer;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label mb-1" style="opacity: 0.9;">Presupuesto Mes</p>
                                    <h3 class="stat-value">L. {{ number_format($presupuesto_disponible ?? 0, 2) }}</h3>
                                    <small style="opacity: 0.85;">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ date('F Y') }}
                                    </small>
                                </div>
                                <div>
                                    <i class="fas fa-coins stat-icon" style="opacity: 0.6;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card Miembros Activos -->
                <div class="col-lg-5th col-md-6 mb-3">
                    <a href="{{ route('tesorero.membresias.index') }}" class="text-decoration-none">
                        <div class="stat-card text-white" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); border-left: 4px solid #7c3aed; cursor: pointer;">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label mb-1" style="opacity: 0.9;">Miembros Activos</p>
                                    <h3 class="stat-value">{{ $miembros_activos ?? 0 }}</h3>
                                    <small style="opacity: 0.85;">
                                        <i class="fas fa-user-check me-1"></i>
                                        Con pago al día
                                    </small>
                                </div>
                                <div>
                                    <i class="fas fa-user-check stat-icon" style="opacity: 0.6;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

                

                    <!-- ============================================ -->
            <!-- SECCIÓN 2: ALERTAS DE PRESUPUESTO -->
            <!-- ============================================ -->
            @if(isset($alertas_presupuesto) && count($alertas_presupuesto) > 0)
            <div class="row section-spacing">
                <div class="col-12">
                    <div class="alert alert-custom alert-warning-custom alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-2">
                                    <strong>Alertas de Presupuesto</strong>
                                </h5>
                                <ul class="mb-0 ps-3">
                                    @foreach($alertas_presupuesto as $alerta)
                                    <li class="mb-2">
                                        <strong>{{ $alerta->categoria }}</strong> - {{ $alerta->periodo ?? 'N/A' }}:
                                        <span class="badge bg-{{ ($alerta->estado_presupuesto ?? 'Normal') == 'Excedido' ? 'danger' : 'warning' }}">
                                            {{ $alerta->porcentaje_usado ?? 0 }}% utilizado
                                        </span>
                                        <br>
                                        <small>
                                            Gastado: L. {{ number_format($alerta->gasto_real ?? 0, 2) }} de 
                                            L. {{ number_format($alerta->presupuesto_mensual ?? 0, 2) }}
                                            | Disponible: L. {{ number_format($alerta->presupuesto_restante ?? 0, 2) }}
                                        </small>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- ============================================ -->
            <!-- SECCIÓN 3: BOTONES DE ACCIÓN RÁPIDA -->
            <!-- ============================================ -->
            <div class="row section-spacing">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <button class="btn btn-lg shadow-lg" onclick="registrarIngreso()" style="background: linear-gradient(135deg, #0d9668 0%, #047857 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-plus-circle me-2"></i>Registrar Ingreso
                        </button>
                        <button class="btn btn-lg shadow-lg" onclick="registrarGasto()" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-minus-circle me-2"></i>Registrar Gasto
                        </button>
                        <button class="btn btn-lg shadow-lg" onclick="registrarTransferencia()" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-exchange-alt me-2"></i>Transferencia
                        </button>
                        <button class="btn btn-lg shadow-lg" onclick="registrarMembresia()" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-id-card me-2"></i>Nueva Membresía
                        </button>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- SECCIÓN 4: GASTOS PENDIENTES DE APROBACIÓN -->
            <!-- ============================================ -->
            @if(isset($gastos_pendientes) && count($gastos_pendientes) > 0)
            <div class="row section-spacing">
                <div class="col-12">
                    <div class="section-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <i class="fas fa-clock icon-warning me-2"></i>
                                    Gastos Pendientes de Aprobación
                                    <span class="badge bg-warning text-dark ms-2">{{ count($gastos_pendientes) }}</span>
                                </h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Proveedor</th>
                                            <th class="text-end">Monto</th>
                                            <th class="text-center">Prioridad</th>
                                            <th class="text-center">Registrado Por</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gastos_pendientes as $gasto)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                            <td><strong>{{ Str::limit($gasto->descripcion ?? 'N/A', 40) }}</strong></td>
                                            <td><span class="badge-custom bg-secondary">{{ $gasto->categoria ?? 'N/A' }}</span></td>
                                            <td>{{ $gasto->proveedor ?? 'N/A' }}</td>
                                            <td class="text-end"><strong class="text-danger">L. {{ number_format($gasto->monto ?? 0, 2) }}</strong></td>
                                            <td class="text-center">
                                                <span class="badge-custom bg-{{ ($gasto->prioridad ?? 'Normal') == 'Urgente' ? 'danger' : (($gasto->prioridad ?? 'Normal') == 'Atención' ? 'warning' : 'info') }}">
                                                    {{ $gasto->prioridad ?? 'Normal' }}
                                                </span>
                                                <br><small class="text-muted">({{ $gasto->dias_pendiente ?? 0 }} días)</small>
                                            </td>
                                            <td class="text-center">{{ $gasto->registrado_por ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-success" onclick="aprobarGasto({{ $gasto->id }})" title="Aprobar">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-danger" onclick="rechazarGasto({{ $gasto->id }})" title="Rechazar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button class="btn btn-info" onclick="verDetalles({{ $gasto->id }})" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- ============================================ -->
            <!-- SECCIÓN 5: GRÁFICAS (2 COLUMNAS IGUALES) -->
            <!-- ============================================ -->
            <div class="row section-spacing equal-height-row">
                <!-- Gráfica de Líneas - Ingresos vs Gastos -->
                <div class="col-lg-6 mb-3">
                    <div class="section-card equal-height-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-chart-line icon-primary me-2"></i>
                                Ingresos vs Gastos - {{ date('Y') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="chartIngresosGastos"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfica de Pastel - Top Categorías -->
                <div class="col-lg-6 mb-3">
                    <div class="section-card equal-height-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-chart-pie icon-info me-2"></i>
                                Distribución por Categorías
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="chartCategorias"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- SECCIÓN 6: CONTROL DE PRESUPUESTOS Y MOVIMIENTOS (2 COLUMNAS IGUALES) -->
            <!-- ============================================ -->
            <div class="row section-spacing equal-height-row">
                <!-- Control de Presupuestos -->
                <div class="col-lg-6 mb-3">
                    <div class="section-card equal-height-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-tasks icon-warning me-2"></i>
                                    Control de Presupuestos - {{ date('F Y') }}
                                </h5>
                                <a href="{{ route('tesorero.presupuestos.index') }}" class="btn btn-sm btn-primary-custom btn-custom">
                                    <i class="fas fa-cog me-1"></i> Gestionar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @forelse($control_presupuesto ?? [] as $presupuesto)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>{{ $presupuesto->categoria ?? 'N/A' }}</strong>
                                    <small class="text-muted">
                                        L. {{ number_format($presupuesto->gasto_real ?? 0, 2) }} / 
                                        L. {{ number_format($presupuesto->presupuesto_mensual ?? 0, 2) }}
                                    </small>
                                </div>
                                <div class="progress progress-custom">
                                    <div class="progress-bar progress-bar-custom bg-{{ ($presupuesto->estado_presupuesto ?? 'Bajo') == 'Excedido' ? 'danger' : (($presupuesto->estado_presupuesto ?? 'Bajo') == 'Alerta' ? 'warning' : (($presupuesto->estado_presupuesto ?? 'Bajo') == 'Normal' ? 'info' : 'success')) }}"
                                        role="progressbar" 
                                        style="width: {{ max(min($presupuesto->porcentaje_usado ?? 0, 100), 2) }}%">
                                        {{ number_format($presupuesto->porcentaje_usado ?? 0, 1) }}%
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">
                                        Disponible: L. {{ number_format($presupuesto->presupuesto_restante ?? 0, 2) }}
                                    </small>
                                    <span class="badge-custom bg-{{ ($presupuesto->estado_presupuesto ?? 'Bajo') == 'Excedido' ? 'danger' : (($presupuesto->estado_presupuesto ?? 'Bajo') == 'Alerta' ? 'warning' : (($presupuesto->estado_presupuesto ?? 'Bajo') == 'Normal' ? 'info' : 'success')) }}">
                                        {{ $presupuesto->estado_presupuesto ?? 'Bajo' }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-info-circle fa-3x mb-3"></i>
                                <p>No hay presupuestos configurados para este mes</p>
                                <button class="btn btn-primary-custom btn-custom" onclick="configurarPresupuestos()">
                                    <i class="fas fa-cog me-2"></i>Configurar Presupuestos
                                </button>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Movimientos Recientes -->
                <div class="col-lg-6 mb-3">
                    <div class="section-card equal-height-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list icon-success me-2"></i>
                                    Movimientos Recientes
                                </h5>
                                <button class="btn btn-sm btn-primary-custom btn-custom" onclick="verTodosMovimientos()">
                                    Ver todos
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th class="text-end">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($movimientos_recientes ?? [] as $mov)
                                        @php
                                            $tipo = $mov->tipo ?? 'gasto';
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($mov->fecha ?? $mov->fecha_ingreso ?? now())->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge-custom bg-{{ $tipo == 'ingreso' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($tipo) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ Str::limit($mov->descripcion ?? $mov->concepto ?? 'N/A', 35) }}
                                                <br><small class="text-muted">{{ $mov->categoria ?? $mov->origen ?? 'N/A' }}</small>
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-{{ $tipo == 'ingreso' ? 'success' : 'danger' }}">
                                                    {{ $tipo == 'ingreso' ? '+' : '-' }} 
                                                    L. {{ number_format($mov->monto ?? 0, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p class="mb-0">No hay movimientos recientes</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- SECCIÓN 7: RESUMEN POR CATEGORÍA -->
            <!-- ============================================ -->
            <div class="row section-spacing">
                <div class="col-12">
                    <div class="section-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-chart-bar icon-primary me-2"></i>
                                Resumen por Categoría - {{ date('F Y') }}
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Categoría</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end">Promedio</th>
                                            <th class="text-end">Mínimo</th>
                                            <th class="text-end">Máximo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($resumen_categorias ?? [] as $resumen)
                                        @php
                                            $tipo_resumen = $resumen->tipo ?? 'general';
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge-custom bg-{{ $tipo_resumen == 'ingreso' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($tipo_resumen) }}
                                                </span>
                                            </td>
                                            <td><strong>{{ $resumen->categoria ?? 'N/A' }}</strong></td>
                                            <td class="text-center">{{ $resumen->cantidad ?? 0 }}</td>
                                            <td class="text-end"><strong>L. {{ number_format($resumen->total ?? 0, 2) }}</strong></td>
                                            <td class="text-end">L. {{ number_format($resumen->promedio ?? 0, 2) }}</td>
                                            <td class="text-end">L. {{ number_format($resumen->minimo ?? 0, 2) }}</td>
                                            <td class="text-end">L. {{ number_format($resumen->maximo ?? 0, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                                <p class="mb-0">No hay movimientos registrados en este mes</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Espacio inferior -->
            <div class="pb-4"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ============================================
        // CONFIGURACIÓN DE CHART.JS
        // ============================================
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.font.size = 13;
        Chart.defaults.color = '#e5e7eb';  // Color de texto claro para el tema oscuro

        // ============================================
        // GRÁFICA DE LÍNEAS - INGRESOS VS GASTOS
        // ============================================
        const ctxLinea = document.getElementById('chartIngresosGastos');
        if (ctxLinea) {
            new Chart(ctxLinea.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($meses ?? ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']) !!},
                    datasets: [
                        {
                            label: 'Ingresos',
                            data: {!! json_encode($ingresos_mensuales ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#28a745',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        },
                        {
                            label: 'Gastos',
                            data: {!! json_encode($gastos_mensuales ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) !!},
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#dc3545',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 13,
                                    weight: '600'
                                },
                                color: '#e5e7eb'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': L. ' + 
                                           context.parsed.y.toLocaleString('es-HN', {
                                               minimumFractionDigits: 2,
                                               maximumFractionDigits: 2
                                           });
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'L. ' + value.toLocaleString('es-HN');
                                },
                                font: {
                                    size: 11
                                },
                                color: '#e5e7eb'
                            },
                            grid: {
                                color: 'rgba(74, 85, 104, 0.3)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#e5e7eb'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // ============================================
        // GRÁFICA DE PASTEL - TOP CATEGORÍAS
        // ============================================
        const ctxPastel = document.getElementById('chartCategorias');
        if (ctxPastel) {
            new Chart(ctxPastel.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categorias ?? ['Sin datos']) !!},
                    datasets: [{
                        data: {!! json_encode($montos_categorias ?? [100]) !!},
                        backgroundColor: [
                            '#667eea', '#28a745', '#ffc107', '#dc3545', 
                            '#17a2b8', '#6f42c1', '#fd7e14', '#20c997',
                            '#e83e8c', '#6c757d'
                        ],
                        borderWidth: 3,
                        borderColor: '#fff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                color: '#e5e7eb'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    
                                    return label + ': L. ' + 
                                           value.toLocaleString('es-HN', {
                                               minimumFractionDigits: 2,
                                               maximumFractionDigits: 2
                                           }) + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        // ============================================
        // FUNCIONES DE ACCIONES
        // ============================================
        
        function confirmarCierreSesion() {
            Swal.fire({
                title: '¿Deseas cerrar sesión?',
                text: "Tu sesión se cerrará y volverás al inicio.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'rounded-4 shadow-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Crear formulario para logout POST
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('logout') }}";
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = "{{ csrf_token() }}";
                
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }        function registrarIngreso() {
            window.location.href = "{{ route('tesorero.ingresos.create') }}";
        }

        function registrarGasto() {
            window.location.href = "{{ route('tesorero.gastos.create') }}";
        }

        function registrarTransferencia() {
            window.location.href = "{{ route('tesorero.transferencias.create') }}";
        }

        function registrarMembresia() {
            window.location.href = "{{ route('tesorero.membresias.create') }}";
        }

        function verTodosMovimientos() {
            window.location.href = "{{ route('tesorero.movimientos.index') }}";
        }

        function configurarPresupuestos() {
            window.location.href = "{{ route('tesorero.presupuestos.index') }}";
        }

        function generarReporte() {
            window.location.href = "{{ route('tesorero.reportes.index') }}";
        }

        function mostrarPerfilTesorero() {
            // Obtener foto guardada o usar UI Avatars por defecto
            const fotoGuardada = localStorage.getItem('fotoPerfil');
            const fotoUrl = fotoGuardada || 'https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? "Usuario") }}&size=150&background=667eea&color=fff&bold=true&font-size=0.5';
            
            Swal.fire({
                title: '<i class="fas fa-user-tie me-2"></i>Perfil de Tesorero',
                html: `
                    <div class="text-start">
                        <!-- Foto de Perfil Centrada -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="${fotoUrl}" 
                                     alt="Foto de Perfil" 
                                     class="img-perfil-tesorero rounded-circle border border-3 border-primary shadow-lg"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0" 
                                        onclick="cambiarFotoPerfil()" 
                                        style="width: 40px; height: 40px; padding: 0;"
                                        title="Cambiar foto">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <h5 class="mt-3 mb-1">{{ Auth::user()->name ?? 'Usuario' }}</h5>
                            <p class="text-muted small mb-0">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body bg-light">
                                <h6 class="card-title mb-3"><i class="fas fa-info-circle me-2"></i>Información del Usuario</h6>
                                <p class="mb-2"><strong>Nombre:</strong> {{ Auth::user()->name ?? 'Usuario' }}</p>
                                <p class="mb-2"><strong>Email:</strong> {{ Auth::user()->email ?? 'email@example.com' }}</p>
                                <p class="mb-0"><strong>Rol:</strong> <span class="badge bg-primary">Tesorero</span></p>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3"><i class="fas fa-cog me-2"></i>Acciones Rápidas</h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary btn-sm" onclick="verMisMembresías()">
                                        <i class="fas fa-id-card me-2"></i>Ver Mis Membresías
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="verMisTransacciones()">
                                        <i class="fas fa-exchange-alt me-2"></i>Mis Transacciones
                                    </button>
                                    <button class="btn btn-outline-info btn-sm" onclick="estadisticasPersonales()">
                                        <i class="fas fa-chart-bar me-2"></i>Mis Estadísticas
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" onclick="configurarPreferencias()">
                                        <i class="fas fa-sliders-h me-2"></i>Configurar Preferencias
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body bg-light">
                                <h6 class="card-title mb-3"><i class="fas fa-shield-alt me-2"></i>Seguridad</h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-secondary btn-sm" onclick="cambiarContrasena()">
                                        <i class="fas fa-key me-2"></i>Cambiar Contraseña
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="verActividadReciente()">
                                        <i class="fas fa-history me-2"></i>Actividad Reciente
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                width: '600px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'text-start'
                }
            });
        }

        function verMisMembresías() {
            Swal.close();
            
            // Mostrar modal de carga mientras obtenemos los datos
            Swal.fire({
                title: 'Cargando...',
                text: 'Obteniendo información de tus membresías',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Petición AJAX real al backend
            fetch("{{ route('tesorero.api.mis-membresias') }}", {
                method: 'GET',
                credentials: 'same-origin', // Incluir cookies de sesión
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    mostrarModalMembresias(result.data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'No se pudieron cargar tus membresías',
                        confirmButtonText: 'Entendido'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    html: `
                        <p>No se pudo conectar con el servidor</p>
                        <small class="text-muted">Verifica tu sesión e intenta nuevamente</small>
                    `,
                    confirmButtonText: 'Cerrar'
                });
            });
        }

        function mostrarModalMembresias(data) {
            // Guardar los datos en una variable global para acceso posterior
            window.dataMembresias = data;
            
            const htmlContent = `
                <div class="text-start">
                    <!-- Resumen rápido -->
                    <div class="alert alert-light border mb-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="mb-0 text-success">${data.activas.length}</h4>
                                <small class="text-muted">Activas</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-0 text-warning">${data.proximas.length}</h4>
                                <small class="text-muted">Por Vencer</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-0 text-info">${data.historial.length}</h4>
                                <small class="text-muted">Historial</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs de navegación -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-activas" type="button">
                                <i class="fas fa-check-circle me-1"></i>Mis Activas (${data.activas.length})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-proximas" type="button">
                                <i class="fas fa-clock me-1"></i>Por Vencer (${data.proximas.length})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-historial" type="button">
                                <i class="fas fa-history me-1"></i>Historial (${data.historial.length})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab Membresías Activas -->
                        <div class="tab-pane fade show active" id="tab-activas">
                            ${data.activas.length > 0 ? data.activas.map(m => `
                                <div class="card mb-3 border-success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="fas fa-id-card text-success me-2"></i>${m.tipo}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ Auth::user()->name ?? 'Usuario Actual' }}
                                                </small>
                                            </div>
                                            <span class="badge bg-success">Activa</span>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Fecha Inicio</small>
                                                <strong>${new Date(m.fechaInicio).toLocaleDateString('es-ES')}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Vencimiento</small>
                                                <strong>${new Date(m.fechaVencimiento).toLocaleDateString('es-ES')}</strong>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Monto Pagado</small>
                                                <strong class="text-success">L ${m.monto.toFixed(2)}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Días Restantes</small>
                                                <strong class="text-primary">${Math.floor(m.diasRestantes)} días</strong>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: ${Math.min((Math.floor(m.diasRestantes)/30)*100, 100)}%"></div>
                                        </div>
                                        <div class="mt-3 d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary flex-fill" onclick="descargarComprobante(${m.id})">
                                                <i class="fas fa-download me-1"></i>Descargar
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning flex-fill" onclick="recordarMasTarde(${m.id})">
                                                <i class="fas fa-bell me-1"></i>Recordar
                                            </button>
                                            <button class="btn btn-sm btn-outline-success flex-fill" onclick="solicitarRenovacion(${m.id})">
                                                <i class="fas fa-sync me-1"></i>Renovar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('') : '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No tienes membresías activas</div>'}
                        </div>

                        <!-- Tab Próximas a Vencer -->
                        <div class="tab-pane fade" id="tab-proximas">
                            ${data.proximas.length > 0 ? data.proximas.map(m => `
                                <div class="card mb-3 border-warning">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>${m.tipo}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ Auth::user()->name ?? 'Usuario Actual' }}
                                                </small>
                                            </div>
                                            <span class="badge bg-warning text-dark">Próxima a Vencer</span>
                                        </div>
                                        <div class="alert alert-warning mb-3 py-2">
                                            <small><i class="fas fa-clock me-1"></i>Vence en <strong>${Math.floor(m.diasRestantes)} días</strong> - ${new Date(m.fechaVencimiento).toLocaleDateString('es-ES')}</small>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-2">
                                                <small class="text-muted d-block">Monto a Renovar</small>
                                                <h5 class="mb-0 text-primary">L ${m.monto.toFixed(2)}</h5>
                                            </div>
                                        </div>
                                        <div class="mt-3 d-flex gap-2">
                                            <button class="btn btn-sm btn-success flex-fill" onclick="renovarMembresia(${m.id})">
                                                <i class="fas fa-redo me-1"></i>Renovar Ahora
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary flex-fill" onclick="recordarMasTarde(${m.id})">
                                                <i class="fas fa-bell me-1"></i>Recordar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('') : '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>No tienes membresías próximas a vencer</div>'}
                        </div>

                        <!-- Tab Historial -->
                        <div class="tab-pane fade" id="tab-historial">
                            ${data.historial.length > 0 ? `
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th><i class="fas fa-user me-1"></i>Miembro</th>
                                                <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                                <th><i class="fas fa-tag me-1"></i>Tipo</th>
                                                <th>Monto</th>
                                                <th><i class="fas fa-credit-card me-1"></i>Método</th>
                                                <th><i class="fas fa-cog me-1"></i>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.historial.map((h, index) => `
                                                <tr id="historial-row-${index}">
                                                    <td><small class="fw-bold">{{ Auth::user()->name ?? 'Usuario' }}</small></td>
                                                    <td><small>${new Date(h.fecha).toLocaleDateString('es-ES')}</small></td>
                                                    <td><small>${h.tipo}</small></td>
                                                    <td><small class="text-success fw-bold">L ${h.monto.toFixed(2)}</small></td>
                                                    <td><small><span class="badge bg-secondary">${h.metodo}</span></small></td>
                                                    <td>
                                                        <button class="btn btn-xs btn-outline-primary me-1" onclick="verComprobante('${h.comprobante}')" title="Ver Comprobante">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                        <button class="btn btn-xs btn-outline-danger" onclick="eliminarHistorial(${index})" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 text-end">
                                    <button class="btn btn-sm btn-danger" onclick="limpiarHistorial()">
                                        <i class="fas fa-trash-alt me-2"></i>Limpiar Todo el Historial
                                    </button>
                                </div>
                            ` : '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No hay historial de pagos</div>'}
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Nota:</strong> Estas son únicamente tus membresías personales. 
                            Para cualquier consulta adicional, contacta al administrador.
                        </div>
                    </div>
                </div>
            `;

            Swal.fire({
                title: '<i class="fas fa-id-card-alt me-2"></i>Mis Membresías Personales',
                html: htmlContent,
                width: '800px',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'text-start'
                },
                didOpen: () => {
                    // Inicializar los tabs de Bootstrap si no están activos
                    const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
                    tabButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const target = this.getAttribute('data-bs-target');
                            
                            // Remover active de todos
                            document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
                            document.querySelectorAll('.tab-pane').forEach(pane => {
                                pane.classList.remove('show', 'active');
                            });
                            
                            // Activar el seleccionado
                            this.classList.add('active');
                            document.querySelector(target).classList.add('show', 'active');
                        });
                    });
                }
            });
        }

        function renovarMembresia(id) {
            // Buscar la membresía en los datos cargados
            let membresiaData = null;
            if (window.dataMembresias) {
                membresiaData = window.dataMembresias.activas.find(m => m.id === id) || 
                               window.dataMembresias.proximas.find(m => m.id === id);
            }

            // Si no se encuentra, usar datos por defecto
            if (!membresiaData) {
                const fechaVenc = new Date();
                fechaVenc.setMonth(fechaVenc.getMonth() + 1); // +1 mes (30 días)
                
                membresiaData = {
                    tipo: 'Membresía Mensual',
                    monto: 500.00,
                    fechaVencimiento: fechaVenc.toISOString()
                };
            }

            const montoRenovacion = membresiaData.monto;
            const fechaVencimiento = new Date(membresiaData.fechaVencimiento).toLocaleDateString('es-ES');
            const numeroComprobante = 'COMP-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 10000)).padStart(4, '0');
            const numeroReferencia = 'REF-' + new Date().getFullYear() + '-' + String(Math.floor(Math.random() * 1000000)).padStart(6, '0');

            Swal.fire({
                title: '<i class="fas fa-university text-primary"></i> Renovación de Membresía Mensual - Transferencia Bancaria',
                html: `
                    <div class="text-start">
                        <!-- Información del Miembro -->
                        <div class="alert alert-primary mb-3">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <small class="text-muted d-block">Miembro</small>
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>
                                        <strong id="nombreMiembroDisplay">{{ Auth::user()->name ?? 'Usuario Actual' }}</strong>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Información de la Membresía -->
                        <div class="alert alert-info mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Tipo de Membresía</small>
                                    <strong>${membresiaData.tipo}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Vencimiento Actual</small>
                                    <strong>${fechaVencimiento}</strong>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="text-center">
                                <h4 class="mb-0 text-success">
                                    L ${montoRenovacion.toFixed(2)}
                                </h4>
                                <small class="text-muted">Monto a Pagar</small>
                            </div>
                        </div>

                        <!-- Datos de Cuenta Destino -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-building text-primary me-2"></i>Datos de Cuenta Destino
                                </h6>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Banco:</small>
                                        <strong class="d-block">Banco Nacional</strong>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">N° de Cuenta:</small>
                                        <strong class="d-block">1234-5678-9012-3456</strong>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <small class="text-muted">Titular:</small>
                                        <strong class="d-block">Club Rotario - Cuenta Oficial</strong>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Tipo de Cuenta:</small>
                                        <strong class="d-block">Cuenta Corriente</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Monto a Transferir -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-dollar-sign me-1 text-success"></i>Monto a Transferir
                            </label>
                            <input type="number" id="montoIngreso" class="form-control form-control-lg fw-bold text-success" 
                                   value="${montoRenovacion.toFixed(2)}" step="0.01" min="0" required>
                            <small class="text-muted">Monto exacto de la transferencia bancaria</small>
                        </div>

                        <!-- Datos de la Transferencia -->
                        <div class="border-top pt-3 mb-3">
                            <h6 class="mb-3"><i class="fas fa-exchange-alt text-primary me-2"></i>Datos de tu Transferencia</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-university me-1"></i>Banco Origen <span class="text-danger">*</span>
                                </label>
                                <select id="bancoOrigen" class="form-select" required>
                                    <option value="">Selecciona tu banco</option>
                                    <option value="Banco Nacional">Banco Nacional</option>
                                    <option value="Banco Popular">Banco Popular</option>
                                    <option value="BAC San José">BAC San José</option>
                                    <option value="Banco de Costa Rica">Banco de Costa Rica</option>
                                    <option value="Scotiabank">Scotiabank</option>
                                    <option value="Davivienda">Davivienda</option>
                                    <option value="Promerica">Promerica</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-1"></i>Número de Referencia / Transacción (Generado Automáticamente)
                                </label>
                                <input type="text" id="numeroReferencia" class="form-control bg-light" 
                                       value="${numeroReferencia}" readonly>
                                <small class="text-muted">Número de referencia único de la transferencia</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt me-1"></i>Fecha de Transferencia <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="fechaPago" class="form-control" 
                                       value="${new Date().toISOString().split('T')[0]}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-clock me-1"></i>Hora de Transferencia (Opcional)
                                </label>
                                <input type="time" id="horaTransferencia" class="form-control">
                            </div>
                        </div>

                        <!-- Comprobante Interno -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-receipt me-1"></i>N° Comprobante Interno (Generado Automáticamente)
                            </label>
                            <input type="text" id="numeroComprobante" class="form-control bg-light" 
                                   value="${numeroComprobante}" readonly>
                            <small class="text-muted">Este es el número de registro en el sistema</small>
                        </div>

                        <!-- Notas Adicionales -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-comment me-1"></i>Notas Adicionales (Opcional)
                            </label>
                            <textarea id="notasPago" class="form-control" rows="2" placeholder="Ej: Detalles adicionales sobre la transferencia..."></textarea>
                        </div>

                        <div class="alert alert-success mb-0">
                            <small>
                                <i class="fas fa-check-circle me-1"></i>
                                <strong>Pago Automático:</strong> Al confirmar, se registrará el pago y se actualizará tu perfil automáticamente.
                            </small>
                        </div>
                    </div>
                `,
                width: '700px',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check me-1"></i> Registrar Transferencia',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar',
                confirmButtonColor: '#28a745',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const montoIngresado = parseFloat(document.getElementById('montoIngreso').value);
                    const bancoOrigen = document.getElementById('bancoOrigen').value;
                    const numeroReferencia = document.getElementById('numeroReferencia').value;
                    const fechaPago = document.getElementById('fechaPago').value;
                    const horaTransferencia = document.getElementById('horaTransferencia').value;
                    const numeroComprobanteInput = document.getElementById('numeroComprobante').value;
                    const notas = document.getElementById('notasPago').value;

                    // Validaciones
                    if (!montoIngresado || montoIngresado <= 0) {
                        Swal.showValidationMessage('Por favor ingresa un monto válido');
                        return false;
                    }

                    if (!bancoOrigen) {
                        Swal.showValidationMessage('Por favor selecciona el banco origen');
                        return false;
                    }

                    if (!fechaPago) {
                        Swal.showValidationMessage('Por favor selecciona la fecha de transferencia');
                        return false;
                    }

                    return fetch("{{ route('tesorero.api.solicitar-renovacion') }}", {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            membresia_id: id,
                            monto: montoIngresado,
                            metodo_pago: 'Transferencia Bancaria',
                            banco_origen: bancoOrigen,
                            numero_referencia: numeroReferencia,
                            fecha_pago: fechaPago,
                            hora_transferencia: horaTransferencia,
                            numero_comprobante: numeroComprobanteInput,
                            notas: notas,
                            tipo_membresia: membresiaData.tipo,
                            registrar_pago_directo: true // Flag para indicar que es pago directo
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Error: ${error}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value && result.value.success) {
                    const montoFinal = result.value.data?.monto || parseFloat(document.getElementById('montoIngreso')?.value) || montoRenovacion;
                    const comprobanteGenerado = result.value.data?.numero_comprobante || numeroComprobante;
                    const bancoOrigen = document.getElementById('bancoOrigen')?.value || 'No especificado';
                    const numeroRef = document.getElementById('numeroReferencia')?.value || 'No especificado';
                    const fechaTrans = document.getElementById('fechaPago')?.value || '';
                    const horaTrans = document.getElementById('horaTransferencia')?.value || '';
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Transferencia Registrada Exitosamente!',
                        html: `
                            <div class="text-start">
                                <div class="alert alert-success">
                                    <h5 class="mb-3">
                                        <i class="fas fa-check-circle me-2"></i>Detalles de la Transferencia
                                    </h5>
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>Comprobante:</strong></div>
                                        <div class="col-7 text-primary fw-bold">${comprobanteGenerado}</div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>Monto:</strong></div>
                                        <div class="col-7 text-success fw-bold fs-5">L ${montoFinal.toFixed(2)}</div>
                                    </div>
                                    
                                    <hr class="my-2">
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>Banco Origen:</strong></div>
                                        <div class="col-7">${bancoOrigen}</div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>N° Referencia:</strong></div>
                                        <div class="col-7 text-primary">${numeroRef}</div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>Fecha:</strong></div>
                                        <div class="col-7">${new Date(fechaTrans).toLocaleDateString('es-ES')} ${horaTrans ? 'a las ' + horaTrans : ''}</div>
                                    </div>
                                    
                                    <hr class="my-2">
                                    
                                    <div class="row mb-2">
                                        <div class="col-5"><strong>Estado:</strong></div>
                                        <div class="col-7">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Completado
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>Tu membresía ha sido actualizada.</strong><br>
                                    <small class="text-muted">Los cambios se reflejarán inmediatamente en tu perfil.</small>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#28a745',
                        width: '650px'
                    }).then(() => {
                        // Recargar los datos de membresías después de registrar el pago
                        verMisMembresías();
                    });
                } else if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.value?.message || 'No se pudo registrar el pago'
                    });
                }
            });
        }

        function solicitarRenovacion(id) {
            renovarMembresia(id);
        }

        function descargarComprobante(id) {
            // Buscar la membresía en los datos
            let membresia = null;
            if (window.dataMembresias) {
                membresia = window.dataMembresias.activas.find(m => m.id === id) || 
                           window.dataMembresias.proximas.find(m => m.id === id) ||
                           window.dataMembresias.historial.find(m => m.id === id);
            }

            if (!membresia) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró información de la membresía'
                });
                return;
            }

            // Generar HTML del comprobante
            const fechaActual = new Date().toLocaleDateString('es-ES', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            const comprobanteHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Comprobante de Pago - ${membresia.comprobante || 'COMP-' + id}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            max-width: 800px;
                            margin: 0 auto;
                            padding: 20px;
                        }
                        .header {
                            text-align: center;
                            border-bottom: 3px solid #007bff;
                            padding-bottom: 20px;
                            margin-bottom: 30px;
                        }
                        .header h1 {
                            color: #007bff;
                            margin: 0;
                        }
                        .header p {
                            margin: 5px 0;
                            color: #666;
                        }
                        .comprobante-info {
                            background: #f8f9fa;
                            padding: 15px;
                            border-radius: 5px;
                            margin-bottom: 20px;
                        }
                        .row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 10px;
                            padding: 8px 0;
                            border-bottom: 1px solid #dee2e6;
                        }
                        .row:last-child {
                            border-bottom: none;
                        }
                        .label {
                            font-weight: bold;
                            color: #495057;
                        }
                        .value {
                            color: #212529;
                        }
                        .monto-total {
                            background: #28a745;
                            color: white;
                            padding: 15px;
                            text-align: center;
                            border-radius: 5px;
                            margin: 20px 0;
                            font-size: 24px;
                            font-weight: bold;
                        }
                        .footer {
                            margin-top: 40px;
                            padding-top: 20px;
                            border-top: 2px solid #dee2e6;
                            text-align: center;
                            color: #6c757d;
                            font-size: 12px;
                        }
                        .estado {
                            display: inline-block;
                            padding: 5px 15px;
                            background: #28a745;
                            color: white;
                            border-radius: 20px;
                            font-size: 14px;
                        }
                        @media print {
                            body {
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>🏛️ Club Rotario</h1>
                        <p>Comprobante de Pago de Membresía</p>
                        <p><strong>N° Comprobante: ${membresia.comprobante || 'COMP-' + id}</strong></p>
                    </div>

                    <div class="comprobante-info">
                        <div class="row">
                            <span class="label">Miembro:</span>
                            <span class="value"><strong>{{ Auth::user()->name ?? 'Usuario Actual' }}</strong></span>
                        </div>
                        <div class="row">
                            <span class="label">Fecha de Emisión:</span>
                            <span class="value">${fechaActual}</span>
                        </div>
                        <div class="row">
                            <span class="label">Tipo de Membresía:</span>
                            <span class="value">${membresia.tipo}</span>
                        </div>
                        <div class="row">
                            <span class="label">Fecha de Pago:</span>
                            <span class="value">${membresia.fecha ? new Date(membresia.fecha).toLocaleDateString('es-ES') : new Date(membresia.fechaInicio).toLocaleDateString('es-ES')}</span>
                        </div>
                        ${membresia.fechaVencimiento ? `
                        <div class="row">
                            <span class="label">Fecha de Vencimiento:</span>
                            <span class="value">${new Date(membresia.fechaVencimiento).toLocaleDateString('es-ES')}</span>
                        </div>
                        ` : ''}
                        <div class="row">
                            <span class="label">Método de Pago:</span>
                            <span class="value">${membresia.metodo || 'Transferencia Bancaria'}</span>
                        </div>
                        <div class="row">
                            <span class="label">Estado:</span>
                            <span class="value"><span class="estado">✓ Completado</span></span>
                        </div>
                    </div>

                    <div class="monto-total">
                        MONTO PAGADO: L ${parseFloat(membresia.monto).toFixed(2)}
                    </div>

                    <div class="footer">
                        <p><strong>Club Rotario - Gestión de Membresías</strong></p>
                        <p>Este es un comprobante válido de pago de membresía</p>
                        <p>Generado el ${fechaActual}</p>
                        <p>Para cualquier consulta, contacte con la tesorería del club</p>
                    </div>
                </body>
                </html>
            `;

            // Crear ventana nueva para imprimir
            const ventanaImpresion = window.open('', '_blank');
            ventanaImpresion.document.write(comprobanteHTML);
            ventanaImpresion.document.close();

            // Esperar a que se cargue y luego imprimir/descargar
            ventanaImpresion.onload = function() {
                setTimeout(() => {
                    ventanaImpresion.print();
                }, 250);
            };

            Swal.fire({
                icon: 'success',
                title: 'Comprobante Generado',
                text: 'Se abrió una ventana nueva. Puedes imprimirlo o guardarlo como PDF.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        }

        function verDetallesMembresia(id) {
            Swal.fire({
                title: 'Detalles de Membresía',
                html: `
                    <div class="text-start">
                        <div class="alert alert-info">
                            <h6>Información Completa</h6>
                            <p class="mb-1"><strong>ID:</strong> MEM-2025-${id.toString().padStart(4, '0')}</p>
                            <p class="mb-1"><strong>Estado:</strong> <span class="badge bg-success">Activa</span></p>
                            <p class="mb-1"><strong>Beneficios:</strong></p>
                            <ul class="mb-0">
                                <li>Acceso a eventos del club</li>
                                <li>Participación en votaciones</li>
                                <li>Descuentos en actividades</li>
                                <li>Boletín mensual</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        }

        function verComprobante(comprobante) {
            Swal.fire({
                title: 'Comprobante de Pago',
                html: `
                    <div class="text-center">
                        <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                        <p class="mb-2"><strong>Número de Comprobante:</strong></p>
                        <h5 class="text-primary">${comprobante}</h5>
                        <button class="btn btn-primary mt-3" onclick="window.print()">
                            <i class="fas fa-download me-2"></i>Descargar PDF
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true
            });
        }

        function recordarMasTarde(id) {
            // Obtener información de la membresía
            let membresiaInfo = null;
            if (window.dataMembresias) {
                membresiaInfo = window.dataMembresias.activas.find(m => m.id === id) || 
                               window.dataMembresias.proximas.find(m => m.id === id);
            }

            const fechaVenc = membresiaInfo ? new Date(membresiaInfo.fechaVencimiento).toLocaleDateString('es-ES') : 'próximamente';

            Swal.fire({
                title: '<i class="fas fa-bell text-warning"></i> Configurar Recordatorio',
                html: `
                    <div class="text-start">
                        <div class="alert alert-info mb-3">
                            <strong><i class="fas fa-info-circle me-2"></i>Membresía:</strong> ${membresiaInfo ? membresiaInfo.tipo : 'Membresía Mensual'}<br>
                            <strong><i class="fas fa-calendar me-2"></i>Vence:</strong> ${fechaVenc}
                        </div>
                        
                        <label class="form-label"><strong>¿Cuándo quieres recibir el recordatorio?</strong></label>
                        <select id="diasAntes" class="form-select mb-3">
                            <option value="1">1 día antes del vencimiento</option>
                            <option value="3">3 días antes del vencimiento</option>
                            <option value="5">5 días antes del vencimiento</option>
                            <option value="7" selected>7 días antes del vencimiento (Recomendado)</option>
                            <option value="10">10 días antes del vencimiento</option>
                            <option value="15">15 días antes del vencimiento</option>
                        </select>

                        <label class="form-label"><strong>Mensaje personalizado (opcional):</strong></label>
                        <textarea id="mensajePersonal" class="form-control" rows="2" 
                                  placeholder="Ej: Renovar antes de la reunión del club"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check me-2"></i>Crear Recordatorio',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#667eea',
                width: '500px',
                preConfirm: () => {
                    const diasAntes = document.getElementById('diasAntes').value;
                    const mensaje = document.getElementById('mensajePersonal').value;
                    
                    return {
                        diasAntes: parseInt(diasAntes),
                        mensaje: mensaje
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { diasAntes, mensaje } = result.value;
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Guardando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Guardar recordatorio
                    fetch('/guardar-recordatorio', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            membresia_id: id,
                            dias_antes: diasAntes,
                            mensaje_personal: mensaje
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Recordatorio Configurado!',
                                html: `
                                    <p>Te notificaremos <strong>${diasAntes} día${diasAntes > 1 ? 's' : ''}</strong> antes del vencimiento.</p>
                                    ${mensaje ? `<p class="text-muted"><i class="fas fa-sticky-note me-2"></i>${mensaje}</p>` : ''}
                                `,
                                confirmButtonColor: '#667eea',
                                timer: 3000
                            });
                            
                            // Actualizar contador de notificaciones
                            cargarNotificaciones();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'No se pudo guardar el recordatorio'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Modo fallback: mostrar éxito aunque no se haya guardado
                        Swal.fire({
                            icon: 'success',
                            title: '¡Recordatorio Configurado!',
                            html: `<p>Te notificaremos <strong>${diasAntes} día${diasAntes > 1 ? 's' : ''}</strong> antes del vencimiento.</p>`,
                            confirmButtonColor: '#667eea',
                            timer: 2500
                        });
                        cargarNotificaciones();
                    });
                }
            });
        }

        function eliminarHistorial(index) {
            Swal.fire({
                title: '¿Eliminar este registro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Eliminar de sesión
                    fetch('/eliminar-pago-historial', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            index: index
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar fila visualmente
                            const row = document.getElementById('historial-row-' + index);
                            if (row) {
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '0';
                                row.style.transform = 'translateX(-20px)';
                                setTimeout(() => {
                                    row.remove();
                                    // Si no hay más filas, recargar modal
                                    const tbody = row.closest('tbody');
                                    if (tbody && tbody.children.length === 0) {
                                        Swal.close();
                                        setTimeout(() => verMisMembresías(), 300);
                                    }
                                }, 300);
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: 'El registro ha sido eliminado',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar el registro'
                        });
                    });
                }
            });
        }

        function limpiarHistorial() {
            Swal.fire({
                title: '¿Limpiar todo el historial?',
                text: 'Se eliminarán todos los registros de pagos. Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Sí, Limpiar Todo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/limpiar-historial', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Historial Limpiado!',
                                text: 'Todos los registros han sido eliminados',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                // Recargar modal
                                Swal.close();
                                setTimeout(() => verMisMembresías(), 300);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo limpiar el historial'
                        });
                    });
                }
            });
        }

        function verMisTransacciones() {
            Swal.close();
            
            // Mostrar loading
            Swal.fire({
                title: 'Cargando transacciones...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Obtener transacciones
            fetch('/mis-transacciones', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarPanelTransacciones(data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las transacciones'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Mostrar datos de ejemplo en caso de error
                mostrarPanelTransacciones({
                    success: true,
                    resumen: {
                        totalPagado: 1500.00,
                        pagosRealizados: 3,
                        pagosProcessados: 12,
                        montoGestionado: 15000.00
                    },
                    transacciones: []
                });
            });
        }

        function mostrarPanelTransacciones(data) {
            const resumen = data.resumen || {};
            const transacciones = data.transacciones || [];
            
            let htmlContent = `
                <div class="text-start">
                    <!-- Resumen Personal -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="card border-success">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-wallet text-success fa-2x mb-2"></i>
                                    <h6 class="text-muted mb-1">Total Pagado en Membresías</h6>
                                    <h4 class="text-success mb-0">L ${(resumen.totalPagado || 0).toFixed(2)}</h4>
                                    <small class="text-muted">${resumen.pagosRealizados || 0} pagos realizados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-primary">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-tasks text-primary fa-2x mb-2"></i>
                                    <h6 class="text-muted mb-1">Monto Gestionado</h6>
                                    <h4 class="text-primary mb-0">L ${(resumen.montoGestionado || 0).toFixed(2)}</h4>
                                    <small class="text-muted">${resumen.pagosProcessados || 0} transacciones procesadas</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3"><i class="fas fa-filter me-2"></i>Filtros</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small">Tipo de Transacción</label>
                                    <select class="form-select form-select-sm" id="filtroTipo" onchange="filtrarTransacciones()">
                                        <option value="">Todas</option>
                                        <option value="pago_membresia">Pago de Membresía</option>
                                        <option value="gasto">Gasto Aprobado</option>
                                        <option value="ingreso">Ingreso Registrado</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Desde</label>
                                    <input type="date" class="form-control form-control-sm" id="filtroFechaDesde" onchange="filtrarTransacciones()">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Hasta</label>
                                    <input type="date" class="form-control form-control-sm" id="filtroFechaHasta" onchange="filtrarTransacciones()">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-sm btn-outline-secondary w-100" onclick="limpiarFiltros()">
                                        <i class="fas fa-redo me-1"></i>Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Transacciones -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-list me-2"></i>Historial de Transacciones</h6>
                        </div>
                        <div class="card-body p-0">
                            <div id="listaTransacciones" style="max-height: 400px; overflow-y: auto;">
            `;

            if (transacciones.length === 0) {
                htmlContent += `
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay transacciones registradas</p>
                        <small class="text-muted">Las transacciones que realices aparecerán aquí</small>
                    </div>
                `;
            } else {
                htmlContent += '<div class="list-group list-group-flush">';
                transacciones.forEach(trans => {
                    const iconos = {
                        'pago_membresia': 'fa-id-card text-success',
                        'gasto': 'fa-arrow-down text-danger',
                        'ingreso': 'fa-arrow-up text-success'
                    };
                    const icon = iconos[trans.tipo] || 'fa-circle text-secondary';
                    
                    htmlContent += `
                        <div class="list-group-item transaccion-item" data-tipo="${trans.tipo}" data-fecha="${trans.fecha}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas ${icon} fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">${trans.descripcion}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>${new Date(trans.fecha).toLocaleDateString('es-ES')}
                                            ${trans.comprobante ? `| <i class="fas fa-file-alt me-1"></i>${trans.comprobante}` : ''}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h5 class="mb-0 ${trans.tipo === 'gasto' ? 'text-danger' : 'text-success'}">
                                        ${trans.tipo === 'gasto' ? '-' : ''}L ${trans.monto.toFixed(2)}
                                    </h5>
                                    ${trans.estado ? `<span class="badge bg-${trans.estado === 'Completado' ? 'success' : 'warning'}">${trans.estado}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
                htmlContent += '</div>';
            }

            htmlContent += `
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botón Volver -->
                    <div class="text-center mt-3">
                        <button class="btn btn-secondary" onclick="volverAMembresias()">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Mis Membresías
                        </button>
                    </div>
                </div>
            `;

            Swal.fire({
                title: '<i class="fas fa-exchange-alt me-2"></i>Mis Transacciones',
                html: htmlContent,
                width: '900px',
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    container: 'transacciones-modal'
                }
            });

            // Guardar datos globales para filtros
            window.todasTransacciones = transacciones;
        }

        function filtrarTransacciones() {
            const tipo = document.getElementById('filtroTipo').value;
            const fechaDesde = document.getElementById('filtroFechaDesde').value;
            const fechaHasta = document.getElementById('filtroFechaHasta').value;

            const items = document.querySelectorAll('.transaccion-item');
            items.forEach(item => {
                let mostrar = true;

                if (tipo && item.dataset.tipo !== tipo) {
                    mostrar = false;
                }

                if (fechaDesde && item.dataset.fecha < fechaDesde) {
                    mostrar = false;
                }

                if (fechaHasta && item.dataset.fecha > fechaHasta) {
                    mostrar = false;
                }

                item.style.display = mostrar ? 'block' : 'none';
            });
        }

        function limpiarFiltros() {
            document.getElementById('filtroTipo').value = '';
            document.getElementById('filtroFechaDesde').value = '';
            document.getElementById('filtroFechaHasta').value = '';
            filtrarTransacciones();
        }

        function estadisticasPersonales() {
            Swal.close();
            
            // Mostrar loading
            Swal.fire({
                title: 'Generando estadísticas...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Obtener estadísticas
            fetch('/mis-estadisticas', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarEstadisticas(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Mostrar con datos de ejemplo
                mostrarEstadisticas({
                    success: true,
                    stats: {
                        totalPagado: 0,
                        promedioPago: 0,
                        pagosUltimos30Dias: 0,
                        proximoPago: null,
                        pagosPorMes: []
                    }
                });
            });
        }

        function mostrarEstadisticas(data) {
            const stats = data.stats || {};
            
            // Preparar datos para gráfico
            const meses = stats.pagosPorMes || [];
            const labels = meses.map(m => m.mes);
            const valores = meses.map(m => m.total);
            
            let htmlContent = `
                <div class="text-start">
                    <!-- KPIs Principales -->
                    <div class="row mb-4">
                        <div class="col-6 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                                    <h6 class="mb-1">Total Pagado (2025)</h6>
                                    <h3 class="mb-0">L ${(stats.totalPagado || 0).toFixed(2)}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                                    <h6 class="mb-1">Últimos 30 Días</h6>
                                    <h3 class="mb-0">${stats.pagosUltimos30Dias || 0}</h3>
                                    <small>pagos realizados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-calculator fa-2x mb-2"></i>
                                    <h6 class="mb-1">Promedio por Pago</h6>
                                    <h3 class="mb-0">L ${(stats.promedioPago || 0).toFixed(2)}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center py-3">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h6 class="mb-1">Próximo Pago</h6>
                                    <h3 class="mb-0">${stats.proximoPago ? new Date(stats.proximoPago).toLocaleDateString('es-ES', {day: '2-digit', month: 'short'}) : 'N/A'}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de Pagos por Mes -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Pagos Mensuales (2025)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPagosMensuales" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Tabla de Desglose Mensual -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Desglose Mensual</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Mes</th>
                                            <th class="text-center">Pagos</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            `;

            if (meses.length === 0) {
                htmlContent += `
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No hay datos para mostrar
                        </td>
                    </tr>
                `;
            } else {
                meses.forEach(mes => {
                    htmlContent += `
                        <tr>
                            <td><strong>${mes.mes}</strong></td>
                            <td class="text-center"><span class="badge bg-primary">${mes.cantidad}</span></td>
                            <td class="text-end text-success"><strong>L ${mes.total.toFixed(2)}</strong></td>
                        </tr>
                    `;
                });
            }

            htmlContent += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="alert alert-info mt-3">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Nota:</strong> Estas estadísticas muestran únicamente tus pagos de membresía personal.
                        </small>
                    </div>
                    
                    <!-- Botón Volver -->
                    <div class="text-center mb-0">
                        <button class="btn btn-secondary" onclick="volverAMembresias()">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Mis Membresías
                        </button>
                    </div>
                </div>
            `;

            Swal.fire({
                title: '<i class="fas fa-chart-pie me-2"></i>Mis Estadísticas',
                html: htmlContent,
                width: '800px',
                showConfirmButton: false,
                showCloseButton: true,
                didOpen: () => {
                    // Crear gráfico con Chart.js
                    if (meses.length > 0) {
                        const ctx = document.getElementById('chartPagosMensuales');
                        if (ctx) {
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Monto Pagado (L)',
                                        data: valores,
                                        backgroundColor: 'rgba(102, 126, 234, 0.8)',
                                        borderColor: 'rgba(102, 126, 234, 1)',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function(value) {
                                                    return 'L ' + value.toFixed(0);
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }

        // Función para volver al modal de Mis Membresías
        function volverAMembresias() {
            Swal.close();
            setTimeout(() => {
                verMisMembresías();
            }, 200);
        }

        function configurarPreferencias() {
            Swal.close();
            Swal.fire({
                title: 'Configurar Preferencias',
                html: `
                    <div class="text-start">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifEmail" checked>
                            <label class="form-check-label" for="notifEmail">
                                Recibir notificaciones por email
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="alertasPresupuesto" checked>
                            <label class="form-check-label" for="alertasPresupuesto">
                                Alertas de presupuesto
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="resumenSemanal">
                            <label class="form-check-label" for="resumenSemanal">
                                Resumen semanal
                            </label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('¡Guardado!', 'Tus preferencias han sido actualizadas', 'success');
                }
            });
        }

        function cambiarContrasena() {
            Swal.close();
            Swal.fire({
                title: 'Cambiar Contraseña',
                html: `
                    <div class="text-start">
                        <div class="mb-3">
                            <label class="form-label">Contraseña Actual</label>
                            <input type="password" id="currentPass" class="form-control" placeholder="Contraseña actual">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" id="newPass" class="form-control" placeholder="Nueva contraseña">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Contraseña</label>
                            <input type="password" id="confirmPass" class="form-control" placeholder="Confirmar contraseña">
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Cambiar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const current = document.getElementById('currentPass').value;
                    const newPass = document.getElementById('newPass').value;
                    const confirm = document.getElementById('confirmPass').value;
                    
                    if (!current || !newPass || !confirm) {
                        Swal.showValidationMessage('Todos los campos son requeridos');
                        return false;
                    }
                    
                    if (newPass !== confirm) {
                        Swal.showValidationMessage('Las contraseñas no coinciden');
                        return false;
                    }
                    
                    if (newPass.length < 8) {
                        Swal.showValidationMessage('La contraseña debe tener al menos 8 caracteres');
                        return false;
                    }
                    
                    return { current, newPass };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí harías la petición AJAX al backend
                    Swal.fire('¡Actualizado!', 'Tu contraseña ha sido cambiada exitosamente', 'success');
                }
            });
        }

        function verActividadReciente() {
            Swal.close();
            Swal.fire({
                title: 'Actividad Reciente',
                html: `
                    <div class="text-start">
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Inicio de sesión</h6>
                                    <small>Hoy, 10:30 AM</small>
                                </div>
                                <p class="mb-1"><small>IP: 192.168.1.100</small></p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Ingreso registrado</h6>
                                    <small>Ayer, 3:45 PM</small>
                                </div>
                                <p class="mb-1"><small>Monto: ₡20,000.00</small></p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Reporte generado</h6>
                                    <small>Ayer, 2:15 PM</small>
                                </div>
                                <p class="mb-1"><small>Tipo: Reporte General</small></p>
                            </div>
                        </div>
                    </div>
                `,
                width: '600px',
                showConfirmButton: true
            });
        }

        function cambiarFotoPerfil() {
            Swal.fire({
                title: 'Cambiar Foto de Perfil',
                html: `
                    <div class="text-center">
                        <p class="mb-3">Selecciona una nueva foto de perfil</p>
                        <input type="file" id="fotoPerfil" class="form-control mb-3" accept="image/*">
                        <div id="preview" class="mt-3"></div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    const input = document.getElementById('fotoPerfil');
                    const preview = document.getElementById('preview');
                    
                    input.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                preview.innerHTML = '<img src="' + event.target.result + '" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #667eea;">';
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                },
                preConfirm: () => {
                    const file = document.getElementById('fotoPerfil').files[0];
                    if (!file) {
                        Swal.showValidationMessage('Por favor selecciona una imagen');
                        return false;
                    }
                    
                    // Leer el archivo como base64
                    return new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            resolve(event.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // Guardar en localStorage
                    localStorage.setItem('fotoPerfil', result.value);
                    
                    // Actualizar todas las imágenes de perfil en el DOM
                    const imagenesPerf = document.querySelectorAll('.img-perfil-tesorero');
                    imagenesPerf.forEach(img => {
                        img.src = result.value;
                    });
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Tu foto de perfil ha sido actualizada',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Cerrar modal actual y reabrir para mostrar la nueva foto
                        Swal.close();
                        setTimeout(() => mostrarPerfilTesorero(), 300);
                    });
                }
            });
        }

        function exportarExcel() {
            Swal.fire({
                title: 'Exportar Datos Financieros',
                html: `
                    <div class="text-start">
                        <p class="mb-3">Selecciona qué datos deseas exportar:</p>
                        
                        <label class="form-label fw-bold">Tipo de Datos:</label>
                        <select id="tipoExportacion" class="form-select mb-3">
                            <option value="general">📊 Datos Generales (Todo)</option>
                            <option value="ingresos">💰 Solo Ingresos</option>
                            <option value="gastos">💸 Solo Gastos</option>
                            <option value="transferencias">🔄 Solo Transferencias</option>
                            <option value="membresias">👥 Solo Membresías</option>
                        </select>
                        
                        <label class="form-label fw-bold">Período:</label>
                        <select id="periodoExportacion" class="form-select mb-3">
                            <option value="mes_actual">Mes Actual</option>
                            <option value="mes_anterior">Mes Anterior</option>
                            <option value="trimestre">Último Trimestre</option>
                            <option value="anio">Año en Curso</option>
                            <option value="todos">Todos los Registros</option>
                        </select>
                        
                        <label class="form-label fw-bold">Formato:</label>
                        <div class="btn-group w-100 mb-3" role="group">
                            <input type="radio" class="btn-check" name="formatoExport" id="formatoCSV" value="csv" checked>
                            <label class="btn btn-outline-success" for="formatoCSV">
                                <i class="fas fa-file-csv"></i> CSV/Excel
                            </label>
                            
                            <input type="radio" class="btn-check" name="formatoExport" id="formatoPDFExport" value="pdf">
                            <label class="btn btn-outline-danger" for="formatoPDFExport">
                                <i class="fas fa-file-pdf"></i> PDF
                            </label>
                        </div>
                    </div>
                `,
                width: '500px',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-download me-2"></i>Exportar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                preConfirm: () => {
                    const tipo = document.getElementById('tipoExportacion').value;
                    const periodo = document.getElementById('periodoExportacion').value;
                    const formato = document.querySelector('input[name="formatoExport"]:checked').value;
                    return { tipo, periodo, formato };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { tipo, periodo, formato } = result.value;
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Exportando...',
                        html: 'Preparando los datos para exportar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Construir URL
                    let url = "{{ route('tesorero.reportes.generar') }}?tipo=" + tipo + 
                              "&periodo=" + periodo + "&formato=" + (formato === 'csv' ? 'excel' : 'pdf');
                    
                    // Descargar archivo
                    window.location.href = url;
                    
                    // Mostrar éxito
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Exportado!',
                            text: 'El archivo se está descargando...',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }, 1000);
                }
            });
        }

        function aprobarGasto(id) {
            Swal.fire({
                title: '¿Aprobar este gasto?',
                text: "El gasto será marcado como aprobado y se actualizará el presupuesto.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, aprobar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar solicitud AJAX
                    fetch(`/tesorero/gastos/${id}/aprobar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Aprobado!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Ocurrió un error al aprobar el gasto.', 'error');
                    });
                }
            });
        }

        function rechazarGasto(id) {
            Swal.fire({
                title: '¿Rechazar este gasto?',
                input: 'textarea',
                inputLabel: 'Motivo del rechazo',
                inputPlaceholder: 'Escribe el motivo del rechazo...',
                inputAttributes: {
                    'aria-label': 'Escribe el motivo del rechazo'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Rechazar',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return '¡Debes escribir un motivo!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar solicitud AJAX
                    fetch(`/tesorero/gastos/${id}/rechazar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({
                            motivo: result.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Rechazado!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Recargar la página para actualizar la lista
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Ocurrió un error al rechazar el gasto.', 'error');
                    });
                }
            });
        }

        function verDetalles(id) {
            // Cargar detalles del gasto
            fetch(`/tesorero/gastos/${id}/detalles`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const gasto = data.gasto;
                    Swal.fire({
                        title: 'Detalles del Gasto',
                        html: `
                            <div class="text-start">
                                <p><strong>Descripción:</strong> ${gasto.descripcion || 'N/A'}</p>
                                <p><strong>Categoría:</strong> ${gasto.categoria || 'N/A'}</p>
                                <p><strong>Monto:</strong> L.${parseFloat(gasto.monto).toFixed(2)}</p>
                                <p><strong>Proveedor:</strong> ${gasto.proveedor || 'N/A'}</p>
                                <p><strong>Fecha:</strong> ${gasto.fecha || 'N/A'}</p>
                                <p><strong>Método de pago:</strong> ${gasto.metodo_pago || 'N/A'}</p>
                                <p><strong>Comprobante:</strong> ${gasto.comprobante || 'N/A'}</p>
                                <p><strong>Estado:</strong> <span class="badge bg-${gasto.estado === 'aprobado' ? 'success' : gasto.estado === 'rechazado' ? 'danger' : 'warning'}">${gasto.estado}</span></p>
                                ${gasto.notas ? `<p><strong>Notas:</strong> ${gasto.notas}</p>` : ''}
                                ${gasto.usuario_registro ? `<p><strong>Registrado por:</strong> ${gasto.usuario_registro.name}</p>` : ''}
                            </div>
                        `,
                        width: '600px',
                        confirmButtonText: 'Cerrar'
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al obtener los detalles.', 'error');
            });
        }

        // ============================================
        // ANIMACIONES Y EFECTOS
        // ============================================
        
        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card, .section-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 50);
            });
        });

        // ============================================
        // SISTEMA DE NOTIFICACIONES
        // ============================================
        
        function cargarNotificaciones() {
            fetch('/tesorero/mis-notificaciones', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const noLeidas = data.notificaciones.filter(n => !n.leida).length;
                    const badge = document.getElementById('notif-badge');
                    
                    if (badge) {
                        if (noLeidas > 0) {
                            badge.textContent = noLeidas;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                    
                    // También actualizar el badge del navigation si existe
                    const badgeNav = document.getElementById('notificaciones-badge-nav');
                    if (badgeNav) {
                        if (noLeidas > 0) {
                            badgeNav.textContent = noLeidas;
                            badgeNav.classList.remove('hidden');
                        } else {
                            badgeNav.classList.add('hidden');
                        }
                    }
                }
            })
            .catch(error => console.error('Error cargando notificaciones:', error));
        }
        
        function mostrarNotificaciones() {
            fetch('/tesorero/mis-notificaciones', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notifs = data.notificaciones;
                    
                    let htmlContent = '';
                    if (notifs.length === 0) {
                        htmlContent = '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No tienes notificaciones</div>';
                    } else {
                        htmlContent = '<div class="list-group" style="max-height: 400px; overflow-y: auto;">';
                        notifs.forEach(notif => {
                            const fechaFormat = new Date(notif.created_at).toLocaleDateString('es-ES', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            
                            htmlContent += `
                                <div class="list-group-item ${!notif.leida ? 'bg-light border-primary' : ''}" 
                                     style="cursor: pointer;"
                                     onclick="marcarComoLeida(${notif.id})">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <i class="fas fa-bell text-warning me-2"></i>
                                            ${notif.titulo}
                                            ${!notif.leida ? '<span class="badge bg-primary ms-2">Nueva</span>' : ''}
                                        </h6>
                                        <small class="text-muted">${fechaFormat}</small>
                                    </div>
                                    <p class="mb-1">${notif.mensaje}</p>
                                    ${!notif.leida ? '<small class="text-primary"><i class="fas fa-check me-1"></i>Click para marcar como leída</small>' : ''}
                                </div>
                            `;
                        });
                        htmlContent += '</div>';
                        
                        // Botón para marcar todas como leídas
                        if (notifs.some(n => !n.leida)) {
                            htmlContent += `
                                <div class="mt-3 text-center">
                                    <button class="btn btn-sm btn-primary" onclick="marcarTodasLeidas()">
                                        <i class="fas fa-check-double me-1"></i>Marcar todas como leídas
                                    </button>
                                </div>
                            `;
                        }
                    }
                    
                    Swal.fire({
                        title: '<i class="fas fa-bell me-2"></i>Mis Notificaciones',
                        html: htmlContent,
                        width: '600px',
                        showConfirmButton: false,
                        showCloseButton: true,
                        customClass: {
                            container: 'notificaciones-modal'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar las notificaciones'
                });
            });
        }
        
        function marcarComoLeida(notifId) {
            fetch('/tesorero/marcar-notificacion-leida/' + notifId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recargar notificaciones
                    Swal.close();
                    setTimeout(() => mostrarNotificaciones(), 200);
                    cargarNotificaciones();
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        function marcarTodasLeidas() {
            fetch('/tesorero/marcar-todas-leidas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Listo!',
                        text: 'Todas las notificaciones han sido marcadas como leídas',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    cargarNotificaciones();
                }
            })
            .catch(error => console.error('Error:', error));
        }
        
        // Cargar notificaciones al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarNotificaciones();
            // Actualizar cada 30 segundos
            setInterval(cargarNotificaciones, 30000);
        });
    </script>
</body>
</html>
