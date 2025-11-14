<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta - {{ $acta->titulo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            padding: 40px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-section {
            margin-bottom: 20px;
        }
        .club-name {
            font-size: 24px;
            font-weight: bold;
            color: #764ba2;
            margin-bottom: 10px;
        }
        .document-type {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            text-transform: uppercase;
            margin: 15px 0;
        }
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #667eea;
            margin-bottom: 30px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 180px;
            color: #555;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .tipo-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content-section {
            margin: 30px 0;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #764ba2;
            margin-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 5px;
        }
        .content-text {
            text-align: justify;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .asistentes-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
        .signature-section {
            margin-top: 60px;
            text-align: center;
        }
        .signature-line {
            border-top: 2px solid #333;
            width: 300px;
            margin: 0 auto 10px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 14px;
        }
        .signature-title {
            color: #666;
            font-size: 12px;
            font-style: italic;
        }
        .page-number {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-section">
            <svg width="80" height="80" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;">
                <circle cx="100" cy="100" r="95" fill="#764ba2" opacity="0.1"/>
                <circle cx="100" cy="100" r="80" fill="none" stroke="#764ba2" stroke-width="8"/>
                <path d="M 100 30 L 120 70 L 165 70 L 130 100 L 145 145 L 100 115 L 55 145 L 70 100 L 35 70 L 80 70 Z" fill="#667eea"/>
                <text x="100" y="110" text-anchor="middle" font-size="32" font-weight="bold" fill="#764ba2">R</text>
            </svg>
        </div>
        <div class="club-name">Club Rotaract Fuerza Tegucigalpa Sur</div>
        <div class="document-type">ACTA DE REUNIÓN</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Título:</div>
            <div class="info-value"><strong>{{ $acta->titulo }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Tipo de Reunión:</div>
            <div class="info-value">
                <span class="tipo-badge">{{ ucfirst($acta->tipo_reunion) }}</span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha de Reunión:</div>
            <div class="info-value">{{ $fecha }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Elaborada por:</div>
            <div class="info-value">{{ $creador->name ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="content-section">
        <div class="section-title">Contenido</div>
        <div class="content-text">
            {!! nl2br(e($acta->contenido)) !!}
        </div>
    </div>

    @if($acta->asistentes)
    <div class="asistentes-section">
        <div class="section-title">Asistentes</div>
        <div class="content-text">
            {!! nl2br(e($acta->asistentes)) !!}
        </div>
    </div>
    @endif

    <div class="footer">
        <div class="signature-section">
            <div class="signature-line"></div>
            <div class="signature-name">{{ $creador->name ?? 'Secretario(a)' }}</div>
            <div class="signature-title">Secretario(a) del Club</div>
        </div>

        <div class="page-number">
            Generado el {{ now()->format('d/m/Y H:i') }} - Club Rotaract Fuerza Tegucigalpa Sur
        </div>
    </div>
</body>
</html>
