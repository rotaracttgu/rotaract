<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero</title>
    <style>
        body {
            font-family: 'Calibri', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
        }
        
        .header {
            text-align: center;
            background-color: #667eea;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24pt;
            margin: 0 0 5px 0;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-box h3 {
            color: #667eea;
            margin-top: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #667eea;
            color: white;
        }
        
        table th, table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .summary-box {
            display: inline-block;
            width: 30%;
            padding: 15px;
            margin: 10px 1%;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .summary-box h4 {
            margin-top: 0;
            color: #667eea;
        }
        
        .summary-box .amount {
            font-size: 18pt;
            font-weight: bold;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        h2 {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
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
    <div class="info-box">
        <h3>Información del Reporte</h3>
        <p><strong>Tipo de Reporte:</strong> {{ ucfirst(str_replace('_', ' ', $tipo)) }}</p>
        <p><strong>Período:</strong> {{ ucfirst(str_replace('_', ' ', $periodo)) }}</p>
        <p><strong>Rango de Fechas:</strong> {{ date('d/m/Y', strtotime($fechaInicio)) }} al {{ date('d/m/Y', strtotime($fechaFin)) }}</p>
        <p><strong>Fecha de Generación:</strong> {{ $fechaGeneracion }}</p>
    </div>

    @if($tipo === 'general')
        <!-- RESUMEN GENERAL -->
        <h2>Resumen Ejecutivo</h2>
        
        <div class="summary-box">
            <h4>💰 Total Ingresos</h4>
            <div class="amount">₡{{ number_format($datos['resumen']['total_ingresos'], 2) }}</div>
            <small>{{ $datos['resumen']['cantidad_ingresos'] }} registros</small>
        </div>
        
        <div class="summary-box">
            <h4>💸 Total Gastos</h4>
            <div class="amount">₡{{ number_format($datos['resumen']['total_gastos'], 2) }}</div>
            <small>{{ $datos['resumen']['cantidad_gastos'] }} registros</small>
        </div>
        
        <div class="summary-box">
            <h4>📊 Balance</h4>
            <div class="amount">₡{{ number_format($datos['resumen']['balance'], 2) }}</div>
            <small>Diferencia neta</small>
        </div>
        
        <div style="clear: both;"></div>

        <!-- INGRESOS -->
        @if(count($datos['ingresos']) > 0)
        <h2>Detalle de Ingresos</h2>
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
                    <td>{{ $ingreso->fuente ?? ($ingreso->origen ?? '-') }}</td>
                    <td class="text-right">₡{{ number_format($ingreso->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- GASTOS -->
        @if(count($datos['gastos']) > 0)
        <div class="page-break"></div>
        <h2>Detalle de Gastos</h2>
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
        <h2>Detalle de Ingresos</h2>
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
                    <td>{{ $ingreso->descripcion ?? ($ingreso->concepto ?? '-') }}</td>
                    <td>{{ $ingreso->categoria ?? ($ingreso->tipo ?? '-') }}</td>
                    <td>{{ $ingreso->fuente ?? ($ingreso->origen ?? '-') }}</td>
                    <td>{{ $ingreso->metodo_pago ?? ($ingreso->metodo_recepcion ?? '-') }}</td>
                    <td class="text-right">₡{{ number_format($ingreso->monto ?? 0, 2) }}</td>
                </tr>
                @endforeach
                <tr style="background-color: #667eea; color: white; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-right">₡{{ number_format($datos->sum('monto'), 2) }}</td>
                </tr>
            </tbody>
        </table>

    @elseif($tipo === 'gastos')
        <!-- SOLO GASTOS -->
        <h2>Detalle de Gastos</h2>
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
                <tr style="background-color: #dc3545; color: white; font-weight: bold;">
                    <td colspan="5" class="text-right">TOTAL:</td>
                    <td class="text-right">₡{{ number_format($datos->sum('monto'), 2) }}</td>
                </tr>
            </tbody>
        </table>

    @elseif($tipo === 'categoria')
        <!-- POR CATEGORÍA -->
        <h2>Ingresos por Categoría</h2>
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

        <h2>Gastos por Categoría</h2>
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
    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 9pt;">
        <p>Generado automáticamente por el Sistema de Gestión Financiera - Club Rotario</p>
        <p>Fecha de generación: {{ $fechaGeneracion }}</p>
    </div>
</body>
</html>
