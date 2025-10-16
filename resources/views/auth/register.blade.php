<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - Rotaract Club Tegucigalpa Sur</title>
    
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

        .register-wrapper {
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

        .register-container {
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

        .form-group input[type="text"],
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

        .form-group input[type="text"]:focus,
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
            justify-content: space-between;
            align-items: center;
            margin-top: 28px;
            gap: 16px;
        }

        .login-link {
            color: #8995a3;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .login-link:hover {
            color: #b8c1cc;
        }

        .btn-register {
            padding: 12px 24px;
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
            white-space: nowrap;
        }

        .btn-register:hover {
            background: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(232, 237, 242, 0.2);
        }

        .btn-register:active {
            transform: translateY(0);
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

        /* Grid para campos en 2 columnas en pantallas grandes */
        @media (min-width: 640px) {
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .form-group.full-width {
                grid-column: 1 / -1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .register-wrapper {
                gap: 60px;
            }

            .logo-container img {
                max-width: 300px;
            }

            .register-container {
                padding: 35px 30px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-register {
                width: 100%;
                order: -1;
            }

            .login-link {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .register-wrapper {
                gap: 50px;
            }

            .logo-container img {
                max-width: 260px;
            }

            .register-container {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <!-- Logo del Club -->
        <div class="logo-container">
            <img src="{{ asset('build/images/Logo_Rotarac.webp') }}" alt="Rotaract Club Tegucigalpa Sur">
        </div>

        <div class="register-container">
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

            <!-- Formulario de Registro -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre y Email en una fila -->
                <div class="form-row">
                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            autocomplete="name"
                            class="@error('name') error @enderror"
                        >
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            autocomplete="username"
                            class="@error('email') error @enderror"
                        >
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Contraseña y Confirmar Contraseña en una fila -->
                <div class="form-row">
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Contraseña</label>
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

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
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
                </div>

                <!-- Acciones del formulario -->
                <div class="form-actions">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="login-link">
                            ¿Ya tienes una cuenta?
                        </a>
                    @endif

                    <button type="submit" class="btn-register">
                        Crear Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>