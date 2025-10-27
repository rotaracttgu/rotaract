<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restablecer Contraseña - Rotaract Club Tegucigalpa Sur</title>
    
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

        .reset-wrapper {
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

        .reset-container {
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

        .page-title {
            text-align: center;
            background: linear-gradient(135deg, #e84d98, #7b68ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .page-description {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: #475569;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #1e293b;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            border-color: #e84d98;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(232, 77, 152, 0.1);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .form-group input.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
            display: block;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-reset {
            padding: 14px 40px;
            background: linear-gradient(135deg, #e84d98 0%, #7b68ee 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(232, 77, 152, 0.3);
            width: 100%;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(232, 77, 152, 0.4);
        }

        .btn-reset:active {
            transform: translateY(0);
        }

        .back-to-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid #f1f5f9;
        }

        .back-to-login a {
            color: #7b68ee;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-to-login a:hover {
            color: #e84d98;
            transform: translateX(-3px);
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert strong {
            display: block;
            margin-bottom: 8px;
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

        /* Responsive */
        @media (max-width: 768px) {
            .reset-wrapper {
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

            .reset-container {
                padding: 35px 30px;
            }

            .page-title {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .reset-wrapper {
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

            .reset-container {
                padding: 30px 24px;
                border-radius: 16px;
            }

            .page-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-wrapper">
        <!-- Logo del Club con diseño moderno -->
        <div class="logo-container">
            <div class="logo-content">
                <h1>Rotaract</h1>
                <p>Club Tegucigalpa Sur</p>
            </div>
        </div>

        <div class="reset-container">
            <!-- Título y descripción -->
            <h2 class="page-title">Restablecer Contraseña</h2>
            <p class="page-description">
                Ingresa tu email y tu nueva contraseña para restablecer el acceso a tu cuenta.
            </p>

            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    @foreach ($errors->all() as $error)
                        • {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Mensaje de sesión (si existe) -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario de Reset Password -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token (oculto) -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
                        required 
                        autofocus
                        autocomplete="username"
                        class="@error('email') error @enderror"
                        placeholder="tu@email.com"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nueva Contraseña -->
                <div class="form-group">
                    <label for="password">Nueva Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        autocomplete="new-password"
                        class="@error('password') error @enderror"
                        placeholder="Mínimo 8 caracteres"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        autocomplete="new-password"
                        class="@error('password_confirmation') error @enderror"
                        placeholder="Confirma tu contraseña"
                    >
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón de Reset -->
                <div class="form-actions">
                    <button type="submit" class="btn-reset">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>

            <!-- Volver al Login -->
            <div class="back-to-login">
                <a href="{{ route('login') }}">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>
</body>
</html>