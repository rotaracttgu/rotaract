<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diploma - Club Rotaract</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 28px;">Club Rotaract</h1>
        <p style="color: white; margin: 10px 0 0 0; font-size: 18px;">Fuerza Tegucigalpa Sur</p>
    </div>
    
    <div style="background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;">
        <h2 style="color: #764ba2; margin-top: 0;">¡Felicidades, {{ $diploma->miembro->name }}!</h2>
        
        <p style="font-size: 16px;">
            Es un honor para nosotros compartir contigo tu diploma de <strong>{{ ucfirst($diploma->tipo) }}</strong>.
        </p>
        
        <div style="background: white; padding: 20px; border-left: 4px solid #667eea; margin: 20px 0;">
            <p style="margin: 0; color: #666;"><strong>Motivo:</strong></p>
            <p style="margin: 5px 0 0 0; font-size: 15px;">{{ $diploma->motivo }}</p>
        </div>
        
        <p style="font-size: 16px;">
            Adjunto a este correo encontrarás tu diploma en formato PDF, el cual puedes descargar e imprimir.
        </p>
        
        <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; font-size: 14px; color: #666;">
                <strong>📅 Fecha de emisión:</strong> {{ $diploma->fecha_emision->format('d/m/Y') }}<br>
                <strong>👤 Emitido por:</strong> {{ $diploma->emisor->name }}
            </p>
        </div>
        
        <p style="font-size: 16px;">
            Gracias por tu dedicación y compromiso con el Club Rotaract. Tu participación es invaluable para nosotros.
        </p>
        
        <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">
        
        <p style="font-size: 14px; color: #666; text-align: center;">
            Este correo fue generado automáticamente. Por favor, no respondas a este mensaje.<br>
            Si tienes alguna pregunta, contáctanos a través de nuestros canales oficiales.
        </p>
        
        <p style="font-size: 14px; color: #999; text-align: center; margin-top: 20px;">
            <strong>Club Rotaract Fuerza Tegucigalpa Sur</strong><br>
            © {{ date('Y') }} Todos los derechos reservados
        </p>
    </div>
</body>
</html>
