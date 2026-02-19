<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de Vencimiento de Contraseña</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.10); }
        .header { background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 100%); padding: 40px 32px; text-align: center; }
        .header img { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 24px; margin: 0; font-weight: 700; }
        .header p { color: #bfdbfe; font-size: 14px; margin: 8px 0 0; }
        .badge { display: inline-block; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; border-radius: 999px; padding: 4px 16px; font-size: 13px; margin-top: 12px; }
        .body { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 16px; }
        .alert-box { border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; }
        .alert-warning { background: #fef9c3; border-left: 4px solid #facc15; }
        .alert-danger  { background: #fee2e2; border-left: 4px solid #ef4444; }
        .alert-box .icon { font-size: 28px; margin-bottom: 8px; }
        .alert-box h2 { font-size: 18px; margin: 0 0 6px; color: #1e293b; }
        .alert-box p  { margin: 0; color: #475569; font-size: 14px; line-height: 1.6; }
        .days-badge { display: inline-block; font-size: 28px; font-weight: 800; color: #1d4ed8; background: #eff6ff; border-radius: 12px; padding: 8px 24px; margin: 16px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #2563eb, #4f46e5); color: #ffffff !important; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 15px; margin: 8px 0; }
        .info-list { background: #f8fafc; border-radius: 10px; padding: 20px 24px; margin: 20px 0; }
        .info-list h3 { font-size: 14px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 12px; }
        .info-list ul { margin: 0; padding: 0; list-style: none; }
        .info-list li { padding: 4px 0; font-size: 14px; color: #334155; }
        .info-list li::before { content: '•'; color: #2563eb; margin-right: 8px; }
        .footer { background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; margin: 4px 0; }
        .footer a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        <h1>🔐 Rotaract Fuerza Tegucigalda Sur</h1>
        <p>Sistema de Gestión</p>
        <span class="badge">📢 Aviso de Seguridad</span>
    </div>

    {{-- BODY --}}
    <div class="body">
        <p class="greeting">Hola, <strong>{{ $usuario->name }} {{ $usuario->apellidos }}</strong></p>

        @if($diasRestantes <= 0)
        {{-- Contraseña ya vencida --}}
        <div class="alert-box alert-danger">
            <div class="icon">🔴</div>
            <h2>¡Tu contraseña ha vencido!</h2>
            <p>Tu contraseña de acceso al sistema <strong>ha caducado</strong>. Debes renovarla inmediatamente para poder continuar usando el sistema.</p>
        </div>
        @else
        {{-- Por vencer --}}
        <div class="alert-box alert-warning">
            <div class="icon">⚠️</div>
            <h2>Tu contraseña vence pronto</h2>
            <p>Tu contraseña de acceso vencerá en:</p>
            <div class="days-badge">{{ $diasRestantes }} día(s)</div>
            <p>Te recomendamos renovarla ahora para evitar interrupciones en tu acceso.</p>
        </div>
        @endif

        <div style="text-align: center; margin: 28px 0;">
            <a href="{{ route('contrasena.renovar.form') }}" class="btn">
                🔑 Renovar mi Contraseña
            </a>
        </div>

        <div class="info-list">
            <h3>ℹ️ Información importante</h3>
            <ul>
                <li>Accede al sistema con tu usuario y contraseña actuales.</li>
                <li>Se te redirigirá automáticamente para cambiar la contraseña.</li>
                <li>La nueva contraseña debe tener al menos 8 caracteres, una mayúscula y un número.</li>
                @if($diasRestantes > 0)
                <li>Tu contraseña vence el: <strong>{{ $usuario->password_expires_at?->format('d/m/Y') }}</strong></li>
                @endif
            </ul>
        </div>

        <p style="font-size: 13px; color: #64748b; line-height: 1.6;">
            Si ya renovaste tu contraseña, puedes ignorar este mensaje. Si no realizaste ninguna acción,
            por favor contacta al administrador del sistema.
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Este correo fue enviado automáticamente por el sistema de gestión Rotaract.</p>
        <p>© {{ date('Y') }} Rotaract Fuerza Tegucigalpa Sur. Todos los derechos reservados.</p>
    </div>
</div>
</body>
</html>
