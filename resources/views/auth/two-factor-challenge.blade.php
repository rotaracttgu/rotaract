<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verificación 2FA - Rotaract Club Tegucigalpa Sur</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0a2540 0%, #1e3a5f 50%, #2d5a7b 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Efectos decorativos de fondo */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(232, 77, 152, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(45, 212, 191, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 25s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, 30px) scale(1.1);
            }
        }

        .verify-wrapper {
            width: 100%;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            position: relative;
            z-index: 1;
        }

        .logo-container {
            text-align: center;
            animation: fadeInDown 0.8s ease-out;
            background: linear-gradient(135deg, #e84d98 0%, #7b68ee 50%, #2dd4bf 100%);
            padding: 35px 45px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(232, 77, 152, 0.3);
            position: relative;
            overflow: hidden;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .logo-content {
            position: relative;
            z-index: 1;
        }

        .logo-container h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .logo-container p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            font-weight: 500;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .verify-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.3);
            max-width: 520px;
            width: 100%;
            padding: 40px 45px;
            animation: fadeInUp 0.8s ease-out;
            backdrop-filter: blur(10px);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-description {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.7;
        }

        .page-description-bold {
            text-align: center;
            color: #1e293b;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: #475569;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 14px;
            text-align: center;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 20px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 36px;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.5em;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #1e293b;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #e84d98;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(232, 77, 152, 0.1);
        }

        .form-group input::placeholder {
            color: #cbd5e1;
            letter-spacing: 0.3em;
        }

        .form-group input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 12px;
            display: block;
            font-weight: 500;
            text-align: center;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-verify {
            padding: 16px 40px;
            background: linear-gradient(135deg, #e84d98 0%, #7b68ee 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(232, 77, 152, 0.3);
            width: 100%;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(232, 77, 152, 0.4);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .secondary-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid #f1f5f9;
            gap: 20px;
        }

        .secondary-actions button {
            color: #64748b;
            background: none;
            border: none;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .secondary-actions button:hover {
            color: #7b68ee;
        }

        .secondary-actions form:last-child button:hover {
            color: #ef4444;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 2px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #bbf7d0;
            color: #16a34a;
        }

        /* Icono de seguridad decorativo */
        .security-icon {
            text-align: center;
            margin-bottom: 20px;
            font-size: 48px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .verify-wrapper {
                gap: 35px;
            }

            .logo-container {
                padding: 30px 40px;
            }

            .logo-container h1 {
                font-size: 28px;
            }

            .logo-container p {
                font-size: 14px;
            }

            .verify-container {
                padding: 35px 30px;
            }

            .form-group input[type="text"] {
                font-size: 32px;
                padding: 18px 16px;
            }

            .secondary-actions {
                flex-direction: column;
                gap: 12px;
            }

            .secondary-actions button {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .verify-wrapper {
                gap: 30px;
            }

            .logo-container {
                padding: 25px 30px;
                border-radius: 16px;
            }

            .logo-container h1 {
                font-size: 24px;
            }

            .logo-container p {
                font-size: 13px;
            }

            .verify-container {
                padding: 30px 24px;
                border-radius: 16px;
            }

            .form-group input[type="text"] {
                font-size: 28px;
                letter-spacing: 0.3em;
            }
        }
    </style>
</head>
<body>
    <div class="verify-wrapper">
        <!-- Logo del Club con diseño moderno -->
        <div class="logo-container">
            <div class="logo-content">
                <h1>Rotaract</h1>
                <p>Club Tegucigalpa Sur</p>
            </div>
        </div>

        <div class="verify-container">
            <!-- Icono de Seguridad -->
            <div class="security-icon">
                🔐
            </div>

            <!-- Descripción del Proceso -->
            <p class="page-description">
                Se ha enviado un código de 6 dígitos a tu correo electrónico.
            </p>
            <p class="page-description-bold">
                Por favor, ingrésalo a continuación para continuar.
            </p>

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Formulario de Verificación 2FA -->
            <form method="POST" action="{{ route('2fa.verify.post') }}">
                @csrf

                <!-- Código de verificación -->
                <div class="form-group">
                    <label for="code">Código de 6 dígitos</label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        required
                        autofocus
                        autocomplete="off"
                        class="@error('code') error @enderror"
                    >
                    @error('code')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón de Verificar -->
                <div class="form-actions">
                    <button type="submit" class="btn-verify">
                        Verificar
                    </button>
                </div>
            </form>

            <!-- Enlaces Secundarios -->
            <div class="secondary-actions">
                <!-- Reenviar código -->
                <form method="POST" action="{{ route('2fa.resend') }}">
                    @csrf
                    <button type="submit">
                        Reenviar código
                    </button>
                </form>

                <!-- Logout / Cancelar -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        Cancelar y cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>