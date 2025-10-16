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
            background: #1a2332;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .reset-wrapper {
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 80px;
            padding: 40px 0;
        }

        .logo-container {
            text-align: center;
            animation: fadeInDown 0.8s ease-out;
        }

        .logo-container img {
            max-width: 380px;
            width: 100%;
            height: auto;
            filter: brightness(1.1);
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
            background: #2a3544;
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
            max-width: 700px;
            width: 100%;
            padding: 45px 50px 40px;
            animation: fadeInUp 0.8s ease-out;
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
            color: #e8edf2;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .page-description {
            text-align: center;
            color: #8995a3;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            color: #a8b4c0;
            font-weight: 400;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #e8edf2;
            color: #1a2332;
        }

        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            outline: none;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(232, 237, 242, 0.1);
        }

        .form-group input::placeholder {
            color: #8995a3;
        }

        .form-group input.error {
            border: 2px solid #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 28px;
        }

        .btn-reset {
            padding: 12px 28px;
            background: #e8edf2;
            color: #2a3544;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-reset:hover {
            background: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(232, 237, 242, 0.2);
        }

        .btn-reset:active {
            transform: translateY(0);
        }

        .back-to-login {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(168, 180, 192, 0.15);
        }

        .back-to-login a {
            color: #8995a3;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .back-to-login a:hover {
            color: #b8c1cc;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.12);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #ff6b6b;
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.12);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #51cf66;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .reset-wrapper {
                gap: 60px;
            }

            .logo-container img {
                max-width: 300px;
            }

            .reset-container {
                padding: 35px 30px;
            }

            .page-title {
                font-size: 20px;
            }

            .form-actions {
                justify-content: stretch;
            }

            .btn-reset {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .reset-wrapper {
                gap: 50px;
            }

            .logo-container img {
                max-width: 260px;
            }

            .reset-container {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-wrapper">
        <!-- Logo del Club -->
        <div class="logo-container">
            <img src="{{ asset('build/images/Logo_Rotarac.webp') }}" alt="Rotaract Club Tegucigalpa Sur">
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
                    <strong>Por favor corrige los siguientes errores:</strong><br>
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
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
                        required 
                        autofocus
                        autocomplete="username"
                        class="@error('email') error @enderror"
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