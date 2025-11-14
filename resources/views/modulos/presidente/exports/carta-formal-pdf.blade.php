<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta Formal - {{ $carta->numero_carta }}</title>
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
            border-bottom: 3px solid #6b46c1;
        }
        
        .logo {
            font-size: 24pt;
            font-weight: bold;
            color: #6b46c1;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 10pt;
            color: #666;
        }
        
        .carta-info {
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 8px;
        }
        
        .label {
            font-weight: bold;
            color: #444;
            display: inline-block;
            width: 150px;
        }
        
        .value {
            color: #666;
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
        
        .asunto {
            margin: 20px 0;
            padding: 10px;
            background-color: #f7f7f7;
            border-left: 4px solid #6b46c1;
        }
        
        .asunto-label {
            font-weight: bold;
            color: #6b46c1;
        }
        
        .contenido {
            margin: 30px 0;
            text-align: justify;
            min-height: 200px;
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
        
        .badge-enviada {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-borrador {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-recibida {
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
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Club Rotaract</div>
        <div class="subtitle">Correspondencia Oficial</div>
    </div>
    
    <div class="carta-numero">
        Carta N° {{ $carta->numero_carta }}
        <span class="badge badge-{{ strtolower($carta->estado) }}">{{ $carta->estado }}</span>
    </div>
    
    <div class="fecha">
        {{ $carta->fecha_envio ? $carta->fecha_envio->format('d \d\e F \d\e Y') : now()->format('d \d\e F \d\e Y') }}
    </div>
    
    <div class="carta-info">
        <div class="info-row">
            <span class="label">Tipo de Carta:</span>
            <span class="value">{{ $carta->tipo }}</span>
        </div>
        @if($carta->usuario)
        <div class="info-row">
            <span class="label">Remitente:</span>
            <span class="value">{{ $carta->usuario->name }} {{ $carta->usuario->apellidos ?? '' }}</span>
        </div>
        @endif
    </div>
    
    <div class="destinatario">
        <strong>Para:</strong><br>
        {{ $carta->destinatario }}
    </div>
    
    <div class="asunto">
        <span class="asunto-label">Asunto:</span> {{ $carta->asunto }}
    </div>
    
    <div class="contenido">
        {!! nl2br(e($carta->contenido)) !!}
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
