<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Rotaract Club Tegucigalpa Sur</title>
    
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

        .login-wrapper {
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 80px;
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

        .login-container {
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

        .form-group input[type="email"]::placeholder,
        .form-group input[type="password"]::placeholder {
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            margin-top: -4px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #a8b4c0;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #6b7785;
        }

        .forgot-password {
            color: #8995a3;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: #b8c1cc;
        }

        .btn-login {
            width: 100%;
            max-width: 120px;
            padding: 12px 20px;
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
            float: right;
        }

        .btn-login:hover {
            background: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(232, 237, 242, 0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            clear: both;
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(168, 180, 192, 0.15);
            color: #8995a3;
            font-size: 13px;
        }

        .register-link a {
            color: #b8c1cc;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
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
            .login-wrapper {
                gap: 60px;
            }

            .logo-container img {
                max-width: 300px;
            }

            .login-container {
                padding: 35px 30px;
            }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                gap: 50px;
            }

            .logo-container img {
                max-width: 260px;
            }

            .login-container {
                padding: 30px 24px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .btn-login {
                width: 100%;
                max-width: 100%;
                float: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Logo del Club -->
        <div class="logo-container">
            <img src="{{ asset('build/images/LogoRotaract.png') }}" alt="Rotaract Club Tegucigalpa Sur">
        </div>

        <div class="login-container">
            <!-- Mensajes de error -->
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Mensaje de sesión (si existe) -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="@error('email') error @enderror"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="@error('password') error @enderror"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Mantener sesion iniciada</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="btn-login">
                    LOG IN
                </button>

                <!-- Link de Registro (opcional) -->
                @if (Route::has('register'))
                    <div class="register-link">
                        Aun no estas registrado? <a href="{{ route('register') }}">Crea una cuenta aqui</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</body>
</html>