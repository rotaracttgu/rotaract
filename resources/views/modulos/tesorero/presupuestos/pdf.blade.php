<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Presupuestos - {{ DateTime::createFromFormat('!m', $mes)->format('F') }} {{ $anio }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #667eea;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-box p {
            margin: 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background: #667eea;
            color: white;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }
        
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        tbody tr:hover {
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
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #000;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .badge-secondary {
            background: #6c757d;
            color: white;
        }
        
        .totals {
            background: #f8f9fa;
            font-weight: bold;
            font-size: 13px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 11px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        
        @media print {
            body {
                padding: 10px;
            }
            
            .no-print {
                display: none;
            }
            
            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <!-- Botón de Impresión -->
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
            🖨️ Imprimir / Guardar como PDF
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>📊 REPORTE DE PRESUPUESTOS</h1>
        <p><strong>Período:</strong> {{ DateTime::createFromFormat('!m', $mes)->format('F') }} {{ $anio }}</p>
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Información General -->
    <div class="info-box">
        <p><strong>Total de categorías:</strong> {{ $presupuestos->count() }}</p>
        <p><strong>Presupuesto total:</strong> L. {{ number_format($presupuestos->sum('presupuesto_mensual'), 2) }}</p>
        <p><strong>Gasto total:</strong> L. {{ number_format($presupuestos->sum('gasto_real'), 2) }}</p>
        <p><strong>Disponible total:</strong> L. {{ number_format($presupuestos->sum('disponible'), 2) }}</p>
    </div>

    <!-- Tabla de Presupuestos -->
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th class="text-right">Presupuesto</th>
                <th class="text-right">Gastado</th>
                <th class="text-right">Disponible</th>
                <th class="text-center">Uso %</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presupuestos as $pres)
            <tr>
                <td>
                    <strong>{{ $pres->categoria }}</strong>
                    @if(!$pres->activo)
                        <span class="badge badge-secondary">Inactivo</span>
                    @endif
                </td>
                <td class="text-right">L. {{ number_format($pres->presupuesto_mensual, 2) }}</td>
                <td class="text-right">L. {{ number_format($pres->gasto_real, 2) }}</td>
                <td class="text-right">
                    <span style="color: {{ $pres->disponible < 0 ? '#dc3545' : '#28a745' }}">
                        L. {{ number_format($pres->disponible, 2) }}
                    </span>
                </td>
                <td class="text-center">{{ number_format($pres->porcentaje, 1) }}%</td>
                <td class="text-center">
                    @if($pres->porcentaje >= 90)
                        <span class="badge badge-danger">Crítico</span>
                    @elseif($pres->porcentaje >= 75)
                        <span class="badge badge-warning">Alerta</span>
                    @else
                        <span class="badge badge-success">Normal</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="totals">
                <td><strong>TOTALES</strong></td>
                <td class="text-right"><strong>L. {{ number_format($presupuestos->sum('presupuesto_mensual'), 2) }}</strong></td>
                <td class="text-right"><strong>L. {{ number_format($presupuestos->sum('gasto_real'), 2) }}</strong></td>
                <td class="text-right">
                    <strong style="color: {{ $presupuestos->sum('disponible') < 0 ? '#dc3545' : '#28a745' }}">
                        L. {{ number_format($presupuestos->sum('disponible'), 2) }}
                    </strong>
                </td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <!-- Detalles por Categoría -->
    @if($presupuestos->where('descripcion', '!=', null)->count() > 0)
    <div style="margin-top: 30px;">
        <h3 style="color: #667eea; margin-bottom: 15px;">Observaciones por Categoría</h3>
        @foreach($presupuestos->where('descripcion', '!=', null) as $pres)
        <div style="margin-bottom: 15px; padding: 10px; background: #f8f9fa; border-left: 4px solid #667eea;">
            <p><strong>{{ $pres->categoria }}:</strong></p>
            <p style="margin-left: 15px;">{{ $pres->descripcion }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Este reporte fue generado automáticamente por el Sistema de Gestión del Club Rotario</p>
        <p>© {{ date('Y') }} - Todos los derechos reservados</p>
    </div>
</body>
</html>
