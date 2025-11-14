<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Consultas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            padding: 30px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .club-name {
            font-size: 20px;
            font-weight: bold;
            color: #764ba2;
            margin-bottom: 10px;
        }
        .document-type {
            font-size: 26px;
            font-weight: bold;
            color: #667eea;
            text-transform: uppercase;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin-bottom: 30px;
        }
        .consulta-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .consulta-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .consulta-asunto {
            font-size: 16px;
            font-weight: bold;
            color: #764ba2;
            margin-bottom: 10px;
        }
        .consulta-meta {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }
        .estado-respondida {
            background: #d1ecf1;
            color: #0c5460;
        }
        .estado-cerrada {
            background: #d4edda;
            color: #155724;
        }
        .prioridad-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .prioridad-alta {
            background: #f8d7da;
            color: #721c24;
        }
        .prioridad-media {
            background: #fff3cd;
            color: #856404;
        }
        .prioridad-baja {
            background: #d4edda;
            color: #155724;
        }
        .consulta-mensaje {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 13px;
        }
        .consulta-respuesta {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin: 10px 0;
            font-size: 13px;
        }
        .label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="club-name">Club Rotaract Fuerza Tegucigalpa Sur</div>
        <div class="document-type">Reporte de Consultas</div>
    </div>

    <div class="info-box">
        <strong>Fecha de Generación:</strong> {{ $fecha_generacion }}<br>
        <strong>Total de Consultas:</strong> {{ $total }}
    </div>

    @foreach($consultas as $index => $consulta)
    <div class="consulta-item">
        <div class="consulta-header">
            <div class="consulta-asunto">{{ $index + 1 }}. {{ $consulta->asunto }}</div>
            <div class="consulta-meta">
                <span class="estado-badge estado-{{ $consulta->estado }}">
                    {{ ucfirst($consulta->estado) }}
                </span>
                <span class="prioridad-badge prioridad-{{ $consulta->prioridad }}">
                    Prioridad: {{ ucfirst($consulta->prioridad) }}
                </span>
            </div>
            <div class="consulta-meta">
                <strong>Usuario:</strong> {{ $consulta->usuario->name }}<br>
                <strong>Fecha:</strong> {{ $consulta->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <div>
            <div class="label">Mensaje:</div>
            <div class="consulta-mensaje">
                {{ $consulta->mensaje }}
            </div>
        </div>

        @if($consulta->respuesta)
        <div style="margin-top: 15px;">
            <div class="label">Respuesta:</div>
            <div class="consulta-respuesta">
                {{ $consulta->respuesta }}
            </div>
            <div class="consulta-meta" style="margin-top: 5px;">
                <strong>Respondido por:</strong> {{ $consulta->respondedor->name ?? 'N/A' }}<br>
                <strong>Fecha de respuesta:</strong> {{ $consulta->respondido_at ? \Carbon\Carbon::parse($consulta->respondido_at)->format('d/m/Y H:i') : 'N/A' }}
            </div>
        </div>
        @endif
    </div>
    @endforeach

    <div class="footer">
        Generado el {{ $fecha_generacion }} - Club Rotaract Fuerza Tegucigalpa Sur<br>
        Documento confidencial - Uso interno
    </div>
</body>
</html>
