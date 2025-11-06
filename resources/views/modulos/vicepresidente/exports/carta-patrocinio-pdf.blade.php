<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Patrocinio - {{ $carta->numero_carta }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #16a34a;
        }
        
        .logo {
            font-size: 24pt;
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 10pt;
            color: #666;
        }
        
        .carta-info {
            margin-bottom: 20px;
            background-color: #f0fdf4;
            padding: 15px;
            border-radius: 5px;
        }
        
        .info-row {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }
        
        .label {
            font-weight: bold;
            color: #444;
            width: 40%;
        }
        
        .value {
            color: #666;
            width: 60%;
        }
        
        .carta-numero {
            text-align: right;
            font-size: 9pt;
            color: #999;
            margin-bottom: 15px;
        }
        
        .fecha {
            text-align: right;
            margin-bottom: 30px;
            font-size: 10pt;
        }
        
        .destinatario {
            margin-bottom: 30px;
        }
        
        .monto-box {
            background-color: #f0fdf4;
            border: 2px solid #16a34a;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border-radius: 8px;
        }
        
        .monto-label {
            font-size: 10pt;
            color: #666;
            margin-bottom: 5px;
        }
        
        .monto-valor {
            font-size: 24pt;
            font-weight: bold;
            color: #16a34a;
        }
        
        .proyecto-info {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #16a34a;
        }
        
        .proyecto-titulo {
            font-weight: bold;
            color: #16a34a;
            font-size: 12pt;
            margin-bottom: 10px;
        }
        
        .descripcion {
            margin: 20px 0;
            text-align: justify;
            min-height: 150px;
        }
        
        .descripcion-titulo {
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 10px;
        }
        
        .firma {
            margin-top: 60px;
            text-align: center;
        }
        
        .linea-firma {
            border-top: 2px solid #333;
            width: 250px;
            margin: 0 auto 10px;
        }
        
        .nombre-firma {
            font-weight: bold;
            font-size: 11pt;
        }
        
        .cargo-firma {
            font-size: 9pt;
            color: #666;
        }
        
        .pie-pagina {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
        }
        
        .badge-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-aprobada {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-rechazada {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-en-revision {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .observaciones {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            font-size: 9pt;
        }
        
        .observaciones-titulo {
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }
        
        .fechas-info {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .fecha-item {
            text-align: center;
        }
        
        .fecha-item-label {
            font-size: 9pt;
            color: #666;
        }
        
        .fecha-item-value {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Club Rotaract</div>
        <div class="subtitle">Solicitud de Patrocinio</div>
    </div>
    
    <div class="carta-numero">
        Carta N° {{ $carta->numero_carta }}
        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $carta->estado)) }}">{{ $carta->estado }}</span>
    </div>
    
    <div class="fecha">
        {{ $carta->fecha_solicitud ? $carta->fecha_solicitud->format('d \d\e F \d\e Y') : now()->format('d \d\e F \d\e Y') }}
    </div>
    
    <div class="destinatario">
        <strong>Para:</strong><br>
        {{ $carta->destinatario }}
    </div>
    
    @if($carta->proyecto)
    <div class="proyecto-info">
        <div class="proyecto-titulo">
            <i class="fas fa-project-diagram"></i> Proyecto: {{ $carta->proyecto->Nombre }}
        </div>
        @if($carta->proyecto->Descripcion)
        <div style="font-size: 9pt; color: #666;">
            {{ $carta->proyecto->Descripcion }}
        </div>
        @endif
    </div>
    @endif
    
    <div class="monto-box">
        <div class="monto-label">Monto Solicitado</div>
        <div class="monto-valor">${{ number_format($carta->monto_solicitado, 2) }}</div>
    </div>
    
    @if($carta->descripcion)
    <div class="descripcion">
        <div class="descripcion-titulo">Descripción de la Solicitud:</div>
        {!! nl2br(e($carta->descripcion)) !!}
    </div>
    @endif
    
    <div class="fechas-info">
        <div class="fecha-item">
            <div class="fecha-item-label">Fecha Solicitud</div>
            <div class="fecha-item-value">
                {{ $carta->fecha_solicitud ? $carta->fecha_solicitud->format('d/m/Y') : 'N/A' }}
            </div>
        </div>
        @if($carta->fecha_respuesta)
        <div class="fecha-item">
            <div class="fecha-item-label">Fecha Respuesta</div>
            <div class="fecha-item-value">
                {{ $carta->fecha_respuesta->format('d/m/Y') }}
            </div>
        </div>
        @endif
    </div>
    
    <div class="carta-info">
        @if($carta->usuario)
        <div class="info-row">
            <span class="label">Solicitado por:</span>
            <span class="value">{{ $carta->usuario->name }} {{ $carta->usuario->apellidos ?? '' }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Estado:</span>
            <span class="value">{{ $carta->estado }}</span>
        </div>
    </div>
    
    @if($carta->observaciones)
    <div class="observaciones">
        <div class="observaciones-titulo">Observaciones:</div>
        <div>{{ $carta->observaciones }}</div>
    </div>
    @endif
    
    <div class="firma">
        <div class="linea-firma"></div>
        <div class="nombre-firma">
            @if($carta->usuario)
                {{ $carta->usuario->name }} {{ $carta->usuario->apellidos ?? '' }}
            @else
                Club Rotaract
            @endif
        </div>
        <div class="cargo-firma">
            @if($carta->usuario && $carta->usuario->getRoleNames()->first())
                {{ $carta->usuario->getRoleNames()->first() }}
            @else
                Vicepresidente
            @endif
        </div>
    </div>
    
    <div class="pie-pagina">
        Documento generado el {{ now()->format('d/m/Y H:i') }} | Club Rotaract
    </div>
</body>
</html>
