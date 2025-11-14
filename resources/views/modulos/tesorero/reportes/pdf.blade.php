<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero - {{ ucfirst($tipo) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .info-section h3 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-item {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            width: 40%;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        
        .summary-cards {
            margin-bottom: 20px;
        }
        
        .summary-card {
            display: inline-block;
            width: 48%;
            padding: 15px;
            margin-right: 2%;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            vertical-align: top;
        }
        
        .summary-card:nth-child(2n) {
            margin-right: 0;
        }
        
        .summary-card h4 {
            color: #667eea;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .summary-card .amount {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        
        .summary-card.income .amount {
            color: #28a745;
        }
        
        .summary-card.expense .amount {
            color: #dc3545;
        }
        
        .summary-card.balance .amount {
            color: #667eea;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background: #667eea;
            color: white;
        }
        
        table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #dee2e6;
            font-size: 10px;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 9px;
            border-top: 1px solid #dee2e6;
            margin-top: 30px;
        }
        
        .section-title {
            color: #667eea;
            font-size: 16px;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>📊 REPORTE FINANCIERO</h1>
        <p>{{ strtoupper(str_replace('_', ' ', $tipo)) }}</p>
    </div>

    <!-- INFORMACIÓN DEL REPORTE -->
    <div class="info-section">
        <h3>Información del Reporte</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Tipo de Reporte:</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $tipo)) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Período:</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $periodo)) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Rango de Fechas:</span>
                <span class="info-value">{{ date('d/m/Y', strtotime($fechaInicio)) }} al {{ date('d/m/Y', strtotime($fechaFin)) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fecha de Generación:</span>
                <span class="info-value">{{ $fechaGeneracion }}</span>
            </div>
        </div>
    </div>

    @if($tipo === 'general')
        <!-- RESUMEN GENERAL -->
        <h2 class="section-title">Resumen Ejecutivo</h2>
        
        <div class="summary-cards">
            <div class="summary-card income">
                <h4>💰 Total Ingresos</h4>
                <div class="amount">₡{{ number_format($datos['resumen']['total_ingresos'], 2) }}</div>
                <small>{{ $datos['resumen']['cantidad_ingresos'] }} registros</small>
            </div>
            
            <div class="summary-card expense">
                <h4>💸 Total Gastos</h4>
                <div class="amount">₡{{ number_format($datos['resumen']['total_gastos'], 2) }}</div>
                <small>{{ $datos['resumen']['cantidad_gastos'] }} registros</small>
            </div>
            
            <div class="summary-card balance">
                <h4>📊 Balance</h4>
                <div class="amount">₡{{ number_format($datos['resumen']['balance'], 2) }}</div>
                <small>Diferencia neta</small>
            </div>
        </div>

        <!-- INGRESOS -->
        @if(count($datos['ingresos']) > 0)
        <h2 class="section-title">Detalle de Ingresos</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Fuente</th>
                    <th class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['ingresos'] as $ingreso)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($ingreso->fecha_ingreso ?? $ingreso->fecha ?? now())) }}</td>
                    <td>{{ $ingreso->descripcion ?? '-' }}</td>
                    <td>{{ $ingreso->categoria ?? '-' }}</td>
                    <td>{{ $ingreso->fuente ?? '-' }}</td>
                    <td class="text-right">₡{{ number_format($ingreso->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- GASTOS -->
        @if(count($datos['gastos']) > 0)
        <div class="page-break"></div>
        <h2 class="section-title">Detalle de Gastos</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['gastos'] as $gasto)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($gasto->fecha ?? now())) }}</td>
                    <td>{{ $gasto->descripcion ?? '-' }}</td>
                    <td>{{ $gasto->categoria ?? '-' }}</td>
                    <td>{{ $gasto->proveedor ?? '-' }}</td>
                    <td class="text-right">₡{{ number_format($gasto->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    @elseif($tipo === 'ingresos')
        <!-- SOLO INGRESOS -->
        <h2 class="section-title">Detalle de Ingresos</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Fuente</th>
                    <th>Método Pago</th>
                    <th class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $ingreso)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($ingreso->fecha_ingreso ?? $ingreso->fecha ?? now())) }}</td>
                    <td>{{ $ingreso->descripcion ?? '-' }}</td>
                    <td>{{ $ingreso->categoria ?? '-' }}</td>
                    <td>{{ $ingreso->fuente ?? '-' }}</td>
                    <td>{{ $ingreso->metodo_pago ?? '-' }}</td>
                    <td class="text-right">₡{{ number_format($ingreso->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
                <tr style="background: #667eea; color: white; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-right">₡{{ number_format($datos->sum('monto'), 2) }}</td>
                </tr>
            </tbody>
        </table>

    @elseif($tipo === 'gastos')
        <!-- SOLO GASTOS -->
        <h2 class="section-title">Detalle de Gastos</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Método Pago</th>
                    <th class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $gasto)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($gasto->fecha ?? now())) }}</td>
                    <td>{{ $gasto->descripcion ?? '-' }}</td>
                    <td>{{ $gasto->categoria ?? '-' }}</td>
                    <td>{{ $gasto->proveedor ?? '-' }}</td>
                    <td>{{ $gasto->metodo_pago ?? '-' }}</td>
                    <td class="text-right">₡{{ number_format($gasto->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
                <tr style="background: #dc3545; color: white; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-right">₡{{ number_format($datos->sum('monto'), 2) }}</td>
                </tr>
            </tbody>
        </table>

    @elseif($tipo === 'categoria')
        <!-- POR CATEGORÍA -->
        <h2 class="section-title">Ingresos por Categoría</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['ingresos_por_categoria'] as $cat)
                <tr>
                    <td>{{ $cat->categoria ?? '-' }}</td>
                    <td class="text-center">{{ $cat->cantidad ?? 0 }}</td>
                    <td class="text-right">₡{{ number_format($cat->total ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="section-title">Gastos por Categoría</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos['gastos_por_categoria'] as $cat)
                <tr>
                    <td>{{ $cat->categoria ?? '-' }}</td>
                    <td class="text-center">{{ $cat->cantidad ?? 0 }}</td>
                    <td class="text-right">₡{{ number_format($cat->total ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <p>Generado automáticamente por el Sistema de Gestión Financiera - Club Rotario</p>
        <p>Fecha de generación: {{ $fechaGeneracion }}</p>
    </div>
</body>
</html>
