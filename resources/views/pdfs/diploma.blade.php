<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diploma de {{ $diploma->tipo }}</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            width: 100%;
            height: 100vh;
        }
        .diploma-container {
            background: white;
            border: 20px solid #f4e5d3;
            border-image: repeating-linear-gradient(
                45deg,
                #c9a961,
                #c9a961 10px,
                #e6d3a8 10px,
                #e6d3a8 20px
            ) 20;
            padding: 60px;
            height: 100%;
            position: relative;
            box-shadow: 0 0 50px rgba(0,0,0,0.3);
        }
        .diploma-inner {
            border: 3px double #c9a961;
            padding: 40px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }
        .title {
            font-size: 48px;
            color: #764ba2;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 8px;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .subtitle {
            font-size: 24px;
            color: #667eea;
            font-style: italic;
            margin-bottom: 10px;
        }
        .club-name {
            font-size: 20px;
            color: #555;
            margin-top: 10px;
        }
        .content {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .text-section {
            font-size: 18px;
            color: #333;
            line-height: 2;
            margin: 20px 0;
        }
        .recipient-name {
            font-size: 42px;
            color: #764ba2;
            font-weight: bold;
            margin: 30px 0;
            padding: 20px 0;
            border-top: 2px solid #c9a961;
            border-bottom: 2px solid #c9a961;
            text-transform: uppercase;
        }
        .motivo {
            font-size: 22px;
            color: #444;
            font-style: italic;
            margin: 30px 0;
            line-height: 1.8;
        }
        .tipo-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 30px;
            border-radius: 25px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-section {
            text-align: center;
            flex: 1;
        }
        .signature-line {
            border-top: 2px solid #333;
            width: 250px;
            margin: 0 auto 10px;
            padding-top: 5px;
        }
        .signature-name {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }
        .signature-title {
            color: #666;
            font-size: 14px;
            font-style: italic;
        }
        .date-section {
            text-align: center;
            flex: 1;
        }
        .date-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .date-value {
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }
        .decorative-element {
            text-align: center;
            color: #c9a961;
            font-size: 36px;
            margin: 20px 0;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.03;
            font-size: 200px;
            font-weight: bold;
            color: #764ba2;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="diploma-container">
        <div class="watermark">ROTARACT</div>
        <div class="diploma-inner">
            <div class="header">
                <div class="logo">
                    <!-- Logo de Rotaract -->
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="95" fill="#764ba2" opacity="0.1"/>
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#764ba2" stroke-width="8"/>
                        <path d="M 100 30 L 120 70 L 165 70 L 130 100 L 145 145 L 100 115 L 55 145 L 70 100 L 35 70 L 80 70 Z" fill="#667eea"/>
                        <text x="100" y="110" text-anchor="middle" font-size="32" font-weight="bold" fill="#764ba2">R</text>
                    </svg>
                </div>
                <div class="title">DIPLOMA</div>
                <div class="subtitle">de {{ ucfirst($diploma->tipo) }}</div>
                <div class="club-name">Club Rotaract Fuerza Tegucigalpa Sur</div>
            </div>

            <div class="content">
                <div class="decorative-element">✦ ✦ ✦</div>
                
                <div class="text-section">
                    El Club Rotaract Fuerza Tegucigalpa Sur<br>
                    tiene el honor de otorgar el presente diploma a:
                </div>

                <div class="recipient-name">
                    {{ $miembro->name ?? 'Nombre del Miembro' }}
                </div>

                <div class="tipo-badge">
                    {{ strtoupper($diploma->tipo) }}
                </div>

                <div class="motivo">
                    {{ $diploma->motivo }}
                </div>

                <div class="decorative-element">✦ ✦ ✦</div>
            </div>

            <div class="footer">
                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $emisor->name ?? 'Nombre del Secretario' }}</div>
                    <div class="signature-title">Secretario(a)</div>
                </div>

                <div class="date-section">
                    <div class="date-label">Fecha de emisión:</div>
                    <div class="date-value">{{ $fecha_emision }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
